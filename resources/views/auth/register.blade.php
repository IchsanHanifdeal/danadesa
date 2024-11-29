<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | {{ $title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('temp/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('temp/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('temp/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box mt-3">
        <div class="login-logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="max-height: 100px; max-width:100px">
            <a href="{{ route('login') }}"><b>{{ config('app.name') }}</b>{{ $title }}</a>
        </div>
        <!-- /.login-logo -->
        <div class="card mb-5">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login untuk mengakses fitur</p>

                <form action="{{ route('store_penduduk') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="file" name="foto_profil" class="custom-file-input" id="foto_profil"
                            onchange="previewFile(this);" required>
                        <label class="custom-file-label" for="foto_profil">Pilih Foto Profil</label>
                        <img id="preview" src="#" alt="Preview Foto Profil" class="img-fluid"
                            style="display:none;" />
                    </div>

                    <div class="input-group mb-3">
                        <input type="number" class="form-control @error('nik') is-invalid @enderror" name="nik"
                            id="nik" placeholder="NIK (16 karakter)" value="{{ old('nik') }}" required
                            minlength="16" maxlength="16">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="nama_depan" id="nama_depan"
                            placeholder="Nama Depan" value="{{ old('nama_depan') }}">
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="nama_belakang" id="nama_belakang"
                            placeholder="Nama Belakang" value="{{ old('nama_belakang') }}">
                    </div>

                    <div class="input-group mb-3">
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                            <option value="">--- Pilih Jenis Kelamin ---</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                            placeholder="Tempat Lahir">
                    </div>

                    <div class="input-group mb-3">
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir"
                            placeholder="Tanggal Lahir">
                    </div>

                    <div class="input-group mb-3">
                        <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat" cols="4"></textarea>
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            id="email" placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" id="password" placeholder="Password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password_confirmation"
                            id="password_confirmation" placeholder="Konfirmasi Password" required>
                    </div>

                    <div class="row d-flex justify-content-end">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                        </div>
                    </div>

                    <hr>
                    <p>Sudah punya akun? <b><a href="{{ route('login') }}"> Masuk!</a></b></p>
                </form>
                <!-- /.social-auth-links -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('temp/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('temp/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('temp/dist/js/adminlte.min.js') }}"></script>

    <script>
        function previewFile(input) {
            var file = input.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('preview').style.display = 'block';
                };
                reader.readAsDataURL(file);

                input.nextElementSibling.textContent = file.name;
            }
        }
    </script>
</body>

</html>
