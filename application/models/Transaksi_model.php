<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_model extends CI_Model
{

  public function tot_bayar($id_order)
  {
    $trans = $this->db->query("SELECT SUM(`total_bayar`) AS `total_bayar` FROM `transaksi` WHERE `id_order` = $id_order")->row_array();
    return $trans['total_bayar'];
  }
}

/* End of file Transaksi_model.php */
