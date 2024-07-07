@component('mail::message')
Hello {{$user->name}},

<p>Don't worry, it happens to the best of us. We've received a request to reset your password.</p>

@component('mail::button', ['url' => url('reset/' . $user->remember_token)])
Reset Your Password
@endcomponent

<p>This link is valid for 60 minutes. If you did not request a password reset, you can safely ignore this email.</p>

<p>In case you have any issues recovering your password, please contact us.</p>

Thanks,<br>
{{ config('app.name') }}  @endcomponent
