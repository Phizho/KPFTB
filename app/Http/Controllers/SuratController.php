<?php

namespace App\Http\Controllers;

use App\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Lampiran;
use PDF;
use Illuminate\Support\Facades\File;
use Storage;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$surat = DB::table('surats')->get();
        $lamp = DB::table('lampirans')
            ->select(DB::raw('count(*) as jumlah_lampiran, surats.*, lampirans.nomor_surat as ns, lampirans.format_lampiran as fl'))
            ->distinct()
            ->rightJoin('surats', 'lampirans.nomor_surat', '=', 'surats.nomor_surat')
            ->groupBy('surats.nomor_surat', 'surats.perihal', 'surats.jenis_surat', 'surats.created_at', 'surats.updated_at', 'lampirans.nomor_surat', 'surats.tanggal_kirim', 'lampirans.format_lampiran')
            ->paginate(5);

        return view('surats.index', compact('lamp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('surats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Surat;
        $data->nomor_surat = $request->get('noSurat');
        $data->perihal = $request->get('perihal');
        $data->tanggal_kirim = $request->get('Tanggal');
        $data->jenis_surat = $request->get('jenis');

        $checkbox = $request->input('tcheck');
        $kepada = $request->get('kepada');
        $count = $request->get('count');

        $row = $request->get('jumrow');
        $col = $request->get('jumcol');

        $data->save();
        $isi = $request->get('isiSurat');

        $folderPath = public_path("assets/pdf/$data->nomor_surat");
        $response = mkdir($folderPath);

        if ($count >= 1) {
            for ($i = 1; $i <= $count; $i++) {
                $lam = new lampiran;
                $file = $request->file("uploadfile{$i}");
                $ext = $file->clientExtension();
                $file->move($folderPath, "{$i}.{$ext}");
                $lam->nama_lampiran = basename($file->getClientOriginalName(), ".{$ext}");
                $lam->format_lampiran = $ext;
                $lam->nomor_surat = $request->get('noSurat');
                $lam->save();
            }
        }

        $fixIsi = "<br/><br/><br/><div>Kepada Yth,<br/>
                    $kepada <br/>
                    Universitas Surabaya
            </div>
            <br/><br/><br/>
            <div>
                Dengan Hormat,
                <br/><br/>
                $isi
            </div>
            <br/>";

        if (isset($checkbox)) {
            $fixIsi .= "<table style='border: 1px solid black; border-collapse: collapse;'>";
            
            for ($i = 1; $i <= $row; $i++) {
                $fixIsi .= "<tr style='border: 1px solid black; border-collapse: collapse;'>";
                for ($j = 1; $j <= $col; $j++){
                  $td = $request->get("instr${i}td${j}");
                  $fixIsi .= "<td  style='width: 200px; border: 1px solid black; border-collapse: collapse;'>$td</td>";
                }
                $fixIsi .= '</tr>';
            } 
            $fixIsi .= "</table></br>";
        }

        $fixIsi .="<div>
                Bersama ini terlampir kami sampaikan:
                <ol>
                    <li>Lampiran1</li>
                    <li>Lampiran2</li>
                </ol>
            </div>
            <div>
                Demikian hal ini disampaikan, atas perhatian dan kerjasama yang baik, kami mengucapkan terimakasih.
            </div>
            <br/><br/><br/><br/>
            <div style='text-align: right;'>
                Tanda Tangan Here
            </div>
            <br/><br/>";
            
        Storage::disk('public_pdfs')->put("$data->nomor_surat/file.txt", $fixIsi);
        $pdf = PDF::loadHTML($fixIsi);
        $fileName = "$data->nomor_surat" . "srtutm";
        $pdf->save($folderPath . '/' . $fileName . '.pdf');
        //return $pdf->stream();

        return redirect()->route('surats.index')->with('status', 'Surat berhasil dibuat!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $jumlahLamp = $request->get("count");
        $noSurat = $request->get("noSurat");
        $tanggalBuat = $request->get("TanggalA");
        $tanggalKirim = $request->get("TanggalB");
        $perihal = $request->get("perihal");

        $lamp = DB::table('lampirans')
            ->select(DB::raw('count(*) as jumlah_lampiran, surats.*, lampirans.nomor_surat as ns'))
            ->distinct()
            ->rightJoin('surats', 'lampirans.nomor_surat', '=', 'surats.nomor_surat')
            ->groupBy('surats.nomor_surat', 'surats.perihal', 'surats.jenis_surat', 'surats.created_at', 'surats.updated_at', 'lampirans.nomor_surat')
            ->when($noSurat, function ($q) use ($noSurat) {
                return $q->where('surats.nomor_surat', 'like', "$noSurat" . "%");
            })
            ->when($tanggalBuat, function ($q) use ($tanggalBuat) {
                return $q->where('surats.created_at', '=', "$tanggalBuat");
            })
            ->when($tanggalKirim, function ($q) use ($tanggalKirim) {
                return $q->where('surats.nomor_surat', '=', "$tanggalKirim");
            })
            ->when($perihal, function ($q) use ($perihal) {
                return $q->where('surats.perihal', 'like', "%" . "$perihal" . "%");
            })
            ->paginate(5);

        return view('surats.index', compact('lamp'));
    }

    public function hapus()
    {
        // dd($noSurat);
        $noSurat = $_POST['noSurat'];
        $hapus = Surat::where('nomor_surat', $_POST['noSurat'])->delete();
        $folderPath = public_path("assets/pdf/$noSurat");
        File::deleteDirectory($folderPath);
        // $response = rmdir($folderPath);
        return response()->json(array(
            'status' => 'ok',
        ), 200);
        // $lamp = DB::table('lampirans')
        //      ->select(DB::raw('count(*) as jumlah_lampiran, surats.*, lampirans.nomor_surat as ns, lampirans.format_lampiran as fl'))
        //      ->distinct()
        //      ->rightJoin('surats', 'lampirans.nomor_surat', '=', 'surats.nomor_surat')
        //      ->groupBy('surats.nomor_surat', 'surats.perihal', 'surats.jenis_surat', 'surats.created_at', 'surats.updated_at','lampirans.nomor_surat','surats.tanggal_kirim','lampirans.format_lampiran')
        //      ->paginate(5);

        // return view('surats.index', compact('lamp'));
    }
}
