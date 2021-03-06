<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends Admin_Controller {

	private $pageCurrent = 'admin/members';
	private $pageContent = 'Anggota';

	public function __construct() {
        parent::__construct();
        $this->load->model(
            array(
                'user',
            )
        );
    }

	public function index()	{

		$member['role'] = User::MEMBER_ROLE;
		$data['pageCurrent'] = $this->pageCurrent;
		$data['pageTitle'] = 'Manajemen Data Anggota';
		$data['pageTitleSub'] = 'Data Anggota';
		$data['pageContent'] = $this->pageContent;
		$data['members'] = $this->user->getWhere($member);
		$data['genders'] = [
		[
			'name' => 'Laki-laki',
			'label' => 'warning'
		],
		[
			'name' => 'Perempuan',
			'label' => 'primary'
			]
		];
		
		$this->load->view('includes/header');
		$this->load->view('includes/navbar');
		$this->load->view('includes/sidebar');
		$this->load->view('pages/admin/members/content', $data);
		$this->load->view('includes/footer');

	}

	public function insert() {

		// Start Validation
        $this->form_validation->set_rules(
            'name',
            'Nama',
            'required',
            array(
                'required' => '*) Masukkan <b>Nama</b>'
            )
        );
		$this->form_validation->set_rules(
            'username',
            'Username',
            'required|trim|is_unique[users.username]', 
            array(
                'required' => '*) Masukkan <b>Username</b>', 
                'trim' => '*) Masukkan <b>Username</b> Dengan Benar',
                'is_unique' => '*) <b>Username</b> Telah Digunakan'
            )
        );
		$this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email|is_unique[users.email]', 
            array(
                'required' => '*) Masukkan <b>Email</b>', 
                'valid_email' => '*) Masukkan Alamat <b>Email</b> Dengan Benar',
                'is_unique' => '*) Alamat <b>Email</b> Telah Digunakan'
            )
		);
		$this->form_validation->set_rules(
            'phone',
            'Phone',
            'required',
            array(
                'required' => '*) Masukkan <b>Nomor Handphone</b>'
            )
        );
		$this->form_validation->set_rules(
            'address',
            'Alamat',
            'required',
            array(
                'required' => '*) Masukkan <b>Alamat</b>'
            )
        );
        $this->form_validation->set_rules(
            'password', 
            'Password', 
            'required|min_length[8]',
            array(
                'required' => '*) Masukkan <b>Password</b>', 
                'min_length' => '*) <b>Password</b> Minimal 8 Karakter'            
            )
        );
        $this->form_validation->set_rules(
            'password-confirm',
            'Ulang Password', 
            'required|matches[password]',
            array(
                'required' => '*) Masukkan <b>Ulang Password</b>', 
                'matches' => '*) <b>Password</b> Tidak Valid'
            )
        );
		// End Validation

		if ($this->form_validation->run() === TRUE) {
			$data['uid'] = date('YmdHis');
            $data['username'] = $this->input->post('username');
            $data['email'] = $this->input->post('email');
            $data['name'] = $this->input->post('name');
            $data['password'] = sha1(md5($this->input->post('password')));
            $data['gender'] = $this->input->post('gender');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
			$data['role'] = User::MEMBER_ROLE;
			$data['joined_since'] = date('Y-m-d H:i:s');
			
			$this->user->insert($data);

			$this->session->set_flashdata('alertSweet', $this->alert->sweetAlert(Alert::SUCCESS, "Berhasil!", "Anggota baru telah di tambahkan", "false"));
			
            redirect($this->pageCurrent, 'refresh');
		} else {
			$data['pageCurrent'] = $this->pageCurrent;
			$data['pageTitle'] = 'Tambah Anggota Baru';
			$data['pageTitleSub'] = 'Formulir Anggota Baru';
			$data['pageContent'] = $this->pageContent;
			
			$this->load->view('includes/header');
			$this->load->view('includes/navbar');
			$this->load->view('includes/sidebar');
			$this->load->view('pages/admin/members/insert', $data);
			$this->load->view('includes/footer');
		}
		
	}

	public function update($id = null) {

		// check id
		if ($id == null) {
			redirect($this->pageCurrent, 'refresh');
		}

		$member['id'] = $id;
		$data['member'] = $this->user->getWhere($member);

		if ($this->input->post() != null) {
			
			// Start Validation
			$this->form_validation->set_rules(
				'name',
				'Nama',
				'required',
				array(
					'required' => '*) Masukkan <b>Nama</b>'
				)
			);
			$this->form_validation->set_rules(
				'phone',
				'Phone',
				'required',
				array(
					'required' => '*) Masukkan <b>Nomor Handphone</b>'
				)
			);
			$this->form_validation->set_rules(
				'address',
				'Alamat',
				'required',
				array(
					'required' => '*) Masukkan <b>Alamat</b>'
				)
			);
			
			// End Validation

			if ($this->input->post('password') != null) {
				
				$this->form_validation->set_rules(
					'password', 
					'Password', 
					'min_length[8]',
					array(
						'min_length' => '*) <b>Password</b> Minimal 8 Karakter'            
					)
				);
				$this->form_validation->set_rules(
					'password-confirm',
					'Ulang Password', 
					'required|matches[password]',
					array(
						'required' => '*) Masukkan <b>Ulang Password</b>', 
						'matches' => '*) <b>Password</b> Tidak Valid'
					)
				);

				if ($this->form_validation->run() === TRUE) {
					$data['password'] = sha1(md5($this->input->post('password')));
				}

			}

			if ($data['member'][0]->username !== $this->input->post('username')) {
				$this->form_validation->set_rules(
					'username',
					'Username',
					'required|trim|is_unique[users.username]', 
					array(
						'required' => '*) Masukkan <b>Username</b>', 
						'trim' => '*) Masukkan <b>Username</b> Dengan Benar',
						'is_unique' => '*) <b>Username</b> Telah Digunakan'
					)
				);
			}

			if ($data['member'][0]->email !== $this->input->post('email')) {
				$this->form_validation->set_rules(
					'email',
					'Email',
					'required|valid_email|is_unique[users.email]', 
					array(
						'required' => '*) Masukkan <b>Email</b>', 
						'valid_email' => '*) Masukkan Alamat <b>Email</b> Dengan Benar',
						'is_unique' => '*) Alamat <b>Email</b> Telah Digunakan'
					)
				);
			}

			if ($this->form_validation->run() === TRUE) {
				$input['username'] = $this->input->post('username');
				$input['email'] = $this->input->post('email');
				$input['name'] = $this->input->post('name');
				$input['gender'] = $this->input->post('gender');
				$input['address'] = $this->input->post('address');
				$input['phone'] = $this->input->post('phone');
				
				if ($this->user->update($id, $input)) {
					$this->session->set_flashdata('alertSweet', $this->alert->sweetAlert(Alert::SUCCESS, "Berhasil!", "Data telah diperbarui", "false"));
					redirect($this->pageCurrent, 'refresh');
				}

			} else {
				$this->session->set_flashdata('alertSweet', $this->alert->sweetAlert(Alert::ERROR, "Gagal!", "Data yang diinputkan tidak valid", "false"));
			}

		}

		
		$data['pageCurrent'] = $this->pageCurrent;
		$data['pageTitle'] = 'Edit Data Anggota';
		$data['pageTitleSub'] = 'Formulir Anggota';
		$data['pageContent'] = $this->pageContent;
		$data['genders'] = ['Laki-laki','Perempuan'];
		
		$this->load->view('includes/header');
		$this->load->view('includes/navbar');
		$this->load->view('includes/sidebar');
		$this->load->view('pages/admin/members/update', $data);
		$this->load->view('includes/footer');

	}

	public function delete($id)
	{
		// check id
		if ($id == null) {
			redirect($this->pageCurrent, 'refresh');
		}
		
		$member['id'] = $id;
		$delete = $this->user->delete($member);
		
		if ($delete) {
			$this->session->set_flashdata('alertSweet', $this->alert->sweetAlert(Alert::SUCCESS, "Berhasil!", "Data telah dihapus", "false"));
			redirect($this->pageCurrent, 'refresh');
		} else {
			$this->session->set_flashdata('alertSweet', $this->alert->sweetAlert(Alert::ERROR, "Gagal!", "Data tidak dapat dihapus", "false"));
			redirect($this->pageCurrent, 'refresh');
		}
		

	}

}
