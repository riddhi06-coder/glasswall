<!DOCTYPE html>
<html lang="en">
  <head>

    @include('components.frontend.head')

  </head>
  <body>

    @include('components.frontend.header')

    <div id="smooth-wrapper">
      <div id="smooth-content">
        <main>

          <!-- hero area start -->
          <section class="tp-breadcrumb-area tp-bg tp-overlay p-relative"
                   data-background="{{ optional($contact)->banner_image_url ?? asset('frontend/assets/images/banner/5650.webp') }}">
            <div class="container">
              <div class="tp-breadcrumb pb-50">
                <div class="page-heading">
                  <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($contact)->banner_heading ?: 'Contact Us' }}</h1>
                </div>
                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>Contact Us</span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->

          <section class="contact-info py-5">
            <div class="container">
              <div class="row g-4">

                <div class="col-md-4">
                  <div class="contact-item">
                    <img src="{{ asset('frontend/assets/images/icons/email.svg') }}" />
                    <h5>Email</h5>
                    <p class="mb-0">
                      <a href="mailto:{{ optional($contact)->email_1 }}">{{ optional($contact)->email_1 }}</a>
                    </p>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="contact-item">
                    <img src="{{ asset('frontend/assets/images/icons/pin.svg') }}" />
                    <h5>Location</h5>
                    @if(optional($contact)->map_url)
                      <a href="{{ $contact->map_url }}" target="_blank" rel="noopener" class="mb-0 d-block text-reset">
                        {!! optional($contact)->address !!}
                      </a>
                    @else
                      <div class="mb-0">
                        {!! optional($contact)->address !!}
                      </div>
                    @endif
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="contact-item">
                    <img src="{{ asset('frontend/assets/images/icons/phone.svg') }}" />
                    <h5>Call</h5>
                    <p class="mb-0">
                      <a href="tel:{{ preg_replace('/\s+/', '', optional($contact)->phone ?? '') }}">{{ optional($contact)->phone }}</a>
                    </p>
                  </div>
                </div>

              </div>
            </div>
          </section>

          <!-- contect-area,start  -->
          <section class="tp-contect-area tp-contect-spacing-2 tp-about-spacing-3 fix">
            <div class="container">
              <div class="tp-contect-map-main">
                <div class="row">
                  <div class="col-lg-5">
                    <div class="tp-contect-map-wrap">
                      <div class="tp-contect-map pt-50">
                        @if(optional($contact)->iframe_url)
                          <iframe src="{{ $contact->iframe_url }}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-7">
                    <div class="tp-contect-box tp-contect-box-inner ">
                      <div class="tp-section-title-wrap tp-text-center mb-30">
                        <h2 class="tp-section-title tp_fade_anim" data-duration=".9" data-delay=".2">
                          Keep in touch with us
                        </h2>
                      </div>
                      <form action="#">
                        <div class="row">
                          <div class="tp-contect-box-input mb-10 col-lg-6">
                            <label>Full Name *</label>
                            <input type="text" />
                          </div>
                          <div class="tp-contect-box-input mb-10 col-lg-6">
                            <label>Email *</label>
                            <input type="email" />
                          </div>
                          <div class="tp-contect-box-input mb-10 col-lg-6">
                            <label>Company Name *</label>
                            <input type="text" />
                          </div>
                          <div class="tp-contect-box-input mb-10 col-lg-6">
                            <label>Phone *</label>
                            <div class="d-flex align-items-stretch">
                              <span class="d-inline-flex align-items-center px-3"
                                    style="border:1px solid #e5e5e5; border-right:0; background:#f7f7f7; white-space:nowrap;">+91</span>
                              <input type="text" name="phone" placeholder="Enter phone number" style="flex:1; min-width:0;" />
                            </div>
                          </div>
                          <div class="tp-contect-box-input mb-20 col-lg-12">
                            <label>Message *</label>
                            <textarea rows="8" style="min-height:200px; resize:vertical;"></textarea>
                          </div>
                        </div>
                        <div class="tp-contect-box-input mb-10">
                          <a href="#" class="tp-btn tp-btn-white">
                            <span class="tp-btn-text tp-btn-white">Submit</span>
                            <span class="tp-btn-icon">
                              <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.75 10.75L10.75 0.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M0.75 0.75H10.75V10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              </svg>
                            </span>
                          </a>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- contect-area,end  -->

        </main>

        @include('components.frontend.footer')
      </div>
    </div>

    @include('components.frontend.main-js')

  </body>
</html>
