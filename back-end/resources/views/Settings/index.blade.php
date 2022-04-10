@extends('layouts.app')
@section('content')
    <div class="card pt-1">

        <div class="custom-data-table ">
            <div class="card-body">
                <h2 class="page-title pt-1">
                    {{__('frontend.settings')}}
                </h2>
                <hr>
                <div class="row">
                    <div class="col-xl-3 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <p class="font-size-16"><a href="{{route('settings.phone.index')}}">{{__('frontend.phoneContact')}}</a> </p>
                                    <div class="mini-stat-icon mx-auto mb-4 mt-3">
                                        <span class="avatar-title rounded-circle bg-soft-primary">
                                            <i class="mdi mdi-cart-outline text-primary font-size-20"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endsection

        @section('js')

            <script>
                $(document).ready(function () {
                });
            </script>
@endsection
