<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    <a href="#" data-toggle="modal" data-target="#barangModal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah baru</a>
  </div>

  <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

  <div class="card">
    <div class="card-body">

      <table class="table table-responsive-md table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Masakan</th>
            <th>Harga</th>
            <th colspan="1">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($masakan as $food) : ?>
            <tr>
              <td><?= $food['id_masakan'] ?></td>
              <td><?= $food['nama_masakan'] ?></td>
              <td>Rp<?= number_format($food['harga'], 2, ',', '.') ?></td>
              <td><a href="#" class="btn btn-info">Edit</a> <a href="#" class="btn btn-danger">Remove</a></td>

            </tr>
          <?php endforeach ?>
        </tbody>
      </table>

    </div>
  </div>

</div>
<!-- /.container-fluid -->

<!-- Tambah Data Barang -->
<div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="barangModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('barang') ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="barangModalTitle">Tambah Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <div class="col-sm-6">
              <label for="inputNamaMasakan">Nama Masakan</label>
              <input type="text" name="nama_masakan" id="inputNamaMasakan" class="form-control">
            </div>
            <div class="col-sm-6">
              <label for="inputHargaMasakan">Harga</label>
              <input type="number" name="harga" id="inputHargaMasakan" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>