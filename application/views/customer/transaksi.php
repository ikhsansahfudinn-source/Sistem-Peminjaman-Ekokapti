<style>
    body {
        padding-top: 80px; /* Sesuaikan dengan tinggi header */
        padding-bottom: 80px; /* Sesuaikan dengan tinggi footer */
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .trans-container {
        flex: 1 0 auto;
        margin: 2rem auto; /* Memusatkan container secara horizontal */
        max-width: 95%; /* Membatasi lebar maksimum untuk keseimbangan */
    }
    .trans-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background: #fff;
        transition: transform 0.3s ease;
    }
    .trans-card:hover {
        transform: translateY(-5px);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: none;
        font-size: 1.25rem;
        font-weight: 600;
        padding: 1rem 1.5rem;
        border-radius: 15px 15px 0 0;
    }
    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
    }
    .nav-tabs .nav-link {
        color: #495057;
        padding: 0.75rem 1.5rem;
        border-radius: 10px 10px 0 0;
        transition: all 0.3s ease;
    }
    .nav-tabs .nav-link:hover {
        background-color: #e9ecef;
    }
    .nav-tabs .nav-link.active {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }
    .trans-table {
        width: 100%;
        max-width: 1200px; /* Membatasi lebar tabel */
        margin: 0 auto; /* Memusatkan tabel secara horizontal */
        border-collapse: separate;
        border-spacing: 0;
    }
    .trans-table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 12px;
        text-align: center; /* Memusatkan teks header tabel */
    }
    .trans-table td {
        background-color: #fff;
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
        text-align: center; /* Memusatkan teks sel tabel */
    }
    .btn-primary, .btn-success, .btn-info, .btn-danger {
        padding: 8px 16px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .btn-primary {
        background-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .btn-success {
        background-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
    }
    .btn-info {
        background-color: #17a2b8;
    }
    .btn-info:hover {
        background-color: #138496;
    }
    .btn-danger {
        background-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #c82333;
    }
    .btn.disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    .flash-message {
        display: block;
        margin: 1rem 1.5rem;
        padding: 0.75rem;
        background-color: #e9ecef;
        border-radius: 5px;
    }
    /* Responsive table untuk layar kecil */
    @media (max-width: 767.98px) {
        .trans-table {
            display: block;
        }
        .trans-table thead {
            display: none;
        }
        .trans-table tbody, .trans-table tr {
            display: block;
        }
        .trans-table tr {
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 0.5rem;
        }
        .trans-table td {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem;
            border: none;
            text-align: left; /* Teks kiri untuk sel di mobile agar label jelas */
        }
        .trans-table td:before {
            content: attr(data-label);
            font-weight: 600;
            width: 40%;
            min-width: 120px;
        }
        .trans-table td:last-child {
            border-bottom: none;
        }
        .trans-card {
            margin-top: 1rem;
        }
        .nav-tabs .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        .nav-tabs {
            flex-wrap: wrap; /* Membungkus tab di layar kecil */
            justify-content: flex-start; /* Menyesuaikan tab di mobile */
        }
    }
    @media (max-width: 576px) {
        .trans-container {
            padding: 0 0.5rem;
        }
        .trans-card {
            width: 100%;
        }
        .flash-message {
            max-width: 100%;
        }
    }
</style>

<div class="container trans-container">
    <div class="card trans-card">
        <div class="card-header">
            Data Transaksi Anda
        </div>
        <span class="flash-message"><?php echo $this->session->flashdata('pesan') ? $this->session->flashdata('pesan') : ''; ?></span>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="keranjang-tab" data-toggle="tab" href="#keranjang" role="tab" aria-controls="keranjang" aria-selected="true">Daftar Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Barang Disewa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="disewa-tab" data-toggle="tab" href="#disewa" role="tab" aria-controls="disewa" aria-selected="false">Barang Dibayar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="dikembalikan-tab" data-toggle="tab" href="#dikembalikan" role="tab" aria-controls="dikembalikan" aria-selected="false">Barang Dikembalikan</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="keranjang" role="tabpanel" aria-labelledby="keranjang-tab">
                    <form id="keranjangForm" action="<?php echo base_url('customer/transaksi/pembayaran_keranjang') ?>" method="post">
                        <input type="hidden" name="selected_transaksi_ids" id="selected_transaksi_ids">
                        <table class="table trans-table">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga/hari</th>
                                    <th>Denda/hari</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach($transaksi as $tr) : ?>
                                    <tr class="keranjang-row">
                                        <td data-label="Select"><input type="checkbox" name="selected_transaksi[]" value="<?php echo $tr->id_pinjam ?>" class="select-checkbox"></td>
                                        <td data-label="No"><?php echo $no++ ?></td>
                                        <td data-label="Nama Barang"><?php echo $tr->nama_barang ?></td>
                                        <td data-label="Jumlah"><?php echo (int)$tr->jumlah ?></td>
                                        <td data-label="Harga/hari"><?php echo number_format($tr->harga,0,',','.')?></td>
                                        <td data-label="Denda/hari"><?php echo number_format($tr->denda,0,',','.')?></td>
                                        <td data-label="Tanggal Sewa"><?php echo date('d/m/Y', strtotime($tr->tanggal_rental)); ?></td>
                                        <td data-label="Tanggal Kembali"><?php echo date('d/m/Y', strtotime($tr->tanggal_kembali)); ?></td>
                                        <td data-label="Action">
                                            <a onclick="return confirm('Anda yakin membatalkan?')" class="btn btn-sm btn-danger" href="<?php echo base_url('customer/transaksi/batal_transaksi/' . $tr->id_pinjam) ?>">Batal</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button type="submit" id="prosesKeranjangBtn" class="btn btn-primary" disabled>Sewa Barang</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <form id="pendingForm" action="<?php echo base_url('customer/transaksi/pembayaran_pending') ?>" method="post">
                        <input type="hidden" name="selected_pending_ids" id="selected_pending_ids">
                        <table class="table trans-table">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga/hari</th>
                                    <th>Denda/hari</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Tanggal Kembali</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach($pending as $pd) : ?>
                                    <tr class="pending-row">
                                        <td data-label="Select"><input type="checkbox" name="selected_pending[]" value="<?php echo $pd->id_pinjam ?>" class="select-pending-checkbox"></td>
                                        <td data-label="No"><?php echo $no++ ?></td>
                                        <td data-label="Nama Barang"><?php echo $pd->nama_barang ?></td>
                                        <td data-label="Jumlah"><?php echo (int)$pd->jumlah ?></td>
                                        <td data-label="Harga/hari"><?php echo number_format($pd->harga,0,',','.')?></td>
                                        <td data-label="Denda/hari"><?php echo number_format($pd->denda,0,',','.')?></td>
                                        <td data-label="Tanggal Sewa"><?php echo date('d/m/Y', strtotime($pd->tanggal_rental)); ?></td>
                                        <td data-label="Tanggal Kembali"><?php echo date('d/m/Y', strtotime($pd->tanggal_kembali)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button type="submit" id="prosesPendingBtn" class="btn btn-info" disabled>Bayar Barang</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="disewa" role="tabpanel" aria-labelledby="disewa-tab">
                    <table class="table trans-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga/hari</th>
                                <th>Denda/hari</th>
                                <th>Tanggal Sewa</th>
                                <th>Tanggal Kembali</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($disewa as $ds) : ?>
                                <tr>
                                    <td data-label="No"><?php echo $no++ ?></td>
                                    <td data-label="Nama Barang"><?php echo $ds->nama_barang ?></td>
                                    <td data-label="Jumlah"><?php echo (int)$ds->jumlah ?></td>
                                    <td data-label="Harga/hari"><?php echo number_format($ds->harga,0,',','.')?></td>
                                    <td data-label="Denda/hari"><?php echo number_format($ds->denda,0,',','.')?></td>
                                    <td data-label="Tanggal Sewa"><?php echo date('d/m/Y', strtotime($ds->tanggal_rental)); ?></td>
                                    <td data-label="Tanggal Kembali"><?php echo date('d/m/Y', strtotime($ds->tanggal_kembali)); ?></td>
                                    <td data-label="Action">
                                        <a href="<?php echo base_url('customer/transaksi/pembayaran/' . $ds->id_pinjam) ?>" class="btn btn-sm btn-success">Check Konfirmasi</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="dikembalikan" role="tabpanel" aria-labelledby="dikembalikan-tab">
                    <table class="table trans-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga/hari</th>
                                <th>Denda/hari</th>
                                <th>Tanggal Sewa</th>
                                <th>Tanggal Kembali</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($dikembalikan as $dk) : ?>
                                <tr>
                                    <td data-label="No"><?php echo $no++ ?></td>
                                    <td data-label="Nama Barang"><?php echo $dk->nama_barang ?></td>
                                    <td data-label="Jumlah"><?php echo (int)$dk->jumlah ?></td>
                                    <td data-label="Harga/hari"><?php echo number_format($dk->harga,0,',','.')?></td>
                                    <td data-label="Denda/hari"><?php echo number_format($dk->denda,0,',','.')?></td>
                                    <td data-label="Tanggal Sewa"><?php echo date('d/m/Y', strtotime($dk->tanggal_rental)); ?></td>
                                    <td data-label="Tanggal Kembali"><?php echo date('d/m/Y', strtotime($dk->tanggal_kembali)); ?></td>
                                    <td data-label="Action">
                                        <a href="<?php echo base_url('customer/transaksi/pembayaran/' . $dk->id_pinjam) ?>" class="btn btn-sm btn-primary">Check Invoice</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Keranjang tab functionality
        const checkboxes = document.querySelectorAll('.select-checkbox');
        const prosesKeranjangBtn = document.getElementById('prosesKeranjangBtn');
        const selectedTransaksiIds = document.getElementById('selected_transaksi_ids');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const selectedIds = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
                selectedTransaksiIds.value = selectedIds.join(',');
                prosesKeranjangBtn.disabled = selectedIds.length === 0;
            });
        });

        document.getElementById('keranjangForm').addEventListener('submit', function(event) {
            if (!selectedTransaksiIds.value) {
                event.preventDefault();
                alert('Pilih setidaknya satu transaksi untuk diproses.');
            } else {
                const selectedIds = selectedTransaksiIds.value.split(',');
                selectedIds.forEach(id => {
                    const row = document.querySelector(`.select-checkbox[value="${id}"]`)?.closest('.keranjang-row');
                    if (row) row.remove();
                });
            }
        });

        // Pending tab functionality
        const pendingCheckboxes = document.querySelectorAll('.select-pending-checkbox');
        const prosesPendingBtn = document.getElementById('prosesPendingBtn');
        const selectedPendingIds = document.getElementById('selected_pending_ids');

        pendingCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const selectedIds = Array.from(pendingCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
                selectedPendingIds.value = selectedIds.join(',');
                prosesPendingBtn.disabled = selectedIds.length === 0;
            });
        });

        document.getElementById('pendingForm').addEventListener('submit', function(event) {
            if (!selectedPendingIds.value) {
                event.preventDefault();
                alert('Pilih setidaknya satu transaksi untuk diproses.');
            } else {
                const selectedIds = selectedPendingIds.value.split(',');
                selectedIds.forEach(id => {
                    const row = document.querySelector(`.select-pending-checkbox[value="${id}"]`)?.closest('.pending-row');
                    if (row) row.remove();
                });
            }
        });
    });
</script>