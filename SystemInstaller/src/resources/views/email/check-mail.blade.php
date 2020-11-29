@component('mail::message')
# Checking...
This mail is from {{ config('app.name') }}.
<br>
Message:
{{ $description }}

@component('mail::button', ['url' => ''])
{{ \Carbon\Carbon::now() }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent