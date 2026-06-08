<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RentalStatusUpdated extends Notification
{
    use Queueable;

    public $rental;
    public $status;

    public function __construct($rental, $status)
    {
        $this->rental = $rental;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $color = $this->status === 'approved' ? 'success' : 'error';
        
        return (new MailMessage)
            ->subject('Rental Request ' . ucfirst($this->status))
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your rental request for "' . $this->rental->book->title . '"has been ' . $this->status . '.')
            ->action('View Status', url('/dashboard'))
            ->line('Thank you for using Planet Library!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'rental_id' => $this->rental->id,
            'book_title' => $this->rental->book->title,
            'status' => $this->status,
        ];
    }
}
