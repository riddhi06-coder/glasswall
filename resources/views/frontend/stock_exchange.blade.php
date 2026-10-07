<!DOCTYPE html>
<html lang="en">
  <head>

    @include('components.frontend.head')
<style>
.stock-wrap {
    padding: 80px 0;
}

.stock-heading {
    margin-bottom: 35px;
    font-size: 20px;
    line-height: 1.3;
    color: #222;
    text-align: center;
}


/* =========================
   TABS
========================= */

.financial-tabs {
    width: 100%;
}

.financial-tab-buttons {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 30px;
    border-bottom: 1px solid #ddd;
}

.financial-tab-btn {
    position: relative;
    display: inline-block;
    padding: 14px 35px;
    margin: 0;
    border: 0;
    outline: none;
    background: transparent;
    color: #777;
    font-size: 16px;
    font-weight: 600;
    line-height: 1.4;
    cursor: pointer;
    transition: all 0.3s ease;
}

.financial-tab-btn:hover {
    color: #111;
}

.financial-tab-btn.active {
    color: #111;
}

.coming-text {
    text-align: center;
}
.coming-text h4{
    font-size:18px;
}

.financial-tab-btn.active::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: -1px;
    width: 100%;
    height: 3px;
    background: #111;
}

.financial-tab-content {
    display: none;
    width: 100%;
}

.financial-tab-content.active {
    display: block;
}





