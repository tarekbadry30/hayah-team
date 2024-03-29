<div class="project-view">
    <div id="btn-close">
        <div class="line-1"></div>
        <div class="line-2"></div>
    </div>

    <div class="row">
        <div class="col-md-8 row">
            <div class="col-md-12 mb30">
                <img src="{{asset($portfolio->image)}}" alt="" class="img-fluid" />
            </div>
        </div>

        <div class="col-md-4">
            <div class="project-info">
                <h2 class="{{LaravelLocalization::getCurrentLocale()=='ar'?'text-right':'text-left'}} arabic-bold d-block">{{$portfolio->name}}</h2>
                <p class="{{LaravelLocalization::getCurrentLocale()=='ar'?'text-right':'text-left'}} arabic">{{$portfolio->desc}}</p>
            </div>
        </div>
    </div>
</div>
