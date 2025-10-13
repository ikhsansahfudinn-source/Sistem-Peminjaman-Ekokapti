<?php
class Laporan extends CI_Controller
{
	public function index()
	{
		$this->rental_model->rental_login();

		$dari = $this->input->post('dari');
		$sampai = $this->input->post('sampai');
		$penanggung_jawab	= $this->session->userdata('penanggung_jawab');
		$filter_user = $this->input->post('user');
		$filter_status = $this->input->post('status');
		$filter_pembayaran = $this->input->post('pembayaran');

		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$data['customers'] = $this->db->get('customer')->result(); // Ambil data user untuk dropdown
			$this->load->view('templates_rental/header');
			$this->load->view('templates_rental/sidebar');
			$this->load->view('rental/filter_laporan', $data);
			$this->load->view('templates_rental/footer');
		} else {
			// Query dasar
			$query = "SELECT tr.*, br.nama_barang, cs.nama 
                    FROM transaksi tr
                    JOIN barang br ON tr.id_barang = br.id_barang
                    JOIN customer cs ON tr.id_customer = cs.id_customer
                    WHERE date(tanggal_rental) BETWEEN '$dari' AND '$sampai'";

			// Tambahkan filter berdasarkan user
			if (!empty($filter_user)) {
				$query .= " AND tr.id_customer = '$filter_user'";
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

			$data['transaksi'] = $this->db->query($query)->result();
			$data['filter'] = array(
				'dari' => $dari,
				'sampai' => $sampai,
				'user' => $filter_user,
				'status' => $filter_status,
				'pembayaran' => $filter_pembayaran
			);

			$this->load->view('templates_rental/header');
			$this->load->view('templates_rental/sidebar');
			$this->load->view('rental/tampilkan_laporan', $data);
			$this->load->view('templates_rental/footer');
		}
	}

	public function print_laporan()
	{
		$this->rental_model->rental_login();
		$dari = $this->input->get('dari');
		$sampai = $this->input->get('sampai');
		$penanggung_jawab	= $this->session->userdata('penanggung_jawab');
		$filter_user = $this->input->get('user');
		$filter_status = $this->input->get('status');
		$filter_pembayaran = $this->input->get('pembayaran');

		// Query yang sama dengan index
		$query = "SELECT tr.*, br.nama_barang, cs.nama 
            FROM transaksi tr
            JOIN barang br ON tr.id_barang = br.id_barang
            JOIN customer cs ON tr.id_customer = cs.id_customer
            WHERE date(tanggal_rental) BETWEEN '$dari' AND '$sampai'";

		if (!empty($filter_user)) {
			$query .= " AND tr.id_customer = '$filter_user'";
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

		$data['transaksi'] = $this->db->query($query)->result();
		$data['title'] = "Laporan Transaksi";

		$this->load->view('rental/print_laporan', $data);
	}

	public function _rules()
	{
		$this->form_validation->set_rules('dari', 'Dari Tanggal', 'required');
		$this->form_validation->set_rules('sampai', 'Sampai Tanggal', 'required');
	}
}
