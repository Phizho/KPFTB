@extends('layout.conquer')

@section('tempat_titleatas')
<title>Surat Keluar</title>
@endsection

@section('tempat_judul')
<p style="text-align: center;">DAFTAR SURAT KELUAR</p>
@endsection

@section('tempat_konten')

@if (session('status'))
<div class="alert alert-success" role="alert">
  {{ session('status') }}
</div>
@endif

<head>
</head>

<body>
  <button onclick=showSearch() id="button-search" class="btn btn-primary">Search</button>
  <form method="GET" action="{{ route('surats.search') }}" enctype="multipart/form-data">
    <div class="form-group" id="search" style="display: none;">
      <div>Kriteria Pencarian</div>
      <br />
      <label>Tanggal Buat:</label>
      <input type="date" class="form-control" name="TanggalA">
      <br />
      <label>Tanggal Kirim:</label>
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
      <button onclick=showSearch() type="button" class="btn btn-primary">Tutup</button>
    </div>
  </form><br/>

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
          {{str_replace("-","/",$l->nomor_surat)}}
        </td>
        <td>
          {{$l->perihal}}
        </td>
        <td>
          {{$l->jenis_surat}}
        </td>
        <td>
          @isset($l->ns)
          @for($i=1;$i<=$l->jumlah_lampiran; $i++)
            <a href='{{URL::asset("assets/pdf/$l->nomor_surat/$i.{$l->fl}")}}' download>{{$i}}</a>
            @endfor
            @endisset
        </td>
        <td>
          {{$l->tanggal_kirim}}
        </td>
        @php
          $h = str_replace("/","-",$l->nomor_surat);
          $he = explode("-",$h);
        @endphp
        @if ($he[1] === "DEK" || $he[1] === "WD" || $he[1] === "Mag-Bioteknologi" ) 
          <td><a href="{{ url('surats/' . $h . '/edit') }}"><img src="{{URL::asset('assets/img/edit.png')}}"></a> </td>
        @elseif ($he[1] === "SK")
          <td><a href="{{ url('surats/' . $h . '/editKep') }}"><img src="{{URL::asset('assets/img/edit.png')}}"></a> </td>
        
        @endif
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        
        <td><a onclick='hapus("{{ $l->nomor_surat }}")'><img src="{{URL::asset('assets/img/delete.png')}}"></a> </td>
        <td><a href='{{URL::asset("assets/pdf/$h/{$h}srtutm.pdf")}}' target="_new"><img src="{{URL::asset('assets/img/pdf.png')}}"></a> </td>
        @endforeach
    </tbody>
  </table>

  <p>Showing {{ $lamp->firstItem() }} to {{ $lamp->lastItem() }} items from {{ $lamp->total() }}</p>
  <div style="text-align: right;">{{ $lamp->links() }}</div>

</body>
@endsection

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  function showSearch() {
    var x = document.getElementById("search");
    var but = document.getElementById("button-search")
    if (x.style.display === "none") {
      x.style.display = "block";
      but.style.display = "none";
    } else {
      x.style.display = "none";
      but.style.display = "block";
    }
  }

  function hapus(noSurat) {
    swal({
        title: 'Apakah anda yakin?',
        text: 'Keseluruhan surat dan lampirannya akan dihapus',
        icon: 'warning',
        buttons: ["Cancel", "Hapus"],
    }).then(function(value) {
        if (value) {
          $.ajax({
            type: 'POST',
            url: '{{ route("surats.hapus") }}',
            data: {
              '_token': '<?php echo csrf_token() ?>',
              'noSurat': noSurat
            },
            success: function(data){
              location.reload()
            }
          });
        }
    });
    
  }
</script>