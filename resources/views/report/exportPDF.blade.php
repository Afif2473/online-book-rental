<!DOCTYPE html>
<html>
<head>
    <title>Library Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <img src="{{ public_path('images/PL_Logo_whiteBG.png') }}" alt="Logo" style="height: 60px; object-fit: contain;">
    <h1>Library Report</h1>
    
    <h3>General Overview</h3>
    <p>Total Books: {{ $totalBooks }}</p>
    <p>Total Users: {{ $totalUsers }}</p>
    <p>Total Rentals: {{ $totalRentals }}</p>

    <h3>Rental Breakdown</h3>
    <p>Active: {{ $activeRentals }}</p>
    <p>Pending: {{ $pendingRentals }}</p>
    <p>Returned: {{ $returnedRentals }}</p>
    <p>Rejected: {{ $rejectedRentals }}</p>
    <p>Expired: {{ $expiredRentals }}</p>

    <h3>Popular Books Ranking</h3>
    <table>
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Total Rentals</th>
            </tr>
        </thead>
        <tbody>
            @foreach($popularBooks as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->rentals_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>