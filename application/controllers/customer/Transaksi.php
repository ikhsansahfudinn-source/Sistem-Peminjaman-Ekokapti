<?php 

    class Transaksi extends CI_Controller{
		public function index(){
			$customer = $this->session->userdata('id_customer');
			
			// Fetch ongoing transactions (keranjang)
			$data['transaksi'] = $this->db->query("SELECT tr.*, br.nama_barang, br.harga, br.denda
							  FROM transaksi tr
							  JOIN barang br ON tr.id_barang = br.id_barang
							  WHERE tr.id_customer = '$customer' AND tr.status_rental = 'Keranjang' AND (tr.status_pembayaran IS NULL OR tr.bukti_pembayaran = '')
							  ORDER BY tr.id_pinjam DESC")->result();
			
			// Fetch pending transactions (pending)
			$data['pending'] = $this->db->query("SELECT tr.*, br.nama_barang, br.harga, br.denda
							  FROM transaksi tr
							  JOIN barang br ON tr.id_barang = br.id_barang
							  WHERE tr.id_customer = '$customer' AND tr.status_pembayaran = '0' AND tr.status_rental = 'Pending' AND tr.bukti_pembayaran = ''
							  ORDER BY tr.id_pinjam DESC")->result();
			
			// Fetch returned transactions (dikembalikan)
			$data['dikembalikan'] = $this->db->query("SELECT tr.*, br.nama_barang, br.harga, br.denda
							  FROM transaksi tr
							  JOIN barang br ON tr.id_barang = br.id_barang
							  WHERE tr.id_customer = '$customer' AND tr.status_rental = 'Selesai' AND tr.bukti_pembayaran != '' AND tr.status_pembayaran = '1'
							  ORDER BY tr.id_pinjam DESC")->result();


			// Fetch rented items (barang disewa)
			$data['disewa'] = $this->db->query("SELECT tr.*, br.nama_barang, br.harga, br.denda
							  FROM transaksi tr
							  JOIN barang br ON tr.id_barang = br.id_barang
							  WHERE tr.id_customer = '$customer' AND tr.status_rental = 'Pending' AND tr.bukti_pembayaran != ''
							  ORDER BY tr.id_pinjam DESC")->result();

			$this->load->view('templates_customer/header');
			$this->load->view('customer/transaksi', $data);
			$this->load->view('templates_customer/footer');
		}

        public function pembayaran($id){
            $customer = $this->session->userdata('id_customer');
            $data['transaksi'] = $this->db->query("SELECT tr.*, br.nama_barang, br.harga, br.denda
                                                  FROM transaksi tr
                                                  JOIN barang br ON tr.id_barang = br.id_barang
                                                  WHERE tr.id_customer = '$customer' AND tr.id_pinjam = '$id'
                                                  ORDER BY tr.id_pinjam DESC")->result();
        
            $penanggung_jawab = $data['transaksi'][0]->penanggung_jawab;
            $data['payment'] = $this->db->query("SELECT * FROM payment WHERE penanggung_jawab = '$penanggung_jawab'")->result();
        
            $this->load->view('templates_customer/header');
            $this->load->view('customer/pembayaran', $data);
            $this->load->view('templates_customer/footer');
        }

		public function pembayaran_keranjang(){
			$customer = $this->session->userdata('id_customer');
			$ids = $this->input->post('selected_transaksi_ids');
			
			if ($ids) {
				$id_array = explode(',', $ids);
				$this->db->where_in('tr.id_pinjam', $id_array);
				$this->db->where('tr.id_customer', $customer);
				$this->db->join('barang br', 'tr.id_barang = br.id_barang');
				$data['transaksi'] = $this->db->get('transaksi tr')->result();

				if (!empty($data['transaksi'])) {
					$penanggung_jawab = $data['transaksi'][0]->penanggung_jawab;
					$data['payment'] = $this->db->query("SELECT * FROM payment WHERE penanggung_jawab = '$penanggung_jawab'")->result();
					
					// Update status_rental to Pending
					$this->db->where_in('id_pinjam', $id_array);
					$this->db->update('transaksi', array('status_rental' => 'Pending'));


					$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
					  Keranjang berhasil diproses
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					</div>');
				} else {
					$data['payment'] = [];
				}

				redirect('customer/transaksi');
			} else {
				redirect('customer/transaksi');
			}
		}

        public function pembayaran_aksi(){
            $ids = $this->input->post('id_pinjam');
            $bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];
            
            if($bukti_pembayaran){
                $config['upload_path'] = './assets/upload';
                $config['allowed_types'] = 'jpg|jpeg|png|tiff|pdf|webp';

                $this->load->library('upload', $config);

                if($this->upload->do_upload('bukti_pembayaran')){
                    $bukti_pembayaran = $this->upload->data('file_name');
                } else {
                    echo $this->upload->display_errors();
                    return;
                }
            }

            $data = array(
                'bukti_pembayaran' => $bukti_pembayaran,
                'status_pembayaran' => '0' // Set status pembayaran to pending
            );

            if (is_array($ids)) {
                foreach ($ids as $id) {
                    $where = array('id_pinjam' => $id);
                    $this->rental_model->update_data('transaksi', $data, $where);
                }
            } else {
                $where = array('id_pinjam' => $ids);
                $this->rental_model->update_data('transaksi', $data, $where);
            }

            $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Bukti Pembayaran Anda Berhasil di Upload
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>');
            redirect('customer/transaksi');
        }

        public function pembayaran_pending(){
            $customer = $this->session->userdata('id_customer');
            $ids = $this->input->post('selected_pending_ids');
            
            if ($ids) {
                $id_array = explode(',', $ids);
                $this->db->where_in('tr.id_pinjam', $id_array);
                $this->db->where('tr.id_customer', $customer);
                $this->db->join('barang br', 'tr.id_barang = br.id_barang');
                $data['transaksi'] = $this->db->get('transaksi tr')->result();

                if (!empty($data['transaksi'])) {
                    $penanggung_jawab = $data['transaksi'][0]->penanggung_jawab;
                    $data['payment'] = $this->db->query("SELECT * FROM payment WHERE penanggung_jawab = '$penanggung_jawab'")->result();
                    
                    // Pass the selected IDs to the view
                    $data['selected_ids'] = $id_array;
                    
                    $this->load->view('templates_customer/header');
                    $this->load->view('customer/pembayaran_batch', $data);
                    $this->load->view('templates_customer/footer');
                    return;
                }
            }
            
            // If no IDs selected or no transactions found, redirect back to transaksi
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  Tidak ada transaksi yang dipilih
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>');
            redirect('customer/transaksi');
        }

        public function cetak_invoice($id){
            $data['transaksi'] = $this->db->query("
                SELECT tr.*, mb.nama_barang, mb.harga, mb.denda,
                    cs.nama, cs.penanggung_jawab, cs.alamat,
                    p.nama_payment, p.key_payment, p.atas_nama
                FROM transaksi tr
                JOIN barang mb ON tr.id_barang = mb.id_barang
                JOIN customer cs ON tr.id_customer = cs.id_customer
                LEFT JOIN payment p ON cs.penanggung_jawab = p.penanggung_jawab
                WHERE tr.id_pinjam = ?", array($id))->result();

            $data['penanggung_jawab'] = $this->db->query("SELECT penanggung_jawab FROM transaksi WHERE id_pinjam = '$id'")->result();

            $penanggung_jawab = $data['penanggung_jawab'][0]->penanggung_jawab;
            $data['payment']    = $this->db->query("SELECT * FROM payment WHERE penanggung_jawab = '$penanggung_jawab'")->result();
            $data['rental']     = $this->db->query("SELECT * FROM customer WHERE penanggung_jawab = '$penanggung_jawab'")->result();

            $this->load->view('customer/cetak_invoice',$data);
        }

        public function batal_transaksi($id) {
            // Get transaction details first
            $transaksi = $this->db->get_where('transaksi', array('id_pinjam' => $id))->row();
            
            // Get current stock
            $barang = $this->db->get_where('barang', array('id_barang' => $transaksi->id_barang))->row();
            $current_stock = $barang->jumlah;
            
            // Return the borrowed quantity back to stock
            $returned_stock = $current_stock + $transaksi->jumlah;
            $this->db->where('id_barang', $transaksi->id_barang);
            $this->db->update('barang', array('jumlah' => $returned_stock));
            
            // Delete the transaction
            $where = array('id_pinjam' => $id);
            $this->rental_model->delete_data($where, 'transaksi');
            $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Transaksi Berhasil dibatalkan
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>');
            
            redirect('customer/transaksi');
        }

        public function proses_keranjang() {
            $selected_transaksi = $this->input->post('selected_transaksi');
            
            if (!empty($selected_transaksi)) {
                foreach ($selected_transaksi as $id_pinjam) {
                    // Process each selected transaction
                    // Example: Mark as processed or move to another table
                    $this->db->where('id_pinjam', $id_pinjam);
                    $this->db->update('transaksi', array('status_rental' => 'Diproses'));
                }
                $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
                      Keranjang berhasil diproses
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>');
            } else {
                $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      Tidak ada transaksi yang dipilih
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>');
            }
            
            redirect('customer/transaksi');
        }
    }

?>
