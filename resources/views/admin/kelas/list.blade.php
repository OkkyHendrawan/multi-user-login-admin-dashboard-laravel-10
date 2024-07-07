@extends('layout.app')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Kelas</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.kelas.form_create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Kelas
                    </a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('auth.message')
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Kelas Nama</th>
                                            <th>Di Buat Oleh</th>
                                            <th>Tanggal Buat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kelas as $value)
                                        <tr>
                                            <td>{{ $value->kelas_id }}</td>
                                            <td>{{ $value->kelas_nama }}</td>
                                            <td>{{ $value->created_by_name }}</td>
                                            <td>{{ $value->created_at }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
