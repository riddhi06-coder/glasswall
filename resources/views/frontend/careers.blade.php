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
          <section
            class="tp-breadcrumb-area tp-bg tp-overlay p-relative"
            data-background="{{ $career && $career->banner_image ? $career->assetUrl($career->banner_image) : asset('frontend/assets/images/bread/careers.webp') }}"
          >
            <div class="container">
              <div class="tp-breadcrumb pb-50">
                <div class="page-heading">
                  <h1 class="tp-breadcrumb-title tp-text-white margin-0">
                    {{ optional($career)->banner_heading ?: 'Careers' }}
                  </h1>
                </div>
                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span>
                    <a href="{{ route('frontend.index') }}">
                      Home
                    </a>
                  </span>
                  <span class="tp-breadcrumb-dvdr">
                    -
                  </span>
                  <span>
                    Careers
                  </span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->
          <section class="gws-careers">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                    <div class="career-img">
                        <img src="{{ $career && $career->section_image ? $career->assetUrl($career->section_image) : asset('frontend/assets/images/home/careerimg.webp') }}" class="br-20"/>
                    </div>
                </div>
                <div class="col-md-7">
                     <div class="gws-careers-intro">
                <h2>
                  {{ optional($career)->section_heading }}
                </h2>
                <div>{!! optional($career)->description !!}</div>
                <h3>
                  {{ optional($career)->join_heading }}
                </h3>
                <p>
                  {{ optional($career)->short_desc }}
                </p>
              </div>
                </div>
                </div>

            </div>
          </section>
          <section class="tp-career-area tp-services-area tp-bg-gray tp-career-spacing-2 pb-150 fix">
            <div class="container">
              <div class="tp-career-heading tp-text-center mb-55 reval-line">
                <h2 class="tp-section-title">
                  {{ optional($career)->job_section_heading ?: 'Openings at GWS' }}
                </h2>
              </div>
              <div class="tp-career-jobs">
                <div class="row">
                  <div class="col-md-12">
                    <div class="tp-services gws-job-openings" id="accordionExample">
                      @forelse($jobs as $job)
                        @php $num = str_pad($loop->iteration, 2, '0', STR_PAD_LEFT); $open = $loop->first; @endphp
                        <div class="tp-services-item {{ $open ? 'active' : '' }} tp_fade_anim" data-delay=".2" data-duration=".9">
                          <div class="tp-services-header" id="heading{{ $job->id }}">
                            <div class="tp-services-button tp-services-button-black {{ $open ? '' : 'collapsed' }}"
                              role="button"
                              data-bs-toggle="collapse"
                              data-bs-target="#collapse{{ $job->id }}"
                              aria-expanded="{{ $open ? 'true' : 'false' }}"
                              aria-controls="collapse{{ $job->id }}">
                              <div class="row tp-align-center">
                                <div class="col-lg-2 col-md-2 col-2">
                                  <span class="tp-services-num">
                                    {{ $num }}
                                  </span>
                                </div>
                                <div class="col-lg-10 col-md-10 col-10">
                                  <div class="tp-services-heading-wrap tp-flex-center tp-justify-between">
                                    <div>
                                      <h3 class="tp-services-title tp-fs-24">
                                        {{ $job->job_role }}
                                      </h3>
                                    </div>
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                      <path d="M7.00002 14C6.47458 14 6.04883 13.5742 6.04883 13.0488V0.95119C6.04883 0.425753 6.47458 0 7.00002 0C7.52546 0 7.95121 0.425753 7.95121 0.95119V13.0488C7.95121 13.5742 7.52546 14 7.00002 14Z" fill="#000"/>
                                      <path d="M13.0488 7.95121H0.95119C0.425753 7.95121 0 7.52546 0 7.00002C0 6.47458 0.425753 6.04883 0.95119 6.04883H13.0488C13.5742 6.04883 14 6.47458 14 7.00002C14 7.52546 13.5742 7.95121 13.0488 7.95121Z" fill="#000"/>
                                    </svg>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="collapse{{ $job->id }}"
                            class="accordion-collapse collapse {{ $open ? 'show' : '' }}"
                            role="region"
                            aria-labelledby="heading{{ $job->id }}"
                            data-bs-parent="#accordionExample">
                            <div class="tp-services-body">
                              <div class="row">
                                <div class="col-xl-2 col-md-2 col-sm-2">
                                  <span class="tp-services-num tp-services-num-larg">
                                    {{ $num }}
                                  </span>
                                </div>
                                <div class="col-xl-10 col-md-10 col-sm-10">
                                  <div class="tp-services-content">
                                    <div class="tp-services-title-wrap tp-flex tp-justify-between">
                                      <h3 class="tp-services-title tp-services-title-larg mb-20">
                                        {{ $job->job_role }}
                                      </h3>
                                      <svg width="14" height="2" viewBox="0 0 14 2" fill="none">
                                        <path d="M13.0488 1.90238H0.95119C0.425753 1.90238 0 1.47663 0 0.95119C0 0.425753 0.425753 0 0.95119 0H13.0488C13.5742 0 14 0.425753 14 0.95119C14 1.47663 13.5742 1.90238 13.0488 1.90238Z" fill="black"/>
                                      </svg>
                                    </div>
                                    <div class="gws-job-details">
                                      <div class="gws-job-section">
                                        <h4>
                                          Job Description
                                        </h4>
                                        <div>{!! $job->description !!}</div>
                                      </div>
                                      <div class="gws-job-info">
                                        <div>
                                          <span>
                                            Location
                                          </span>
                                          <strong>
                                            {{ $job->location }}
                                          </strong>
                                        </div>
                                        <div>
                                          <span>
                                            Employment Type
                                          </span>
                                          <strong>
                                            {{ $job->employment_type }}
                                          </strong>
                                        </div>
                                        <div>
                                          <span>
                                            Experience
                                          </span>
                                          <strong>
                                            {{ $job->experience }}
                                          </strong>
                                        </div>
                                        <div>
                                          <span>
                                            Qualification
                                          </span>
                                          <strong>
                                            {{ $job->qualification }}
                                          </strong>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="gws-job-apply">
                                      <a href="#" data-bs-toggle="modal" data-bs-target="#jobApplyModal" data-job-role="{{ $job->job_role }}" class="tp-btn tp-btn-white">
                                        <span class="tp-btn-text tp-btn-white">
                                          Apply Now
                                        </span>
                                        <span class="tp-btn-icon">
                                          <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.75 10.75L10.75 0.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path d="M0.75 0.75H10.75V10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                          </svg>
                                        </span>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @empty
                        <div class="tp-text-center">
                          <p>No current openings. Please check back later.</p>
                        </div>
                      @endforelse
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <div class="modal fade" id="jobApplyModal" tabindex="-1" aria-labelledby="jobApplyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="jobApplyModalLabel">
                    Apply for a Position
                  </h5>
                  <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                  </button>
                </div>
                <div class="modal-body">
                  <form id="jobApplicationForm" action="{{ route('frontend.careers.apply') }}" method="post" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row">
                      <div class="col-12 mb-3">
                        <label for="jobRole" class="form-label">
                          Position Applied For
                        </label>
                        <input type="text"
                                class="form-control"
                                id="jobRole"
                                name="job_role"
                                value="{{ old('job_role') }}"
                                readonly>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="firstName" class="form-label">
                          First Name
                          <span>
                            *
                          </span>
                        </label>
                        <input type="text"
                                class="form-control {{ $errors->career->has('first_name') ? 'is-invalid' : '' }}"
                                id="firstName"
                                name="first_name"
                                value="{{ old('first_name') }}"
                                required>
                        <small class="form-error {{ $errors->career->has('first_name') ? 'show' : '' }}" data-for="first_name">{{ $errors->career->first('first_name') }}</small>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="lastName" class="form-label">
                          Last Name
                          <span>
                            *
                          </span>
                        </label>
                        <input type="text"
                                class="form-control {{ $errors->career->has('last_name') ? 'is-invalid' : '' }}"
                                id="lastName"
                                name="last_name"
                                value="{{ old('last_name') }}"
                                required>
                        <small class="form-error {{ $errors->career->has('last_name') ? 'show' : '' }}" data-for="last_name">{{ $errors->career->first('last_name') }}</small>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="emailAddress" class="form-label">
                          Email Address
                          <span>
                            *
                          </span>
                        </label>
                        <input type="email"
                                class="form-control {{ $errors->career->has('email') ? 'is-invalid' : '' }}"
                                id="emailAddress"
                                name="email"
                                value="{{ old('email') }}"
                                required>
                        <small class="form-error {{ $errors->career->has('email') ? 'show' : '' }}" data-for="email">{{ $errors->career->first('email') }}</small>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="contactNo" class="form-label">
                          Contact No.
                          <span>
                            *
                          </span>
                        </label>
                        <input type="tel"
                                class="form-control {{ $errors->career->has('contact_no') ? 'is-invalid' : '' }}"
                                id="contactNo"
                                name="contact_no"
                                value="{{ old('contact_no') }}"
                                inputmode="numeric"
                                maxlength="10"
                                required>
                        <small class="form-error {{ $errors->career->has('contact_no') ? 'show' : '' }}" data-for="contact_no">{{ $errors->career->first('contact_no') }}</small>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="resume" class="form-label">
                          Upload Resume
                          <span>
                            *
                          </span>
                        </label>
                        <input type="file"
                                class="form-control {{ $errors->career->has('resume') ? 'is-invalid' : '' }}"
                                id="resume"
                                name="resume"
                                accept=".pdf,.doc,.docx"
                                required>
                        <div class="form-text">
                          Accepted formats: PDF, DOC, DOCX (max 3 MB)
                        </div>
                        <small class="form-error {{ $errors->career->has('resume') ? 'show' : '' }}" data-for="resume">{{ $errors->career->first('resume') }}</small>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="message" class="form-label">
                          Message
                        </label>
                        <textarea class="form-control"
                                id="message"
                                name="message"
                                rows="5">{{ old('message') }}</textarea>
                      </div>
                      <div class="col-12">
                        <button type="submit" class="tp-btn tp-btn-white">
                                      <span class="tp-btn-text tp-btn-white">
                                        Submit Application
                                      </span>
                                      <span class="tp-btn-icon">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M0.75 10.75L10.75 0.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                          </path>
                                          <path d="M0.75 0.75H10.75V10.75" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                          </path>
                                        </svg>
                                      </span>
                                    </button>
                        <div class="form-status" data-status></div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </main>

        @include('components.frontend.footer')
      </div>
    </div>

    @include('components.frontend.main-js')

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('jobApplyModal');
        if (!modal) return;

        // The GSAP ScrollSmoother wrapper (#smooth-content) uses a CSS transform,
        // which traps position:fixed modals inside it. Move the modal to <body>
        // so it overlays the page correctly.
        if (modal.parentElement !== document.body) {
          document.body.appendChild(modal);
        }

        // Fill the "Position Applied For" field from the clicked job's Apply button.
        modal.addEventListener('show.bs.modal', function (event) {
          var trigger = event.relatedTarget;
          if (!trigger) return;
          var role = trigger.getAttribute('data-job-role') || '';
          var input = modal.querySelector('#jobRole');
          if (input) input.value = role;
        });

        // Client-side validation (mirrors the server rules). On success the form submits
        // normally and the server redirects to the thank-you page.
        var form = document.getElementById('jobApplicationForm');
        if (form) {
          var nameRe  = /^[A-Za-z][A-Za-z .'\-]*$/;
          var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          var phoneRe = /^\d{10}$/;
          var okExt   = ['pdf', 'doc', 'docx'];
          var MAX     = 3 * 1024 * 1024;

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
            var fn = val('first_name'), ln = val('last_name');
            ok = setErr('first_name', (fn.length >= 2 && nameRe.test(fn)) ? '' : 'Please enter a valid first name (letters only).') && ok;
            ok = setErr('last_name',  (ln.length >= 2 && nameRe.test(ln)) ? '' : 'Please enter a valid last name (letters only).') && ok;
            ok = setErr('email', emailRe.test(val('email')) ? '' : 'Please enter a valid email address.') && ok;
            ok = setErr('contact_no', phoneRe.test(val('contact_no')) ? '' : 'Please enter a valid 10-digit contact number.') && ok;

            var f = fieldEl('resume');
            var file = f && f.files ? f.files[0] : null;
            if (!file) {
              ok = setErr('resume', 'Please upload your resume.') && ok;
            } else {
              var ext = file.name.split('.').pop().toLowerCase();
              if (okExt.indexOf(ext) === -1) ok = setErr('resume', 'Resume must be a PDF, DOC or DOCX file.') && ok;
              else if (file.size > MAX)      ok = setErr('resume', 'Resume is too large (max 3 MB).') && ok;
              else ok = setErr('resume', '') && ok;
            }
            return ok;
          }

          var contact = fieldEl('contact_no');
          if (contact) contact.addEventListener('input', function () { this.value = this.value.replace(/\D/g, '').slice(0, 10); });

          form.querySelectorAll('[name]').forEach(function (el) {
            var ev = el.type === 'file' ? 'change' : 'input';
            el.addEventListener(ev, function () { setErr(el.getAttribute('name'), ''); });
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
            if (label) label.textContent = 'Submitting...';
          });
        }

        // Re-open the modal after a validation error so the user sees the highlighted fields.
        @if($errors->career->any())
          if (window.bootstrap) {
            bootstrap.Modal.getOrCreateInstance(modal).show();
          }
        @endif
      });
    </script>

    <style>
      #jobApplicationForm .form-error { display:none; color:#e03131; font-size:12px; margin-top:4px; }
      #jobApplicationForm .form-error.show { display:block; }
      #jobApplicationForm .is-invalid { border-color:#e03131 !important; }
      #jobApplicationForm .form-status { margin-top:12px; font-size:14px; display:none; }
      #jobApplicationForm .form-status.show { display:block; }
      #jobApplicationForm .form-status.success { color:#2b8a3e; }
      #jobApplicationForm .form-status.error { color:#e03131; }
    </style>

  </body>
</html>
