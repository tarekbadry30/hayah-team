<!DOCTYPE html>
<html lang="{{LaravelLocalization::getCurrentLocale()}}" dir="{{LaravelLocalization::getCurrentLocaleDirection()}}">
    <head>
        <meta charset="utf-8" />
        <title>test v2</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="keywords" />
        <meta content="" name="author" />

        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <![endif]-->

        <!-- CSS Files
    ================================================== -->
        <link href="{{asset('front_website/')}}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/css/bootstrap-grid.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/css/bootstrap-reboot.min.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/css/animate.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/css/owl.carousel.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/css/owl.theme.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/css/owl.transitions.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/css/magnific-popup.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/css/jquery.countdown.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/css/style.css" rel="stylesheet" type="text/css" />

        <!-- color scheme -->
        <link id="colors" href="{{asset('front_website/')}}/css/colors/scheme-01.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/css/coloring.css" rel="stylesheet" type="text/css" />

        <!-- RS5.0 Stylesheet -->
        <link href="{{asset('front_website/')}}/revolution/css/settings.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/revolution/css/layers.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/revolution/css/navigation.css" rel="stylesheet" type="text/css" />
        <link href="{{asset('front_website/')}}/css/rev-settings.css" rel="stylesheet" type="text/css" />
        <style>
            .second-color{
                color: #515c6a;
            }
            @font-face {
                font-family: 'arabicFont'; /*a name to be used later*/
                src: url('{{asset('/fonts/janna.ttf')}}'); /*URL to font*/
            }
            @font-face {
                font-family: 'arabicBoldFont'; /*a name to be used later*/
                src: url('{{asset('/fonts/janna-bold.ttf')}}'); /*URL to font*/
            }
            .arabic{
                font-family: arabicFont;
                letter-spacing: 2px;
            }
            .arabic-bold{
                font-family: arabicBoldFont;
                letter-spacing: 2px;
            }
            #contact_form .field-set{
                margin-bottom: 10px;
            }
           #contact_form  .field-set label{
                margin-bottom: 0;
               color:#ff0000 !important;
            }
            #contact_form input,
            #contact_form textarea{
                padding-bottom: 10px;
                margin-bottom: 0px;
            }
        </style>
    </head>

    <body>
    <div id="wrapper">

    @include('FrontWebsite.includes.header')
        @yield('slider')
        @yield('about')
        @yield('projects')
        @yield('contact')
    </div>
    <!-- content close -->

    <!-- footer begin -->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 sm-text-center mb-sm-30">
                    &copy; Copyright {{date('Y')}} - Jess by Designesia
                </div>

                <div class="col-md-6 text-md-right text-sm-left">
                    <div class="social-icons">
                        @foreach($links as $link)
                        <a href="{{$link->link}}" target="_blank"><i class="fa fa-{{in_array($link->type,['website','other'])?'internet-explorer':$link->type}} fa-lg"></i></a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer close -->

    <a href="#" id="back-to-top"></a>

    <div id="preloader">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <script src="{{asset('front_website/')}}/js/jquery.min.js"></script>
    <script src="{{asset('front_website/')}}/js/bootstrap.min.js"></script>
    <script src="{{asset('front_website/')}}/js/wow.min.js"></script>
    <script src="{{asset('front_website/')}}/js/jquery.isotope.min.js"></script>
    <script src="{{asset('front_website/')}}/js/easing.js"></script>
    <script src="{{asset('front_website/')}}/js/owl.carousel.js"></script>
    <script src="{{asset('front_website/')}}/js/validation.js"></script>
    <script src="{{asset('front_website/')}}/js/jquery.magnific-popup.min.js"></script>
    <script src="{{asset('front_website/')}}/js/enquire.min.js"></script>
    <script src="{{asset('front_website/')}}/js/jquery.stellar.min.js"></script>
    <script src="{{asset('front_website/')}}/js/jquery.plugin.js"></script>
    <script src="{{asset('front_website/')}}/js/typed.js"></script>
    <script src="{{asset('front_website/')}}/js/typed-custom.js"></script>
    <script src="{{asset('front_website/')}}/js/jquery.countTo.js"></script>
    <script src="{{asset('front_website/')}}/js/jquery.countdown.js"></script>
    <script src="{{asset('front_website/')}}/js/designesia.js"></script>

    <!-- RS5.0 Core JS Files -->
    <script src="{{asset('front_website/')}}/revolution/js/jquery.themepunch.tools.min.js?rev=5.0"></script>
    <script src="{{asset('front_website/')}}/revolution/js/jquery.themepunch.revolution.min.js?rev=5.0"></script>

    <!-- RS5.0 Extensions Files -->
    <script src="{{asset('front_website/')}}/revolution/js/extensions/revolution.extension.video.min.js"></script>
    <script src="{{asset('front_website/')}}/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="{{asset('front_website/')}}/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="{{asset('front_website/')}}/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
    <script src="{{asset('front_website/')}}/revolution/js/extensions/revolution.extension.actions.min.js"></script>
    <script src="{{asset('front_website/')}}/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script src="{{asset('front_website/')}}/revolution/js/extensions/revolution.extension.migration.min.js"></script>
    <script src="{{asset('front_website/')}}/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
    <!-- current page only scripts -->

    <script>
        var tpj = jQuery;

        var revapi1083;
        tpj(document).ready(function () {
            if (tpj("#rev_slider_1083_1").revolution == undefined) {
                revslider_showDoubleJqueryError("#rev_slider_1083_1");
            } else {
                revapi1083 = tpj("#rev_slider_1083_1")
                    .show()
                    .revolution({
                        sliderType: "standard",
                        jsFileLocation: "revolution/js/",
                        sliderLayout: "fullscreen",
                        dottedOverlay: "none",
                        delay: 6000,
                        navigation: {
                            keyboardNavigation: "off",
                            keyboard_direction: "horizontal",
                            mouseScrollNavigation: "off",
                            mouseScrollReverse: "default",
                            onHoverStop: "off",
                            touch: {
                                touchenabled: "on",
                                swipe_threshold: 75,
                                swipe_min_touches: 1,
                                swipe_direction: "horizontal",
                                drag_block_vertical: false,
                            },
                            bullets: {
                                enable: true,
                                hide_onmobile: true,
                                hide_under: 600,
                                style: "hermes",
                                hide_onleave: true,
                                hide_delay: 200,
                                hide_delay_mobile: 1200,
                                direction: "vertical",
                                h_align: "right",
                                v_align: "center",
                                h_offset: 30,
                                v_offset: 0,
                                space: 5,
                                tmp: "",
                            },
                        },
                        viewPort: {
                            enable: true,
                            outof: "pause",
                            visible_area: "80%",
                            presize: false,
                        },
                        responsiveLevels: [1360, 1024, 778, 480],
                        visibilityLevels: [1360, 1024, 778, 480],
                        gridwidth: [1360, 1024, 778, 480],
                        gridheight: [700, 600, 500, 400],
                        lazyType: "none",
                        parallax: {
                            type: "mouse",
                            origo: "slidercenter",
                            speed: 2000,
                            levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50, 46, 47, 48, 49, 50, 55],
                            type: "mouse",
                        },
                        shadow: 0,
                        spinner: "off",
                        stopLoop: "off",
                        stopAfterLoops: -1,
                        stopAtSlide: -1,
                        shuffle: "off",
                        autoHeight: "off",
                        hideThumbsOnMobile: "off",
                        hideSliderAtLimit: 0,
                        hideCaptionAtLimit: 0,
                        hideAllCaptionAtLilmit: 0,
                        debugMode: false,
                        fallbacks: {
                            simplifyAll: "off",
                            nextSlideOnWindowFocus: "off",
                            disableFocusListener: false,
                        },
                    });
            }
        }); /*ready*/
    </script>
    </body>
</html>
