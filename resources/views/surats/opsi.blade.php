@extends('layout.conquer')

@section('tempat_titleatas')
<title>Surat Keluar</title>
@endsection

@section('tempat_judul')
<p style="text-align: center;">DAFTAR SURAT KELUAR</p>
@endsection

@section('tempat_konten')

@if (session('status'))
<div class="alert alert-success" role="alert">
  {{ session('status') }}
</div>
@endif

<head>
</head>

<body>
  <label class="required">Nama Lengkap Dekan</label>
  <input type="input" class="form-control" name="wakilRkn">
  <label class="required">Nama Lengkap Wakil Dekan</label>
  <input type="input" class="form-control" name="wakilRkn">
  <label class="required">Nama Lengkap Magister Kaprodi</label>
  <input type="input" class="form-control" name="wakilRkn">
  
</body>
@endsection

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  function showSearch() {
    var x = document.getElementById("search");
    var but = document.getElementById("button-search")
    if (x.style.display === "none") {
      x.style.display = "block";
      but.style.display = "none";
    } else {
      x.style.display = "none";
      but.style.display = "block";
    }
  }
</script>