<?php

namespace Tests\Feature;

use App\Events\RentalRequested;
use App\Listeners\SendRentalConfirmationEmail;
use App\Mail\RentalRequestedMail;
use App\Models\Book;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RentalEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_renting_a_book_dispatches_the_event()
    {
        Event::fake();

        $user = User::factory()->create(); 

        $book = Book::create([
            'title' => 'Test Driven Development Book',
            'quantity' => 5,
            'author' => 'Kent Beck',
            'description' => 'A book about TDD principles and practices.',
            'cover_image' => 'https://example.com/tdd-book-cover.jpg',
            'isbn' => '978-0321146533',
        ]);

        $this->actingAs($user)
             ->post(route('rentals.store', $book->id));

        Event::assertDispatched(RentalRequested::class);
    }

    public function test_the_listener_sends_the_email()
    {
        Mail::fake();

        $user = User::factory()->create();
        
        $book = Book::create([
            'title' => 'Test Driven Development Book',
            'quantity' => 5,
            'author' => 'Kent Beck',
            'description' => 'A book about TDD principles and practices.',
            'cover_image' => 'https://example.com/tdd-book-cover.jpg',
            'isbn' => '978-0321146533',
        ]);

        $rental = Rental::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending'
        ]);

        $event = new RentalRequested($rental);
        $listener = new SendRentalConfirmationEmail();
        $listener->handle($event);

        Mail::assertSent(RentalRequestedMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}