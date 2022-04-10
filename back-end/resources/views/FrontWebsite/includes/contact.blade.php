<!-- section begin -->
<section id="section-contact" class="no-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="text-center">
                    <h2>Contact Us</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div class="spacer-30"></div>
                </div>
            </div>
        </div>

        <form name="contactForm" id="contact_form" class="row form-default" method="post" action="email.php">
            <div class="col-md-6">
                <div class="field-set">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" />
                    <div class="line-fx"></div>
                </div>

                <div class="field-set">
                    <input type="text" name="email" id="email" class="form-control" placeholder="Your Email" />
                    <div class="line-fx"></div>
                </div>

                <div class="field-set">
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Your Phone" />
                    <div class="line-fx"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="field-set">
                    <textarea name="message" id="message" class="form-control" placeholder="Your Message"></textarea>
                    <div class="line-fx"></div>
                </div>
            </div>

            <div class="spacer-single"></div>

            <div class="col-md-12 text-center">
                <div id="submit">
                    <input type="submit" id="send_message" value="Submit Form" class="btn btn-custom color-2" />
                </div>
                <div id="mail_success" class="success">Your message has been sent successfully.</div>
                <div id="mail_fail" class="error">Sorry, error occured this time sending your message.</div>
            </div>
        </form>

        <div class="spacer-double"></div>

        <div class="row text-center wow fadeInUp">
            <div class="col-md-4">
                <div class="wm-1"></div>
                <i class="icon_mobile id-color size40 mb20"></i>
                <h6 class="id-color">Call Us</h6>
                <p>(208) 333 9296</p>
            </div>

            <div class="col-md-4">
                <div class="wm-1"></div>
                <i class="icon_house_alt id-color size40 mb20"></i>
                <h6 class="id-color">Visit Office</h6>
                <p>Collins Street West, London, UK</p>
            </div>

            <div class="col-md-4">
                <div class="wm-1"></div>
                <i class="icon_mail_alt id-color size40 mb20"></i>
                <h6 class="id-color">Email Us</h6>
                <p>contact@jess-template.com</p>
            </div>
        </div>
    </div>
</section>
