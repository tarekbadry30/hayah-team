@extends('layouts.app')
@section('content')
    <div class="card pt-1">

    <div class="custom-data-table ">

        <div class="card-body">
            <h2 class="page-title pt-1">
                {{__('frontend.phoneContact')}}
            </h2>
            <div class="row">
                <div class="col-sm-8">
                    <input type="text" class="form-control data-search-input">
                </div>
                <div class="col-sm-4">
                    <a href="{{route('settings.phone.create')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-2 mx-1"><i class=" fas fa-plus"></i></a>
                    <a href="{{route('settings.phone.importPage')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-2 mx-1"><i class="fas fa-file-import"></i></a>
                    <a href="{{route('settings.phone.export')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-2 mx-1"><i class="fas fa-file-export"></i></a>

                </div>
            </div>
            <table id="mainTable" class="mt-3 table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                <tr>
                    <th>{{__('frontend.name')}}</th>
                    <th>{{__('frontend.phone')}}</th>
                    <th>{{__('frontend.action')}}</th>
                </tr>
                </thead>
                <tbody>
                    @if(count($phones)<1)
                    <tr><td colspan="3">{{__('frontend.noData')}}</td></tr>
                    @endif
                    @foreach($phones as $phone)
                        <tr>
                            <td>{{$phone->name}}</td>
                            <td>{{$phone->phone}}</td>
                            <td>
                                <button
                                    class="btn btn-outline-danger delete-btn  waves-effect waves-light"
                                    href="{{route('settings.phone.destroy',['phone'=>$phone])}}" title="{{__('frontend.delete')}}"><i class="fas fa-trash-alt"></i></button>
                                <a class="btn btn-outline-success  waves-effect waves-light"
                                   href="{{route('settings.phone.edit',['phone'=>$phone])}}" title="{{__('frontend.edit')}}"><i class="far fa-edit"></i></button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $(document).on('click', '.delete-btn', function () {
                let url = $(this).attr('href');
                Swal.fire({
                    title: "{{__('frontend.alert')}}",
                    text: "{{__('frontend.sureDelete')}}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#1cbb8c",
                    cancelButtonColor: "#f14e4e",
                    confirmButtonText: "{{__('frontend.yes')}}",
                    cancelButtonText: "{{__('frontend.no')}}",
                }).then(
                    function (result) {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                method: 'delete',
                            }).done(function (data) {
                                Swal.fire({
                                    title: "{{__('frontend.success')}}",
                                    text: data.data.message,
                                    icon: "success",
                                    confirmButtonColor: "#1cbb8c",
                                    confirmButtonText: "{{__('frontend.ok')}}",
                                });
                                setPage(currentPage, itemsPerPage);

                            });
                        }
                    })
            });
        });

    </script>
@endsection
