<?php
class Laporan extends CI_Controller
{
    public function index()
    {
        $this->rental_model->admin_login();

        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        $filter_user = $this->input->post('user');
        $filter_status = $this->input->post('status');
        $filter_pembayaran = $this->input->post('pembayaran');
        $filter_barang = $this->input->post('barang');

        $this->_rules();

        // Ambil data customers dan barang untuk dropdown filter
        $data['customers'] = $this->db->get('customer')->result();
        $data['barang'] = $this->db->get('barang')->result();

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/sidebar');
            $this->load->view('admin/filter_laporan', $data);
            $this->load->view('templates_admin/footer');
        } else {
            // Query dasar dengan pengurutan
            $query = "SELECT tr.*, br.nama_barang, cs.nama,
                      DATEDIFF(tr.tanggal_kembali, tr.tanggal_rental) + 1 AS lama_peminjaman
                      FROM transaksi tr
                      JOIN barang br ON tr.id_barang = br.id_barang
                      JOIN customer cs ON tr.id_customer = cs.id_customer
                      WHERE date(tanggal_rental) BETWEEN '$dari' AND '$sampai'";

            // Tambahkan filter berdasarkan user
            if (!empty($filter_user)) {
                $query .= " AND tr.id_customer = " . $this->db->escape($filter_user);
            }

            // Tambahkan filter berdasarkan barang
            if (!empty($filter_barang)) {
                $query .= " AND tr.id_barang = " . $this->db->escape($filter_barang);
            }

            // Tambahkan filter status rental
            if ($filter_status == 'dipinjam') {
                $query .= " AND tr.status_rental = 'Pending'";
            } elseif ($filter_status == 'belum_kembali') {
                $query .= " AND tr.status_pengembalian = 'Belum Kembali'";
            } elseif ($filter_status == 'selesai') {
                $query .= " AND tr.status_rental = 'Selesai'";
            }

            // Tambahkan filter status pembayaran
            if ($filter_pembayaran == 'lunas') {
                $query .= " AND tr.status_pembayaran = '1'";
            } elseif ($filter_pembayaran == 'belum_lunas') {
                $query .= " AND (tr.status_pembayaran = '0' OR tr.status_pembayaran IS NULL)";
            }

            // Pengurutan untuk menampilkan transaksi yang belum selesai di atas
            $query .= " ORDER BY CASE 
                        WHEN tr.status_rental = 'Pending' THEN 1
                        WHEN tr.status_pengembalian = 'Belum Kembali' THEN 2
                        ELSE 3
                      END, tr.tanggal_rental DESC";

            $data['transaksi'] = $this->db->query($query)->result();
            $data['filter'] = array(
                'dari' => $dari,
                'sampai' => $sampai,
                'user' => $filter_user,
                'status' => $filter_status,
                'pembayaran' => $filter_pembayaran,
                'barang' => $filter_barang
            );

            $this->load->view('templates_admin/header');
            $this->load->view('templates_admin/sidebar');
            $this->load->view('admin/tampilkan_laporan', $data);
            $this->load->view('templates_admin/footer');
        }
    }

    public function print_laporan()
    {
        $this->rental_model->admin_login();
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $filter_user = $this->input->get('user');
        $filter_status = $this->input->get('status');
        $filter_pembayaran = $this->input->get('pembayaran');
        $filter_barang = $this->input->get('barang');

        // Query untuk laporan cetak
        $query = "SELECT tr.*, br.nama_barang, cs.nama,
                  DATEDIFF(tr.tanggal_kembali, tr.tanggal_rental) + 1 AS lama_peminjaman
                  FROM transaksi tr
                  JOIN barang br ON tr.id_barang = br.id_barang
                  JOIN customer cs ON tr.id_customer = cs.id_customer
                  WHERE date(tanggal_rental) BETWEEN '$dari' AND '$sampai'";

        if (!empty($filter_user)) {
            $query .= " AND tr.id_customer = " . $this->db->escape($filter_user);
        }

        if (!empty($filter_barang)) {
            $query .= " AND tr.id_barang = " . $this->db->escape($filter_barang);
        }

        if ($filter_status == 'dipinjam') {
            $query .= " AND tr.status_rental = 'Pending'";
        } elseif ($filter_status == 'belum_kembali') {
            $query .= " AND tr.status_pengembalian = 'Belum Kembali'";
        } elseif ($filter_status == 'selesai') {
            $query .= " AND tr.status_rental = 'Selesai'";
        }

        if ($filter_pembayaran == 'lunas') {
            $query .= " AND tr.status_pembayaran = '1'";
        } elseif ($filter_pembayaran == 'belum_lunas') {
            $query .= " AND (tr.status_pembayaran = '0' OR tr.status_pembayaran IS NULL)";
        }

        $query .= " ORDER BY CASE 
                        WHEN tr.status_rental = 'Pending' THEN 1
                        WHEN tr.status_pengembalian = 'Belum Kembali' THEN 2
                        ELSE 3
                      END, tr.tanggal_rental DESC";

        $data['transaksi'] = $this->db->query($query)->result();
        $data['title'] = "Laporan Transaksi";

        $this->load->view('admin/print_laporan', $data);
    }

    public function _rules()
    {
        $this->form_validation->set_rules('dari', 'Dari Tanggal', 'required');
        $this->form_validation->set_rules('sampai', 'Sampai Tanggal', 'required');
    }
}
?>