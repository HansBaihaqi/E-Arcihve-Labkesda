<x-guest-layout>
    <h2 class="text-xl font-semibold text-gray-900 mb-1">Lupa Password</h2>
    <p class="text-sm text-gray-500 mb-6">Masukkan email Anda dan kami akan mengirimkan link reset password.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-input @error('email') border-red-500 @enderror" value="{{ old('email') }}" required autofocus>
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn-primary w-full justify-center">Kirim Link Reset</button>
        <a href="{{ route('login') }}" class="block text-center text-sm text-indigo-600 hover:text-indigo-700 font-medium">Kembali ke login</a>
    </form>
</x-guest-layout>
