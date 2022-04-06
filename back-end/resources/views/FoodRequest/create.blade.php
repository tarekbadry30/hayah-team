@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <form novalidate  class="create-form pt-3 {{session()->has('errorsq')?'was-validated':''}}" action="{{route('donation-types.store')}}" method="post">
                        @csrf
                        <h4 class="header-title">{{__('frontend.createDonationType')}} </h4>
                        <!-- Nav tabs -->
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
                                <div class="row mb-3">
                                    <label for="desc" class="col-sm-2 col-form-label">{{__('frontend.'.$locale.'.desc')}}</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control @error($locale.'.desc') parsley-error is-invalid @enderror"
                                          placeholder="{{__('frontend.'.$locale.'.desc')}}" id="desc" name="{{$locale}}[desc]">{{old($locale.'.desc')}}</textarea>
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



                        <div class="row mb-3 justify-content-center">
                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light col-sm-3 mx-1">
                                {{__('frontend.save')}}</button>
                            <a href="{{route('donation-types.index')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

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
