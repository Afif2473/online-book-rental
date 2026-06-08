# N+1 Query Problem Analysis

I have reviewed your code to identify potential N+1 query problems.

## What is the N+1 Query Problem?
The N+1 query problem occurs when your application executes one database query to get a list of records (the "1" query), and then executes an additional query for *each* record in that list to retrieve related data (the "N" queries). This severely degrades application performance, especially as the number of records grows.

## Issues Found in Your Code

### 1. `SendExpiryNotifications` Command

In `app/Console/Commands/SendExpiryNotifications.php`, there are N+1 problems in how relationships are accessed during the mail sending process.

```php
        $expiringDate = Carbon::today()->addDays(3);
        $rentalExpiring = Rental::where('status', 'Picked Up')
            ->whereDate('expires_at', $expiringDate)
            ->get(); // Eager loading is missing here
        foreach ($rentalExpiring as $rental)
        {
            // Accessing $rental->user triggers a query for EACH rental
            Mail::to($rental->user)->send(new \App\Mail\RentalExpireSoon($rental, 'expiring soon'));
        }

        $expiredToday = Carbon::today();
        $rentalsToday = Rental::where('status', 'Picked Up')
            ->whereDate('expires_at', $expiredToday)
            ->get(); // Eager loading is missing here
        foreach ($rentalsToday as $rental)
        {
            // Accessing $rental->user triggers a query for EACH rental
            Mail::to($rental->user)->send(new \App\Mail\RentalExpireToday($rental, 'expired today'));        
        }

        $expired = Carbon::today()->subDay();
        $rentalsExpired = Rental::where('status', 'Picked Up')
            ->whereDate('expires_at', '<=', $expired)
            ->get(); // Eager loading is missing here
        $this->info("Found " . $rentalsExpired->count() . " rentals to mark as expired.");
        foreach ($rentalsExpired as $rental)
        {
            $rental->update(['status' => 'expired']);
            // Accessing $rental->book triggers a query for EACH expired rental
            $rental->book->increment('quantity');
        }
```

**How to Fix:**
Use `with()` to eager load the `user` and `book` relationships when querying the rentals.

```php
        $rentalExpiring = Rental::with('user')->where('status', 'Picked Up')
            ->whereDate('expires_at', $expiringDate)
            ->get();

        // ...
        
        $rentalsToday = Rental::with('user')->where('status', 'Picked Up')
            ->whereDate('expires_at', $expiredToday)
            ->get();
            
        // ...
        
        $rentalsExpired = Rental::with('book')->where('status', 'Picked Up')
            ->whereDate('expires_at', '<=', $expired)
            ->get();
```

### 2. Routes (`routes/web.php`)

In `routes/web.php` for the `/dashboard` route, you already used eager loading (`with(['user', 'book'])` and `with('book')`), which is great! This prevents the N+1 problem on the dashboard view.

```php
    if ($user->role === 'admin'){
        $query = App\Models\Rental::with(['user', 'book']); // Excellent: prevents N+1
        // ...
    }else{
        $query = App\Models\Rental::with('book')->where('user_id', $user->id); // Excellent: prevents N+1
        // ...
    }
```
However, watch out for the email notifications in `RentalController.php`.

### 3. `RentalController.php`

In `app/Http/Controllers/RentalController.php`, when triggering emails, you access related models on the given `Rental`.

```php
    public function reject(Rental $rental)
    {
        Gate::authorize('admin');
        $rental->update(['status' => 'rejected']);
        
        // $rental->user may trigger a query if the 'user' relation wasn't loaded 
        // when resolving the implicit route model binding.
        Mail::to($rental->user->email)
            ->send(new RentalRejected($rental, 'rejected'));

        return back()->with('success', 'Rental request rejected');
    }
```
Since this is a single record (`$rental`), it technically causes just an extra single query (1+1), not a full N+1 problem on a massive scale (since it's fired on a single action). However, it's good practice to keep an eye out for this if you ever switch to mass-rejecting or mass-approving items.

## Summary

The largest potential N+1 issue in your current codebase is within the `SendExpiryNotifications` command, where iterating over multiple records and accessing unloaded relationships causes additional database queries for each individual item inside the loop. Adding `with('user')` and `with('book')` to those queries fixes it.