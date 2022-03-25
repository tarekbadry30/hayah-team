@extends('layouts.app')
@section('css')
    <!-- Plugins css -->
    <link href="{{asset('assets/libs/dropzone/min/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .pointer-event{
            cursor: pointer;
        }
        .dz-success-mark{
            display: inline;
        }
        .dz-error-mark{
            display: inline;
        }
        .dz-remove{
            display: block;
        }
    </style>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card pt-3">
                <div class="card-body">
                    <h4 class="header-title">{{$msg}}</h4>
                    <div class="row mb-3">
                        <div class="col-sm-12 position-relative">
                            <form action="{{$uploadRoute}}" class="dropzone_form">
                                <div class="fallback">
                                    <input name="file" type="file">
                                    @csrf
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3 text-center pointer-event">
                                        <i class="display-4 text-muted mdi mdi-cloud-upload-outline"></i>
                                    </div>

                                    <h4 class="text-center pointer-event">{{__('frontend.img')}}</h4>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="row mb-3 justify-content-center">
                        <button type="button" class="btn btn-outline-primary waves-effect waves-light col-sm-3 mx-1 submit-form">
                            {{__('frontend.save')}}</button>
                        <a href="{{$backRoute}}" class="btn btn-outline-secondary waves-effect waves-light col-sm-3 mx-1">{{__('frontend.cancel')}}</a>

                    </div>

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
            var myDropzone = new Dropzone(".dropzone_form", {
                autoProcessQueue: false,
                url:  "{{$uploadRoute}}",
                addRemoveLinks: true,
                maxFilesize: {{$files['max']}},
                acceptedFiles: "{{$files['mimes']}}",
                sending: function(file, xhr, formData) {
                    formData.append("_token", "{{ csrf_token() }}");
                    formData.append("{{$input['name']}}", "{{$input['value']}}");
                },
                success:function(file){
                    Swal.fire({
                        title: "{{__('frontend.uploadCompleted')}}",
                        icon: "success",
                        confirmButtonColor: "#1cbb8c",
                        confirmButtonText: "{{__('frontend.ok')}}",
                    }).then(function (result) {
                        window.location.href = "{{$backRoute}}"
                    });
                },
                error: function(file, response) {
                    Swal.fire({
                        title: "{{__('frontend.errorHappen')}}",
                        icon: "error",
                        confirmButtonColor: "#1cbb8c",
                        confirmButtonText: "{{__('frontend.ok')}}",
                    });
                    console.log(response);
                    if($.type(response) === "string")
                        var message = response; //dropzone sends it's own error messages in string
                    else
                        var message = response.message;
                    file.previewElement.classList.add("dz-error");
                    _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                    _results = [];
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i];
                        _results.push(node.textContent = message);
                    }
                    return _results;
                }
            });
            $(".submit-form").click(function (e) {
                myDropzone.processQueue();
            });
            //console.clear()
            console.log('init 1')
            $(".select2-search-disable").select2();
        })
    </script>
@endsection
