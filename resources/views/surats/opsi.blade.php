@extends('layout.conquer')

@section('tempat_titleatas')
<title>Surat Keluar</title>
@endsection

@section('tempat_judul')
<p style="text-align: center;">Ubah Data Dekan</p>
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
  <form method="POST" action="{{ route('surats.updateOpsi') }}" formtarget="_blank" target="_blank"  enctype="multipart/form-data">
  @csrf
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Nama Lengkap Dekan:</label>
      <div class="col-sm-2">
        <input type="input" class="form-control" name="Dekan" value='{{$namaDekan}}' style="width: 300px;" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="bold col-sm-2 col-form-label">Tanda Tangan Dekan:</label>
      <div class="col-sm-2">
        <input type="file" name="uploadfileDekan" class="form-control" style="width: 300px;" accept=".png">
      </div>
    </div> 
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Nama Lengkap Wakil Dekan:</label>
      <div class="col-sm-2">
        <input type="input" class="form-control" name="WakilDekan" value='{{$namaWakilDekan}}' style="width: 300px;" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="bold col-sm-2 col-form-label">Tanda Tangan Wakil Dekan:</label>
      <div class="col-sm-2">
        <input type="file" name="uploadfileWakil" class="form-control" style="width: 300px;" accept=".png">
      </div>
    </div> 
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Nama Lengkap Magister Kaprodi:</label>
      <div class="col-sm-2">
        <input type="input" class="form-control" name="MagisterKaprodi" value='{{$namaMagisterKaprodi}}' style="width: 300px;" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="bold col-sm-2 col-form-label">Tanda Tangan Magister Kaprodi:</label>
      <div class="col-sm-2">
       <input type="file" name="uploadfileKaprodi" class="form-control" style="width: 300px;" accept=".png">
      </div>
    </div> 
    <input type="submit" class="btn btn-primary" value="Simpan" name="submit" onclick="">
  </form>
  
  
</body>
@endsection

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
</script>