<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Data Transaksi</h1>
		</div>

		<?php echo $this->session->flashdata('pesan') ?>

		<!-- Filter Form -->
		<div class="card mb-4">
			<div class="card-header">
				<h4>Filter Data Transaksi</h4>
			</div>
			<div class="card-body">
				<form action="<?php echo base_url('rental/transaksi') ?>" method="GET">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Status Sewa</label>
								<select name="status_rental" class="form-control">
									<option value="semua" <?php echo ($status_rental == 'semua' || $status_rental == '') ? 'selected' : '' ?>>Semua</option>
									<option value="Keranjang" <?php echo ($status_rental == 'Keranjang') ? 'selected' : '' ?>>Keranjang</option>
									<option value="Pending" <?php echo ($status_rental == 'Pending') ? 'selected' : '' ?>>Pending (Belum Dibayar)</option>
									<option value="menunggu_konfirmasi" <?php echo ($status_rental == 'menunggu_konfirmasi') ? 'selected' : '' ?>>Menunggu Konfirmasi (Sudah Dibayar)</option>
									<option value="Selesai" <?php echo ($status_rental == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Tanggal Mulai</label>
								<input type="date" name="tanggal_mulai" class="form-control" value="<?php echo $tanggal_mulai ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Tanggal Selesai</label>
								<input type="date" name="tanggal_selesai" class="form-control" value="<?php echo $tanggal_selesai ?>">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>&nbsp;</label>
								<button type="submit" class="btn btn-primary form-control">Filter</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<tr>
					<th>No</th>
					<th>Penyewa</th>
					<th>Barang</th>
					<th>Tgl. Sewa</th>
					<th>Tgl. Kembali</th>
					<th>Harga/Hari</th>
					<th>Denda/Hari</th>
					<th>Total Harga (+Denda)</th>
					<th>Jumlah</th>
					<th>Tgl. Dikembalikan</th>
					<th>Status Pengembalian</th>
					<th>Status Sewa</th>
					<th>Bukti Pembayaran</th>
					<th>Action</th>
				</tr>
				<?php
				$no = 1;
				foreach ($transaksi as $tr) : ?>
					<tr>
						<td><?php echo $no++ ?></td>
						<td><?php echo $tr->nama ?></td>
						<td><?php echo $tr->nama_barang ?></td>
						<td><?php echo date('d/m/Y', strtotime($tr->tanggal_rental)) ?></td>
						<td><?php echo date('d/m/Y', strtotime($tr->tanggal_kembali)) ?></td>
						<td>Rp. <?php echo number_format($tr->harga, 0, ',', '.') ?></td>
						<td>Rp. <?php echo number_format($tr->denda, 0, ',', '.') ?></td>
						<td>
							Rp. <?php echo number_format($tr->total_denda, 0, ',', '.') ?>
						</td>
						<td><?php echo $tr->jumlah ?></td>
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
							<?php if ($tr->status_pengembalian == "Kembali") {
								echo "Kembali";
							} else {
								echo "Belum Kembali";
							}

							?>
						</td>

						<td>
							<?php if ($tr->status_rental == "Selesai") {
								echo "Kembali";
							} else {
								echo "Belum Selesai";
							}

							?>
						</td>

						<td>

							<center>


								<?php if ($tr->status_pembayaran == "1") { ?>
									<a class="btn btn-sm btn-primary text-white"><i class="fas fa-check-circle"></i></a>
								<?php } else { ?>
									<?php
									if (empty($tr->bukti_pembayaran)) { ?>

										<button class="btn btn-sm btn-danger"><i class="fas fa-times-circle"></i></button>

									<?php } else { ?>

										<a class="btn btn-sm btn-warning" href="<?php echo base_url('rental/transaksi/pembayaran/' . $tr->id_pinjam) ?>"><i class="fas fa-clock"></i></a>

									<?php } ?>
								<?php } ?>



							</center>

						</td>

						<td>

							<?php

							if ($tr->status_pembayaran == "1") {
								echo "-";
							} else { ?>

								<div class="row">
									<a class="btn btn-sm btn-success mr-2" href="<?php echo base_url('rental/transaksi/transaksi_selesai/' . $tr->id_pinjam) ?>"><i class="fas fa-check"></i></a>
									<a onclick="return confirm('Anda yakin membatalkan/menghapus transaksi ini?')" class="btn btn-sm btn-danger" href="<?php echo base_url('rental/transaksi/batal_transaksi/' . $tr->id_pinjam) ?>"><i class="fas fa-times"></i></a>
								</div>

							<?php } ?>

						</td>
					</tr>

				<?php endforeach; ?>
			</table>
		</div>

		<!-- Pagination -->
		<div class="mt-4">
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</section>
</div>