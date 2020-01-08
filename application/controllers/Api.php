<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

  public function index()
  {
    $query = "SELECT `order`.no_meja, `order`.tanggal, `user`.username, `user`.nama_user, `masakan`.nama_masakan 
              FROM `order` 
              JOIN `detail_order` ON `detail_order`.id_order = `order`.id_order 
              JOIN `masakan` ON `masakan`.id_masakan = `detail_order`.id_masakan 
              JOIN `user` ON `order`.id_user = `user`.id_user";

    $data = $this->db->query($query)->result_array();

    // array_push($data, $_SERVER['SERVER_NAME']);

    echo json_encode($data);
    // echo json_encode($data);
  }
}

/* End of file Api.php */
