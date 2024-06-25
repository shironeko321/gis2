@extends('layout.dashboard')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-plus"></i>
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

  @if (session()->has('msg'))
    <div class="alert alert-success">{{ session()->get('msg') }}</div>
  @endif

  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Create New Category</h4>
      <form action="{{ route('category.store') }}" class="forms-sample" method="POST">
        @csrf
        <div class="form-group">
          <label for="color">Color</label>
          <input type="color" name="color" class="form-control form-control-color" id="color"
            placeholder="Color" value="{{ old('color') }}">
        </div>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control" id="name" placeholder="Name"
            value="{{ old('name') }}">
        </div>
        <button type="submit" class="btn btn-gradient-primary me-2">Create</button>
      </form>
    </div>
  </div>
@endsection
