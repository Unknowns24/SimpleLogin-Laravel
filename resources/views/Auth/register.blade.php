<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title><?php echo env('APP_NAME') ?> - Registro de Usuario</title>
        <!-- Icon -->
        <link rel="icon" href="{{url('/')}}/dist/img/logo.png">
        <link rel="stylesheet" href="{{url('/')}}/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="{{url('/')}}/dist/css/adminlte.min.css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

        <style>
            .short, .weak {
                color: red;
            }

            .good {
                color: orangered;
            }

            .strong {
                color: green;
            }
        </style>
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
                                    <input id="pass" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" required>
                                    <input name="password" id="password" type="hidden">
                                </div>
                                
                                <div class="input-group mb-2 mx-auto mt-2" style="max-width: 300px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                        <i class="fas fa-unlock"></i>
                                        </span>
                                    </div>
                                    <input id="pass-confirm" type="password" class="form-control" placeholder="Repita Contraseña" required autocomplete="new-password">
                                    <input id="password-confirm" name="password_confirmation" type="hidden">
                                </div>
                                
                                <span id="confirm" class="text-center center justify-content-center"></span>
                            
                                <div class="input-group mx-auto mt-2" style="max-width: 300px;">
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

        <script src="{{url('/')}}/plugins/jquery/jquery.min.js"></script>
        <script src="{{url('/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{url('/')}}/plugins/md5/main.js"></script>

        <script>
            $(document).ready(function() {

                $('#pass').keyup(function()
                {
                    $('#confirm').html(checkStrength($('#pass').val()));
                }); 

                $('#pass-confirm').keyup(function()
                {
                    $('#confirm').html(chekEqual($('#pass').val(), $('#pass-confirm').val()));
                }); 

                function chekEqual(str1, str2)
                {
                    if (str1 != str2)
                    {
                        $('#confirm').removeClass();
                        $('#confirm').addClass('short');
                        return "Las contraseñas no coinciden!";
                    }

                    return '';
                }

                function checkStrength(password, b = false)
                {
                    //initial strength
                    var strength = 0

                    //if the password length is less than 6, return message.
                    if (password.length < 6) {
                        if (b == false)
                        {
                            $('#confirm').removeClass()
                            $('#confirm').addClass('short')
                            return 'Contraseña muy corta!'
                        }
                        else
                        {
                            return false;
                        }
                    }

                    //length is ok, lets continue.

                    //if length is 8 characters or more, increase strength value
                    if (password.length > 7) strength += 1

                    //if password contains both lower and uppercase characters, increase strength value
                    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1

                    //if it has numbers and characters, increase strength value
                    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  strength += 1 

                    //if it has one special character, increase strength value
                    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))  strength += 1

                    //if it has two special characters, increase strength value
                    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/)) strength += 1

                    //now we have calculated strength value, we can return messages

                    //if value is less than 2
                    if (b == false) 
                    {
                        if (strength < 2 ) {
                            $('#confirm').removeClass()
                            $('#confirm').addClass('weak')
                            return 'Contraseña muy Debil!'
                        } else if (strength == 2 ) {
                            $('#confirm').removeClass()
                            $('#confirm').addClass('good')
                            return 'Contraseña Aceptable!'
                        } else {
                            $('#confirm').removeClass()
                            $('#confirm').addClass('strong')
                            return 'Contraseña Segura!'
                        }    
                    }
                    else
                    {
                        if (strength < 2 ) 
                        {
                            return false;
                        } 
                        else if (strength == 2 ) 
                        {
                            return true;
                        } 
                        else 
                        {
                            return true;
                        }
                    }
                }

                $('#register').click(function(e) {
                    e.preventDefault();

                    var password = document.getElementById('pass');
                    var password_confirm = document.getElementById('pass-confirm');
                    document.getElementById("confirm").innerHTML = "";

                    if(checkStrength(password.value, true) == true) 
                    {
                        if (password.value != password_confirm.value) 
                        {
                            $('#confirm').removeClass();
                            $('#confirm').addClass('short');
                            document.getElementById('confirm').innerHTML = "Las contraseñas no coinciden!";
                            return;
                        }
                    }
                    else
                    {
                        $('#confirm').html(checkStrength($('#pass').val()));
                        return;
                    }

                    var passwordHidden = document.getElementById('password');
                    passwordHidden.value = MD5(password.value);
                    
                    var password_confirmHidden = document.getElementById('password-confirm');
                    password_confirmHidden.value = MD5(password_confirm.value);
                    
                    $("#register").submit();
                });
            });
        </script>
    </body>
</html>
