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

          <section class="tp-project-page-area pt-180 pb-100">
            <div class="container">

              <div class="row">
                <div class="col-12">
                  <div class="tp-section-title-wrapper mb-60 text-center">
                    <span class="tp-section-subtitle">Our Work</span>
                    <h2 class="tp-section-title">{{ $category->name }}</h2>
                  </div>
                </div>
              </div>

              @if($projects->isEmpty())
                <div class="row">
                  <div class="col-12 text-center">
                    <p>No projects available in this category yet.</p>
                  </div>
                </div>
              @else
                <div class="row gy-4">
                  @foreach($projects as $project)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                      <div class="tp-project-item">
                        <div class="tp-project-thumb">
                          <img src="{{ $project->thumbnail_url }}" alt="{{ $project->name }}"
                               style="width:100%; height:320px; object-fit:cover; border-radius:10px;" />
                        </div>
                        <div class="tp-project-content mt-20">
                          <h3 class="tp-project-title mb-5">{{ $project->name }}</h3>
                          @if($project->location)
                            <span class="tp-project-location">{{ $project->location }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif

            </div>
          </section>

        </main>

        @include('components.frontend.footer')
      </div>
    </div>

    @include('components.frontend.main-js')

  </body>
</html>
