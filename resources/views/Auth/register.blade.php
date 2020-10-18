<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title>test</title>
        <!-- Icon -->
        <link rel="icon" href="{{url('/')}}/dist/img/logo.png">
        <link rel="stylesheet" href="{{url('/')}}/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="{{url('/')}}/dist/css/adminlte.min.css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>


    <body style="background-color:black;">
        <div class="container" style="width:100%; height:100%">
            <div class="row d-flex justify-content-center mx-auto" style="margin-top:15%">
                <div class="col-6 col-lg-4">
                    <div class="card ">
                        <div class="card-body text-center p-4">
                            <form id="register" class="form-signin" method="POST" action="{{ route('register') }}">
                                @csrf
                                <h1 class="h3 mb-3 font-weight-normal">Registro</h1>
                                
                                @if(isset($err))
                                    <div class="row d-flex float-right mr-2">
                                        <div class="alert alert-danger" role="alert">
                                            <strong>{{$err}}</strong><a href="{{url('/')}}/register"><i class="fas fa-times float-right ml-2" style="margin-top: 1%"></i><a>
                                        </div>
                                    </div>  
                                @endif

                                @error('username')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror

                                @error('email')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror

                                @error('password')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror

                                <div class="input-group mb-2 mx-auto" style="max-width: 300px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input id="username" name="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Usuario" value="{{old('username')}}" required autocomplete="username" autofocus>
                                </div>

                                <div class="input-group mb-2 mx-auto" style="max-width: 300px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="fas fa-at"></i>
                                        </span>
                                    </div>
                                    <input id="email" name="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="E-Mail" value="{{old('email')}}" required autocomplete="email">
                                </div>

                                <div class="input-group mb-2 mx-auto" style="max-width: 300px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                    <input name="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" required>
                                </div>

                                <div class="input-group mb-2 mx-auto" style="max-width: 300px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="fas fa-unlock"></i>
                                        </span>
                                    </div>
                                    <input id="password-confirm" name="password_confirmation" type="password" class="form-control" placeholder="Repita Contraseña" required autocomplete="new-password">
                                </div>
                            
                                <div class="input-group mx-auto" style="max-width: 300px;">
                                    <button class="btn btn-lg btn-primary btn-block" id="submit-btn">Registrarse</button>
                                </div>
                                <br>

                                <div class="row justify-content-center">
                                    <p>¿Ya tienes una cuenta? <a href="{{url('/')}}/login" class="link">¡Inicia Sesion!</a></p>
                                </div>
                                <p class=" mb-3 text-muted">© 2019 - <?=date("Y")?></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="{{url('/')}}/plugins/jquery/jquery.min.js"></script>
    <script src="{{url('/')}}/plugins/md5/main.js"></script>
    <script src="{{url('/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        $('#register').submit(function() {
            var password = document.getElementById('password');
            password.value = MD5(password.value);

            var password_confirm = document.getElementById('password-confirm');
            password_confirm.value = MD5(password_confirm.value);
        });
    </script>
</html>
