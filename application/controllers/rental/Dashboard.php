<?php
	
	class Dashboard extends CI_Controller{

		public function index(){
			$this->rental_model->rental_login();

			$penanggung_jawab		= $this->session->userdata('penanggung_jawab');
			$data['total_data'] = $this->rental_model->total_data_rental();
			$data['transaksi']	= $this->db->query("SELECT * FROM transaksi tr, barang mb, customer cs WHERE tr.id_barang=mb.id_barang AND tr.id_customer=cs.id_customer AND tr.status_pembayaran='0' AND tr.penanggung_jawab = '$penanggung_jawab'")->result();
			$this->load->view('templates_rental/header');
			$this->load->view('templates_rental/sidebar');
			$this->load->view('rental/Dashboard',$data);
			$this->load->view('templates_rental/footer');
		}
	}
?>