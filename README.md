## Simple Login 

Esta es una pagina web en laravel con un Sistema de registro y login totalmente personalizado. para una mayor flexibilidad ante distintas necesidades que pueda tener.

## Caracteristicas del Sistema

En este Login los passwords son encriptados por los clientes por lo que la informacion no va a viajara "desnuda", a demas que viaja encriptada en md5 a diferencia que la normalidad en laravel que es bcrypt, esto se debe que este es un sistema para paginas que no necesitan de tanta proteccion.

## Requerimientos 

- Composer.
- Laravel.
- MySQL.
- [Praesidium](https://github.com/Unknowns24/Praesidium-Laravel)

### Instalacion en otros proyectos

0. ***(Opcional) Crear proyecto.***

Si tenemos el instalador lo haremos asi:
```
laravel new blog 
```
Si no lo podremos hacer con composer de esta forma:
```
composer create-project --prefer-dist laravel/laravel blog
```

1. ***Se ingresa en el archivo routes/web.php las siguientes lineas de codigo:***
```php
use App\Http\Controllers\Auth\AuthController;

// Auth Routes 
Route::get('login',                         [ AuthController::class,  'loginForm'     ])->name('login');
Route::get('register',                      [ AuthController::class,  'registerForm'  ])->name('register');
Route::get('/MailVerification',             [ AuthController::class,  'verification'  ])->name('verification.notice')->middleware('auth');
Route::get('MailVerification/resend',       [ AuthController::class,  'ResendMail'    ])->name('mail.resend');
Route::get('verifyMail/{userid}/{code}',    [ AuthController::class,  'verifyMail'    ])->name('mail.verify');

Route::post('login',                        [ AuthController::class,  'login'         ])->name('login');
Route::post('register',                     [ AuthController::class,  'register'      ])->name('register');
Route::post('logout',                       [ AuthController::class,  'logout'        ])->name('logout');
```

2. ***Creacion del Controlador.***  
Para esto moveras el controlador `AuthController` ubicado en app/Https/Controllers/Auth a tu proyecto, si cambiaras la ubicacion no olvides de ingresar correctamente el namespace

3. ***Vistas.***  
Para esto importaremos las vistas del sistema de login, las cuales se encuentran en `resources/views/auth` y en `resources/views/emails`. Luego las debes implementar en la misma ubicacion en tu proyecto. 

4. ***Email.***
En este paso debemos importar a nuestro proyecto la carpeta `app/Mail` y su contenido a la misma ubicacion pero en nuestro proyecto.

5. ***Traits.***
En este paso debemos importar la carpeta `app/Traits` con su contenido a nuestro proyecto.

6. ***Cambio en el AuthServiceProvider.***  
para el correcto funcionamiento del sistema debemos añadir el siguiente codigo en el metodo **boot** del archivo AuthServiceProvider.php que se encuentra en app/Providers: 
```php
    use Illuminate\Contracts\Auth\Authenticatable as UserContract;
    use Illuminate\Support\Facades\Auth;

    Auth::provider('eloquent', function($app, array $config)
    {
        return new class($app['hash'], $config['model']) extends \Illuminate\Auth\EloquentUserProvider
        {
            public function validateCredentials(UserContract $user, array $credentials)
            {
                $pass = $credentials['password'];
        
                if ($pass == $user->getAuthPassword()) {
                    return true;
                }
            
                return false; 
            }
        };
    });
```

7. ***Implementacion de la verificacion de Email.***  
Para poder habilitar los middlewares como `verified` lo que se debera hacer es añadir en el Modelo `User.php` ubicado en `app/Models` el siguiente codigo:  
```php 
implements MustVerifyEmail
```  
Ejemplo de como quedaría:
```php
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use UNK\Praesidium\Traits\PraesidiumTrait as Praesidium; 

class User extends Authenticatable implements MustVerifyEmail  // Aqui implementamos el Modelo MustVerifyEmail
{
    use HasFactory, Notifiable, Praesidium;

    /* 
        Default user model code
    */
}
```

8. ***Instalar el Plugin MD5***  
Como ultimo paso debemos copiar la carpeta MD5 que se encuentra en public/plugins/MD5 a la misma ubicacion pero en nuestro proyecto.

9. ***Archivo de autoload***
Al haber metido tantos archivos nuevos en nuestro proyecto para poder terminar con la instalacion deberemos ejecutar el siguiente comando:
```
composer dump-autoload
```

###  Ejemplo de aplicacion
__En caso de descargar el proyecto hemos proporcionado los metodos para poder hacerle pruebas pertinentes al sistema.__

__**Verificacion de emails**__

- Ejemplo de prueba. 
Para esto hemos creado una ruta de prueba, la ruta home, donde se necesitara un login previo para poder acceder y a la cual aquellos usuarios ya verificados no podran entrar, en esta sera visible el mensaje "Se necesita verificar el email" con sus acciones pertinentes    

- Ejemplo de aplicacion. 
Para poder chequear si un usuario se encuentra o no verificado a traves de email, lo que se debe hacer es llamar al trait importado del proyecto el cual es `app/Traits/VerificationMailTrait` y hacer uso de la funcion `emailValidated(userID)`, retorna un booleano.


## Desarrolladores

[Unknowns](https://github.com/Unknowns24).
[SERBice](https://github.com/SERBice).
