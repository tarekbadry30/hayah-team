<!-- section begin -->
<section id="section-portfolio" class="bg-light">
    <div class="container">
        <!-- portfolio filter begin -->
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="arabic-bold"><span class="id-color">{{__('website.portfolio')}}</span></h2>
            </div>

            <div class="spacer-single"></div>

            <div class="col-md-12 text-center ">
                <ul id="filters" class="d-none">
                    <li><a href="#" data-filter="*" class="selected">all projects</a></li>
                    <li><a href="#" data-filter=".illustration">illustration</a></li>
                    <li><a href="#" data-filter=".mobile">mobile</a></li>
                    <li><a href="#" data-filter=".photography">photography</a></li>
                    <li><a href="#" data-filter=".website">website</a></li>
                </ul>

                <div id="gallery" class="gallery full-gallery de-gallery pf_full_width pf_3_cols grid sequence">
                    @foreach($portfolios as $portfolio)
                    <!-- gallery item -->
                    <div class="item illustration website gallery-item pf-click" data-value="{{route('website.portfolioShow',['portfolio'=>$portfolio])}}">
                        <div class="picframe wow">
                                            <span class="overlay">
                                                <span class="pf_text">
                                                    <span class="project-name">{{$portfolio->name}}</span>
                                                </span>
                                            </span>
                            <img src="{{asset($portfolio->image)}}" alt="" />
                        </div>
                    </div>
                    <!-- close gallery item -->
                        @endforeach
                </div>
            </div>
            <!-- portfolio filter close -->
        </div>
    </div>
</section>
<!-- section close -->

<div id="loader-area">
    <div class="container">
        <div class="project-load"></div>
    </div>
</div>
