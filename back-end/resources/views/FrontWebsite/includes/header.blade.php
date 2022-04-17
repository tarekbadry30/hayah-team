<div class="page-overlay">
    <div class="preloader-wrap">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
</div>

<!-- header begin -->
<header class="header-light transparent scroll-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <div class="align-self-center header-col-left">
                        <!-- logo begin -->
                        <div id="logo">
                            <a href="/">
                                <img style="max-width: 75px;" src="{{asset('/logo.png')}}">
                            </a>
                        </div>
                        <!-- logo close -->
                    </div>
                    <div class="align-self-center ml-auto header-col-mid">
                        <!-- mainmenu begin -->
                        <ul id="mainmenu" class="scrollnav {{LaravelLocalization::getCurrentLocale()=='ar'?'text-right pl-5':'pr-4'}}">
                            <li><a href="#section-hero" class="active">{{__('website.home')}}</a></li>
                            <li></li>
                            <li><a href="#section-about">{{__('website.about')}}</a></li>
                            <li></li>
                            <li class="d-none"><a href="#section-services">Services</a></li>
                            <li></li>
                            <li><a href="#section-portfolio">{{__('website.portfolio')}}</a></li>
                            <li></li>
                            <li></li>
                            <li><a href="#section-contact">{{__('website.contactUs')}}</a></li>
                            <li></li>
                            <li>
                                <a  @php
                                   $localeCode=LaravelLocalization::getCurrentLocale();
                                   $localeInverseCode=$localeCode=='en'?'ar':'en';
                                   $lang=$localeCode=='ar'?'English':'العربية';
                                   @endphp
                                   href="{{ LaravelLocalization::getLocalizedURL($localeInverseCode, null, [], true) }}">
                                    <img src="/assets/images/flags/{{ $localeCode=='en'?'oman.png':'us.jpg' }}" alt="user-image" class="me-1" height="12"> {{ $lang }}
                                </a>
                            </li>
                        </ul>

                        <!-- mainmenu close -->
                    </div>
                    <div class="align-self-center {{LaravelLocalization::getCurrentLocale()=='ar'?'mr-auto':'ml-auto'}} header-col-right">
                        <div class="social-icons">
                            @foreach($links as $link)
                                <a href="{{$link->link}}" target="_blank"><i class="fa fa-{{in_array($link->type,['website','other'])?'internet-explorer':$link->type}} fa-lg"></i></a>
                            @endforeach
                        </div>

                        <span id="menu-btn"></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header close -->
