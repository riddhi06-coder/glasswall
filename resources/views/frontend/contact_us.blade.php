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
                      <form id="contactForm" action="{{ route('frontend.contact.submit') }}" method="post" novalidate>
                        @csrf
                        <div class="row">
                          <div class="tp-contect-box-input mb-10 col-lg-6">
                            <label>Full Name *</label>
                            <input type="text" name="name" />
                            <small class="form-error" data-for="name"></small>
                          </div>
                          <div class="tp-contect-box-input mb-10 col-lg-6">
                            <label>Email *</label>
                            <input type="email" name="email" />
                            <small class="form-error" data-for="email"></small>
                          </div>
                          <div class="tp-contect-box-input mb-10 col-lg-6">
                            <label>Company Name *</label>
                            <input type="text" name="company" />
                            <small class="form-error" data-for="company"></small>
                          </div>
                          <div class="tp-contect-box-input mb-10 col-lg-6">
                            <label>Phone *</label>
                            <div style="position: relative;">
                              <span style="position:absolute; left:24px; top:50%; transform:translateY(-50%); color:#8a8a8a; pointer-events:none;">+91</span>
                              <input type="text" name="phone" inputmode="numeric" maxlength="10" style="padding-left:58px;" />
                            </div>
                            <small class="form-error" data-for="phone"></small>
                          </div>
                          <div class="tp-contect-box-input mb-20 col-lg-12">
                            <label>Message *</label>
                            <textarea name="message" rows="8" style="min-height:200px; resize:vertical;"></textarea>
                            <small class="form-error" data-for="message"></small>
                          </div>
                        </div>
                        <div class="tp-contect-box-input mb-10">
                          <button type="submit" class="tp-btn tp-btn-white">
                            <span class="tp-btn-text tp-btn-white">Submit</span>
                            <span class="tp-btn-icon">
                              <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.75 10.75L10.75 0.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M0.75 0.75H10.75V10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              </svg>
                            </span>
                          </button>
                          <div class="form-status" data-status></div>
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

    <style>
      .form-error { display:none; color:#e03131; font-size:12px; margin-top:4px; }
      .form-error.show { display:block; }
      .is-invalid { border-color:#e03131 !important; }
      .form-status { margin-top:12px; font-size:14px; display:none; }
      .form-status.show { display:block; }
      .form-status.success { color:#2b8a3e; }
      .form-status.error { color:#e03131; }
    </style>
    <script>
      (function () {
        var form = document.getElementById('contactForm');
        if (!form) return;
        var token = document.querySelector('meta[name="csrf-token"]');
        var status = form.querySelector('[data-status]');

        function clearErrors() {
          form.querySelectorAll('.form-error').forEach(function (el) { el.textContent = ''; el.classList.remove('show'); });
          form.querySelectorAll('.is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });
          if (status) { status.className = 'form-status'; status.textContent = ''; }
        }
        function showErrors(errors) {
          Object.keys(errors).forEach(function (field) {
            var box = form.querySelector('.form-error[data-for="' + field + '"]');
            var input = form.querySelector('[name="' + field + '"]');
            if (box) { box.textContent = errors[field][0]; box.classList.add('show'); }
            if (input) input.classList.add('is-invalid');
          });
        }
        function setStatus(type, msg) {
          if (!status) return;
          status.className = 'form-status show ' + type;
          status.textContent = msg;
        }

        form.addEventListener('submit', function (e) {
          e.preventDefault();
          clearErrors();
          var btn = form.querySelector('button[type="submit"]');
          var label = btn ? btn.querySelector('.tp-btn-text') : null;
          var orig = label ? label.textContent : '';
          if (btn) { btn.disabled = true; btn.style.opacity = '.65'; }
          if (label) label.textContent = 'Sending...';

          fetch(form.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token ? token.content : '', 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: new FormData(form)
          }).then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
            .then(function (res) {
              if (res.data && res.data.ok) {
                form.reset();
                setStatus('success', res.data.message || 'Your message has been sent.');
              } else if (res.data && res.data.errors) {
                showErrors(res.data.errors);
                setStatus('error', 'Please correct the highlighted fields.');
              } else {
                setStatus('error', (res.data && res.data.message) || 'Something went wrong. Please try again.');
              }
            }).catch(function () {
              setStatus('error', 'Network error. Please try again.');
            }).finally(function () {
              if (btn) { btn.disabled = false; btn.style.opacity = ''; }
              if (label) label.textContent = orig;
            });
        });
      })();
    </script>

  </body>
</html>
