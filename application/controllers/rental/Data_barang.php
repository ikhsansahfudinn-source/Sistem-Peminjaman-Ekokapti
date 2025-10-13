<?php


class Data_barang extends CI_Controller{
	public function index(){
		$this->rental_model->rental_login();

		$where = array(
			'penanggung_jawab'	=> $this->session->userdata('penanggung_jawab')
		);
		$data['barang'] = $this->rental_model->get_where($where,'barang')->result();
		$data['type'] = $this->rental_model->get_data('type')->result();

		$this->load->view('templates_rental/header');
		$this->load->view('templates_rental/sidebar');
		$this->load->view('rental/Data_barang',$data);
		$this->load->view('templates_rental/footer');
	}

	public function tambah_barang(){ 
		$this->rental_model->rental_login();
		$data['type'] = $this->rental_model->get_data('type')->result();
		$this->load->view('templates_rental/header');
		$this->load->view('templates_rental/sidebar');
		$this->load->view('rental/form_tambah_barang',$data);
		$this->load->view('templates_rental/footer');
	}

	public function tambah_barang_aksi(){
		$this->rental_model->rental_login();
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
			redirect('rental/data_barang');
		}
	}


	public function update_barang($id){
		$this->rental_model->rental_login();

		$where = array('id_barang' => $id);
		$data['barang'] = $this->db->query("SELECT * FROM barang mb, type tp WHERE mb.kode_type=tp.kode_type AND mb.id_barang='$id'")->result();

		if($data['barang']['0']->penanggung_jawab != $this->session->userdata('penanggung_jawab')){
			redirect('rental/data_barang');
		}else{
		}

		$data['type'] = $this->rental_model->get_data('type')->result();

		$this->load->view('templates_rental/header');
		$this->load->view('templates_rental/sidebar');
		$this->load->view('rental/form_update_barang',$data);
		$this->load->view('templates_rental/footer');

	}

	public function update_barang_aksi(){
		$this->rental_model->rental_login();
		$this->_rules();
		if($this->form_validation->run() == FALSE){
			$this->update_barang($this->input->post('id_barang'));
		}else{
			$id 					= $this->input->post('id_barang');
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
			redirect('rental/data_barang');
		}
	}

	public function _rules(){

		$this->form_validation->set_rules('kode_type','Kode Type','required');
		$this->form_validation->set_rules('nama_barang','Nama Barang','required');
		$this->form_validation->set_rules('jumlah','Jumlah','required');
		$this->form_validation->set_rules('status','Status','required');
		$this->form_validation->set_rules('harga','Harga','required');
		$this->form_validation->set_rules('denda','Denda','required');
	}


	public function detail_barang($id){
		$this->rental_model->rental_login();

		$where = array('id_barang' => $id);
		$data['barang'] = $this->db->query("SELECT * FROM barang mb, type tp WHERE mb.kode_type=tp.kode_type AND mb.id_barang='$id'")->result();

		if($data['barang']['0']->penanggung_jawab != $this->session->userdata('penanggung_jawab')){
			redirect('rental/data_barang');
		}else{
		}

		$data['detail'] = $this->rental_model->ambil_id_barang($id);

		$this->load->view('templates_rental/header');
		$this->load->view('templates_rental/sidebar');
		$this->load->view('rental/detail_barang',$data);
		$this->load->view('templates_rental/footer');

	}

	public function delete_barang($id){
		$this->rental_model->rental_login();


		$where = array('id_barang' => $id);
		$data['barang'] = $this->db->query("SELECT * FROM barang mb, type tp WHERE mb.kode_type=tp.kode_type AND mb.id_barang='$id'")->result();

		if($data['barang']['0']->penanggung_jawab != $this->session->userdata('penanggung_jawab')){
			redirect('rental/data_barang');
		}else{
		}

		$this->rental_model->delete_data($where,'barang');

		$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Data Barang Berhasil Dihapus
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>');
		redirect('rental/data_barang');
	}
}
?>