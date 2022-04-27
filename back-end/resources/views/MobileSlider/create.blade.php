@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">

                    <form novalidate
                          class="create-form pt-3 {{session()->has('errorsq')?'was-validated':''}}"
                          action="{{route('form-sheets.store')}}" method="post">
                        @csrf
                        <h4 class="header-title">{{__('frontend.createFormSheet')}} </h4>
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

                            </div>
                            @endforeach

                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">{{__('frontend.userType')}}</label>
                            <div class="col-sm-10 position-relative">
                                <select class="form-control user_type @error('userType') parsley-error is-invalid @enderror" name="user_type">
                                    <option {{old('userType')=='all'?'selected':''}} value="all">{{__('frontend.all')}}</option>
                                    <option {{old('userType')=='needy'?'selected':''}} value="needy">{{__('frontend.needy')}}</option>
                                    <option {{old('userType')=='benefactor'?'selected':''}} value="benefactor">{{__('frontend.benefactor')}}</option>
                                </select>
                            </div>

                            @error('userType')
                            <div class="invalid-tooltip position-static">
                                {{$message }}
                            </div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="visibleRange" class="col-sm-2 col-form-label">{{__('frontend.visibleRange')}}</label>
                            <div class="col-sm-10 position-relative">
                                <input class="form-control @error('visibleRange') parsley-error is-invalid @enderror"
                                       value="{{old('visibleRange')}}"  type="text"   id="visibleRange" name="visibleRange"/>
                                @error('visibleRange')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="visible" class="col-sm-2 col-form-label">{{__('frontend.visible')}}</label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="visible" switch="bool" checked name="visible" />
                                <label for="visible" data-on-label="Yes" data-off-label="No"></label>
                                @error('visible')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="inputs-container">
                            <hr>
                            <div class="row pb-2">
                                <div class="col-sm-10"><h2 class="text-center">{{__('frontend.formInput')}}</h2> </div>
                                <button type="button" class="col-sm-1 btn btn-outline-success add-box"><i class=" fas fa-plus"></i></button>

                            </div>
                            @for($i=0;$i<=$inputsCount;$i++)
                            <div class="row mb-3 input-box">
                                <label class="col-sm-2 col-form-label">{{__('frontend.inputItem')}}</label>
                                <div class="col-sm-4 position-relative">
                                    <input class="form-control"
                                           value="" required type="text" placeholder="{{__('frontend.ar.name')}}"
                                           id="name" name="inputs[{{$i}}][ar][name]"/>
                                </div>

                                <div class="col-sm-4 position-relative">
                                    <input class="form-control"
                                           value="" required type="text" placeholder="{{__('frontend.en.name')}}"
                                           id="name" name="inputs[{{$i}}][en][name]"/>
                                </div>

                                <button type="button" class="col-sm-1 btn btn-outline-danger remove-box"><i class="fas fa-trash-alt "></i></button>
                            </div>
                            @endfor
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light col-sm-3 mx-1">
                                {{__('frontend.save')}}</button>
                            <a href="{{route('form-sheets.index')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

                        </div>

                    </form>


                </div>
            </div>
        </div> <!-- end col -->
    </div>


@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>

        $(document).ready(function () {
            $("#visibleRange").flatpickr({
                mode: "range"
            });
            $(document).on('click', '.remove-box', function () {
                if($('.input-box').length>1)
                    $(this).closest('.input-box').remove();
            });
            $(document).on('click', '.add-box', function () {
                let newRow=$('.input-box').length;
                $('.inputs-container').append(`

                            <div class="row mb-3 input-box">
                                <label class="col-sm-2 col-form-label">{{__('frontend.inputItem')}}</label>
                                <div class="col-sm-4 position-relative">
                                    <input class="form-control"
                                           value="" required type="text" placeholder="{{__('frontend.ar.name')}}"
                                           id="name" name="inputs[${newRow}][ar][name]"/>
                                </div>

                                <div class="col-sm-4 position-relative">
                                    <input class="form-control"
                                           value="" required type="text" placeholder="{{__('frontend.en.name')}}"
                                           id="name" name="inputs[${newRow}][en][name]"/>
                                </div>

                                <button type="button" class="col-sm-1 btn btn-outline-danger remove-box"><i class="fas fa-trash-alt "></i></button>
                                <button type="button" class="d-none col-sm-1 btn btn-outline-success add-box"><i class=" fas fa-plus"></i></button>
                            </div>

`);
            });

        })
    </script>
@endsection
