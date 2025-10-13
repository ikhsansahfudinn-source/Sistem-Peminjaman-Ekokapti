<div class="container">
	<div class="card" style="margin-top: 170px; margin-bottom: 50px">
		<div class="card-header">
			Form Sewa
		</div>
		<span class="mt-2"><?php echo $this->session->flashdata('pesan') ?></span>
		<div class="card-body">
			<?php foreach ($detail as $dt) : ?>
				<form method="POST" action="<?php echo base_url('customer/rental/tambah_rental_aksi') ?>">
					<div class="form-group">
						<label>Nama Barang</label>
						<input type="text" name="nama_barang" class="form-control" value="<?php echo $dt->nama_barang ?>" readonly>
					</div>

					<div class="form-group">
						<label>Penanggung Jawab</label>
						<input type="text" name="penanggung_jawab" class="form-control" value="<?php echo $dt->penanggung_jawab ?>" readonly>
					</div>

					<div class="form-group">
						<label>Harga Sewa/Hari</label>
						<input type="hidden" name="id_barang" value="<?php echo $dt->id_barang ?>">
						<input type="hidden" name="penanggung_jawab" value="<?php echo $dt->penanggung_jawab ?>">
						<input type="text" name="harga" class="form-control" value="<?php echo $dt->harga ?>" readonly>
					</div>

					<div class="form-group">
						<label>Denda/Hari</label>
						<input type="text" name="denda" class="form-control" value="<?php echo $dt->denda ?>" readonly>
					</div>

					<div class="form-group">
						<label>Jumlah Barang</label>
						<input type="number" name="jumlah" class="form-control" min="1" required>
					</div>

					<div class="form-group">
						<label>Tanggal Pinjam</label>
						<input type="date" name="tanggal_rental" class="form-control" min="<?php echo date('Y-m-d'); ?>"
							required>

					</div>

					<div class="form-group">
						<label>Tanggal Kembali</label>
						<input type="date" name="tanggal_kembali" class="form-control" min="<?php echo date('Y-m-d'); ?>"
							required>
					</div>

					<?php if ($dt->status == '1') { ?>
						<button type="submit" class="btn btn-success">Sewa</button>
					<?php } else { ?>
						<button type="button" class="btn btn-danger disabled">Tidak Tersedia</button>
					<?php } ?>
				</form>
			<?php endforeach; ?>
		</div>
	</div>
</div>