<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
    $this->load->model('Transaksi_model', 'trans');
  }

  public function index()
  {
    $data['title'] = "Home";
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();

    $this->load->view('templates/header', $data, FALSE);
    $this->load->view('templates/sidebar', $data, FALSE);
    $this->load->view('templates/topbar', $data, FALSE);
    $this->load->view('user/index', $data, FALSE);
    $this->load->view('templates/footer', $data, FALSE);
  }

  public function export()
  {
    include APPPATH . 'third_party/PHPExcel.php';

    $user = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    $id_user = $user['id_user'];

    $query = "SELECT `user`.id_user, `user`.username, `user`.nama_user, `transaksi`.tanggal, `transaksi`.id_order FROM `user` JOIN `transaksi` ON `transaksi`.id_user = `user`.id_user WHERE `transaksi`.id_user = $id_user GROUP BY `transaksi`.id_order";
    $data = $this->db->query($query)->result_array();

    $excel = new PHPExcel();

    $excel->getProperties()
      ->setCreator("Muhammad Anugrah Pratama")
      ->setLastModifiedBy("Muhammad Anugrah Pratama")
      ->setTitle("Data Order")
      ->setSubject("Order")
      ->setDescription("Report Data Order")
      ->setKeywords("Order");

    // Header
    $excel->setActiveSheetIndex(0)->setCellValue('A1', 'no');
    $excel->setActiveSheetIndex(0)->setCellValue('B1', 'tanggal');
    $excel->setActiveSheetIndex(0)->setCellValue('C1', 'username');
    $excel->setActiveSheetIndex(0)->setCellValue('D1', 'nama_user');
    $excel->setActiveSheetIndex(0)->setCellValue('E1', 'total_bayar');

    $numrows = 2;
    $no = 1;

    foreach ($data as $data) {
      $tot_bayar =  $this->trans->tot_bayar($data['id_order']);
      array_push($data, $tot_bayar);

      // print_r($data);
      $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrows, $no++);
      $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrows, $data['tanggal']);
      $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrows, $data['username']);
      $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrows, $data['nama_user']);
      $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrows, $data[0]);

      $numrows++;
    }

    $excel->getActiveSheet(0)->setTitle("Data Order");
    $excel->setActiveSheetIndex(0);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Data Order ' . $user['username'] . '.xlsx"');
    header('Cache-Control: max-age=0');

    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
  }
}

/* End of file User.php */
