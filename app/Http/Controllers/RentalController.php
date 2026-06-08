<?php

namespace App\Http\Controllers;

use App\Mail\RentalApproved;
use App\Mail\RentalRejected;
use App\Models\Rental;
use App\Models\Book;
use App\Notifications\RentalStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Events\RentalRequested;
use App\Listeners\SendRentalConfirmationEmail;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin'){
            $query = Rental::with(['user', 'book']);

            if ($request->filled('status') && $request->status !== 'all'){
                $query->where('status', $request->status);
            }

            if ($request->filled('search')){
                $searchTerm = $request->search;

                $query->where(function ($q) use ($searchTerm) {
                    $q->whereHas('user', function ($userQuery) use ($searchTerm){
                        $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                    })

                    ->orWhereHas('book', function ($bookQuery) use ($searchTerm) {
                        $bookQuery->where('title', 'like', '%' . $searchTerm . '%');
                    });
                });
            }
            $rentals = $query->latest()->get();
        }else{
            $query = Rental::with('book')->where('user_id', $user->id);

            if ($request->filled('status') && $request->status !== 'all'){
                $query->where('status', $request->status);
            }

            if ($request->filled('search')){
                $searchTerm = $request->search;
                $query->whereHas('book', function ($bookQuery) use ($searchTerm){
                    $bookQuery->where('title', 'like', '%'. $searchTerm . '%')
                    ->orWhere('author', 'like', '%' . $searchTerm . '%');
                });
            }
            $rentals = $query->latest()->get();
        }
        return view('dashboard', compact('rentals'));
    }

    public function store(Request $request, Book $book)
    {
        if ($book->quantity < 1) {  
            return back()->with('error', 'Sorry this book is currently unavailable.');
        }

        $rental = Rental::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            //'expires_at' => now()->addDays(14),
            'status' => 'pending',
        ]);

        RentalRequested::dispatch($rental);

        return back()->with('success', 'rental application submitted! Waiting for admin approval.');
    }

    public function markPickedUp(Rental $rental)
    {
        Gate::authorize('admin');
        if($rental->status !== 'approved'){
            return back()->with('error', 'Only approved rentals can be picked up.');
        }

        $rental->update([
            'status' => 'Picked Up',
            'rented_at' => now(),
            'expires_at' => now()->addDays(14)
        ]);

        return back()->with('success', 'Book marked as picked up! Rental period has started.');
    }

    public function markReturned(Rental $rental)
    {
        Gate::authorize('admin');
        if($rental->status !== 'Picked Up'){
            return back()->with ('error', 'Only picked up rentals can be marked as returned.');
        }

        $rental->update(['status' => 'returned']);

        $rental->book->increment('quantity');

        return back()->with('success', 'Book marked as returned and inventory updated!');
    }

    public function reject(Rental $rental)
    {
        Gate::authorize('admin');
        $rental->update(['status' => 'rejected']);
        Mail::to($rental->user->email)
            ->send(new RentalRejected($rental, 'rejected'));

        return back()->with('success', 'Rental request rejected');
    }

    public function approve(Rental $rental)
    {
        Gate::authorize('admin');

        if ($rental->book->quantity<=0) {
            return back()->with('error', 'Sorry, book currently unavailable.');
        }
        $rental->update(['status' => 'approved']);
        $rental->book->decrement('quantity');
        //$rental->user->notify(new RentalStatusUpdated($rental, 'approved'));
        Mail::to($rental->user->email)
            ->send(new RentalApproved($rental, 'approved'));

        return back()->with('success', 'Rental request approved and student notified!');
    }

    public function cancel(Rental $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            abort(403, 'Unauthorized Action.');
        }
        
        if ($rental->status !== 'pending')
        {
            return back()->with('error', 'Only requests that are still pending can be cancelled.');
        }
        $rental->delete();
        return back()->with('success', 'Rental request cancelled successfully.');
    }
}
