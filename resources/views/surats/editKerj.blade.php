@extends('layout.conquer')

@section('tempat_titleatas')
<title>Edit Surat Kerjasama</title>
@endsection

@section('tempat_judul')
<p style="text-align: center;">UBAH DATA SURAT KERJASAMA</p>
@endsection

@section('tempat_konten')
<head> 
<meta name="csrf-token" content="{{ csrf_token() }}">
<a href="{{route('surats.index')}}">
  Kembali</a>
</head>

<body>
  <form method="POST" action="{{url('surats/'.$s[0]->nomor_surat.'/updateKerj')}}" formtarget="_blank" target="_blank"  enctype="multipart/form-data">
    @csrf
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Ubaya Pihak ke:</label>
      <div class="col-sm-1">
        <select name="pihakKe" class="form-control" onchange="" value="{{$pihakUbaya}}">
          <option value="1">1</option>
          <option value="2">2</option>
        </select>
      </div>
    </div>
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">No Surat Keluar:</label>
      <div class="col-sm-4">  
        <input type="input" class="form-control" name="noSurat" value='{{str_replace("-","/",$s[0]->nomor_surat)}}' required readonly>
      </div>
    </div>  
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Tanggal Kirim:</label>
      <div class="col-sm-4"> 
        <input type="date" class="form-control" name="Tanggal" style="width: 200px;" value="{{ date('Y-m-d', strtotime($s[0]->tanggal_kirim)) }}" required>
      </div>
    </div>  
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Instansi Rekan:</label>
      <div class="col-sm-4"> 
        <input type="input" class="form-control" name="pihak2" style="width: 200px;" value="{{$namaRekan}}" required>
      </div>
    </div> 
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Perihal Kerja Sama:</label>
      <div class="col-sm-4"> 
        <input type="input" class="form-control" name="perihal" style="width: 300px;" value="{{$s[0]->perihal}}" required>
      </div>
    </div> 
    <div>
      <b style="font-size: 20px;"> Data Rekan </b><br/><br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Perwakilan Rekan:</label>
        <div class="col-sm-4"> 
          <input type="input" class="form-control" name="wakilRkn" value="{{$perwakilanRkn}}" required>
        </div>
      </div> 
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Jabatan Perwakilan Rekan:</label>
        <div class="col-sm-4">
          <input type="input" class="form-control" name="jabatanRkn" value="{{$jabatanWPR}}" required>
        </div>
      </div> 
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Nomor Telepon Rekan:</label>
        <div class="col-sm-4">
          <input type="input" class="form-control" name="noTelpRkn" value="{{$teleponRkn}}">
        </div>
      </div> 
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Nomor HP Rekan:</label>
        <div class="col-sm-4">
          <input type="input" class="form-control" name="noHPRkn" value="{{$hpRkn}}">
        </div>
      </div> 
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Alamat Rekan:</label>
        <div class="col-sm-4">
          <input type="input" class="form-control" name="alamatRkn" value="{{$alamatRkn}}" required>
        </div>
      </div> 
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Email Rekan:</label>
        <div class="col-sm-4">
          <input type="input" class="form-control" name="emailRkn" value="{{$emailRkn}}" required>
        </div>
      </div> 
    </div>
    <br/>
    <div>
      <b style="font-size: 20px;"> Ruang Lingkup Perjanjian </b> <br/><br/>
      <label class="bold">Pertimbangan Perjanjian (jika tidak diisi akan mengikuti template)</label>
      <textarea name="pertPerjanjian" id="pertPerjanjian" rows="8" class="form-control">{{$pertPerjanjian}}</textarea>
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Pihak Rekan:</label>
          <div class="col-sm-4">
          <input type="input" class="form-control" name="lingkupRkn" value="{{$lingkupRkn}}" required>
        </div>
      </div> 
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Pihak Bioteknologi:</label>
        <div class="col-sm-4">
          <input type="input" class="form-control" name="lingkupBiotek" value="{{$lingkupUby}}" required>
        </div>
      </div> 
    </div>
    <br/>
    <div>
      <b style="font-size: 20px;"> Hak dan Kewajiban </b> <br/><br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Kewajiban Bioteknologi:</label>
        <div class="col-sm-4">
          <textarea name="kewajibanBiotek" id="kewajibanBiotek" rows="8" class="form-control" style="width: 100%;" required>{{$kewajibanUby}}</textarea>
        </div>
      </div> 
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Kewajiban Rekan:</label>
        <div class="col-sm-4">
          <textarea name="kewajibanRkn" id="kewajibanRkn" rows="8" class="form-control" style="width: 100%;" required>{{$kewajibanRkn}}</textarea>
        </div>
      </div> 
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Hak Bioteknologi:</label>
        <div class="col-sm-4">
          <textarea name="hakBiotek" id="hakBiotek" rows="8" class="form-control" style="width: 100%;" required>{{$hakUby}}</textarea>
        </div>
      </div>
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Hak Rekan:</label>
        <div class="col-sm-4">
          <textarea name="hakRkn" id="hakRkn" rows="8" class="form-control" style="width: 100%;" required>{{$hakRkn}}</textarea>
        </div>
      </div>
    </div>
    <br/>
    <div>
      <b style="font-size: 20px;"> Pelaksanaan Kerjasama </b> <br/><br/>
        <label class="required bold">Pelaksanaan Kerjasama</label>
        <textarea name="pelaksanaanKj" id="pelaksanaanKj" rows="8" class="form-control" required>{{$pelaksanaan}}</textarea>
    </div>
    <br/>
    <div>
      <b style="font-size: 20px;"> Biaya-Biaya </b> <br/><br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Pihak Pembayar</label>
        <div class="col-sm-4">
          <select name="pihakPembayar" class="form-control" onchange="" value="{{$pihakPembayar}}">
            <option value="1">Bioteknologi</option>
            <option value="2">Rekan</option>
          </select>
        </div>
      </div>
      <br/>
      <div class="form-group row">
        <label class="required bold col-sm-2 col-form-label">Jumlah Pembayaran</label>
        <div class="col-sm-4">
          <input type="input" class="form-control" name="jumlahBayar" value="{{$jumlahBayar}}" required>
        </div>
      </div>
    </div>
    <br/>
    <label class="bold">Ketentuan Pembayaran (Jika dikosongi akan mengikuti template)</label>
    <textarea name="ktnPembayaran" id="ktnPembayaran" rows="8" class="form-control">{{$ktnPembayaran}}</textarea>
    <br/>
    <label class="required bold">Pembayaran dilakukan melalui</label>
    <textarea name="caraPembayaran" id="caraPembayaran" rows="8" class="form-control" required>{{$caraPembayaran}}</textarea>
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Batas Waktu Perjanjian</label>
      <div class="col-sm-4">
        <input type="date" class="form-control" name="tanggalSelesai" value="{{date('Y-m-d', $tanggalsl)}}" required>
      </div>
    </div>
    <br/>
    <div>
      <b style="font-size: 20px;"> Pasal Tambahan (jika tidak diisi akan mengikuti template) </b> <br/><br/>
      <label class="bold">Force Majeur</label>
      <textarea name="forcMajeur" id="forcMajeur" rows="8" class="form-control">{{$forcMajeur}}</textarea>
      <br/>
      <label class="bold">Sanksi</label>
      <textarea name="sanksi" id="sanksi" rows="8" class="form-control">{{$sanksi}}</textarea>
      <br/>
      <label class="bold">Penyelesaian Perselisihan</label>
      <textarea name="penyPerselisihan" id="penyPerselisihan" rows="8" class="form-control">{{$penyPerselisihan}}</textarea>
    </div>
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