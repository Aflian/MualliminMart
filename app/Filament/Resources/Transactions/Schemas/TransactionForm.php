<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use App\Models\User;
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
                    ->default(fn () => self::generateInvoiceNumber())
                    ->unique(ignoreRecord: true)
                    ->disabled()
                    ->dehydrated(),

                Select::make('user_id')
                    ->label('Kasir/Admin')
                    ->options(User::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Select::make('shift_id')
                    ->label('Shift')
                    ->options(Shift::pluck('shift_name', 'id'))
                    ->searchable(),

                Select::make('vendor_id')
                    ->label('Vendor / Supplier')
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
                    ->required()
                    ->reactive(),

                // 🔹 Repeater untuk item barang
                Repeater::make('items')
                    ->relationship('items')
                    ->label('Daftar Barang')
                    ->schema([
                        Select::make('product_id')
                            ->label('Produk')
                            ->options(Product::pluck('name', 'id'))
                            ->reactive()
                            ->searchable()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $product = Product::find($state);

                                if ($product) {
                                    $category = $get('../../category');

                                    if ($category === 'pembelian') {
                                        $price = $product->purchase_price; // harga beli
                                    } else {
                                        $price = $product->selling_price; // harga jual
                                    }

                                    $set('price', $price);

                                    $quantity = $get('quantity') ?? 1;
                                    $set('subtotal', $quantity * $price);

                                    // trigger update total
                                    $set('../../trigger_total_update', now()->timestamp);
                                }
                            })
                            ->required(),

                        TextInput::make('quantity')
                            ->label('Jumlah')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $price = $get('price') ?? 0;
                                $subtotal = $state * $price;
                                $set('subtotal', $subtotal);
                                $set('../../trigger_total_update', now()->timestamp);
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
                            ->dehydrated(false),
                    ])
                    ->defaultItems(1)
                    ->columnSpanFull(),

                // 🔹 Hidden field untuk trigger update total
                TextInput::make('trigger_total_update')
                    ->hidden()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $items = $get('items') ?? [];
                        $total = collect($items)->sum('subtotal');
                        $set('total_amount', $total);
                    }),

                // 🔹 Total otomatis
                TextInput::make('total_amount')
                    ->label('Total')
                    ->numeric()
                    ->disabled()
                    ->prefix('Rp')
                    ->dehydrated()
                    ->afterStateHydrated(function ($state, callable $set, $record) {
                        if ($record && $record->exists) {
                            $total = $record->items->sum('subtotal');
                            $set('total_amount', $total);
                        }
                    }),

                DateTimePicker::make('transaction_date')
                    ->label('Tanggal Transaksi')
                    ->default(now())
                    ->required(),

                DateTimePicker::make('due_date')
                    ->label('Tanggal Jatuh Tempo')
                    ->placeholder('Opsional untuk hutang')
                    ->hidden(fn (callable $get) => $get('payment_status') !== 'hutang'),
            ]);
    }

    private static function generateInvoiceNumber(): string
    {
        $lastInvoice = Transaction::orderBy('id', 'desc')->first();
        $lastId = $lastInvoice ? $lastInvoice->id : 0;

        return 'INV-' . now()->format('Ymd') . '-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    }
}
