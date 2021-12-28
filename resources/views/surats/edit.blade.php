@extends('layout.conquer')

@section('tempat_titleatas')
<title>Edit Surat Keluar</title>
@endsection

@section('tempat_judul')
<p style="text-align: center;">UBAH DATA SURAT KELUAR</p>
@endsection

@section('tempat_konten')
<head>
<a href="{{route('surats.index')}}">
  Kembali</a>
</head>
<script>
var count = 0;
</script>

<body onload="mulai()">
  <form method="POST" action="{{url('surats/'.$s[0]->nomor_surat)}}" formtarget="_blank" target="_blank" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <br />
    <div class="form-group row">
      <label for="jenis" class="bold col-sm-2 col-form-label">Jenis surat keluar:</label>
      <div class="col-sm-4">
        <select name="jenis" id="jenis" class="form-control">
          <option value="1">Surat Keluar Dekan</option>
          <option value="2">Surat Keluar Wakil Dekan</option>
          <option value="3">Surat Keluar Kaprodi Magister Bioteknologi</option>
        </select>
      </div>
    </div>
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label" for="noSurat">No Surat Keluar:</label>
      <div class="col-sm-4">
        <input type="input" id="noSurat" class="form-control" name="noSurat" value='{{str_replace("-","/",$s[0]->nomor_surat)}}' style="width:200px;" required/>
      </div>
    </div>
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label" for="Tanggal">Tanggal Kirim:</label>
      <div class="col-sm-2">
        <input type="date" class="form-control" name="Tanggal" id="Tanggal" value="{{ date('Y-m-d', strtotime($s[0]->tanggal_kirim)) }}" required/>
      </div>
    </div>
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Perihal:</label>
      <div class="col-sm-4">
        <input type="input" class="form-control" name="perihal" value="{{$s[0]->perihal}}" required>
      </div>
    </div>
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Lampiran:</label>
      <div class="col-sm-2">
        <input type="input" class="form-control" name="lampiran" value ="{{$la}}" required>
      </div> 
    </div>  
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Kepada:</label>
      <div class="col-sm-3">
        <input type="input" class="form-control" name="kepada" value="{{$kepada}}" required>
      </div> 
    </div>
    <br/>
    <label class="required bold"> Isi Surat </label>
    <textarea name="isiSurat" id="isiSurat" rows="8" class="form-control"  required>{{$isiSurat}}</textarea>  
    <br/> 
    <input type="checkbox" name="tcheck[]" value="pTabel" id="tcheck" onclick="tOn()" @if ($counttable > 1 ) checked @endif>
      <label>Gunakan Tabel?</label>
      <br/>
      <div id="hiddenTable" style="display: none;">
        <label class="required">Jumlah Baris</label>
        <input type="input" class="form-control" name="noRow" id="noRow" min="1">
        <br />
        <label class="required">Jumlah Kolom</label>
        <input type="input" class="form-control" name="noCol" id="noCol" min="1" max="6">
        <br/>
        <div>
          <button type="button" class="btn btn-primary" name="tambahTable" onclick="addTable()">Buat Tabel baru</button>
        </div>
        <br/>
        <table style='border: 1px solid black; border-collapse: collapse;  width: 100%;' id="tbl">
        </table>
      </div>
      <br/>
      <label class="required bold"> Penutup Surat </label>
      <textarea name="penutup" id="penutup" rows="8" class="form-control" required>{{$penutup}}</textarea>  
    <br/><br/>
    <div id="tempat_upload">
    <input type="hidden" name="tglbuat" id="tglbuat" value='{{$s[0]->created_at}}'/>
      <label>Upload Lampiran</label>  
      @isset($arrayNama) 
      <script>
          count = <?php echo json_encode(count($arrayNama)); ?>;
      </script>
        @for($i=1;$i<=count($arrayNama); $i++)
        <div>
          <input type="file" name="uploadfile{{$i}}" id="uploadfile{{$i}}" onchange="changeLampText(this.id)" style="display: none;" accept=".pdf,.jpg">
          <label style="color: blue; text-decoration: underline;" for="uploadfile{{$i}}" value="{{$arrayNama[$i-1]}}.{{$arrayExtension[$i-1]}}">{{$i}}. {{$arrayNama[$i-1]}} (Klik disini untuk mengubah)</label>
          <input type="hidden" name="lampuploadfile{{$i}}" id="lampuploadfile{{$i}}" value='{{$arrayNama[$i-1]}}.{{$arrayExtension[$i-1]}}'/>
        </div>
        @endfor
      @endisset
    </div>
    <h5>Format file PDF/JPG</h5>
    <div>
    <button type="button" class="btn btn-primary" name="tambahLampiran" onclick="addInputFile()">Tambah Lampiran</button>
    </div>
    <br/>
    <input type="submit" class="btn btn-primary" value="Simpan Surat" name="submit" onclick="CekCount()">
  </form>
</body>

<script>
var trNum = 0;
var tdNum = 0;

function mulai() {
  var counttable = <?php echo json_encode($counttable) ?>;
  var countrow = parseInt(<?php echo json_encode($countrow) ?>);

  if (counttable > 1) {
    var x = document.getElementById("hiddenTable");
    x.style.display = "block";
    
    var currentData = 1;

    var arraytable = <?php echo json_encode($arraytable) ?>;
    var countcol = parseInt(counttable/2)/(countrow - 1);
    document.getElementById("noRow").value = countrow - 1;
    document.getElementById("noCol").value = countcol;
    $htmlTbl = "";

    for (i=1;i<countrow;i++) {
      $htmlTbl += `<tr id="tr${i}" style='border: 1px solid black; border-collapse: collapse;'>`;
      for (j=1;j<=countcol;j++){
        $htmlTbl += `<td style="width: 200px; border: 1px solid black; border-collapse: collapse;"><div id="tr${i}td${j}" contenteditable>${arraytable[currentData]}</div></td>`;
        currentData += 2;
      }
      $htmlTbl += '</tr>';
  } 

    $('#tbl').append($htmlTbl);

    trNum = countrow-1;
    tdNum = countcol;

    $html = `<input type="hidden" name="jumrow" id="jumrow" value='${trNum}'/>
            <input type="hidden" name="jumcol" id="jumcol" value='${tdNum}'/>`;
    $('#tempat_upload').append($html);
    }
}

  function addInputFile() {
    count+=1; 
    $html = `<input type="file" name="uploadfile${count}" class="form-control" accept=".pdf,.jpg">`;
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

function changeLampText(id) {

  var labelId = "label[for="+id+"]";

  if ($(labelId).length) {
    var x = document.getElementById(id);
    x.style.display = "block";

    if ($(`#lamp${id}`).length) {
      $(`#lamp${id}`).remove();
    }
    var value = $(labelId).attr("value");
    $html = `<input type="hidden" name="lamp${id}" id="lamp${id}" value='${value}'/>`;

    $('#tempat_upload').append($html);
    $(labelId).remove();
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