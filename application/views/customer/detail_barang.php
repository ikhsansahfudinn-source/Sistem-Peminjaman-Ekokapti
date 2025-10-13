<style>
    body {
        padding-top: 80px;
        padding-bottom: 80px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    .item-container {
        flex: 1 0 auto;
        margin: 2rem auto;
        max-width: 95%;
    }
    .item-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background: #fff;
        transition: transform 0.3s ease;
    }
    .item-card:hover {
        transform: translateY(-5px);
    }
    .item-image {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }
    .item-table {
        width: 100%;
        margin: 0 auto;
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    .item-table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 12px;
        text-align: left;
        width: 30%;
    }
    .item-table td {
        background-color: #ffffff;
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
    }
    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .btn-success:hover {
        background-color: #218838;
    }
    .btn-danger {
        background-color: #dc3545;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        opacity: 0.7;
    }
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }
    .col-md-5, .col-md-7 {
        position: relative;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
    }
    .col-md-5 {
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }
    .col-md-7 {
        flex: 0 0 58.333333%;
        max-width: 58.333333%;
    }
    @media (max-width: 767.98px) {
        .col-md-5, .col-md-7 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .item-image {
            margin-bottom: 1rem;
        }
        .item-table th, .item-table td {
            padding: 8px;
        }
    }
</style>

<div class="container item-container">
    <div class="card item-card">
        <div class="card-body">
            <?php foreach ($detail as $dt) : ?>
                <div class="row">
                    <!-- Image Section -->
                    <div class="col-md-5">
                        <img class="item-image" src="<?php echo base_url('assets/upload/' . $dt->gambar) ?>" alt="<?php echo $dt->nama_barang ?>">
                    </div>

                    <!-- Details Table Section -->
                    <div class="col-md-7">
                        <table class="table item-table">
                            <tr>
                                <th>Nama Barang</th>
                                <td><?php echo $dt->nama_barang ?></td>
                            </tr>
                            <tr>
                                <th>Penanggung Jawab</th>
                                <td><?php echo $dt->penanggung_jawab ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?php echo $rental[0]->alamat ?></td>
                            </tr>

                            <?php if ($dt->status == '1'): ?>
                                <tr>
                                    <th>Jumlah</th>
                                    <td><?php echo $dt->jumlah ?></td>
                                </tr>
                            <?php endif; ?>

                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php
                                    if ($dt->status == '1') {
                                        echo "Tersedia";
                                    } else {
                                        echo "Tidak Tersedia/Sedang disewa";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <?php
                                    if ($dt->status != '1') {
                                        echo "<button class='btn btn-danger disabled'>Barang Tidak Tersedia</button>";
                                    } elseif ($dt->jumlah == 0) {
                                        echo "<button class='btn btn-danger disabled'>Habis</button>";
                                    } else {
                                        echo anchor('customer/rental/tambah_rental/' . $dt->id_barang, '<button class="btn btn-success">Sewa</button>');
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
