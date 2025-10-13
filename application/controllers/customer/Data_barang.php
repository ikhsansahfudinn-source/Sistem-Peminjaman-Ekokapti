<?php
	
	class Data_barang extends CI_Controller{
		public function index(){

			$data['barang'] = $this->rental_model->get_data('barang')->result();
			$this->load->view('templates_customer/header');
			$this->load->view('customer/data_barang', $data);
			$this->load->view('templates_customer/footer');
		}

		public function detail_barang($id){

			$data['detail'] = $this->rental_model->ambil_id_barang($id);
			$data['rental'] = $this->db->query("SELECT * FROM customer cs, barang mb WHERE mb.penanggung_jawab = cs.penanggung_jawab AND mb.id_barang = '$id'")->result();
			$this->load->view('templates_customer/header');
			$this->load->view('customer/detail_barang', $data);
			$this->load->view('templates_customer/footer');
		}
	}
?>