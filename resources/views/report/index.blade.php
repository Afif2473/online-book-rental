@extends('layout')

@section('content')
<div class="container-fluid" style="background-color: #f8fafc; min-height: 100vh;">
    <div class="row pt-4 px-3">
        
        <!-- Sidebar Menu -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block collapse">
            <div class="bg-white rounded-4 p-4 d-flex flex-column" style="position: sticky; top: 1.5rem; height: calc(100vh - 3rem); overflow-y: auto; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
                
                <!-- Logo Area -->
                <div class="text-center mb-4">
                    <img src="{{ asset('images/PL_Logo_whiteBG.png') }}" alt="Logo" style="height: 60px; object-fit: contain;">
                </div>

                <h6 class="text-primary fw-bold text-uppercase mb-3 px-2" style="letter-spacing: 1px; font-size: 0.85rem;">Book Rental</h6>
                
                <ul class="nav flex-column mb-auto gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-muted fw-bold rounded-3 px-3 py-2" style="font-size: 0.85rem;" href="{{ route('dashboard') }}">
                            Active Rentals
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted fw-bold rounded-3 px-3 py-2" href="{{ route('books.index') }}" style="font-size: 0.85rem;">
                            Book Collections
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold rounded-3 px-3 py-2" href="{{ route('report.index') }}" style="font-size: 0.85rem;background-color: #eff6ff; color: #3b82f6;">
                            Report
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted fw-bold rounded-3 px-3 py-2" style="font-size: 0.85rem;" href="{{ route('settings') }}">Settings</a>
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

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom mt-2">
                <h1 class="h2 fw-bold">Library Report</h1>
            </div>

            <div class="mb-3 d-flex justify-content-end">
                <a href="{{ route('report.exportPDF') }}" class="btn btn-primary">
                    Export to PDF
                </a>
            </div>

            <!-- Stats Overview -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                        <h6 class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">Total Books</h6>
                        <h2 class="fw-bold mb-0 text-primary">{{ $totalBooks }}</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                        <h6 class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">Registered Users</h6>
                        <h2 class="fw-bold mb-0 text-success">{{ $totalUsers }}</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                        <h6 class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">Total Rentals</h6>
                        <h2 class="fw-bold mb-0 text-info">{{ $totalRentals }}</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                        <h6 class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">Active Rentals</h6>
                        <h2 class="fw-bold mb-0 text-success">{{ $activeRentals }}</h2>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- Rental Breakdown -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <h5 class="fw-bold mb-4">Rental Breakdown</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-0">
                                <span>Pending Approval</span>
                                <span class="fw-bold py-2 px-3">{{ $pendingRentals }}</span>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-0">
                                <span>Returned</span>
                                <span class="fw-bold py-2 px-3">{{ $returnedRentals }}</span>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-0">
                                <span>Rejected</span>
                                <span class="fw-bold py-2 px-3">{{ $rejectedRentals }}</span>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-0">
                                <span class="text-danger fw-bold">Expired</span>
                                <span class="fw-bold py-2 px-3">{{ $expiredRentals }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Popular Books -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <h5 class="fw-bold mb-4">Books Ranking by Most Rentals</h5>
                        @if($popularBooks->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <thead class="text-muted small text-uppercase" style="letter-spacing: 1px;">
                                        <tr>
                                            <th class="ps-0 border-bottom pb-2">Title</th>
                                            <th class="border-bottom pb-2">Author</th>
                                            <th class="text-end pe-0 border-bottom pb-2">Rentals</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($popularBooks as $book)
                                            <tr>
                                                <td class="ps-0 py-3 fw-bold text-truncate" style="max-width: 150px;">{{ $book->title }}</td>
                                                <td class="py-3 text-muted text-truncate" style="max-width: 120px;">{{ $book->author }}</td>
                                                <td class="pe-0 py-3 text-end"><span class="badge bg-primary rounded-pill">{{ $book->rentals_count }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center py-4">No rental data available yet.</p>
                        @endif
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>
@endsection