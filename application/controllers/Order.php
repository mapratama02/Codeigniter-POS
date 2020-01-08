<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    is_logged_in();
  }

  public function index()
  {
    $data['title'] = "Order";
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    $data['users'] = $this->db->get_where('user', ['id_level' => 4])->result_array();
    $data['masakan'] = $this->db->get('masakan')->result_array();

    $data['order'] = $this->db->query(
      "SELECT `order`.id_order, `order`.no_meja, `order`.tanggal, `order`.keterangan, `user`.id_user, `user`.username
      FROM `order` JOIN `user` ON `order`.id_user = `user`.id_user"
    )->result_array();

    $this->load->view('templates/header', $data, FALSE);
    $this->load->view('templates/sidebar', $data, FALSE);
    $this->load->view('templates/topbar', $data, FALSE);
    $this->load->view('order/index', $data, FALSE);
    $this->load->view('templates/footer', $data, FALSE);
  }

  public function detail_order($id)
  {
    $data['title'] = "Order";
    $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    $data['users'] = $this->db->get_where('user', ['id_level' => 4])->result_array();
    // $data['masakan'] = $this->db->get('masakan')->result_array();

    // $id = $this->db->query("SELECT ");

    $data['masakan'] = $this->db->query(
      "SELECT `masakan`.nama_masakan FROM `masakan` JOIN `detail_order` ON `masakan`.id_masakan = `detail_order`.id_masakan WHERE `detail_order`.id_order = $id"
    )->result_array();

    // print_r($data['masakan']);

    // die;

    $this->load->view('templates/header', $data, FALSE);
    $this->load->view('templates/sidebar', $data, FALSE);
    $this->load->view('templates/topbar', $data, FALSE);
    $this->load->view('order/detail_order', $data, FALSE);
    $this->load->view('templates/footer', $data, FALSE);
  }

  public function add_detail_order()
  {
    $id_order = $this->input->post('id_order');
    $masakan = $this->input->post('masakan');
    $keterangan = $this->input->post('keterangan');
    if ($keterangan == NULL) {
      $keterangan = '';
    }

    $set = array(
      'id_order' => $id_order,
      'id_masakan' => $masakan,
      'keterangan' => $keterangan,
      'status_detail_order' => 1
    );

    $this->db->insert('detail_order', $set);
    redirect('order');
  }

  public function add()
  {
    $user = $this->input->post('user');
    $no_meja = $this->input->post('no_meja');
    $keterangan = $this->input->post('keterangan');

    if ($keterangan == NULL) {
      $keterangan = '';
    }

    $set = array(
      'no_meja' => $no_meja,
      'tanggal' => date('Y-m-d'),
      'id_user' => $user,
      'keterangan' => $keterangan,
      'status_order' => 1
    );

    print_r($set);

    $this->db->insert('order', $set);
    redirect('order');
  }

  public function export()
  {
    include APPPATH . 'third_party/PHPExcel.php';

    $query = "SELECT `order`.id_order, `order`.no_meja, `order`.tanggal, `user`.username, `user`.nama_user, `masakan`.nama_masakan, `masakan`.harga FROM `order`
              JOIN `user` ON `order`.id_user = `user`.id_user 
              JOIN `detail_order` ON `order`.id_order = `detail_order`.id_order
              JOIN `masakan` ON `masakan`.id_masakan = `detail_order`.id_masakan";

    $data = $this->db->query($query)->result();

    // print_r($data);

    // die;

    $excel = new PHPExcel();

    $excel->getProperties()
      ->setCreator("Muhammad Anugrah Pratama")
      ->setLastModifiedBy("Muhammad Anugrah Pratama")
      ->setTitle("Data Order")
      ->setSubject("Order")
      ->setDescription("Report Data Order")
      ->setKeywords("Order");

    // Header
    $excel->setActiveSheetIndex(0)->setCellValue('A1', 'id_order');
    $excel->setActiveSheetIndex(0)->setCellValue('B1', 'no_meja');
    $excel->setActiveSheetIndex(0)->setCellValue('C1', 'tanggal');
    $excel->setActiveSheetIndex(0)->setCellValue('D1', 'username');
    $excel->setActiveSheetIndex(0)->setCellValue('E1', 'nama_user');
    $excel->setActiveSheetIndex(0)->setCellValue('F1', 'nama_masakan');
    $excel->setActiveSheetIndex(0)->setCellValue('G1', 'harga');

    $numrows = 2;
    foreach ($data as $key) {
      $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrows, $key->id_order);
      $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrows, $key->no_meja);
      $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrows, $key->tanggal);
      $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrows, $key->username);
      $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrows, $key->nama_user);
      $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrows, $key->nama_masakan);
      $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrows, $key->harga);

      $numrows++;
    }

    $excel->getActiveSheet(0)->setTitle("Data Order");
    $excel->setActiveSheetIndex(0);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Data Order.xlsx"');
    header('Cache-Control: max-age=0');

    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $write->save('php://output');
  }
}

/* End of file Order.php */
