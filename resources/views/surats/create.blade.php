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
  <form method="POST" action="{{ route('surats.store') }}" formtarget="_blank" target="_blank" enctype="multipart/form-data">
    <div class="form-group">
      @csrf
      <label class="required">No Surat Keluar</label>
      <input type="input" class="form-control" name="noSurat" required>
      <br />
      <label class="required">Perihal</label>
      <input type="input" class="form-control" name="perihal" required>
      <br />
      <label class="required">Tanggal Kirim:</label>
      <input type="date" class="form-control" name="Tanggal" required>
      <br>
      <label class="required"> Isi Surat </label>
      <textarea name="isiSurat" id="isiSurat" rows="8" class="form-control" required></textarea>  
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
      <div id="tempat_upload">
        <label>Upload Lampiran</label>
        <input type="file" name="uploadfile1" accept=".pdf,.jpg">       
      </div>
      <h5>Format file PDF/JPG</h5>
      <div>
      <button type="button" class="btn btn-primary" name="tambahLampiran" onclick="addInputFile()">Tambah Lampiran</button>
      </div>
      <br/>
      <input type="submit" class="btn btn-primary" value="Simpan Surat" name="submit" onclick="CekCount()">
    </div>
  </form>

</body>

<script>
var count = 0 ;

function addInputFile() {
  count+=1; 
  $html = `<input type="file" name="uploadfile${count}"  accept=".pdf,.jpg">`;
  $("#tempat_upload").append($html);
}

function CekCount()
{
    $html=`<input type="hidden" name="count" id="count" value='${count}'/>`; 
    $('#tempat_upload').append($html);
}
</script>
@endsection