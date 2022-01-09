@extends('layout.conquer')

@section('tempat_titleatas')
<title>Pembuatan Surat Keluar</title>
@endsection

@section('tempat_judul')
<p style="text-align: center;">TAMBAH DATA SURAT KEPUTUSAN</p>
@endsection

@section('tempat_konten')
<head> 
<meta name="csrf-token" content="{{ csrf_token() }}">
<a href="{{route('surats.index')}}">
  Kembali</a>
</head>

<body onload="mulai()">
  <form method="POST" action="{{url('surats/'.$s[0]->nomor_surat.'/updateKep')}}" formtarget="_blank" target="_blank"  enctype="multipart/form-data">
    @csrf
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">No Surat Keluar:</label>
      <div class="col-sm-2">
        <input type="input" class="form-control" name="noSurat" value='{{str_replace("-","/",$s[0]->nomor_surat)}}' style="width: 200px;" required readonly>
      </div>
    </div>
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Tanggal Kirim:</label>
      <div class="col-sm-2">
        <input type="date" class="form-control" name="Tanggal" value="{{ date('Y-m-d', strtotime($s[0]->tanggal_kirim)) }}" required>
      </div>
    </div> 
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Perihal:</label>
      <div class="col-sm-4">
        <input type="input" class="form-control" name="perihal" value="{{$s[0]->perihal}}" required>
      </div>
    </div> 
    <br />
    <label class="required bold">Menimbang</label>
    <textarea name="menimbang" id="menimbang" rows="8" class="form-control"  required>{{$menimbang}}</textarea>
    <br>
    <div class="required" id="tempat_mengingat">
      <label class="bold">Mengingat</label>     
    </div>
    <div>
    <button type="button" class="btn btn-primary" name="tambahMengingat" onclick="addMengingat()">Tambah Mengingat</button>
    <button type="button" class="btn btn-danger" name="hapusMengingat" onclick="deleteMengingat()">Hapus Mengingat</button>
    </div>
    <br/>
    <div class="required" id="tempat_menetapkan">
      <label class="bold">Menetapkan</label>     
    </div>
    <div>
    <button type="button" class="btn btn-primary" name="tambahMenetapkan" onclick="addMenetapkan()">Tambah Menetapkan</button>
    <button type="button" class="btn btn-danger" name="hapusMenetapkan" onclick="deleteMenetapkan()">Hapus Menetapkan</button>
    </div>
    <input type="hidden" name="tglbuat" id="tglbuat" value='{{$s[0]->created_at}}'/>
    <div id="tempat_upload"> 
    </div>
    <br/>
    <input type="submit" class="btn btn-primary" value="Simpan Surat" name="submit" onclick="CekCount()">
  </form>

</body>

<script type="text/javascript">
var countMengingat = 0;
var countMenetapkan = 0;
var trNum = 0;
var tdNum = 0;

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

function mulai() {

  var cIngat = parseInt(<?php echo json_encode($cIngat) ?>);
  var cTetap = parseInt(<?php echo json_encode($cTetap) ?>);
  var mengingat = <?php echo json_encode($mengingat) ?>;
  var menetapkan = <?php echo json_encode($menetapkan) ?>;


  if (cIngat >= 1) {
    for (i=1;i<=cIngat;i++) {
        countMengingat+=1; 
        $html = `<div class="form-group row" id="divMengingat${countMengingat}">
                <div class="required" style="width: 50px; float: left; margin-left:18px; padding-top: 5px;">
                  <label class="bold col-sm-6 col-form-label" >${countMengingat}.</label>
                </div>
                <div class="col-sm-4">
                 <input type="input" class="form-control" name="mengingat${countMengingat}" id="mengingat${countMengingat}" value="${mengingat[i-1]}" style="float:left;" required>
                </div>
              </div>`
        $("#tempat_mengingat").append($html);
    }
  }

  if (cTetap >= 1) {
    for (i=1;i<=cTetap;i++) {
        countMenetapkan+=1; 
        $html = `<div class="form-group row" id="divMenetapkan${countMenetapkan}">
                <div class="required" style="width: 50px; float: left; margin-left:18px; padding-top: 5px;">
                  <label class="bold col-sm-6 col-form-label" >${countMenetapkan}.</label>
                </div>
                <div class="col-sm-4">
                 <input type="input" class="form-control" name="menetapkan${countMenetapkan}" id="menetapkan${countMenetapkan}" value="${menetapkan[i-1]}" style="float:left;" required>
                </div>
              </div>`
        $("#tempat_menetapkan").append($html);
    }
  }
}

function addMengingat() {
    countMengingat+=1; 
    $html = `<div class="form-group row" id="divMengingat${countMengingat}">
                <div class="required" style="width: 50px; float: left; margin-left:18px; padding-top: 5px;">
                  <label class="bold col-sm-6 col-form-label" >${countMengingat}.</label>
                </div>
                <div class="col-sm-4">
                 <input type="input" class="form-control" name="mengingat${countMengingat}" style="float:left;" required>
                </div>
              </div>`
    $("#tempat_mengingat").append($html);
  }

  function addMenetapkan() {
    countMenetapkan+=1; 
    $html = `<div class="form-group row" id="divMenetapkan${countMenetapkan}">
                <div class="required" style="width: 50px; float: left; margin-left:18px; padding-top: 5px;">
                  <label class="bold col-sm-6 col-form-label" >${countMenetapkan}.</label>
                </div>
                <div class="col-sm-4">
                 <input type="input" class="form-control" name="menetapkan${countMenetapkan}" style="float:left;" required>
                </div>
              </div>`
    $("#tempat_menetapkan").append($html);
  }

  function deleteMengingat() {
    //if ($(`#mengingat${countMengingat}`).length) {
        var x = document.getElementById(`divMengingat${countMengingat}`);
        x.remove();
        countMengingat-=1;
      //} 
  }

  function deleteMenetapkan() {
    //if ($(`#menetapkan${countMenetapkan}`).length) {
        var x = document.getElementById(`divMenetapkan${countMenetapkan}`);
        x.remove();
        countMenetapkan-=1;
      //} 
  }

function CekCount()
{
  if ($('#countMengingat').length) {
      var x = document.getElementById("countMengingat");
      x.remove();
    }
    
  if ($('#countMenetapkan').length) {
      var x = document.getElementById("countMenetapkan");
      x.remove();
    }

    $html =`<input type="hidden" name="countMengingat" id="countMengingat" value='${countMengingat}'/>`;
    $html +=`<input type="hidden" name="countMenetapkan" id="countMenetapkan" value='${countMenetapkan}'/>`;  
    
  $('#tempat_upload').append($html);
}
</script>
@endsection