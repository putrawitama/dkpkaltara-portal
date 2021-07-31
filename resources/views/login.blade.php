<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Security-Policy" content="img-src * 'self' data: https:; default-src *; style-src 'self' http://* 'unsafe-inline'; script-src 'self' http://* 'unsafe-inline' 'unsafe-eval'" />
    <meta charset="UTF-8">
    <meta name="base" content="{{URL::route('home')}}" />
    <meta name="baseImage" content="{{ url('storage') }}" />
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('image/favicon/android-chrome-192x192.png') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/sweetalert2.min.css')}}" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/sb-admin-2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/login.min.css')}}" />
    <title>Kosmetik</title>
</head>
<div id="loading-overlay">
    <div class="loader"></div>
</div>

<body class="bg-gradient-primary">
    <div class="wrapper h-100" id="main-wrapper">
        @php $notif = session('notif'); @endphp
        @if ($notif)
        <div id="notif" data-status="{!! $notif['status'] !!}" data-message="{!! $notif['message'] !!}" data-url="{!! $notif['url'] !!}">
        </div>
        @endif
        
        <div class="container h-100">
            <!-- Outer Row -->
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="my-5">
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                            </div>
                                            <form class="user" id="formLogin" action="{{ route('post.login') }}" method="POST" ajax="true">
                                                <div class="form-group">
                                                    <input type="email" name="email" id="email" class="form-control form-control-user w-100"
                                                        id="exampleInputEmail" aria-describedby="emailHelp"
                                                        placeholder="Enter Email Address...">
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" name="password" id="password" class="form-control form-control-user w-100"
                                                        id="exampleInputPassword" placeholder="Password">
                                                </div>
                                                <div class="mt-5"></div>
                                                <!-- <div class="form-group">
                                                    <div class="custom-control custom-checkbox small">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                                        <label class="custom-control-label" for="customCheck">Remember
                                                            Me</label>
                                                    </div>
                                                </div> -->
                                                <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                            </form>
                                            <hr>
                                            <div class="text-center">
                                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                                            </div>
                                            <div class="text-center">
                                                <!-- <a class="small" href="register.html">Create an Account!</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div id="modalSession" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <p class="p-session">Anda sudah tidak aktif selama 15 menit. Silahkan login kembali</p>
                            <center>
                                <button class="btn btn-success" id="btnSession" onclick="reload();">Login</button>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('modal')

    @show
</body>

<script src="{{asset('plugin/jquery/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('plugin/popper/popper.min.js')}}"></script>
<script src="{{asset('plugin/bootstrap-4.3.1/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugin/crypto-js/crypto-js.js') }}"></script>
<script type="text/javascript" src="{{asset('plugin/jquery-validate/dist/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{asset('plugin/jquery-validate/dist/additional-methods.js') }}"></script>
<script src="{{asset('plugin/toastr/toastr.min.js')}}"></script>
<script src="{{asset('plugin/raphael/raphael.js')}}"></script>
<script src="{{asset('js/sweetalert2.min.js')}}"></script>
<script src="{{asset('plugin/mask/jquery.mask.min.js')}}"></script>
<script src="{{asset('plugin/moment/moment.js')}}"></script>
<script src="{{asset('js/all.js')}}"></script>
</html>
