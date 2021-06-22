@component('mail::message')
# New member registered

Full name: {{ $member->name }} <br>
@if(isset($member->phone))Phone number: {{ $member->phone }} <br>@endif
Email: {{ $member->email }} <br>

@component('mail::button', ['url' => route('admin.members.profile', $member->id)])
    Show Member
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
