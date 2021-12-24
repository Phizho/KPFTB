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
    <div class="form-group">
      @csrf
      <br />
      <label class="required">No Surat Keluar</label>
      <input type="input" class="form-control" name="noSurat" value='{{str_replace("-","/",$s[0]->nomor_surat)}}' required>
      <br />
      <label class="required">Perihal</label>
      <input type="input" class="form-control" name="perihal" value="{{$s[0]->perihal}}" required>
      <br />
      <label class="required">Tanggal Kirim:</label>
      <input type="date" class="form-control" name="Tanggal" value="{{ date('Y-m-d', strtotime($s[0]->tanggal_kirim)) }}" required>
      <br>
      <label class="required">Menimbang</label>
      <textarea name="menimbang" id="menimbang" rows="8" class="form-control"  required>{{$menimbang}}</textarea>
      <br>
      <div class="required" id="tempat_mengingat">
        <label>Mengingat</label>     
      </div>
      <div>
      <button type="button" class="btn btn-primary" name="tambahMengingat" onclick="addMengingat()">Tambah Mengingat</button>
      <button type="button" class="btn btn-danger" name="hapusMengingat" onclick="deleteMengingat()">Hapus Mengingat</button>
      </div>
      <br/>
      <div class="required" id="tempat_menetapkan">
        <label>Menetapkan</label>     
      </div>
      <div>
      <button type="button" class="btn btn-primary" name="tambahMenetapkan" onclick="addMenetapkan()">Tambah Menetapkan</button>
      <button type="button" class="btn btn-danger" name="hapusMenetapkan" onclick="deleteMenetapkan()">Hapus Menetapkan</button>
      </div>
      <div id="tempat_upload"> 
      </div>
      <br/>
      <input type="submit" class="btn btn-primary" value="Simpan Surat" name="submit" onclick="CekCount()">
    </div>
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
  var cIngat = parseInt({ json_encode($cIngat) });
  var cTetap = parseInt({ json_encode($cTetap) });
  var mengingat = { json_encode($mengingat)};
  var menetapkan = { json_encode($menetapkan) };


  if (cIngat >= 1) {
    for (i=1;i<=cIngat;i++) {
        countMengingat+=1; 
        $html = `<label>${countMengingat}</label>`
        $html += `<textarea name="mengingat${countMengingat}" id="mengingat${countMengingat}" rows="8" class="form-control" required>${mengingat[i-1]}</textarea>`;
        $("#tempat_mengingat").append($html);
    }
  }

  if (cTetap >= 1) {
    for (i=1;i<=cTetap;i++) {
        countMenetapkan+=1; 
        $html = `<label>${countMenetapkan}</label>`
        $html += `<textarea name="menetapkan${countMenetapkan}" id="menetapkan${countMenetapkan}" rows="8" class="form-control" required>${menetapkan[i-1]}</textarea>`;
        $("#tempat_menetapkan").append($html);
    }
  }
}

function addMengingat() {
  countMengingat+=1; 
  $html = `<label>${countMengingat}</label>`
  $html += `<textarea name="mengingat${countMengingat}" id="mengingat${countMengingat}" rows="8" class="form-control" required></textarea>`;
  $("#tempat_mengingat").append($html);
}

function addMenetapkan() {
  countMenetapkan+=1; 
  $html = `<label>${countMenetapkan}</label>`
  $html += `<textarea name="menetapkan${countMenetapkan}" id="menetapkan${countMenetapkan}" rows="8" class="form-control" required></textarea>`;
  $("#tempat_menetapkan").append($html);
}

function deleteMengingat() {
  if ($(`#mengingat${countMengingat}`).length) {
      var x = document.getElementById(`mengingat${countMengingat}`);
      x.remove();
      countMengingat-=1;
    } 
}

function deleteMenetapkan() {
  if ($(`#menetapkan${countMenetapkan}`).length) {
      var x = document.getElementById(`menetapkan${countMenetapkan}`);
      x.remove();
      countMenetapkan-=1;
    } 
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