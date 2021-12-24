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
  <form method="POST" action="{{ route('surats.storeKerj') }}" formtarget="_blank" target="_blank"  enctype="multipart/form-data">
    <div class="form-group">
      @csrf
      <br />
      <label class="required">Ubaya Pihak ke</label>
      <select name="pihakKe" onchange="" value="{{$pihakUbaya}}">
        <option value="1">1</option>
        <option value="2">2</option>
      <br/>
      <label class="required">No Surat Keluar</label>
      <input type="input" class="form-control" name="noSurat" value='{{str_replace("-","/",$s[0]->nomor_surat)}}' required>
      <br />
      <label class="required">Perihal Kerja Sama</label>
      <input type="input" class="form-control" name="perihal" value="{{$s[0]->perihal}}" required>
      <br />
      <label class="required">Tanggal Kirim:</label>
      <input type="date" class="form-control" name="Tanggal" value="{{ date('Y-m-d', strtotime($s[0]->tanggal_kirim)) }}" required>
      <br/>
      <label class="required">Instansi Rekan</label>
      <input type="input" class="form-control" name="pihak2" value="{{$namaRekan}}" required>
      <br />
      <div>
         <b> Data Rekan </b><br/><br/>
        <label class="required">Perwakilan Rekan</label>
        <input type="input" class="form-control" name="wakilRkn" value="{{$perwakilanRkn}}" required>
        <label class="required">Jabatan Perwakilan Rekan</label>
        <input type="input" class="form-control" name="jabatanRkn" value="{{$jabatanWPR}}" required>
        <label class="required">Nomor Telepon Rekan</label>
        <input type="input" class="form-control" name="noTelpRkn" value="{{$teleponRkn}}">
        <label class="required">Nomor HP Rekan</label>
        <input type="input" class="form-control" name="noHPRkn" value="{{$hpRkn}}">
        <label class="required">Alamat Rekan</label>
        <input type="input" class="form-control" name="alamatRkn" value="{{$alamatRkn}}" required>
        <label class="required">Email Rekan</label>
        <input type="input" class="form-control" name="emailRkn" value="{{$emailRkn}}" required>
      </div>
      <br/>
      <div>
          <b> Ruang Lingkup Perjanjian </b> <br/><br/>
          <label class="required">Pihak Rekan</label>
          <input type="input" class="form-control" name="lingkupRkn" value="{{$lingkupRkn}}" required>
          <label class="required">Pihak Bioteknologi</label>
          <input type="input" class="form-control" name="lingkupBiotek" value="{{$lingkupUby}}" required>
      </div>
      <br/>
      <div>
          <b> Hak dan Kewajiban </b> <br/><br/>
          <label class="required">Kewajiban Bioteknologi</label>
          <input type="input" class="form-control" name="kewajibanBiotek" value="{{$kewajibanUby}}" required>
          <label class="required">Kewajiban Rekan</label>
          <input type="input" class="form-control" name="kewajibanRkn" value="{{$kewajibanRkn}}" required>  
          <label class="required">Hak Bioteknologi</label>
          <input type="input" class="form-control" name="hakBiotek" value="{{$hakUby}}" required> 
          <label class="required">Hak Rekan</label>
          <input type="input" class="form-control" name="hakRkn" value="{{$hakRkn}}" required>
      </div>
      <br/>
      <div>
          <b> Pelaksanaan Kerjasama </b> <br/><br/>
          <label class="required">Pelaksanaan Kerjasama</label>
          <textarea name="pelaksanaanKj" id="pelaksanaanKj" rows="8" class="form-control" required>{{$pelaksanaan}}</textarea>
      </div>
      <br/>
      <div>
          <b> Biaya-Biaya </b> <br/>
          <label class="required">Pihak Pembayar</label>
          <select name="pihakPembayar" onchange="">
          <option value="1">Bioteknologi</option>
          <option value="2">Rekan</option>
          <br />
          <label class="required">Jumlah Pembayaran</label>
          <input type="input" class="form-control" name="jumlahBayar" value="{{$jumlahBayar}}" required>
      </div>
      <br/>
      <div>
          <label class="required">Pembayaran dilakukan melalui</label>
          <textarea name="caraPembayaran" id="caraPembayaran" rows="8" class="form-control" required>{{$caraPembayaran}}</textarea>
      </div>
      <br/>
      <div>
          <label class="required">Batas Waktu Perjanjian</label>
          <input type="date" class="form-control" name="tanggalSelesai" value="{{date('Y-m-d', strtotime($tanggalsl))}}" required>
      </div>
      <br/>
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
  let value = 4  
    $.ajax({
            type:"POST",
            url: "{{ route('surats.generateNO') }}",
            data: {
                vl : 4,
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
            baru = "001/PKS/FTb/"+month+"/"+y
            $('input[name=noSurat]').attr('value', baru);
            }
        });
    
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