<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('/') }}assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="{{ asset('/') }}assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="{{ asset('/') }}assets/css/demo/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="{{ asset('/') }}assets/images/favicon.png" />
</head>
<body>
<script src="{{ asset('/') }}assets/js/preloader.js"></script>
<div class="body-wrapper">
  <div class="main-wrapper">
    <div class="page-wrapper full-page-wrapper d-flex align-items-center justify-content-center">
      <main class="auth-page">
        <div class="mdc-layout-grid">
          <div class="mdc-layout-grid__inner">
            <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-6-tablet">
              <div class="mdc-card">
                @include('auth.message')
                <form action="" method="post">
                    {{ csrf_field() }}
                  <div class="mdc-layout-grid">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                            <div class="mdc-text-field w-100">
                              <input class="mdc-text-field__input" type="password" required name="password">
                              <div class="mdc-line-ripple"></div>
                              <label for="text-field-hero-input" class="mdc-floating-label">Password</label>
                            </div>
                          </div>

                          <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                            <div class="mdc-text-field w-100">
                              <input class="mdc-text-field__input" type="password" required name="cpassword">
                              <div class="mdc-line-ripple"></div>
                              <label for="text-field-hero-input" class="mdc-floating-label">Confirm Password</label>
                            </div>
                          </div>
                      <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                        <button type="submit" class="mdc-button mdc-button--raised w-100">Reset Password</button>
                      </div>
                    </div>
                  </div>
                </form>
                <p class="mb-1">
                    <br />
                    <a href="{{ url ('') }}">Login</a>
                  </p>
              </div>
            </div>
            <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
          </div>
        </div>
      </main>
    </div>
  </div>
</div>
<!-- plugins:js -->
<script src="{{ asset('/') }}assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{ asset('/') }}assets/js/material.js"></script>
<script src="{{ asset('/') }}assets/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<!-- End custom js for this page-->
</body>
</html>
