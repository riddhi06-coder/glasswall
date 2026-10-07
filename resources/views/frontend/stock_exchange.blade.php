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
                    data-background="{{ optional($stock)->banner_image_url ?? 'https://www.glasswallsystems.in/ipo-docs/banner_46500dbda9614a4ab6c390e9eae0e246.webp' }}">
                    <div class="container">
                        <div class="tp-breadcrumb pb-50">
                            <div class="page-heading">
                                <h1 class="tp-breadcrumb-title tp-text-white margin-0">{{ optional($stock)->banner_heading ?? 'Stock Exchange' }}</h1>
                            </div>
                            <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                                <span><a href="{{ route('frontend.index') }}">Home</a></span>
                                <span class="tp-breadcrumb-dvdr">-</span>
                                <span>{{ optional($stock)->banner_heading ?? 'Stock Exchange' }}</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- hero area end -->

                <section class="stock-wrap">
                    <div class="container">

                        @if(optional($stock)->page_heading)
                        <h2 class="stock-heading">{{ $stock->page_heading }}</h2>
                        @endif

                        <div class="financial-tabs">

                            <!-- Tab Buttons -->
                            <div class="financial-tab-buttons">
                                @foreach($tabs as $tab)
                                <button type="button" class="financial-tab-btn {{ $loop->first ? 'active' : '' }}" data-tab="stock-tab-{{ $tab->id }}">
                                    {{ $tab->label }}
                                </button>
                                @endforeach
                            </div>

                            <!-- Tab Content -->
                            @foreach($tabs as $tab)
                            <div class="financial-tab-content {{ $loop->first ? 'active' : '' }}" id="stock-tab-{{ $tab->id }}">
                                @if($tab->items->count())
                                <div class="disclosures-table">
                                    @foreach($tab->items as $item)
                                    <div class="disclosure-row">
                                        <div class="disclosure-title">
                                            <span class="disclosure-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                            <span>{!! $item->title !!}</span>
                                        </div>
                                        <div class="disclosure-link">
                                            <a href="{{ $item->href ?: '#' }}" @if($item->href) target="_blank" rel="noopener" @endif>View</a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="coming-text">
                                    <h3>Coming Soon</h3>
                                </div>
                                @endif
                            </div>
                            @endforeach

                        </div>

                    </div>
                </section>



            </main>

            @include('components.frontend.footer')
        </div>
    </div>

    @include('components.frontend.main-js')
    <script>
        document.addEventListener('click', function(e) {

            const button = e.target.closest('.financial-tab-btn');

            if (!button) return;

            const tabId = button.getAttribute('data-tab');

            document.querySelectorAll('.financial-tab-btn').forEach(function(btn) {
                btn.classList.remove('active');
            });

            document.querySelectorAll('.financial-tab-content').forEach(function(tab) {
                tab.classList.remove('active');
            });

            button.classList.add('active');

            const content = document.getElementById(tabId);

            if (content) {
                content.classList.add('active');
            }

        });
    </script>
</body>

</html>