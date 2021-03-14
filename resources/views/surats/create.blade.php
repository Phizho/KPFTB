@extends('layout.conquer')

@section('tempat_titleatas')
<title>Pembuatan Surat Keluar</title>
@endsection

@section('tempat_judul')
<p style="text-align: center;">TAMBAH DATA SURAT KELUAR</p>
@endsection

@section('tempat_konten')
<head>
<a href="{{route('surats.index')}}">
  Kembali</a>
</head>

<body>
  <form method="POST" action="#" enctype="multipart/form-data">
    <div class="form-group">
      <label class="required">No Surat Keluar</label>
      <input type="input" class="form-control" name="noSurat" required>
      <br />
      <label class="required">Perihal</label>
      <input type="input" class="form-control" name="perihal" required>
      <br />
      <label class="required">Tanggal:</label>
      <input type="date" class="form-control" name="Tanggal">
      <br>
      <label class="required"> Isi Surat </label>
      <textarea name="isiSurat" id="isiSurat" rows="8" class="form-control"></textarea>  
      <br/> 
      <label>Jenis surat keluar</label>
      <select name="jenis">
        <option value="1">Surat Keluar Dekan</option>
        <option value="2">Surat Keluar Wakil Dekan</option>
        <option value="3">Surat Keluar Kaprodi Magister Bioteknologi</option>
        <option value="4">Surat Kerja Sama</option>
        <option value="5">Surat Keputusan Dekan</option>
      </select>
      <br/>
      <label>Upload Lampiran</label>
      <input type="file" name="uploadfile" accept=".pdf,.jpg">
      <h5>Format file PDF/JPG</h5>
      <br />
      <br><br>
      <input type="submit" class="btn btn-primary" value="Simpan Surat" name="submit">
    </div>
  </form>

</body>
@endsection