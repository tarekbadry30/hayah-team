@extends('layouts.app')
@section('content')
    <div class="card pt-1">

    <div class="custom-data-table ">

        <div class="card-body">
            <h2 class="page-title pt-1">
                {{__('frontend.DeliveryList')}}
            </h2>
            <div class="row">
                <div class="col-sm-8">
                    <input type="text" class="form-control data-search-input">
                </div>
                <div class="col-sm-4">
                    <a href="{{route('deliveries.create')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1"><i class=" fas fa-plus"></i></a>

                </div>
            </div>
            <table id="mainTable" class="mt-3 table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                <tr>
                    <th>{{__('frontend.name')}}</th>
                    <th>{{__('frontend.phone')}}</th>
                    <th>{{__('frontend.vehicle_number')}}</th>
                    <th>{{__('frontend.status')}}</th>
                    <th>{{__('frontend.nationalNumber')}}</th>
                    <th>{{__('frontend.lastOrderDate')}}</th>
                    <th>{{__('frontend.action')}}</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info d-none" id="mainTable_info" role="status" aria-live="polite">Showing 0 to 0 of 0 entries</div>
                </div>
                <div class="col-sm-12 col-md-7 pagination-container">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {

            @if(session('success'))
            Swal.fire({
                title: "{{__('frontend.success')}}",
                text: '{{session('success')}}',
                icon: "success",
                confirmButtonColor: "#1cbb8c",
                confirmButtonText: "{{__('frontend.ok')}}",
            });
            @endif
            let currentPage = 1;
            let itemsPerPage = 25;
            setPage(currentPage, itemsPerPage);
            //$('#mainTable').DataTable();
            $(document).on('change', 'select[name="mainTable_length"]', function () {
                itemsPerPage = $(this).val();
                setPage(currentPage, itemsPerPage);

            });
            $('select[name="mainTable_length"]').val(itemsPerPage);
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $(document).on('click', '.page-link', function () {
                currentPage = $(this).attr('page');
                setPage($(this).attr('page'), itemsPerPage);
            })
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
        function setPage(page,itemsPerPage) {
            customDataTable($('#mainTable tbody'),$(".pagination-container"),'{{route('deliveries.dataTable')}}',page,'get',itemsPerPage);
        }
        async function  customDataTable(tableBody,paginationContainer,url,page=1,method='get',itemsPerPage=15) {
            let results=[];
           await $.ajax({
                url: url,
                method:method,
                data: {page:page,itemsPerPage:itemsPerPage}
            }).done(function( data ) {
                console.log( "Sample of data:", data.data.data/*.current_page */);
                let lastPage=data.data.last_page;
                generatePaginator(page,lastPage,paginationContainer);
                    results=results=data.data.data;
                });
            let tableContent='';

            if(results.length<1)
                tableContent=`<tr><td colspan="${$('#mainTable th').length-1}">{{__('frontend.noResult')}}</td></tr>`;
            for(let item of results){
                console.log(item);
                tableContent+=`<tr>

status
nationalNumber
lastOrderDate
                    <td>${item.name}</td>
                    <td>${item.phone}</td>
                    <td>${item.vehicle_number}</td>
                    <td>${item.status}</td>
                    <td>${item.national_number}</td>
                    <td>${item.last_order_date}</td>
                    <td>
                    <button class="btn btn-outline-danger delete-btn  waves-effect waves-light" href="{{route('users.index')}}/${item.id}">{{__('frontend.delete')}}</button>
                    <a class="btn btn-outline-success  waves-effect waves-light" href="{{route('users.index')}}/${item.id}/edit">{{__('frontend.edit')}}</button>
                    </td>

            </tr>`;
            }
            tableBody.html(tableContent);


            //$('#mainTable').DataTable();
        }
        function generatePaginator(page,lastPage,paginationContainer) {
            let paginationHTML=`
                <div class="dataTables_paginate paging_simple_numbers" id="mainTable_paginate">
                <ul class="pagination">
                    <li class="paginate_button page-item previous ${page==1?'disabled':''}" id="mainTable_previous">
                        <button href="#" aria-controls="mainTable" page="${page>1?parseInt(page)-1:1}" data-dt-idx="0" tabindex="0" class="page-link">Previous</button>
                    </li>`;

            for(let pager=1;pager<=lastPage;pager++){
                paginationHTML+=`
                            <li class="paginate_button page-item ${pager==page?'active':''}" >
                                <button href="#" aria-controls="mainTable" page="${pager}" class="page-link">${pager}</button>
                            </li>
                        `;
            }
            paginationHTML+=`<li class="paginate_button page-item next ${page==lastPage?'disabled':''}" id="mainTable_next">
                        <button href="#" aria-controls="mainTable" page="${parseInt(page)+1}" data-dt-idx="1" tabindex="0" class="page-link">Next</button>
                    </li>
                </ul>
            </div>
                `;
            paginationContainer.html(paginationHTML)
        }
    </script>
@endsection
