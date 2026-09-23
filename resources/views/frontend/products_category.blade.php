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
            data-background="{{ asset('frontend/assets/images/products.webp') }}"
          >
            <div class="container">
              <div class="tp-breadcrumb pb-50">
                  <div class="page-heading">
                <h1 class="tp-breadcrumb-title tp-text-white margin-0">Our Products</h1>
                </div>

                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span><a href="{{ route('frontend.products_category_listing') }}">Our Products</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>{{ $category->name }}</span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->

          <section class="product-section">
            <div class="container">
              <!-- Heading -->

              <div class="row align-items-center mb-5">
                <div class="col-lg-12">
                  <div class="tp-section-title-wrap tp_fade_anim tp-text-center" data-dure=".9">
                    <span class="tp-section-sub-title mb-15">Our Services</span>
                    <!--@if($category->short_description)-->
                    <!--  <div class="mt- section-heading">-->
                    <!--    <p class="sub-title">{{ $category->short_description }}</p>-->
                    <!--  </div>-->
                    <!--@endif-->
                    
                    
                     <div class="mt- section-heading seo-text">
                       <p>Glass Wall Systems (India) Limited is a specialist provider of facade solutions, offering end-to-end facade work for commercial, institutional, hospitality and residential developments across India. Recognised among the top facade manufacturers in India and facade companies in India, we combine in-house design, fabrication and installation to deliver every project under one accountable roof, backed by a track record that positions us as one of the top facade consultants in Mumbai, India.</p>

<p>Our capability spans the full range of modern facade systems. We engineer unitised and semi-unitised curtain wall system solutions, high-performance building glass facade assemblies and precision aluminium glazing works for glass curtain wall and exterior glass wall panel applications. Every facade glazing package is detailed for wind load resistance, water tightness, thermal performance and acoustic comfort, drawing on experience built while pursuing global facade solutions for demanding, code-compliant markets. Alongside glazing, we supply aluminium doors and windows engineered for durability, smooth operation and weather sealing across sliding, casement and tilt-turn configurations.</p>

<p>Sun control and elevation articulation are delivered through our louvers facade and aluminium louvers facade offerings. As experienced louvers manufacturers in India, we work across the common types of louvers — fixed, operable, aerofoil, Z-blade, vertical and horizontal — translating each louvers design into a system tuned for shading, airflow and rain defence. Our aluminium fins facade solutions add rhythm and solar control to building envelopes, while terracotta louvers bring warmth, texture and sustainable material character to elevations seeking a more natural aesthetic.</p>

<p>For opaque and hybrid facades, we provide insulated sandwich panels for energy-efficient wall build-ups and different types of rainscreen claddings, including dry stone cladding systems engineered with concealed anchoring for natural stone finishes, often combined with glazing to create layered, contemporary elevations.</p>

<p>As trusted facade contractors, GWS supports every project with structural analysis, BIM detailing, value engineering, certified installation teams and documented quality assurance from design through handover. Our facades are built to perform — structurally, visually and environmentally — for decades, making us a partner of choice for architects and developers who expect global standards delivered locally.</p>

<p>Explore our complete range of premium architectural facade solutions designed for residential, commercial and industrial projects.</p>
                      </div>
                      
                      
                      
                      
                    <h2 class="tp-section-title mb-25">{{ $category->name }}</h2>
                    
                  </div>
                </div>
              </div>

              <!-- Grid -->

              <div class="row g-4">
                @forelse($products as $product)
                  <div class="col-lg-4">
                    <article class="product-card large">
                      <img src="{{ $product->image_url }}" alt="{{ $product->name }}" />

                      <div class="overlay"></div>

                      <div class="shine"></div>

                      <div class="card-content">
                        <h3>{{ $product->name }}</h3>

                        <a href="{{ route('frontend.contact_us') }}">
                          Learn More

                          <i class="fa-solid fa-arrow-right"></i>
                        </a>
                      </div>

                      <div class="arrow">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                      </div>
                    </article>
                  </div>
                @empty
                  <div class="col-12 text-center">
                    <p>No products available in this category yet.</p>
                  </div>
                @endforelse
              </div>
            </div>
          </section>

        </main>

        @include('components.frontend.footer')
      </div>
    </div>

    @include('components.frontend.main-js')

  </body>
</html>
