<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
  @section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="MOFAD">
    <meta name="keywords" content="MOFAD">
    <meta name="author" content="MOFAD">
    <title>MOFAD</title>

    <link rel="apple-touch-icon" href="{{asset('/app-assets/images/favicon/apple-touch-icon-152x152.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/app-assets/images/favicon/favicon-32x32.png')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/vendors.min.css')}}">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/themes/vertical-gradient-menu-template/materialize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/themes/vertical-gradient-menu-template/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/pages/login.css')}}">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/custom/custom.css')}}">
    <!-- END: Custom CSS-->
    @show()
</head>
<!-- END: Head-->
@section('content')
      <body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 1-column login-bg   blank-page blank-page" data-open="click" data-menu="vertical-gradient-menu" data-col="1-column">
        <div class="row">
        
          <div class="col s12">
            <div class="container">
                <div id="login-page" class="row">
                    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                    @if (session('status'))
                    <div class="card-alert card green">
                        <div class="card-content white-text">
                            <p> {{ session('status') }} </p>
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                        
                    @endif

                    @if (count($errors) > 0)
                    <div class="card-alert card red">
                        <div class=" card-content white-text">
                        
                            @foreach ($errors->all() as $error)
                            <p> - {{ $error }}</p>
                            @endforeach
                        
                        </div>
                        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    
                    @endif
                        <form method="POST" action="{{ route('password.email') }}" class="login-form">
                        {{csrf_field()}}
                            <div class="row">
                                <div class="input-field col s12">
                                    <h5 class="ml-4 center-align ">Reset Password</h5>
                                </div>
                            </div>
                            <div class="row margin">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">person_outline</i>
                                    <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus >
                                    <label for="email" class="center-align">Email</label>
                                    @error('email')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror
                                </div>
                            </div>
                           
                            
                            <div class="row">
                                <div class="input-field col s12">
                                    <button  class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Send Password Reset Link</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
            <div class="content-overlay"></div>
        </div>
        </div>

      
        <!-- BEGIN VENDOR JS-->
      
      @show
      @section('footer_scripts')      
        <script src="{{asset('/app-assets/js/vendors.min.js')}}"></script>
      <!-- BEGIN VENDOR JS-->
      <!-- BEGIN PAGE VENDOR JS-->
      <!-- END PAGE VENDOR JS-->
      <!-- BEGIN THEME  JS-->
      <script src="{{asset('/app-assets/js/plugins.js')}}"></script>
      <script src="{{asset('/app-assets/js/search.js')}}"></script>
      <script src="{{asset('/app-assets/js/custom/custom-script.js')}}"></script>
      <!-- END THEME  JS-->
      <!-- BEGIN PAGE LEVEL JS-->
      <!-- END PAGE LEVEL JS-->
      @show
      </body>

      </html>



