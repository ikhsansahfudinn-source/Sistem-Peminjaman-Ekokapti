<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Barang</h1>
        </div>

        <a href="<?php echo base_url('admin/data_barang/tambah_barang')?>" class="btn btn-primary mb-3">Tambah Data</a>

        <?php echo $this->session->flashdata('pesan') ?>

        <table class="table table-hover table-striper table-bordered">
        	<thead>
                <tr>
            		<th>No</th>
    				<th>Gambar</th>
    				<th>Type</th>
    				<th>Nama Barang</th>
    				<th>Jumlah</th>
    				<th>Status</th>
    				<th>Aksi</th>
                </tr>
        	</thead>
        	<tbody>

        		<?php
        			$no = 1;
        			foreach ($barang as $mb) : ?>
                        <tr>
            				<td><?php echo $no++ ?></td>
            				<td>
                                <img height="50px" src="<?php echo base_url() . 'assets/upload/' . $mb->gambar ?>">            
                            </td>
            				<td><?php echo $mb->kode_type ?></td>
            				<td><?php echo $mb->nama_barang ?></td>
            				<td><?php echo $mb->jumlah ?></td>
            				<td><?php 
            					if($mb->status == "0"){
            						echo "<span class='badge badge-danger'> Tidak Tersedia </span>";
            					} else{
            						echo "<span class='badge badge-primary'> Tersedia </span>";
            					}
            				?></td>
            				<td>
            					<a href="<?php echo base_url('admin/data_barang/detail_barang/').$mb->id_barang ?>" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
            					<a href="<?php echo base_url('admin/data_barang/delete_barang/').$mb->id_barang ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
            					<a href="<?php echo base_url('admin/data_barang/update_barang/').$mb->id_barang ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
            				</td>
                        </tr>
        		<?php endforeach; ?>

        	</tbody>

        </table>
    </section>
</div>