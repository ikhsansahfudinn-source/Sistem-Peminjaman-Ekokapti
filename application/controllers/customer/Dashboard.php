<?php
	
	class Dashboard extends CI_Controller{
		public function index(){

			// $data['barang'] = $this->rental_model->get_data('barang')->result();
			$data['barang'] = $this->db->query("SELECT * FROM barang mb, type tp WHERE mb.kode_type=tp.kode_type")->result();

			$data['rental'] = $this->db->query("SELECT nama_barang FROM barang WHERE nama_barang != ''")->result();

			$data['type'] = $this->rental_model->get_data('type')->result();
			$data['total_barang'] = $this->db->query("SELECT * FROM barang WHERE status = '1'")->num_rows()-1;
			$data['total_customer'] = $this->db->query("SELECT * FROM customer WHERE role_id = '2'")->num_rows()-1;
			$data['total_rental'] = $this->db->query("SELECT * FROM customer WHERE role_id = '3'")->num_rows()-1;

			$this->load->view('templates_customer/header');
			$this->load->view('customer/dashboard', $data);
			$this->load->view('templates_customer/footer');
		}

		public function detail_barang($id){

			$data['detail'] = $this->rental_model->ambil_id_barang($id);
			$this->load->view('templates_customer/header');
			$this->load->view('customer/detail_barang', $data);
			$this->load->view('templates_customer/footer');
		}
	}
?>