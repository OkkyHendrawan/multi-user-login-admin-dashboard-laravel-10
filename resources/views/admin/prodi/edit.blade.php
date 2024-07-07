@extends('layout.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Data Prodi</h1>
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
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.prodi.update', ['prodi_id' => $prodi->prodi_id]) }}">
                                @csrf
                                @method('PUT') <!-- Menambahkan metode PUT -->
                                <div class="form-group">
                                    <label for="prodi_kode">Kode</label>
                                    <input type="text" class="form-control" id="prodi_kode" name="prodi_kode" value="{{ $prodi->prodi_kode }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="prodi_nama">Nama Prodi</label>
                                    <input type="text" class="form-control" id="prodi_nama" name="prodi_nama" value="{{ $prodi->prodi_nama }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="fakultas_nama">Nama Fakultas</label>
                                <select class="form-control" required name="prodi_fakultas_id">
                                    <option value="">Pilih Fakultas</option>
                                    @foreach($getFakultas as $fakultas)
                                        <option value="{{ $fakultas->fakultas_id }}" {{ $prodi->prodi_fakultas_id == $fakultas->fakultas_id ? 'selected' : '' }}>
                                            {{ $fakultas->fakultas_nama }}
                                        </option>
                                    @endforeach
                                </select>
                                </div>

                                <div class="form-group">
                                    <label for="prodi_status">Status Prodi</label>
                                    <select class="form-control" id="prodi_status" name="prodi_status" required>
                                        <option value="active" {{ $prodi->prodi_status == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ $prodi->prodi_status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
