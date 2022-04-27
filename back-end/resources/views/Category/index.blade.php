@extends('layouts.app')
@section('content')
    <div class="card pt-1">
    <div class="custom-data-table ">

        <div class="card-body">
            <h2 class="page-title pt-1">
                {{__('frontend.categoriesList')}} @if(isset($type)) {{__('frontend.inType')}} <strong>
                    {{$type->name}}
                </strong>
                @endif
            </h2>
            <div class="row">
                <div class="col-sm-8">
                    <input type="text" class="form-control data-search-input">
                </div>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-outline-secondary waves-effect waves-light col-sm-2 mx-1 apply-filter"><i class=" fas fa-search"></i></button>

                    <a href="{{route('categories.create')}}@if(isset($type))?type_id={{$type->id}}@endif" class="btn btn-outline-secondary waves-effect waves-light col-sm-2 mx-1"><i class=" fas fa-plus"></i></a>
                    @if(isset($type))
                    <a href="{{route('categories.importPage')}}?type_id={{$type->id}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-2 mx-1"><i class="fas fa-file-import"></i></a>
                    @endif
                    <a href="{{route('categories.export')}}{{isset($type)?'?type_id='.$type->id:''}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-2 mx-1"><i class="fas fa-file-export"></i></a>

                </div>
                <div class="col-sm-12">
                    <div class="row filters_container">
                        <div class="col-md-3 form-group">
                            <label class="col-form-label">{{__('frontend.donationType')}}</label>
                            <select class="form-control donation_types" name="type_id">
                                <option value="">{{__('frontend.all')}}</option>
                                @foreach($types as $typeItem)
                                <option value="{{$typeItem->id}}" @if(isset($type)&&$typeItem->id==$type->id) selected @endif>{{$typeItem->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="col-form-label">{{__('frontend.urgent')}}</label>
                            <select class="form-control urgent" name="urgent">
                                <option value="">{{__('frontend.all')}}</option>
                                <option value="1">{{__('frontend.yes')}}</option>
                                <option value="0">{{__('frontend.no')}}</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label class="col-form-label">{{__('frontend.status')}}</label>
                            <select class="form-control status" name="status">
                                <option value="">{{__('frontend.all')}}</option>
                                <option value="enabled">{{__('frontend.enabled')}}</option>
                                <option value="disabled">{{__('frontend.disabled')}}</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group d-none">
                            <label class="col-form-label">{{__('frontend.date')}}</label>
                            <input type="text" class="form-control date-range" name="date_range" />
                        </div>
                    </div>
                </div>

            </div>
            <table id="mainTable" class="mt-3 table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                <tr>
                    <th>{{__('frontend.img')}}</th>
                    <th>{{__('frontend.name')}}</th>
                    <th>{{__('frontend.desc')}}</th>
                    <th>{{__('frontend.status')}}</th>
                    <th>{{__('frontend.options')}}</th>
                    <th>{{__('frontend.type')}}</th>
                    <th>{{__('frontend.urgent')}}</th>
                    <th>{{__('frontend.needed_value')}}</th>
                    <th>{{__('frontend.collected_value')}}</th>
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
            $(document).on('click', '.apply-filter', function () {
                setPage(1, 25);
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
            customDataTable($('#mainTable tbody'),$(".pagination-container"),'{{route('categories.dataTable')}}?type_id={{request()->type_id}}',page,'get',itemsPerPage);
        }
        async function  customDataTable(tableBody,paginationContainer,url,page=1,method='get',itemsPerPage=15) {
            let results=[];
           await $.ajax({
                url: url,
                method:method,
                data: {
                    page: page,
                    itemsPerPage: itemsPerPage,
                    filters: {
                        type_id: $('.donation_types').val() != '' ? $('.donation_types').val() : '',
                        urgent: $(".urgent").val() != '' ? $(".urgent").val() : '',
                        date: $('.date-range').val() != '' ? $('.date-range').val() : '',
                        status: $('.status').val() != '' ? $('.status').val() : '',
                    },
                }
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
                    <td><img class="avatar-md" src="{{asset('/')}}${item.image}"></td>
                    <td>${item.name}</td>
                    <td>${item.desc}</td>
                    <td>${item.status}</td>
                    <td ><a href="{{route('category-option.index')}}?category_id=${item.id}">${item.options_count}</td>
                    <td>${item.type_id?item.type.name:''}</td>
                    <td>${item.urgent?'{{__('frontend.yes')}}':'{{__('frontend.no')}}'}</td>
                    <td>${item.needed_value}</td>
                    <td>${item.collected_value}</td>
                    <td>
                        <div class="btn-group dropend">
                            <button type="button" class="btn btn-info waves-effect waves-light dropdown-toggle-split dropdown-toggle"
                            data-bs-toggle="dropdown" aria-expanded="false">
                                <i class=" fas fa-angle-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="btn btn-outline-danger delete-btn  waves-effect waves-light"
                                    href="{{route('categories.index')}}/${item.id}" title="{{__('frontend.delete')}}">
                                    <i class="fas fa-trash-alt"></i> </button>
                                <a class="btn btn-outline-success  waves-effect waves-light"
                                    href="{{route('categories.index')}}/${item.id}/edit" title="{{__('frontend.edit')}}">
                                        <i class="far fa-edit "></i>
                                </a>
                                <a href="{{route('uploads.index')}}?model=Category&value=${item.id}&backRoute={{request()->url()}}"
                                    class="btn btn-outline-info waves-effect waves-light" title="{{__('frontend.changeImg')}}">
                                    <i class="fas fa-upload"></i>
                                </a>
                                <a href="{{route('category-option.create')}}?category_id=${item.id}" title="{{__('frontend.createOption')}}"
                                    class="btn btn-outline-secondary waves-effect waves-light ">
                                    <i class=" fas fa-plus"></i>
                                </a>
                                <a href="{{route('category-option.importPage')}}?category_id=${item.id}"
                                   title="{{__('frontend.import')}}" class="btn btn-outline-secondary waves-effect waves-light"><i class="fas fa-file-import"></i></a>
                                <a href="{{route('category-option.export')}}?category_id=${item.id}"
                                   title="{{__('frontend.export')}}" class="btn btn-outline-secondary waves-effect waves-light"><i class="fas fa-file-export"></i></a>
                            </div>
                        </div>
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
