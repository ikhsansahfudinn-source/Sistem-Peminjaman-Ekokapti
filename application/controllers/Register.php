<?php 

class Register extends CI_Controller {

    public function index() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth_header');
            $this->load->view('register_form');
            $this->load->view('templates_admin/footer');
        } else {
            $nama       = $this->input->post('nama');
            $username   = $this->input->post('username');
            $alamat     = $this->input->post('alamat');
            $gender     = $this->input->post('gender');
            $no_telp    = $this->input->post('no_telp');
            $no_ktp     = $this->input->post('no_ktp');
            $password   = md5($this->input->post('password'));
            $role_id    = '2';

            $data = array(
                'nama'      => $nama,
                'username'  => $username,
                'alamat'    => $alamat,
                'gender'    => $gender,
                'no_telp'   => $no_telp,
                'no_ktp'    => $no_ktp,
                'password'  => $password,
                'role_id'   => $role_id
            );

            $this->rental_model->insert_data($data, 'customer');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Berhasil Register, Silakan Login!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>');
            redirect('auth/login');
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('nama', 'Nama', 'required', [
            'required' => 'Nama harus diisi.'
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique [customer.username]', [
            'is_unique' => 'Username sudah terdaftar.',
            'required' => 'Username harus diisi.'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required', [
            'required' => 'Alamat harus diisi.'
        ]);
        $this->form_validation->set_rules('gender', 'Gender', 'required', [
            'required' => 'Gender harus dipilih.'
        ]);
        $this->form_validation->set_rules('no_telp', 'No. Telepon', 'required|numeric', [
            'required' => 'No. Telepon harus diisi.',
            'numeric' => 'No. Telepon harus berupa angka.'
        ]);
        $this->form_validation->set_rules('no_ktp', 'No. KTP', 'required|numeric', [
            'required' => 'No. KTP harus diisi.',
            'numeric' => 'No. KTP harus berupa angka.'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/]', [
            'required' => 'Password harus diisi.',
            'min_length' => 'Password minimal 8 karakter.',
            'regex_match' => 'Password harus mengandung minimal 1 huruf kapital, 1 angka, dan 1 karakter khusus (!@#$%^&*).'
        ]);
    }
}