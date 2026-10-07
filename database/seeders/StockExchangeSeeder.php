<?php

namespace Database\Seeders;

use App\Models\StockExchange;
use App\Models\StockExchangeTab;
use Illuminate\Database\Seeder;

class StockExchangeSeeder extends Seeder
{
    private const PDF = 'https://www.glasswallsystems.in/public/frontend/assets/pdf/stock/';

    public function run(): void
    {
        StockExchange::firstOrCreate([], [
            'banner_heading' => 'Stock Exchange',
            'page_heading'   => 'Financial Year 2026-2027',
        ]);

        if (StockExchangeTab::count() > 0) {
            $this->command?->info('Stock Exchange tabs already exist — skipping.');
            return;
        }

        // Q1 documents (from the live Stock Exchange page).
        $q1 = [
            ['01', 'BM Intimation for Unaudited Results for June 2026', self::PDF.'BM-Intimation-for-Unaudited-Results-for-June-2026.pdf'],
            ['02', '2026 09 22 - Reply on Price Movement', self::PDF.'2026-09-22-Reply-on-Price-Movement.pdf'],
            ['03', '2026 10 01 - Intimation on Earnings Call dated 01.10.2026', self::PDF.'026-10-01-Intimation-on-Earnings-Call-dated-01.10.2026.pdf'],
            ['04', 'Disclosure under Reg 30(5) dated 17.09.2026', self::PDF.'Disclosure-under-Reg-30(5)-dated-17.09.2026.pdf'],
            ['05', 'Intimation regarding Resignation of Prakash Bagla', self::PDF.'Intimation-regarding-Resignation-of-Prakash-Bagla.pdf'],
            ['06', 'Intimation under Reg 7 SEBI (Listing Obligations and Disclosure Requirements) 2015', self::PDF.'Intimation-under-Reg-7-SEBI.pdf'],
            ['07', 'Intimation under Reg 8 SEBI (Prohibition of Insider Trading) Regulations, 2015', self::PDF.'Intimation-under-Reg-8-SEBI-(Prohibition-of-Insider-Trading)-Regulations-2015.pdf'],
            ['08', 'Regulation 6(1) of SEBI (Listing Obligations and Disclosure Requirements) 2015', self::PDF.'Regulation-6(1)-of-SEBI-(Listing-Obligations-and-Disclosure-Requirements)-2015.pdf'],
            ['09', 'Trading Window Closure - Qtr ended 30.09.2026', self::PDF.'Trading-Window-Closure-Qtr-ended-30.09.2026.pdf'],
            ['10', 'Trading Window Closure dated 17.09.2026', self::PDF.'Trading-Window-Closure-dated-17.09.2026.pdf'],
            ['11', 'Outcome of Board Meeting Dated 06.10.2026', self::PDF.'Outcome-of-Board-Meeting-Dated-06.10.2026.pdf'],
        ];

        $tabQ1 = StockExchangeTab::create(['label' => 'Q1', 'sort_order' => 0, 'is_active' => true]);
        $o = 0;
        foreach ($q1 as [$number, $title, $url]) {
            $tabQ1->items()->create(['number' => $number, 'title' => $title, 'url' => $url, 'sort_order' => $o++]);
        }

        // Q2 / Q3 — empty (render "Coming Soon").
        StockExchangeTab::create(['label' => 'Q2', 'sort_order' => 1, 'is_active' => true]);
        StockExchangeTab::create(['label' => 'Q3', 'sort_order' => 2, 'is_active' => true]);

        $this->command?->info('Seeded Stock Exchange: Q1 ('.count($q1).' docs) + Q2 + Q3.');
    }
}