</style>
  </head>
  <body>

    @include('components.frontend.header')

    <div id="smooth-wrapper">
      <div id="smooth-content">
        <main>

          <!-- hero area start -->
          <section class="tp-breadcrumb-area tp-bg tp-overlay p-relative" data-background="https://www.glasswallsystems.in/ipo-docs/banner_46500dbda9614a4ab6c390e9eae0e246.webp">
            <div class="container">
              <div class="tp-breadcrumb pb-50">
                <div class="page-heading">
                  <h1 class="tp-breadcrumb-title tp-text-white margin-0">Stock Exchange</h1>
                </div>
                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>Stock Exchange </span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->

          <section class="stock-wrap">
    <div class="container">

        <h2 class="stock-heading">
            Financial Year 2026-2027
        </h2>

        <div class="financial-tabs">

            <!-- Tab Buttons -->
            <div class="financial-tab-buttons">

                <button type="button" class="financial-tab-btn active" data-tab="financial-q1">
                    Q1
                </button>

                <!--<button type="button" class="financial-tab-btn" data-tab="financial-q2">-->
                <!--    Q2-->
                <!--</button>-->

                <!--<button type="button" class="financial-tab-btn" data-tab="financial-q3">-->
                <!--    Q3-->
                <!--</button>-->

            </div>


            <!-- Q1 CONTENT -->
            <div class="financial-tab-content active" id="financial-q1">

                <div class="disclosures-table">

                    <div class="disclosure-row">

                        <div class="disclosure-title">
                            <span class="disclosure-number">01</span>

                            <span>
                                BM Intimation for Unaudited Results for June 2026
                            </span>
                        </div>

                        <div class="disclosure-link">
                            <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/BM-Intimation-for-Unaudited-Results-for-June-2026.pdf"
                               target="_blank"
                               rel="noopener">
                                View
                            </a>
                        </div>

                    </div>
                    
                    
                    <div class="disclosure-row">

                        <div class="disclosure-title">
                            <span class="disclosure-number">02</span>

                            <span>
                               2026 09 22 - Reply on Price Movement
                            </span>
                        </div>

                        <div class="disclosure-link">
                            <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/2026-09-22-Reply-on-Price-Movement.pdf"
                               target="_blank"
                               rel="noopener">
                                View
                            </a>
                        </div>

                    </div>
                    
                    <div class="disclosure-row">

                        <div class="disclosure-title">
                            <span class="disclosure-number">03</span>

                            <span>
                               2026 10 01 - Intimation on Earnings Call dated 01.10.2026
                            </span>
                        </div>

                        <div class="disclosure-link">
                            <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/026-10-01-Intimation-on-Earnings-Call-dated-01.10.2026.pdf"
                               target="_blank"
                               rel="noopener">
                                View
                            </a>
                        </div>

                    </div>
                    
                    <div class="disclosure-row">

                        <div class="disclosure-title">
                            <span class="disclosure-number">04</span>

                            <span>
                               Disclosure under Reg 30(5) dated 17.09.2026
                            </span>
                        </div>

                        <div class="disclosure-link">
                            <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/Disclosure-under-Reg-30(5)-dated-17.09.2026.pdf"
                               target="_blank"
                               rel="noopener">
                                View
                            </a>
                        </div>

                    </div>
                    
                    <div class="disclosure-row">

                        <div class="disclosure-title">
                            <span class="disclosure-number">05</span>

                            <span>
                               Intimation regarding Resignation of Prakash Bagla
                            </span>
                        </div>

                        <div class="disclosure-link">
                            <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/Intimation-regarding-Resignation-of-Prakash-Bagla.pdf"
                               target="_blank"
                               rel="noopener">
                                View
                            </a>
                        </div>

                    </div>
                    
                    <div class="disclosure-row">

                        <div class="disclosure-title">
                            <span class="disclosure-number">06</span>

                            <span>
                               Intimation under Reg 7 SEBI (Listing Obligations and Disclosure Requirements) 2015
                            </span>
                        </div>

                        <div class="disclosure-link">
                            <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/Intimation-under-Reg-7-SEBI.pdf"
                               target="_blank"
                               rel="noopener">
                                View
                            </a>
                        </div>

                    </div>
                    
                    <div class="disclosure-row">

                        <div class="disclosure-title">
                            <span class="disclosure-number">07</span>

                            <span>
                               Intimation under Reg 8 SEBI (Prohibition of Insider Trading) Regulations, 2015
                            </span>
                        </div>

                        <div class="disclosure-link">
                            <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/Intimation-under-Reg-8-SEBI-(Prohibition-of-Insider-Trading)-Regulations-2015.pdf"
                               target="_blank"
                               rel="noopener">
                                View
                            </a>
                        </div>

                    </div>
                    
                    <div class="disclosure-row">

                        <div class="disclosure-title">
                            <span class="disclosure-number">08</span>

                            <span>
                               Regulation 6(1) of SEBI (Listing Obligations and Disclosure Requirements) 2015
                            </span>
                        </div>

                        <div class="disclosure-link">
                            <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/Regulation-6(1)-of-SEBI-(Listing-Obligations-and-Disclosure-Requirements)-2015.pdf"
                               target="_blank"
                               rel="noopener">
                                View
                            </a>
                        </div>

                    </div>
                    
                    <div class="disclosure-row">

                        <div class="disclosure-title">
                            <span class="disclosure-number">09</span>
                            
                            <span>
                               Trading Window Closure - Qtr ended 30.09.2026
                            </span>
                        </div>

                        <div class="disclosure-link">
                            <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/Trading-Window-Closure-Qtr-ended-30.09.2026.pdf"
                               target="_blank"
                               rel="noopener">
                                View
                            </a>
                        </div>

                    </div>
                    
                    <div class="disclosure-row">

                        <div class="disclosure-title">
                            <span class="disclosure-number">10</span>
                                Trading Window Closure dated 17.09.2026
                            <span>
                               
                            </span>
                        </div>

                        <div class="disclosure-link">
                            <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/Trading-Window-Closure-dated-17.09.2026.pdf"
                               target="_blank"
                               rel="noopener">
                                View
                            </a>
                        </div>

                    </div>
                    
                     <div class="disclosure-row">

                        <div class="disclosure-title">
                            <span class="disclosure-number">10</span>
                                Outcome of Board Meeting Dated 06.10.2026
                            <span>
                               
                            </span>
                        </div>

                        <div class="disclosure-link">
                            <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/Outcome-of-Board-Meeting-Dated-06.10.2026.pdf"
                               target="_blank"
                               rel="noopener">
                                View
                            </a>
                        </div>

                    </div>

                </div>

            </div>


            <!-- Q2 CONTENT -->
            <div class="financial-tab-content" id="financial-q2">
                <div  class="coming-text">
                    <h3>Coming Soon</h3>
                </div>
                

            </div>


            <!-- Q3 CONTENT -->
            <div class="financial-tab-content" id="financial-q3">

               <div  class="coming-text">
                    <h3>Coming Soon</h3>
                </div>

            </div>

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
