<?php


class Data_barang extends CI_Controller{
	public function index(){
		$this->rental_model->admin_login();
		$data['barang'] = $this->rental_model->get_data('barang')->result();
		$data['type'] = $this->rental_model->get_data('type')->result();

		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/Data_barang',$data);
		$this->load->view('templates_admin/footer');
	}

	public function tambah_barang(){ 
		$this->rental_model->admin_login();
		$data['type'] = $this->rental_model->get_data('type')->result();
		$data['penanggung_jawab'] = $this->db->query("SELECT penanggung_jawab FROM customer WHERE role_id='3'")->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/form_tambah_barang',$data);
		$this->load->view('templates_admin/footer');
	}

	public function tambah_barang_aksi(){
		
		$this->_rules();
		if($this->form_validation->run() == FALSE){
			$this->tambah_barang();
		}else{
			$penanggung_jawab			= $this->input->post('penanggung_jawab');
			$kode_type				= $this->input->post('kode_type');
			$nama_barang					= $this->input->post('nama_barang');
			$jumlah				= $this->input->post('jumlah');
			$status					= $this->input->post('status');
			$harga					= $this->input->post('harga');
			$denda					= $this->input->post('denda');
			$pengantaran						= $this->input->post('pengantaran');
			$pengambilan					= $this->input->post('pengambilan');
			$gambar					= $_FILES['gambar']['name'];


			if($gambar='0'){}else{
				$config['upload_path']		= './assets/upload';
				$config['allowed_types']	= 'jpg|jpeg|png|tiff|webp';

				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('gambar')){
					echo "Gambar Barang Gagal diupload!";
				}else{
					$gambar = $this->upload->data('file_name');
				}
			}

			$data = array(
				'penanggung_jawab'		=> $penanggung_jawab,
				'kode_type'			=> $kode_type,
				'nama_barang'				=> $nama_barang,
				'jumlah'			=> $jumlah,
				'status'			=> $status,
				'harga'				=> $harga,
				'denda'				=> $denda,
				'pengantaran'				=> $pengantaran,
				'pengambilan'				=> $pengambilan,
				'gambar'			=> $gambar,
			);

			$this->rental_model->insert_data($data, 'barang');
			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				  Data Barang Berhasil Ditambahkan
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>');
			redirect('admin/data_barang');
		}
	}


	public function update_barang($id){
		$this->rental_model->admin_login();
		$where = array('id_barang' => $id);
		$data['barang'] = $this->db->query("SELECT * FROM barang mb, type tp WHERE mb.kode_type=tp.kode_type AND mb.id_barang='$id'")->result();
		$data['type'] = $this->rental_model->get_data('type')->result();
		$data['penanggung_jawab'] = $this->db->query("SELECT penanggung_jawab FROM customer WHERE role_id='3'")->result();

		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/form_update_barang',$data);
		$this->load->view('templates_admin/footer');

	}

	public function update_barang_aksi(){
		$this->rental_model->admin_login();
		$this->_rules();
		if($this->form_validation->run() == FALSE){
			$this->update_barang($this->input->post('id_barang'));
		}else{
			$id 					= $this->input->post('id_barang');
			$penanggung_jawab			= $this->input->post('penanggung_jawab');
			$kode_type				= $this->input->post('kode_type');
			$nama_barang					= $this->input->post('nama_barang');
			$jumlah				= $this->input->post('jumlah');
			$status					= $this->input->post('status');
			$harga					= $this->input->post('harga');
			$denda					= $this->input->post('denda');
			$pengantaran						= $this->input->post('pengantaran');
			$pengambilan					= $this->input->post('pengambilan');
			$gambar					= $_FILES['gambar']['name'];
			
			if($gambar){
				$config['upload_path']		= './assets/upload';
				$config['allowed_types']	= 'jpg|jpeg|png|tiff|webp';

				$this->load->library('upload', $config);

				if($this->upload->do_upload('gambar')){
					$gambar = $this->upload->data('file_name');
					$this->db->set('gambar', $gambar);
				}else{
					echo $this->upload->display_errors();
				}
			}

			$data = array(
				'penanggung_jawab'		=> $penanggung_jawab,
				'kode_type'			=> $kode_type,
				'nama_barang'				=> $nama_barang,
				'jumlah'			=> $jumlah,
				'status'			=> $status,
				'harga'				=> $harga,
				'denda'				=> $denda,
				'pengantaran'				=> $pengantaran,
				'pengambilan'				=> $pengambilan,
				
			);

			$where = array(
				'id_barang' => $id
			);

			$this->rental_model->update_data('barang', $data, $where);

			$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				  Data Barang Berhasil Diupdate
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>');
			redirect('admin/data_barang');
		}
	}

	public function _rules(){

		
		$this->form_validation->set_rules('penanggung_jawab','Penanggung Jawab','required');
		$this->form_validation->set_rules('kode_type','Type Barang','required');
		$this->form_validation->set_rules('nama_barang','Nama Barang','required');
		$this->form_validation->set_rules('jumlah','Jumlah','required');
	//	$this->form_validation->set_rules('tahun','Tahun','required');
	//	$this->form_validation->set_rules('warna','Warna','required');
		$this->form_validation->set_rules('status','Status','required');
		$this->form_validation->set_rules('harga','Harga','required');
		$this->form_validation->set_rules('denda','Denda','required');
	}


	public function detail_barang($id){
		$this->rental_model->admin_login();

		$data['detail'] = $this->rental_model->ambil_id_barang($id);
		$data['type'] = $this->rental_model->get_data('type')->result();

		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/detail_barang',$data);
		$this->load->view('templates_admin/footer');

	}

	public function delete_barang($id){
		$this->rental_model->admin_login();

		$where = array('id_barang' => $id);
		$this->rental_model->delete_data($where,'barang');

		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Data Barang Berhasil Dihapus
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>');
		redirect('admin/data_barang');
	}
}
?>