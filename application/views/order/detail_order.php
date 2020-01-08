<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    <!-- <a href="#" data-toggle="modal" data-target="#exampleModalCenter" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah baru</a> -->
  </div>

  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4">
          <h5 class="text-gray-700">Makanan yang dipesan</h5>
          <hr>
          <ul class="list-group">
            <?php foreach ($masakan as $food) : ?>
              <li class="list-group-item"><?= $food['nama_masakan'] ?></li>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

</div>