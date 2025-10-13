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
				<form action="<?php echo base_url('admin/transaksi') ?>" method="GET">
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
								<label>Filter User</label>
								<select name="user" class="form-control">
									<option value="">Semua User</option>
									<?php foreach ($customers as $cs) : ?>
										<option value="<?php echo $cs->id_customer ?>" <?php echo ($filter_user == $cs->id_customer) ? 'selected' : '' ?>>
											<?php echo $cs->nama ?>
										</option>
									<?php endforeach; ?>
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
					<th>Jumlah</th>
					<th>Harga/Hari</th>
					<th>Denda/Hari</th>
					<th>Total Harga (+Denda)</th>
					<th>Total Bayar</th>
					<th>Tgl. Dikembalikan</th>
					<th>Status Pengembalian</th>
					<th>Status Sewa</th>
					<th>Bukti Pembayaran</th>
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
						<td><?php echo $tr->jumlah ?></td>
						<td>Rp. <?php echo number_format($tr->harga, 0, ',', '.') ?></td>
						<td>Rp. <?php echo number_format($tr->denda, 0, ',', '.') ?></td>
						<td>
							Rp. <?php echo number_format($tr->total_denda, 0, ',', '.') ?>
						</td>
						<td>
							<?php
							// Calculate base rental cost
							$rental_days = ceil((strtotime($tr->tanggal_kembali) - strtotime($tr->tanggal_rental)) / (60 * 60 * 24)) + 1;
							$base_cost = $tr->harga * $rental_days * $tr->jumlah;

							// Check if there's late return and calculate late fees
							$has_late_fee = false;
							$late_fee = 0;
							$total_bayar = $base_cost; // Start with base cost

							if ($tr->tanggal_pengembalian != "0000-00-00" && !empty($tr->tanggal_pengembalian)) {
								if (strtotime($tr->tanggal_pengembalian) > strtotime($tr->tanggal_kembali)) {
									$has_late_fee = true;
									$late_days = ceil((strtotime($tr->tanggal_pengembalian) - strtotime($tr->tanggal_kembali)) / (60 * 60 * 24));
									$late_fee = $late_days * $tr->denda * $tr->jumlah;
									$total_bayar = $base_cost + $late_fee; // Add late fee to total
								}
							}
							?>
							<div>
								<strong>Rp. <?php echo number_format($total_bayar, 0, ',', '.') ?></strong>
								<?php if ($has_late_fee): ?>
									<br><small class="text-danger">
										<i class="fas fa-exclamation-triangle"></i>
										Termasuk denda: Rp. <?php echo number_format($late_fee, 0, ',', '.') ?>
									</small>
								<?php else: ?>
									<br><small class="text-success">
										<i class="fas fa-check-circle"></i>
										Tanpa denda
									</small>
								<?php endif; ?>
							</div>
						</td>
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
							<?php
							// Menentukan warna berdasarkan status pengembalian
							$pengembalian_class = ($tr->status_pengembalian == "Kembali") ? 'badge badge-success' : 'badge badge-danger';
							?>
							<span class="<?php echo $pengembalian_class; ?>">
								<?php echo $tr->status_pengembalian; ?>
							</span>
						</td>

						<td>
							<?php
							// Menentukan warna berdasarkan status peminjaman
							$status_class = '';
							if ($tr->status_rental == "Selesai") {
								$status_class = 'badge badge-success'; // Hijau
							} elseif ($tr->status_rental == "Pending") {
								$status_class = 'badge badge-warning'; // Oranye
							} else {
								$status_class = 'badge badge-secondary'; // Abu-abu
							}
							?>
							<span class="<?php echo $status_class; ?>">
								<?php echo $tr->status_rental; ?>
							</span>
						</td>

						<td>

							<center>
								<div class="mb-2">
									<?php if ($tr->status_pembayaran == "1") { ?>
										<a class="btn btn-sm btn-primary text-white"><i class="fas fa-check-circle"></i> Terkonfirmasi</a>
									<?php } else { ?>
										<?php
										if (empty($tr->bukti_pembayaran)) { ?>

											<button class="btn btn-sm btn-danger"><i class="fas fa-times-circle"></i> Belum Upload</button>

										<?php } else { ?>

											<a class="btn btn-sm btn-warning" href="<?php echo base_url('admin/transaksi/pembayaran/' . $tr->id_pinjam) ?>"><i class="fas fa-clock"></i> Perlu Konfirmasi</a>

										<?php } ?>
									<?php } ?>
								</div>

							</center>

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