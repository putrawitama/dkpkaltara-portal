<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Security-Policy" content="img-src * 'self' data: https:; default-src *; style-src 'self' http://* 'unsafe-inline'; script-src 'self' http://* 'unsafe-inline' 'unsafe-eval'" />
    <meta charset="UTF-8">
    <meta name="base" content="{{URL::route('landing.main')}}" />
    <meta name="baseImage" content="{{ url('storage') }}" />
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/logo/favicon.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('plugin/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugin/bootstrap-4.3.1/css/bootstrap.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/sweetalert2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('plugin/toastr/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/sb-admin-2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">
    <title>DKP Kaltara</title>
</head>
<body style="background-color:#F2FAFA;">
    <div class="container-fluid pt-5">
        <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white shadow-lg py-3">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('img/logo/logo_banner.png') }}" height="40" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto topnav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="galeriPage" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Galeri</a>
                        <div class="dropdown-menu" aria-labelledby="galeriPage">
                            <a class="dropdown-item" href="{{ route('landing.gallery.detail', ['type' => 'photo']) }}">Foto</a>
                            <a class="dropdown-item" href="{{ route('landing.gallery.detail', ['type' => 'video']) }}">Video</a>
                        </div>
                    </li>
                    
                    @for ($i = 0; $i < count($menu); $i++)
                    @if (count($menu[$i]->subMenu) > 1)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbar{{$i}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $menu[$i]->name }}</a>
                        <div class="dropdown-menu" aria-labelledby="navbar{{$i}}">
                        @for ($j = 0; $j < count($menu[$i]->subMenu); $j++)
                            <a class="dropdown-item" href="{{ route('landing.detail', ['menu' => $menu[$i]->subMenu[$j]->slug]) }}">{{ $menu[$i]->subMenu[$j]->name }}</a>
                        @endfor
                        </div>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('landing.detail', ['menu' => $menu[$i]->subMenu[0]->slug]) }}">{{ $menu[$i]->name }}</a>
                    @endif
                    </li>
                    @endfor

                    <li class="nav-item">
                        <a class="nav-link" href="/kontak">Kontak</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="row">
            <div class="jumbotron jumbotron-fluid w-100 mt-5 mb-0 text-center" style="background-color:#F2FAFA;">
                <div class="container">
                    <img src="{{ asset('img/logo/logo.png') }}" height="200" alt="">
                    <h1 class="display-4 mt-4 font-weight-bold text-dark">DINAS KELAUTAN DAN PERIKANAN</h1>
                    <p class="h4">Provinsi Kalimantan Utara</p>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <footer class="sticky-footer mt-5 w-100" style="background-color: #004385;">
        <div class="container my-auto">
            <div class="row text-white mb-5 mt-3">
                <div class="col-md-6">
                    <h4 class="mt-3">DKP Kaltara</h4>
                    <img src="{{ asset('img/logo/logo_banner.png') }}" height="50" alt="">
                </div>
                <div class="col-md-3">
                    <h4 class="mt-3">Menu</h4>
                    <ul class="pl-0" style="list-style:none;">
                    @for ($i = 0; $i < count($menu); $i++)
                        <li><a href="{{ route('landing.detail', ['menu' => $menu[$i]->subMenu[0]->slug]) }}" class="text-light">{{ $menu[$i]->name }}</a></li>
                    @endfor
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="mt-3">Address</h4>
                    <ul class="pl-0" style="list-style:none;">
                        <li>Jl. Sengkawit, Tj. Selor Hilir, Tj. Selor, Kabupaten Bulungan, Kalimantan Utara 77216</li>
                    </ul>
                </div>
            </div>
            <div class="copyright text-center my-auto text-white">
                <span>Copyright &copy; Dinas Kelautan dan Perikanan Kalimantan Utara {{ date('Y') }}</span>
            </div>
        </div>
    </footer>
    <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v11.0" nonce="E8iZEd5M"></script>
<script src="{{asset('plugin/jquery/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('plugin/popper/popper.min.js')}}"></script>
<script src="{{asset('plugin/bootstrap-4.3.1/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugin/crypto-js/crypto-js.js') }}"></script>
<script src="{{asset('plugin/toastr/toastr.min.js')}}"></script>
<script src="{{asset('plugin/raphael/raphael.js')}}"></script>
<script src="{{asset('js/sweetalert2.min.js')}}"></script>
<script src="{{asset('plugin/moment/moment.js')}}"></script>
<script src="{{asset('js/sb-admin-2.min.js')}}"></script>
<script src="{{asset('js/all.js')}}"></script>
</body>
</html>