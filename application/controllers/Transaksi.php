<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
    $this->load->model('Transaksi_model', 'trans_mod');
  }
  public function index()
  {
    $data['title'] = "Transaksi";
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

    $data['transaksi'] = $this->db->query("SELECT `transaksi`.id_transaksi, `transaksi`.id_order, `user`.nama_user, `transaksi`.tanggal FROM `transaksi` JOIN `user` ON `transaksi`.id_user = `user`.id_user GROUP BY `transaksi`.id_order ORDER BY `transaksi`.tanggal DESC")->result_array();

    $this->load->view('templates/header', $data, FALSE);
    $this->load->view('templates/sidebar', $data, FALSE);
    $this->load->view('templates/topbar', $data, FALSE);
    $this->load->view('transaksi/index', $data, FALSE);
    $this->load->view('templates/footer', $data, FALSE);
  }

  public function details($id_order)
  {
    $data['title'] = "Transaksi";
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

    $data['transaksi'] = $this->db->query("SELECT `transaksi`.id_transaksi, `transaksi`.id_order, `user`.nama_user, `transaksi`.tanggal FROM `transaksi` JOIN `user` ON `transaksi`.id_user = `user`.id_user WHERE `transaksi`.id_order = $id_order GROUP BY `transaksi`.id_order")->row_array();
    $data['order'] = $this->db->query("SELECT `masakan`.id_masakan, `masakan`.nama_masakan, `detail_order`.id_order, `detail_order`.id_masakan FROM `masakan` JOIN `detail_order` ON `masakan`.id_masakan = `detail_order`.id_masakan WHERE `detail_order`.id_order = $id_order")->result_array();
    $data['total_bayar'] = $this->db->query("SELECT SUM(`total_bayar`) AS `total_bayar` FROM `transaksi` WHERE `id_order` = $id_order")->row_array();

    $this->load->view('templates/header', $data, FALSE);
    $this->load->view('templates/sidebar', $data, FALSE);
    $this->load->view('templates/topbar', $data, FALSE);
    $this->load->view('transaksi/details', $data, FALSE);
    $this->load->view('templates/footer', $data, FALSE);
  }

  public function export()
  {
    include APPPATH . 'third_party/PHPExcel.php';

    $id_order = $this->db->query("SELECT `id_order` FROM `transaksi` GROUP BY `id_order`")->result_array();

    $no = 1;
    $numrows = 2;

    $excel = new PHPExcel();

    $excel->getProperties()
      ->setCreator("Muhammad Anugrah Pratama")
      ->setLastModifiedBy("Muhammad Anugrah Pratama")
      ->setTitle("Data Transaksi")
      ->setSubject("Transaksi")
      ->setDescription("Report Data Transaksi")
      ->setKeywords("Transaksi");


    $excel->setActiveSheetIndex(0)->setCellValue('A1', 'no');
    $excel->setActiveSheetIndex(0)->setCellValue('B1', 'tanggal');
    $excel->setActiveSheetIndex(0)->setCellValue('C1', 'username');
    $excel->setActiveSheetIndex(0)->setCellValue('D1', 'nama_user');
    $excel->setActiveSheetIndex(0)->setCellValue('E1', 'total_bayar');

    foreach ($id_order as $id_order) {
      $order = $id_order['id_order'];
      $transaksi = $this->db->query("SELECT `transaksi`.tanggal, `user`.username, `user`.nama_user FROM `transaksi` JOIN `user` ON `transaksi`.id_user = `user`.id_user")->row_array();
      $tot_bayar = $this->trans_mod->tot_bayar($order);
      array_push($transaksi, $tot_bayar);


      $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrows, $no++);
      $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrows, $transaksi['tanggal']);
      $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrows, $transaksi['username']);
      $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrows, $transaksi['nama_user']);
      $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrows, $transaksi[0]);

      $numrows++;
    }

    $excel->getActiveSheet(0)->setTitle("Data Transaksi");
    $excel->setActiveSheetIndex(0);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Data Transaksi.xlsx"');
    header('Cache-Control: max-age=0');

    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');

    // print_r($id_order);
  }
}

/* End of file Transaksi.php */
