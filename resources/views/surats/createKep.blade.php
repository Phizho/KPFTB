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
      <div class="form-inline">
        @csrf
        <br />
        <label class="required bold">No Surat Keluar:</label>
        <input type="input" class="form-control" name="noSurat" value="" required readonly>
        <br/><br/>
        <label class="required bold">Tanggal Kirim:</label>
        <input type="date" class="form-control" name="Tanggal" required>
        <br style="clear:both;"/>
        <br/>
        <label class="required bold">Perihal:</label>
        <input type="input" class="form-control" name="perihal" style="width: 300px;" required>
        <br /><br/>
        <label class="required bold">Menimbang</label>
        <textarea name="menimbang" id="menimbang" rows="8" class="form-control" style="width: 100%;" required></textarea>
        <br/><br/>
        <div id="tempat_mengingat">
          <label class="bold">Mengingat</label>     
        </div>
        <div>
        <button type="button" class="btn btn-primary" name="tambahMengingat" onclick="addMengingat()">Tambah Mengingat</button>
        <button type="button" class="btn btn-danger" name="hapusMengingat" onclick="deleteMengingat()">Hapus Mengingat</button>
        </div>
        <br/>
        <div id="tempat_menetapkan">
          <label class="bold">Menetapkan</label>     
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
    $html = `<div id="divMengingat${countMengingat}"><label class="bold required">${countMengingat}.</label>`
    $html += `<input type="input" class="form-control" name="mengingat${countMengingat}" style="width: 300px;" required>`
    $("#tempat_mengingat").append($html);
  }

  function addMenetapkan() {
    countMenetapkan+=1; 
    $html = `<div id="divMenetapkan${countMenetapkan}"><label class="bold required">${countMenetapkan}.</label>`
    $html += `<input type="input" class="form-control" name="mengingat${countMenetapkan}" style="width: 300px;" required>`
    $("#tempat_menetapkan").append($html);
  }

  function deleteMengingat() {
    if ($(`#mengingat${countMengingat}`).length) {
        var x = document.getElementById(`divMengingat${countMengingat}`);
        x.remove();
        countMengingat-=1;
      } 
  }

  function deleteMenetapkan() {
    if ($(`#menetapkan${countMenetapkan}`).length) {
        var x = document.getElementById(`divMenetapkan${countMenetapkan}`);
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