<div class="modal fade" id="filtercategory" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Destination By Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
          id="close-modal"></button>
      </div>
      <div class="modal-body">
        <div class="row row-cols-2 row-cols-md-4 g-3 px-0 px-md-5">
          @foreach ($category as $item)
            <div class="col">
              <label class="w-100 form-check-label border rounded p-2"
                for="{{ $item->name . '-' . $loop->iteration }}">
                <input class="form-check-input category" type="checkbox" name="filter"
                  value="{{ $item->name }}" id="{{ $item->name . '-' . $loop->iteration }}">
                {{ ucfirst(trans($item->name)) }}
              </label>
            </div>
          @endforeach
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="filter">
          <i class="fa fa-filter"></i>
          Filter
        </button>
      </div>
    </div>
  </div>
</div>
