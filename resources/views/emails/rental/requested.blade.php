<x-mail::message>
# You've Placed a Rental Request!

Thank you for your interest in renting {{ $rental->book->title }} from our collection. Your rental request has been received and is currently being processed. We will notify you once your request has been reviewed and approved.

<x-mail::button :url="url('/dashboard')">
Planet Library
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
