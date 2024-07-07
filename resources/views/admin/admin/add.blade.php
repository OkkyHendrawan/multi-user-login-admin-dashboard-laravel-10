@extends ('layout.app')

@section('content')
 <!-- BS Stepper -->
 <link rel="stylesheet" href="{{ asset('/') }}assets/plugins/bs-stepper/css/bs-stepper.min.css">

<div class="content-wrapper">
    <!-- Header Konten (Header Halaman) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tambah Admin Baru</h1>
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
              <form method="post" action="{{ route ('admin.admin.proses_create')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" required placeholder="Nama Lengkap">
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"  required placeholder="Email">
                    <div style="color: red">{{ $errors->first('email') }}</div>
                  </div>
                  <div class="form-group">
                    <label>Kata Sandi</label>
                    <input type="password" class="form-control" name="password"  required placeholder="Kata Sandi">
                  </div>
                  <div class="form-group">
                    <label>Foto</label>
                    <div>
                      <input type="file" class="form-control-file" name="photo_path" onchange="previewImage(event)">
                    </div>
                    <div class="mt-2">
                      <img id="preview" src="#" alt="Pratinjau" style="max-width: 200px;">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Kirim</button>
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
      var reader = new FileReader();
      reader.onload = function(){
        var preview = document.getElementById('preview');
        preview.src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>

@endsection
