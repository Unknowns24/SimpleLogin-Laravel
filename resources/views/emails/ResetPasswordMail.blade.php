@component('mail::message')
# Cambiar Contraseña - {{ config('app.name') }}

Hola {{$data['username']}}, nos comunicamos debido a una peticion para cambiar la contraseña de su cuenta. Para esto presione el boton de abajo o copie y pegue el link que se encuentra a continuacion. **Este link solo sera valido por 10 minutos.**

<?php echo url('/').'/reset-password/'.$data["id"].'/'.$data["hash"]; ?>

@component('mail::button', ['url' => url('/').'/reset-password/'.$data["id"].'/'.$data["hash"]])
Cambiar Contraseña
@endcomponent

Staff de {{ config('app.name') }}.
@endcomponent
