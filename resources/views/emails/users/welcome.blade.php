@component('mail::message')
Hola {{$user->name}},

Bienvenido.

Te invitamos a completar tu registro en nuestro sistema haciendo click en el siguiente botón.

@component('mail::button', ['url' => route('set.password',$user->id)])
Completar Registro
@endcomponent

Muchas Gracias,<br>
{{ config('app.name') }}
@endcomponent
