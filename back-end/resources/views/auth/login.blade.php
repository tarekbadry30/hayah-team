@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card">
                <div class="card-body">
                    <div class="px-2 py-3">


                        <div class="text-center">
                            <a href="/">
                                <img src="{{asset('assets/images/logo-dark.png')}}" height="22" alt="logo">
                            </a>

                            <h5 class="text-primary mb-2 mt-4">{{__('frontend.welcomeBack')}}</h5>
                        </div>


                        <form class="form-horizontal mt-4 pt-2" method="post" action="{{route('login')}}">
                            @csrf
                            <div class="mb-3">
                                <label for="phone">{{__('frontend.phone')}}</label>
                                <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                       placeholder="{{__('frontend.enter')}} {{__('frontend.phone')}}">
                                @error('phone')
                                <div class="invalid-feedback" >
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password">{{__('frontend.password')}}</label>
                                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                                       placeholder="{{__('frontend.enter')}} {{__('frontend.password')}}">
                                @error('password')
                                <div class="invalid-feedback" >
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input"
                                           id="customControlInline">
                                    <label class="form-label"
                                           for="customControlInline">{{__('frontend.rememberMe')}}</label>
                                </div>
                            </div>

                            <div>
                                <button class="btn btn-primary w-100 waves-effect waves-light"
                                        type="submit">{{__('frontend.login')}}</button>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="mt-4 text-center">
                                    <a href="{{route('password.request')}}" class="text-muted"><i class="mdi mdi-lock me-1"></i> {{__('frontend.forgotPassword')}}</a>
                                </div>
                            @endif

                        </form>

                        <div class="mt-5 text-center">
                            @if(Route::has('register'))
                                <p>Don't have an account ?<a href="auth-register.html" class="fw-bold"> Register</a> </p>
                            @endif
                            <p>© <script>document.write(new Date().getFullYear())</script> {{config()->get('app.name')}}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
