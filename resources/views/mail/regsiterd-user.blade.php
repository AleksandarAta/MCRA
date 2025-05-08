<x-mail::message>
# Introduction

{{ __("Thank you for registring to our website") }}

  <a href="{{ route('user.info', ['user' => $user->id]) }}">  {{ __("To continue please click on this link") }}</a>ex

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
