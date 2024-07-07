@extends('layout.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Fakultas</h1>
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
                            <form method="POST" action="{{ route('admin.fakultas.update', ['fakultas_id' => $fakultas->fakultas_id]) }}">
                                @csrf
                                @method('PUT') <!-- Menambahkan metode PUT -->
                                <div class="form-group">
                                    <label for="fakultas_kode">Kode</label>
                                    <input type="text" class="form-control" id="fakultas_kode" name="fakultas_kode" value="{{ $fakultas->fakultas_kode }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="fakultas_nama">Nama Fakultas</label>
                                    <input type="text" class="form-control" id="fakultas_nama" name="fakultas_nama" value="{{ $fakultas->fakultas_nama }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="fakultas_status">Status Fakultas</label>
                                    <select class="form-control" id="fakultas_status" name="fakultas_status" required>
                                        <option value="active" {{ $fakultas->fakultas_status == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ $fakultas->fakultas_status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
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
