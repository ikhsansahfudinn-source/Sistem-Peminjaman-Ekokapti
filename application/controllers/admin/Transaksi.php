<?php


class Transaksi extends CI_Controller
{

	public function index()
	{
		$this->rental_model->admin_login();

		// Load pagination library
		$this->load->library('pagination');

		// Get filters from GET parameters
		$filter_user = $this->input->get('user');
		$status_rental = $this->input->get('status_rental');
		$tanggal_mulai = $this->input->get('tanggal_mulai');
		$tanggal_selesai = $this->input->get('tanggal_selesai');

		$data['customers'] = $this->db->get('customer')->result();
		// Start building the SQL query with filters
		$this->db->select("tr.id_pinjam, tr.tanggal_rental, tr.tanggal_kembali,
                  tr.tanggal_pengembalian, tr.status_rental, tr.status_pengembalian,
                  tr.status_pembayaran, tr.bukti_pembayaran, tr.jumlah, tr.total_denda,
                  br.nama_barang, br.harga, br.denda, br.status,
                  cs.nama");
		$this->db->from('transaksi tr');
		$this->db->join('barang br', 'tr.id_barang = br.id_barang');
		$this->db->join('customer cs', 'tr.id_customer = cs.id_customer');

		// Apply filters if set
		if (!empty($filter_user)) {
			$this->db->where('tr.id_customer', $filter_user);
		}
		if ($status_rental && $status_rental != 'semua') {
			if ($status_rental == 'menunggu_konfirmasi') {
				// Special filter for payments that need confirmation
				$this->db->where('tr.bukti_pembayaran IS NOT NULL');
				$this->db->where('tr.bukti_pembayaran !=', '');
				$this->db->where('tr.status_pembayaran', '0');
			} else if ($status_rental == 'Pending') {
				// Show only Pending rentals that haven't been paid
				$this->db->where('tr.status_rental', 'Pending');
				$this->db->where('(tr.bukti_pembayaran IS NULL OR tr.bukti_pembayaran = "")', NULL, FALSE);
			} else {
				// Normal status filtering
				$this->db->where('tr.status_rental', $status_rental);
			}
		}

		if ($tanggal_mulai) {
			$this->db->where('tr.tanggal_rental >=', $tanggal_mulai);
		}

		if ($tanggal_selesai) {
			$this->db->where('tr.tanggal_rental <=', $tanggal_selesai);
		}

		// Count total records for pagination
		$total_rows = $this->db->count_all_results('', false);

		// Configure pagination
		$config['base_url'] = base_url('admin/transaksi/index');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = 10;
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
		$config['reuse_query_string'] = TRUE;

		// Bootstrap 4 pagination styles
		$config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link');

		$this->pagination->initialize($config);

		// Get current page
		$page = ($this->input->get('page')) ? $this->input->get('page') : 1;
		$offset = ($page - 1) * $config['per_page'];

		// Order by id_pinjam and limit results
		$this->db->order_by("CASE 
                                WHEN tr.status_rental = 'Pending' THEN 1
                                WHEN tr.status_pengembalian = 'Belum Kembali' THEN 2
                                ELSE 3
                             END, tr.tanggal_rental DESC");
        $this->db->limit($config['per_page'], $offset);

		// Execute query
		$data['transaksi'] = $this->db->get()->result();

		// Pass filters to view
		$data['filter_user'] = $filter_user;
		$data['status_rental'] = $status_rental;
		$data['tanggal_mulai'] = $tanggal_mulai;
		$data['tanggal_selesai'] = $tanggal_selesai;

		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/Data_transaksi', $data);
		$this->load->view('templates_admin/footer');
	}


	public function pembayaran($id)
	{
		$this->rental_model->admin_login();
		$where = array('id_pinjam' => $id);
		$data['pembayaran'] = $this->db->query("SELECT tr.*, br.nama_barang, br.harga, br.denda, cs.nama 
													FROM transaksi tr 
													JOIN barang br ON tr.id_barang = br.id_barang 
													JOIN customer cs ON tr.id_customer = cs.id_customer 
													WHERE tr.id_pinjam='$id'")->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/konfirmasi_pembayaran', $data);
		$this->load->view('templates_admin/footer');
	}

	public function cek_pembayaran()
	{
		$this->rental_model->admin_login();
		$id 				= $this->input->post('id_pinjam');
		$status_pembayaran	= $this->input->post('status_pembayaran');

		$data = array(
			'status_pembayaran'	=> $status_pembayaran
		);

		$where = array(
			'id_pinjam'	=> $id
		);

		$this->rental_model->update_data('transaksi', $data, $where);

		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				  Pembayaran telah dikonfirmasi. Silakan konfirmasi pengembalian barang.
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>');
		redirect('admin/transaksi/pembayaran/' . $id);
	}


	public function download_pembayaran($id)
	{
		$this->rental_model->admin_login();
		$this->load->helper('download');
		$filePembayaran = $this->rental_model->downloadPembayaran($id);
		$file = 'assets/upload/' . $filePembayaran['bukti_pembayaran'];
		force_download($file, NULL);
	}

	public function transaksi_selesai($id)
	{
		$this->rental_model->admin_login();
		$where = array('id_pinjam' => $id);
		$data['transaksi'] = $this->db->query("SELECT * FROM transaksi WHERE id_pinjam='$id'")->result();

		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/transaksi_selesai', $data);
		$this->load->view('templates_admin/footer');
	}

	public function transaksi_selesai_aksi()
	{
		$this->rental_model->admin_login();

		$id = $this->input->post('id_pinjam');
		$tanggal_pengembalian = $this->input->post('tanggal_pengembalian');
		$status_rental = $this->input->post('status_rental');
		$status_pengembalian = $this->input->post('status_pengembalian');

		// Get data from database
		$transaksi = $this->db->query("SELECT tr.*, br.harga, br.denda, tr.jumlah
										FROM transaksi tr
										JOIN barang br ON tr.id_barang = br.id_barang
										WHERE tr.id_pinjam = '$id'")->row();

		// Get rental duration in days
		$rental_days = ceil((strtotime($transaksi->tanggal_kembali) - strtotime($transaksi->tanggal_rental)) / (60 * 60 * 24) + 1);

		// Calculate base rental cost
		$rental_cost = $transaksi->harga * $rental_days * $transaksi->jumlah;

		// Calculate late fees if applicable
		if (strtotime($tanggal_pengembalian) > strtotime($transaksi->tanggal_kembali)) {
			$late_days = ceil((strtotime($tanggal_pengembalian) - strtotime($transaksi->tanggal_kembali)) / (60 * 60 * 24));
			$late_fees = $late_days * $transaksi->denda * $transaksi->jumlah;
		} else {
			$late_fees = 0;
		}

		// Total cost including rental and late fees
		$total_denda = $rental_cost + $late_fees;

		// Prepare data for update - keep existing payment status
		$data = array(
			'tanggal_pengembalian' => $tanggal_pengembalian,
			'status_rental' => $status_rental,
			'status_pengembalian' => $status_pengembalian,
			'total_denda' => $total_denda
		);

		// Only update payment status if not already confirmed
		if ($transaksi->status_pembayaran != '1') {
			// If transaction is completed and item returned, auto-confirm payment if proof exists
			if ($status_rental == 'Selesai' && $status_pengembalian == 'Kembali' && !empty($transaksi->bukti_pembayaran)) {
				$data['status_pembayaran'] = '1';
			}
		}

		$where = array('id_pinjam' => $id);
		$this->rental_model->update_data('transaksi', $data, $where);

		// Handle item status and stock based on return status
		if ($status_pengembalian == 'Kembali' && $status_rental == 'Selesai') {
			$id_barang = $this->input->post('id_barang');
			$data2	= array('status'   => '1');
			$where2 = array('id_barang'  => $id_barang);
			$this->rental_model->update_data('barang', $data2, $where2);

			// Get current stock
			$barang = $this->db->get_where('barang', array('id_barang' => $id_barang))->row();
			$current_stock = $barang->jumlah;

			// Return the borrowed quantity back to stock
			$new_stock = $current_stock + $transaksi->jumlah;
			$this->db->where('id_barang', $id_barang);
			$this->db->update('barang', array('jumlah' => $new_stock));

			$message = 'Konfirmasi pengembalian berhasil. Barang sudah dikembalikan dan stok telah diperbarui.';

			// Add payment info to message
			if ($transaksi->status_pembayaran == '1') {
				$message .= ' Pembayaran sudah dikonfirmasi sebelumnya.';
			} else if (!empty($transaksi->bukti_pembayaran)) {
				$message .= ' Pembayaran otomatis dikonfirmasi karena transaksi selesai.';
			} else {
				$message .= ' Pembayaran belum ada bukti, silakan minta customer upload bukti pembayaran.';
			}
		} else if ($status_pengembalian == 'Belum Kembali') {
			$message = 'Status pengembalian diperbarui. Barang masih dalam status belum dikembalikan.';
		} else {
			$message = 'Status transaksi berhasil diperbarui.';
		}

		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				  ' . $message . '
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>');

		redirect('admin/transaksi');
	}

	public function batal_transaksi($id)
	{
		$this->rental_model->admin_login();
		$where = array('id_pinjam' => $id);
		$data  = $this->rental_model->get_where($where, 'transaksi')->row();

		$where2 = array('id_barang' => $data->id_barang);
		$data2	= array('status'   => '1');

		$this->rental_model->update_data('barang', $data2, $where2);
		$this->rental_model->delete_data($where, 'transaksi');

		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				  Transaksi Berhasil dibatalkan
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>');
		redirect('admin/transaksi');
	}
}
