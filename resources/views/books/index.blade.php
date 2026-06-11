    @extends('layout')

@section('content')
<div class="container-fluid" style="background-color: #f8fafc; min-height: 100vh;">
    <div class="row pt-4 px-3">
        
        <!-- Sidebar Menu -->
        @include('layouts.navigation')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </ul>
                </div>
            @endif 

            @can('admin')
                <!-- ADMIN VIEW (Table Format) -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom mt-2">
                    <h1 class="h2 fw-bold">{{ __('message.Menu2.Manage Collections') }}</h1>
                    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="offcanvas" data-bs-target="#addBookOffcanvas" aria-controls="addBookOffcanvas">{{ __('message.Menu2.Add New Book') }}</button>
                    @include('books.partials.create')
                </div>
                
                <form method="GET" action="{{ route('books.index') }}" class="row g-2 mb-4 mt-2">
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control rounded-pill px-4" placeholder="{{ __('message.Menu2.Search Book Title, Author, or ISBN') }}" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2"><button type="submit" class="btn btn-primary w-100 rounded-pill">{{ __('message.Menu2.Search') }}</button></div>
                    <div class="col-md-2"><a href="{{ route('books.index') }}" class="btn btn-outline-secondary w-100 rounded-pill">{{ __('message.Menu2.Clear') }}</a></div>
                </form>

                <div class="bg-white rounded-4 shadow-sm p-3 table-responsive">
                    <table class="table align-middle border-light">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('message.Menu2.Cover') }}</th>
                                <th>{{ __('message.Menu2.Title') }}</th>
                                <th>{{ __('message.Menu2.Author') }}</th>
                                <th>{{ __('message.Menu2.ISBN') }}</th>
                                <th>{{ __('message.Menu2.Stock') }}</th>
                                <th>{{ __('message.Menu2.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($books as $book)
                                <tr>
                                    <td>
                                        @if($book->book_cover)
                                            <img src="{{ asset('storage/' . $book->book_cover) }}" alt="Cover" class="rounded" style="width: 40px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 60px;"><span class="small text-muted">No</span></div>
                                        @endif
                                    </td>
                                    <td class="fw-bold">{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td class="text-muted">{{ $book->isbn }}</td>
                                    <td>
                                        @if($book->quantity > 0) <span class="badge bg-success">{{ $book->quantity }} {{ __('message.Menu2.Available') }}</span>
                                        @else <span class="badge bg-danger">{{ __('message.Menu2.Out of Stock') }}</span> @endif
                                    </td>
                                    <td>
                                        <!--<a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning">Edit</a> -->
                                        <button class="btn btn-sm btn-warning shadow-none" data-bs-toggle="offcanvas" data-bs-target="#editBookOffcanvas{{ $book->id }}" aria-controls="editBookOffcanvas{{ $book->id }}">{{ __('message.Menu2.Edit') }}</button>
                                        @include('books.partials.edit', ['book' => $book])
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBookModal{{ $book->id }}">{{ __('message.Menu2.Delete') }}</button>
                                            <div class="modal fade" id="deleteBookModal{{ $book->id }}" tabindex="-1" aria-labelledby="deleteBookModalLabel{{ $book->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="deleteBookModalLabel{{ $book->id }}">{{ __('message.Menu2.Delete Book') }}</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('message.Menu2.Delete Confirmation') }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('message.Menu2.Close') }}</button>
                                                            <button type="submit" class="btn btn-danger">{{ __('message.Menu2.Delete') }}</button>
                                                        </div>
                                                        </div>
                                                    </div>      
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">{{ __('message.Menu2.No books found') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination for Admin -->
                @if($books->hasPages())
                    <div class="mt-4 d-flex justify-content-end">
                        {{ $books->links() }}
                    </div>
                @endif

            @else
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">{{ __('Dashboard') }}</span>
                    <h2 class="fw-bold mb-1" style="color: #111827;">{{ __('Book Collections') }}</h2>
                    <p class="text-muted small mb-0">{{ __('Choose any book to rent') }}</p>
                </div>
                <form method="GET" action="{{ route('books.index') }}" class="row g-2 mb-4 mt-2">
                        <div class="col-md-8">
                            <input type="text" name="search" class="form-control rounded-pill px-4" placeholder="{{ __('Search Book title, Author, or ISBN') }}" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2"><button type="submit" class="btn btn-primary w-100 rounded-pill">{{ __('Search') }}</button></div>
                        <div class="col-md-2"><a href="{{ route('books.index') }}" class="btn btn-outline-secondary w-100 rounded-pill">{{ __('Clear') }}</a></div>
                    </form>
                
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @forelse ($books as $book)
                        <div class="col">
                            <div class="card custom-card bg-white h-100 p-2">
                                
                                @if($book->book_cover)
                                    <img src="{{ asset('storage/' . $book->book_cover) }}" class="card-img-top rounded-4" alt="Cover" style="height: 250px; object-fit: cover;">
                                @else
                                    <div class="card-img-top rounded-4 d-flex align-items-center justify-content-center text-muted" style="height: 250px; background-color: #f1f5f9;">
                                        <span class="small fw-bold text-uppercase" style="letter-spacing: 2px; color: #cbd5e1;">Book Cover</span>
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex justify-content-between align-items-start px-3 py-3 gap-2">
                                    <div class="overflow-hidden">
                                        <h5 class="fw-bold mb-1 text-truncate" style="max-width: 180px;">{{ $book->title }}</h5>
                                        <p class="text-muted small mb-0">{{ $book->author }}</p>
                                    </div>
                                    @if($book->quantity > 0) 
                                        <span class="badge-approved">{{ __('message.Menu2.Available') }}</span>
                                    @else 
                                        <span class="badge-rejected">{{ __('message.Menu2.Out of Stock') }}</span> 
                                    @endif
                                </div>
                                
                                <div class="overflow-auto figma-card-footer mt-auto d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="d-block text-muted" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 1px;">ISBN</span>
                                        <span class="fw-bold text-truncate" style="font-size: 0.85rem; color: #1f2937;">{{ $book->isbn }}</span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-muted" data-bs-toggle="modal" data-bs-target="#bookModal{{ $book->id }}" style="font-size: 0.85rem;">
                                            {{ __('message.Menu2.Details') }}
                                        </button>

                                        @if($book->quantity > 0)
                                            <form action="{{ route('rentals.store', $book->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-sm rounded-pill px-3 fw-bold" style="background-color: #eff6ff; color: #3b82f6; border: none; font-size: 0.85rem;">{{ __('message.Menu2.Rent') }}</button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary text-truncate btn-sm rounded-pill px-3 fw-bold" style="font-size: 0.85rem;" disabled>{{ __('message.Menu2.Unavailable') }}</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                                <div class="modal fade" id="bookModal{{ $book->id }}" tabindex="-1" aria-labelledby="bookModalLabel{{ $book->id }}">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 rounded-4 shadow">
                                            <div class="modal-header border-0 pb-0">
                                                <h5 class="modal-title fw-bold" id="bookModalLabel{{ $book->id }}">{{ $book->title }}</h5>
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body pt-2">
                                                <p class="text-muted small mb-3">{{ __('By') }} {{ $book->author }} &bull; ISBN: {{ $book->isbn }}</p>
                                                
                                                <div class="mb-3">
                                                    <h6 class="fw-bold" style="font-size: 0.85rem;">{{ __('message.Menu2.Description') }}</h6>
                                                    <p class="text-muted" style="font-size: 0.9rem; white-space: pre-wrap;">{{ $book->description ?? __('message.Menu2.no description') }}</p>
                                                </div>
                                                
                                                <div class="d-flex justify-content-between align-items-center mt-4 p-3 rounded-3" style="background-color: #f8fafc;">
                                                    <div>
                                                        <span class="d-block text-muted" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 1px;">{{ __('message.Menu2.availability') }}</span>
                                                        @if($book->quantity > 0)
                                                            <span class="fw-bold text-success">{{ $book->quantity }} {{ __('message.Menu2.in stock') }}</span>
                                                        @else
                                                            <span class="fw-bold text-danger">{{ __('message.Menu2.Out of Stock') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-light border-0 rounded-4 text-center py-5 shadow-sm">
                                <p class="text-muted mb-0 fw-bold">{{ __('message.Menu2.No books found') }}</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination for Students -->
                @if($books->hasPages())
                    <div class="mt-4 d-flex justify-content-end">
                        {{ $books->links() }}
                    </div>
                @endif
            @endcan
        </main>
    </div>
</div>
@endsection