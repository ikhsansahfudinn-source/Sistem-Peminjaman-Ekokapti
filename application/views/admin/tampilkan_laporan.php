<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Hasil Filter Laporan</h1>
        </div>

        <form method="POST" action="<?php echo base_url('admin/laporan') ?>">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control" value="<?php echo isset($_POST['dari']) ? $_POST['dari'] : '' ?>" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control" value="<?php echo isset($_POST['sampai']) ? $_POST['sampai'] : '' ?>" required>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Filter User</label>
                        <select name="user" class="form-control">
                            <option value="">Semua User</option>
                            <?php foreach ($customers as $cs) : ?>
                                <option value="<?php echo $cs->id_customer ?>" <?php echo isset($_POST['user']) && $_POST['user'] == $cs->id_customer ? 'selected' : '' ?>>
                                    <?php echo $cs->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Filter Barang</label>
                        <select name="barang" class="form-control">
                            <option value="">Semua Barang</option>
                            <?php foreach ($barang as $br) : ?>
                                <option value="<?php echo $br->id_barang ?>" <?php echo isset($_POST['barang']) && $_POST['barang'] == $br->id_barang ? 'selected' : '' ?>>
                                    <?php echo $br->nama_barang ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status Peminjaman</label>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="dipinjam">Sedang Dipinjam</option>
                            <option value="belum_kembali">Belum Dikembalikan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status Pembayaran</label>
                        <select name="pembayaran" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="lunas">Lunas</option>
                            <option value="belum_lunas">Belum Lunas</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">
                <i class="fas fa-filter"></i> Filter Data
            </button>
        </form>

        <div class="row mb-3">
            <div class="col-md-12 mt-3">
                <a href="<?php echo base_url('admin/laporan/print_laporan?') . http_build_query($filter) ?>"
                    class="btn btn-success btn-icon icon-left" target="_blank">
                    <i class="fas fa-print"></i> Cetak Laporan
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Tgl. Dikembalikan</th>
                                <th>Status Peminjaman</th>
                                <th>Status Pengembalian</th>
                                <th>Status Bayar</th>
                                <th>Total</th>
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
                                    <td>
                                        <span class="badge badge-<?=
                                                                    ($tr->status_rental == 'Pending') ? 'warning' : (($tr->status_rental == 'Selesai') ? 'success' : 'secondary')
                                                                    ?>">
                                            <?= $tr->status_rental ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?=
                                                                    ($tr->status_pengembalian == 'Belum Kembali') ? 'danger' : 'success'
                                                                    ?>">
                                            <?= $tr->status_pengembalian ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-<?=
                                                                    ($tr->status_pembayaran == 1) ? 'success' : 'danger'
                                                                    ?>">
                                            <?= ($tr->status_pembayaran == 1) ? 'Lunas' : 'Belum Lunas' ?>
                                        </span>
                                    </td>
                                    <td>Rp <?= number_format($tr->total_denda, 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                    </table>

                </div>