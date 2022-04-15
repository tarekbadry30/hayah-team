@extends('layouts.app')
@section('content')
    <div class="card pt-1">

    <div class="custom-data-table ">

        <div class="card-body">
            <h2 class="page-title pt-1">
                {{__('frontend.form-sheetAnswer')}}
            </h2>
            <div class="row">

                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">{{__('frontend.name')}}</label>
                        <div class="col-sm-10 position-relative">
                            <input class="form-control"
                                   value="{{$form->name}}"  type="text" placeholder="{{__('frontend.name')}}" readonly />
                        </div>
                    </div>


                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">{{__('frontend.userType')}}</label>
                        <div class="col-sm-10 position-relative">
                            <input class="form-control"
                                   value="{{__('frontend.'.$form->user_type)}}"  type="text" placeholder="{{__('frontend.user_type')}}" readonly />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">


                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">{{__('frontend.visibleRange')}}</label>
                        <div class="col-sm-10 position-relative">
                            <input class="form-control"
                                   value="{{isset($form->from)?$form->from.' to '.$form->to:' '}}"  type="text" placeholder="{{__('frontend.visibleRange')}}" readonly />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">{{__('frontend.visible')}}</label>
                        <div class="col-sm-10 position-relative">
                            <input class="form-control" value="{{$form->visible?__('frontend.yes'):__('frontend.no')}}"  readonly />
                        </div>
                    </div>
                </div>
            </div>


            <div class="inputs-container">
                <hr>
                <div class="row pb-2">
                    <div class="col-sm-12"><h2 class="text-center">{{__('frontend.formInput')}}</h2> </div>
                </div>
                <div class="row">
                @foreach($form->inputs as $input)
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">{{__('frontend.inputItem')}}</label>
                            <div class="col-sm-10 position-relative">
                                <input class="form-control" value="{{$input->name}}"  readonly />
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            <div class="answers-container">
                <hr>
                <div class="row pb-2">
                    <div class="col-sm-12"><h2 class="text-center">{{__('frontend.formAnswers')}}</h2> </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <input type="text" class="form-control data-search-input">
                    </div>
                    <table id="mainTable" class="mt-3 table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>{{__('frontend.user')}}</th>
                            <th>{{__('frontend.userType')}}</th>
                            @foreach($form->inputs as $input)
                            <th>{{$input->name}}</th>
                            @endforeach
                            <th>{{__('frontend.date')}}</th>

                            <th>{{__('frontend.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--@foreach($form->answers as $answer)
                            <tr>
                                <td>{{$answer->user->name}}</td>
                                <td>{{__('frontend.'.$answer->user->type)}}</td>
                                @foreach($answer->inputAnswers as $ansItem)
                                <td>{{$ansItem->answer}}</td>
                                @endforeach
                                <td>{{$answer->created_at}}</td>

                                <td>
                                    <button
                                        class="btn btn-outline-danger delete-btn  waves-effect waves-light"
                                        href="{{route('form-sheets.index')}}/{{$answer->id}}"
                                        title="{{__('frontend.delete')}}"><i class="fas fa-trash-alt"></i>
                                    </button>

                                </td>
                            </tr>
                            @endforeach--}}
                        </tbody>
                    </table>

                </div>
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
                    //$(`.accept-btn[item_id="${form.find('#donation_help_id').val()}"]`).addClass('d-none');
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
                let donation_help_id = $(this).attr('donation_help_id');
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
                                data:{
                                    donation_help_id:donation_help_id
                                }
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
            $(document).on('change', '.user_type', function () {
                generateFilters(globalFiltersList,{
                    user_type:$('.user_type').val(),
                    category_id:$('.category_types').val(),
                })
            });
            $(document).on('change', '.category_types', function () {
                generateFilters(globalFiltersList,{
                    user_type:$('.user_type').val(),
                    category_id:$('.category_types').val(),
                })
            });
            $(document).on('change', '.category_options', function () {
                generateFilters(globalFiltersList,{
                    user_type:$('.user_type').val(),
                    category_id:$('.category_types').val(),

                })
            });
        });
        $(document).on('click', '.apply-filter', function () {
            setPage(1, 25);
        });
        $(document).on('click', '.accept-btn', function () {
            $('#donation_help_id').val($(this).attr('item_id'));
        });
        function setPage(page,itemsPerPage) {
            customDataTable($('#mainTable tbody'),$(".pagination-container"),'{{route('form-sheets.answerDataTable')}}',page,'get',itemsPerPage);
        }
        async function  customDataTable(tableBody,paginationContainer,url,page=1,method='get',itemsPerPage=15) {
            let results=[];
           await $.ajax({
                url: url,
                method:method,
                data: {
                    page:page,
                    itemsPerPage:itemsPerPage,
                    form_id:{{$form->id}}
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
                tableContent+=`
                <tr>
                    <td>${item.user.name}</td>
                    <td>${item.user.type=='needy'?'{{__('frontend.needy')}}':'-'}</td>`;
                for(let ansItem of item.input_answers)
                    tableContent+=`<td>${ansItem.answer}</td>`
                tableContent+=`
                <td>${item.created_at}</td>

                                <td>
                                    <button
                                        class="btn btn-outline-danger delete-btn  waves-effect waves-light"
                                        href="{{route('form-sheets.index')}}/answers/${item.id}"
                                        title="{{__('frontend.delete')}}"><i class="fas fa-trash-alt"></i>
                                    </button>

                                </td>
                            </tr>
                `;
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
            user_type:'',
            category_id:'',
        }) {
            let donation_type=$('.user_type');
            let category_types=$('.category_types');
            let donation_content=`<option selected value="">{{__('frontend.all')}}</option>`
            let category_content=`<option selected value="">{{__('frontend.all')}}</option>`
            list.forEach((item)=>{
                donation_content+=`<option ${newFilters.user_type==item.id?'selected':''} value="${item.id}">${item.name}</option>`;
                if(newFilters.user_type==item.id) {
                    item.categories.forEach((catItem) => {
                        category_content += `<option ${newFilters.category_id == catItem.id ? 'selected' : ''} value="${catItem.id}">${catItem.name}</option>`;

                    })
                }
            })
            donation_type.html(donation_content);
            category_types.html(category_content);

        }
    </script>
@endsection
