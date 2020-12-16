@component('mail::message')
# Activar Cuenta - {{ config('app.name') }}

Hola {{$data['username']}}, le informamos que para tener acceso total al sistema deberá verificar su cuenta de email, haga click al boton de abajo o ingrese a la siguiente dirección.

<?php echo url('/').'/verifyMail/'.$data["id"].'/'.$data["hash"]; ?>

@component('mail::button', ['url' => url('/').'/verifyMail/'.$data["id"].'/'.$data["hash"]])
Activar Cuenta
@endcomponent

Staff de {{ config('app.name') }}.
@endcomponent
