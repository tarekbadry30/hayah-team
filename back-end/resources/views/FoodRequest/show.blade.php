@extends('layouts.app')
@section('content')
    <div class="card pt-1">

    <div class="custom-data-table ">

        <div class="card-body">
            <h2 class="page-title pt-1">
                {{__('frontend.showFoodRequest')}}
            </h2>
            <div class="row">
                <div class="col-sm-8">
                    <input type="text" class="form-control data-search-input">
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1 apply-filter"><i class=" fas fa-search"></i></button>
                </div>
                <div class="col-sm-12">
                    <div class="row filters_container">
                        <div class="col-md-3 form-group">
                            <label class="col-form-label">{{__('frontend.user')}}</label>
                            <input type="text" readonly class="form-control status" value="{{$foodRequest->user->name}}" />
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="col-form-label">{{__('frontend.status')}}</label>
                            <input type="text" readonly class="form-control status" value="{{$foodRequest->status}}" />
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="col-form-label">{{__('frontend.deliveryEmployee')}}</label>
                            <input readonly class="form-control" value="{{$foodRequest->delivery?$foodRequest->delivery->name:''}}" />

                        </div>
                        <div class="col-md-3 form-group">
                            <label class="col-form-label">{{__('frontend.date')}}</label>
                            <input readonly type="text" class="form-control date-range" value="{{$foodRequest->created_at}}"/>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="col-form-label">{{__('frontend.month')}}</label>
                            <input readonly type="text" class="form-control month" value="{{$foodRequest->month->month}}" />
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="col-form-label">{{__('frontend.total_value')}}</label>
                            <input readonly type="text" class="form-control month" value="{{$foodRequest->total_value}}" />
                        </div>
                    </div>
                </div>
            </div>
            <table id="mainTable" class="mt-3 table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>{{__('frontend.img')}}</th>
                        <th>{{__('frontend.name')}}</th>
                        <th>{{__('frontend.price')}}</th>
                        <th>{{__('frontend.amount')}}</th>
                        <th>{{__('frontend.total_value')}}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($foodRequest->monthFood as $item)
                    <tr>
                        <td><img src="{{asset($item->food->img)}}" class="avatar-md"> </td>
                        <td>{{$item->food->name}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->count}}</td>
                        <td>{{$item->count*$item->price}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @endsection
