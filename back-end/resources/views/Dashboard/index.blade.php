@extends('layouts.app')
@section('content')
    <div class="card pt-1">

    <div class="custom-data-table ">

        <div class="card-body">
            <h2 class="page-title pt-1">
                {{__('frontend.Dashboard')}}
            </h2>
            <hr>
            <div class="row">
                @foreach($cards as $card)
                <div class="col-xl-3 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <p class="font-size-16"><a href="{{$card['route']}}">{{$card['name']}}</a> </p>
                                <div class="mini-stat-icon mx-auto mb-4 mt-3">
                                    <span class="avatar-title rounded-circle bg-soft-primary">
                                        <i class="mdi mdi-cart-outline text-primary font-size-20"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-22">{{$card['value']}}</h5>

                                <p class="text-muted">70% Target</p>

                                <div class="progress mt-3" style="height: 4px;">
                                    <div class="progress-bar progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="70">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

        @endsection

@section('js')
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

            <script>
        $(document).ready(function () {
            $(".date-range").flatpickr({
                mode: "range"
            });

            let currentPage = 1;
            let itemsPerPage = 25;
            var globalFiltersList=[];
            setPage(currentPage, itemsPerPage);

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
            $(document).on('change', '.donation_types', function () {
                generateFilters(globalFiltersList,{
                    type_id:$('.donation_types').val(),
                    option_id:$(".category_options").val(),
                    category_id:$('.category_types').val(),
                })
            });
            $(document).on('change', '.category_types', function () {
                generateFilters(globalFiltersList,{
                    type_id:$('.donation_types').val(),
                    option_id:$(".category_options").val(),
                    category_id:$('.category_types').val(),
                })
            });
            $(document).on('change', '.category_options', function () {
                generateFilters(globalFiltersList,{
                    type_id:$('.donation_types').val(),
                    option_id:$(".category_options").val(),
                    category_id:$('.category_types').val(),

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
            customDataTable($('#mainTable tbody'),$(".pagination-container"),'{{route('donations.dataTable')}}',page,'get',itemsPerPage);
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
                        type_id:$('.donation_types').val()!=''?$('.donation_types').val():'',
                        option_id:$(".category_options").val()!=''?$(".category_options").val():'',
                        category_id:$('.category_types').val()!=''?$('.category_types').val():'',
                        date:$('.date-range').val()!=''?$('.date-range').val():'',
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
                    <td>${item.user.name}</td>
                    <td>${item.status}</td>
                    <td>${item.donation_type.name}</td>
                    <td>${item.category.name}</td>
                    <td>${item.option.name}</td>
                    <td>${item.type}</td>
                    <td>${item.value}</td>
                    <td>${item.created_at}</td>
                    <td>
                    <button
                    class="btn btn-outline-success accept-btn waves-effect waves-light ${item.status!='pending'?'d-none':''}"
                    item_id="${item.id}" data-bs-toggle="modal"
                    data-bs-target=".accept-donation-modal"
                    >{{__('frontend.accept')}}</button>
                    <button
                    class="btn btn-outline-danger delete-btn  waves-effect waves-light"
                    href="{{route('donation-types.index')}}/${item.id}">{{__('frontend.delete')}}</button>
                    <a class="btn btn-outline-success  waves-effect waves-light"
                    href="{{route('donation-types.index')}}/${item.id}/edit">{{__('frontend.edit')}}</button>


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
