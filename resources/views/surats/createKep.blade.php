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

<body onload="getComboN()">
  <form method="POST" action="{{ route('surats.storeKep') }}" formtarget="_blank" target="_blank"  enctype="multipart/form-data">
    <div class="form-group">
      @csrf
      <br />
      <label class="required">No Surat Keluar</label>
      <input type="input" class="form-control" name="noSurat" value="" required readonly>
      <br />
      <label class="required">Perihal</label>
      <input type="input" class="form-control" name="perihal" required>
      <br />
      <label class="required">Tanggal Kirim:</label>
      <input type="date" class="form-control" name="Tanggal" required>
      <br>
      <label class="required">Menimbang</label>
      <textarea name="menimbang" id="menimbang" rows="8" class="form-control" required></textarea>
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

function getComboN() {
  let value = 5  
    $.ajax({
            type:"POST",
            url: "{{ route('surats.generateNO') }}",
            data: {
                vl : 5,
            },
            success: function(data)
            { 
              var arrSpl = data.success.split("-");
              var d = new Date();
              var y = d.getFullYear();

              switch(d.getMonth()) {
                case 0:
                  month = "I"
                  break;
                case 1:
                  month = "II"
                  break;
                case 2:
                  month = "III"
                  break;
                case 3:
                  month = "IV"
                  break;
                case 4:
                  month = "V"
                  break;
                case 5:
                  month = "VI"
                  break;
                case 6:
                  month = "VII"
                  break;
                case 7:
                  month = "VIII"
                  break;
                case 8:
                  month = "IX"
                  break;
                case 9:
                  month = "X"
                  break;
                case 10:
                  month = "XI"
                  break;
                case 11:
                  month = "XII"
                  break;
              } 
              if (value == 5) {
                if (arrSpl[5] == y) {
                //Tahun sama     
                if (month == arrSpl[4]) {
                  //Bulan sama
                  arrSpl[0] = String(parseInt(arrSpl[0]) + 1).padStart(2,'0');
                  var baru = arrSpl.join('/');
                } else {
                  //Bulan beda
                  arrSpl[4] = month;
                  arrSpl[0] = "01";
                  var baru = arrSpl.join('/');
                }
                $('input[name=noSurat]').attr('value', baru);
              } else {
                //Tahun Beda
                arrSpl[4] = month;
                arrSpl[0] = "01";
                arrSpl[5] = y;
                var baru = arrSpl.join('/');
                $('input[name=noSurat]').attr('value', baru);
              }
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              var d = new Date();
              var y = d.getFullYear();

              switch(d.getMonth()) {
                case 0:
                  month = "I"
                  break;
                case 1:
                  month = "II"
                  break;
                case 2:
                  month = "III"
                  break;
                case 3:
                  month = "IV"
                  break;
                case 4:
                  month = "V"
                  break;
                case 5:
                  month = "VI"
                  break;
                case 6:
                  month = "VII"
                  break;
                case 7:
                  month = "VIII"
                  break;
                case 8:
                  month = "IX"
                  break;
                case 9:
                  month = "X"
                  break;
                case 10:
                  month = "XI"
                  break;
                case 11:
                  month = "XII"
                  break;
              } 
              
              switch(value){
                case "5":
                  baru = "001/SK/DEK/FTb/"+month+"/"+y
                  break;
              }

              $('input[name=noSurat]').attr('value', baru);
            }
        });
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