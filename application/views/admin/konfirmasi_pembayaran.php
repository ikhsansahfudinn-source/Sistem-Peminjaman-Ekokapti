<div class="main-content">

	<section class="section">
		<div class="section-header">
			<h1>Konfirmasi Pembayaran & Pengembalian</h1>
		</div>

		<div class="row justify-content-center">
			<div class="col-md-10">
				<div class="card">
					<div class="card-header">
						<h4>Detail Transaksi & Konfirmasi</h4>
					</div>

					<div class="card-body">
						<?php foreach ($pembayaran as $pmb) : ?>

							<!-- Transaction Details -->
							<div class="row mb-4">
								<div class="col-md-6">
									<h6><strong>Detail Transaksi</strong></h6>
									<table class="table table-sm">
										<tr>
											<td>ID Transaksi</td>
											<td>: <?php echo $pmb->id_pinjam ?></td>
										</tr>
										<tr>
											<td>Nama Penyewa</td>
											<td>: <?php echo $pmb->nama ?></td>
										</tr>
										<tr>
											<td>Barang</td>
											<td>: <?php echo $pmb->nama_barang ?></td>
										</tr>
										<tr>
											<td>Jumlah</td>
											<td>: <?php echo $pmb->jumlah ?> unit</td>
										</tr>
										<tr>
											<td>Tanggal Sewa</td>
											<td>: <?php echo date('d/m/Y', strtotime($pmb->tanggal_rental)) ?></td>
										</tr>
										<tr>
											<td>Tanggal Kembali</td>
											<td>: <?php echo date('d/m/Y', strtotime($pmb->tanggal_kembali)) ?></td>
										</tr>
										<tr>
											<td>Status Sewa</td>
											<td>:
												<?php if ($pmb->status_rental == "Selesai") { ?>
													<span class="badge badge-success">Selesai</span>
												<?php } else { ?>
													<span class="badge badge-warning"><?php echo $pmb->status_rental ?></span>
												<?php } ?>
											</td>
										</tr>
									</table>
								</div>
								<div class="col-md-6">
									<h6><strong>Status Pembayaran & Pengembalian</strong></h6>
									<table class="table table-sm">
										<tr>
											<td>Status Pembayaran</td>
											<td>:
												<?php if ($pmb->status_pembayaran == "1") { ?>
													<span class="badge badge-success">Terkonfirmasi</span>
												<?php } else { ?>
													<span class="badge badge-warning">Menunggu Konfirmasi</span>
												<?php } ?>
											</td>
										</tr>
										<tr>
											<td>Tanggal Dikembalikan</td>
											<td>:
												<?php if ($pmb->tanggal_pengembalian == "0000-00-00" || empty($pmb->tanggal_pengembalian)) { ?>
													<span class="text-danger">Belum Dikembalikan</span>
												<?php } else { ?>
													<?php echo date('d/m/Y', strtotime($pmb->tanggal_pengembalian)) ?>
												<?php } ?>
											</td>
										</tr>
										<tr>
											<td>Status Pengembalian</td>
											<td>:
												<?php if ($pmb->status_pengembalian == "Kembali") { ?>
													<span class="badge badge-success">Sudah Kembali</span>
												<?php } else { ?>
													<span class="badge badge-danger">Belum Kembali</span>
												<?php } ?>
											</td>
										</tr>
										<tr>
											<td>Total Denda</td>
											<td>: Rp. <?php echo number_format($pmb->total_denda, 0, ',', '.') ?></td>
										</tr>
									</table>
								</div>
							</div>

							<!-- Payment Proof Section -->
							<div class="mb-4">
								<h6><strong>Bukti Pembayaran</strong></h6>
								<div class="row">
									<div class="col-md-6">
										<?php if (!empty($pmb->bukti_pembayaran)) { ?>
											<div class="card">
												<div class="card-header">
													<h6 class="mb-0">Preview Bukti Pembayaran</h6>
												</div>
												<div class="card-body text-center">
													<img src="<?php echo base_url('assets/upload/' . $pmb->bukti_pembayaran) ?>"
														class="img-fluid"
														style="max-height: 300px; cursor: pointer;"
														onclick="showImageModal('<?php echo base_url('assets/upload/' . $pmb->bukti_pembayaran) ?>')"
														alt="Bukti Pembayaran">
													<br><br>
													<a class="btn btn-success btn-sm" href="<?php echo base_url('admin/transaksi/download_pembayaran/') . $pmb->id_pinjam ?>">
														<i class="fas fa-download"></i> Download
													</a>
													<button class="btn btn-info btn-sm" onclick="showImageModal('<?php echo base_url('assets/upload/' . $pmb->bukti_pembayaran) ?>')">
														<i class="fas fa-search-plus"></i> Perbesar
													</button>
												</div>
											</div>
										<?php } else { ?>
											<div class="alert alert-warning">
												<i class="fas fa-exclamation-triangle"></i>
												Bukti pembayaran belum diupload oleh customer.
											</div>
										<?php } ?>
									</div>
									<div class="col-md-6">
										<?php if ($pmb->status_pembayaran == "0" && !empty($pmb->bukti_pembayaran)) { ?>
											<div class="card">
												<div class="card-header">
													<h6 class="mb-0">Konfirmasi Pembayaran</h6>
												</div>
												<div class="card-body">
													<form method="POST" action="<?php echo base_url('admin/transaksi/cek_pembayaran') ?>">
														<input type="hidden" name="id_pinjam" value="<?php echo $pmb->id_pinjam ?>">
														<div class="form-group">
															<div class="custom-control custom-switch">
																<input type="checkbox" class="custom-control-input" id="confirmPayment" value="1" name="status_pembayaran">
																<label class="custom-control-label" for="confirmPayment">
																	<strong>Konfirmasi Pembayaran Valid</strong>
																</label>
															</div>
															<small class="text-muted">Centang jika bukti pembayaran sudah sesuai</small>
														</div>
														<button type="submit" class="btn btn-primary btn-block">
															<i class="fas fa-check"></i> Konfirmasi Pembayaran
														</button>
													</form>
												</div>
											</div>
										<?php } elseif ($pmb->status_pembayaran == "1") { ?>
											<div class="alert alert-success">
												<i class="fas fa-check-circle"></i>
												Pembayaran sudah dikonfirmasi
											</div>
										<?php } ?>
									</div>
								</div>
							</div>

							<!-- Return Confirmation Section -->
							<?php if ($pmb->status_rental != "Selesai") { ?>
								<div class="mb-4">
									<h6><strong>Konfirmasi Pengembalian Barang</strong></h6>
									<div class="alert alert-info">
										<i class="fas fa-info-circle"></i>
										Silakan konfirmasi status pengembalian barang. Pembayaran bisa dilakukan di awal atau di akhir setelah pengembalian.
									</div>

									<div class="card">
										<div class="card-body">
											<form method="POST" action="<?php echo base_url('admin/transaksi/transaksi_selesai_aksi') ?>" id="returnForm">
												<input type="hidden" name="id_pinjam" value="<?php echo $pmb->id_pinjam ?>">
												<input type="hidden" name="id_barang" value="<?php echo $pmb->id_barang ?>">

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label><strong>Status Pengembalian</strong> <span class="text-danger">*</span></label>
															<select name="status_pengembalian" id="status_pengembalian" class="form-control" required onchange="updateStatusRental()">
																<option value="">-- Pilih Status Pengembalian --</option>
																<option value="Kembali" <?php echo ($pmb->status_pengembalian == 'Kembali') ? 'selected' : '' ?>>
																	✅ Barang Sudah Dikembalikan
																</option>
																<option value="Belum Kembali" <?php echo ($pmb->status_pengembalian == 'Belum Kembali') ? 'selected' : '' ?>>
																	❌ Barang Belum Dikembalikan
																</option>
															</select>
															<small class="text-muted">Pilih sesuai kondisi aktual barang</small>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label><strong>Tanggal Pengembalian</strong> <span class="text-danger">*</span></label>
															<input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" class="form-control"
																value="<?php echo ($pmb->tanggal_pengembalian != '0000-00-00' && !empty($pmb->tanggal_pengembalian)) ? $pmb->tanggal_pengembalian : date('Y-m-d') ?>" required>
															<small class="text-muted">Tanggal aktual barang dikembalikan</small>
														</div>
													</div>
												</div>

												<div class="form-group">
													<label><strong>Status Transaksi</strong> <span class="text-danger">*</span></label>
													<select name="status_rental" id="status_rental" class="form-control" required>
														<option value="">-- Pilih Status Transaksi --</option>
														<option value="Selesai" <?php echo ($pmb->status_rental == 'Selesai') ? 'selected' : '' ?>>
															🎯 Selesai (Transaksi Selesai)
														</option>
														<option value="Pending" <?php echo ($pmb->status_rental == 'Pending') ? 'selected' : '' ?>>
															⏳ Pending (Masih Berlangsung)
														</option>
													</select>
													<small class="text-muted">Selesai = Transaksi selesai dan barang dikembalikan</small>
												</div>

												<div class="alert alert-warning" id="warningMessage" style="display: none;">
													<i class="fas fa-exclamation-triangle"></i>
													<span id="warningText"></span>
												</div>

												<!-- Payment Status Info -->
												<div class="alert <?php echo ($pmb->status_pembayaran == '1') ? 'alert-success' : 'alert-warning' ?>">
													<i class="fas <?php echo ($pmb->status_pembayaran == '1') ? 'fa-check-circle' : 'fa-clock' ?>"></i>
													<strong>Status Pembayaran:</strong>
													<?php if ($pmb->status_pembayaran == '1') { ?>
														Sudah dikonfirmasi
													<?php } else { ?>
														<?php if (!empty($pmb->bukti_pembayaran)) { ?>
															Menunggu konfirmasi (bukti sudah diupload)
														<?php } else { ?>
															Belum ada bukti pembayaran
														<?php } ?>
													<?php } ?>
												</div>

												<div class="row">
													<div class="col-md-6">
														<button type="submit" class="btn btn-success btn-block" id="submitBtn">
															<i class="fas fa-check-circle"></i> Simpan Konfirmasi Pengembalian
														</button>
													</div>
													<div class="col-md-6">
														<a href="<?php echo base_url('admin/transaksi/batal_transaksi/' . $pmb->id_pinjam) ?>"
															class="btn btn-danger btn-block"
															onclick="return confirm('Anda yakin membatalkan transaksi ini? Tindakan ini tidak dapat dibatalkan.')">
															<i class="fas fa-times-circle"></i> Batalkan Transaksi
														</a>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<div class="alert alert-success">
									<i class="fas fa-check-circle"></i>
									<strong>Transaksi telah selesai.</strong> Barang sudah dikembalikan dan pembayaran sudah dikonfirmasi.
									<br><small>Tanggal pengembalian: <?php echo ($pmb->tanggal_pengembalian != '0000-00-00') ? date('d/m/Y', strtotime($pmb->tanggal_pengembalian)) : '-' ?></small>
								</div>
							<?php } ?>

							<!-- Back Button -->
							<div class="text-center mt-4">
								<a href="<?php echo base_url('admin/transaksi') ?>" class="btn btn-secondary">
									<i class="fas fa-arrow-left"></i> Kembali ke Data Transaksi
								</a>
							</div>

						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Modal for Image Preview -->
	<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="imageModalLabel">Preview Bukti Pembayaran</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<img id="modalImage" src="" class="img-fluid" alt="Bukti Pembayaran">
				</div>
			</div>
		</div>
	</div>

