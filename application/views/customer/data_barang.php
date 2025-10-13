<!--== Page Title Area Start ==-->
<section id="page-title-area" class="section-padding overlay">
  <div class="container">
    <div class="row">
      <!-- Page Title Start -->
      <div class="col-lg-12">
        <div class="section-title text-center">
          <h2>Pilihan Barang</h2>
          <span class="title-line"><i class="fa fa-box"></i></span>
          <p>Pilih barang yang Anda butuhkan</p>
        </div>
      </div>
      <!-- Page Title End -->
    </div>
  </div>
</section>
<!--== Page Title Area End ==-->

<!-- Di data_barang.php -->
<section id="barang-list" class="section-padding">
  <div class="container">
    <div class="row">
      <?php foreach ($barang as $mb) : ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card h-100 barang-card">
            <div class="card-img-top">
              <img src="<?= base_url('assets/upload/' . $mb->gambar) ?>"
                alt="<?= $mb->nama_barang ?>"
                class="img-fluid">
            </div>
            <div class="card-body">
              <h5 class="card-title"><?= $mb->nama_barang ?></h5>
              <div class="badge-container">
                <span class="badge badge-<?= ($mb->status == 1) ? 'success' : 'danger' ?>">
                  <?= ($mb->status == 1) ? 'Tersedia' : 'Habis' ?>
                </span>
                <span class="badge badge-info">
                  Stok: <?= $mb->jumlah ?>
                </span>
              </div>
              <p class="card-text harga">
                Rp <?= number_format($mb->harga, 0, ',', '.') ?>/hari
              </p>
            </div>
            <div class="card-footer">
              <a href="<?= base_url('customer/data_barang/detail_barang/' . $mb->id_barang) ?>"
                class="btn btn-success btn-block">
                Lihat Detail
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>