<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    <!-- <a href="#" data-toggle="modal" data-target="#exampleModalCenter" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah baru</a> -->
  </div>

  <a href="<?= base_url('transaksi/export') ?>" class="btn btn-outline-success mb-4"><i class="fas fa-file-excel"></i> Export Excel</a>

  <div class="card">
    <div class="card-body">

      <table class="table table-responsive-md table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1 ?>
          <?php foreach ($transaksi as $transaksi) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $transaksi['nama_user'] ?></td>
              <td><?= $transaksi['tanggal'] ?></td>
              <td><a href="<?= base_url('transaksi/details/') . $transaksi['id_order'] ?>" class="btn btn-info">Details</a></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>

    </div>
  </div>

</div>