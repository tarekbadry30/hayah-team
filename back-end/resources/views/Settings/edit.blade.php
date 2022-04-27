@extends('layouts.app')
@section('content')
    <form novalidate  class="create-form pt-3 {{session()->has('errorsq')?'was-validated':''}}" action="{{route('settings.update',['setting'=>$setting])}}" method="post">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        <h4 class="header-title">{{__('frontend.general')}}</h4>
                        <input type="hidden" name="id" value="{{$setting->id}}">
                        <!-- Nav tabs -->
                        <div class="row mb-3 d-none">
                            <label for="name" class="col-sm-2 col-form-label">{{__('frontend.img')}}</label>
                            <div class="col-sm-10 position-relative">
                                <img src="{{asset($setting->img)}}" class="avatar-lg">
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            @foreach(config('translatable.locales') as $locale)
                                <li class="nav-item" {{$errorsCount=0}}>
                                    <a errors-count="{{$errorsCount=substr_count(implode(" ",array_keys($errors->toArray())),"$locale.")}}" class="{{$errorsCount>0?'nav-errors':''}} nav-link {{$locale==app()->getLocale()?'active':''}} " data-bs-toggle="tab" href="#{{$locale}}" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">
                                        @lang('frontend.'.$locale.'.locale')
                                        <span class="badge rounded-pill bg-danger py-1 {{$errorsCount>0?'':'d-none'}}" >{{$errorsCount}}</span>
                                    </span>
                                    </a>
                                </li>
                            @endforeach

                        </ul>

                        <!-- Tab panes -->
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">{{__('frontend.projectName')}}</label>
                            <div class="col-sm-10 position-relative">
                                <input class="form-control @error('name') parsley-error is-invalid @enderror"
                                       value="{{old('name',$setting->name)}}"  type="text" placeholder="{{__('frontend.name')}}"
                                       id="name" name="name"/>
                                @error('name')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="tab-content text-muted pt-2">
                            @foreach(config('translatable.locales') as $locale)

                                <div class="tab-pane {{$locale==app()->getLocale()?'active':''}}" id="{{$locale}}" role="tabpanel">
                                    <div class="row mb-3">
                                        <label for="name" class="col-sm-2 col-form-label">{{__('frontend.'.$locale.'.about')}}</label>
                                        <div class="col-sm-10 position-relative">
                                            <textarea class="form-control @error($locale.'.about') parsley-error is-invalid @enderror"  placeholder="{{__('frontend.'.$locale.'.about')}}"
                                                      name="{{$locale}}[about]">{{old($locale.'.about',$setting->translate($locale)->about)}}</textarea>
                                            @error($locale.'.about')
                                            <div class="invalid-tooltip position-static">
                                                {{$message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name" class="col-sm-2 col-form-label">{{__('frontend.'.$locale.'.vision')}}</label>
                                        <div class="col-sm-10 position-relative">
                                            <textarea class="form-control @error($locale.'.vision') parsley-error is-invalid @enderror"  placeholder="{{__('frontend.'.$locale.'.vision')}}"
                                                    name="{{$locale}}[vision]">{{old($locale.'.vision',$setting->translate($locale)->vision)}}</textarea>
                                            @error($locale.'.vision')
                                            <div class="invalid-tooltip position-static">
                                                {{$message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="name" class="col-sm-2 col-form-label">{{__('frontend.'.$locale.'.goals')}}</label>
                                        <div class="col-sm-10 position-relative">
                                            <textarea class="form-control @error($locale.'.goals') parsley-error is-invalid @enderror"  placeholder="{{__('frontend.'.$locale.'.goals')}}"
                                                    name="{{$locale}}[goals]">{{old($locale.'.goals',$setting->translate($locale)->goals)}}</textarea>
                                            @error($locale.'.goals')
                                            <div class="invalid-tooltip position-static">
                                                {{$message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                        </div>

                        <div class="row mb-3 justify-content-center">
                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light col-sm-3 mx-1">
                                {{__('frontend.save')}}</button>
                            <a href="{{route('settings.index')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

                        </div>


                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            console.clear()
            console.log('init 1')
            $(".select2-search-disable").select2();
        })
    </script>
@endsection
