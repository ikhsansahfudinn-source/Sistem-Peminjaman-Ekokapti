<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Filter Laporan Peminjaman</h1>
		</div>
	</section>

	<form method="POST" action="<?php echo base_url('rental/laporan') ?>">
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label>Dari Tanggal</label>
					<input type="date" name="dari" class="form-control" required>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label>Sampai Tanggal</label>
					<input type="date" name="sampai" class="form-control" required>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<label>Filter User</label>
					<select name="user" class="form-control">
						<option value="">Semua User</option>
						<?php foreach ($customers as $cs) : ?>
							<option value="<?php echo $cs->id_customer ?>">
								<?php echo $cs->nama ?>
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
</div>