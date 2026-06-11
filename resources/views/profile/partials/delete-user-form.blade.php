<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('message.Menu4.Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('message.Menu4.Delete Account Message') }}
        </p>
    </header>
<!--
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
-->
    <form action="{{ route('profile.destroy', $user->id) }}" method="POST" class="d-inline">
        @csrf @method('DELETE')
        <button type="button" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion{{ $user->id }}" class="btn btn-danger w-10 rounded-pill py-2 fw-bold">{{ __('message.Menu4.Delete Account') }}</button>
        <div class="modal fade" id="confirm-user-deletion{{ $user->id }}" tabindex="-1" aria-labelledby="confirmUserDeletionLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="confirmUserDeletionLabel{{ $user->id }}">{{ __('message.Menu4.Delete Account') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('message.Menu4.delete confirmation') }} "<strong>{{ $user->name }}</strong>"?
                        <p class="text-muted small mb-4">{{ __('message.Menu4.enter password') }}</p>

                        <!-- Password Input -->
                        <div class="mb-3">
                            <input type="password" 
                                   class="form-control figma-input @error('password', 'userDeletion') is-invalid @enderror" 
                                   id="password-{{ $user->id }}" 
                                   name="password" 
                                   placeholder="{{ __('message.Menu4.Password') }}" 
                                   required>
                            
                            <!-- Display Validation Errors -->
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('message.Menu4.Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('message.Menu4.Delete') }}</button>
                    </div>
                </div>      
            </div>
        </div>
    </form>
</section>