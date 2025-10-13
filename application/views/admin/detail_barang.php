<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Barang</h1>
        </div>

        <?php foreach ( $detail as $dt ) : ?>

            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-5">
                            <img width="400" src="<?php echo base_url() . 'assets/upload/' . $dt->gambar ?>">

                        </div>

                        <div class="col-md-7">
                            
                            <table class="table">
                                <tr>
                                    <td>Type Barang</td>
                                    <td>
                                        
                                        <?php 
                                            foreach($type as $tp){
                                                if($dt->kode_type == $tp->kode_type){
                                                    echo $tp->nama_type;
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Nama Barang</td>
                                    <td><?php echo $dt->nama_barang ?></td>
                                </tr>

                                <tr>
                                    <td>Jumlah</td>
                                    <td><?php echo $dt->jumlah ?></td>
                                </tr>

                                <tr>
                                    <td>Harga</td>
                                    <td>Rp. <?php echo number_format($dt->harga,0,',','.') ?></td>
                                </tr>

                                <tr>
                                    <td>Denda</td>
                                    <td>Rp. <?php echo number_format($dt->denda,0,',','.')?></td>
                                </tr>

                                <tr>
                                    <td>Penanggung Jawab</td>
                                    <td><?php echo $dt->penanggung_jawab?></td>
                                </tr>

                                <tr>
                                    <td>Status</td>
                                    <td>
                                        <?php 
                                            if($dt->status == "0"){
                                                echo "<span class='badge badge-danger'> Tidak Tersedia </span>";
                                            }else{
                                                echo "<span class='badge badge-primary'>Tersedia </span>";
                                            }
                                        ?>    
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pengantaran Sampai Lokasi</td>
                                    <td>
                                        <?php 
                                            if($dt->pengantaran == "0"){
                                                echo "<span class='badge badge-danger'> Tidak Tersedia </span>";
                                            }else{
                                                echo "<span class='badge badge-primary'>Tersedia </span>";
                                            }
                                        ?>    
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ambil Ditempat</td>
                                    <td>
                                        <?php 
                                            if($dt->pengambilan == "0"){
                                                echo "<span class='badge badge-danger'> Tidak Tersedia </span>";
                                            }else{
                                                echo "<span class='badge badge-primary'>Tersedia </span>";
                                            }
                                        ?>    
                                    </td>
                                </tr>
                            </table>

                            <a class="btn btn-sm btn-danger ml-4" href="<?php echo base_url('admin/data_barang') ?>">Kembali</a>
                            <a class="btn btn-sm btn-primary" href="<?php echo base_url('admin/data_barang/update_barang/') . $dt->id_barang ?>">Update</a>
                        </div>

                    </div>
                </div>
            </div>

        <?php endforeach ?>

    </section>
</div>