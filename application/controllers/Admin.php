<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    is_logged_in();
  }

  public function index()
  {
    $data['title'] = "Dashboard";
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

    $this->load->view('templates/header', $data, FALSE);
    $this->load->view('templates/sidebar', $data, FALSE);
    $this->load->view('templates/topbar', $data, FALSE);
    $this->load->view('admin/index', $data, FALSE);
    $this->load->view('templates/footer', $data, FALSE);
  }
}

/* End of file Admin.php */
