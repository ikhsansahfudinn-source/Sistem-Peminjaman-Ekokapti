<div style="max-width: 800px; font-family: 'Arial', sans-serif; margin: 20px auto; border: 1px solid #e0e0e0; padding: 30px; border-radius: 8px; position: relative;">
    <!-- Header dengan Logo -->
    <div style="display: flex; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #2c3e50; padding-bottom: 20px;">
        <img src="<?php echo base_url('assets/assets_shop/img/logo1.png" alt="JSOFT') ?>"
            style="max-height: 80px; margin-right: 25px;"
            alt="Logo Karang Taruna">
        <div>
            <h1 style="color: #2c3e50; margin: 0; font-size: 24px; letter-spacing: 1px;">Karang Taruna Muda Mudi Ekokapti </h1>
            <p style="color: #7f8c8d; margin: 5px 0 0 0; font-size: 14px;">
                Ngrandu, Kaliagung, Sentolo, Kulon Progo, DIY <br>
                Telp:_________________ | Email:_________________<br>
            </p>
        </div>
    </div>

    <!-- Body Invoice -->
    <div style="margin-bottom: 30px;">
        <div style="text-align: center; margin-bottom: 25px;">
            <h2 style="color: #2c3e50; margin: 0 0 10px 0; text-transform: uppercase;">Invoice Pembayaran</h2>
            <p style="color: #7f8c8d; margin: 0; font-size: 0.9em;">
                No. Invoice: <?php echo $tr->id_rental ?? ''; ?><br>
                Tanggal Cetak: <?php echo date('d/m/Y H:i'); ?>
            </p>
        </div>

        <!-- Detail Transaksi -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
            <?php foreach ($transaksi as $tr) : ?>
                <tr>
                    <td style="padding: 8px 0; width: 30%; font-weight: bold;">Nama Customer</td>
                    <td style="padding: 8px 0; width: 5%;">:</td>
                    <td style="padding: 8px 0;"><?php echo $tr->nama ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Nama Barang</td>
                    <td style="padding: 8px 0;">:</td>
                    <td style="padding: 8px 0;"><?php echo $tr->nama_barang ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Tanggal Sewa</td>
                    <td style="padding: 8px 0;">:</td>
                    <td style="padding: 8px 0;"><?php echo date('d/m/Y', strtotime($tr->tanggal_rental)); ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Tanggal Kembali</td>
                    <td style="padding: 8px 0;">:</td>
                    <td style="padding: 8px 0;"><?php echo date('d/m/Y', strtotime($tr->tanggal_kembali)); ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Biaya Sewa/Hari</td>
                    <td style="padding: 8px 0;">:</td>
                    <td style="padding: 8px 0;">Rp. <?php echo number_format($tr->harga, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Jumlah Barang</td>
                    <td style="padding: 8px 0;">:</td>
                    <td style="padding: 8px 0;"><?php echo $tr->jumlah; ?></td>
                </tr>
                <tr>
                    <?php
                    $x = strtotime($tr->tanggal_kembali);
                    $y = strtotime($tr->tanggal_rental);
                    $jmlHari = abs(($x - $y) / (60 * 60 * 24) + 1);
                    ?>
                    <td style="padding: 8px 0; font-weight: bold;">Jumlah Hari Sewa</td>
                    <td style="padding: 8px 0;">:</td>
                    <td style="padding: 8px 0;"><?php echo $jmlHari; ?> Hari</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Status Pembayaran</td>
                    <td style="padding: 8px 0;">:</td>
                    <td style="padding: 8px 0;">
                        <?php echo $tr->status_pembayaran == '0'
                            ? "<span style='color: #e74c3c; font-weight: bold;'>BELUM LUNAS</span>"
                            : "<span style='color: #27ae60; font-weight: bold;'>LUNAS</span>"; ?>
                    </td>
                </tr>
                <tr style="background-color: #f8f9fa;">
                    <td style="padding: 12px 0; font-weight: bold;">TOTAL PEMBAYARAN</td>
                    <td style="padding: 12px 0;">:</td>
                    <td style="padding: 12px 0; font-weight: bold; color: #c0392b;">
                        Rp. <?php
                            if ($tr->status_pengembalian == 'Kembali' && $tr->status_rental == 'Selesai') {
                                echo number_format($tr->total_denda, 0, ',', '.');
                            } else {
                                echo number_format($tr->harga * $jmlHari, 0, ',', '.');
                            }
                            ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div style="margin: 25px 0; border-left: 4px solid #2c3e50; padding-left: 15px;">
            <h4 style="color: #2c3e50; margin: 0 0 10px 0;">Informasi Penyewaan</h4>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 6px 0; width: 40%; font-weight: bold;">Penanggung Jawab</td>
                    <td style="padding: 6px 0;">:</td>
                    <td style="padding: 6px 0;"><?php echo $rental[0]->penanggung_jawab ?></td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; font-weight: bold;">Alamat</td>
                    <td style="padding: 6px 0;">:</td>
                    <td style="padding: 6px 0;"><?php echo $rental[0]->alamat ?></td>
                </tr>
            </table>

            <!-- Tanda Tangan -->
            <div style="margin-top: 50px; text-align: right;">
                <div style="display: inline-block; text-align: center;">
                    <p style="margin: 0 0 60px 0; color: #7f8c8d;">Tanda Tangan Admin</p>
                    <div style="border-top: 1px solid #2c3e50; width: 200px; margin-bottom: 5px;"></div>
                    <p style="margin: 0; font-weight: bold; color: #2c3e50;">
                        <span style="font-weight: normal; font-size: 0.9em;"></span>
                    </p>
                    <?php echo $rental[0]->penanggung_jawab ?><br>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div style="border-top: 2px solid #2c3e50; padding-top: 20px; text-align: center; color: #7f8c8d; font-size: 12px;">
            <p style="margin: 5px 0;">
                &copy; <?php echo date('Y') ?> |
                Wahananing Krido Taruna Wiyating Tomo
            </p>
        </div>

        <!-- Tombol Cetak -->
        <div style="text-align: center; margin-top: 30px;">
            <button onclick="window.print()"
                style="background-color: #2c3e50; 
                       color: white;
                       padding: 12px 40px;
                       border: none;
                       border-radius: 25px;
                       cursor: pointer;
                       font-size: 14px;
                       transition: all 0.3s;
                       box-shadow: 0 3px 6px rgba(0,0,0,0.1);">
                🖨 Cetak Invoice
            </button>
        </div>
    </div>