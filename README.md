## Simple Login 

Esta es una pagina web en laravel con un Sistema de registro y login totalmente personalizado. para una mayor flexibilidad ante distintas necesidades que pueda tener.

## Caracteristicas del Sistema

En este Login los passwords son encriptados por los clientes por lo que la informacion no va a viajara "desnuda", a demas que viaja encriptada en md5 a diferencia que la normalidad en laravel que es bcrypt, esto se debe que este es un sistema para paginas que no necesitan de tanta proteccion.

## Requerimientos 

- Composer.
- Laravel.
- MySQL.

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
Route::get('login',     [ AuthController::class,  'loginForm'     ])->name('login');
Route::get('register',  [ AuthController::class,  'registerForm'  ])->name('register');
Route::post('login',    [ AuthController::class,  'login'         ])->name('login');
Route::post('register', [ AuthController::class,  'register'      ])->name('register');
Route::post('logout',   [ AuthController::class,  'logout'        ])->name('logout');
```

2. ***Creacion del Controlador.***  
Para esto moveras el controlador AuthController ubicado en app/Https/Controllers/Auth a tu proyecto, si cambiaras la ubicacion no olvides de ingresar correctamente el namespace

3. ***Vistas.***  
Para esto importaremos las vistas del sistema de login, las cuales se encuentran en resources/views/Auth y las debes implementar en la misma ubicacion en tu proyecto. 

4. ***Cambio en el AuthServiceProvider.***  
para el correcto funcionamiento del sistema debemos añadir el siguiente codigo en el metodo **boot** del archivo AuthServiceProvider.php que se encuentra en app/Providers: 
```php
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

## Creadores

[Unknowns](https://github.com/Unknowns24).
