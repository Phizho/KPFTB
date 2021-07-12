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
      <br />
      <label>Jenis surat keluar</label>
      <select name="jenis">
        <option value="1">Surat Keluar Dekan</option>
        <option value="2">Surat Keluar Wakil Dekan</option>
        <option value="3">Surat Keluar Kaprodi Magister Bioteknologi</option>
        <option value="4">Surat Kerja Sama</option>
        <option value="5">Surat Keputusan Dekan</option>
      </select>
      <br /><br />
      <label class="required">No Surat Keluar</label>
      <input type="input" class="form-control" name="noSurat" value='{{str_replace("-","/",$nsurat)}}' required>
      <br />
      <label class="required">Perihal</label>
      <input type="input" class="form-control" name="perihal" required>
      <br />
      <label class="required">Lampiran</label>
      <input type="input" class="form-control" name="lampiran" required>
      <br />
      <label class="required">Tanggal Kirim:</label>
      <input type="date" class="form-control" name="Tanggal" required>
      <br>
      <label class="required">Kepada</label>
      <input type="input" class="form-control" name="kepada" required>
      <br>
      <label class="required"> Isi Surat </label>
      <textarea name="isiSurat" id="isiSurat" rows="8" class="form-control" required></textarea>  
      <br/> 
      <input type="checkbox" name="tcheck[]" value="pTabel" id="tcheck" onclick="tOn()">
        <label>Gunakan Tabel?</label>
        <br/>
        <div id="hiddenTable" style="display: none;">
          <label class="required">Jumlah Baris</label>
          <input type="number" class="form-control" name="noRow" id="noRow" min="1">
          <br />
          <label class="required">Jumlah Kolom</label>
          <input type="number" class="form-control" name="noCol" id="noCol" min="1" max="6">
          <br/>
          <div>
            <button type="button" class="btn btn-primary" name="tambahTable" onclick="addTable()">Buat Tabel</button>
          </div>
          <br/>
          <table style='border: 1px solid black; border-collapse: collapse; width: 100%;' id="tbl">
          </table>
          <br/>
        </div>
        <label class="required"> Penutup Surat </label>
        <textarea name="penutup" id="penutup" rows="8" class="form-control" required></textarea>   
      <br/><br/>
      <div id="tempat_upload">
        <label>Upload Lampiran</label>     
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
var trNum = 0;
var tdNum = 0;

function addInputFile() {
  count+=1; 
  $html = `<input type="file" name="uploadfile${count}"  accept=".pdf,.jpg">`;
  $("#tempat_upload").append($html);
}

function CekCount()
{
    if ($('#count').length) {
      var x = document.getElementById("count");
      x.remove();
    }

    $html=`<input type="hidden" name="count" id="count" value='${count}'/>`; 
    for (i=1;i<=trNum;i++) {
      for (j=1;j<=tdNum;j++){
        var y = $(`#tr${i}td${j}`).html();
        $html += `<input type="hidden" name="instr${i}td${j}" id="instr${i}td${j}" value='${y}'/>`;
      }
  } 
  $('#tempat_upload').append($html);
}

function tOn() {
    var x = document.getElementById("hiddenTable");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }

function addTable() {

  if($('#tr1').length) {
    var k;
    var l;
    for (k = 1; k <= trNum; k++) {
      for (l=1; l <= tdNum; l++) {
        var obj = document.getElementById(`tr${k}td${l}`);
        obj.remove(); 
      }
      var myobj = document.getElementById(`tr${k}`);
      myobj.remove(); 
    }   
    var r = document.getElementById(`jumrow`);
    r.remove();
    var c = document.getElementById(`jumcol`);
    c.remove();
  }

  $row = document.getElementById("noRow").value;
  $col = document.getElementById("noCol").value;
  $htmlTbl = "";

  var i;
  var j;      

  for (i=1;i<=$row;i++) {
    $htmlTbl += `<tr id="tr${i}" style='border: 1px solid black; border-collapse: collapse;'>`;
    for (j=1;j<=$col;j++){
      if (i == 1) {
        $htmlTbl += `<td style="width: 200px; border: 1px solid black; border-collapse: collapse;"><div id="tr${i}td${j}" contenteditable><center><b>Judul Kolom</b></center></div></td>`;
      } else {
        $htmlTbl += `<td style="width: 200px; border: 1px solid black; border-collapse: collapse;"><div id="tr${i}td${j}" contenteditable></div></td>`;
      }
    }
    $htmlTbl += '</tr>';
  } 
  $('#tbl').append($htmlTbl);

  trNum = $row;
  tdNum = $col;

  $html = `<input type="hidden" name="jumrow" id="jumrow" value='${trNum}'/>
           <input type="hidden" name="jumcol" id="jumcol" value='${tdNum}'/>`;
  $('#tempat_upload').append($html);

}
</script>
@endsection