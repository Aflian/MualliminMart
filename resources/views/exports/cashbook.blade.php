<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan Maullim Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Print Mode */
        @media print {
            .no-print { display: none; }
            body { font-size: 10px; }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            font-size: 11px;
        }

        .report-container {
            background: #fff;
            padding: 1.5rem;
            margin: 1rem auto;
            max-width: 1400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Header */
        .header-title {
            border-bottom: 3px solid #0d6efd;
            padding-bottom: .75rem;
            margin-bottom: 1rem;
        }
        .header-title h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: .25rem;
        }
        .header-title h4 {
            font-size: 1rem;
            font-weight: 400;
        }

        /* Table */
        .table-responsive { margin-top: 1rem; }
        .table {
            font-size: .85rem;
            margin-bottom: 0;
        }
        .table thead th {
            background-color: #0d6efd;
            color: #fff;
            font-weight: 600;
            vertical-align: middle;
            padding: .5rem .4rem;
            font-size: .8rem;
            border: 1px solid #0a58ca;
            text-align: center;
        }
        .table tbody td {
            padding: .4rem;
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }
        .table tbody tr:hover { background-color: #f8f9fa; }

        /* Item List */
        .item-list {
            margin: 0;
            padding-left: 1rem;
            font-size: .8rem;
        }
        .item-list li {
            margin-bottom: .15rem;
            line-height: 1.3;
        }

        /* Summary */
        .summary-box {
            background-color: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 5px;
            padding: 1rem;
            margin-top: 1.5rem;
        }
        .summary-box p { margin-bottom: .5rem; font-size: .95rem; }
        .summary-box .value {
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* Signature */
        .signature-section {
            margin-top: 3rem;
            page-break-inside: avoid;
            font-size: .9rem;
        }
        .signature-box { min-height: 80px; }
        .signature-name {
            margin-top: 60px;
            font-weight: bold;
            border-bottom: 1px solid #333;
            display: inline-block;
            min-width: 180px;
            text-align: center;
            padding-bottom: 2px;
        }

        /* Footer */
        .footer-info {
            font-size: .75rem;
            margin-top: 1rem;
        }
        .badge { font-size: .7rem; padding: .3rem .5rem; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="report-container">
            <!-- Header -->
            <div class="header-title text-center">
                <h2 class="mb-2">Laporan Cashbook Muallimin Mart </h2>
                <h4 class="text-muted">
                    Periode:
                    @if($periode === 'daily')
                        {{ \Carbon\Carbon::parse($tanggal)->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}
                    @elseif($periode === 'weekly')
                        Minggu ke-{{ \Carbon\Carbon::parse($tanggal)->timezone('Asia/Jakarta')->week }}
                        ({{ \Carbon\Carbon::parse($tanggal)->timezone('Asia/Jakarta')->startOfWeek()->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($tanggal)->timezone('Asia/Jakarta')->endOfWeek()->format('d/m/Y') }})
                    @elseif($periode === 'monthly')
                        Bulan {{ \Carbon\Carbon::parse($tanggal)->timezone('Asia/Jakarta')->translatedFormat('F Y') }}
                    @endif
                </h4>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle">
                    <thead>
                        <tr>
                            <th style="width:4%;">No</th>
                            <th style="width:9%;">Invoice</th>
                            <th style="width:10%;">Tanggal</th>
                            <th style="width:22%;">Barang</th>
                            <th style="width:10%;">Kuantitas</th>
                            <th style="width:11%;" class="text-end">Harga</th>
                            <th style="width:12%;" class="text-end">Subtotal</th>
                            <th style="width:7%;">Tipe</th>
                            <th style="width:10%;">Kategori</th>
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
                                <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                <td class="text-center"><small>{{ $record->transaction->invoice_number ?? '-' }}</small></td>
                                <td class="text-center"><small>{{ $record->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</small></td>
                                <td>
                                    @if($record->transaction && $record->transaction->items)
                                        <ul class="item-list">
                                            @foreach($record->transaction->items as $item)
                                                <li>{{ $item->product->name ?? '-' }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($record->transaction && $record->transaction->items)
                                        <ul class="item-list list-unstyled mb-0">
                                            @foreach($record->transaction->items as $item)
                                                <li>{{ $item->quantity }} {{ $item->unit }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($record->transaction && $record->transaction->items)
                                        <ul class="item-list list-unstyled mb-0">
                                            @foreach($record->transaction->items as $item)
                                                <li>Rp {{ number_format($item->price, 0, ',', '.') }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">Rp 0</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold">Rp {{ number_format($record->amount, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $record->type === 'in' ? 'success' : 'danger' }}">
                                        {{ strtoupper($record->type) }}
                                    </span>
                                </td>
                                <td class="text-center"><small>{{ ucfirst($record->category) }}</small></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="summary-box">
                <div class="row g-3 text-center text-md-start">
                    <div class="col-md-4">
                        <strong>Total Pemasukan (In):</strong><br>
                        <span class="text-success value">Rp {{ number_format($totalIn, 0, ',', '.') }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>Total Pengeluaran (Out):</strong><br>
                        <span class="text-danger value">Rp {{ number_format($totalOut, 0, ',', '.') }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>Saldo Akhir:</strong><br>
                        <span class="text-primary value">Rp {{ number_format($totalIn - $totalOut, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-end text-muted footer-info">
                <p class="mb-0">Dicetak pada: {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB</p>
                <p class="mb-0">Dicetak oleh: {{ auth()->user()->name ?? 'System' }}</p>
            </div>

            <!-- Signature Section -->
            <div class="signature-section">
                <div class="row">
                    <div class="col-6 text-center">
                        <p class="mb-4">Kasir/Admin</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
