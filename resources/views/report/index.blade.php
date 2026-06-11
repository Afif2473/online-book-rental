@extends('layout')

@section('content')
<div class="container-fluid" style="background-color: #f8fafc; min-height: 100vh;">
    <div class="row pt-4 px-3">
        
        <!-- Sidebar Menu -->
        @include('layouts.navigation')

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom mt-2">
                <h1 class="h2 fw-bold">{{ __('message.Menu3.Collection Report') }}</h1>
            </div>

            <div class="mb-3 d-flex justify-content-end">
                <a href="{{ route('report.exportPDF') }}" class="btn btn-primary">
                    {{ __('message.Menu3.ExportPDF') }}
                </a>
            </div>

            <!-- Stats Overview -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                        <h6 class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">{{ __('message.Menu3.Total Books') }}</h6>
                        <h2 class="fw-bold mb-0 text-primary">{{ $totalBooks }}</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                        <h6 class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">{{ __('message.Menu3.Registered Users') }}</h6>
                        <h2 class="fw-bold mb-0 text-success">{{ $totalUsers }}</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                        <h6 class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">{{ __('message.Menu3.Total Rentals') }}</h6>
                        <h2 class="fw-bold mb-0 text-info">{{ $totalRentals }}</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                        <h6 class="text-muted fw-bold text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 1px;">{{ __('message.Menu3.Active Rentals') }}</h6>
                        <h2 class="fw-bold mb-0 text-success">{{ $activeRentals }}</h2>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- Rental Breakdown -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <h5 class="fw-bold mb-4">{{ __('message.Menu3.Rental Breakdown') }}</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-0">
                                <span>{{ __('message.Menu3.Pending Approval') }}</span>
                                <span class="fw-bold py-2 px-3">{{ $pendingRentals }}</span>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-0">
                                <span>{{ __('message.Menu3.Returned') }}</span>
                                <span class="fw-bold py-2 px-3">{{ $returnedRentals }}</span>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-0">
                                <span>{{ __('message.Menu3.Rejected') }}</span>
                                <span class="fw-bold py-2 px-3">{{ $rejectedRentals }}</span>
                            </li>
                            <li class="list-group-item border-0 d-flex justify-content-between align-items-center px-0">
                                <span class="text-danger fw-bold">{{ __('message.Menu3.Expired') }}</span>
                                <span class="fw-bold py-2 px-3">{{ $expiredRentals }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Popular Books -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                        <h5 class="fw-bold mb-4">{{ __('message.Menu3.Ranking') }}</h5>
                        @if($popularBooks->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <thead class="text-muted small text-uppercase" style="letter-spacing: 1px;">
                                        <tr>
                                            <th class="ps-0 border-bottom pb-2">{{ __('message.Menu3.Title') }}</th>
                                            <th class="border-bottom pb-2">{{ __('message.Menu3.Author') }}</th>
                                            <th class="text-end pe-0 border-bottom pb-2">{{ __('message.Menu3.Rentals') }}</th>
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