@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <form novalidate  class="create-form pt-3 {{session()->has('errorsq')?'was-validated':''}}" action="{{route('foods.update',['food'=>$food])}}" method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" value="{{$food->id}}">
                        <h4 class="header-title">{{__('frontend.editFood')}} </h4>
                        <!-- Nav tabs -->
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">{{__('frontend.img')}}</label>
                            <div class="col-sm-10 position-relative">
                                <img src="{{asset($food->img)}}" class="avatar-lg">
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            @foreach(config('translatable.locales') as $locale)
                                <li class="nav-item">
                                    <a class="nav-link {{$locale==app()->getLocale()?'active':''}} @error($locale.'.name')alert-danger @enderror @error($locale.'.desc') alert-danger @enderror" data-bs-toggle="tab" href="#{{$locale}}" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">@lang('frontend.'.$locale.'.locale')</span>
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content text-muted pt-2">
                            @foreach(config('translatable.locales') as $locale)

                                <div class="tab-pane {{$locale==app()->getLocale()?'active':''}}" id="{{$locale}}" role="tabpanel">
                                    <div class="row mb-3">
                                        <label for="name" class="col-sm-2 col-form-label">{{__('frontend.'.$locale.'.name')}}</label>
                                        <div class="col-sm-10 position-relative">
                                            <input class="form-control @error($locale.'.name') parsley-error is-invalid @enderror"
                                                   value="{{old($locale.'.name',$food->translate($locale)->name)}}"  type="text" placeholder="{{__('frontend.'.$locale.'.name')}}"
                                                   id="name" name="{{$locale}}[name]"/>
                                            @error($locale.'.name')
                                            <div class="invalid-tooltip position-static">
                                                {{$message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="desc" class="col-sm-2 col-form-label">{{__('frontend.'.$locale.'.desc')}}</label>
                                        <div class="col-sm-10">
                                        <textarea class="form-control @error($locale.'.desc') parsley-error is-invalid @enderror"
                                                  placeholder="{{__('frontend.'.$locale.'.desc')}}" id="desc" name="{{$locale}}[desc]">{{old($locale.'.desc',$food->translate($locale)->desc)}}</textarea>
                                            @error($locale.'.desc')
                                            <div class="invalid-tooltip position-static">
                                                {{$message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="row mb-3">
                            <label for="parent_id" class="col-sm-2 col-form-label">{{__('frontend.price')}}</label>
                            <div class="col-sm-10">
                                <input name="price" type="text" class="form-control @error('price') parsley-error is-invalid @enderror " />
                                @error('price')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="type" class="col-sm-2 col-form-label">{{__('frontend.type')}}</label>
                            <div class="col-sm-10">
                                <select name="type" class="option_type form-control select2-search-disable2 @error('type') parsley-error is-invalid @enderror ">
                                    <option {{old('type',$food->type)=='eat'?'selected':''}} value="eat">{{__('frontend.eat')}}</option>
                                    <option {{old('type',$food->type)!='eat'?'selected':''}} value="drink">{{__('frontend.drink')}}</option>
                                </select>

                                @error('type')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="available" class="col-sm-2 col-form-label">{{__('frontend.available')}}</label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="available" switch="bool" {{old('available',$food->available?'on':'')=='on'?'checked':''}} name="available" />
                                <label for="available" data-on-label="Yes" data-off-label="No"></label>
                                @error('acceptAnyVal')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3 justify-content-center">
                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light col-sm-3 mx-1">
                                {{__('frontend.save')}}</button>
                            <a href="{{route('foods.index')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

                        </div>

                    </form>


                </div>
            </div>
        </div> <!-- end col -->
    </div>


@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $("input[name='price']").TouchSpin({
                step: 0.1,
                decimals: 2,
                initval: {{$food->price}},
                max:1000000,
                min:0.1,
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary"
            });
            $('.option_type').change(function () {
                if($(this).val()=='finance'){
                    $('.finance').removeClass('d-none');
                }else{
                    $('.finance').addClass('d-none');

                }
            })
        })
    </script>
@endsection
