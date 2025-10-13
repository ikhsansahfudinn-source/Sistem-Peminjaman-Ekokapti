<?php 

class Rental extends CI_Controller
{
    public function tambah_rental($id)
    {
        // Periksa apakah pengguna sudah login
        if (empty($this->session->userdata('role_id'))) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Silakan Login Untuk Melanjutkan Transaksi
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('auth/login'); // Arahkan ke halaman login
        }

        // Ambil detail barang
        $data['detail'] = $this->db->query("SELECT * FROM barang mb, type tp, customer cs WHERE mb.id_barang = '$id' AND tp.kode_type = mb.kode_type AND cs.penanggung_jawab=mb.penanggung_jawab")->result();
        $this->load->view('templates_customer/header');
        $this->load->view('customer/tambah_rental', $data);
        $this->load->view('templates_customer/footer');
    }

    // public function tambah_rental_aksi()
    // {
    //     $id_customer        = $this->session->userdata('id_customer');
    //     $id_barang          = $this->input->post('id_barang');
    //     $penanggung_jawab   = $this->input->post('penanggung_jawab');
    //     $tanggal_rental     = $this->input->post('tanggal_rental');
    //     $tanggal_kembali    = $this->input->post('tanggal_kembali');
    //     $denda              = $this->input->post('denda');
    //     $harga              = $this->input->post('harga');
    //     $jumlah				= (int)$this->input->post('jumlah');

        
    //     $data = array(
    //         'id_customer'           => $id_customer,
    //         'id_barang'             => $id_barang,
    //         'penanggung_jawab'      => $penanggung_jawab,
    //         'tanggal_rental'        => $tanggal_rental,
    //         'tanggal_kembali'       => $tanggal_kembali,
    //         'denda'                 => $denda,
    //         'harga'                 => $harga,
    //         'jumlah'                => $jumlah,
    //         'tanggal_pengembalian'  => '-',
    //         'status_rental'         => 'Belum Selesai',
    //         'status_pengembalian'   => 'Belum Kembali'
    //     );

    //     $this->rental_model->insert_data($data, 'transaksi');

    //     $status = array('status' => '0');
    //     $id = array('id_barang' => $id_barang);

    //     $this->rental_model->update_data('barang', $status, $id);

    //     $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //           Transaksi Berhasil, Silakan Checkout
    //           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //             <span aria-hidden="true">&times;</span>
    //           </button>
    //         </div>');
    //     redirect('customer/transaksi');
    // }

	public function tambah_rental_aksi() {
    $id_customer = $this->session->userdata('id_customer');
    $id_barang = $this->input->post('id_barang');
    $jumlah_baru = (int)$this->input->post('jumlah');
    $tanggal_rental = $this->input->post('tanggal_rental');
    $tanggal_kembali = $this->input->post('tanggal_kembali');
    $penanggung_jawab = $this->input->post('penanggung_jawab');

    // Get current stock
    $barang = $this->db->get_where('barang', array('id_barang' => $id_barang))->row();
    $current_stock = $barang->jumlah;

    // Check if enough stock available
    if ($current_stock < $jumlah_baru) {
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Stock tidak mencukupi. Stok tersedia hanya '.$current_stock.'.</div>');
        redirect('customer/rental/tambah_rental/'.$id_barang);
        return;
    }
		
		// Update stock in barang table
		$new_stock = $current_stock - $jumlah_baru;
		$this->db->where('id_barang', $id_barang);
		$this->db->update('barang', array('jumlah' => $new_stock));
		
		// Check existing rental with same dates
		$existing_rental = $this->db->get_where('transaksi', array(
			'id_customer' => $id_customer,
			'id_barang' => $id_barang,
			'penanggung_jawab' => $penanggung_jawab,
			'tanggal_rental' => $tanggal_rental,
			'tanggal_kembali' => $tanggal_kembali,
			'status_rental' => 'Keranjang'
		))->row();
		
		if($existing_rental) {
			$jumlah_total = $existing_rental->jumlah + $jumlah_baru;
			$this->db->where(array(
				'id_customer' => $id_customer,
				'id_barang' => $id_barang,
				'penanggung_jawab' => $penanggung_jawab,
				'tanggal_rental' => $tanggal_rental,
				'tanggal_kembali' => $tanggal_kembali,
				'status_rental' => 'Keranjang'
			));
			$this->db->update('transaksi', array('jumlah' => $jumlah_total));
		} else {
			$data = array(
				'id_customer' => $id_customer,
				'id_barang' => $id_barang,
				'tanggal_rental' => $tanggal_rental,
				'tanggal_kembali' => $tanggal_kembali,
				'penanggung_jawab' => $penanggung_jawab,
				'denda' => $this->input->post('denda'),
				'harga' => $this->input->post('harga'),
				'jumlah' => $jumlah_baru,
				'status_rental' => 'Keranjang',
				'status_pengembalian' => 'Belum Kembali'
			);
			
			$this->db->insert('transaksi', $data);
		}
		
		redirect('customer/transaksi');
	}
}
