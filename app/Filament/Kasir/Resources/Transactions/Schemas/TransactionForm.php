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
use Illuminate\Support\Facades\Auth;

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

                // 🔹 User otomatis terisi sesuai kasir login
                Hidden::make('user_id')
                    ->default(fn () => Auth::id())
                    ->dehydrated(),

                // 🔹 Shift kasir (opsional, bisa auto set jika sistem shift aktif)
                Select::make('shift_id')
                    ->label('Shift')
                    ->options(Shift::pluck('shift_name', 'id'))
                    ->searchable()
                    ->required(),

                TextInput::make('customer_name')
                    ->label('Nama Customer')
                    ->placeholder('Opsional untuk pembelian'),

                // 🔹 Kasir bisa pilih kategori
                Select::make('category')
                    ->default('penjualan')
                    ->options([
                        'penjualan' => 'Penjualan',
                        'pembelian' => 'Pembelian',
                    ])
                    ->dehydrated(),

                Select::make('payment_method_id')
                    ->label('Metode Pembayaran')
                    ->options(PaymentMethod::pluck('name', 'id'))
                    ->required(),

                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'lunas' => 'Lunas',
                        'hutang' => 'Hutang',
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
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $product = Product::find($state);

                                if ($product) {
                                    // Ambil kategori transaksi dari parent
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

                // 🔹 Trigger update total
                TextInput::make('trigger_total_update')
                    ->hidden()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $items = $get('items') ?? [];
                        $total = collect($items)->sum('subtotal');
                        $set('total_amount', $total);
                    }),

                // 🔹 Total transaksi
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
