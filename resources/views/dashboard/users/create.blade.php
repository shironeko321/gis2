@extends('layout.dashboard')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-plus"></i>
      </span> Users
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
      <h4 class="card-title">Create New User</h4>
      <form action="{{ route('user.store') }}" class="forms-sample" method="POST">
        @csrf
        <div class="form-group">
          <label for="exampleInputUsername1">Name</label>
          <input type="text" name="name" class="form-control" id="exampleInputUsername1"
            placeholder="Name" value="{{ old('name') }}">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" name="email" class="form-control" id="exampleInputEmail1"
            placeholder="Email" value="{{ old('email') }}">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="password" class="form-control" id="exampleInputPassword1"
            placeholder="Password">
        </div>
        <button type="submit" class="btn btn-gradient-primary me-2">Create</button>
      </form>
    </div>
  </div>
@endsection
