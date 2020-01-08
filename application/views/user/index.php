<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    <!-- <a href="#" data-toggle="" data-target="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah baru</a> -->
  </div>

  <!-- <div class="card">
    <div class="card-body"></div>
  </div> -->

  <?php if ($user['id_level'] == 4) : ?>
    <a href="<?= base_url('user/export') ?>" class="btn btn-outline-success mb-4"><i class="fas fa-file-excel"></i> Generate your Transaction</a>
  <?php endif ?>

  <div class="jumbotron bg-white shadow">
    <h1 class="display-4">Halo! <?= $user['nama_user'] ?></h1>
    <hr>
  </div>

</div>