<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Tambah Data Barang</h1>
        </div>

        <div class="card">
        	<div class="card-body">
        		<form method="POST" action="<?php echo base_url('rental/data_barang/tambah_barang_aksi') ?>" enctype="multipart/form-data">
        		<div class="row">
        			<div class="col-md-6">
        				<div class="form-group">
                            <input type="hidden" name="penanggung_jawab" value="<?php echo $this->session->userdata('penanggung_jawab') ?>">
        					<label>Type </label>
        					<select name="kode_type" class="form-control">
        						<option value="">--Pilih Type--</option>

        						<?php foreach ($type as $tp) :?>
        							<option value="<?php echo $tp->kode_type?>"><?php echo $tp->nama_type?></option>
        						<?php endforeach ?>
        					</select>
        					<?php echo form_error('kode_type','<div class="text-small text-danger">','</div>') ?>
        				</div>

        				<div class="form-group">
        					<label>Nama Barang</label>
        					<input type="text" name="nama_barang" class="form-control">
        					<?php echo form_error('nama_barang','<div class="text-small text-danger">','</div>') ?>
        				</div>

        				<div class="form-group">
        					<label>Jumlah</label>
        					<input type="text" name="jumlah" class="form-control">
        					<?php echo form_error('jumlah','<div class="text-small text-danger">','</div>') ?>
        				</div>

                        <div class="form-group">
                            <label>Pengantaran Sampai Lokasi</label>
                            <select name="pengantaran" class="form-control">
                                <option value="1">Tersedia</option>
                                <option value="0">Tidak Tersedia</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Ambil Ditempat</label>
                            <select name="pengambilan" class="form-control">
                                <option value="1">Tersedia</option>
                                <option value="0">Tidak Tersedia</option>
                            </select>
                        </div>

                        
        			</div>
        			<div class="col-md-6">

                        <div class="form-group">
                            <label>Harga Sewa/Hari</label>
                            <input type="number" name="harga" class="form-control">
                            <?php echo form_error('harga','<div class="text-small text-danger">','</div>') ?>
                        </div>

                        <div class="form-group">
                            <label>Denda</label>
                            <input type="number" name="denda" class="form-control">
                            <?php echo form_error('denda','<div class="text-small text-danger">','</div>') ?>
                        </div>


        				<div class="form-group">
        					<label>Status</label>
        					<select name="status" class="form-control">
        						<option value="">--Pilih Status--</option>
        						<option value="1">Tersedia</option>
        						<option value="0">Tidak Tersedia</option>
        					</select>
        					<?php echo form_error('status','<div class="text-small text-danger">','</div>') ?>
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
        	</div>
        </div>
    </section>
</div> 