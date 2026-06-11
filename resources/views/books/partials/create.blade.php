<div class="offcanvas offcanvas-end w-75 border-0 shadow" tabindex="-1" id="addBookOffcanvas" aria-labelledby="addBookOffcanvas" style="width: 400px; border-top-left-radius: 1.5rem; border-bottom-left-radius: 1.5rem;">
    
    <div class="offcanvas-header px-4 pt-4 pb-2">
        <h5 class="offcanvas-title fw-bold" id="addBookOffcanvas">{{ __('Add New Book') }}</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    
    <div class="offcanvas-body px-4 pb-4">
        <!-- Ensure enctype is set for file uploads -->
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column h-100">
            @csrf
            
            <div class="mb-3">
                <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">{{ __('BOOK TITLE') }}</label>
                <input type="text" name="title" class="form-control border-0 rounded-3 px-3 py-2" style="background-color: #f1f5f9;" placeholder="e.g. The Great Gatsby" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">{{ __('AUTHOR') }}</label>
                <input type="text" name="author" class="form-control border-0 rounded-3 px-3 py-2" style="background-color: #f1f5f9;" placeholder="e.g. F. Scott Fitzgerald" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">{{ __('ISBN') }}</label>
                <input type="text" name="isbn" class="form-control border-0 rounded-3 px-3 py-2 @error('isbn') is-invalid @enderror" style="background-color: #f1f5f9;" placeholder="e.g. 978-0743273565" required>
            </div>  

            <div class="mb-4">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">{{ __('QUANTITY') }}</label>
                        <input type="number" name="quantity" class="form-control border-0 rounded-3 px-3 py-2" style="background-color: #f1f5f9;" min="0" value="1" required>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">{{ __('BOOK COVER IMAGE') }}</label>
                <div class="position-relative overflow-hidden" style="max-width: 300px;">
                    <div class="btn btn-primary rounded-pill px-4 text-center">
                        {{ __('Upload File') }}
                    </div>
                    <input type="file" name="attachment" class="position-absolute top-0 start-0 opacity-0 w-100 h-100" style="cursor: pointer;">
                </div>
                <div class="form-text small mt-2">{{ __('Accepted formats: JPG, PNG. Max size: 2MB.') }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">{{ __('DESCRIPTION') }}</label>
                <textarea name="description" class="form-control border-0 rounded-3" rows="5" style="background-color: #f1f5f9;" placeholder="{{ __('Synopsis of the book') }}" required></textarea>
            </div>

            <div class="mt-auto pt-4 border-top">
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">{{ __('Save') }}</button>
                <button type="button" class="btn btn-light w-100 rounded-pill py-2 mt-2 fw-bold text-muted" data-bs-dismiss="offcanvas">{{ __('Cancel') }}</button>
            </div>
        </form>
    </div>
</div>