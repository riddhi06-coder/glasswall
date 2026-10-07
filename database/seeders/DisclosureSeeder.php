<?php

namespace Database\Seeders;

use App\Models\Disclosure;
use App\Models\DisclosureRow;
use Illuminate\Database\Seeder;

class DisclosureSeeder extends Seeder
{
    private const PDF = 'https://www.glasswallsystems.in/public/frontend/assets/pdf/';

    public function run(): void
    {
        Disclosure::firstOrCreate([], [
            'banner_heading' => 'Disclosures',
            'page_heading'   => 'Disclosure under regulation 46 of SEBI (Listing Obligations and Disclosure Requirements) Regulations, 2015.',
        ]);

        // Only seed the rows once (avoid duplicating on re-run).
        if (DisclosureRow::count() > 0) {
            $this->command?->info('Disclosure rows already exist — skipping row seed.');
            return;
        }

        $v = fn ($url = null, $label = 'View', $name = null) => ['label' => $label, 'url' => $url, 'name' => $name];

        $rows = [
            ['01', 'Details of Business', 'links', null, [$v('https://www.glasswallsystems.in/about-us/')]],
            ['02', 'Memorandum of Association and Articles of Association', 'links', null, [$v(self::PDF.'MOA.pdf', 'View MOA'), $v(self::PDF.'AOA.pdf', 'View AOA')]],
            ['03', 'Brief Profile of Board of Directors including Directorship and full-time positions in Body Corporates', 'links', null, [$v()]],
            ['04', 'Terms and conditions of appointment of Independent Directors', 'links', null, [$v()]],
            ['05', 'Composition of various committees of Board of Directors', 'links', null, [$v(self::PDF.'Composition-of-various-committees-of-Board-of-Directors.pdf')]],
            ['06', 'Code of conduct of Board of Directors and Senior Management Personnel', 'links', null, [$v(self::PDF.'Code-of-conduct-for-BOD-SMP.pdf')]],
            ['07', 'Details of establishment of Vigil Mechanism/Whistle Blower policy', 'links', null, [$v(self::PDF.'Whistle-Blower-Policy.pdf')]],
            ['08', 'Criteria of making payments to Non-executive directors, if the same has not been disclosed in annual report', 'links', null, [$v()]],
            ['09', 'Policy on Dealing with Related Party Transactions', 'links', null, [$v()]],
            ['10', "Policy for determining 'Material' subsidiaries", 'links', null, [$v(self::PDF.'Determination-of-Material-Subsidiary-Policy.pdf')]],
            ['11', 'Details of familiarization programmes imparted to Independent Directors', 'links', null, [$v(self::PDF.'Policy-on-ID-familiarisation.pdf')]],
            ['12', 'Email address for grievance redressal and other relevant details', 'links', null, [$v('https://www.glasswallsystems.in/investor-resources')]],
            ['13', 'Contact information of the designated officials of the listed entity who are responsible for assisting and handling investor grievances', 'links', null, [$v('https://www.glasswallsystems.in/investor-resources/')]],
            ['14', 'Financial information including:', 'financial', '2026–2027', [
                $v(null, 'View', 'a. Notice of meeting of the board of directors where financial results shall be discussed'),
                $v(null, 'View', 'b. Financial Results'),
                $v(null, 'View', 'c. Annual Report'),
            ]],
            ['15', 'Shareholding pattern', 'tabs', '2026–2027', 'TABS'],
            ['16', 'Details of agreements entered into with the media companies and/or their associates etc.', 'links', null, [$v()]],
            ['15', 'Schedule of analyst or institutional investor meet', 'tabs', '2026–2027', 'TABS'],
            ['18', 'Presentations made by the Company to analysts or institutional investors', 'links', null, [$v()]],
            ['19', 'Audio or video recordings and transcripts of post earnings/quarterly calls', 'links', null, [$v()]],
            ['20', 'New name and the old name of the listed entity for a continuous period of one year, from the date of the last name change (Date of Name Change)', 'links', null, [$v()]],
            ['21', 'Items in sub-regulation (1) of regulation 47', 'links', null, [$v()]],
            ['22', 'Credit Ratings', 'links', null, [$v()]],
            ['23', 'Separate audited financial statements of each subsidiary of the listed entity in respect of a relevant financial year', 'links', null, [$v()]],
            ['24', 'Secretarial compliance report as per sub-regulation (2) of regulation 24A', 'links', null, [$v()]],
            ['25', 'Disclosure of the policy for determination of materiality of events or information required under clause (ii), sub-regulation (4) of regulation 30', 'links', null, [$v(self::PDF.'Policy-on-Materiality-of-events.pdf')]],
            ['26', 'Disclosure of contact details of key managerial personnel', 'links', null, [$v()]],
            ['27', 'Disclosures under sub-regulation (8) of regulation 30 of these regulations', 'links', null, [$v()]],
            ['28', 'Statements of deviation(s) or variation(s) as specified in regulation 32', 'links', null, [$v()]],
            ['29', 'Dividend distribution policy', 'links', null, [$v(self::PDF.'Dividend-Distribution-Policy.pdf')]],
            ['30', 'Annual return as provided under section 92 of the Companies Act, 2013', 'links', null, [$v('https://www.glasswallsystems.in/annual-report/')]],
            ['31', 'Employee Benefit Scheme Documents', 'links', null, [$v()]],
        ];

        $order = 0;
        foreach ($rows as [$number, $title, $type, $year, $children]) {
            $row = DisclosureRow::create([
                'number' => $number, 'title' => $title, 'type' => $type,
                'year' => $year, 'sort_order' => $order++, 'is_active' => true,
            ]);

            if ($children === 'TABS') {
                foreach (['Q1', 'Q2', 'Q3'] as $i => $q) {
                    $row->tabs()->create(['label' => $q, 'content' => "<h6>Coming Soon {$q}</h6>", 'sort_order' => $i]);
                }
                continue;
            }

            $o = 0;
            foreach ($children as $c) {
                $row->links()->create([
                    'name' => $c['name'], 'label' => $c['label'], 'url' => $c['url'], 'sort_order' => $o++,
                ]);
            }
        }

        $this->command?->info('Seeded '.count($rows).' disclosure rows.');
    }
}
