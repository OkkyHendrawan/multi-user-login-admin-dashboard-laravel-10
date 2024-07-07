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
            <h1>Tambah Fakultas</h1>
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
              <form method="post" action="{{ route ('admin.fakultas.proses_create')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Kode</label>
                    <input type="text" class="form-control" value="{{ old('fakultas_kode') }}" name="fakultas_kode" required placeholder="Kode">
                  </div>
                  <div class="form-group">
                    <label>Nama Fakultas</label>
                    <input type="nama" class="form-control" name="fakultas_nama" value="{{ old('fakultas_nama') }}"  required placeholder="Nama Fakultas">
                  </div>
                  <div class="form-group">
                    <label>Status Fakultas</label>
                    <select class="form-control" name="fakultas_status" required>
                        <option value="active" {{ old('fakultas_status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('fakultas_status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Simpan</button>
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
