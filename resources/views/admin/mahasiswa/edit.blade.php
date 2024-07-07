@extends('layout.app')

@section('content')
<!-- BS Stepper -->
<link rel="stylesheet" href="{{ asset('/') }}assets/plugins/bs-stepper/css/bs-stepper.min.css">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Data Mahasiswa</h1>
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
                        <form method="POST" action="{{ route('admin.mahasiswa.update', ['mahasiswa_id' => $mahasiswa->mahasiswa_id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Nama Lengkap <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" value="{{ $mahasiswa->mahasiswa_nama }}" name="mahasiswa_nama" required placeholder="Nama Lengkap ">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>NBI <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" value="{{ $mahasiswa->mahasiswa_nbi }}" name="mahasiswa_nbi" required placeholder="NPP">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Status <span style="color: red;">*</span></label>
                                        <select class="form-control" required name="mahasiswa_status">
                                            <option value="">Pilih Status </option>
                                            <option value="active" {{ $mahasiswa->mahasiswa_status == 'active' ? 'selected' : '' }}>Aktif</option>
                                            <option value="inactive" {{ $mahasiswa->mahasiswa_status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Alamat <span style="color: red;"></span></label>
                                        <input type="text" class="form-control" value="{{ $mahasiswa->mahasiswa_alamat }}" name="mahasiswa_alamat" required placeholder="Alamat">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Nomor Hp <span style="color: red;"></span></label>
                                        <input type="text" class="form-control" value="{{ $mahasiswa->mahasiswa_nomor_hp }}" name="mahasiswa_nomor_hp" required placeholder="Nomor Hp">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tanggal Lahir <span style="color: red;">*</span></label>
                                        <input type="date" class="form-control" value="{{ $mahasiswa->mahasiswa_tgl_lahir }}" name="mahasiswa_tgl_lahir" required placeholder="Tanggal lahir">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Agama <span style="color: red;"></span></label>
                                        <input type="text" class="form-control" value="{{ $mahasiswa->mahasiswa_agama }}" name="mahasiswa_agama" required placeholder="Agama">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tanggal Penerimaan <span style="color: red;">*</span></label>
                                        <input type="date" class="form-control" value="{{ $mahasiswa->mahasiswa_tgl_penerimaan }}" name="mahasiswa_tgl_penerimaan" required placeholder="Tanggal Penerimaan">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Jenis Kelamin <span style="color: red;">*</span></label>
                                        <select class="form-control" required name="mahasiswa_kelamin">
                                            <option value="">Pilih Status </option>
                                            <option value="laki-laki" {{ $mahasiswa->mahasiswa_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki Laki</option>
                                            <option value="perempuan" {{ $mahasiswa->mahasiswa_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Dosen Wali <span style="color: red;">*</span></label>
                                        <select class="form-control" required name="mahasiswa_dosen_id">
                                            <option value="">Pilih Dosen Wali</option>
                                            @foreach($daftarDosen as $value)
                                                <option value="{{ $value->dosen_id }}" {{ $mahasiswa->mahasiswa_dosen_id == $value->dosen_id ? 'selected' : '' }}>{{ $value->dosen_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Kelas <span style="color: red;">*</span></label>
                                        <select class="form-control" required name="mahasiswa_kelas_id">
                                            <option value="">Pilih Kelas</option>
                                            @foreach($getKelas as $value)
                                                <option value="{{ $value->kelas_id }}" {{ $mahasiswa->mahasiswa_kelas_id == $value->kelas_id ? 'selected' : '' }}>{{ $value->kelas_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Prodi Mahasiswa <span style="color: red;">*</span></label>
                                        <select class="form-control" required name="mahasiswa_prodi_id">
                                            <option value="">Pilih Prodi</option>
                                            @foreach($daftarProdi as $value)
                                                <option value="{{ $value->prodi_id }}" {{ $mahasiswa->mahasiswa_prodi_id == $value->prodi_id ? 'selected' : '' }}>{{ $value->prodi_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Fakultas Mahasiswa <span style="color: red;">*</span></label>
                                        <select class="form-control" required name="mahasiswa_fakultas_id">
                                            <option value="">Pilih Fakultas</option>
                                            @foreach($daftarFakultas as $value)
                                                <option value="{{ $value->fakultas_id }}" {{ $mahasiswa->mahasiswa_fakultas_id == $value->fakultas_id ? 'selected' : '' }}>{{ $value->fakultas_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>IPK <span style="color: red;"></span></label>
                                        <input type="text" class="form-control" value="{{ $mahasiswa->mahasiswa_ipk }}" name="mahasiswa_ipk" required placeholder="IPK">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Email <span style="color: red;">*</span></label>
                                    <input type="email" class="form-control" name="email" value="{{ $mahasiswa->email }}" required placeholder="Email">
                                    <div style="color: red">{{ $errors->first('email') }}</div>
                                </div>
                                <div class="form-group">
                                    <label>Kata Sandi</label>
                                    <input type="password" class="form-control" name="password" placeholder="Kata Sandi">
                                    <p>Apakah Anda ingin mengubah kata sandi? Jika ya, tambahkan kata sandi baru.</p>
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    @if($mahasiswa->mahasiswa_foto)
                                        <img id="preview" src="{{ asset('mahasiswa/'.$mahasiswa->mahasiswa_foto) }}" alt="Foto Mahasiswa" style="max-width: 15%;">
                                    @else
                                        <p>Tidak ada foto tersedia</p>
                                    @endif
                                    <input type="file" class="form-control" name="mahasiswa_foto" onchange="previewImage(event)">
                                    <p>Unggah foto baru jika ingin menggantinya.</p>
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
        reader.onload = function () {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>


@endsection
