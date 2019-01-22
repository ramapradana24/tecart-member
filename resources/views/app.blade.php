<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('tecart-png.png')}}">
    <title>Technology Artisan</title>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css')}}"/>
    <link href="https://cdn.materialdesignicons.com/3.3.92/css/materialdesignicons.min.css"
      rel="stylesheet">
    {{-- <link rel="stylesheet" type="text/css" href="{{asset("assets/lib/material-design-icons/css/material-design-iconic-font.min.css")}}"/><!--[if lt IE 9]> --}}
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" type="text/css"/>
  </head>
  <body class="be-splash-screen">
    <div class="be-wrapper be-login be-signup">
      <div class="be-content">
        <div class="main-content container-fluid">
          <div id="app">
            <router-view></router-view>
          </div>
        </div>
      </div>
    </div>
    <script src="{{asset('assets/lib/jquery/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/main.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/lib/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//initialize the javascript
      	App.init();
      	
      });
    </script>
  </body>
</html>