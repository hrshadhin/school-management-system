@component('mail::message')

    @component('mail::panel')
        {!! $emailContent !!}
    @endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent