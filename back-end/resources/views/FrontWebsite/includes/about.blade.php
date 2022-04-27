<section id="section-about">
    <div class="container">
        <div class="row align-items-center" style="justify-content: space-between;">

            <div class="text-center col-lg-12 wow fadeInLeft" data-wow-delay=".4s">
                <h2 class="arabic-bold"><span class="id-color">{{__('website.about')}}</span></h2>
                <p class="arabic-bold" style="font-size:18px">
                    {{$settings->about}}
                </p>
                <div class="spacer-10"></div>
            </div>
            <div class="text-center col-lg-5 wow fadeInLeft" data-wow-delay=".8s">
                <h2 class="arabic-bold">{{__('website.ourVision')}}</h2>
                <p class="arabic-bold" style="font-size:18px">
                    {{$settings->vision}}
                </p>
                <div class="spacer-10"></div>
            </div>
            <div class="text-center col-lg-5  wow fadeInLeft" data-wow-delay="1.2s">
                <h2 class="arabic-bold"><span class="id-color">{{__('website.goals')}}</span></h2>
                <p class="arabic-bold" style="font-size:18px">{{$settings->goals}} </p>
                <div class="spacer-10"></div>
            </div>
        </div>

        <div id="skills" class="row">
            <div class="spacer-double"></div>
            <div class="spacer-double"></div>
            <div class="col-md-4">
                <div class="skill-bar style-2">
                    <h5>Design</h5>
                    <div class="de-progress">
                        <div class="value"></div>
                        <div class="progress-bar" data-value="80%"></div>
                    </div>
                </div>

                <div class="skill-bar style-2">
                    <h5>Branding</h5>
                    <div class="de-progress">
                        <div class="value"></div>
                        <div class="progress-bar" data-value="70%"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="skill-bar style-2">
                    <h5>Marketing</h5>
                    <div class="de-progress">
                        <div class="value"></div>
                        <div class="progress-bar" data-value="70%"></div>
                    </div>
                </div>

                <div class="skill-bar style-2">
                    <h5>Development</h5>
                    <div class="de-progress">
                        <div class="value"></div>
                        <div class="progress-bar" data-value="90%"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="skill-bar style-2">
                    <h5>Photography</h5>
                    <div class="de-progress">
                        <div class="value"></div>
                        <div class="progress-bar" data-value="90%"></div>
                    </div>
                </div>

                <div class="skill-bar style-2">
                    <h5>SEO</h5>
                    <div class="de-progress">
                        <div class="value"></div>
                        <div class="progress-bar" data-value="75%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
