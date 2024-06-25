@extends('layout.dashboard')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-pen"></i>
      </span> Category
    </h3>
  </div>

  @if ($errors->any())
    <ul class="alert alert-warning">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Edit Category</h4>
      <form action="{{ route('category.update', ['category' => $item->id]) }}" class="forms-sample"
        method="POST">
        @csrf
        @method('put')
        <div class="form-group">
          <label for="color">Color</label>
          <input type="color" name="color" class="form-control form-control-color" id="color"
            placeholder="Color" value="{{ $item->color }}">
        </div>
        <div class="form-group">
          <label for="exampleInputUsername1">Name</label>
          <input type="text" name="name" class="form-control" id="exampleInputUsername1"
            placeholder="Name" value="{{ $item->name }}">
        </div>

        <button type="submit" class="btn btn-gradient-primary me-2">Edit</button>
      </form>
    </div>
  </div>
@endsection
