@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <form novalidate
                          class="create-form pt-3 {{session()->has('errorsq')?'was-validated':''}}"
                          action="{{route('donation-helps.store')}}" method="post">
                        @csrf
                        <h4 class="header-title">{{__('frontend.createDonationType')}} </h4>
                        <!-- Nav tabs -->
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
                                    <label for="name" class="col-sm-2 col-form-label">{{__('frontend.'.$locale.'.name')}}</label>
                                    <div class="col-sm-10 position-relative">
                                        <input class="form-control @error($locale.'.name') parsley-error is-invalid @enderror"
                                               value="{{old($locale.'.name')}}"  type="text" placeholder="{{__('frontend.'.$locale.'.name')}}"
                                               id="name" name="{{$locale}}[name]"/>
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
                                          placeholder="{{__('frontend.'.$locale.'.desc')}}" id="desc" name="{{$locale}}[desc]">{{old($locale.'.desc')}}</textarea>
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
                        <div class="row mb-3 filters_container">
                                <label class="col-sm-2 col-form-label" for="donation_types">{{__('frontend.donationType')}}</label>
                                <div class="col-sm-10">
                                    <select id="donation_types" class="form-control donation_types" name="type_id">
                                        <option value="">{{__('frontend.none')}}</option>
                                    </select>
                                </div>
                        </div>
                        <div class="row mb-3 filters_container">
                            <label class="col-sm-2 col-form-label" for="category_id">{{__('frontend.category')}}</label>
                            <div class="col-sm-10 form-group">
                                <select class="form-control category_types" name="category_id" id="category_id">
                                    <option value="">{{__('frontend.none')}}</option>
                                </select>
                            </div>
                        </div>


                        <div class="row mb-3 justify-content-center">
                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light col-sm-3 mx-1">
                                {{__('frontend.save')}}</button>
                            <a href="{{route('donation-helps.index')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

                        </div>

                    </form>


                </div>
            </div>
        </div> <!-- end col -->
    </div>


@endsection

@section('js')
    <script>
        function generateFilters(list,newFilters={
            type_id:'',
            category_id:'',
        }) {
            let donation_type=$('.donation_types');
            let category_types=$('.category_types');
            let donation_content=`<option selected value="">{{__('frontend.none')}}</option>`
            let category_content=`<option selected value="">{{__('frontend.none')}}</option>`
            list.forEach((item)=>{
                donation_content+=`<option ${newFilters.type_id==item.id?'selected':''} value="${item.id}">${item.name}</option>`;
                if(newFilters.type_id==item.id) {
                    item.categories.forEach((catItem) => {
                        category_content += `<option ${newFilters.category_id == catItem.id ? 'selected' : ''} value="${catItem.id}">${catItem.name}</option>`;
                    })
                }
            })
            donation_type.html(donation_content);
            category_types.html(category_content);

        }
        $(document).ready(function () {
            $(document).on('change', '.donation_types', function () {
                generateFilters(globalFiltersList,{
                    type_id:$('.donation_types').val(),
                    category_id:$('.category_types').val(),
                })
            });
            $("input[name='default_value']").TouchSpin({
                step: 0.1,
                decimals: 2,
                initval: 1,
                max:1000000,
                min:0.1,
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary"
            });
            $.ajax({
                url: "{{route('categories.listForFilter')}}",
                method: 'get',
            }).done(function (data) {
                globalFiltersList=data.data;
                generateFilters(globalFiltersList)

            });
            $('.option_type').change(function () {
                if($(this).val()=='finance'){
                    $('.finance').removeClass('d-none');
                }else{
                    $('.finance').addClass('d-none');

                }
            })
        })
    </script>
@endsection
