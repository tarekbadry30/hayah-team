<!-- section begin -->
<section id="section-portfolio">
    <div class="container">
        <!-- portfolio filter begin -->
        <div class="row">
            <div class="col-md-12 text-center">
                <h2><span class="id-color">{{__('frontend.portfolio')}}</span></h2>
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
                    <!-- gallery item -->
                    <div class="item illustration website gallery-item pf-click" data-value="project-details-image.html">
                        <div class="picframe wow">
                                            <span class="overlay">
                                                <span class="pf_text">
                                                    <span class="project-name">Multi Images</span>
                                                </span>
                                            </span>
                            <img src="{{asset('front_website')}}/images/portfolio/1.jpg" alt="" />
                        </div>
                    </div>
                    <!-- close gallery item -->

                    <!-- gallery item -->
                    <div class="item photography gallery-item pf-click" data-value="project-details-slider.html">
                        <div class="picframe wow">
                                            <span class="overlay">
                                                <span class="pf_text">
                                                    <span class="project-name">Slider Images</span>
                                                </span>
                                            </span>
                            <img src="{{asset('front_website')}}/images/portfolio/2.jpg" alt="" />
                        </div>
                    </div>
                    <!-- close gallery item -->

                    <!-- gallery item -->
                    <div class="item illustration gallery-item pf-click" data-value="project-details-youtube.html">
                        <div class="picframe wow">
                                            <span class="overlay">
                                                <span class="pf_text">
                                                    <span class="project-name">Youtube Video</span>
                                                </span>
                                            </span>
                            <img src="{{asset('front_website')}}/images/portfolio/3.jpg" alt="" />
                        </div>
                    </div>
                    <!-- close gallery item -->

                    <!-- gallery item -->
                    <div class="item photography illustration mobile gallery-item pf-click" data-value="project-details-image-big.html">
                        <div class="picframe wow">
                                            <span class="overlay">
                                                <span class="pf_text">
                                                    <span class="project-name">Multi Images Big</span>
                                                </span>
                                            </span>
                            <img src="{{asset('front_website')}}/images/portfolio/4.jpg" alt="" />
                        </div>
                    </div>
                    <!-- close gallery item -->

                    <!-- gallery item -->
                    <div class="item photography mobile website gallery-item pf-click" data-value="project-details-slider-big.html">
                        <div class="picframe wow">
                                            <span class="overlay">
                                                <span class="pf_text">
                                                    <span class="project-name">Slider Images Big</span>
                                                </span>
                                            </span>
                                <img src="{{asset('front_website')}}/images/portfolio/5.jpg" alt="" />
                        </div>
                    </div>
                    <!-- close gallery item -->

                    <!-- gallery item -->
                    <div class="item mobile website gallery-item pf-click" data-value="project-details-youtube-big.html">
                        <div class="picframe wow">
                                            <span class="overlay">
                                                <span class="pf_text">
                                                    <span class="project-name">Youtube Video Big</span>
                                                </span>
                                            </span>
                            <img src="{{asset('front_website')}}/images/portfolio/6.jpg" alt="" />
                        </div>
                    </div>
                    <!-- close gallery item -->
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
