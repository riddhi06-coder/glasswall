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
                            <input type="text" name="name" value="{{ old('name') }}" class="{{ $errors->contact->has('name') ? 'is-invalid' : '' }}" />
                            <small class="form-error {{ $errors->contact->has('name') ? 'show' : '' }}" data-for="name">{{ $errors->contact->first('name') }}</small>
                          </div>
                          <div class="tp-contect-box-input mb-10 col-lg-6">
                            <label>Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="{{ $errors->contact->has('email') ? 'is-invalid' : '' }}" />
                            <small class="form-error {{ $errors->contact->has('email') ? 'show' : '' }}" data-for="email">{{ $errors->contact->first('email') }}</small>
                          </div>
                          <div class="tp-contect-box-input mb-10 col-lg-6">
                            <label>Company Name *</label>
                            <input type="text" name="company" value="{{ old('company') }}" class="{{ $errors->contact->has('company') ? 'is-invalid' : '' }}" />
                            <small class="form-error {{ $errors->contact->has('company') ? 'show' : '' }}" data-for="company">{{ $errors->contact->first('company') }}</small>
                          </div>
                          <div class="tp-contect-box-input mb-10 col-lg-6">
                            <label>Phone *</label>
                            <div style="position: relative;">
                              <span style="position:absolute; left:24px; top:50%; transform:translateY(-50%); color:#8a8a8a; pointer-events:none;">+91</span>
                              <input type="text" name="phone" value="{{ old('phone') }}" inputmode="numeric" maxlength="10" style="padding-left:58px;" class="{{ $errors->contact->has('phone') ? 'is-invalid' : '' }}" />
                            </div>
                            <small class="form-error {{ $errors->contact->has('phone') ? 'show' : '' }}" data-for="phone">{{ $errors->contact->first('phone') }}</small>
                          </div>
                          <div class="tp-contect-box-input mb-20 col-lg-12">
                            <label>Message *</label>
                            <textarea name="message" rows="8" style="min-height:200px; resize:vertical;" class="{{ $errors->contact->has('message') ? 'is-invalid' : '' }}">{{ old('message') }}</textarea>
                            <small class="form-error {{ $errors->contact->has('message') ? 'show' : '' }}" data-for="message">{{ $errors->contact->first('message') }}</small>
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
      // Client-side validation (mirrors the server rules). On success the form submits
      // normally and the server redirects to the thank-you page.
      (function () {
        var form = document.getElementById('contactForm');
        if (!form) return;

        var nameRe  = /^[A-Za-z][A-Za-z .'\-]*$/;
        var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var phoneRe = /^\d{10}$/;

        function fieldEl(name) { return form.querySelector('[name="' + name + '"]'); }
        function val(name) { var el = fieldEl(name); return el ? el.value.trim() : ''; }
        function setErr(name, msg) {
          var box = form.querySelector('.form-error[data-for="' + name + '"]');
          var input = fieldEl(name);
          if (box) { box.textContent = msg || ''; box.classList.toggle('show', !!msg); }
          if (input) input.classList.toggle('is-invalid', !!msg);
          return !msg;
        }

        function validate() {
          var ok = true;
          var name = val('name');
          ok = setErr('name', (name.length >= 2 && nameRe.test(name)) ? '' : 'Please enter a valid name (letters only).') && ok;
          ok = setErr('email', emailRe.test(val('email')) ? '' : 'Please enter a valid email address.') && ok;
          ok = setErr('company', val('company') ? '' : 'Please enter your company.') && ok;
          ok = setErr('phone', phoneRe.test(val('phone')) ? '' : 'Please enter a valid 10-digit phone number.') && ok;
          ok = setErr('message', val('message').length >= 5 ? '' : 'Please enter your message.') && ok;
          return ok;
        }

        // keep phone numeric only
        var phone = fieldEl('phone');
        if (phone) phone.addEventListener('input', function () { this.value = this.value.replace(/\D/g, '').slice(0, 10); });

        // clear a field's error as the user corrects it
        form.querySelectorAll('[name]').forEach(function (el) {
          el.addEventListener('input', function () { setErr(el.getAttribute('name'), ''); });
        });

        form.addEventListener('submit', function (e) {
          if (!validate()) {
            e.preventDefault();
            var firstBad = form.querySelector('.is-invalid');
            if (firstBad) firstBad.focus();
            return;
          }
          var btn = form.querySelector('button[type="submit"]');
          var label = btn ? btn.querySelector('.tp-btn-text') : null;
          if (btn) { btn.disabled = true; btn.style.opacity = '.65'; }
          if (label) label.textContent = 'Sending...';
        });
      })();
    </script>

  </body>
</html>
