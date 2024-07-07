@extends('layout.app')

@section('content')

<style>
    .table-responsive {
        overflow-x: auto;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table th,
    .table td {
        white-space: nowrap;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Fakultas</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('fakultas.generate.excel') }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Ekspor ke Excel
                    </a>
                    <a href="{{ route('fakultas.generate.pdf') }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Ekspor ke PDF
                    </a>
                    <a href="{{ route('admin.fakultas.form_create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Fakultas
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('auth.message')
            <div class="card">
                <div class="card-header">
                    <h3>Daftar Fakultas (Total : {{ $fakultas->total() }})</h3>
                    </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Nama Fakultas</th>
                                    <th>Status Fakultas</th>
                                    <th>Di buat oleh</th>
                                    <th>Tanggal Buat</th>
                                    <th>Di update oleh</th>
                                    <th>Tanggal Update</th>
                                    <th>Di hapus oleh</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fakultas as $value)
                                <tr>
                                    <td>{{ $value->fakultas_id }}</td>
                                    <td>{{ $value->fakultas_kode }}</td>
                                    <td>{{ $value->fakultas_nama }}</td>
                                    <td>{{ $value->fakultas_status }}</td>
                                    <td>{{ $value->created_by }}</td>
                                    <td>{{ $value->created_at }}</td>
                                    <td>{{ $value->updated_by }}</td>
                                    <td>{{ $value->updated_at }}</td>
                                    <td>{{ $value->deleted_by_name }}</td>
                                    <td class="text-center">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{$value->fakultas_id}}">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal{{$value->fakultas_id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$value->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{$value->fakultas_id}}">Hapus Fakultas</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus fakultas berikut?</p>
                                                        <ul class="list-unstyled">
                                                            <li><strong>Kode Fakultas:</strong> {{ $value->fakultas_kode }}</li>
                                                            <li><strong>Nama Fakultas:</strong> {{ $value->fakultas_nama }}</li>
                                                            <li><strong>Status Fakultas:</strong> {{ $value->fakultas_Status }}</li>
                                                            <li><strong>Di buat oleh:</strong> {{ $value->created_by }}</li>
                                                            <li><strong>Tanggal Buat:</strong> {{ $value->created_at }}</li>
                                                            <li><strong>Di update oleh:</strong> {{ $value->updated_by }}</li>
                                                            <li><strong>Tanggal Update:</strong> {{ $value->updated_at }}</li>
                                                        </ul>
                                                        <p>Tindakan ini tidak dapat dibatalkan.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.fakultas.softDeleteFakultas', ['fakultas_id' => $value->fakultas_id]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="{{ route('admin.fakultas.edit', ['fakultas_id' => $value->fakultas_id]) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $fakultas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
