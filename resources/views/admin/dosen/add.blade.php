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
                    <h1>Tambah Dosen Baru</h1>
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
                        <form method="post" action="{{ route('admin.dosen.proses_create') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Nama Lengkap <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" value="{{ old('dosen_nama') }}" name="dosen_nama" required placeholder="Nama Lengkap ">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="dosen_npp">NPP:</label>
                                        <input type="text" name="dosen_npp" id="dosen_npp" class="form-control" value="{{ old('dosen_npp') }}">
                                        @error('dosen_npp')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Alamat <span style="color: red;"></span></label>
                                        <input type="text" class="form-control" value="{{ old('dosen_alamat') }}" name="dosen_alamat" required placeholder="Alamat">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Prodi Dosen <span style="color: red;">*</span></label>
                                        <select class="form-control" required name="dosen_prodi_id">
                                            <option value="">Pilih Prodi</option>
                                            @foreach($daftarProdi as $value)
                                            <option value="{{ $value->prodi_id }}">{{ $value->prodi_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Nomor HP <span style="color: red;"></span></label>
                                        <input type="text" class="form-control" value="{{ old('dosen_nomor_hp') }}" name="dosen_nomor_hp" required placeholder="Nomor HP">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Status <span style="color: red;">*</span></label>
                                        <select class="form-control" required name="dosen_status">
                                            <option value="">Pilih Status </option>
                                            <option value="active">Aktif</option>
                                            <option value="inactive">Tidak Aktif</option>
                                        </select>
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
                                        <input type="file" class="form-control-file" name="dosen_foto" onchange="previewImage(event)">
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
        reader.onload = function () {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>


@endsection
