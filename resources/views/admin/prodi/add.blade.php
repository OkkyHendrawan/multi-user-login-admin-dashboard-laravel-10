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
            <h1>Tambah Prodi</h1>
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
              <form method="post" action="{{ route ('admin.prodi.proses_create')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Kode</label>
                    <input type="text" class="form-control" value="{{ old('prodi_kode') }}" name="prodi_kode" required placeholder="Kode">
                    @error('prodi_kode')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Nama Prodi</label>
                    <input type="nama" class="form-control" name="prodi_nama" value="{{ old('prodi_nama') }}"  required placeholder="Nama Prodi">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Fakultas <span style="color: red;">*</span></label>
                    <select class="form-control" required name="fakultas_id">
                        <option value="">Pilih Fakultas</option>
                        @foreach($daftarFakultas as $value)
                        <option value=" {{ $value->fakultas_id }}">{{ $value->fakultas_nama }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Status Prodi</label>
                    <select class="form-control" name="prodi_status" required>
                        <option value="active" {{ old('prodi_status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('prodi_status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
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
