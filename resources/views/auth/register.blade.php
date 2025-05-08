<x-guest-layout>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-brown-50 to-brown-100 dark:from-brown-900 dark:to-brown-800">
    <div class="max-w-md w-full bg-white dark:bg-brown-700 rounded-2xl shadow-xl p-8 space-y-6">
      <h2 class="text-2xl font-bold text-brown-800 dark:text-brown-100 text-center">
        Create Your Account
      </h2>

      <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
          <label for="name" class="block text-sm font-medium text-brown-700 dark:text-brown-200">Name</label>
          <input id="name" name="name" type="text" required autofocus
            class="mt-1 block w-full px-4 py-2 bg-brown-50 dark:bg-brown-600 border border-brown-200 dark:border-brown-500 rounded-lg focus:ring-2 focus:ring-brown-400 focus:outline-none transition" 
            value="{{ old('name') }}">
          <x-input-error :messages="$errors->get('name')" class="mt-1 text-sm text-red-600" />
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-brown-700 dark:text-brown-200">Email</label>
          <input id="email" name="email" type="email" required
            class="mt-1 block w-full px-4 py-2 bg-brown-50 dark:bg-brown-600 border border-brown-200 dark:border-brown-500 rounded-lg focus:ring-2 focus:ring-brown-400 focus:outline-none transition"
            value="{{ old('email') }}">
          <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-brown-700 dark:text-brown-200">Password</label>
          <input id="password" name="password" type="password" required autocomplete="new-password"
            class="mt-1 block w-full px-4 py-2 bg-brown-50 dark:bg-brown-600 border border-brown-200 dark:border-brown-500 rounded-lg focus:ring-2 focus:ring-brown-400 focus:outline-none transition">
          <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-brown-700 dark:text-brown-200">Confirm Password</label>
          <input id="password_confirmation" name="password_confirmation" type="password" required
            class="mt-1 block w-full px-4 py-2 bg-brown-50 dark:bg-brown-600 border border-brown-200 dark:border-brown-500 rounded-lg focus:ring-2 focus:ring-brown-400 focus:outline-none transition">
          <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-red-600" />
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
          <a href="{{ route('login') }}"
             class="text-sm text-brown-600 dark:text-brown-300 hover:text-brown-800 dark:hover:text-brown-100 transition">
            Already registered?
          </a>
          <button type="submit"
                  class="px-6 py-2 bg-brown-600 dark:bg-brown-500 text-white rounded-lg font-semibold hover:bg-brown-700 dark:hover:bg-brown-400 transition">
            Register
          </button>
        </div>
      </form>
    </div>
  </div>
</x-guest-layout>
