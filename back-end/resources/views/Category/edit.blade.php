@extends('layouts.app')
@section('content')
    <form novalidate  class="create-form pt-3 {{session()->has('errorsq')?'was-validated':''}}" action="{{route('categories.update',['category'=>$category])}}" method="post">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        @method('put')
                        <h4 class="header-title">{{__('frontend.editCategory')}}</h4>
                        <input type="hidden" name="id" value="{{$category->id}}">
                        <!-- Nav tabs -->
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">{{__('frontend.img')}}</label>
                            <div class="col-sm-10 position-relative">
                                <img src="{{asset($category->img)}}" class="avatar-lg">
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
                                        <label for="{{$locale}}.name" class="col-sm-2 col-form-label">{{__('frontend.'.$locale.'.name')}}</label>
                                        <div class="col-sm-10 position-relative">
                                            <input class="form-control @error($locale.'.name') parsley-error is-invalid @enderror"
                                                   value="{{old($locale.'.name',$category->translate($locale)->name)}}"  type="text" placeholder="{{__('frontend.'.$locale.'.name')}}"
                                                   id="{{$locale}}.name" name="{{$locale}}[name]"/>
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
                                          placeholder="{{__('frontend.'.$locale.'.desc')}}" id="desc" name="{{$locale}}[desc]">{{old($locale.'.desc',$category->translate($locale)->desc)}}</textarea>
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
                                    <option {{$category->status=='enabled'?'selected':''}} value="enabled">{{__('frontend.enabled')}}</option>
                                    <option {{$category->status=='disabled'?'selected':''}} value="disabled">{{__('frontend.disabled')}}</option>
                                </select>
                                @error('status')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="type_id" class="col-sm-2 col-form-label">{{__('frontend.type')}}</label>
                            <div class="col-sm-10">
                                <select name="type_id" class="form-control select2-search-disable2 @error('type_id') parsley-error is-invalid @enderror ">
                                    @foreach($types as $typeItem)
                                        <option {{$category->type_id==$typeItem->id?'selected':''}} value="{{$typeItem->id}}">{{$typeItem->name}}</option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 justify-content-center">
                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light col-sm-3 mx-1">
                                {{__('frontend.save')}}</button>
                            <a href="{{route('categories.index')}}{{$category->type_id?'?type_id='.$category->type_id:''}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

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
