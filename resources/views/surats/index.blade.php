@extends('layout.conquer')

@section('tempat_judul')
<p style="text-align: center;">DAFTAR SURAT KELUAR</p>
@endsection

@section('tempat_konten')

<head>
</head>

<body>
  <form method="POST" action="#" enctype="multipart/form-data">
    <div class="form-group">
      <div>Kriteria Pencarian</div>
      <label>Tanggal Awal:</label>
      <input type="date" class="form-control" name="TanggalA">
      <br />
      <label>Tanggal Berakhir:</label>
      <input type="date" class="form-control" name="TanggalB">
      <br />
      <label>No Surat</label>
      <input type="input" class="form-control" name="noSurat">
      <br />
      <label>Perihal</label>
      <input type="input" class="form-control" name="perihal">
      <br />
      <label>Jenis Surat</label>
      <select name="jenis">
        <option value="1">Semua</option>
        <option value="2">Surat Keluar Dekan</option>
        <option value="3">Surat Keluar Wakil Dekan</option>
        <option value="4">Surat Keluar Kaprodi Magister Bioteknologi</option>
        <option value="5">Surat Kerja Sama</option>
        <option value="6">Surat Keputusan Dekan</option>
      </select>
      <button type="submit" class="btn btn-primary">Cari</button>
    </div>
  </form>

  <a href="/surats/create">
    <button class="btn btn-primary">Tambah Surat</button>
  </a>
  <br /><br>

  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>No. Surat Keluar Dekan</th>
        <th>Perihal</th>
        <th>Jenis Surat</th>
        <th>Lampiran</th>     
        <th>Tanggal Kirim</th>
        <th></th>
        <th></th>
        <th></th> 
      </tr>
    </thead>
    <tbody>
      @foreach($lamp as $l)
      <tr id='tr_{{$l->nomor_surat}}'>
        <td id='td_{{$l->created_at}}'> 
            {{$l->created_at}}
        </td> 
        <td> 
            {{$l->nomor_surat}}
        </td> 
        <td> 
            {{$l->perihal}}
        </td> 
        <td>
            {{$l->jenis_surat}}
          </td>
        <td>
            @for($i=1;$i<=$l->jumlah_lampiran; $i++)
              <a>{{$i}}
            @endfor
        </td>
        <td> </td>
        <td><a><img src="{{URL::asset('assets/img/icons8-edit-48.png')}}"></a> </td>
        <td><a><img src="{{URL::asset('assets/img/icons8-delete-48.png')}}"></a> </td>
        <td><a><img src="{{URL::asset('assets/img/icons8-pdf-40.png')}}"></a> </td>
      @endforeach
    </tbody>
  </table>

</body>
@endsection