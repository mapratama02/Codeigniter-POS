<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title ?> - Details</h1>
    <!-- <a href="#" data-toggle="modal" data-target="#exampleModalCenter" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah baru</a> -->
  </div>

  <div class="card">
    <div class="card-body">

      <dt>Name</dt>
      <dd><?= $transaksi['nama_user'] ?></dd>

      <dt>Order(s)</dt>
      <dd>
        <ul>
          <?php foreach ($order as $order) : ?>
            <li><?= $order['nama_masakan'] ?></li>
          <?php endforeach ?>
        </ul>
      </dd>

      <dt>Total Harga</dt>
      <dd>Rp<?= number_format($total_bayar['total_bayar'], 2, ',', '.') ?></dd>

    </div>
  </div>

</div>