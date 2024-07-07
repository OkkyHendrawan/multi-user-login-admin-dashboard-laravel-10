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
                    <h1>Edit Data Dosen</h1>
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
                        <form method="POST" action="{{ route('admin.dosen.update', ['dosen_id' => $dosen->dosen_id]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Nama Lengkap <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" value="{{ $dosen->dosen_nama }}" name="dosen_nama" required placeholder="Nama Lengkap ">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>NPP <span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" value="{{ $dosen->dosen_npp }}" name="dosen_npp" required placeholder="NPP">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Alamat <span style="color: red;"></span></label>
                                        <input type="text" class="form-control" value="{{ $dosen->dosen_alamat }}" name="dosen_alamat" required placeholder="Alamat">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Prodi Dosen <span style="color: red;">*</span></label>
                                        <select class="form-control" required name="dosen_prodi_id">
                                            <option value="">Pilih Prodi</option>
                                            @foreach($daftarProdi as $value)
                                                <option value="{{ $value->prodi_id }}" {{ $dosen->dosen_prodi_id == $value->prodi_id ? 'selected' : '' }}>{{ $value->prodi_nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Nomor HP <span style="color: red;"></span></label>
                                        <input type="text" class="form-control" value="{{ $dosen->dosen_nomor_hp }}" name="dosen_nomor_hp" required placeholder="Nomor HP">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Status <span style="color: red;">*</span></label>
                                        <select class="form-control" required name="dosen_status">
                                            <option value="">Pilih Status </option>
                                            <option value="active" {{ $dosen->dosen_status == 'active' ? 'selected' : '' }}>Aktif</option>
                                            <option value="inactive" {{ $dosen->dosen_status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email <span style="color: red;">*</span></label>
                                    <input type="email" class="form-control" name="email" value="{{ $dosen->email }}" required placeholder="Email">
                                    <div style="color: red">{{ $errors->first('email') }}</div>
                                </div>
                                <div class="form-group">
                                    <label>Kata Sandi</label>
                                    <input type="password" class="form-control" name="password" placeholder="Kata Sandi">
                                    <p>Apakah Anda ingin mengubah kata sandi? Jika ya, tambahkan kata sandi baru.</p>
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    @if($dosen->dosen_foto)
                                        <img id="preview" src="{{ asset('dosen/'.$dosen->dosen_foto) }}" alt="Foto Dosen" style="max-width: 15%;">
                                    @else
                                        <p>Tidak ada foto tersedia</p>
                                    @endif
                                    <input type="file" class="form-control" name="dosen_foto" onchange="previewImage(event)">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $('#fakultas').change(function () {
            var fakultasId = $(this).val();

            if (fakultasId) {
                $.ajax({
                    type: "GET",
                    url: "/getProdiByFakultas/" + fakultasId,
                    success: function (response) {
                        $('#prodi').empty();
                        if (response.length > 0) {
                            $.each(response, function (key, value) {
                                $('#prodi').append('<option value="' + value.prodi_id + '">' + value.prodi_nama + '</option>');
                            });
                        } else {
                            $('#prodi').append('<option value="">Tidak ada program studi yang tersedia</option>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#prodi').empty();
            }
        });
    });
</script>


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
