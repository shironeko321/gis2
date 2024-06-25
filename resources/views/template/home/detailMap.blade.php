<div class="offcanvas offcanvas-end" tabindex="-1" id="detail" aria-labelledby="offcanvasLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasLabel">Offcanvas</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
      aria-label="Close"></button>
  </div>
  <div class="offcanvas-body pt-0 d-flex flex-column gap-2">
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner" id="images">
      </div>
      <button class="carousel-control-prev" type="button"
        data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button"
        data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>


    {{-- alamat --}}
    <div class="card">
      <div class="card-body p-2">
        <h5 class="card-title">Alamat</h5>
        <p class="card-text" id="address"></p>
      </div>
    </div>

    {{-- waktu operasional --}}
    <div class="card">
      <div class="card-body p-2">
        <h5 class="card-title" type="button" data-bs-toggle="collapse"
          data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
          Waktu Operasional
        </h5>
        <div class="collapse" id="collapseExample">
          <ul class="list-group list-group-flush" id="open">

          </ul>
        </div>
      </div>
    </div>

    {{-- deskripsi --}}
    <div class="card">
      <div class="card-body p-2">
        <h5 class="card-title">Deskripsi</h5>
        <p class="card-text" id="description"></p>
      </div>
    </div>
  </div>
</div>
