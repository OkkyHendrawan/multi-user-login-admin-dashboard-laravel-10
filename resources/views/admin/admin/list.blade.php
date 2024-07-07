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
     /* Gaya untuk modal */
     #imageModal {
        display: none; /* Sembunyikan modal secara default */
        position: fixed; /* Atur posisi modal agar tetap pada jendela */
        z-index: 9999; /* Tetapkan indeks tumpukan tinggi agar modal muncul di atas konten lain */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto; /* Aktifkan pengguliran jika konten melebihi ukuran modal */
        background-color: rgba(0, 0, 0, 0.7); /* Warna latar belakang dengan opasitas 70% */
    }

    /* Gaya untuk konten modal */
    .modal-content {
        margin: 15% auto; /* Atur jarak dari atas untuk memusatkan modal secara vertikal */
        background-color: #fefefe; /* Warna latar belakang konten modal */
        border: 1px solid #888;
        width: 80%; /* Atur lebar konten modal */
        border-radius: 10px; /* Bentuk sudut modal */
        position: relative; /* Atur posisi relatif untuk menempatkan tombol tutup */
    }

    /* Gaya untuk tombol tutup */
    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 28px;
        font-weight: bold;
        color: #888;
        cursor: pointer;
    }

    /* Gaya untuk gambar dalam modal */
    #modalImage {
        width: 100%; /* Atur lebar gambar agar mengisi konten modal */
        height: auto; /* Atur tinggi gambar agar sesuai dengan proporsinya */
        border-radius: 50%; /* Bentuk gambar menjadi lingkaran */
        display: block; /* Tampilkan gambar sebagai blok agar dapat menerapkan margin otomatis */
        margin: auto; /* Atur margin otomatis agar gambar muncul di tengah */
        max-width: 80%; /* Tetapkan lebar maksimum gambar */
        max-height: 80vh; /* Tetapkan tinggi maksimum gambar agar sesuai dengan tinggi viewport */
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Admin</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.generate.excel') }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Ekspor ke Excel
                    </a>
                    <a href="{{ route('admin.generate.pdf') }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Ekspor ke PDF
                    </a>
                    <a href="{{ route('admin.admin.form_create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Admin
                    </a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Search Form -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cari Admin</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.search') }}" method="GET">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Cari berdasarkan Nama">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Cari berdasarkan Email">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Cari</button>
                                <a href="{{ route('admin.search') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    @include('auth.message')

                    <div class="card">
                        <div class="card-header">
                            <h3>Daftar Admin (Total : {{ $admin->total() }})</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Foto</th>
                                            <th>Nama Lengkap</th>
                                            <th>Email</th>
                                            <th>Tanggal Buat</th>
                                            <th>Tanggal Update</th>
                                            <th colspan="3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($admin as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td class="text-center">
                                                @if($value->foto_path)
                                                <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin: auto;">
                                                    <img id="modalImage{{$value->id}}" src="{{ asset('admin/'.$value->foto_path) }}" alt="Foto Admin" style="width: 100%; height: 100%; object-fit: cover;" onclick="showImageModal('{{$value->id}}')">
                                                </div>
                                                @else
                                                    <p>Foto tidak tersedia</p>
                                                @endif
                                            </td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->created_at }}</td>
                                            <td>{{ $value->updated_at }}</td>
                                            <td>
                                                <a href="#" class="btn btn-info preview-btn" data-toggle="modal" data-target="#previewModal{{ $value->id }}">
                                                    <i class="fas fa-eye"></i> Pratinjau
                                                </a>
                                                <a href="{{ url('admin/admin/edit/'.$value->id) }}" class="btn btn-primary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $value->id }}">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {!! $admin->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                        </div>
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

@foreach($admin as $value)
<!-- Modal Preview -->
<div class="modal fade" id="previewModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel{{ $value->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel{{ $value->id }}">Pratinjau Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Nama:</strong> {{ $value->name }}</p>
                <p><strong>Email:</strong> {{ $value->email }}</p>
                <p><strong>Tanggal Buat:</strong> {{ $value->created_at }}</p>
                <p><strong>Tanggal Update:</strong> {{ $value->updated_at }}</p>
                <p><strong>Foto:</strong></p>
                <p>{{$value->foto_path}}</p>
                @if($value->foto_path)
                <img src="{{ asset('admin/'.$value->foto_path) }}" alt="Foto Admin" style="max-width: 100%;">
                @else
                <p>Foto tidak tersedia</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($admin as $value)
<!-- Modal Delete -->
<div class="modal fade" id="deleteModal{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $value->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $value->id }}">Hapus Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus admin berikut?</p>
                <ul class="list-unstyled">
                    <li><strong>Nama Admin:</strong> {{ $value->name }}</li>
                    <li><strong>Email:</strong> {{ $value->email }}</li>
                    <li><strong>Tanggal Buat:</strong> {{ $value->created_at }}</li>
                    <li><strong>Tanggal Update:</strong> {{ $value->updated_at }}</li>
                </ul>
                <p>Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="{{ url('admin/admin/delete/'.$value->id) }}" class="btn btn-danger">Ya, Hapus</a>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- Image Modal -->
<div id="imageModal" class="modal" onclick="closeModal()">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<script>
    function showImageModal(id) {
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("modalImage");
    var img = document.getElementById("modalImage" + id);

    modal.style.display = "block"; // Tampilkan modal
    modalImg.src = img.src; // Setel sumber gambar modal

    // Atur properti CSS gambar modal
    modalImg.style.width = "80%"; // Atur lebar gambar menjadi 80% dari lebar modal
    modalImg.style.maxWidth = "600px"; // Tetapkan lebar maksimum gambar
}


    function closeModal() {
        var modal = document.getElementById("imageModal");
        modal.style.display = "none"; // Sembunyikan modal saat tombol tutup diklik
    }
</script>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // When preview button is clicked, show the corresponding modal
        $('.preview-btn').click(function() {
            var modalId = $(this).data('target');
            $(modalId).modal('show');
        });
    });
</script>

@endsection
