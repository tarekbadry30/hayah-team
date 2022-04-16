@extends('layouts.app')
@section('content')
    <form novalidate  class="create-form pt-3 {{session()->has('errorsq')?'was-validated':''}}" action="{{route('users.store')}}" method="post">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <h4 class="header-title">{{__('frontend.createUser')}}</h4>
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">{{__('frontend.name')}}</label>
                        <div class="col-sm-10 position-relative">
                            <input class="form-control @error('name') parsley-error is-invalid @enderror" value="{{old('name')}}"  type="text" placeholder="{{__('frontend.name')}}" id="name" name="name"/>
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
                            <input class="form-control @error('phone') parsley-error is-invalid @enderror" value="{{old('phone')}}"  type="text" placeholder="{{__('frontend.phone')}}" id="phone" name="phone">
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
                        <label for="address" class="col-sm-2 col-form-label">{{__('frontend.address')}}</label>
                        <div class="col-sm-10">
                            <input class="form-control @error('address') parsley-error is-invalid @enderror" value="{{old('address')}}"  type="text" placeholder="{{__('frontend.address')}}" id="address" name="address">
                        @error('address')
                            <div class="invalid-tooltip position-static">
                                {{$message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nationalNum" class="col-sm-2 col-form-label">{{__('frontend.nationalNum')}}</label>
                        <div class="col-sm-10">
                            <input class="form-control  @error('national_number') parsley-error is-invalid @enderror " value="{{old('national_number')}}"  type="text" placeholder="{{__('frontend.nationalNum')}}" id="nationalNum" name="national_number">
                            @error('national_number')
                            <div class="invalid-tooltip position-static">
                                {{$message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nationalNum" class="col-sm-2 col-form-label">{{__('frontend.type')}}</label>
                        <div class="col-sm-10">
                            <select name="type" class="form-control select2-search-disable2 @error('type') parsley-error is-invalid @enderror ">
                                <option value="benefactor">{{__('frontend.benefactor')}}</option>
                                <option value="needy">{{__('frontend.needy')}}</option>
                            </select>
                            @error('type')
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
                                <option value="pending">{{__('frontend.pending')}}</option>
                                <option value="active">{{__('frontend.active')}}</option>
                                <option value="blocked">{{__('frontend.blocked')}}</option>
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
                        <a href="{{route('users.index')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

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
