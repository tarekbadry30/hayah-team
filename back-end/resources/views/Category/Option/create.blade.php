@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <form novalidate  class="create-form pt-3 {{session()->has('errorsq')?'was-validated':''}}" action="{{route('category-option.store')}}" method="post">
                        <input type="hidden" name="category_id" value="{{$category->id}}">
                        @csrf
                        <h4 class="header-title">{{__('frontend.createCategoryOption')}} <strong>{{$category->name}}</strong></h4>
                        <!-- Nav tabs -->
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
                                               value="{{old($locale.'.name')}}"  type="text" placeholder="{{__('frontend.'.$locale.'.name')}}"
                                               id="name" name="{{$locale}}[name]"/>
                                        @error($locale.'.name')
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
                            <label for="status" class="col-sm-2 col-form-label">{{__('frontend.status')}}</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control select2-search-disable2 @error('status') parsley-error is-invalid @enderror ">
                                    <option value="enabled">{{__('frontend.enabled')}}</option>
                                    <option value="disabled">{{__('frontend.disabled')}}</option>
                                </select>
                                @error('status')
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
                                    <option value="finance">{{__('frontend.finance')}}</option>
                                    <option value="physical">{{__('frontend.physical')}}</option>
                                </select>

                                @error('type')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="finance">
                            <div class="row mb-3">
                                <label for="parent_id" class="col-sm-2 col-form-label">{{__('frontend.defaultValue')}}</label>
                                <div class="col-sm-10">
                                    <input name="default_value" type="text" class="form-control @error('default_value') parsley-error is-invalid @enderror " />
                                    @error('default_value')
                                    <div class="invalid-tooltip position-static">
                                        {{$message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="acceptAnyVal" class="col-sm-2 col-form-label">{{__('frontend.acceptAnyValue')}}</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" id="acceptAnyVal" switch="bool" checked name="accept_any_value" />
                                    <label for="acceptAnyVal" data-on-label="Yes" data-off-label="No"></label>
                                    @error('acceptAnyVal')
                                    <div class="invalid-tooltip position-static">
                                        {{$message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light col-sm-3 mx-1">
                                {{__('frontend.save')}}</button>
                            <a href="{{route('category-option.index',['category_id'=>request()->category_id])}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

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
            $("input[name='default_value']").TouchSpin({
                step: 0.1,
                decimals: 2,
                initval: 1,
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
