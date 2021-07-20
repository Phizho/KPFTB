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
        setlocale(LC_ALL, 'IND');
        $data->nomor_surat = str_replace("/","-",$request->get('noSurat'));
        $ns = $request->get('noSurat');
        $data->perihal = $request->get('perihal');
        $data->tanggal_kirim = $request->get('Tanggal');
        $date = date('d-m-Y', strtotime($data->tanggal_kirim));
        $d = strftime('%d %B %Y');
        $data->jenis_surat = $request->get('jenis');
        $jen = $request->get('jenis');

        $data->save();

        $lampiran = $request->get('lampiran');
        $penutup = $request->get('penutup');
        $checkbox = $request->input('tcheck');
        $kepada = $request->get('kepada');
        $count = $request->get('count');

        $row = $request->get('jumrow');
        $col = $request->get('jumcol');

        $isi = $request->get('isiSurat');

        $folderPath = public_path("assets/pdf/$data->nomor_surat");
        $ubayaPath = public_path("assets/LogoUbayaSml.png");
        $ftbPath = public_path("assets/LogoFTB.png");
        $ttDEKPath = public_path("assets/TTDekan.png");
        $ttKPDMPath = public_path("assets/TTKaprodiM.png");
        $response = mkdir($folderPath);

        if ($jen = 5) {
            $fixIsipdf = "<center><b><div>KEPUTUSAN<br/>DEKAN FAKULTAS TEKNOBIOLOGI UNIVERSITAS SURABAYA<br/>NOMOR: $ns<br/>Tentang<br/>$data->perihal</div><hr><br/><div>DEKAN FAKULTAS TEKNOBIOLOGI UNIVERSITAS SURABAYA</div></b></center><br/>";
            $fixIsipdf.= "MENIMBANG : Dalam Rangka<br/><br/>";
            $fixIsipdf.= "MENGINGAT : Dalam Rangka<br/><br/>";
            $fixIsipdf.= "<br/><b>MENETAPKAN</b><br/><br/>";
            $fixIsipdf.= "Pertama<br/><br/>";
            $fixIsipdf.= "Ditetapkan di  : Surabaya<br/>Pada Tanggal  : $d<br/>Dekan,
            <br/><img src='$ttDEKPath' width='213' height='135'><br/>
            Dr.rer.nat. Sulistyo Emantoko D.P., S.Si., M.Si         
            </div>
            <br/><br/>";
        } else {
        $fixIsi = "$lampiran<br/>$ns<br/>$data->perihal<br/>$date<br/>$kepada<br/>$isi<br/>$penutup<br/>";
        $fixIsipdf = "<div><img src='$ubayaPath' width='255' height='75'><img src='$ftbPath' width='255' height='75' style='float: right;'></div><br/><br/><br/><div style=' width: 100%; text-align: right; float: right;'>$d</div>Nomor : $ns <br/>Lampiran : $lampiran<br/> Perihal : <b>$data->perihal</b><br/></p>
        <br/><br/><br/><div>Kepada Yth,<br/>$kepada <br/>Universitas Surabaya</div>
            <br/><br/>
            <div>
                Dengan Hormat,
                <br/><br/>$isi
            <br/>
            </div>
            <br/>";

        if (isset($checkbox)) {
            $fixIsi .= "<table style='border: 1px solid black; border-collapse: collapse; width: 100%;'>";
            $fixIsipdf .= "<table style='border: 1px solid black; border-collapse: collapse; width: 100%;'>";
            
            for ($i = 1; $i <= $row; $i++) {
                $fixIsi .= "<tr style='border: 1px solid black; border-collapse: collapse;'>";
                $fixIsipdf .= "<tr style='border: 1px solid black; border-collapse: collapse;'>";
                for ($j = 1; $j <= $col; $j++){
                  $td = $request->get("instr${i}td${j}");
                  $fixIsi .= "<td  style=' border: 1px solid black; border-collapse: collapse;'><div>^$td^</div></td>";
                  $fixIsipdf .="<td  style='border: 1px solid black; border-collapse: collapse;'><div>$td</div></td>";
                }
                $fixIsi .= '</tr>';
                $fixIsipdf .= '</tr>';
            } 
            $fixIsi .= "</table>";
            $fixIsipdf .= "</table>";
        }

        if ($count >= 1) {
            $fixIsi .="</br>";
            $fixIsipdf .="</br></br><div>
                    Bersama ini terlampir kami sampaikan:
                    <ol></br>";
            for ($i = 1; $i <= $count; $i++) {
                $lam = new lampiran;
                $file = $request->file("uploadfile{$i}");
                $ext = $file->clientExtension();
                
                $namaLam = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
                $fixIsi.="<li>$namaLam</li>";
                $fixIsipdf.="<li>$namaLam</li>";

                $file->move($folderPath, "{$i}.{$ext}");
                $lam->nama_lampiran = basename($file->getClientOriginalName(), ".{$ext}");
                $lam->format_lampiran = $ext;
                $lam->nomor_surat = str_replace("/","-",$request->get('noSurat'));
                $lam->save();
            }
            $fixIsi .="</br></div>";
            $fixIsipdf .="</ol></br></div>";
        }
        if($jen == 3) {    
            $fixIsipdf .="<br/><div>$penutup
        </div>
        <br/><br/><br/>
        <div style='text-align: left;'>
            <p>
            Hormat Kami, <br/>
            Dekan Fakultas Teknobiologi
            </p>
            <img src='$ttKPDMPath' width='213' height='135'><br/>
            Dr.Tjie Kok, S.Si., M.Si., Apt         
        </div>
        <br/><br/>";
        } else {
            $fixIsipdf .="<br/><div>$penutup
        </div>
        <br/><br/><br/>
        <div style='text-align: left;'>
            <p>
            Hormat Kami, <br/>
            Dekan Fakultas Teknobiologi
            </p>
            <img src='$ttDEKPath' width='213' height='135'><br/>
            Dr.rer.nat. Sulistyo Emantoko D.P., S.Si., M.Si         
        </div>
        <br/><br/>";
        }
        }
            
        Storage::disk('public_pdfs')->put("$data->nomor_surat/file.txt", $fixIsi);
        $pdf = PDF::loadHTML($fixIsipdf);
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
        //$idc = str_replace("-","/",$id);
        $s = DB::table('surats')
            ->select(DB::raw('*'))
            ->where('nomor_surat', $id)
            ->get();
        
        $l = DB::table('lampirans')
            ->select(DB::raw('*'))
            ->where('nomor_surat', $id)
            ->get();

            $p = Storage::disk('public_pdfs')->getAdapter()->getPathPrefix();
            
            $path = "C:/xampp/htdocs/KPFTB/public/assets/pdf/".$id."/file.txt";
            $txtFile = file_get_contents("$path");

            $fullText = explode('<br/>',$txtFile);
            $la = $fullText[0];
            $kepada = $fullText[4];
            $isiSurat = $fullText[5];
            $fulltable = $fullText[7];
            $penutup = $fullText[6];

            $arrayNama = array();
            $arrayExtension = array();
            
            if (count($l) >= 1) {
                $lampiran = explode('</br>',$txtFile);
                $perlamp = explode('<li>',$lampiran[1]);
                for ($i = 0; $i < count($l); $i++) {
                    $nL = explode('</li>',$perlamp[$i+1]);

                    array_push($arrayNama, $nL[0]);

                    $format = DB::table('lampirans')
                        ->where('nomor_surat', $id)
                        ->where('nama_lampiran', $nL[0])
                        ->value('format_lampiran');
                    
                    array_push($arrayExtension, $format);
                }
            }
            
            $arraytable = explode("^",$fulltable);
            $row = explode ("<tr ", $fulltable);
            $countrow = count($row);
            $counttable = count($arraytable);


        if ($counttable >= 1 ) {
            if (count($l) >= 1) {
                return view('surats.edit', compact('s','isiSurat','kepada','arraytable','counttable','countrow','arrayNama','arrayExtension','penutup','la'));
            } else {
                return view('surats.edit', compact('s','isiSurat','kepada','arraytable','counttable','countrow','penutup','la'));
            }   
        }
        else {
            if (count($l) >= 1) {
                return view('surats.edit', compact('s','isiSurat','kepada','arrayNama','arrayExtension','penutup','la'));
            } else {
                return view('surats.edit', compact('s','isiSurat','kepada','penutup','la'));
            }       
        }
        
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
        //$idc = str_replace("-","/",$id);
        setlocale(LC_ALL, 'IND');
        $perihal = $request->get("perihal");
        $jenis = $request->get("jenis");
        $tanggal = $request->get('Tanggal');
        $tglbuat = $request->get('tglbuat');
        $date = strftime('%d %B %Y', strtotime($tglbuat));

        DB::table('surats')
            ->where('nomor_surat', $id)
            ->update(['perihal' => $perihal,'jenis_surat' => $jenis,'tanggal_kirim' => $tanggal]);

        $penutup = $request->get('penutup');
        $checkbox = $request->input('tcheck');
        $kepada = $request->get('kepada');
        $count = $request->get('count');
        $lampiran = $request->get('Lampiran');

        $row = $request->get('jumrow');
        $col = $request->get('jumcol');

        $isi = $request->get('isiSurat');
        $ubayaPath = public_path("assets/LogoUbayaSml.png");
        $ftbPath = public_path("assets/LogoFTB.png");

        $folderPath = public_path("assets/pdf/$id");
        $ttDEKPath = public_path("assets/TTDekan.png");
        $ttKPDMPath = public_path("assets/TTKaprodiM.png");

        $fixIsi = "$lampiran<br/>$id<br/>$perihal<br/>$date<br/>$kepada<br/>$isi<br/>$penutup<br/>";
        $fixIsipdf = "<div><img src='$ubayaPath' width='255' height='75'><img src='$ftbPath' width='255' height='75' style='float: right;'></div><br/><br/><br/><div style=' width: 100%; text-align: right; float: right;'>$date</div>Nomor : $id <br/>Lampiran : $lampiran<br/> Perihal : <b>$perihal</b><br/></p>
        <br/><br/><br/><div>Kepada Yth,<br/>$kepada <br/>Universitas Surabaya</div>
            <br/><br/>
            <div>
                Dengan Hormat,
                <br/><br/>$isi
            <br/>
            </div>
            <br/>";
            
        if (isset($checkbox)) {
            $fixIsi .= "<table style='border: 1px solid black; border-collapse: collapse; width: 100%;' >";
            $fixIsipdf .= "<table style='border: 1px solid black; border-collapse: collapse; width: 100%;'>";
            
            for ($i = 1; $i <= $row; $i++) {
                $fixIsi .= "<tr style='border: 1px solid black; border-collapse: collapse;'>";
                $fixIsipdf .= "<tr style='border: 1px solid black; border-collapse: collapse;'>";
                for ($j = 1; $j <= $col; $j++){
                    $td = $request->get("instr${i}td${j}");
                    $fixIsi .= "<td  style='border: 1px solid black; border-collapse: collapse;'><div>^$td^</div></td>";
                    $fixIsipdf .="<td  style=' border: 1px solid black; border-collapse: collapse;'><div>$td</div></td>";
                }
                $fixIsi .= '</tr>';
                $fixIsipdf .= '</tr>';
            } 
            $fixIsi .= "</table>";
            $fixIsipdf .= "</table>";
        }

        if ($count >= 1) {
            $fixIsi .="</br>";
            $fixIsipdf .="</br></br><div>
                    Bersama ini terlampir kami sampaikan:
                    <ol></br>";
            for ($i = 1; $i <= $count; $i++) {
                $lam = new lampiran;
                $file = $request->file("uploadfile{$i}");
                $cek = $request->get("lampuploadfile{$i}");

                $f = explode('.',$cek);
                if(isset($cek)) {
                    if (isset($file)) {
                        $hapus = Lampiran::where('nomor_surat','=', $id)->where('nama_lampiran','=', $f[0])->delete();
                        $filePath = public_path("assets/pdf/$id/$i.$f[1]");
                        File::delete($filePath);
                        $ext = $file->clientExtension();

                        $namaLam = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
                        $fixIsi.="<li>$namaLam</li>";
                        $fixIsipdf.="<li>$namaLam</li>";
                        
                        $folderPath = public_path("assets/pdf/$id");
                        $file->move($folderPath, "{$i}.{$ext}");
                        $lam->nama_lampiran = basename($file->getClientOriginalName(), ".{$ext}");
                        $lam->format_lampiran = $ext;
                        $lam->nomor_surat = $request->get('noSurat');
                        $lam->save();
                    } else {
                        $namaLam = $f[0];
                        $fixIsi.="<li>$namaLam</li>";
                        $fixIsipdf.="<li>$namaLam</li>";
                    }
                    
                } else {
                    if (isset($file)) {
                        $ext = $file->clientExtension();
                        $namaLam = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
                        $fixIsi.="<li>$namaLam</li>";
                        $fixIsipdf.="<li>$namaLam</li>";
    
                        $folderPath = public_path("assets/pdf/$id");
                        $file->move($folderPath, "{$i}.{$ext}");
                        $lam->nama_lampiran = basename($file->getClientOriginalName(), ".{$ext}");
                        $lam->format_lampiran = $ext;
                        $lam->nomor_surat = $request->get('noSurat');
                        $lam->save();
                    } 
                }           
            }
            $fixIsi .="</br>";
            $fixIsipdf .="</ol></br></div>";
        }
            $fixIsipdf .="<br/><div>$penutup
            </div>
            <br/><br/><br/>
            <div style='text-align: left;'>
                <p>
                Hormat Kami, <br/>
                Dekan Fakultas Teknobiologi
                </p>
                <img src='$ttDEKPath' width='213' height='135'><br/>
                Dr.rer.nat. Sulistyo Emantoko D.P., S.Si., M.Si         
            </div>
            <br/><br/>";
            
        Storage::disk('public_pdfs')->put("$id/file.txt", $fixIsi);
        $pdf = PDF::loadHTML($fixIsipdf);
        $fileName = "$id" . "srtutm";
        $pdf->save($folderPath . '/' . $fileName . '.pdf');

        return redirect()->route('surats.index')->with('status','Surat berhasil di edit');
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
            ->select(DB::raw('count(*) as jumlah_lampiran, surats.*, lampirans.nomor_surat as ns, lampirans.format_lampiran as fl'))
            ->distinct()
            ->rightJoin('surats', 'lampirans.nomor_surat', '=', 'surats.nomor_surat')
            ->groupBy('surats.nomor_surat', 'surats.perihal', 'surats.jenis_surat', 'surats.created_at', 'surats.updated_at', 'lampirans.nomor_surat','surats.tanggal_kirim','lampirans.format_lampiran')
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
            ->paginate(100);
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

    public function generateNO(Request $request) {
        if ($request->vl == 1) {
            $s = DB::table('surats')
            ->select(DB::raw('max(surats.nomor_surat) mns, created_at'))
            ->where('surats.jenis_surat', '=', 'Keluar Dekan')
            ->groupBy('surats.created_at')
            ->orderBy('created_at','desc')
            ->limit(1)
            ->get();
        } else if ($request->vl == 2) {
            $s = DB::table('surats')
            ->select(DB::raw('max(surats.nomor_surat) mns, created_at'))
            ->where('surats.jenis_surat', '=', 'Keluar Wakil Dekan')
            ->groupBy('surats.created_at')
            ->orderBy('created_at','desc')
            ->limit(1)
            ->get();
        } else if ($request->vl == 3) {
            $s = DB::table('surats')
            ->select(DB::raw('max(surats.nomor_surat) mns, created_at'))
            ->where('surats.jenis_surat', '=', 'Keluar Kaprodi Magister Bioteknologi')
            ->groupBy('surats.created_at')
            ->orderBy('created_at','desc')
            ->limit(1)
            ->get();
        } else if ($request->vl == 4) {
            $s = DB::table('surats')
            ->select(DB::raw('max(surats.nomor_surat) mns, created_at'))
            ->where('surats.jenis_surat', '=', 'Kerja Sama')
            ->groupBy('surats.created_at')
            ->orderBy('created_at','desc')
            ->limit(1)
            ->get();
        } else if ($request->vl == 5) {
            $s = DB::table('surats')
            ->select(DB::raw('max(surats.nomor_surat) mns, created_at'))
            ->where('surats.jenis_surat', '=', 'Keputusan Dekan')
            ->groupBy('surats.created_at')
            ->orderBy('created_at','desc')
            ->limit(1)
            ->get();
        }

        return response()->json(['success'=>$s[0]->mns]);
    }
}
