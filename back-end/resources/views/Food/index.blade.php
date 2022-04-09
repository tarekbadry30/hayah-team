@extends('layouts.app')
@section('content')
    <div class="card pt-1">

        <div class="custom-data-table ">

            <div class="card-body">
                <h2 class="page-title pt-1">
                    {{__('frontend.foods')}}
                </h2>
                <div class="row">
                    <!--
                        <div class="col-sm-8">
                            <input type="text" class="form-control data-search-input">
                        </div>
                        <div class="col-sm-4">

                        </div>
                        -->
                    <div class="col-sm-8">
                        <input type="text" class="form-control data-search-input">
                    </div>
                    <div class="col-sm-4">
                        <a href="{{route('foods.create')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-2 mx-1"><i class=" fas fa-plus"></i></a>
                        <a href="{{route('foods.importPage')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-2 mx-1"><i class="fas fa-file-import"></i></a>
                        <a href="{{route('foods.export')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-2 mx-1"><i class="fas fa-file-export"></i></a>
                        <button type="button" class="btn btn-outline-secondary waves-effect waves-light col-sm-2 mx-1 apply-filter"><i class=" fas fa-search"></i></button>
                    </div>
                    <div class="col-sm-12">
                        <div class="row filters_container">
                            <div class="col-md-3 form-group">
                                <label class="col-form-label">{{__('frontend.type')}}</label>
                                <select class="form-control type" name="type">
                                    <option value="">{{__('frontend.all')}}</option>
                                    <option value="eat">{{__('frontend.eat')}}</option>
                                    <option value="drink">{{__('frontend.drink')}}</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="col-form-label">{{__('frontend.min_price')}}</label>
                                <input  name="min_price" type="text" class="form-control min_price" />
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="col-form-label">{{__('frontend.max_price')}}</label>
                                <input  name="max_price" type="text" class="form-control max_price" />
                            </div>
                            <div class="col-md-3 form-group">
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
                        <th>{{__('frontend.type')}}</th>
                        <th>{{__('frontend.available')}}</th>
                        <th>{{__('frontend.price')}}</th>
                        <th>{{__('frontend.date')}}</th>
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
        {{--

        <!--  Modal content for the above example -->
        <div class="modal fade accept-donation-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">{{__('frontend.acceptDonation')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="control-donation" action="{{route('donations.accept')}}" method="post">
                            @csrf
                            <input type="hidden" name="donation_id" id="donation_id" >
                            <div class="row mb-3">
                                <label for="desc" class="col-sm-2 col-form-label">{{__('frontend.notes')}}</label>
                                <div class="col-sm-10">
                                <textarea class="form-control" placeholder="{{__('frontend.notes')}}" id="notes" name="notes"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="type_id" class="col-sm-2 col-form-label">{{__('frontend.deliveryEmployee')}}</label>
                                <div class="col-sm-10">
                                    <select name="delivery_id" class="form-control select2-search-disable2">
                                        <option value="" selected></option>
                                        @foreach($deliveries as $delivery)
                                            <option  value="{{$delivery->id}}">{{$delivery->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 justify-content-center">
                                <button type="submit" class="btn btn-outline-primary waves-effect waves-light col-sm-3 mx-1">
                                    {{__('frontend.save')}}</button>
                                <button type="submit" class="btn btn-outline-info waves-effect waves-light col-sm-3 mx-1">
                                    {{__('frontend.cancel')}}</button>

                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
                --}}

        @endsection
        @section('js')
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

            <script>
                $(document).ready(function () {
                    $("input[name='min_price']").TouchSpin({
                        step: 0.1,
                        decimals: 2,
                        initval: 1,
                        max:1000000,
                        min:0.1,
                        buttondown_class: "btn btn-primary",
                        buttonup_class: "btn btn-primary"
                    });
                    $("input[name='max_price']").TouchSpin({
                        step: 0.1,
                        decimals: 2,
                        initval: 100000000,
                        max:100000000,
                        min:0.1,
                        buttondown_class: "btn btn-primary",
                        buttonup_class: "btn btn-primary"
                    });
                    $(".date-range").flatpickr({
                        mode: "range"
                    });

                    let currentPage = 1;
                    let itemsPerPage = 25;
                    var globalFiltersList=[];
                    setPage(currentPage, itemsPerPage);
                    generateFilters(globalFiltersList)

                    $.ajax({
                        url: "{{route('categories.listForFilter')}}",
                        method: 'get',
                    }).done(function (data) {
                        globalFiltersList=data.data;
                        generateFilters(globalFiltersList)
                        setPage(currentPage, itemsPerPage);

                    });

                    $(document).on('change', 'select[name="mainTable_length"]', function () {
                        itemsPerPage = $(this).val();
                        setPage(currentPage, itemsPerPage);

                    });
                    $(document).on('submit', '.control-donation', function (e) {
                        let form = $(this);
                        e.preventDefault();
                        $.ajax({
                            url: form.attr('action'),
                            method: form.attr('method'),
                            data: form.serialize(),

                        }).done(function( data ) {

                            setPage(currentPage, itemsPerPage);
                            Swal.fire({
                                title: "{{__('frontend.success')}}",
                                text: data.message,
                                icon: "success",
                                confirmButtonColor: "#1cbb8c",
                                confirmButtonText: "{{__('frontend.ok')}}",
                            });
                            $(".accept-donation-modal").modal('hide');
                            //$(`.accept-btn[item_id="${form.find('#donation_id').val()}"]`).addClass('d-none');
                        });
                        let tableContent='';;
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
                $(document).on('click', '.apply-filter', function () {
                    setPage(1, 25);
                });
                $(document).on('click', '.accept-btn', function () {
                    $('#donation_id').val($(this).attr('item_id'));
                });
                function setPage(page,itemsPerPage) {
                    customDataTable($('#mainTable tbody'),$(".pagination-container"),'{{route('foods.dataTable')}}',page,'get',itemsPerPage);
                }
                async function  customDataTable(tableBody,paginationContainer,url,page=1,method='get',itemsPerPage=15) {
                    let results=[];
                    await $.ajax({
                        url: url,
                        method:method,
                        data: {
                            page:page,
                            itemsPerPage:itemsPerPage,
                            filters:{
                                date:$('.date-range').val()!=''?$('.date-range').val():'',
                                min_price:$('.min_price').val()!=''?$('.min_price').val():'',
                                max_price:$('.max_price').val()!=''?$('.max_price').val():'',
                                type:$('.type').val()!=''?$('.type').val():'',
                            }
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
                        //console.log(item);
                        tableContent+=`<tr>
                    <td><img src="{{asset('/')}}${item.image}" class="avatar-md"></td>
                    <td>${item.name}</td>
                    <td>${item.desc}</td>
                    <td>${item.type}</td>
                    <td>${item.available?'{{__('frontend.yes')}}':"{{__('frontend.no')}}"}</td>
                    <td>${item.price}</td>
                    <td>${item.created_at}</td>
                    <td>
                    <button
                    class="btn btn-outline-success accept-btn waves-effect waves-light ${item.status!='pending'?'d-none':''}"
                    item_id="${item.id}" data-bs-toggle="modal"
                    data-bs-target=".accept-donation-modal"
                    >{{__('frontend.accept')}}</button>
                    <button
                    class="btn btn-outline-danger delete-btn  waves-effect waves-light"
                    href="{{route('foods.index')}}/${item.id}" title="{{__('frontend.delete')}}"><i class="fas fa-trash-alt"></i></button>
                    <a class="btn btn-outline-success  waves-effect waves-light"
                    href="{{route('foods.index')}}/${item.id}/edit" title="{{__('frontend.edit')}}"><i class="far fa-edit"></i></button>

                 <a href="{{route('uploads.index')}}?model=Food&value=${item.id}&backRoute={{request()->url()}}"
                    class="btn btn-outline-info waves-effect waves-light" title=" {{__('frontend.changeImg')}}">
                    <i class="fas fa-upload"></i>
                        </a>
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
                function generateFilters(list,newFilters={
                    type_id:'',
                    category_id:'',
                    option_id:'',
                }) {
                    let donation_type=$('.donation_types');
                    let category_types=$('.category_types');
                    let category_options=$('.category_options');
                    let donation_content=`<option selected value="">{{__('frontend.all')}}</option>`
                    let category_content=`<option selected value="">{{__('frontend.all')}}</option>`
                    let options_content=`<option selected value="">{{__('frontend.all')}}</option>`
                    list.forEach((item)=>{
                        donation_content+=`<option ${newFilters.type_id==item.id?'selected':''} value="${item.id}">${item.name}</option>`;
                        if(newFilters.type_id==item.id) {
                            item.categories.forEach((catItem) => {
                                category_content += `<option ${newFilters.category_id == catItem.id ? 'selected' : ''} value="${catItem.id}">${catItem.name}</option>`;
                                if(newFilters.category_id==catItem.id) {
                                    catItem.options.forEach((optionItem) => {
                                        options_content += `<option ${newFilters.option_id == optionItem.id ? 'selected' : ''} value="${optionItem.id}">${optionItem.name}</option>`;
                                    })
                                }
                            })
                        }
                    })
                    donation_type.html(donation_content);
                    category_types.html(category_content);
                    category_options.html(options_content);

                }
            </script>
@endsection
