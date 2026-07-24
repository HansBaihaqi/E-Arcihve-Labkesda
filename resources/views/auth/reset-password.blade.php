<x-guest-layout>
    <h2 class="text-xl font-semibold text-gray-900 mb-1">Reset Password</h2>
    <p class="text-sm text-gray-500 mb-6">Masukkan password baru untuk akun Anda.</p>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" class="form-input @error('email') border-red-500 @enderror" value="{{ old('email', $request->email) }}" required autofocus>
            @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="form-label">Password Baru</label>
            <input id="password" type="password" name="password" class="form-input @error('password') border-red-500 @enderror" required>
            @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" required>
        </div>

        <button type="submit" class="btn-primary w-full justify-center">Reset Password</button>
    </form>
</x-guest-layout>
