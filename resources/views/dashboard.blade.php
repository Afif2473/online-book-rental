@extends('layout')

@section('content')
<div class="container-fluid" style="background-color: #f8fafc; min-height: 100vh;">
    <div class="row pt-4 px-3">
        
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block collapse">
            <div class="bg-white rounded-4 p-4 d-flex flex-column" style="position: sticky; top: 1.5rem; height: calc(100vh - 3rem); overflow-y: auto; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
                <!-- Logo Area -->
                <div class="text-center mb-4">
                    <img src="{{ asset('images/PL_Logo_whiteBG.png') }}" alt="Logo" style="height: 60px; object-fit: contain;">
                </div>
                <h6 class="text-primary fw-bold text-uppercase mb-3 px-2" style="letter-spacing: 1px; font-size: 0.85rem;">Book Rental</h6>
                
                <ul class="nav flex-column mb-auto gap-2">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold rounded-3 px-3 py-2" href="{{ route('dashboard') }}" style="font-size: 0.85rem;background-color: #eff6ff; color: #3b82f6;">
                            Active Rentals
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted fw-bold rounded-3 px-3 py-2" href="{{ route('books.index') }}" style="font-size: 0.85rem;">
                            Book Collections
                        </a>
                    </li>
                    @can('admin')
                    <li class="nav-item">
                        <a class="nav-link text-muted fw-bold rounded-3 px-3 py-2" href="{{ route('report.index') }}" style="font-size: 0.85rem;">
                            Report
                        </a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link text-muted fw-bold rounded-3 px-3 py-2" href="{{ route('settings') }}" style="font-size: 0.85rem;">
                            Settings
                        </a>
                    </li>
                </ul>

                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center px-2">
                    <div>
                        <span class="d-block fw-bold" style="color: #1f2937; font-size: 0.95rem;">{{ auth()->user()->name }}</span>
                        <span class="text-muted" style="font-size: 0.8rem;">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger text-decoration-none fw-bold p-0" style="font-size: 0.85rem;">Log out</button>
                    </form>
                </div>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @can('admin')
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2 fw-bold">Admin Dashboard</h1>
                </div>
                <h4 class="mt-3">Manage Rental Requests</h4>
                
                <form method="GET" action="{{ route('dashboard') }}" class="row g-2 mb-4 mt-2">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control rounded-pill px-4" placeholder="Search student or book title..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select rounded-pill px-4">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="picked up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>
                    <div class="col-md-2"><button type="submit" class="btn btn-primary rounded-pill px-4 w-100">Filter</button></div>
                    <div class="col-md-2"><a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 w-100">Clear</a></div>
                </form>

                <div class="bg-white rounded-4 shadow-sm p-3 table-responsive">
                    <table class="table align-middle border-light">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th><th>Book</th><th>Requested</th><th>Expiry Date</th><th>Status</th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rentals as $rental)
                                <tr>
                                    <td>{{ $rental->user->name }}</td>
                                    <td>{{ $rental->book->title }}</td>
                                    <td>{{ $rental->created_at->format('M d, Y') }}</td>
                                    <td>{{ $rental->expires_at?->format('M d, Y') }}</td>
                                    <td><span class="badge-{{ ($rental->status === 'approved' ? 'approved' : ($rental->status === 'Picked Up' ? 'picked_up' : ($rental->status === 'pending' ? 'pending' : ($rental->status === 'returned' ? 'returned' : ($rental->status === 'expired' ? 'expired' : 'rejected'))))) }}" >{{ ucfirst($rental->status) }}</span></td>
                                    <td>
                                        @if($rental->status === 'pending')
                                            <form action="{{ route('rentals.approve', $rental) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-success">Approve</button></form>
                                            <form action="{{ route('rentals.reject', $rental) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-danger">Reject</button></form>
                                        @elseif($rental->status === 'approved')
                                            <form action="{{ route('rentals.pickup', $rental) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-primary">Picked Up</button></form>
                                        @elseif($rental->status === 'Picked Up')
                                            <form action="{{ route('rentals.return', $rental) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-primary">Return</button></form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">No requests found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @else
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">Dashboard</span>
                    <h2 class="fw-bold mb-1" style="color: #111827;">My Rentals</h2>
                    <p class="text-muted small mb-0">Monitor your Rental Activity here</p>
                </div>
                
                <form method="GET" action="{{ route('dashboard') }}" class="row g-2 mb-4 mt-2">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control rounded-pill px-4" placeholder="Search student or book title..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select rounded-pill px-4">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="picked up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>
                    <div class="col-md-2"><button type="submit" class="btn btn-primary rounded-pill px-4 w-100">Filter</button></div>
                    <div class="col-md-2"><a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 w-100">Clear</a></div>
                </form>
                
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @forelse ($rentals as $rental)
                        <div class="col">
                            <div class="card custom-card bg-white h-100 p-2">
                                
                                @if($rental->book->book_cover)
                                    <img src="{{ asset('storage/' . $rental->book->book_cover) }}" class="card-img-top rounded-4" alt="Cover" style="height: 250px; object-fit: cover;">
                                @else
                                    <div class="card-img-top rounded-4 d-flex align-items-center justify-content-center text-muted" style="height: 250px; background-color: #f1f5f9;">
                                        <span class="small fw-bold text-uppercase" style="letter-spacing: 2px; color: #cbd5e1;">Book Cover</span>
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex justify-content-between align-items-start px-3 py-3" gap-2>
                                    <div class="overflow-hidden">
                                        <h5 class="fw-bold mb-1 text-truncate" style="max-width: 180px;">{{ $rental->book->title }}</h5>
                                        <p class="text-muted small mb-0">{{ $rental->book->author }}</p>
                                    </div>
                                    @if($rental->status === 'approved') <span class="badge-approved">Approved</span>
                                    @elseif($rental->status === 'pending') <span class="badge-pending">Pending</span>
                                    @elseif($rental->status === 'returned') <span class="badge-returned">Returned</span>
                                    @elseif($rental->status === 'expired') <span class="badge-expired">Expired</span>
                                    @elseif($rental->status === 'Picked Up') <span> - </span> 
                                    @else <span class="badge-rejected">Rejected</span> @endif
                                </div>
                                
                                <div class="figma-card-footer mt-auto d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="d-block text-muted" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 1px;">EXPIRES</span>
                                        <span class="fw-bold" style="font-size: 0.85rem; color: #1f2937;">
                                            {{ $rental->expires_at ? \Carbon\Carbon::parse($rental->expires_at)->format('M d, Y') : '-' }}
                                        </span>
                                    </div>
                                    <div>
                                        @if($rental->status === 'pending')
                                            <form action="{{ route('rentals.cancel', $rental) }}" method="POST" class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger text-decoration-none p-0 fw-bold" style="font-size: 0.8rem;" onclick="return confirm('Cancel request?')">Cancel</button>
                                            </form>
                                        @elseif($rental->status === 'approved')
                                            <span class="fw-bold" style="color: #3b82f6; font-size: 0.8rem;">Ready to pick up</span>
                                        @elseif($rental->status === 'Picked Up')
                                            <span class="fw-bold" style="color: #10b981; font-size: 0.8rem;">Picked Up</span>
                                        @else
                                            <span class="text-muted fw-bold" style="font-size: 0.8rem;">See Details</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-light aler-dismissable border-0 rounded-4 text-center py-5 shadow-sm">
                                <p class="text-muted mb-0 fw-bold">You have no rentals matching this filter.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            @endcan
        </main>
    </div>
</div>
@endsection