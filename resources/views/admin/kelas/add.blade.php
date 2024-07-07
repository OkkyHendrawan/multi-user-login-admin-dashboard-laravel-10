@extends ('layout.app')

@section('content')
 <!-- BS Stepper -->
 <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/bs-stepper/css/bs-stepper.min.css">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Kelas</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <form method="post" action="{{ route('admin.kelas.proses_create') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Kelas Nama</label>
                    <input type="text" class="form-control" value="{{ old('kelas_nama') }}" name="kelas_nama" required placeholder="Kelas Nama">
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="Simpan" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>

          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>


@endsection
