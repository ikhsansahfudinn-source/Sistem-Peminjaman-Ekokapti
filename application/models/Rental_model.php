<?php

	class Rental_model extends CI_Model{
		public function get_data($table){
			return $this->db->get($table);
		}

		public function get_where($where, $table){
			return $this->db->get_where($table, $where);
		}

		public function check_stock($id_barang) {
			$this->db->select('jumlah');
			$this->db->from('barang');
			$this->db->where('id_barang', $id_barang);
			$query = $this->db->get();
			return $query->row()->jumlah;
		}

		public function insert_data($data, $table){
			// Update stock after inserting rental data
			$id_barang = $data['id_barang'];
			$jumlah_pinjam = $data['jumlah_pinjam'];
			$stok_tersedia = $this->check_stock($id_barang);

			if ($stok_tersedia >= $jumlah_pinjam) {
				$this->db->insert($table, $data);
				// Update the stock in the barang table
				$this->db->set('jumlah', 'jumlah - ' . (int)$jumlah_pinjam, FALSE);
				$this->db->where('id_barang', $id_barang);
				$this->db->update('barang');
			} else {
				return false; // Not enough stock available
			}
			$this->db->insert($table, $data);
		}

		public function update_data($table, $data, $where){
			$this->db->update($table, $data, $where);
		}		

		public function delete_data($where, $table){
			$this->db->where($where);
			$this->db->delete($table);
		}

		public function ambil_id_barang($id){
			$hasil = $this->db->where('id_barang',$id)->get('barang');
			if($hasil->num_rows() > 0){
				return $hasil->result();
			}else{
				return false;
			}
		}

		public function cek_login(){
			$username = set_value('username');
			$password = set_value('password');

			$result = $this->db
							->where('username',$username)
							->where('password',md5($password))
							->limit(1)
							->get('customer');

			if($result->num_rows() > 0){
				return $result->row();
			}else{
				return FALSE;
			}
		}

		public function update_password($where, $data, $table){
			$this->db->where($where);
			$this->db->update($table,$data);
		
		}

		public function downloadPembayaran($id){
			$query = $this->db->get_where('transaksi',array('id_pinjam' => $id));
			return $query->row_array();
		}

		public function total_data_rental(){
			$penanggung_jawab 		= $this->session->userdata('penanggung_jawab');

			$menunggu_konfirmasi= $this->db->query("SELECT * FROM transaksi WHERE bukti_pembayaran != '' AND status_pembayaran = '0' AND penanggung_jawab = '$penanggung_jawab'")->num_rows();
			$transaksi			= $this->db->get_where('transaksi', array('penanggung_jawab' => $penanggung_jawab))->num_rows();
			$transaksi_selesai	= $this->db->query("SELECT * FROM transaksi WHERE status_rental = 'Selesai' AND penanggung_jawab = '$penanggung_jawab'")->num_rows();
			$barang 				= $this->db->get_where('barang', array('penanggung_jawab' => $penanggung_jawab))->num_rows();

			$data = array(

				'total_menunggu_konfirmasi' => $menunggu_konfirmasi,
				'total_transaksi'	=> $transaksi,
				'total_transaksi_selesai' => $transaksi_selesai,
				'total_barang'	=> $barang
			);	

			return $data;
		}


		public function total_data_admin(){
			$customer			= $this->db->get_where('customer', array('role_id' => '2'))->num_rows();
			$transaksi			= $this->db->count_all_results('transaksi');
			$transaksi_selesai	= $this->db->get_where('transaksi', array('status_rental' => 'Selesai'))->num_rows();
			$barang 				= $this->db->count_all_results('barang');

			$data = array(

				'total_customer' => $customer,
				'total_transaksi'	=> $transaksi,
				'total_transaksi_selesai' => $transaksi_selesai,
				'total_barang'	=> $barang
			);	

			return $data;
		}

		public function rental_login(){
			if (!empty($this->session->userdata('role_id'))) {
				if ($this->session->userdata('role_id') == '3') {
					return;
				}elseif($this->session->userdata('role_id') == '2'){
					redirect('customer/dashboard');
				}else{
					redirect('admin/dashboard');
				}
			}else{
				redirect('customer/dashboard');
			}
		}

		public function admin_login(){
			if (!empty($this->session->userdata('role_id'))) {
				if ($this->session->userdata('role_id') == '1') {
					return;
				}elseif($this->session->userdata('role_id') == '2'){
					redirect('customer/dashboard');
				}else{
					redirect('rental/dashboard');
				}
			}else{
				redirect('customer/dashboard');
			}
		}

		public function customer_login(){
			if (!empty($this->session->userdata('role_id'))) {
				if ($this->session->userdata('role_id') == '2') {
					return;
				}elseif($this->session->userdata('role_id') == '1'){
					redirect('admin/dashboard');
				}else{
					redirect('rental/dashboard');
				}
			}else{
				redirect('customer/dashboard');
			}
		}
	}

?>
