@extends ('layout.app')

@section('content')

        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <meta http-equiv="X-UA-Compatible" content="ie=edge">
          <!-- plugins:css -->
          <link rel="stylesheet" href="{{ asset('/') }}assets/vendors/css/vendor.bundle.base.css">
          <link rel="stylesheet" href="{{ asset('/') }}assets/css/demo/style.css">
          <!-- End layout styles -->
        </head>
        <body>
        {{-- <script src="{{ asset('/') }}assets/js/preloader.js"></script> --}}
          <div class="body-wrapper">
            <div class="main-wrapper mdc-drawer-app-content">
              <div class="page-wrapper mdc-toolbar-fixed-adjust">
                <main class="content-wrapper">
                  <div class="mdc-layout-grid">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--info">
                              <div class="card-inner">
                                <h5 class="card-title">Average Income</h5>
                                <h5 class="font-weight-light pb-2 mb-1 border-bottom">$1,200.00</h5>
                                <p class="tx-12 text-muted">87% target reached</p>
                                <div class="card-icon-wrapper">
                                  <i class="material-icons">credit_card</i>
                                </div>
                              </div>
                            </div>
                          </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--primary">
                              <div class="card-inner">
                                <h5 class="card-title">Lead Conversion</h5>
                                <h5 class="font-weight-light pb-2 mb-1 border-bottom">$234,769.00</h5>
                                <p class="tx-12 text-muted">87% target reached</p>
                                <div class="card-icon-wrapper">
                                  <i class="material-icons">trending_up</i>
                                </div>
                              </div>
                            </div>
                          </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--danger">
                              <div class="card-inner">
                                <h5 class="card-title">Annual Profit</h5>
                                <h5 class="font-weight-light pb-2 mb-1 border-bottom">$1,958,104.00</h5>
                                <p class="tx-12 text-muted">55% target reached</p>
                                <div class="card-icon-wrapper">
                                  <i class="material-icons">attach_money</i>
                                </div>
                              </div>
                            </div>
                          </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--success">
                              <div class="card-inner">
                                <h5 class="card-title">Borrowed</h5>
                                <h5 class="font-weight-light pb-2 mb-1 border-bottom">$62,0076.00</h5>
                                <p class="tx-12 text-muted">48% target reached</p>
                                <div class="card-icon-wrapper">
                                  <i class="material-icons">dvr</i>
                                </div>
                              </div>
                            </div>
                          </div>
                      <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                        <div class="mdc-card">
                          <h6 class="card-title">Line chart</h6>
                          <canvas id="lineChart"></canvas>
                        </div>
                      </div>
                      <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                        <div class="mdc-card">
                          <h6 class="card-title">Bar chart</h6>
                          <canvas id="barChart"></canvas>
                        </div>
                      </div>
                      <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                        <div class="mdc-card">
                          <h6 class="card-title">Area chart</h6>
                          <canvas id="areaChart"></canvas>
                        </div>
                      </div>
                      <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                        <div class="mdc-card">
                          <h6 class="card-title">Doughnut chart</h6>
                          <canvas id="doughnutChart"></canvas>
                        </div>
                      </div>
                      <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                        <div class="mdc-card">
                          <h6 class="card-title">Chart Mahasiswa</h6>
                          <canvas id="pieChart"></canvas>
                        </div>
                      </div>
                      <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                        <div class="mdc-card">
                          <h6 class="card-title">Scatter chart</h6>
                          <canvas id="scatterChart"></canvas>
                        </div>
                      </div>
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
          <script src="{{ asset('/') }}assets/vendors/chartjs/Chart.min.js"></script>
          <!-- End plugin js for this page-->
          <!-- inject:js -->
          <script src="{{ asset('/') }}assets/js/material.js"></script>
          <script src="{{ asset('/') }}assets/js/misc.js"></script>
          <!-- endinject -->
          <!-- Custom js for this page-->
          <script src="{{ asset('/') }}assets/js/chartjs.js"></script>
          <!-- End custom js for this page-->
        </body>
        </html>

    </section>


@endsection
