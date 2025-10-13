<?php
	
	class Dashboard extends CI_Controller{

		public function index(){
			$this->rental_model->admin_login();
			$data['total_data'] = $this->rental_model->total_data_admin();
			$data['transaksi'] = $this->db->query("SELECT tr.*, br.nama_barang, cs.nama 
                                          FROM transaksi tr 
                                          JOIN barang br ON tr.id_barang = br.id_barang 
                                          JOIN customer cs ON tr.id_customer = cs.id_customer 
                                          ORDER BY tr.id_pinjam DESC 
                                          LIMIT 5")->result();
			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/sidebar');
			$this->load->view('admin/Dashboard',$data);
			$this->load->view('templates_admin/footer');
		}
	}
?>
