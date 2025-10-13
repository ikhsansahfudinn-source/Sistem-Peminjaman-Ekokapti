<div class="main-content">
	<section class="section">
		<div class="section-header">
			<h1>Transaksi Selesai</h1>
		</div>
	</section>

	<?php foreach ($transaksi as $tr) : ?>
		<form method="POST" action="<?php echo base_url('admin/transaksi/transaksi_selesai_aksi') ?>">
			<input type="hidden" name="id_pinjam" value="<?php echo $tr->id_pinjam ?>">
			<input type="hidden" name="id_barang" value="<?php echo $tr->id_barang ?>">

			<input type="hidden" name="tanggal_kembali" value="<?php echo $tr->tanggal_kembali ?>">
			<input type="hidden" name="denda" value="<?php echo $tr->denda ?>">

			<div class="form-group">
				<label>Tanggal Pengembalian</label>
				<input type="date" name="tanggal_pengembalian" class="form-control" value="<?php echo $tr->tanggal_pengembalian ?>" required>
			</div>

			<div class="form-group">
				<label>Status Pengembalian</label>
				<select name="status_pengembalian" class="form-control" required>
					<option value="" disabled selected>Pilih Status</option>
					<option value="Kembali" <?php echo ($tr->status_pengembalian == 'Kembali') ? 'selected' : ''; ?>>Kembali</option>
					<option value="Belum Kembali" <?php echo ($tr->status_pengembalian == 'Belum Kembali') ? 'selected' : ''; ?>>Belum Kembali</option>
				</select>
			</div>

			<div class="form-group">
				<label>Status Pinjam</label>
				<select name="status_rental" class="form-control" required>
					<option value="" disabled selected>Pilih Status</option>
					<option value="Selesai" <?php echo ($tr->status_rental == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
					<option value="Belum Selesai" <?php echo ($tr->status_rental == 'Belum Selesai') ? 'selected' : ''; ?>>Belum Selesai</option>
				</select>
			</div>

			<button type="submit" class="btn btn-success">Submit</button>
		</form>
		<hr> <!-- Tambahkan pemisah antar form jika ada lebih dari satu transaksi -->
	<?php endforeach; ?>
</div>