
<!doctype html>
<html lang="en">
<head>
<title>DLC Ikeja Cooperative</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="The Complete Cooperative App for Nigerian Cooperatives and Society">
<meta name="author" content="Squarem Limited">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
<!-- MAIN CSS -->
<link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
<link rel="stylesheet" href="{{asset('main/css/font-awesome.min.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="theme-green">
<!-- Overlay For Sidebars -->
<div id="corner">
    <div id="wrapper">
        @include('partials.backend.header')
        @include('partials.backend.sidebar')
        <div id="main-content">
            <div class="container-fluid">
                <router-view></router-view>
                <vue-progress-bar></vue-progress-bar>        
            </div>
        </div>
    </div>   
</div>

<script src="{{asset('/js/app.js')}}"></script>   
<script src="{{asset('assets/bundles/libscripts.bundle.js')}}"></script>    
<script src="{{asset('assets/bundles/vendorscripts.bundle.js')}}"></script>
<script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"></script> 
</body>
</html>