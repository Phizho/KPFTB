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
  <form method="POST" action="{{ route('surats.storeKerj') }}" formtarget="_blank" target="_blank" enctype="multipart/form-data">
    <div class="form-inline">
      @csrf
      <br />
      <label class="required bold">Ubaya Pihak ke</label>
      <select name="pihakKe" class="form-control" onchange="">
        <option value="1">1</option>
        <option value="2">2</option>
      </select>
        <br/><br/>
        <label class="required bold">No Surat Keluar:</label>
        <input type="input" class="form-control" name="noSurat" value="" required>
        <br/><br/>
        <label class="required bold">Tanggal Kirim:</label>
        <input type="date" class="form-control" name="Tanggal" required>
        <br style="clear:both;" />
        <br/>
        <label class="required bold">Instansi Rekan:</label>
        <input type="input" class="form-control" name="pihak2" style="width: 200px;" required>
        <br /><br/>
        <label class="required bold">Perihal Kerja Sama:</label>
        <input type="input" class="form-control" name="perihal" style="width: 300px;" required>
        <br /><br/>
        <div>
          <b style="font-size: 20px;"> Data Rekan </b><br /><br />
          <label class="required bold">Perwakilan Rekan:</label>
          <input type="input" class="form-control" name="wakilRkn" required>
          <br/><br/>
          <label class="required bold">Jabatan Perwakilan Rekan:</label>
          <input type="input" class="form-control" name="jabatanRkn" required>
          <br/><br/>
          <label class="required bold">Nomor Telepon Rekan:</label>
          <input type="input" class="form-control" name="noTelpRkn">
          <br/><br/>
          <label class="required bold">Nomor HP Rekan:</label>
          <input type="input" class="form-control" name="noHPRkn">
          <br/><br/>
          <label class="required bold">Alamat Rekan:</label>
          <input type="input" class="form-control" name="alamatRkn" required>
          <br/><br/>
          <label class="required bold">Email Rekan:</label>
          <input type="input" class="form-control" name="emailRkn" required>
        </div>
        <br />
        <div>
          <b style="font-size: 20px;"> Ruang Lingkup Perjanjian </b> <br /><br />
          <label class="required bold">Pihak Rekan:</label>
          <input type="input" class="form-control" name="lingkupRkn" required>
          <br /><br />
          <label class="required bold">Pihak Bioteknologi:</label>
          <input type="input" class="form-control" name="lingkupBiotek" required>
        </div>
        <br />
        <div>
          <b style="font-size: 20px;"> Hak dan Kewajiban </b> <br /><br />
          <label class="required bold">Kewajiban Bioteknologi:</label>
          <input type="input" class="form-control" name="kewajibanBiotek" required>
          <br /><br />
          <label class="required bold">Kewajiban Rekan:</label>
          <input type="input" class="form-control" name="kewajibanRkn" required>
          <br /><br />
          <label class="required bold">Hak Bioteknologi:</label>
          <input type="input" class="form-control" name="hakBiotek" required>
          <br /><br />
          <label class="required bold">Hak Rekan:</label>
          <input type="input" class="form-control" name="hakRkn" required>
        </div>
        <br />
        <div>
          <b style="font-size: 20px;"> Pelaksanaan Kerjasama </b> <br /><br />
          <label class="required bold">Pelaksanaan Kerjasama</label>
          <textarea name="pelaksanaanKj" id="pelaksanaanKj" rows="8" class="form-control" style="width: 100%;" required></textarea>
        </div>
        <br />
        <div>
          <b style="font-size: 20px;"> Biaya-Biaya </b> <br/><br/>
          <label class="required bold">Pihak Pembayar</label>
          <select name="pihakPembayar" class="form-control" onchange="">
            <option value="1">Bioteknologi</option>
            <option value="2">Rekan</option>
            <br /><br/>
          </select>
          <br /><br/>
          <label class="required bold">Jumlah Pembayaran</label>
          <input type="input" class="form-control" name="jumlahBayar" required>
        </div>
        <br />
        <div>
          <label class="required bold">Pembayaran dilakukan melalui</label>
          <textarea name="caraPembayaran" id="caraPembayaran" rows="8" class="form-control" style="width: 100%;" required></textarea>
        </div>
        <br />
        <div>
          <label class="required bold">Batas Waktu Perjanjian</label>
          <input type="date" class="form-control" name="tanggalSelesai" required>
        </div>
        <br />
        <div id="tempat_upload">
        </div>
        <br />
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