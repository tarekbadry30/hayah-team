@extends('layouts.app')
@section('content')
    <form novalidate  class="create-form pt-3 {{session()->has('errorsq')?'was-validated':''}}" action="{{route('deliveries.update',['delivery'=>$delivery])}}" method="post">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        <h4 class="header-title">{{__('frontend.editDelivery')}}</h4>
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">{{__('frontend.name')}}</label>
                            <div class="col-sm-10 position-relative">
                                <input type="hidden" name="id" value="{{$delivery->id}}">
                                <input class="form-control @error('name') parsley-error is-invalid @enderror" value="{{old('name',$delivery->name)}}"  type="text" placeholder="{{__('frontend.name')}}" id="name" name="name"/>
                                @error('name')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone" class="col-sm-2 col-form-label">{{__('frontend.phone')}}</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('phone') parsley-error is-invalid @enderror" value="{{old('phone',$delivery->phone)}}"  type="text" placeholder="{{__('frontend.phone')}}" id="phone" name="phone">
                                @error('phone')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">{{__('frontend.password')}}</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('password') parsley-error is-invalid @enderror  " type="password" value="{{old('password')}}" name="password" placeholder="{{__('frontend.password')}}"  id="password">
                                @error('password')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="vehicle_number" class="col-sm-2 col-form-label">{{__('frontend.vehicle_number')}}</label>
                            <div class="col-sm-10">
                                <input class="form-control @error('vehicle_number') parsley-error is-invalid @enderror"
                                       value="{{old('vehicle_number',$delivery->vehicle_number)}}"  type="text"
                                       placeholder="{{__('frontend.vehicle_number')}}" id="vehicle_number" name="vehicle_number">
                                @error('vehicle_number')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nationalNum" class="col-sm-2 col-form-label">{{__('frontend.nationalNum')}}</label>
                            <div class="col-sm-10">
                                <input class="form-control  @error('national_number') parsley-error is-invalid @enderror " value="{{old('national_number',$delivery->national_number)}}"  type="text" placeholder="{{__('frontend.nationalNum')}}" id="nationalNum" name="national_number">
                                @error('national_number')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nationalNum" class="col-sm-2 col-form-label">{{__('frontend.status')}}</label>
                            <div class="col-sm-10">
                                <select name="status" class="form-control select2-search-disable2 @error('status') parsley-error is-invalid @enderror ">
                                    <option {{$delivery->status=='active'?'selected':''}} value="active">{{__('frontend.active')}}</option>
                                    <option {{$delivery->status!='active'?'selected':''}} value="blocked">{{__('frontend.blocked')}}</option>
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
                            <a href="{{route('deliveries.index')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

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
