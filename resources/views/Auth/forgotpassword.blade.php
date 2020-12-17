<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title><?php echo env('APP_NAME') ?> - Cambio de Contraseña</title>
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
                        <form action="{{route('reset.sendMail')}}" method="GET"> 
                            @csrf 
                            <div class="card-header text-center p-4">
                                <strong> Cambiar Contraseña </strong>
                            </div>
                        
                                          
                            <div class="card-body text-center p-4">                    
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

                                <label for="email">Direccion de Email</label>
                                <div class="input-group mb-2 mx-auto" style="max-width: 300px;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope-open-text"></i>
                                        </span>
                                    </div>

                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Enviar</button>
                                <a href="<?= (url()->previous() != Illuminate\Support\Facades\URL::current() ? url()->previous() : url('/')) ?>" class="btn btn-light">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{url('/')}}/plugins/jquery/jquery.min.js"></script>
        <script src="{{url('/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>
</html>