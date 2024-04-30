@extends('layout.dashboard', ['active' => 'category'])

@section('content')
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-home"></i>
      </span> Category
    </h3>

    <a href="{{ route('category.create') }}" class="btn btn-primary">
      Create a New
      <i class="mdi mdi-plus"></i>
    </a>
  </div>

  @if (session()->has('msg'))
    <div class="alert alert-success">{{ session()->get('msg') }}</div>
  @endif

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">List</h4>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th> * </th>
                  <th> Name </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($collection as $item)
                  <tr>
                    <th>
                      {{ $loop->iteration }}
                    </th>
                    <td> {{ $item->name }} </td>
                    <td>
                      <div class="btn-group">
                        <a href="{{ route('category.edit', ['category' => $item->id]) }}"
                          class="btn btn-primary">
                          <i class="mdi mdi-pen"></i>
                          Edit
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                          data-bs-target="#delete-{{ $loop->iteration }}">
                          <i class="mdi mdi-trash-can"></i>
                          Delete
                        </button>
                      </div>
                      <div class="modal fade" id="delete-{{ $loop->iteration }}" tabindex="-1"
                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>are you sure delete this item({{ $item->name }})?</p>
                            </div>
                            <form action="{{ route('category.destroy', ['category' => $item->id]) }}"
                              method="POST" class="modal-footer">
                              @csrf
                              @method('delete')
                              <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
