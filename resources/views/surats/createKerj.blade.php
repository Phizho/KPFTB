@extends('layout.conquer')

@section('tempat_titleatas')
<title>Pembuatan Surat Kerjasama</title>
@endsection

@section('tempat_judul')
<p style="text-align: center;">TAMBAH DATA SURAT KERJASAMA</p>
@endsection

@section('tempat_konten')

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <a href="{{route('surats.index')}}">
    Kembali</a>
</head>

<body onload="getComboN()">
  <form method="POST" action="{{ route('surats.storeKerj') }}" formtarget="_blank" target="_blank" enctype="multipart/form-data">
      @csrf
      <br />
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Ubaya Pihak ke:</label>
        <div class="col-sm-1">
          <select name="pihakKe" class="form-control" onchange="">
            <option value="1">1</option>
            <option value="2">2</option>0
          </select>
        </div>
      </div>
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">No Surat Keluar:</label>
        <div class="col-sm-4">  
          <input type="input" class="form-control" name="noSurat" value="" required readonly>
        </div>
      </div>  
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Tanggal Kirim:</label>
        <div class="col-sm-4"> 
          <input type="date" class="form-control" name="Tanggal" style="width: 200px;" required>
        </div>
      </div>  
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Instansi Rekan:</label>
        <div class="col-sm-4"> 
          <input type="input" class="form-control" name="pihak2" style="width: 200px;" required>
        </div>
      </div> 
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Perihal Kerja Sama:</label>
        <div class="col-sm-4"> 
          <input type="input" class="form-control" name="perihal" style="width: 300px;" required>
        </div>
      </div> 
      <br/>
      <div>
        <b style="font-size: 20px;"> Data Rekan </b><br/><br/>
        <div class="form-group row">
          <label class="required bold col-sm-2 col-form-label">Perwakilan Rekan:</label>
          <div class="col-sm-4"> 
            <input type="input" class="form-control" name="wakilRkn" required>
          </div>
        </div> 
        <br/>
        <div class="form-group row">
          <label class="required bold col-sm-2 col-form-label">Jabatan Perwakilan Rekan:</label>
          <div class="col-sm-4">
            <input type="input" class="form-control" name="jabatanRkn" required>
          </div>
        </div> 
        <br/>
        <div class="form-group row">
          <label class="required bold col-sm-2 col-form-label">Nomor Telepon Rekan:</label>
          <div class="col-sm-4">
            <input type="input" class="form-control" name="noTelpRkn">
          </div>
        </div> 
        <br/>
        <div class="form-group row">
          <label class="required bold col-sm-2 col-form-label">Nomor HP Rekan:</label>
          <div class="col-sm-4">
            <input type="input" class="form-control" name="noHPRkn">
          </div>
        </div> 
        <br/>
        <div class="form-group row">
          <label class="required bold col-sm-2 col-form-label">Alamat Rekan:</label>
          <div class="col-sm-4">
            <input type="input" class="form-control" name="alamatRkn" required>
          </div>
        </div> 
        <br/>
        <div class="form-group row">
          <label class="required bold col-sm-2 col-form-label">Email Rekan:</label>
          <div class="col-sm-4">
            <input type="input" class="form-control" name="emailRkn" required>
          </div>
        </div> 
      </div>
      <br/>
        <div>
          <b style="font-size: 20px;"> Ruang Lingkup Perjanjian </b> <br/><br/>
          <div class="form-group row">
            <label class="required bold col-sm-2 col-form-label">Pihak Rekan:</label>
              <div class="col-sm-4">
              <input type="input" class="form-control" name="lingkupRkn" required>
            </div>
          </div> 
          <br/>
          <div class="form-group row">
            <label class="required bold col-sm-2 col-form-label">Pihak Bioteknologi:</label>
            <div class="col-sm-4">
              <input type="input" class="form-control" name="lingkupBiotek" required>
            </div>
          </div> 
        </div>
        <br/>
        <div>
          <b style="font-size: 20px;"> Hak dan Kewajiban </b> <br/><br/>
          <div class="form-group row">
            <label class="required bold col-sm-2 col-form-label">Kewajiban Bioteknologi:</label>
            <div class="col-sm-4">
              <textarea name="kewajibanBiotek" id="kewajibanBiotek" rows="8" class="form-control" style="width: 100%;" required></textarea>
            </div>
          </div> 
          <br/>
          <div class="form-group row">
            <label class="required bold col-sm-2 col-form-label">Kewajiban Rekan:</label>
            <div class="col-sm-4">
              <textarea name="kewajibanRkn" id="kewajibanRkn" rows="8" class="form-control" style="width: 100%;" required></textarea>
            </div>
          </div> 
          <br/>
          <div class="form-group row">
            <label class="required bold col-sm-2 col-form-label">Hak Bioteknologi:</label>
            <div class="col-sm-4">
              <textarea name="hakBiotek" id="hakBiotek" rows="8" class="form-control" style="width: 100%;" required></textarea>
            </div>
          </div>
          <br/>
          <div class="form-group row">
            <label class="required bold col-sm-2 col-form-label">Hak Rekan:</label>
            <div class="col-sm-4">
              <textarea name="hakRkn" id="hakRkn" rows="8" class="form-control" style="width: 100%;" required></textarea>
            </div>
          </div>
        </div>
        <br/>
        <div>
          <b style="font-size: 20px;"> Pelaksanaan Kerjasama </b> <br /><br />
          <label class="required bold">Pelaksanaan Kerjasama</label>
          <textarea name="pelaksanaanKj" id="pelaksanaanKj" rows="8" class="form-control" style="width: 100%;" required></textarea>
        </div>
        <br />
        <div>
          <b style="font-size: 20px;"> Biaya-Biaya </b> <br/><br/>
          <div class="form-group row">
            <label class="required bold col-sm-2 col-form-label">Pihak Pembayar</label>
            <div class="col-sm-4">
              <select name="pihakPembayar" class="form-control" onchange="">
                <option value="1">Bioteknologi</option>
                <option value="2">Rekan</option>
              </select>
            </div>
          </div>
          <br/>
          <div class="form-group row">
            <label class="required bold col-sm-2 col-form-label">Jumlah Pembayaran</label>
            <div class="col-sm-4">
              <input type="input" class="form-control" name="jumlahBayar" required>
            </div>
          </div>
        </div>
        <br />
        <label class="bold">Ketentuan Pembayaran (Jika dikosongi akan mengikuti template)</label>
        <textarea name="ktnPembayaran" id="ktnPembayaran" rows="8" class="form-control"></textarea>
        <br/>
        <label class="required bold">Pembayaran dilakukan melalui</label>
        <textarea name="caraPembayaran" id="caraPembayaran" rows="8" class="form-control" style="width: 100%;" required></textarea>
        <br />
        <div class="form-group row">
          <label class="required bold col-sm-2 col-form-label">Batas Waktu Perjanjian</label>
          <div class="col-sm-4">
            <input type="date" class="form-control" name="tanggalSelesai" required>
          </div>
        </div>
        <br />
        <div>
          <b style="font-size: 20px;"> Pasal Tambahan (jika tidak diisi akan mengikuti template) </b> <br/><br/>
          <label class="bold">Force Majeur</label>
          <textarea name="caraPembayaran" id="caraPembayaran" rows="8" class="form-control"></textarea>
          <br/>
          <label class="bold">Sanksi</label>
          <textarea name="caraPembayaran" id="caraPembayaran" rows="8" class="form-control"></textarea>
          <br/>
          <label class="bold">Penyelesaian Perselisihan</label>
          <textarea name="caraPembayaran" id="caraPembayaran" rows="8" class="form-control"></textarea>
        </div>
        <div id="tempat_upload">
        </div>
        <br />
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

  function getComboN() {
    let value = 4
    $.ajax({
      type: "POST",
      url: "{{ route('surats.generateNO') }}",
      data: {
        vl: 4,
      },
      success: function(data) {
        var arrSpl = data.success.split("-");
        var d = new Date();
        var y = d.getFullYear();

        switch (d.getMonth()) {
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
        if (arrSpl[4] == y) {
          //Tahun sama     
          if (month == arrSpl[3]) {
            //Bulan sama
            arrSpl[0] = String(parseInt(arrSpl[0]) + 1).padStart(3, '0');
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
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        var d = new Date();
        var y = d.getFullYear();

        switch (d.getMonth()) {
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
        baru = "001/PKS/FTb/" + month + "/" + y
        $('input[name=noSurat]').attr('value', baru);
      }
    });

  }

  function CekCount() {
    if ($('#countMengingat').length) {
      var x = document.getElementById("countMengingat");
      x.remove();
    }

    if ($('#countMenetapkan').length) {
      var x = document.getElementById("countMenetapkan");
      x.remove();
    }

    $html = `<input type="hidden" name="countMengingat" id="countMengingat" value='${countMengingat}'/>`;
    $html += `<input type="hidden" name="countMenetapkan" id="countMenetapkan" value='${countMenetapkan}'/>`;

    $('#tempat_upload').append($html);
  }
</script>
@endsection