</div>

<script>
	function showImageModal(imageSrc) {
		document.getElementById('modalImage').src = imageSrc;
		$('#imageModal').modal('show');
	}

	function updateStatusRental() {
		var statusPengembalian = document.getElementById('status_pengembalian').value;
		var statusRental = document.getElementById('status_rental');
		var warningMessage = document.getElementById('warningMessage');
		var warningText = document.getElementById('warningText');

		// Auto-update status rental based on status pengembalian
		if (statusPengembalian === "Kembali") {
			statusRental.value = "Selesai";
			warningMessage.style.display = 'block';
			warningMessage.className = 'alert alert-success';
			warningText.innerHTML = '<strong>Rekomendasi:</strong> Barang sudah dikembalikan, status transaksi otomatis diset ke "Selesai"';
		} else if (statusPengembalian === "Belum Kembali") {
			statusRental.value = "Pending";
			warningMessage.style.display = 'block';
			warningMessage.className = 'alert alert-info';
			warningText.innerHTML = '<strong>Info:</strong> Barang belum dikembalikan, status transaksi diset ke "Pending"';
		} else {
			warningMessage.style.display = 'none';
			statusRental.value = "";
		}
	}

	// Form validation before submit
	document.addEventListener('DOMContentLoaded', function() {
		var form = document.getElementById('returnForm');
		if (form) {
			form.addEventListener('submit', function(e) {
				var statusPengembalian = document.getElementById('status_pengembalian').value;
				var statusRental = document.getElementById('status_rental').value;
				var tanggalPengembalian = document.getElementById('tanggal_pengembalian').value;

				if (!statusPengembalian || !statusRental || !tanggalPengembalian) {
					e.preventDefault();
					alert('Mohon lengkapi semua field yang wajib diisi!');
					return false;
				}

				// Validation logic
				if (statusPengembalian === "Kembali" && statusRental !== "Selesai") {
					if (!confirm('Barang sudah dikembalikan tapi status transaksi bukan "Selesai". Apakah Anda yakin?')) {
						e.preventDefault();
						return false;
					}
				}

				if (statusPengembalian === "Belum Kembali" && statusRental === "Selesai") {
					e.preventDefault();
					alert('Tidak bisa menyelesaikan transaksi jika barang belum dikembalikan!');
					return false;
				}

				// Confirm submission with payment info
				var confirmMessage = 'Konfirmasi pengembalian:\n\n';
				confirmMessage += '• Status Pengembalian: ' + statusPengembalian + '\n';
				confirmMessage += '• Status Transaksi: ' + statusRental + '\n';
				confirmMessage += '• Tanggal Pengembalian: ' + tanggalPengembalian + '\n\n';

				// Add payment scenario info
				if (statusRental === "Selesai" && statusPengembalian === "Kembali") {
					confirmMessage += 'CATATAN: Jika ada bukti pembayaran, pembayaran akan otomatis dikonfirmasi.\n';
					confirmMessage += 'Jika belum ada bukti, customer perlu upload bukti pembayaran.\n\n';
				}

				confirmMessage += 'Apakah data sudah benar?';

				if (!confirm(confirmMessage)) {
					e.preventDefault();
					return false;
				}
			});
		}
	});
</script>