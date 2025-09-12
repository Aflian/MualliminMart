<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Maullim Mart</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2, h4 {
            text-align: center;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th {
            background-color: #f0f0f0;
            text-align: center;
            padding: 6px;
        }
        td {
            padding: 6px;
        }
        .right {
            text-align: right;
        }
        .center {
            text-align: center;
        }
        .summary {
            margin-top: 20px;
            border: 1px solid #444;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h2>Laporan Cashbook</h2>
    <h4>
        Periode:
        @if($periode === 'daily')
            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
        @elseif($periode === 'weekly')
            Minggu ke-{{ \Carbon\Carbon::parse($tanggal)->week }} ({{ \Carbon\Carbon::parse($tanggal)->startOfWeek()->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggal)->endOfWeek()->format('d/m/Y') }})
        @elseif($periode === 'monthly')
            Bulan {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('F Y') }}
        @endif
    </h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Kuantitas</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>Tipe</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalIn = 0;
                $totalOut = 0;
            @endphp

            @foreach($records as $index => $record)
                @php
                    if($record->type === 'in') {
                        $totalIn += $record->amount;
                    } else {
                        $totalOut += $record->amount;
                    }
                @endphp
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center">{{ $record->transaction->invoice_number ?? '-' }}</td>
                    <td class="center">{{ $record->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($record->transaction && $record->transaction->items)
                            <ul style="margin: 0; padding-left: 15px;">
                                @foreach($record->transaction->items as $item)
                                    <li>{{ $item->product->name ?? '-' }}</li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                    <td class="center">
                        @if($record->transaction && $record->transaction->items)
                            <ul style="margin: 0; padding-left: 15px;">
                                @foreach($record->transaction->items as $item)
                                    <li>{{ $item->quantity }} {{ $item->unit }}</li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                    <td class="right">
                        @if($record->transaction && $record->transaction->items)
                            <ul style="margin: 0; padding-left: 15px; list-style:none;">
                                @foreach($record->transaction->items as $item)
                                    <li>Rp {{ number_format($item->price, 0, ',', '.') }}</li>
                                @endforeach
                            </ul>
                        @else
                            Rp 0
                        @endif
                    </td>
                    <td class="right">Rp {{ number_format($record->amount, 0, ',', '.') }}</td>
                    <td class="center">{{ strtoupper($record->type) }}</td>
                    <td class="center">{{ ucfirst($record->category) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Total Pemasukan (In):</strong> Rp {{ number_format($totalIn, 0, ',', '.') }}</p>
        <p><strong>Total Pengeluaran (Out):</strong> Rp {{ number_format($totalOut, 0, ',', '.') }}</p>
        <p><strong>Saldo Akhir:</strong> Rp {{ number_format($totalIn - $totalOut, 0, ',', '.') }}</p>
    </div>
</body>
</html>
