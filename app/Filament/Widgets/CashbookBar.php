<?php

namespace App\Filament\Widgets;

use App\Models\Cashbook;
use Filament\Widgets\ChartWidget;

class CashbookBar extends ChartWidget
{
    protected ?string $heading = 'Grafik Keuangan ';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $days = collect(range(6, 0))->map(function ($i) {
            return now()->subDays($i)->format('Y-m-d');
        });

        $inData = [];
        $outData = [];

        foreach ($days as $day) {
            $inData[] = Cashbook::whereDate('created_at', $day)
                ->where('type', 'in')
                ->sum('amount');

            $outData[] = Cashbook::whereDate('created_at', $day)
                ->where('type', 'out')
                ->sum('amount');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => $inData,
                    'borderColor' => '#16a34a', // hijau
                    'backgroundColor' => 'rgba(22,163,74,0.2)',
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $outData,
                    'borderColor' => '#dc2626', // merah
                    'backgroundColor' => 'rgba(220,38,38,0.2)',
                ],
            ],
            'labels' => $days->map(fn ($d) => \Carbon\Carbon::parse($d)->translatedFormat('d M'))->toArray(),
        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }
}
