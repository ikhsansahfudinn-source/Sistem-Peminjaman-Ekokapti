!--== SlideshowBg Area Start ==-->
<section id="slideslow-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="slideshowcontent">
                    <div class="display-table">
                        <div class="display-table-cell">
                            <h1>SISTEM PEMINJAMAN</h1>
                            <p>KARANG TARUNA<br>MUDA MUDI EKOKAPTI</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== SlideshowBg Area End ==-->

<!--== Partner Area Start ==-->
<div id="partner-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="partner-content-wrap">
                    <!-- Single Partner Start -->
                    <?php foreach ($rental as $rt) : ?>
                        <div class="single-partner">
                            <div class="display-table">
                                <div class="display-table-cell">
                                    <!-- <img src="assets/img/partner/partner-logo-1.png" alt="JSOFT"> -->
                                    <h5><?php echo $rt->nama_barang ?></h5>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                    <!-- Single Partner End -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--== Partner Area End ==-->

<!--== Fun Fact Area Start ==-->
<section id="funfact-area" class="overlay section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-md-12 m-auto">
                <div class="funfact-content-wrap">
                    <div class="row">
                        <!-- Single FunFact Start -->
                        <div class="col-lg-4 col-md-6">
                            <div class="single-funfact">
                                <div class="funfact-icon">
                                    <i class="fa fa-smile-o"></i>
                                </div>
                                <div class="funfact-content">
                                    <p><span class="counter"><?php echo $total_customer ?></span>+</p>
                                    <h4>PELANGGAN SEWA</h4>
                                </div>
                            </div>
                        </div>
                        <!-- Single FunFact End -->
                        <!-- Single FunFact Start -->
                        <div class="col-lg-4 col-md-6">
                            <div class="single-funfact">
                                <div class="funfact-icon">
                                    <i class="fa fa-car"></i>
                                </div>
                                <div class="funfact-content">
                                    <p><span class="counter"><?php echo $total_barang ?></span>+</p>
                                    <h4>BARANG TERSEDIA</h4>
                                </div>
                            </div>
                        </div>
                        <!-- Single FunFact End -->
                        <!-- Single FunFact Start -->
                        <div class="col-lg-4 col-md-6">
                            <div class="single-funfact">
                                <div class="funfact-icon">
                                    <i class="fa fa-bank"></i>
                                </div>

                                <div class="funfact-content">
                                    <p><span class="counter"><?php echo $total_rental ?></span>+</p>
                                    <h4>TYPE BARANG</h4>
                                </div>
                            </div>
                        </div>
                        <!-- Single FunFact End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== Fun Fact Area End ==-->

<section id="choose-car" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title  text-center">
                    <h2>Pilih Kebutuhan Anda</h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
                    <p>Pilih Segala Kebutuhan Anda, dan Segera Koordinasikan dengan Penanggungjawab Barang</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="choose-ur-cars">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="home2-car-filter">
                                <a href="#" data-filter="*" class="active">all</a>

                                <?php foreach ($type as $tp) : ?>
                                    <a href="#" data-filter=".<?php echo $tp->kode_type ?>"><?php echo $tp->nama_type ?></a>
                                <?php endforeach; ?>
                            </div>

                        </div>

                        <div class="col-lg-9">

                            <div class="row popular-car-gird">

                                <?php foreach ($barang as $mb) : ?>

                                    <div class="col-lg-6 col-md-6 <?php echo $mb->kode_type ?>">
                                        <div class="single-popular-car">
                                            <div class="p-car-thumbnails">
                                                <a class="car-hover" href="<?php echo base_url('assets/upload/' . $mb->gambar) ?>">
                                                    <img style="height: 300px" src="<?php echo base_url('assets/upload/' . $mb->gambar) ?>" alt="<?php echo $mb->nama_barang ?>">
                                                </a>
                                            </div>

                                            <div class="p-car-content">
                                                <h3>
                                                    <a href="<?php echo base_url('customer/data_barang/detail_barang/') . $mb->id_barang ?>"><?php echo $mb->nama_barang ?></a>
                                                    <span class="price"><i class="fa fa-tag"></i>Rp. <?php echo number_format($mb->harga, 0, ',', '.') ?>/Hari</span>
                                                </h3>
                                                <h5><?php echo $mb->penanggung_jawab ?></h5>
                                                <p class="text-dark">Stock tersedia: <span class="badge badge-info" style="font-size: medium; margin-bottom: 10px;"><?php echo $mb->jumlah; ?></span></p>

                                                <div class="p-car-feature">
                                                    <?php if ($mb->pengantaran == '1') { ?>
                                                        <a>Antar Sampai Lokasi</a>
                                                    <?php } else { ?>
                                                    <?php } ?>

                                                    <?php if ($mb->pengambilan == '1') { ?>
                                                        <a>Ambil Ditempat</a>
                                                    <?php } else { ?>
                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                <?php endforeach; ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>