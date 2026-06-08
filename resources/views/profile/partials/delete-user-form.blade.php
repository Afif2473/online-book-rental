<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>
<!--
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
-->
    <form action="{{ route('profile.destroy', $user->id) }}" method="POST" class="d-inline">
        @csrf @method('DELETE')
        <button type="button" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion{{ $user->id }}" class="btn btn-danger w-10 rounded-pill py-2 fw-bold">{{ __('Delete Account') }}</button>
        <div class="modal fade" id="confirm-user-deletion{{ $user->id }}" tabindex="-1" aria-labelledby="confirmUserDeletionLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="confirmUserDeletionLabel{{ $user->id }}">Delete Account</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete "<strong>{{ $user->name }}</strong>"?
                        <p class="text-muted small mb-4">Please enter your password to confirm you would like to permanently delete your account.</p>

                        <!-- Password Input -->
                        <div class="mb-3">
                            <input type="password" 
                                   class="form-control figma-input @error('password', 'userDeletion') is-invalid @enderror" 
                                   id="password-{{ $user->id }}" 
                                   name="password" 
                                   placeholder="Password" 
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>      
            </div>
        </div>
    </form>
</section>