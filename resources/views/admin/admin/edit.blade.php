@extends ('layout.app')

@section('content')

<div class="content-wrapper">
    <!-- Header Konten (Header Halaman) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Data Admin</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Konten Utama -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <form method="post" action=""enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" value="{{ $getRecord->name }}" required placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $getRecord->email }}" required placeholder="Email">
                        <div style="color: red">{{ $errors->first('email') }}</div>
                    </div>
                    <div class="form-group">
                        <label>Kata Sandi</label>
                        <input type="password" class="form-control" name="password" placeholder="Kata Sandi">
                        <p>Apakah Anda ingin mengubah kata sandi? Jika ya, tambahkan kata sandi baru.</p>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        @if($getRecord->foto_path)
                            <img id="preview" src="{{ asset('admin/'.$getRecord->foto_path) }}" alt="Foto Admin" style="max-width: 15%;">
                        @else
                            <p>Tidak ada foto tersedia</p>
                        @endif
                        <input type="file" class="form-control" name="admin_foto" onchange="previewImage(event)">
                        <p>Unggah foto baru jika ingin menggantinya.</p>
                    </div>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
              </form>
            </div>

          </div>
          <!--/.col (left) -->
          <!-- kolom kanan -->
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <script>
    function previewImage(event) {
        var preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(event.target.files[0]);
    }
</script>

@endsection
