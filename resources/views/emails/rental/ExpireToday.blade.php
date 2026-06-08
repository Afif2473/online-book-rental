<x-mail::message>
# Rental Expires Today

Dear {{ $rental->user->name }},
We wanted to remind you that your rental for the book "{{ $rental->book->title }}" is expiring today on {{ $rental->expires_at->format('d/m/Y') }}. Please make sure to return the book on time to avoid any late fees.

<x-mail::button :url="''">
Go to Planet Library
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
