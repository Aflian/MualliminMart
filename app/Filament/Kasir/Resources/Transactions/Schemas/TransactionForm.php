<?php

namespace App\Filament\Kasir\Resources\Transactions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use App\Models\Shift;
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

                // 🔹 User otomatis (kasir login)
                Hidden::make('user_id')
                    ->default(fn () => Auth::id())
                    ->dehydrated(),

                // 🔹 Shift manual
                Select::make('shift_id')
                    ->label('Shift')
                    ->options(Shift::pluck('shift_name', 'id'))
                    ->searchable()
                    ->required(),

                TextInput::make('customer_name')
                    ->label('Nama Customer'),

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

                // 🔹 Input scan barcode
                TextInput::make('scan_barcode')
                    ->label('Scan / Input Barcode')
                    ->placeholder('Scan barcode produk atau ketik manual, lalu tekan Enter...')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        if (!$state) return;

                        $product = Product::where('sku', trim($state))->first();
                        if (!$product) {
                            return;
                        }

                        $items = $get('items') ?? [];
                        $category = $get('category');
                        $price = $category === 'pembelian' ? $product->purchase_price : $product->selling_price;

                        $found = false;
                        foreach ($items as $index => $item) {
                            if ($item['product_id'] == $product->id) {
                                $items[$index]['quantity'] = ($items[$index]['quantity'] ?? 1) + 1;
                                $items[$index]['subtotal'] = $items[$index]['quantity'] * $items[$index]['price'];
                                $found = true;
                                break;
                            }
                        }

                        if (!$found) {
                            $items[] = [
                                'product_id'   => $product->id,
                                'product_name' => $product->name,
                                'quantity'     => 1,
                                'price'        => $price,
                                'subtotal'     => $price,
                            ];
                        }

                        $set('items', $items);
                        $set('trigger_total_update', now()->timestamp);

                        $set('scan_barcode', '');
                    }),

                // 🔹 Daftar item
                Repeater::make('items')
                    ->relationship('items')
                    ->label('Daftar Barang')
                    ->schema([
                        Hidden::make('product_id'),

                        TextInput::make('product_name')
                            ->label('Produk')
                            ->disabled()
                            ->dehydrated(false)
                            ->afterStateHydrated(function ($state, callable $set, callable $get) {
                                if (!$state && $get('product_id')) {
                                    $set('product_name', Product::find($get('product_id'))->name ?? '');
                                }
                            })
                            ->columnSpan(4),

                        TextInput::make('quantity')
                            ->label('Qty')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $price = $get('price') ?? 0;
                                $set('subtotal', $state * $price);
                                $set('../../trigger_total_update', now()->timestamp);
                            })
                            ->columnSpan(2),

                        TextInput::make('price')
                            ->label('Harga')
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->columnSpan(3),

                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(3),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),

                // 🔹 Trigger untuk hitung total
                TextInput::make('trigger_total_update')
                    ->hidden()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $items = $get('items') ?? [];
                        $total = collect($items)->sum('subtotal');
                        $set('total_amount', $total);

                        // otomatis update kembalian kalau ada uang dibayar
                        $dibayar = $get('uang_dibayar') ?? 0;
                        $set('uang_kembalian', max(0, $dibayar - $total));
                    }),

                // 🔹 Total belanja
                TextInput::make('total_amount')
                    ->label('Total')
                    ->numeric()
                    ->disabled()
                    ->prefix('Rp')
                    ->dehydrated(),

                // 🔹 Uang dibayar
                TextInput::make('uang_dibayar')
                    ->label('Uang Dibayar')
                    ->numeric()
                    ->live(debounce: 500) // biar tidak ke-reset saat ketik
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $total = $get('total_amount') ?? 0;
                        $set('uang_kembalian', max(0, $state - $total));
                    }),

                // 🔹 Uang kembalian
                TextInput::make('uang_kembalian')
                    ->label('Kembalian')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false),

                DateTimePicker::make('transaction_date')
                    ->label('Tanggal Transaksi')
                    ->default(now())
                    ->readOnly()
                    ->required(),

                DateTimePicker::make('due_date')
                    ->label('Jatuh Tempo')
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
