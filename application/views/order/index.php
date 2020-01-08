<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    <a href="#" data-toggle="modal" data-target="#exampleModalCenter" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah baru</a>
  </div>

  <a href="<?= base_url('order/export') ?>" class="btn btn-outline-success mb-4"><i class="fas fa-file-excel"></i> Export Data</a>

  <div class="card">
    <div class="card-body">
      <table class="table table-responsive-md table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Meja</th>
            <th>Tanggal</th>
            <th>User</th>
            <th>Keterangan</th>
            <th colspan="2">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($order as $orders) : ?>
            <tr>
              <td><?= $orders['id_order'] ?></td>
              <td><?= $orders['no_meja'] ?></td>
              <td><?= $orders['tanggal'] ?></td>
              <td><?= $orders['username'] ?></td>
              <td><?= $orders['keterangan'] ?></td>
              <td><a href="#" data-toggle="modal" data-order="<?= $orders['id_order'] ?>" data-target="#detailOrder" class="btn btn-success">Add Order</a></td>
              <td><a href="<?= base_url('order/detail_order/' . $orders['id_order']) ?>" class="btn btn-info">Detail Order</a></td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('order/add') ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">New Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row form-group">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">User</label>
                <select name="user" id="UserSelect" class="form-control">
                  <?php foreach ($users as $u) : ?>
                    <option value="<?= $u['id_user'] ?>"><?= $u['nama_user'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">No Meja</label>
                <input type="number" name="no_meja" id="noMeja" class="form-control">
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-12">
              <label for="">Keterangan</label>
              <textarea name="keterangan" id="" cols="30" rows="5" class="form-control"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Tambah Data Barang -->
<div class="modal fade" id="detailOrder" tabindex="-1" role="dialog" aria-labelledby="detailOrderTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="<?= base_url('order/add_detail_order') ?>" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="detailOrderTitle">Tambah Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <div class="col-sm-4">
              <label for="">ID Order</label>
              <input type="text" name="id_order" readonly id="idOrder" class="form-control">
            </div>
            <div class="col-sm-4">
              <label for="inputNamaMasakan">Nama Masakan</label>
              <select name="masakan" id="namaMasakan" class="form-control">
                <?php foreach ($masakan as $food) : ?>
                  <option value="<?= $food['id_masakan'] ?>"><?= $food['nama_masakan'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-sm-4">
              <label for="inputHargaMasakan">Keterangan</label>
              <input type="text" name="keterangan" id="inputHargaMasakan" class="form-control">
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