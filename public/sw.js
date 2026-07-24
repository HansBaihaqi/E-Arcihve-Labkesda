const CACHE_NAME = 'e-archive-v2';
const scope = self.registration.scope;
const base = new URL(scope).pathname;

const OFFLINE_URL = `${base}offline.html`;
const MANIFEST_URL = `${base}manifest.json`;
const ICON_192 = `${base}icon-192.png`;
const ICON_512 = `${base}icon-512.png`;

const ASSETS = [
    MANIFEST_URL,
    ICON_192,
    ICON_512,
    OFFLINE_URL,
];

// Install Event
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            console.log('Caching initial assets');
            return cache.addAll(ASSETS).catch(err => console.log('Asset caching failed on install:', err));
        })
    );
    self.skipWaiting();
});

// Activate Event
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))
            );
        })
    );
    self.clients.claim();
});

// Fetch Event
self.addEventListener('fetch', event => {
    // Only handle GET requests
    if (event.request.method !== 'GET') return;

    // Only handle requests to our own origin
    if (!event.request.url.startsWith(self.location.origin)) return;

    const acceptHeader = event.request.headers.get('accept');
    const isHtmlRequest = event.request.mode === 'navigate' || (acceptHeader && acceptHeader.includes('text/html'));

    if (isHtmlRequest) {
        // Network-First, fallback to Offline Page for HTML navigations
        event.respondWith(
            fetch(event.request)
                .catch(() => {
                    // Return the cached offline page when network fails
                    return caches.match(OFFLINE_URL);
                })
        );
    } else {
        // Cache-First, fallback to Network for static assets
        event.respondWith(
            caches.match(event.request).then(cachedResponse => {
                if (cachedResponse) {
                    return cachedResponse;
                }
                return fetch(event.request).then(networkResponse => {
                    // Dynamically cache other static assets of our origin (like CSS, JS, images) if fetched successfully
                    if (networkResponse && networkResponse.status === 200 && networkResponse.type === 'basic') {
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME).then(cache => {
                            cache.put(event.request, responseClone);
                        });
                    }
                    return networkResponse;
                }).catch(() => {
                    // Fail silently for non-HTML assets when offline
                });
            })
        );
    }
});
