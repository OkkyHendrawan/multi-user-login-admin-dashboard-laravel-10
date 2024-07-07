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
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Dosen</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('prodi.generate.excel') }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Ekspor ke Excel
                    </a>
                    <a href="{{ route('prodi.generate.pdf') }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Ekspor ke PDF
                    </a>
                    <a href="{{ route('admin.dosen.form_create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Dosen
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
                    <h3>Daftar Dosen (Total : {{ $dosen->total() }})</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('dosen.search') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="dosen_nama" class="form-control" placeholder="Cari Nama Dosen">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" placeholder="Cari Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Cari</button>
                                <a href="{{ route('admin.dosen.list') }}" class="btn btn-secondary">Reset</a>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="prodi_id">Pilih Prodi:</label>
                                    <select name="prodi_id" id="prodi_id" class="form-control">
                                        <option value="">-- Pilih Prodi --</option>
                                        @foreach($prodi->where('is_delete', 0) as $p)
                                        <option value="{{ $p->prodi_id }}">{{ $p->prodi_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th> <!-- Kolom untuk menampilkan foto -->
                                    <th>NPP</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Nomor Hp</th>
                                    <th>Status Dosen</th>
                                    <th>Alamat</th>
                                    <th>Prodi Dosen</th>
                                    <th>Di buat oleh</th>
                                    <th>Tanggal Buat</th>
                                    <th>Di update oleh</th>
                                    <th>Tanggal Update</th>
                                    <th>Di hapus oleh</th>
                                    <th colspan="3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dosen as $value)
                                <tr>
                                    <td>{{ $value->dosen_id }}</td>
                                    <td class="text-center">
                                        @if($value->dosen_foto)
                                            <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin: auto;">
                                                <img src="{{ asset('dosen/'.$value->dosen_foto) }}" alt="Foto Dosen" style="width: 100%; height: 100%; object-fit: cover;" onclick="showImageModal('modalImage{{$value->dosen_id}}')">
                                            </div>
                                        @else
                                            <p>Foto tidak tersedia</p>
                                        @endif
                                    </td>
                                    <td>{{ $value->dosen_npp }}</td>
                                    <td>{{ $value->dosen_nama }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->dosen_nomor_hp }}</td>
                                    <td>{{ $value->dosen_status }}</td>
                                    <td>{{ $value->dosen_alamat }}</td>
                                    <td>{{ $value->prodi->prodi_nama }}</td> <!-- Tambahkan kolom prodi -->
                                    <td>{{ $value->created_by }}</td>
                                    <td>{{ $value->created_at }}</td>
                                    <td>{{ $value->updated_by }}</td>
                                    <td>{{ $value->updated_at }}</td>
                                    <td>{{ $value->deleted_by_name }}</td>

                                    <td class="text-center">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#previewModal{{ $value->dosen_id }}">
                                            <i class="fas fa-eye"></i> Pratinjau
                                        </button>

                                        <!-- Modal Preview -->
                                        <div class="modal fade" id="previewModal{{ $value->dosen_id }}" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel{{ $value->dosen_id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="previewModalLabel{{ $value->dosen_id }}">Pratinjau Dosen</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>NPP:</strong> {{ $value->dosen_npp }}</p>
                                                        <p><strong>Nama Lengkap:</strong> {{ $value->dosen_nama }}</p>
                                                        <p><strong>Email:</strong> {{ $value->email }}</p>
                                                        <p><strong>Nomor Hp:</strong> {{ $value->dosen_nomor_hp }}</p>
                                                        <p><strong>Status Dosen:</strong> {{ $value->dosen_status }}</p>
                                                        <p><strong>Alamat:</strong> {{ $value->dosen_alamat }}</p>
                                                        <p><strong>Prodi Dosen:</strong> {{ $value->prodi ? $value->prodi->prodi_nama : 'Tidak terhubung dengan Prodi' }}</p>
                                                        <p><strong>Di buat oleh:</strong> {{ $value->created_by }}</p>
                                                        <p><strong>Tanggal Buat:</strong> {{ $value->created_at }}</p>
                                                        <p><strong>Di update oleh:</strong> {{ $value->updated_by }}</p>
                                                        <p><strong>Tanggal Update:</strong> {{ $value->updated_at }}</p>
                                                        <p><strong>Di hapus oleh:</strong> {{ $value->deleted_by_name }}</p>
                                                        <p><strong>Foto:</strong></p>
                                                        @if($value->dosen_foto)
                                                            <img src="{{ asset('dosen/'.$value->dosen_foto) }}" alt="Foto Dosen" style="max-width: 100%;" id="modalImage{{$value->dosen_id}}">
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

                                        <a href="{{ route('admin.dosen.edit', ['dosen_id' => $value->dosen_id]) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $value->dosen_id }}">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal{{ $value->dosen_id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $value->dosen_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{$value->dosen_id}}">Hapus Data Dosen</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus dosen berikut?</p>
                                                        <ul class="list-unstyled">
                                                            <li><strong>NPP:</strong> {{ $value->dosen_npp }}</li>
                                                            <li><strong>Nama Lengkap:</strong> {{ $value->dosen_nama }}</li>
                                                            <li><strong>Email:</strong> {{ $value->email }}</li>
                                                            <li><strong>Status Dosen:</strong> {{ $value->dosen_status }}</li>
                                                            <li><strong>Alamat:</strong> {{ $value->dosen_alamat }}</li>
                                                            <li><strong>Dosen Prodi:</strong> {{ $value->prodi ? $value->prodi->prodi_nama : 'Tidak terhubung dengan Prodi' }}</li>
                                                            <li><strong>Di buat oleh:</strong> {{ $value->created_by }}</li>
                                                            <li><strong>Tanggal Buat:</strong> {{ $value->created_at }}</li>
                                                            <li><strong>Di update oleh:</strong> {{ $value->updated_by }}</li>
                                                            <li><strong>Tanggal Update:</strong> {{ $value->updated_at }}</li>
                                                            <li><strong>Di hapus oleh:</strong> {{ $value->deleted_by_name }}</li>
                                                            <p><strong>Foto:</strong></p>
                                                            @if($value->dosen_foto)
                                                                <img src="{{ asset('dosen/'.$value->dosen_foto) }}" alt="Foto Dosen" style="max-width: 100%;">
                                                            @else
                                                                <p>Foto tidak tersedia</p>
                                                            @endif
                                                        </ul>
                                                        <p>Tindakan ini tidak dapat dibatalkan.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.dosen.softDeleteDosen', ['dosen_id' => $value->dosen_id]) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $dosen->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Image Modal -->
<div id="imageModal" class="modal" onclick="closeModal()">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<script>
    function showImageModal(imageId) {
        var modal = document.getElementById("imageModal");
        var modalImg = document.getElementById("modalImage");
        modal.style.display = "block"; // Tampilkan modal
        modalImg.src = document.getElementById(imageId).src; // Setel sumber gambar modal

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
