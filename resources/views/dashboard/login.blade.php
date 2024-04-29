<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Purple Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>

              @if ($errors->any())
                <div class="alert alert-warning ps-3">
                  @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                    <br>
                  @endforeach
                </div>
              @endif

              <form action="{{ route('auth') }}" method="POST" class="pt-3">
                @csrf
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-lg" placeholder="Username"
                    value="{{ old('email') }}">
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
                </div>
                <div class="mt-3 d-grid gap-2">
                  <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium">SIGN
                    IN</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

</body>

</html>
