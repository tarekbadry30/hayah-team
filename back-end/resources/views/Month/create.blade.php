@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <form class="create-form pt-3 {{session()->has('errorsq')?'was-validated':''}}"
                          action="{{route('monthly-help.store')}}" method="post">
                        @csrf
                        <h4 class="header-title">{{__('frontend.createMonthHelpOf')}} <strong>{{$user->name}}</strong> </h4>
                        <input type="hidden" value="{{$user->id}}" name="user_id">
                        <div class="row mb-3">
                            <label for="value" class="col-sm-2 col-form-label">{{__('frontend.value')}}</label>
                            <div class="col-sm-10">
                                <input name="help_value" type="text" class="help_value form-control @error('help_value') parsley-error is-invalid @enderror " />
                                @error('help_value')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="month" class="col-sm-2 col-form-label">{{__('frontend.month')}}</label>
                            <div class="col-sm-10">
                                <input value="{{old('month')}}" type="text" name="month" class="month form-control  @error('month') parsley-error is-invalid @enderror ">


                                @error('month')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3 justify-content-center">
                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light col-sm-3 mx-1">
                                {{__('frontend.save')}}</button>
                            <a href="{{route('monthly-help.index',['user_id'=>$user->id])}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

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
            $(".month").flatpickr({
                shorthand: true, //defaults to false
                dateFormat: "m-Y", //defaults to "F Y"
                altFormat: "F Y", //defaults to "F Y"
                minDate: "today",

                @if(old('month'))
                    defaultDate:['{{old('month')}}']
                @endif
            });
            $("input[name='help_value']").TouchSpin({
                step: 0.1,
                decimals: 2,
                initval: 1,
                max:1000000,
                min:0.1,
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary"
            });

        })
    </script>
@endsection
