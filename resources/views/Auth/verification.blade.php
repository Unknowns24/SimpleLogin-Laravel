<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title><?php echo env('APP_NAME') ?> - Verificar Email</title>
        <!-- Icon -->
        <link rel="icon" href="{{url('/')}}/dist/img/logo.png">
        <link rel="stylesheet" href="{{url('/')}}/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="{{url('/')}}/dist/css/adminlte.min.css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>


    <body style="background-color:black;">
        <div class="container" style="width:100%; height:100%">
            <div class="row d-flex justify-content-center mx-auto" style="margin-top:20%">
                <div class="col-8">
                    <div class="card ">
                        <div class="card-header text-center p-4">
                            Verificación de E-Mail
                        </div>
                        <div class="card-body text-center p-4">                    
                            @if(isset($validated) && $validated == true)
                                <div class="alert alert-success">
                                    Tu correo se ha verificado satisfactoriamente!
                                </div>
                            @endif

                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                            @endif

                            <p>Hola <?php echo(App\Models\User::findOrFail(Illuminate\Support\Facades\Auth::user()->id))->name ?>, Necesitamos que verifiques tu dirección de email, te hemos enviado un correo, deberás seguir las instrucciones del mismo. <br>Si la cuenta no es activada antes de <?php echo date("j", env('EXPIRE_NON_ACTIVATED_USERS',0)-1); ?> día(s) de ser registrada, la misma será  <strong>eliminada<strong> automáticamente.<p>
                        </div>
                        
                        <div class="card-footer text-center p-4">
                            @if(isset($validated) and $validated == true)
                                <a href="{{url('/')}}" class="btn btn-primary">Ir al menu principal</a>
                            @else
                                <a href="{{route('mail.resend')}}" class="btn btn-primary">Reenviar</a>
                                <a href="{{url('/')}}" class="btn btn-danger" onclick="
                                    event.preventDefault();
                                    document.getElementById('logout-form').submit();
                                    return false;
                                ">Cerrar Sesión</a>
                                <a href="<?= (url()->previous() != Illuminate\Support\Facades\URL::current() ? url()->previous() : url('/')) ?>" class="btn btn-light">Volver</a>

                                <form action="{{route('logout')}}" method="POST" id="logout-form" style="display: none"> @csrf </form>
                            @endif
                        </div>  
                    </div>
                </div>
            </div>
        </div>

        <script src="{{url('/')}}/plugins/jquery/jquery.min.js"></script>
        <script src="{{url('/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

