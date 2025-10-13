<style>
    .print-container {
        max-width: 1000px;
        margin: 20px auto;
        padding: 30px;
        background: #fff;
    }

    .print-header {
        text-align: center;
        border-bottom: 2px solid #eee;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .print-title {
        color: #2c3e50;
        font-size: 24px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin: 25px 0;
    }

    .report-table thead tr {
        background-color: #34495e;
        color: #fff;
    }

    .report-table th,
    .report-table td {
        padding: 12px 15px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .report-table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85em;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    @media print {

        .no-print,
        .print-btn {
            display: none !important;
        }

        .print-container {
            margin: 0;
            padding: 10px;
        }

        .report-table {
            font-size: 12px;
        }
    }
</style>

<div class="print-container">
    <div class="print-header">
        <h1 class="print-title">Laporan Transaksi</h1>
        <p class="text-muted">Periode: <?php echo date('d/m/Y', strtotime($_GET['dari'])) ?> - <?php echo date('d/m/Y', strtotime($_GET['sampai'])) ?></p>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tgl Sewa</th>
                <th>Tgl Kembali</th>
                <th>Tgl. Dikembalikan</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($transaksi as $tr): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $tr->nama ?></td>
                    <td><?= $tr->nama_barang ?></td>
                    <td><?php echo $tr->jumlah ?></td>
                    <td><?= date('d/m/Y', strtotime($tr->tanggal_rental)) ?></td>
                    <td><?= date('d/m/Y', strtotime($tr->tanggal_kembali)) ?></td>
                    <td>
                        <?php
                        if ($tr->tanggal_pengembalian == "0000-00-00") {
                            echo "-";
                        } else {
                            echo date('d/m/Y', strtotime($tr->tanggal_pengembalian));
                        }
                        ?>
                    </td>
                    <td>Rp <?= number_format($tr->total_denda, 0, ',', '.') ?></td>
                    <td>
                        <?php
                        $statusClass = '';
                        if ($tr->status_rental == 'Selesai') {
                            $statusClass = 'badge-success';
                        } elseif ($tr->status_pembayaran == '0') {
                            $statusClass = 'badge-warning';
                        } else {
                            $statusClass = 'badge-danger';
                        }
                        ?>
                        <span class="status-badge <?= $statusClass ?>">
                            <?= ($tr->status_rental == 'Selesai') ? 'Selesai' : 'Proses' ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="margin-top: 30px; text-align: right;">
        <p style="margin-bottom: 40px;">Mengetahui,<br>Admin</p>
        <p>(__________________________)</p>
    </div>
    <div style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="background-color: #1E90FF; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Cetak Laporan</button>
    </div>
</div>