<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        Gate::authorize('admin');

        $data = $this->reportData();

        return view('report.index', $data);
    }

    public function exportPDF()
    {
        Gate::authorize('admin');

        $data = $this->reportData();

        $pdf = Pdf::loadView('report.exportPDF', $data);

        return $pdf->download('book-planet-report.pdf');
    }

    private function reportData(): array
    {
        $totalBooks = Book::count();
        $totalUsers = User::where('role', '!=', 'admin')->count();
        
        $rentalCount = Rental::selectRaw('status, count(status) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $totalRentals = $rentalCount->sum();
        $activeRentals = $rentalCount->get('approved', 0) + $rentalCount->get('Picked Up', 0);
        $returnedRentals = $rentalCount->get('returned', 0);
        $rejectedRentals = $rentalCount->get('rejected', 0);
        $expiredRentals = $rentalCount->get('expired', 0);
        $pendingRentals = $rentalCount->get('pending', 0);

        $popularBooks = Book::withCount('rentals')
            ->orderBy('rentals_count', 'desc')
            ->get();

        return compact(
            'totalBooks', 'totalUsers', 'totalRentals', 
            'activeRentals', 'returnedRentals', 'rejectedRentals', 
            'expiredRentals', 'pendingRentals', 'popularBooks'
        );
    }
}