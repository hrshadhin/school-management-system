@component('mail::message')

    @component('mail::panel')
        {!! $emailContent !!}
    @endcomponent

    Thanks,
    @if(AppHelper::getInstituteCategory() == 'college') Principal @else Head Master @endif
    {{ config('app.name') }}
@endcomponent