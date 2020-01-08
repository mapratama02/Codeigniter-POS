<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');

    is_logged_in();
  }

  public function index()
  {
    $data['title'] = "Data Masakan";
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    $data['masakan'] = $this->db->get('masakan')->result_array();


    $this->form_validation->set_rules('nama_masakan', 'Nama Masakan', 'trim|required');
    $this->form_validation->set_rules('harga', 'Harga', 'trim|required|numeric');



    if ($this->form_validation->run() == FALSE) {
      $this->load->view('templates/header', $data, FALSE);
      $this->load->view('templates/sidebar', $data, FALSE);
      $this->load->view('templates/topbar', $data, FALSE);
      $this->load->view('barang/data', $data, FALSE);
      $this->load->view('templates/footer', $data, FALSE);
    } else {
      $nama = $this->input->post('nama_masakan');
      $harga = $this->input->post('harga');

      $set = array(
        'nama_masakan' => $nama,
        'harga' => $harga,
        'status_masakan' => 1
      );

      $this->db->insert('masakan', $set);
      redirect('barang', 'refresh');
    }
  }
}

/* End of file Barang.php */
