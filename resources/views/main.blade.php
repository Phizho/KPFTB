@extends('layout.conquer')

@section('tempat_konten')
<head>
</head>

<body>
    <form method="POST" action="#" enctype="multipart/form-data">
      <div class="form-group">
        <div>Kriteria Pencarian</div>
        <label>Tanggal Awal:</label>
        <input type="date" class="form-control" name="TanggalA">
        <br/>
        <label>Tanggal Berakhir:</label>
        <input type="date" class="form-control" name="TanggalB">
        <br/>
        <label>No Surat</label>
        <input type="input" class="form-control" name="noSurat">
        <br/>
        <label>Perihal</label>
        <input type="input" class="form-control" name="perihal">
        <br/>
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

    <a href="/buatsurat">
      <button class="btn btn-primary" >Tambah Surat</button>
    </a>
    <br/>

    <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>No. Surat Keluar Dekan</th>
            <th>Perihal</th>
            <th>Tanggal Kirim</th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
            <tbody>

            </tbody>
    </table>

</body>
@endsection