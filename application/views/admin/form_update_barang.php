<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Update Data Barang</h1>
        </div>

        <div class="card">
        	<div class="card-body">

        		<?php foreach ($barang as $mb) : ?>
        		<form method="POST" action="<?php echo base_url('admin/data_barang/update_barang_aksi') ?>" enctype="multipart/form-data">
        		<div class="row">
        			<div class="col-md-6">
        				<div class="form-group">
        					<label>Type Barang</label>
        					<input type="hidden" name="id_barang" value="<?php echo $mb->id_barang ?>">
        					<select name="kode_type" class="form-control">
        						<option value="<?php echo $mb->kode_type ?>"><?php echo $mb->kode_type ?></option>

        						<?php foreach ($type as $tp) :?>
        							<option value="<?php echo $tp->kode_type?>"><?php echo $tp->nama_type?></option>
        						<?php endforeach ?>
        					</select>
        					<?php echo form_error('kode_type','<div class="text-small text-danger">','</div>') ?>
        				</div>

        				<div class="form-group">
        					<label>Nama Barang</label>
        					<input type="text" name="nama_barang" class="form-control" value="<?php echo $mb->nama_barang ?>">
        					<?php echo form_error('nama_barang','<div class="text-small text-danger">','</div>') ?>
        				</div>

        				<div class="form-group">
        					<label>Jumlah</label>
        					<input type="text" name="jumlah" class="form-control" value="<?php echo $mb->jumlah ?>">
        					<?php echo form_error('jumlah','<div class="text-small text-danger">','</div>') ?>
        				</div>

                        <div class="form-group">
                            <label>Pengantaran Sampai Lokasi</label>
                            <select name="pengantaran" class="form-control">
                                <option <?php if($mb->pengantaran == 1){echo "selected='selected'";}
                                    echo $mb->pengantaran;?> value="1">Tersedia</option>

                                <option <?php if($mb->pengantaran == 0){echo "selected='selected'";}
                                    echo $mb->pengantaran;?> value="0">Tidak Tersedia</option>
                            </select>
                            <?php echo form_error('pengantaran','<div class="text-small text-danger">','</div>') ?>
                        </div>

                        <div class="form-group">
                            <label>Ambil Ditempat</label>
                            <select name="pengambilan" class="form-control">
                                <option <?php if($mb->pengambilan == 1){echo "selected='selected'";}
                                    echo $mb->pengambilan;?> value="1">Tersedia</option>

                                <option <?php if($mb->pengambilan == 0){echo "selected='selected'";}
                                    echo $mb->pengambilan;?> value="0">Tidak Tersedia</option>
                            </select>
                            <?php echo form_error('pengambilan','<div class="text-small text-danger">','</div>') ?>
                        </div>



        			</div>
        			<div class="col-md-6">

                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" name="harga" class="form-control" value="<?php echo $mb->harga ?>">
                            <?php echo form_error('harga','<div class="text-small text-danger">','</div>') ?>
                        </div>

                        <div class="form-group">
                            <label>denda</label>
                            <input type="text" name="denda" class="form-control" value="<?php echo $mb->denda ?>">
                            <?php echo form_error('denda','<div class="text-small text-danger">','</div>') ?>
                        </div>

        				<div class="form-group">
        					<label>Status</label>
        					<select name="status" class="form-control">
        						<option <?php if($mb->status == 1){echo "selected='selected'";}
        							echo $mb->status;?> value="1">Tersedia</option>

        						<option <?php if($mb->status == 0){echo "selected='selected'";}
        							echo $mb->status;?> value="0">Tidak Tersedia</option>
        					</select>
        					<?php echo form_error('status','<div class="text-small text-danger">','</div>') ?>
        				</div>

						<div class="form-group">
                            <label>Penanggung Jawab</label>
                            <select name="penanggung_jawab" class="form-control">
                                <option value="<?php echo $mb->penanggung_jawab?>"><?php echo $mb->penanggung_jawab?></option>
                                <?php foreach ($penanggung_jawab as $nr) :?>
                                    <?php if($mb->penanggung_jawab != $nr->penanggung_jawab) { ?>
                                        <option value="<?php echo $nr->penanggung_jawab?>"><?php echo $nr->penanggung_jawab?></option>
                                    <?php }else{?>
                                    <?php } ?>
                                <?php endforeach ?>

                            </select>
                            <?php echo form_error('penanggung_jawab','<div class="text-small text-danger">','</div>') ?>
                        </div>

        				<div class="form-group">
        					<label>Gambar</label>
        					<input type="file" name="gambar" class="form-control">
        				</div>

        				<button type="submit" class="btn btn-primary">Simpan</button>
        				<button type="reset" class="btn btn-danger">Reset</button>
        			</div>
        		</div>
        		</form>
        	<?php endforeach; ?>
        	</div>
        </div>
    </section>
</div> 