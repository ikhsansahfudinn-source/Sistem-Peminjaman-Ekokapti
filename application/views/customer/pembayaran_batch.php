<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card" style="margin-top: 110px">
                <div class="card-header alert-success">
                    Invoice Pembayaran Anda
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-responsive">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal Sewa</th>
                            <th>Tanggal Kembali</th>
                            <th>Harga/hari</th>
                            <th>Jumlah Hari</th>
                            <th>Sub Total</th>
                        </tr>
                        
                        <?php 
                        $no = 1;
                        $total_bayar = 0;
                        foreach($transaksi as $tr) : 
                            // Calculate rental days
                            $x = strtotime($tr->tanggal_kembali);
                            $y = strtotime($tr->tanggal_rental);
                            $jmlHari = abs(($x - $y)/(60*60*24) + 1);
                            
                            // Calculate sub total for this item
                            $sub_total = $tr->harga * $jmlHari;
                            $total_bayar += $sub_total;
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $tr->nama_barang ?></td>
                                <td><?php echo (int)$tr->jumlah ?></td>
                                <td><?php echo date('d/m/Y', strtotime($tr->tanggal_rental)); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($tr->tanggal_kembali)); ?></td>
                                <td>Rp. <?php echo number_format($tr->harga,0,',','.') ?></td>
                                <td><?php echo $jmlHari; ?> Hari</td>
                                <td>Rp. <?php echo number_format($sub_total,0,',','.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="bg-success text-white">
                            <th colspan="7" class="text-right">TOTAL PEMBAYARAN</th>
                            <th>Rp. <?php echo number_format($total_bayar,0,',','.') ?></th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="margin-top: 110px">
                <div class="card-header alert alert-primary">
                    Informasi Pembayaran
                </div>
                <div class="card-body">
                    <p class="text-success mb-3"> Silakan Melakukan Pembayaran Melalui Alat di Bawah Ini: </p>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($payment as $pm ) : ?>
                            <li class="list-group-item font-bold"><?php echo $pm->nama_payment . ' ' . $pm->key_payment ?> <?php echo $pm->atas_nama ?></li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <!-- Button trigger modal -->
                    <button style="width: 100%" type="button" class="btn btn-danger btn-sm mt-3" data-toggle="modal" data-target="#exampleModal">
                      Upload Bukti Pembayaran
                    </button>
                </div>
            </div>
        </div>        
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Bukti Pembayaran Anda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo base_url('customer/transaksi/pembayaran_aksi') ?>" enctype="multipart/form-data">
            <?php foreach($selected_ids as $id) : ?>
                <input type="hidden" name="id_pinjam[]" value="<?php echo $id ?>">
            <?php endforeach; ?>
            <div class="form-group">
                <label>Upload Bukti Pembayaran (Gambar/PDF)</label>
                <input type="file" name="bukti_pembayaran" class="form-control">
            </div>
            <div class="modal-footer mx-auto">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Kirim</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div> 