<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>Forgot Password - {{ Voyager::setting("admin.title") }}</title>
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">
    @if (__('voyager::generic.is_rtl') == 'true')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif
    <style>
        body{background-image:url('{{ Voyager::image( Voyager::setting("admin.bg_image"), voyager_asset("images/bg.jpg") ) }}');background-color:{{Voyager::setting("admin.bg_color","#FFFFFF")}}}body.login .login-sidebar{border-top:5px solid{{config('voyager.primary_color','#22A7F0')}}}@media (max-width:767px){body.login .login-sidebar{border-top:0px!important;border-left:5px solid{{config('voyager.primary_color','#22A7F0')}}}}body.login .form-group-default.focused{border-color:{{config('voyager.primary_color','#22A7F0')}}}.login-button,.bar:before,.bar:after{background:{{config('voyager.primary_color','#22A7F0')}}}.remember-me-text{padding:0 5px}.extra-controls{position:relative;width:100%}.extra-controls input{display:none}.extra-controls #password_toggler{cursor:pointer;position:absolute;right:0;top:-25px}.extra-controls #password_toggler svg{width:18px;height:18px;fill:#666}.extra-controls #password_toggler:hover svg{fill:#222}
    </style>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
</head>
<body class="login">
<div class="container-fluid">
    <div class="row">
        <div class="faded-bg animated"></div>
        <div class="hidden-xs col-sm-7 col-md-8">
            <div class="clearfix">
                <div class="col-sm-12 col-md-10 col-md-offset-2">
                    <div class="logo-title-container">
                        @php $admin_logo_img = Voyager::setting('admin.icon_image', ''); @endphp
                        @if($admin_logo_img == '')
                        <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{ voyager_asset('images/logo-icon-light.png') }}" alt="Logo Icon">
                        @else
                        <img class="img-responsive pull-left flip logo hidden-xs animated fadeIn" src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                        @endif
                        <div class="copy animated fadeIn">
                            <h1>{{ Voyager::setting('admin.title', 'Voyager') }}</h1>
                            <p>{{ Voyager::setting('admin.description', __('voyager::login.welcome')) }}</p>
                        </div>
                    </div> <!-- .logo-title-container -->
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">

            <div class="login-container">

                <p>Reset your password</p>

                <form action="{{ route('voyager.forgot_password.reset') }}" method="POST">
                    @csrf
                    <div class="form-group form-group-default" id="emailGroup">
                        <label>{{ __('voyager::generic.email') }}</label>
                        <div class="controls">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('voyager::generic.email') }}" class="form-control" required>
                         </div>
                    </div>

                    <div class="form-group" id="rememberMeGroup">
                        <div class="controls">
                            <a href="{{ route('voyager.login') }}">Back to Login</a>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-block login-button">
                        <span class="signingin hidden"><span class="voyager-refresh"></span> Requesting Reset...</span>
                        <span class="signin">Request Reset</span>
                    </button>

              </form>

              <div style="clear:both"></div>

              @if(!$errors->isEmpty())
              <div class="alert alert-{{ $errors->has('success') ? 'success' : 'red'}}">
                <ul class="list-unstyled">
                    @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
              </div>
              @endif
            </div> <!-- .login-container -->

        </div> <!-- .login-sidebar -->
    </div> <!-- .row -->
</div> <!-- .container-fluid -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" SameSite=None></script>
<script>
    var btn = document.querySelector('button[type="submit"]');
    var form = document.forms[0];
    var email = document.querySelector('[name="email"]');
    btn.addEventListener('click', function(ev){
        if (form.checkValidity()) {
            btn.querySelector('.signingin').className = 'signingin';
            btn.querySelector('.signin').className = 'signin hidden';
        } else {
            ev.preventDefault();
        }
    });
    email.focus();
    document.getElementById('emailGroup').classList.add("focused");

    // Focus events for email and password fields
    email.addEventListener('focusin', function(e){
        document.getElementById('emailGroup').classList.add("focused");
    });
    email.addEventListener('focusout', function(e){
       document.getElementById('emailGroup').classList.remove("focused");
    });
</script>
</body>
</html>
