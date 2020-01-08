<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }

  public function index()
  {
    $data['title'] = "Point Of Sale";

    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');


    if ($this->form_validation->run() == FALSE) {
      $this->load->view('auth/header', $data, FALSE);
      $this->load->view('auth/login', $data, FALSE);
      $this->load->view('auth/footer', $data, FALSE);
    } else {
      $username = $this->input->post('username');
      $password = $this->input->post('password');

      $this->_login($username, $password);
    }
  }

  private function _login($username, $password)
  {
    $user = $this->db->get_where('user', ['username' => $username])->row_array();

    if ($user) {
      if (password_verify($password, $user['password'])) {
        $data = array(
          'username' => $username,
          'level' => $user['id_level']
        );
        $this->session->set_userdata($data);

        if ($this->session->userdata('level') == 1) {
          redirect('admin');
        } else {
          redirect('user');
        }
      } else {
        $this->session->set_flashdata('msg', '<div class="alert alert-danger">Wrong Password!</div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('msg', '<div class="alert alert-danger">User not found!</div>');
      redirect('auth');
    }
  }

  public function logout()
  {

    $this->session->unset_userdata('username');
    $this->session->unset_userdata('level');
    $this->session->set_flashdata('msg', '<div class="alert alert-success">GoodBye!</div>');
    redirect('auth');
  }

  public function blokced()
  {
    $this->load->view('auth/blocked');
  }

  public function insert_dummy()
  {
    $data = array(
      array(
        'username' => "mapratama02",
        'password' => password_hash('Pratama02', PASSWORD_DEFAULT),
        'nama_user' => "Muhammad Anugrah Pratama",
        'id_level' => 1
      ),
      array(
        'username' => "mecinkari",
        'password' => password_hash('ayamkari', PASSWORD_DEFAULT),
        'nama_user' => "Muhammad Anugrah Pratama",
        'id_level' => 2
      ),
      array(
        'username' => "johndoe",
        'password' => password_hash('jojojojo', PASSWORD_DEFAULT),
        'nama_user' => "John Doe",
        'id_level' => 3
      ),
      array(
        'username' => "sarahjane",
        'password' => password_hash('sarahjane', PASSWORD_DEFAULT),
        'nama_user' => "Sarah Jane",
        'id_level' => 4
      ),
    );

    $this->db->insert_batch('user', $data);
    redirect('auth', 'refresh');
  }
}

/* End of file Auth.php */
