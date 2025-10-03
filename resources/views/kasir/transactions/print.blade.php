<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk {{ $transaction->invoice_number }}</title>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            width: 58mm;
            margin: 0 auto;
        }
        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 2px 0;
            vertical-align: top;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="center bold">
        MU`ALLIMIN MART
    </div>
    <div class="center">
        KOMPLEK MU'ALLIMIN MUHAMMADIYAH BANGKINANG KOTA<br>
        Telp: 0812-3456-7890
    </div>
    <hr>

    <table>
        <tr>
            <td>Invoice</td>
            <td>: {{ $transaction->invoice_number }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: {{ $transaction->transaction_date->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td>: {{ $transaction->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>Customer</td>
            <td>: {{ $transaction->customer_name ?? '-' }}</td>
        </tr>
    </table>
    <hr>

    <table>
        @foreach ($transaction->items as $item)
            <tr>
                <td colspan="2">{{ $item->product->name ?? 'Produk' }}</td>
            </tr>
            <tr>
                <td>{{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>
    <hr>

    <table>
        <tr>
            <td class="bold">Total</td>
            <td class="right bold">{{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Metode</td>
            <td class="right">{{ $transaction->paymentMethod->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td class="right">{{ ucfirst($transaction->payment_status) }}</td>
        </tr>
    </table>
    <hr>

    <div class="center">
        JAZAKUMULLAHU KHAIRAN 🙏<br>
        Barang yang sudah dibeli tidak dapat dikembalikan.
        <br>
        Perform The Future
    </div>
</body>
</html>
