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
            <h1>Tambah Mahasiswa Baru</h1>
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
                <form method="post" action="{{ route ('admin.mahasiswa.proses_create') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Nama Lengkap <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" value="{{ old('mahasiswa_nama') }}" name="mahasiswa_nama" required placeholder="Nama Lengkap">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mahasiswa_nbi">NBI:</label>
                                <input type="text" name="mahasiswa_nbi" id="mahasiswa_nbi" class="form-control" value="{{ old('mahasiswa_nbi') }}">
                                @error('mahasiswa_nbi')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status <span style="color: red;">*</span></label>
                                <select class="form-control" required name="mahasiswa_status">
                                    <option value="">Pilih Status </option>
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Alamat <span style="color: red;"></span></label>
                                <input type="text" class="form-control" value="{{ old('mahasiswa_alamat') }}" name="mahasiswa_alamat" required placeholder="Alamat">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Nomor HP <span style="color: red;"></span></label>
                                <input type="text" class="form-control" value="{{ old('mahasiswa_nomor_hp') }}" name="mahasiswa_nomor_hp" required placeholder="Nomor HP">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal Lahir <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" value="{{ old('mahasiswa_tgl_lahir') }}" name="mahasiswa_tgl_lahir" required placeholder="Tanggal lahir">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Agama <span style="color: red;"></span></label>
                                <input type="text" class="form-control" value="{{ old('mahasiswa_agama') }}" name="mahasiswa_agama" required placeholder="Agama">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tanggal Penerimaan <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" value="{{ old('mahasiswa_tgl_penerimaan') }}" name="mahasiswa_tgl_penerimaan" required placeholder="Tanggal Penerimaan">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jenis Kelamin <span style="color: red;">*</span></label>
                                <select class="form-control" required name="mahasiswa_kelamin">
                                    <option value="">Pilih Jenis Kelamin </option>
                                    <option value="laki-laki">Laki Laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Dosen Wali <span style="color: red;">*</span></label>
                                <select class="form-control" required name="mahasiswa_dosen_id">
                                    <option value="">Pilih Dosen Wali</option>
                                    @foreach($daftarDosen as $value)
                                    <option value="{{ $value->dosen_id }}">{{ $value->dosen_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Prodi Mahasiswa<span style="color: red;">*</span></label>
                                <select class="form-control" required name="mahasiswa_prodi_id">
                                    <option value="">Pilih Prodi</option>
                                    @foreach($daftarProdi as $value)
                                    <option value="{{ $value->prodi_id }}">{{ $value->prodi_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Kelas <span style="color: red;">*</span></label>
                                <select class="form-control" required name="mahasiswa_kelas_id">
                                    <option value="">Pilih Kelas</option>
                                    @foreach($getKelas as $value)
                                    <option value="{{ $value->kelas_id }}">{{ $value->kelas_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Fakultas <span style="color: red;">*</span></label>
                                <select class="form-control" required name="mahasiswa_fakultas_id">
                                    <option value="">Pilih Fakultas</option>
                                    @foreach($daftarFakultas as $value)
                                    <option value="{{ $value->fakultas_id }}">{{ $value->fakultas_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>IPK <span style="color: red;"></span></label>
                                <input type="text" class="form-control" value="{{ old('mahasiswa_ipk') }}" name="mahasiswa_ipk" required placeholder="IPK">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password <span style="color: red;">*</span></label>
                            <input type="password" class="form-control" name="password" required placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label>Photo</label>
                            <div>
                                <input type="file" class="form-control-file" name="mahasiswa_foto" onchange="previewImage(event)">
                            </div>
                            <div class="mt-2">
                                <img id="preview" src="#" alt="Preview" style="max-width: 200px;">
                            </div>
                        </div>
                    </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
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

  <script>
    function previewImage(event) {
      var reader = new FileReader();
      reader.onload = function(){
        var preview = document.getElementById('preview');
        preview.src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>


@endsection
