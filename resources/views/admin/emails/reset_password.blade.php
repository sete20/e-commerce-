@component('mail::message')
# Introduction

Wlcome der : {{$data['data']->name}}

@component('mail::button', ['url' =>aurl('reset/password/'.$data['token'])])
Click  Here TP reset UR Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
