@extends('layouts.app')
@section('css')

@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <form novalidate  class="create-form pt-3 {{session()->has('errorsq')?'was-validated':''}}"
                          action="{{route('portfolio.update',['portfolio'=>$portfolio])}}" method="post">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" value="{{$portfolio->id}}">
                        <h4 class="header-title">{{__('frontend.editPortfolio')}}</h4>
                        <!-- Nav tabs -->
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">{{__('frontend.img')}}</label>
                            <div class="col-sm-10 position-relative">
                                <img src="{{asset($portfolio->img)}}" class="avatar-lg">
                            </div>
                        </div>                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            @foreach(config('translatable.locales') as $locale)
                                <li class="nav-item" {{$errorsCount=0}}>
                                    <a errors-count="{{$errorsCount=substr_count(implode(" ",array_keys($errors->toArray())),"$locale.")}}" class="{{$errorsCount>0?'nav-errors':''}} nav-link {{$locale==app()->getLocale()?'active':''}} " data-bs-toggle="tab" href="#{{$locale}}" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">
                                        @lang('frontend.'.$locale.'.locale')
                                        <span class="badge rounded-pill bg-danger py-1 {{$errorsCount>0?'':'d-none'}}" >{{$errorsCount}}</span>
                                    </span>
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
                                                   value="{{old($locale.'.name',$portfolio->translate($locale)->name)}}"  type="text" placeholder="{{__('frontend.'.$locale.'.name')}}"
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
                                      placeholder="{{__('frontend.'.$locale.'.desc')}}" id="desc" name="{{$locale}}[desc]">{{old($locale.'.desc',$portfolio->translate($locale)->desc)}}</textarea>
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
                            <label for="visible" class="col-sm-2 col-form-label">{{__('frontend.visible')}}</label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="visible" switch="bool" {{$portfolio->visible?'checked':''}} name="visible" />
                                <label for="visible" data-on-label="Yes" data-off-label="No"></label>
                                @error('visible')
                                <div class="invalid-tooltip position-static">
                                    {{$message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 justify-content-center">
                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light col-sm-3 mx-1">
                                {{__('frontend.save')}}</button>
                            <a href="{{route('portfolio.index')}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

                        </div>

                    </form>


                </div>
            </div>
        </div> <!-- end col -->
    </div>


@endsection

@section('js')

    <!-- Plugins js -->
    <script src="{{asset("assets/libs/dropzone/min/dropzone.min.js")}}"></script>
    <script>
        $(document).ready(function () {
            /*var myDropzone = new Dropzone(".dropzone_form", {
                autoProcessQueue: false,
                url:  "{{route('categories.uploadImg')}}",
                addRemoveLinks: true,
                maxFilesize: 1,
                acceptedFiles: ".jpeg,.jpg,.png",
                sending: function(file, xhr, formData) {
                    formData.append("_token", "{{ csrf_token() }}");
                },
            });
            function submitMainForm(){
                let Form=$(".create-form");
                $.ajax({
                    url: Form.attr('action'),
                    method:Form.attr('method'),
                    data: Form.serialize(),
                    success: function (data) {
                        console.log('Submission was successful.');
                        console.log(data);
                    },
                    error: function (data) {
                        console.log('An error occurred.');
                        console.log(data);
                    },
                }).done(function() {

                });
            }
            $(".submit-form").click(function (e) {
                submitMainForm();
                //myDropzone.processQueue();
            });

            console.clear()
            console.log('init 1')
            $(".select2-search-disable").select2();*/
            $("input[name='needed_value']").TouchSpin({
                step: 0.1,
                decimals: 2,
                initval: 1,
                max:1000000,
                min:0.1,
                buttondown_class: "btn btn-primary",
                buttonup_class: "btn btn-primary"
            });

            $('#visible').change(function () {
                console.log($(this).is(':checked'));
                if($(this).is(':checked')){
                    $('.visible-container').removeClass('d-none');
                }else{
                    $('.visible-container').addClass('d-none');

                }
            })
        })
    </script>
@endsection
