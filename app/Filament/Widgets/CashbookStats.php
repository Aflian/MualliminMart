<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Cashbook;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CashbookStats extends BaseWidget
{
    protected static ?int $sort = 1; // urutan di dashboard

    protected function getStats(): array
    {
        $totalIn = Cashbook::where('type', 'in')->sum('amount');
        $totalOut = Cashbook::where('type', 'out')->sum('amount');
        $saldo = $totalIn - $totalOut;

        return [
            Stat::make('Total Pemasukan', 'Rp ' . number_format($totalIn, 0, ',', '.'))
                ->description('Akumulasi semua pemasukan')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Pengeluaran', 'Rp ' . number_format($totalOut, 0, ',', '.'))
                ->description('Akumulasi semua pengeluaran')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Saldo Akhir', 'Rp ' . number_format($saldo, 0, ',', '.'))
                ->description('Pemasukan - Pengeluaran')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($saldo >= 0 ? 'primary' : 'warning'),
            Stat::make('Total Pengguna', User::count())
                ->description('Jumlah semua user yang terdaftar')
                ->descriptionIcon('heroicon-o-users')
                ->color('success'),

            Stat::make('Total Vendor', Vendor::count())
                ->description('Jumlah semua vendor yang terdaftar')
                ->descriptionIcon('heroicon-o-building-storefront')
                ->color('info'),

            Stat::make('Total Transaksi', Transaction::count())
                ->description('Jumlah semua transaksi yang tercatat')
                ->descriptionIcon('heroicon-o-credit-card')
                ->color('warning'),
        ];
    }
}
