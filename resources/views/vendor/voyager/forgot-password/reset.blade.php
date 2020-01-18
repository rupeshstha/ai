<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="admin login">
    <title>Reset Password - {{ Voyager::setting("admin.title") }}</title>
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

                <p>Reset password for <u style="text-transform: none;">{{ $passwordReset->email }}</u></p>

                <form action="{{ route('admin.forgot_password.update', $passwordReset->token) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group form-group-default" id="passwordGroup">
                        <label>{{ __('voyager::generic.password') }}</label>
                        <div class="controls">
                            <input type="password" name="password" placeholder="{{ __('voyager::generic.password') }}" class="form-control" required>
                        </div>
                        <div class="extra-controls">
                            <input type="checkbox" name="password_toggle" id="password_toggle" class="">
                            <label for="password_toggle" id="password_toggler" title="">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d=""/></svg>
                            </label>
                        </div>
                    </div>
                    <div class="form-group form-group-default" id="passwordGroup">
                        <label>Confirm Password</label>
                        <div class="controls">
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group" id="rememberMeGroup">
                        <div class="controls">
                            <a href="{{ route('voyager.login') }}">Back to Login</a>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-block login-button">
                        <span class="signingin hidden"><span class="voyager-refresh"></span> Reseting Password...</span>
                        <span class="signin">Reset Password</span>
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
    var password = document.querySelector('[name="password"]');
    btn.addEventListener('click', function(ev){
        if (form.checkValidity()) {
            btn.querySelector('.signingin').className = 'signingin';
            btn.querySelector('.signin').className = 'signin hidden';
        } else {
            ev.preventDefault();
        }
    });
    password.focus();

    password.addEventListener('focusin', function(e){
        document.getElementById('passwordGroup').classList.add("focused");
    });
    password.addEventListener('focusout', function(e){
       document.getElementById('passwordGroup').classList.remove("focused");
    });

    $(function() {
        var passwordApp = {
            eyeClose : "M19.604 2.562l-3.346 3.137c-1.27-.428-2.686-.699-4.243-.699-7.569 0-12.015 6.551-12.015 6.551s1.928 2.951 5.146 5.138l-2.911 2.909 1.414 1.414 17.37-17.035-1.415-1.415zm-6.016 5.779c-3.288-1.453-6.681 1.908-5.265 5.206l-1.726 1.707c-1.814-1.16-3.225-2.65-4.06-3.66 1.493-1.648 4.817-4.594 9.478-4.594.927 0 1.796.119 2.61.315l-1.037 1.026zm-2.883 7.431l5.09-4.993c1.017 3.111-2.003 6.067-5.09 4.993zm13.295-4.221s-4.252 7.449-11.985 7.449c-1.379 0-2.662-.291-3.851-.737l1.614-1.583c.715.193 1.458.32 2.237.32 4.791 0 8.104-3.527 9.504-5.364-.729-.822-1.956-1.99-3.587-2.952l1.489-1.46c2.982 1.9 4.579 4.327 4.579 4.327z",
            eyeOpen : "M12.015 7c4.751 0 8.063 3.012 9.504 4.636-1.401 1.837-4.713 5.364-9.504 5.364-4.42 0-7.93-3.536-9.478-5.407 1.493-1.647 4.817-4.593 9.478-4.593zm0-2c-7.569 0-12.015 6.551-12.015 6.551s4.835 7.449 12.015 7.449c7.733 0 11.985-7.449 11.985-7.449s-4.291-6.551-11.985-6.551zm-.015 3c-2.209 0-4 1.792-4 4 0 2.209 1.791 4 4 4s4-1.791 4-4c0-2.208-1.791-4-4-4z",
            passwordToggle : "#password_toggle",
            passwordToggler : "#password_toggler",
            passwordContainer : "[name=password]",
            iconContainer : "#password_toggler svg path",
            init() {
                this.hidePassword();
                this.binders();
            },
            binders() {
                $(this.passwordToggler).on('click', function() {
                    if ( $(passwordApp.passwordToggle).is(':checked') ) {
                        passwordApp.hidePassword();
                    } else {
                        passwordApp.showPassword();
                    }
                });
            },
            showPassword() {
                $(this.passwordToggler).attr('title', 'Hide Password');
                $(this.passwordContainer).attr('type', 'text');
                $(this.iconContainer).attr('d', this.eyeClose);
            },
            hidePassword() {
                $(this.passwordToggler).attr('title', 'Show Password');
                $(this.passwordContainer).attr('type', 'password');
                $(this.iconContainer).attr('d', this.eyeOpen);
            }
        }

        passwordApp.init();
    });
</script>
</body>
</html>
