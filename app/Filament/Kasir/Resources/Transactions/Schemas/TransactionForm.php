<?php

namespace App\Filament\Kasir\Resources\Transactions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use App\Models\Shift;
use App\Models\Vendor;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Transaction;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 🔹 Invoice unik
                TextInput::make('invoice_number')
                    ->label('No. Invoice')
                    ->default(fn () => 'INV-' . now()->format('Ymd') . '-' . str_pad((Transaction::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT))
                    ->unique(ignoreRecord: true)
                    ->disabled()
                    ->dehydrated(),

                // 🔹 User otomatis dari kasir yang login
                Hidden::make('user_id')
                    ->default(fn () => auth()->id())
                    ->dehydrated(),

                Select::make('shift_id')
                    ->label('Shift')
                    ->options(Shift::pluck('shift_name', 'id'))
                    ->searchable(),

                Select::make('vendor_id')
                    ->label('Vendor / Supplier (Opsional)')
                    ->options(Vendor::pluck('name', 'id'))
                    ->searchable(),

                TextInput::make('customer_name')
                    ->label('Nama Customer')
                    ->placeholder('Opsional untuk pembelian'),

                Select::make('category')
                    ->label('Kategori Transaksi')
                    ->options([
                        'penjualan' => 'Penjualan',
                        'pembelian' => 'Pembelian',
                    ])
                    ->required()
                    ->reactive(),

                Select::make('payment_method_id')
                    ->label('Metode Pembayaran')
                    ->options(PaymentMethod::pluck('name', 'id'))
                    ->required(),

                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'lunas' => 'Lunas',
                        'hutang' => 'Hutang',
                        'gagal' => 'Gagal',
                    ])
                    ->default('lunas')
                    ->required(),

                // 🔹 Daftar item transaksi
                Repeater::make('items')
                    ->relationship('items')
                    ->label('Daftar Barang')
                    ->schema([
                        Select::make('product_id')
                            ->label('Produk')
                            ->options(Product::pluck('name', 'id'))
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('price', Product::find($state)?->selling_price ?? 0)
                            )
                            ->required(),

                        TextInput::make('quantity')
                            ->label('Jumlah')
                            ->numeric()
                            ->default(1)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $price = $get('price') ?? 0;
                                $subtotal = $state * $price;
                                $set('subtotal', $subtotal);
                            })
                            ->required(),

                        TextInput::make('price')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(),

                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->defaultItems(1)
                    ->columnSpanFull()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $total = collect($state)->sum('subtotal');
                        $set('total_amount', $total);
                    }),

                // 🔹 Total otomatis
                TextInput::make('total_amount')
                    ->label('Total')
                    ->numeric()
                    ->disabled()
                    ->prefix('Rp')
                    ->dehydrated(),

                DateTimePicker::make('transaction_date')
                    ->label('Tanggal Transaksi')
                    ->default(now())
                    ->required(),

                DateTimePicker::make('due_date')
                    ->label('Tanggal Jatuh Tempo')
                    ->placeholder('Opsional untuk hutang'),
            ]);
    }
}
