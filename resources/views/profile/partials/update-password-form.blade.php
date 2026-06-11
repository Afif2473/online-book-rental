<section>
    @if (session('password_updated'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">{{ session('password_updated') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('message.Menu4.Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('message.Menu4.Update pass message') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('message.Menu4.Current Password')" />
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 form-control figma-input w-50" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-danger" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('message.Menu4.New Password')" />
            <input id="update_password_password" name="password" type="password" class="mt-1 form-control figma-input w-50" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('message.Menu4.Confirm Password')" />
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 form-control figma-input w-50" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger" />
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center gap-4">
            <button type="submit" class=" mt-3 btn btn-primary w-10 rounded-pill py-2 fw-bold">{{ __('message.Menu4.Save') }}</button>
        </div>
        </div>
    </form>
</section>
