@extends('layout')

@section('content')
<div class="container-fluid" style="background-color: #f8fafc; min-height: 100vh;">
    <div class="row pt-4 px-3">
        @include('layouts.navigation')

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
                    <h1 class="h2 fw-bold">{{ __('message.menu1.Admin Dashboard') }}</h1>
                </div>
                <h4 class="mt-3">{{ __('message.menu1.Manage Rental Requests') }}</h4>

                <form method="GET" action="{{ route('dashboard') }}" class="row g-2 mb-4 mt-2">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control rounded-pill px-4" placeholder="{{ __('Search student or book title') }}" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select rounded-pill px-4">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>{{ __('message.menu1.All statuses') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('message.Actions.Pending') }}</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ __('message.Actions.Approved') }}</option>
                            <option value="picked up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>{{ __('message.Actions.Picked up') }}</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('message.Actions.Rejected') }}</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>{{ __('message.Actions.Returned') }}</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>{{ __('message.Actions.Expired') }}</option>
                        </select>
                    </div>
                    <div class="col-md-2"><button type="submit" class="btn btn-primary rounded-pill px-4 w-100">{{ __('message.menu1.Filter') }}</button></div>
                    <div class="col-md-2"><a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 w-100">{{ __('message.menu1.Clear') }}</a></div>
                </form>

                <div class="bg-white rounded-4 shadow-sm p-3 table-responsive">
                    <table class="table align-middle border-light">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('message.menu1.Student') }}</th>
                                <th>{{ __('message.menu1.Book') }}</th>
                                <th>{{ __('message.menu1.Requested At') }}</th>
                                <th>{{ __('message.menu1.Expiry Date') }}</th>
                                <th>{{ __('message.menu1.Status') }}</th>
                                <th>{{ __('message.menu1.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rentals as $rental)
                                <tr>
                                    <td>{{ $rental->user->name }}</td>
                                    <td>{{ $rental->book->title }}</td>
                                    <td>{{ $rental->created_at->format('M d, Y') }}</td>
                                    <td>{{ $rental->expires_at?->format('M d, Y') }}</td>
                                    <td><span class="badge-{{ ($rental->status === 'approved' ? 'approved' : ($rental->status === 'Picked Up' ? 'picked_up' : ($rental->status === 'pending' ? 'pending' : ($rental->status === 'returned' ? 'returned' : ($rental->status === 'expired' ? 'expired' : 'rejected'))))) }}" >{{ __(ucfirst($rental->status)) }}</span></td>
                                    <td>
                                        @if($rental->status === 'pending')
                                            <form action="{{ route('rentals.approve', $rental) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-success">{{ __('message.Actions.Approve') }}</button></form>
                                            <form action="{{ route('rentals.reject', $rental) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-danger">{{ __('message.Actions.Reject') }}</button></form>
                                        @elseif($rental->status === 'approved')
                                            <form action="{{ route('rentals.pickup', $rental) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-primary">{{ __('message.Actions.Picked Up') }}</button></form>
                                        @elseif($rental->status === 'Picked Up')
                                            <form action="{{ route('rentals.return', $rental) }}" method="POST" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-primary">{{ __('message.Actions.Returned') }}</button></form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">{{ __('message.menu1.no requests found') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @else
                <div>
                    <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">{{ __('message.menu1.Dashboard') }}</span>
                    <h2 class="fw-bold mb-1" style="color: #111827;">{{ __('message.menu1.my rentals') }}</h2>
                    <p class="text-muted small mb-0">{{ __('message.menu1.Monitor your Rental Activities here') }}</p>
                </div>
                
                <form method="GET" action="{{ route('dashboard') }}" class="row g-2 mb-4 mt-2">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control rounded-pill px-4" placeholder="{{ __('message.menu1.Search student or book title') }}" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select rounded-pill px-4">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>{{ __('message.menu1.All statuses') }}</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('message.menu1.pending') }}</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ __('message.Actions.Approved') }}</option>
                            <option value="picked up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>{{ __('message.Actions.Picked Up') }}</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('message.Actions.Rejected') }}</option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>{{ __('message.Actions.Returned') }}</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>{{ __('message.Actions.Expired') }}</option>
                        </select>
                    </div>
                    <div class="col-md-2"><button type="submit" class="btn btn-primary rounded-pill px-4 w-100">{{ __('message.menu1.Filter') }}</button></div>
                    <div class="col-md-2"><a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 w-100">{{ __('message.menu1.Clear') }}</a></div>
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
                                    @if($rental->status === 'approved') <span class="badge-approved">{{ __('message.Actions.Approved') }}</span>
                                    @elseif($rental->status === 'pending') <span class="badge-pending">{{ __('message.Actions.Pending') }}</span>
                                    @elseif($rental->status === 'returned') <span class="badge-returned">{{ __('message.Actions.Returned') }}</span>
                                    @elseif($rental->status === 'expired') <span class="badge-expired">{{ __('message.Actions.Expired') }}</span>
                                    @elseif($rental->status === 'Picked Up') <span> - </span> 
                                    @else <span class="badge-rejected">{{ __('message.Actions.Rejected') }}</span> @endif
                                </div>
                                
                                <div class="figma-card-footer mt-auto d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="d-block text-muted" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 1px;">{{ __('message.menu1.Expires') }}</span>
                                        <span class="fw-bold" style="font-size: 0.85rem; color: #1f2937;">
                                            {{ $rental->expires_at ? \Carbon\Carbon::parse($rental->expires_at)->format('M d, Y') : '-' }}
                                        </span>
                                    </div>
                                    <div>
                                        @if($rental->status === 'pending')
                                            <form action="{{ route('rentals.cancel', $rental) }}" method="POST" class="m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger text-decoration-none p-0 fw-bold" style="font-size: 0.8rem;" onclick="return confirm('Cancel request?')">{{ __('message.menu1.Cancel') }}</button>
                                            </form>
                                        @elseif($rental->status === 'approved')
                                            <span class="fw-bold" style="color: #3b82f6; font-size: 0.8rem;">{{ __('message.menu1.Ready to pick up') }}</span>
                                        @elseif($rental->status === 'Picked Up')
                                            <span class="fw-bold" style="color: #10b981; font-size: 0.8rem;">{{ __('message.Actions.Picked Up') }}</span>
                                        @else
                                            <span class="text-muted fw-bold" style="font-size: 0.8rem;">{{ __('message.menu1.See Details') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-light aler-dismissable border-0 rounded-4 text-center py-5 shadow-sm">
                                <p class="text-muted mb-0 fw-bold">{{ __('message.menu1.No rentals found') }}</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            @endcan
        </main>
    </div>
</div>
@endsection