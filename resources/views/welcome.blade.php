<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>Login | E-BMS</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.css?ver=3.2.3">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=3.2.3">
</head>

<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-split nk-split-page nk-split-lg">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em class="icon ni ni-info"></em></a>
                            </div>
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="{{route('home')}}" class="logo-link">
                                        <img class="logo-dark logo-img logo-img-lg" src="./images/logo-bms.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                                    </a>
                                </div>
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Sign-In</h5>
                                        <div class="nk-block-des">
                                            <p>Access the E-BMS panel using your email and password.</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <form method="POST"  class="form-validate is-alter" autocomplete="off" action="{{ route('login') }}">
                                    @csrf
                                                <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email-address">Email </label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input id="email" autocomplete="email" type="email" class="form-control  @error('email') is-invalid @enderror form-control-lg" name="email" value="{{ old('email') }}" required autofocus required placeholder="Enter your email address or username">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="javascript:void(0);" class="form-icon form-icon-right password-switch lg" data-target="password">
                                                <em class="password-icon icon-show icon ni ni-eye"></em>
                                                <em class="password-icon icon-hide icon ni ni-eye-off" style="display:none;"></em>
                                            </a>
                                            <input id="password" autocomplete="current-password" name="password" required
                                                type="password" class="form-control @error('password') is-invalid @enderror form-control-lg"
                                                placeholder="Enter your password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                      
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary btn-block">Sign in</button>
                                    </div>
                                </form><!-- form -->
                               
                                
                              
                                
                            </div><!-- .nk-block -->
                           
                        </div><!-- .nk-split-content -->
                        <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right" data-toggle-body="true" data-content="athPromo" data-toggle-screen="lg" data-toggle-overlay="true">
                            <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
                                <div >
                                    <div class="">
                                        <div class="nk-feature nk-feature-center">
                                            <div class="nk-feature-img">
                                                <img class="round" src="./images/slides/back-slide.jpeg" srcset="./images/slides/promo-a2x.png 2x" alt="">
                                            </div>
                                            <div class="nk-feature-content py-4 p-sm-5">
                                                <h4>E-BMS</h4>
                                                <p>Electricity Billing Management System .</p>
                                            </div>
                                        </div>
                                    </div><!-- .slider-item -->
                                   
                                </div><!-- .slider-init -->
                              
                            </div><!-- .slider-wrap -->
                        </div><!-- .nk-split-content -->
                    </div><!-- .nk-split -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.2.3"></script>
    <script src="./assets/js/scripts.js?ver=3.2.3"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('.password-switch');
    const passwordField = document.getElementById('password');
    const showIcon = togglePassword.querySelector('.icon-show');
    const hideIcon = togglePassword.querySelector('.icon-hide');

    togglePassword.addEventListener('click', function() {
        // Toggle the type attribute
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        // Toggle the icon visibility
        showIcon.style.display = type === 'password' ? 'block' : 'none';
        hideIcon.style.display = type === 'password' ? 'none' : 'block';
    });
});

    </script>

</html>