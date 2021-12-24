  @extends('layout.conquer')

  @section('tempat_titleatas')
  <title>Pembuatan Surat Keluar</title>
  @endsection

  @section('tempat_judul')
  <p style="text-align: center;">TAMBAH DATA SURAT KELUAR</p>
  @endsection

  @section('tempat_konten')
  <head> 
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{route('surats.index')}}">
    Kembali</a>
  </head>

  <body>
    <form method="POST" action="{{ route('surats.store') }}" formtarget="_blank" target="_blank"  enctype="multipart/form-data">
      <div class="form-inline">
        @csrf
        <br />
        <label class="bold">Jenis surat keluar:</label>
        <select name="jenis" class="form-control" onchange="getComboN(this)">
          <option disabled selected value> -- Pilih Jenis Surat -- </option>
          <option value="1">Surat Keluar Dekan</option>
          <option value="2">Surat Keluar Wakil Dekan</option>
          <option value="3">Surat Keluar Kaprodi Magister Bioteknologi</option>
        </select>
        <br /><br />
        <label class="required bold" for="noSurat">No Surat Keluar:</label>
        <input type="input" id="noSurat" class="form-control" name="noSurat" value="" style="width:200px;" required disabled/>
        <br style="clear:both;" /><br/>
        <label class="required bold" for="Tanggal">Tanggal Kirim:</label>
        <input type="date" class="form-control" name="Tanggal" style="width:200px;" id="Tanggal" required/>
        <br style="clear:both;" /><br/>
        <label class="required bold">Perihal:</label>
        <input type="input" class="form-control" name="perihal" style="width: 300px;" required>
        <br style="clear:both;" /><br />
        <label class="required bold">Lampiran:</label>
        <input type="input" class="form-control" name="lampiran" style="width: 300px;" required>
        <br style="clear:both;" /><br />
        <label class="required bold">Kepada:</label>
        <input type="input" class="form-control" name="kepada" style="width: 300px;" required>
        <br style="clear:both;" /><br />
        <label class="required bold"> Isi Surat: </label>
        <textarea name="isiSurat" id="isiSurat" rows="8" class="form-control" style="width:100%;" required></textarea>  
        <br/> 
        <input type="checkbox" name="tcheck[]" value="pTabel" id="tcheck" onclick="tOn()">
          <label class="bold">Gunakan Tabel?</label>
          <br/>
          <div id="hiddenTable" style="display: none;">
            <label class="required">Jumlah Baris</label>
            <input type="number" class="form-control" name="noRow" id="noRow" style="width: 10%;" min="1">
            <br/>
            <label class="required">Jumlah Kolom</label>
            <input type="number" class="form-control" name="noCol" id="noCol" style="width: 10%;" min="1" max="6">
            <br/>
            <div>
              <button type="button" class="btn btn-primary" name="tambahTable" onclick="addTable()">Buat Tabel</button>
            </div>
            <br/>
            <table style='border: 1px solid black; border-collapse: collapse; width: 100%;' id="tbl">
            </table>
            <br/>
          </div><br/>
          <label class="required bold"> Penutup Surat: </label>
          <textarea name="penutup" id="penutup" rows="8" style="width:100%;" class="form-control" required></textarea>   
        <br/><br/>
        <div id="tempat_upload">
          <label class="bold">Upload Lampiran</label>     
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

  <script type="text/javascript">
  var count = 0 ;
  var trNum = 0;
  var tdNum = 0;

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function getComboN(selectObject) {
    let value = selectObject.value;  
      $.ajax({
              type:"POST",
              url: "{{ route('surats.generateNO') }}",
              data: {
                  vl : value,
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
                } else {
                  if (arrSpl[4] == y) {
                  //Tahun sama     
                  if (month == arrSpl[3]) {
                    //Bulan sama
                    arrSpl[0] = String(parseInt(arrSpl[0]) + 1).padStart(3,'0');
                    var baru = arrSpl.join('/');
                  } else {
                    //Bulan beda
                    arrSpl[3] = month;
                    arrSpl[0] = "001";
                    var baru = arrSpl.join('/');
                  }
                  $('input[name=noSurat]').attr('value', baru);
                } else {
                  //Tahun Beda
                  arrSpl[3] = month;
                  arrSpl[0] = "001";
                  arrSpl[4] = y;
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
                  case "1":
                    baru = "001/DEK/FTb/"+month+"/"+y
                    break;
                  case "2":
                    baru = "001/WD/FTb/"+month+"/"+y
                    break;
                  case "3":
                    baru = "001/Mag-Bioteknologi/FTb/"+month+"/"+y
                    break;
                  case "4":
                    baru = "001/PKS/FTb/"+month+"/"+y
                    break;
                  case "5":
                    baru = "001/SK/DEK/FTb/"+month+"/"+y
                    break;
                }

                $('input[name=noSurat]').attr('value', baru);
              }
          });
  }

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
          $htmlTbl += `<td style="height: 30px; width: 200px; border: 1px solid black; border-collapse: collapse;"><div id="tr${i}td${j}" contenteditable><center><b>Judul Kolom</b></center></div></td>`;
        } else {
          $htmlTbl += `<td style="height: 30px; width: 200px; border: 1px solid black; border-collapse: collapse;"><div id="tr${i}td${j}" contenteditable></div></td>`;
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