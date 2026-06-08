<div class="offcanvas offcanvas-end w-75 border-0 shadow" tabindex="-1" id="editBookOffcanvas{{ $book->id }}" style="width: 400px; border-top-left-radius: 1.5rem; border-bottom-left-radius: 1.5rem;">
    
    <div class="offcanvas-header px-4 pt-4 pb-2">
        <h5 class="offcanvas-title fw-bold">Edit Book {{ $book->title }}</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    
    <div class="offcanvas-body px-4 pb-4">
        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column h-100">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">BOOK TITLE</label>
                <!-- Pre-fill using value attribute -->
                <input type="text" name="title" class="form-control border-0 rounded-3 px-3 py-2" style="background-color: #f1f5f9;" value="{{ $book->title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">AUTHOR</label>
                <input type="text" name="author" class="form-control border-0 rounded-3 px-3 py-2" style="background-color: #f1f5f9;" value="{{ $book->author }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">ISBN</label>
                <input type="text" name="isbn" class="form-control border-0 rounded-3 px-3 py-2" style="background-color: #f1f5f9;" value="{{ $book->isbn }}" required>
            </div>

            <div class="mb-4">
                <div class="col-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">QUANTITY</label>
                    <input type="number" name="quantity" class="form-control border-0 rounded-3 px-3 py-2" style="background-color: #f1f5f9;" min="0" value="{{ $book->quantity }}" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">UPDATE COVER IMAGE</label>
                <input type="file" name="book_cover" class="form-control border-0 rounded-3 px-3 py-2" style="background-color: #f1f5f9;" accept="image/*">
                <div class="form-text small mt-2">Leave blank to keep current cover.</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">DESCRIPTION</label>
                <!-- Textarea values go between the tags, not in a value="" attribute -->
                <textarea name="description" class="form-control border-0 rounded-3" rows="5" style="background-color: #f1f5f9;" required>{{ $book->description }}</textarea>
            </div>

            <div class="mt-auto pt-4 border-top">
                <button type="submit" class="btn btn-warning w-100 rounded-pill py-2 fw-bold text-dark">Update Book</button>
                <button type="button" class="btn btn-light w-100 rounded-pill py-2 mt-2 fw-bold text-muted" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>