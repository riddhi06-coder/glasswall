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
                  <h1 class="tp-breadcrumb-title tp-text-white margin-0">Disclosures</h1>
                </div>
                <div class="tp-breadcrumb-menu tp-flex-center mb-15 pt-35">
                  <span><a href="{{ route('frontend.index') }}">Home</a></span>
                  <span class="tp-breadcrumb-dvdr">-</span>
                  <span>Disclosures</span>
                </div>
              </div>
            </div>
          </section>
          <!-- hero area end -->

          <section class="disclosures-wrap py-5">
  <div class="container">

    <h2 class="disclosures-heading">
      Disclosure under regulation 46 of SEBI (Listing Obligations and Disclosure Requirements) Regulations, 2015.
    </h2>

    <div class="disclosures-table">

      <!-- 01 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">01</span>
          <span>Details of Business</span>
        </div>
        <div class="disclosure-link">
          <a href="https://www.glasswallsystems.in/about-us/" target="_blank" rel="noopener">View</a>
        </div>
      </div>

      <!-- 02 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">02</span>
          <span>Memorandum of Association and Articles of Association</span>
        </div>
        <div class="disclosure-link" style="flex-direction: column;">
          <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/MOA.pdf" target="_blank">View MOA</a>
          <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/AOA.pdf" target="_blank">View AOA</a>
        </div>
      </div>

      <!-- 03 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">03</span>
          <span>Brief Profile of Board of Directors including Directorship and full-time positions in Body Corporates</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 04 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">04</span>
          <span>Terms and conditions of appointment of Independent Directors</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 05 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">05</span>
          <span>Composition of various committees of Board of Directors</span>
        </div>
        <div class="disclosure-link">
          <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/Composition-of-various-committees-of-Board-of-Directors.pdf" target="_blank">View</a>
        </div>
      </div>

      <!-- 06 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">06</span>
          <span>Code of conduct of Board of Directors and Senior Management Personnel</span>
        </div>
        <div class="disclosure-link">
          <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/Code-of-conduct-for-BOD-SMP.pdf" target="_blank" rel="noopener">View</a>
        </div>
      </div>

      <!-- 07 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">07</span>
          <span>Details of establishment of Vigil Mechanism/Whistle Blower policy</span>
        </div>
        <div class="disclosure-link">
          <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/Whistle-Blower-Policy.pdf" target="_blank" rel="noopener">View</a>
        </div>
      </div>

      <!-- 08 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">08</span>
          <span>Criteria of making payments to Non-executive directors, if the same has not been disclosed in annual report</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 09 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">09</span>
          <span>Policy on Dealing with Related Party Transactions</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 10 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">10</span>
          <span>Policy for determining 'Material' subsidiaries</span>
        </div>
        <div class="disclosure-link">
          <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/Determination-of-Material-Subsidiary-Policy.pdf" target="_blank" rel="noopener">View</a>
        </div>
      </div>

      <!-- 11 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">11</span>
          <span>Details of familiarization programmes imparted to Independent Directors</span>
        </div>
        <div class="disclosure-link">
          <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/Policy-on-ID-familiarisation.pdf" target="_blank" rel="noopener">View</a>
        </div>
      </div>

      <!-- 12 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">12</span>
          <span>Email address for grievance redressal and other relevant details</span>
        </div>
        <div class="disclosure-link">
          <a href="https://www.glasswallsystems.in/investor-resources" target="_blank" rel="noopener">View</a>
        </div>
      </div>

      <!-- 13 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">13</span>
          <span>Contact information of the designated officials of the listed entity who are responsible for assisting and handling investor grievances</span>
        </div>
        <div class="disclosure-link">
          <a href="https://www.glasswallsystems.in/investor-resources/" target="_blank" rel="noopener">View</a>
        </div>
      </div>

      <!-- 14 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">14</span>
          <span>
            Financial information including:
            <br>
            a. Notice of meeting of the board of directors where financial results shall be discussed
            <br>
            b. Financial Results
            <br>
            c. Annual Report
          </span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 15 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">15</span>
          <span>Shareholding pattern</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 16 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">16</span>
          <span>Details of agreements entered into with the media companies and/or their associates etc.</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 17 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">17</span>
          <span>Schedule of analyst or institutional investor meet</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 18 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">18</span>
          <span>Presentations made by the Company to analysts or institutional investors</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 19 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">19</span>
          <span>Audio or video recordings and transcripts of post earnings/quarterly calls</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 20 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">20</span>
          <span>New name and the old name of the listed entity for a continuous period of one year, from the date of the last name change (Date of Name Change)</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 21 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">21</span>
          <span>Items in sub-regulation (1) of regulation 47</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 22 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">22</span>
          <span>Credit Ratings</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 23 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">23</span>
          <span>Separate audited financial statements of each subsidiary of the listed entity in respect of a relevant financial year</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 24 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">24</span>
          <span>Secretarial compliance report as per sub-regulation (2) of regulation 24A</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 25 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">25</span>
          <span>Disclosure of the policy for determination of materiality of events or information required under clause (ii), sub-regulation (4) of regulation 30</span>
        </div>
        <div class="disclosure-link">
          <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/Policy-on-Materiality-of-events.pdf" target="_blank" rel="noopener">View</a>
        </div>
      </div>

      <!-- 26 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">26</span>
          <span>Disclosure of contact details of key managerial personnel</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 27 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">27</span>
          <span>Disclosures under sub-regulation (8) of regulation 30 of these regulations</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 28 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">28</span>
          <span>Statements of deviation(s) or variation(s) as specified in regulation 32</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
        </div>
      </div>

      <!-- 29 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">29</span>
          <span>Dividend distribution policy</span>
        </div>
        <div class="disclosure-link">
          <a href="https://www.glasswallsystems.in/public/frontend/assets/pdf/Dividend-Distribution-Policy.pdf" target="_blank" rel="noopener">View</a>
        </div>
      </div>

      <!-- 30 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">30</span>
          <span>Annual return as provided under section 92 of the Companies Act, 2013</span>
        </div>
        <div class="disclosure-link">
          <a href="https://www.glasswallsystems.in/annual-report/" target="_blank" rel="noopener">View</a>
        </div>
      </div>

      <!-- 31 -->
      <div class="disclosure-row">
        <div class="disclosure-title">
          <span class="disclosure-number">31</span>
          <span>Employee Benefit Scheme Documents</span>
        </div>
        <div class="disclosure-link">
          <a href="#">View</a>
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

  </body>
</html>
