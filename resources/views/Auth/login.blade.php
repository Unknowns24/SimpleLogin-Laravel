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
            <div class="row d-flex justify-content-center mx-auto" style="margin-top:20%">
                <div class="col-6 col-lg-4">
                    <div class="card ">
                        <div class="card-body text-center p-4">
                            <form id="login" class="form-signin" method="POST" action="{{ route('login') }}">
                                @csrf
                                <h1 class="h3 mb-3 font-weight-normal">Login</h1>
                                
                                @error('login')
                                    <div class="alert alert-danger" role="alert">
                                        <strong>{{$message}}</strong>
                                    </div>
                                @enderror

                                <div class="input-group mb-2 mx-auto" style="max-width: 300px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                    <input id="email" type="email" class="form-control @error('login') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Direccion de Email" required>
                                </div>

                                <div class="input-group mb-2 mx-auto" style="max-width: 300px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                    <input name="password" id="password" type="hidden">
                                    <input id="pass" type="password" class="form-control @error('login') is-invalid @enderror" placeholder="Contraseña" required>
                                </div>
                                
                                <div class="input-group mx-auto" style="max-width: 300px;">
                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                                </div>

                                <div class="custom-control custom-switch mt-2">
                                    <input type="checkbox" class="custom-control-input" name="remember" id="remember">
                                    <label class="custom-control-label" for="remember">Recuerdame</label>
                                </div>
                                <br>

                                <div class="row justify-content-center">
                                    <p>¿No tienes una cuenta? <a href="{{url('/')}}/register" class="link">¡Registrate ahora!</a></p>
                                </div>
                                <p class="mb-3 text-muted">© 2019 - <?=date("Y")?></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{url('/')}}/plugins/jquery/jquery.min.js"></script>
        <script src="{{url('/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{url('/')}}/plugins/md5/main.js"></script>

        <script>
            $('#login').submit(function() {
                var password = document.getElementById('pass');
                var passwordHidden = document.getElementById('password');
                passwordHidden.value = MD5(password.value);
            })
        </script>
    </body>
</html>

