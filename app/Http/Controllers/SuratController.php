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

    public function createKep()
    {
        return view('surats.createKep');
    }

    public function createKerj()
    {
        return view('surats.createKerj');
    }

    public function opsi() {     
        $path = "C:/xampp/htdocs/KPFTB/public/assets/opsi.txt";
        $txtFile = file_get_contents("$path");

        $fullText = explode('|',$txtFile);
        $namaDekan = $fullText[0];
        $namaWakilDekan = $fullText[1];
        $namaMagisterKaprodi = $fullText[2];

        return view('surats.opsi', compact('namaDekan','namaWakilDekan','namaMagisterKaprodi'));
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
        $footerPath = public_path("assets/FooterFix.png");
        $ubayaPath = public_path("assets/LogoUbayaSml.png");
        $ftbPath = public_path("assets/LogoFTB.png");
        $ttDEKPath = public_path("assets/TTDekan.png");
        $ttWaDekPath = public_path("assets/TTWaDekan.png");
        $ttKPDMPath = public_path("assets/TTKaprodiM.png");
        $response = mkdir($folderPath);

        $path = "C:/xampp/htdocs/KPFTB/public/assets/opsi.txt";
        $opsi = file_get_contents("$path");

        $listnama = explode('|',$opsi);
        $namaDekan = $listnama[0];
        $namaWakilDekan = $listnama[1];
        $namaMagisterKaprodi = $listnama[2];

            $fixIsi = "$lampiran<br/>$ns<br/>$data->perihal<br/>$date<br/>$kepada<br/>$isi<br/>$penutup<br/>";
            $fixIsipdf ="<html><head><style> @page { margin: margin: 0cm 0cm; } body { margin-top: 3cm; margin-left: 2cm; margin-right: 2cm; margin-bottom: 2cm; }";
            $fixIsipdf.="header { position: fixed; top: 0cm; left: 0cm; right: 0cm; height: 1cm; } footer { position: fixed;  bottom: 0cm;  left: 0cm;  right: 0cm; height: 2cm; }";
            $fixIsipdf.="</style></head>";
            $fixIsipdf.= "<header><img src='$ubayaPath' width='255' height='75' style='margin-left: 1cm; margin-top: 1cm;'><img src='$ftbPath' width='255' height='75' style='float: right; margin-right: 1cm; margin-top: 1cm;'></header><br/><br/><br/>";
            $fixIsipdf.="<footer><img src='$footerPath' width='100%'></footer>";
            $fixIsipdf.= "<body><div style=' width: 100%; text-align: right; float: right;'>$d</div>Nomor : $ns <br/>Lampiran : $lampiran<br/> Perihal : <b>$data->perihal</b><br/></p>
            <br/><br/><br/><div>Kepada Yth,<br/>$kepada <br/>Universitas Surabaya</div>
                <br/><br/>
                <div style='text-align: justify; text-justify: inter-word;'>
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
                $fixIsipdf .="<br/><div style='text-align: justify; text-justify: inter-word;'>$penutup
            </div>
            <br/><br/><br/>
            <div style='text-align: left;'>
                <p>
                Hormat Kami, <br/>
                Kaprodi. Magister Teknobiologi
                </p>
                <img src='$ttKPDMPath' width='213' height='135'><br/>
                $namaMagisterKaprodi         
            </div>
            <br/><br/></body>";
            } else if ($jen == 1) {
                $fixIsipdf .="<br/><div style='text-align: justify; text-justify: inter-word;'>$penutup
            </div>
            <br/><br/><br/>
            <div style='text-align: left; page-break-inside: avoid;'>
                <p>
                Hormat Kami, <br/>
                Dekan Fakultas Teknobiologi
                </p>
                <img src='$ttDEKPath' width='213' height='135'><br/>
                $namaDekan         
            </div>
            <br/><br/></body>";
            } else if ($jen == 2) {
                $fixIsipdf .="<br/><div style='text-align: justify; text-justify: inter-word;'>$penutup
                </div>
                <br/><br/><br/>
                <div style='text-align: left; page-break-inside: avoid;'>
                    <p>
                    Hormat Kami, <br/>
                    Wakil Dekan Fakultas Teknobiologi
                    </p>
                    <img src='$ttWaDekPath' width='231' height='107'><br/>
                    $namaWakilDekan         
                </div>
                <br/><br/></body>";
            }
        $fixIsipdf.="</html>";
        Storage::disk('public_pdfs')->put("$data->nomor_surat/file.txt", $fixIsi);
        $pdf = PDF::loadHTML($fixIsipdf);
        $fileName = "$data->nomor_surat" . "srtutm";
        $pdf->save($folderPath . '/' . $fileName . '.pdf');
        
        //return $pdf->stream();

        return redirect()->route('surats.index')->with('status', 'Surat berhasil dibuat!!');
    }

    public function storeKerj(Request $request)
    {
        $data = new Surat;
        setlocale(LC_ALL, 'IND');
        $data->nomor_surat = str_replace("/","-",$request->get('noSurat'));
        $ns = $request->get('noSurat');
        $data->perihal = $request->get('perihal');
        $data->tanggal_kirim = $request->get('Tanggal');
        $date = date('d-m-Y', strtotime($data->tanggal_kirim));
        $d = strftime('%d %B %Y');
        
        $data->jenis_surat = 4;

        $data->save();

        $path = "C:/xampp/htdocs/KPFTB/public/assets/opsi.txt";
        $opsi = file_get_contents("$path");

        $listnama = explode('|',$opsi);
        $namaDekan = $listnama[0];
        $namaWakilDekan = $listnama[1];
        $namaMagisterKaprodi = $listnama[2];

        $hari = strftime('%A');
        $tanggal = strftime('%d');
        $bulan = strftime('%B');
        $tahun = strftime('%Y');

        $pihakUbaya = $request->get('pihakKe');
        $fixIsi = "$ns<br/>$data->perihal<br/>$pihakUbaya<br/>";
        if ($pihakUbaya == 1) {
            $namaPihak1 = "Fakultas Teknobiologi Surabaya";
            $alamatPihak1 = "Jalan Raya Kalirungkut, Surabaya 60293";
            $perwakilanPihak1 = "$namaDekan";
            $jabatanWP1 = "Dekan";
            $lingkup1 = $request->get('lingkupBiotek');
            $kewajiban1 = $request->get('kewajibanBiotek');
            $hak1 = $request->get('hakBiotek');
            $telepon1 = "+6231-298 1399";
            $hp1 = "+62 819 35096868";
            $email1 = "arta@staff.ubaya.ac.id";
            if ($request->get('pihakPembayar') == 1 ){
                $pihakPembayar = "PIHAK PERTAMA";
                $pihakPenerima = "PIHAK KEDUA";
            } else {
                $pihakPembayar = "PIHAK KEDUA";
                $pihakPenerima = "PIHAK PERTAMA";
            }

            $namaPihak2 = $request->get('pihak2');
            $alamatPihak2 = $request->get('alamatRkn');
            $perwakilanPihak2 = $request->get('wakilRkn');
            $jabatanWP2 = $request->get('jabatanRkn');
            $lingkup2 = $request->get('lingkupRkn');
            $kewajiban2 = $request->get('kewajibanRkn');
            $hak2 = $request->get('hakRkn');
            $telepon2 = $request->get('noTelpRkn');
            $hp2 = $request->get("noHPRkn");
            $email2 = $request->get("emailRkn");

        $fixIsi.= "$namaPihak2<br/>$perwakilanPihak2<br/>$jabatanWP2<br/>$telepon2<br/>$hp2<br/>$alamatPihak2<br/>$email2<br/>$lingkup2<br/>$kewajiban2<br/>$hak2<br/>";
        $fixIsi.= "$lingkup1<br/>$kewajiban1<br/>$hak1<br/>";
        } else {
            $namaPihak2 = "Fakultas Teknobiologi Surabaya";
            $alamatPihak2 = "Jalan Raya Kalirungkut, Surabaya 60293";
            $perwakilanPihak2 = "$namaDekan";
            $jabatanWP2 = "Dekan";
            $lingkup2 = $request->get('lingkupBiotek');
            $kewajiban2 = $request->get('kewajibanBiotek');
            $hak2 = $request->get('hakBiotek');
            $telepon2 = "+6231-298 1399";
            $hp2 = "+62 819 35096868";
            $email2 = "arta@staff.ubaya.ac.id";
            if ($request->get('pihakPembayar') == 1 ){
                $pihakPembayar = "PIHAK KEDUA";
                $pihakPenerima = "PIHAK PERTAMA";
            } else {
                $pihakPembayar = "PIHAK PERTAMA";
                $pihakPenerima = "PIHAK KEDUA";
            }

            $namaPihak1 = $request->get('pihak2');
            $alamatPihak1 = $request->get('alamatRkn');
            $perwakilanPihak1 = $request->get('wakilRkn');
            $jabatanWP1 = $request->get('jabatanRkn');
            $lingkup1 = $request->get('lingkupRkn');
            $kewajiban1 = $request->get('kewajibanRkn');
            $hak1 = $request->get('hakRkn');
            $telepon1 = $request->get('noTelpRkn');
            $hp1 = $request->get("noHPRkn");
            $email1 = $request->get("emailRkn");

            $fixIsi.= "$namaPihak1<br/>$perwakilanPihak1<br/>$jabatanWP1<br/>$telepon1<br/>$hp1<br/>$alamatPihak1<br/>$email1<br/>$lingkup1<br/>$kewajiban1<br/>$hak1<br/>";
            $fixIsi.= "$lingkup2<br/>$kewajiban2<br/>$hak2<br/>";
        }

        $pihak1K = strtoupper($namaPihak1);
        $pihak2K = strtoupper($namaPihak2);

        $caraPembayaran = nl2br($request->get("caraPembayaran"));
        $pelaksanaan = nl2br($request->get("pelaksanaanKj"));
        $jumlahBayar = $request->get("jumlahBayar");
        $tanggalsl = strtotime($request->get("tanggalSelesai"));
        $tanggalSelesai = strftime('%d %B %Y', $tanggalsl);
        // $countMengingat = $request->get('countMengingat');
        // $countMenetapkan = $request->get('countMenetapkan');

        // $isi = $request->get('isiSurat');
        $fixIsi.= "$pelaksanaan<br/>$pihakPembayar<br/>$jumlahBayar<br/>$caraPembayaran<br/>$tanggalsl";

        $folderPath = public_path("assets/pdf/$data->nomor_surat");
        $ubayaPath = public_path("assets/LogoUbayaSml.png");
        $ftbPath = public_path("assets/LogoFTB.png");
        $ttDEKPath = public_path("assets/TTDekan.png");
        $ttKPDMPath = public_path("assets/TTKaprodiM.png");
        $parafPKS = public_path("assets/parafPKS.png");
        $response = mkdir($folderPath);

        $fixIsipdf = "<html> <head> <style> @page { margin: margin: 0cm 0cm; } body { margin-top: 2cm; margin-left: 2cm; margin-right: 2cm; margin-bottom: 3cm; } footer { position: fixed;  bottom: 0cm;  left: 0cm;  right: 0cm; height: 3cm; margin-left: 3cm; }</style> </head>"; 
        $fixIsipdf.= "<footer><img src='$parafPKS'></footer>";
        $fixIsipdf.= "<body><center><b><div style='font-size: 30px;'>PERJANJIAN KERJASAMA<br/><i>(Letter of Agreement)</i><br/>antara<br/>";
        $fixIsipdf.= "$pihak1K<br/>dengan<br/>$pihak2K<br/>Tentang<br/>\"$data->perihal\"</div>";
        $fixIsipdf.= "<hr><div style='width: 250px; margin: auto; text-align: left;'>NOMOR :<hr>NOMOR : $ns</div></b></center>";
        $fixIsipdf.= "<br/><div>Pada hari ini <b>$hari</b>, tanggal <b>$tanggal</b>, bulan <b>$bulan</b>, tahun <b>$tahun</b>, telah dibuat dan ditandatangani Perjanjian Kerjasama, oleh dan antara :<br/><br/>";
        $fixIsipdf.= "<ol type='I'><li><b>$namaPihak1</b>, yang berdomisili di $alamatPihak1 yang dalam melakukan pembuatan hukum ini diwakili oleh <b>$perwakilanPihak1</b> sebagai <b>$jabatanWP1</b> Selanjutnya disebut sebagai <b>PIHAK PERTAMA</b></li><br/><br/>";
        $fixIsipdf.= "<li><b>$namaPihak2</b>, yang berdomisili di $alamatPihak2 yang dalam hal melakukan perbuatan hukum ini diwakili oleh <b>$perwakilanPihak2</b> sebagai <b>$jabatanWP2</b> Selanjutnya disebut sebagai <b>PIHAK KEDUA</b></li></ol>";
        $fixIsipdf.= "<br/>";
        $fixIsipdf.= "(PIHAK PERTAMA DAN PIHAK KEDUA secara bersama – sama disebut PARA PIHAK)";
        $fixIsipdf.= "<br/><br/>";
        $fixIsipdf.= "Berdasarkan atas pertimbangan:";
        $fixIsipdf.= "<ol type='1'><li>Kerangka acuan dari Fakultas Teknobiologi Universitas Surabaya penggunaan fasilitas laboratorium untuk penelitian/aplikasi bioteknologi, khususnya di bidang bioteknologi tanaman</li></ol>";
        $fixIsipdf.= "PARA PIHAK sepakat untuk melakukan kerjasama dalam \"$data->perihal\"";
        $fixIsipdf.= "<br/><br/>";
        $fixIsipdf.= "<center><b>Pasal 1<br/>RUANG LINGKUP PERJANJIAN</b></center>";
        $fixIsipdf.= "<ol type='1'><li>PIHAK PERTAMA $lingkup1</li><li>PIHAK KEDUA $lingkup2</li></ol>";
        $fixIsipdf.= "<br/>";
        $fixIsipdf.= "<center><b>Pasal 2<br/>HAK dan KEWAJIBAN PARA PIHAK</b></center><br/>";
        $fixIsipdf.= "<ol type=''1><li>Hak PIHAK PERTAMA: <br/>$hak1</li><br/><br/>";
        $fixIsipdf.= "<li>KEWAJIBAN PIHAK PERTAMA:<br/>$kewajiban1</li><br/><br/>";    
        $fixIsipdf.= "<li>Hak PIHAK KEDUA:<br/>$hak2</li><br/><br/>";
        $fixIsipdf.= "<li>KEWAJIBAN PIHAK KEDUA:<br/>$kewajiban2</li>";
        $fixIsipdf.= "</ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 3<br/>PELAKSANAAN KERJASAMA</b></center><br/>";
        $fixIsipdf.= "$pelaksanaan";
        $fixIsipdf.= "<br/><br/><center><b>Pasal 4<br/>BIAYA-BIAYA</b></center>";
        $fixIsipdf.= "<ol type='1'><li> $pihakPenerima akan menerima pembayaran dari $pihakPembayar</li><li> Biaya yang dimaksud adalah sebesar Rp 20.000.000,- yang sudah mencakup bahan, jasa serta institutional fee yang ditentukan oleh $pihakPenerima.</li></ol>";
        $fixIsipdf.= "<center><b>Pasal 5<br/>CARA PEMBAYARAN</b></center>";
        $fixIsipdf.= "<ol type='1'><li> Pembayaran atas biaya-biaya seperti yang tercantum pada Pasal 5 ayat ( 1 ) sebesar Rp $jumlahBayar dilaksanakan oleh PIHAK PERTAMA dengan ketentuan sebagai berikut:";
        $fixIsipdf.= "<ol type='1'><li>Pembayaran I sebesar 50% (lima puluh persen) selambatnya 7 (tujuh) hari kerja setelah penandatanganan kontrak</li><li>Pembayaran II sebesar 50% (lima puluh persen) selambatnya 7 (tujuh) hari kerja setelah penyerahan laporan </li></ol></li>";
        $fixIsipdf.= "<li>Pembayaran dilakukan melalui $caraPembayaran</li></ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 6<br/>JANGKA WAKTU PERJANJIAN</b></center><br/>";
        $fixIsipdf.= "<ol><li>Perjanjian Kerja Sama ini terhitung semenjak tanggal $d dan berakhir pada tanggal $tanggalSelesai</li><li>Perjanjian Kerjasama ini dapat diakhiri lebih awal atau diperpanjang atas kesepakatan kedua belah pihak</li></ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 7<br/><i>FORCE MAJEUR</i></b></center><br/>";
        $fixIsipdf.= "<ol><li> Perjanjian ini akan ditinjau kembali apabila terjadi hal-hal yang sifatnya diluar kekuasaan manusia yang biasa disebut force majeur yang akibatnya baik secara langsung maupun tidak langsung dapat mempengaruhi berlangsungnya perjanjian ini</li><li> Kejadian-kejadian yang termasuk Force Majeur antara lain:<br/><ol type='a'><li>Bencana alam seperti gunung meletus, banjir besar/ air bah, kebakaran, gempa bumi</li><li>Kondisi sosial seperti pemberontakan, pemogokan massal, epidemi</li><li>Kebijakan Pemerintah seperti sanering, devaluasi, kebijakan pemerintah yang terkait dengan perjanjian kerja ini</li></ol></li><li>Pihak yang terkena langsung akibat force majeur ini, agar memberitahukan hal tersebut kepada pihak lain secara tertulis dalam perjanjian ini dalam waktu 3x24 jam terhitung sejak terjadinya force majeur tersebut.</li></ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 8<br/>SANKSI</b></center> <br/>";
        $fixIsipdf.= "<ol><li>Bilamana dalam pelaksanaan perjanjian ini ternyata ada salah satu pihak yang dianggap telah melanggar ketentuan yang diatur tersebut diatas, maka pihak yang merasa dirugikan dapat mengajukan surat keberatan atau teguran kepada pihak lainnya</li><li>Bilamana setelah adanya surat teguran dari pihak yang merasa dirugikan tersebut ternyata tidak mendapatkan tanggapan yang semestinya dari pihak yang ditegur, maka surat teguran berikutnya dapat diberikan sampai maksimum 3 (tiga) kali dengan tenggang waktu masing-masing selama 7 (tujuh) hari kerja efektif sebelum akhirnya dilakukan pemutusan perjanjian kerjasama ini</li></ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 9<br/>PENYELESAIAN PERSELISIHAN</b></center><br/><br/>";
        $fixIsipdf.= "<ol><li>Bilamana terjadi perbedaan pendapat selama berlangsungnya perjanjian ini, maka kedua belah pihak sepakat untuk menyelesaikan permasalahan yang ada secara musyawarah/ kekeluargaan</li><li>Bilamana dengan musyawarah/ kekeluargaan tersebut kedua belah pihak tidak mencapai kesepakatan, maka kedua belah pihak sepakat untuk menyelesaikannya melalui jalur hukum yaitu di Kantor Panitera Pengadilan Negeri Surabaya</li></ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 10<br/><i>CONTACT PERSON</i></b></center><br/>";
        $fixIsipdf.= "<ol><li>Untuk kelancaran pelaksanaan PKS ini atau dalam hal terdapat saran/usulan/komplain/ keluhan yang dialami salah satu pihak sehubungan dengan pelaksanaan PKS ini, dapat disampaikan oleh salah satu pihak kepada pihak lainnya melalui Contact Person yang ditunjuk oleh PARA PIHAK untuk menangani / menindaklanjuti permasalahan/komplain/ keluhan tersebut.
        <br/><br/>
            <table>
                <tr><td width=200px><b><u>PIHAK PERTAMA</u></b></td><td width=10px></td><td></td></tr>
                <tr><td colspan='3'><b>$pihak1K</b></td></tr>
                <tr><td width=200px>Contact Person</td><td width=10px>:</td><td>$perwakilanPihak1</td></tr>
                <tr><td width=200px>Alamat</td><td width=10px>:</td><td>$alamatPihak1</td></tr>
                <tr><td width=200px>Telepon</td><td width=10px>:</td><td>$telepon1</td></tr>
                <tr><td width=200px>HP</td><td width=10px>:</td><td>$hp1</td></tr>
                <tr><td width=200px>Email</td><td width=10px>:</td><td>$email1</td></tr>
            </table>
            <br/>
            <table>
                <tr><td width=200px><b><u>PIHAK KEDUA</u></b></td><td width=10px></td><td></td></tr>
                <tr><td colspan='3'><b>$pihak2K</b></td></tr>
                <tr><td width=200px>Contact Person</td><td width=10px>:</td><td>$perwakilanPihak2</td></tr>
                <tr><td width=200px>Alamat</td><td width=10px>:</td><td>$alamatPihak2</td></tr>
                <tr><td width=200px>Telepon</td><td width=10px>:</td><td>$telepon2</td></tr>
                <tr><td width=200px>HP</td><td width=10px>:</td><td>$hp2</td></tr>
                <tr><td width=200px>Email</td><td width=10px>:</td><td>$email2</td></tr>
            </table>  
        </li>
        <br/><br/>
        <li>Penggantian Contact Person yang ditunjuk oleh PARA PIHAK sebagaimana dimaksud ayat (1) Pasal ini hanya dilaksanakan dengan pemberitahuan secara tertulis dari pihak yang menghendaki pergantian kepada pihak lainnya.</li>
         </ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 11<br/>PENUTUP</b></center><br/>";
        $fixIsipdf.= "<ol><li>Hal-hal yang belum cukup diatur dalam perjanjian ini, akan diatur kemudian dalam perjanjian tambahan yang merupakan satu kesatuan dengan perjanjian ini</li><li>Segala ketentuan dan syarat-syarat dalam PKS ini berlaku dan mengikat bagi pihak-pihak yang menandatangani dan pengganti-penggantinya.</li><li>Perjanjian Kerjasama  ini dibuat dalam rangkap 2 (dua) ASLI, masing-masing sama bunyinya dan ditandatangani di atas kertas bermaterai cukup sehingga mempunyai kekuatan hukum yang sama Bagi Para Pihak.</li></ol>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian Perjanjian Kerjasama ini dibuat dengan itikad baik, untuk dipatuhi dan dilaksanakan dengan penuh tanggungjawab oleh PARA PIHAK  ";
        $fixIsipdf.= "<br/><br/><br/>";
        $fixIsipdf.= "<div width='50%' style='text-align: center; float: left;'>
        <b>PIHAK PERTAMA<br/>$namaPihak1
        <br/><br/><br/><br/>
        <u>$perwakilanPihak1</u><br/>
        $jabatanWP1
        </b>       
        </div>";
        $fixIsipdf.= "<div width='50%' style='text-align: center; float: right;'>
        <b>PIHAK KEDUA<br/>$namaPihak2
        <br/><br/><br/><br/>
        <u>$perwakilanPihak2</u><br/>
        $jabatanWP2
        </b>
        </div>";
        $fixIsipdf.= "</body>";
        $fixIsipdf.= "</html>";

        Storage::disk('public_pdfs')->put("$data->nomor_surat/file.txt", $fixIsi);
        $pdf = PDF::loadHTML($fixIsipdf);
        $fileName = "$data->nomor_surat" . "srtutm";
        $pdf->save($folderPath . '/' . $fileName . '.pdf');
        
        //return $pdf->stream();

        return redirect()->route('surats.index')->with('status', 'Surat berhasil dibuat!!');
    }

    public function storeKep(Request $request)
    {
        $data = new Surat;
        setlocale(LC_ALL, 'IND');
        $data->nomor_surat = str_replace("/","-",$request->get('noSurat'));
        $ns = $request->get('noSurat');
        $data->perihal = $request->get('perihal');
        $data->tanggal_kirim = $request->get('Tanggal');
        $date = date('d-m-Y', strtotime($data->tanggal_kirim));
        $d = strftime('%d %B %Y');
        $data->jenis_surat = 5;

        $data->save();

        $path = "C:/xampp/htdocs/KPFTB/public/assets/opsi.txt";
        $opsi = file_get_contents("$path");

        $listnama = explode('|',$opsi);
        $namaDekan = $listnama[0];
        $namaWakilDekan = $listnama[1];
        $namaMagisterKaprodi = $listnama[2];

        $menimbang = $request->get('menimbang');
        $countMengingat = $request->get('countMengingat');
        $countMenetapkan = $request->get('countMenetapkan');

        $isi = $request->get('isiSurat');

        $folderPath = public_path("assets/pdf/$data->nomor_surat");
        $ubayaPath = public_path("assets/LogoUbayaSml.png");
        $ftbPath = public_path("assets/LogoFTB.png");
        $ttDEKPath = public_path("assets/TTDekan.png");
        $ttKPDMPath = public_path("assets/TTKaprodiM.png");
        $response = mkdir($folderPath);

        $fixIsi = "$ns<br/>$data->perihal<br/>$menimbang<br/>";

        $fixIsipdf = "<center><b><div>KEPUTUSAN<br/>DEKAN FAKULTAS TEKNOBIOLOGI UNIVERSITAS SURABAYA<br/>NOMOR: $ns<br/>Tentang<br/>$data->perihal</div><hr><br/><div>DEKAN FAKULTAS TEKNOBIOLOGI UNIVERSITAS SURABAYA</div></b></center><br/>";
        $fixIsipdf.= "<table style='border-collapse: collapse; width: 100%;'>";
        $fixIsipdf.= "<tr><td style='width:30%; vertical-align: text-top;'>MENIMBANG</td><td style='width:5%; vertical-align: text-top;'>: </td><td style='text-align:left; text-align: justify; text-justify: inter-word;'>$menimbang</td></tr>";
        $fixIsipdf.= "<tr><td style='height:10px;'></td><td></td><td></td></tr>";
        $fixIsipdf.= "<tr><td style='width:30%; vertical-align: text-top;'>MENGINGAT</td><td style='width:5%; vertical-align: text-top;'>: </td><td style='text-align:left; text-align: justify; text-justify: inter-word;'>";
        for ($i = 1; $i <= $countMengingat; $i++) {
            $fill = $request->get("mengingat$i");
            $fixIsipdf.="$i. $fill<br/>";
            $fixIsi.="$fill</br>";
        } 
        $fixIsi.="<br/>";
        $fixIsipdf.="<br/></td></tr>";
        $fixIsipdf.= "<tr><td style='width:30%;'></td><td></td><td style='text-align:center; width:70%;'><b>MENETAPKAN</b></td></tr>";
        $fixIsipdf.= "<tr><td style='height:10px;'></td><td></td><td></td></tr>";
        for ($i = 1; $i <= $countMenetapkan; $i++) {
            switch ($i) {
                case 1:
                  $angka = "Pertama";
                  break;
                case 2:
                    $angka = "Kedua";
                    break;
                case 3:
                    $angka = "Ketiga";
                    break;
                case 4:
                    $angka = "Keempat";
                    break;
                case 5:
                    $angka = "Kelima";
                    break;
                case 6:
                    $angka = "Keenam";
                    break;
                case 7:
                    $angka = "Ketujuh";
                    break;
                case 8:
                    $angka = "Kedelapan";
                    break;
                case 9:
                    $angka = "Kesembilan";
                    break;
                default:
                    "";
                }
            $fill = $request->get("menetapkan$i");
            $fixIsipdf.="<tr><td style='width:30%;'>$angka</td><td style='width:5%;'>:</td><td style='text-align:left; width:70%; text-align: justify; text-justify: inter-word;'>$fill</td></tr>";
            $fixIsi.="$fill</br>";
        } 
        $fixIsi.= "<br/>$countMengingat<br/>$countMenetapkan";
        $fixIsipdf.= "Pertama<br/><br/>";
        $fixIsipdf.= "<div>Ditetapkan di  : Surabaya<br/>Pada Tanggal  : $d<br/>Dekan,
        <br/><img src='$ttDEKPath' width='213' height='135'><br/>
        <b>$namaDekan</b>
        </div>
        <br/><br/>";
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
        $s = DB::table('surats')
            ->select(DB::raw('nomor_surat, perihal, jenis_surat+0 as jenis_surat, created_at, updated_at, tanggal_kirim'))
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

    public function editKep($id) {
        $s = DB::table('surats')
        ->select(DB::raw('*'))
        ->where('nomor_surat', $id)
        ->get();

        $p = Storage::disk('public_pdfs')->getAdapter()->getPathPrefix();
            
        $path = "C:/xampp/htdocs/KPFTB/public/assets/pdf/".$id."/file.txt";
        $txtFile = file_get_contents("$path");

        $fullText = explode('<br/>', $txtFile);
        $perihal = $fullText[1];
        $menimbang = $fullText[2];
        $mengingat = explode("</br>", $fullText[3]);
        $menetapkan = explode("</br>", $fullText[4]);
        $cIngat = $fullText[5];
        $cTetap = $fullText[6];

        return view('surats.editKep', compact('s','perihal','menimbang','mengingat','menetapkan','cIngat','cTetap'));
    }

    public function editKerj($id) {
        $s = DB::table('surats')
        ->select(DB::raw('*'))
        ->where('nomor_surat', $id)
        ->get();

        $p = Storage::disk('public_pdfs')->getAdapter()->getPathPrefix();
            
        $path = "C:/xampp/htdocs/KPFTB/public/assets/pdf/".$id."/file.txt";
        $txtFile = file_get_contents("$path");


        $fullText = explode('<br/>', $txtFile);
        $perihal = $fullText[1];
        $pihakUbaya = $fullText[2];
        $namaRekan = $fullText[3];
        $perwakilanRkn = $fullText[4];
        $jabatanWPR = $fullText[5];
        $teleponRkn = $fullText[6];
        $hpRkn = $fullText[7];
        $alamatRkn = $fullText[8];
        $emailRkn = $fullText[9];
        $lingkupRkn = $fullText[10];
        $kewajibanRkn = $fullText[11];
        $hakRkn = $fullText[12];
        $lingkupUby = $fullText[13];
        $kewajibanUby = $fullText[14];
        $hakUby = $fullText[15];
        $pelaksanaan = $fullText[16];
        $pihakPembayar = $fullText[17];
        $jumlahBayar = $fullText[18];
        $caraPembayaran = $fullText[19];
        $tanggalsl = $fullText[20];

        return view('surats.editKerj', compact('s','perihal','pihakUbaya','namaRekan','perwakilanRkn','jabatanWPR','teleponRkn','hpRkn','alamatRkn'
        ,'emailRkn','lingkupRkn','kewajibanRkn','hakRkn','lingkupUby','kewajibanUby','hakUby','pelaksanaan','pihakPembayar'
        ,'jumlahBayar','caraPembayaran','tanggalsl'));
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
        $idc = str_replace("-","/",$id);
        setlocale(LC_ALL, 'IND');
        $perihal = $request->get("perihal");
        $jenis = $request->get("jenis");
        $tanggal = $request->get('Tanggal');
        $tglbuat = $request->get('tglbuat');
        $jen = $request->get('jenis');
        $date = strftime('%d %B %Y', strtotime($tglbuat));

        DB::table('surats')
            ->where('nomor_surat', $id)
            ->update(['perihal' => $perihal,'jenis_surat' => $jenis,'tanggal_kirim' => $tanggal]);

        $penutup = $request->get('penutup');
        $checkbox = $request->input('tcheck');
        $kepada = $request->get('kepada');
        $count = $request->get('count');
        $lampiran = $request->get('lampiran');

        $row = $request->get('jumrow');
        $col = $request->get('jumcol');

        $isi = $request->get('isiSurat');
        $footerPath = public_path("assets/FooterFix.png");
        $ubayaPath = public_path("assets/LogoUbayaSml.png");
        $ftbPath = public_path("assets/LogoFTB.png");

        $folderPath = public_path("assets/pdf/$id");
        $ttDEKPath = public_path("assets/TTDekan.png");
        $ttKPDMPath = public_path("assets/TTKaprodiM.png");
        $ttWaDekPath = public_path("assets/TTWaDekan.png");

        $path = "C:/xampp/htdocs/KPFTB/public/assets/opsi.txt";
        $opsi = file_get_contents("$path");

        $listnama = explode('|',$opsi);
        $namaDekan = $listnama[0];
        $namaWakilDekan = $listnama[1];
        $namaMagisterKaprodi = $listnama[2];

        $fixIsi = "$lampiran<br/>$idc<br/>$perihal<br/>$date<br/>$kepada<br/>$isi<br/>$penutup<br/>";
        $fixIsipdf ="<html><head><style> @page { margin: margin: 0cm 0cm; } body { margin-top: 3cm; margin-left: 2cm; margin-right: 2cm; margin-bottom: 2cm; }";
        $fixIsipdf.="header { position: fixed; top: 0cm; left: 0cm; right: 0cm; height: 1cm; } footer { position: fixed;  bottom: 0cm;  left: 0cm;  right: 0cm; height: 2cm; }";
        $fixIsipdf.="</style></head>";
        $fixIsipdf.= "<header><img src='$ubayaPath' width='255' height='75' style='margin-left: 1cm; margin-top: 1cm;'><img src='$ftbPath' width='255' height='75' style='float: right; margin-right: 1cm; margin-top: 1cm;'></header><br/><br/><br/>";
        $fixIsipdf.="<footer><img src='$footerPath' width='100%'></footer>";
        $fixIsipdf.= "<body><div style=' width: 100%; text-align: right; float: right;'>$date</div>Nomor : $idc <br/>Lampiran : $lampiran<br/> Perihal : <b>$perihal</b><br/></p>
        <br/><br/><br/><div>Kepada Yth,<br/>$kepada <br/>Universitas Surabaya</div>
            <br/><br/>
            <div style='text-align: justify; text-justify: inter-word;'>
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
        if($jen == 3) {    
                $fixIsipdf .="<br/><div style='text-align: justify; text-justify: inter-word;'>$penutup
            </div>
            <br/><br/><br/>
            <div style='text-align: left;'>
                <p>
                Hormat Kami, <br/>
                Kaprodi. Magister Teknobiologi
                </p>
                <img src='$ttKPDMPath' width='213' height='135'><br/>
                $namaWakilDekan         
            </div>
            <br/><br/></body>";
            } else if ($jen == 1) {
                $fixIsipdf .="<br/><div style='text-align: justify; text-justify: inter-word;'>$penutup
            </div>
            <br/><br/><br/>
            <div style='text-align: left; page-break-inside: avoid;'>
                <p>
                Hormat Kami, <br/>
                Dekan Fakultas Teknobiologi
                </p>
                <img src='$ttDEKPath' width='213' height='135'><br/>
                $namaDekan         
            </div>
            <br/><br/></body>";
            } else if ($jen == 2) {
                $fixIsipdf .="<br/><div style='text-align: justify; text-justify: inter-word;'>$penutup
                </div>
                <br/><br/><br/>
                <div style='text-align: left; page-break-inside: avoid;'>
                    <p>
                    Hormat Kami, <br/>
                    Wakil Dekan Fakultas Teknobiologi
                    </p>
                    <img src='$ttWaDekPath' width='213' height='135'><br/>
                    $namaWakilDekan         
                </div>
                <br/><br/></body>";
            }
            
        $fixIsipdf.="</html>";
        Storage::disk('public_pdfs')->put("$id/file.txt", $fixIsi);
        $pdf = PDF::loadHTML($fixIsipdf);
        $fileName = "$id" . "srtutm";
        $pdf->save($folderPath . '/' . $fileName . '.pdf');
        return redirect()->route('surats.index')->with('status','Surat berhasil di edit');
    }

    public function updateKep(Request $request, $id)
    {
        //$idc = str_replace("-","/",$id);
        setlocale(LC_ALL, 'IND');
        $perihal = $request->get("perihal");
        $tanggal = $request->get('Tanggal');
        $tglbuat = $request->get('tglbuat');
        $date = strftime('%d %B %Y', strtotime($tglbuat));

        $menimbang = $request->get('menimbang');
        $countMengingat = $request->get('countMengingat');
        $countMenetapkan = $request->get('countMenetapkan');

        DB::table('surats')
            ->where('nomor_surat', $id)
            ->update(['perihal' => $perihal,'tanggal_kirim' => $tanggal]);

        $folderPath = public_path("assets/pdf/$id");
        $ttDEKPath = public_path("assets/TTDekan.png");

        $path = "C:/xampp/htdocs/KPFTB/public/assets/opsi.txt";
        $opsi = file_get_contents("$path");

        $listnama = explode('|',$opsi);
        $namaDekan = $listnama[0];
        $namaWakilDekan = $listnama[1];
        $namaMagisterKaprodi = $listnama[2];

        $fixIsi = "$id<br/>$perihal<br/>$menimbang<br/>";

        $fixIsipdf = "<center><b><div>KEPUTUSAN<br/>DEKAN FAKULTAS TEKNOBIOLOGI UNIVERSITAS SURABAYA<br/>NOMOR: $id<br/>Tentang<br/>$perihal</div><hr><br/><div>DEKAN FAKULTAS TEKNOBIOLOGI UNIVERSITAS SURABAYA</div></b></center><br/>";
        $fixIsipdf.= "<table style='border-collapse: collapse; width: 100%;'>";
        $fixIsipdf.= "<tr><td style='width:30%; vertical-align: text-top;'>MENIMBANG</td><td style='width:5%; vertical-align: text-top;'>: </td><td style='text-align:left; text-align: justify; text-justify: inter-word;'>$menimbang</td></tr>";
        $fixIsipdf.= "<tr><td style='height:10px;'></td><td></td><td></td></tr>";
        $fixIsipdf.= "<tr><td style='width:30%; vertical-align: text-top;'>MENGINGAT</td><td style='width:5%; vertical-align: text-top;'>: </td><td style='text-align:left; text-align: justify; text-justify: inter-word;'>";
        for ($i = 1; $i <= $countMengingat; $i++) {
            $fill = $request->get("mengingat$i");
            $fixIsipdf.="$i. $fill<br/>";
            $fixIsi.="$fill</br>";
        } 
        $fixIsi.="<br/>";
        $fixIsipdf.="</td></tr>";
        $fixIsipdf.= "<tr><td style='width:30%;'></td><td></td><td style='text-align:center; width:70%;'><b>MENETAPKAN</b></td></tr>";
        $fixIsipdf.= "<tr><td style='height:10px;'></td><td></td><td></td></tr>";
        for ($i = 1; $i <= $countMenetapkan; $i++) {
            switch ($i) {
                case 1:
                  $angka = "Pertama";
                  break;
                case 2:
                    $angka = "Kedua";
                    break;
                case 3:
                    $angka = "Ketiga";
                    break;
                case 4:
                    $angka = "Keempat";
                    break;
                case 5:
                    $angka = "Kelima";
                    break;
                case 6:
                    $angka = "Keenam";
                    break;
                case 7:
                    $angka = "Ketujuh";
                    break;
                case 8:
                    $angka = "Kedelapan";
                    break;
                case 9:
                    $angka = "Kesembilan";
                    break;
                default:
                    "";
                }
            $fill = $request->get("menetapkan$i");
            $fixIsipdf.="<tr><td style='width:30%;'>$angka</td><td style='width:5%;'>:</td><td style='text-align:left; width:70%; text-align: justify; text-justify: inter-word;'>$fill</td></tr>";
            $fixIsi.="$fill</br>";
        } 
        $fixIsi.= "<br/>$countMengingat<br/>$countMenetapkan";
        $fixIsipdf.= "Pertama<br/><br/>";
        $fixIsipdf.= "<div>Ditetapkan di  : Surabaya<br/>Pada Tanggal  : $date<br/>Dekan,
        <br/><img src='$ttDEKPath' width='213' height='135'><br/>
        <b>$namaDekan </b>
        </div>
        <br/><br/>";
            
        Storage::disk('public_pdfs')->put("$id/file.txt", $fixIsi);
        $pdf = PDF::loadHTML($fixIsipdf);
        $fileName = "$id" . "srtutm";
        $pdf->save($folderPath . '/' . $fileName . '.pdf');

        return redirect()->route('surats.index')->with('status','Surat berhasil di edit');
    }

    public function updateKerj(Request $request, $id) {
        $data = new Surat;
        setlocale(LC_ALL, 'IND');
        $data->nomor_surat = str_replace("/","-",$request->get('noSurat'));
        $ns = $request->get('noSurat');
        $data->perihal = $request->get('perihal');
        $data->tanggal_kirim = $request->get('Tanggal');
        $date = date('d-m-Y', strtotime($data->tanggal_kirim));
        $d = strftime('%d %B %Y');
        
        $data->jenis_surat = 4;

        DB::table('surats')
            ->where('nomor_surat', $id)
            ->update(['perihal' => $data->perihal,'tanggal_kirim' => $data->tanggal_kirim]);

        $path = "C:/xampp/htdocs/KPFTB/public/assets/opsi.txt";
        $opsi = file_get_contents("$path");

        $listnama = explode('|',$opsi);
        $namaDekan = $listnama[0];
        $namaWakilDekan = $listnama[1];
        $namaMagisterKaprodi = $listnama[2];

        $hari = strftime('%A');
        $tanggal = strftime('%d');
        $bulan = strftime('%B');
        $tahun = strftime('%Y');

        $pihakUbaya = $request->get('pihakKe');
        $fixIsi = "$ns<br/>$data->perihal<br/>$pihakUbaya<br/>";
        if ($pihakUbaya == 1) {
            $namaPihak1 = "Fakultas Teknobiologi Surabaya";
            $alamatPihak1 = "Jalan Raya Kalirungkut, Surabaya 60293";
            $perwakilanPihak1 = "$namaDekan";
            $jabatanWP1 = "Dekan";
            $lingkup1 = $request->get('lingkupBiotek');
            $kewajiban1 = $request->get('kewajibanBiotek');
            $hak1 = $request->get('hakBiotek');
            $telepon1 = "+6231-298 1399";
            $hp1 = "+62 819 35096868";
            $email1 = "arta@staff.ubaya.ac.id";
            if ($request->get('pihakPembayar') == 1 ){
                $pihakPembayar = "PIHAK PERTAMA";
                $pihakPenerima = "PIHAK KEDUA";
            } else {
                $pihakPembayar = "PIHAK KEDUA";
                $pihakPenerima = "PIHAK PERTAMA";
            }

            $namaPihak2 = $request->get('pihak2');
            $alamatPihak2 = $request->get('alamatRkn');
            $perwakilanPihak2 = $request->get('wakilRkn');
            $jabatanWP2 = $request->get('jabatanRkn');
            $lingkup2 = $request->get('lingkupRkn');
            $kewajiban2 = $request->get('kewajibanRkn');
            $hak2 = $request->get('hakRkn');
            $telepon2 = $request->get('noTelpRkn');
            $hp2 = $request->get("noHPRkn");
            $email2 = $request->get("emailRkn");

        $fixIsi.= "$namaPihak2<br/>$perwakilanPihak2<br/>$jabatanWP2<br/>$telepon2<br/>$hp2<br/>$alamatPihak2<br/>$email2<br/>$lingkup2<br/>$kewajiban2<br/>$hak2<br/>";
        $fixIsi.= "$lingkup1<br/>$kewajiban1<br/>$hak1<br/>";
        } else {
            $namaPihak2 = "Fakultas Teknobiologi Surabaya";
            $alamatPihak2 = "Jalan Raya Kalirungkut, Surabaya 60293";
            $perwakilanPihak2 = "$namaDekan";
            $jabatanWP2 = "Dekan";
            $lingkup2 = $request->get('lingkupBiotek');
            $kewajiban2 = $request->get('kewajibanBiotek');
            $hak2 = $request->get('hakBiotek');
            $telepon2 = "+6231-298 1399";
            $hp2 = "+62 819 35096868";
            $email2 = "arta@staff.ubaya.ac.id";
            if ($request->get('pihakPembayar') == 1 ){
                $pihakPembayar = "PIHAK KEDUA";
                $pihakPenerima = "PIHAK PERTAMA";
            } else {
                $pihakPembayar = "PIHAK PERTAMA";
                $pihakPenerima = "PIHAK KEDUA";
            }

            $namaPihak1 = $request->get('pihak2');
            $alamatPihak1 = $request->get('alamatRkn');
            $perwakilanPihak1 = $request->get('wakilRkn');
            $jabatanWP1 = $request->get('jabatanRkn');
            $lingkup1 = $request->get('lingkupRkn');
            $kewajiban1 = $request->get('kewajibanRkn');
            $hak1 = $request->get('hakRkn');
            $telepon1 = $request->get('noTelpRkn');
            $hp1 = $request->get("noHPRkn");
            $email1 = $request->get("emailRkn");

            $fixIsi.= "$namaPihak1<br/>$perwakilanPihak1<br/>$jabatanWP1<br/>$telepon1<br/>$hp1<br/>$alamatPihak1<br/>$email1<br/>$lingkup1<br/>$kewajiban1<br/>$hak1<br/>";
            $fixIsi.= "$lingkup2<br/>$kewajiban2<br/>$hak2<br/>";
        }

        $pihak1K = strtoupper($namaPihak1);
        $pihak2K = strtoupper($namaPihak2);

        $caraPembayaran = nl2br($request->get("caraPembayaran"));
        $pelaksanaan = nl2br($request->get("pelaksanaanKj"));
        $jumlahBayar = $request->get("jumlahBayar");
        $tanggalsl = strtotime($request->get("tanggalSelesai"));
        $tanggalSelesai = strftime('%d %B %Y', $tanggalsl);
        // $countMengingat = $request->get('countMengingat');
        // $countMenetapkan = $request->get('countMenetapkan');

        // $isi = $request->get('isiSurat');
        $fixIsi.= "$pelaksanaan<br/>$pihakPembayar<br/>$jumlahBayar<br/>$caraPembayaran<br/>$tanggalsl";

        $folderPath = public_path("assets/pdf/$data->nomor_surat");
        $ubayaPath = public_path("assets/LogoUbayaSml.png");
        $ftbPath = public_path("assets/LogoFTB.png");
        $ttDEKPath = public_path("assets/TTDekan.png");
        $ttKPDMPath = public_path("assets/TTKaprodiM.png");
        $parafPKS = public_path("assets/parafPKS.png");
        //<html><head><style> @page { margin: margin: 0cm 0cm; } body { margin-top: 2cm; margin-left: 2cm; margin-right: 2cm; margin-bottom: 2cm; }
        
        $fixIsipdf = "<html> <head> <style> @page { margin: margin: 0cm 0cm; } body { margin-top: 2cm; margin-left: 2cm; margin-right: 2cm; margin-bottom: 3cm; } footer { position: fixed;  bottom: 0cm;  left: 0cm;  right: 0cm; height: 3cm; margin-left: 3cm; }</style> </head>"; 
        $fixIsipdf.= "<footer><img src='$parafPKS'></footer>";
        $fixIsipdf.= "<body><center><b><div style='font-size: 30px;'>PERJANJIAN KERJASAMA<br/><i>(Letter of Agreement)</i><br/>antara<br/>";
        $fixIsipdf.= "$pihak1K<br/>dengan<br/>$pihak2K<br/>Tentang<br/>\"$data->perihal\"</div>";
        $fixIsipdf.= "<hr><div style='width: 250px; margin: auto; text-align: left;'>NOMOR :<hr>NOMOR : $ns</div></b></center>";
        $fixIsipdf.= "<br/><div style='text-align: justify; text-justify: inter-word;'>Pada hari ini <b>$hari</b>, tanggal <b>$tanggal</b>, bulan <b>$bulan</b>, tahun <b>$tahun</b>, telah dibuat dan ditandatangani Perjanjian Kerjasama, oleh dan antara :<br/><br/>";
        $fixIsipdf.= "<ol type='I'><li style='text-align: justify; text-justify: inter-word;'><b>$namaPihak1</b>, yang berdomisili di $alamatPihak1 yang dalam melakukan pembuatan hukum ini diwakili oleh <b>$perwakilanPihak1</b> sebagai <b>$jabatanWP1</b> Selanjutnya disebut sebagai <b>PIHAK PERTAMA</b></li><br/><br/>";
        $fixIsipdf.= "<li style='text-align: justify; text-justify: inter-word;'><b>$namaPihak2</b>, yang berdomisili di $alamatPihak2 yang dalam hal melakukan perbuatan hukum ini diwakili oleh <b>$perwakilanPihak2</b> sebagai <b>$jabatanWP2</b> Selanjutnya disebut sebagai <b>PIHAK KEDUA</b></li></ol>";
        $fixIsipdf.= "<br/>";
        $fixIsipdf.= "(PIHAK PERTAMA DAN PIHAK KEDUA secara bersama – sama disebut PARA PIHAK)";
        $fixIsipdf.= "<br/><br/>";
        $fixIsipdf.= "Berdasarkan atas pertimbangan:";
        $fixIsipdf.= "<ol type='1'><li>Kerangka acuan dari Fakultas Teknobiologi Universitas Surabaya penggunaan fasilitas laboratorium untuk penelitian/aplikasi bioteknologi, khususnya di bidang bioteknologi tanaman</li></ol>";
        $fixIsipdf.= "PARA PIHAK sepakat untuk melakukan kerjasama dalam \"$data->perihal\"";
        $fixIsipdf.= "<br/><br/>";
        $fixIsipdf.= "<center><b>Pasal 1<br/>RUANG LINGKUP PERJANJIAN</b></center>";
        $fixIsipdf.= "<ol type='1'><li style='text-align: justify; text-justify: inter-word;'>PIHAK PERTAMA $lingkup1</li><li style='text-align: justify; text-justify: inter-word;'>PIHAK KEDUA $lingkup2</li></ol>";
        $fixIsipdf.= "<br/>";
        $fixIsipdf.= "<center><b>Pasal 2<br/>HAK dan KEWAJIBAN PARA PIHAK</b></center><br/>";
        $fixIsipdf.= "<ol type='1'><li style='text-align: justify; text-justify: inter-word;'>Hak PIHAK PERTAMA: <br/>$hak1</li><br/><br/>";
        $fixIsipdf.= "<li style='text-align: justify; text-justify: inter-word;'>KEWAJIBAN PIHAK PERTAMA:<br/>$kewajiban1</li><br/><br/>";    
        $fixIsipdf.= "<li style='text-align: justify; text-justify: inter-word;'>Hak PIHAK KEDUA:<br/>$hak2</li><br/><br/>";
        $fixIsipdf.= "<li style='text-align: justify; text-justify: inter-word;'>KEWAJIBAN PIHAK KEDUA:<br/>$kewajiban2</li>";
        $fixIsipdf.= "</ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 3<br/>PELAKSANAAN KERJASAMA</b></center><br/>";
        $fixIsipdf.= "<div style='text-align: justify; text-justify: inter-word;'>$pelaksanaan</div>";
        $fixIsipdf.= "<br/><br/><center><b>Pasal 4<br/>BIAYA-BIAYA</b></center>";
        $fixIsipdf.= "<ol type='1'><li> $pihakPenerima akan menerima pembayaran dari $pihakPembayar</li><li> Biaya yang dimaksud adalah sebesar Rp 20.000.000,- yang sudah mencakup bahan, jasa serta institutional fee yang ditentukan oleh $pihakPenerima.</li></ol>";
        $fixIsipdf.= "<center><b>Pasal 5<br/>CARA PEMBAYARAN</b></center>";
        $fixIsipdf.= "<ol type='1'><li style='text-align: justify; text-justify: inter-word;'> Pembayaran atas biaya-biaya seperti yang tercantum pada Pasal 5 ayat ( 1 ) sebesar Rp $jumlahBayar dilaksanakan oleh PIHAK PERTAMA dengan ketentuan sebagai berikut:";
        $fixIsipdf.= "<ol type='1'><li style='text-align: justify; text-justify: inter-word;'>Pembayaran I sebesar 50% (lima puluh persen) selambatnya 7 (tujuh) hari kerja setelah penandatanganan kontrak</li><li>Pembayaran II sebesar 50% (lima puluh persen) selambatnya 7 (tujuh) hari kerja setelah penyerahan laporan </li></ol></li>";
        $fixIsipdf.= "<li style='text-align: justify; text-justify: inter-word;'>Pembayaran dilakukan melalui $caraPembayaran</li></ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 6<br/>JANGKA WAKTU PERJANJIAN</b></center><br/>";
        $fixIsipdf.= "<ol><li>Perjanjian Kerja Sama ini terhitung semenjak tanggal $d dan berakhir pada tanggal $tanggalSelesai</li><li>Perjanjian Kerjasama ini dapat diakhiri lebih awal atau diperpanjang atas kesepakatan kedua belah pihak</li></ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 7<br/><i>FORCE MAJEUR</i></b></center><br/>";
        $fixIsipdf.= "<ol><li style='text-align: justify; text-justify: inter-word;'> Perjanjian ini akan ditinjau kembali apabila terjadi hal-hal yang sifatnya diluar kekuasaan manusia yang biasa disebut force majeur yang akibatnya baik secara langsung maupun tidak langsung dapat mempengaruhi berlangsungnya perjanjian ini</li><li> Kejadian-kejadian yang termasuk Force Majeur antara lain:<br/><ol type='a'><li>Bencana alam seperti gunung meletus, banjir besar/ air bah, kebakaran, gempa bumi</li><li>Kondisi sosial seperti pemberontakan, pemogokan massal, epidemi</li><li>Kebijakan Pemerintah seperti sanering, devaluasi, kebijakan pemerintah yang terkait dengan perjanjian kerja ini</li></ol></li><li>Pihak yang terkena langsung akibat force majeur ini, agar memberitahukan hal tersebut kepada pihak lain secara tertulis dalam perjanjian ini dalam waktu 3x24 jam terhitung sejak terjadinya force majeur tersebut.</li></ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 8<br/>SANKSI</b></center> <br/>";
        $fixIsipdf.= "<ol><li style='text-align: justify; text-justify: inter-word;'>Bilamana dalam pelaksanaan perjanjian ini ternyata ada salah satu pihak yang dianggap telah melanggar ketentuan yang diatur tersebut diatas, maka pihak yang merasa dirugikan dapat mengajukan surat keberatan atau teguran kepada pihak lainnya</li><li>Bilamana setelah adanya surat teguran dari pihak yang merasa dirugikan tersebut ternyata tidak mendapatkan tanggapan yang semestinya dari pihak yang ditegur, maka surat teguran berikutnya dapat diberikan sampai maksimum 3 (tiga) kali dengan tenggang waktu masing-masing selama 7 (tujuh) hari kerja efektif sebelum akhirnya dilakukan pemutusan perjanjian kerjasama ini</li></ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 9<br/>PENYELESAIAN PERSELISIHAN</b></center><br/><br/>";
        $fixIsipdf.= "<ol><li style='text-align: justify; text-justify: inter-word;'>Bilamana terjadi perbedaan pendapat selama berlangsungnya perjanjian ini, maka kedua belah pihak sepakat untuk menyelesaikan permasalahan yang ada secara musyawarah/ kekeluargaan</li><li>Bilamana dengan musyawarah/ kekeluargaan tersebut kedua belah pihak tidak mencapai kesepakatan, maka kedua belah pihak sepakat untuk menyelesaikannya melalui jalur hukum yaitu di Kantor Panitera Pengadilan Negeri Surabaya</li></ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 10<br/><i>CONTACT PERSON</i></b></center><br/>";
        $fixIsipdf.= "<ol><li style='text-align: justify; text-justify: inter-word;'>Untuk kelancaran pelaksanaan PKS ini atau dalam hal terdapat saran/usulan/komplain/ keluhan yang dialami salah satu pihak sehubungan dengan pelaksanaan PKS ini, dapat disampaikan oleh salah satu pihak kepada pihak lainnya melalui Contact Person yang ditunjuk oleh PARA PIHAK untuk menangani / menindaklanjuti permasalahan/komplain/ keluhan tersebut.
        <br/><br/>
            <table>
                <tr><td width=200px><b><u>PIHAK PERTAMA</u></b></td><td width=10px></td><td></td></tr>
                <tr><td colspan='3'><b>$pihak1K</b></td></tr>
                <tr><td width=200px>Contact Person</td><td width=10px>:</td><td>$perwakilanPihak1</td></tr>
                <tr><td width=200px>Alamat</td><td width=10px>:</td><td>$alamatPihak1</td></tr>
                <tr><td width=200px>Telepon</td><td width=10px>:</td><td>$telepon1</td></tr>
                <tr><td width=200px>HP</td><td width=10px>:</td><td>$hp1</td></tr>
                <tr><td width=200px>Email</td><td width=10px>:</td><td>$email1</td></tr>
            </table>
            <br/>
            <table>
                <tr><td width=200px><b><u>PIHAK KEDUA</u></b></td><td width=10px></td><td></td></tr>
                <tr><td colspan='3'><b>$pihak2K</b></td></tr>
                <tr><td width=200px>Contact Person</td><td width=10px>:</td><td>$perwakilanPihak2</td></tr>
                <tr><td width=200px>Alamat</td><td width=10px>:</td><td>$alamatPihak2</td></tr>
                <tr><td width=200px>Telepon</td><td width=10px>:</td><td>$telepon2</td></tr>
                <tr><td width=200px>HP</td><td width=10px>:</td><td>$hp2</td></tr>
                <tr><td width=200px>Email</td><td width=10px>:</td><td>$email2</td></tr>
            </table>  
        </li>
        <br/><br/>
        <li style='text-align: justify; text-justify: inter-word;'>Penggantian Contact Person yang ditunjuk oleh PARA PIHAK sebagaimana dimaksud ayat (1) Pasal ini hanya dilaksanakan dengan pemberitahuan secara tertulis dari pihak yang menghendaki pergantian kepada pihak lainnya.</li>
         </ol>";
        $fixIsipdf.= "<br/><center><b>Pasal 11<br/>PENUTUP</b></center><br/>";
        $fixIsipdf.= "<ol><li style='text-align: justify; text-justify: inter-word;'>Hal-hal yang belum cukup diatur dalam perjanjian ini, akan diatur kemudian dalam perjanjian tambahan yang merupakan satu kesatuan dengan perjanjian ini</li><li>Segala ketentuan dan syarat-syarat dalam PKS ini berlaku dan mengikat bagi pihak-pihak yang menandatangani dan pengganti-penggantinya.</li><li>Perjanjian Kerjasama  ini dibuat dalam rangkap 2 (dua) ASLI, masing-masing sama bunyinya dan ditandatangani di atas kertas bermaterai cukup sehingga mempunyai kekuatan hukum yang sama Bagi Para Pihak.</li></ol>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian Perjanjian Kerjasama ini dibuat dengan itikad baik, untuk dipatuhi dan dilaksanakan dengan penuh tanggungjawab oleh PARA PIHAK  ";
        $fixIsipdf.= "<br/><br/><br/>";
        $fixIsipdf.= "<div width='50%' style='text-align: center; float: left;'>
        <b>PIHAK PERTAMA<br/>$namaPihak1
        <br/><br/><br/><br/>
        <u>$perwakilanPihak1</u><br/>
        $jabatanWP1
        </b>       
        </div>";
        $fixIsipdf.= "<div width='50%' style='text-align: center; float: right;'>
        <b>PIHAK KEDUA<br/>$namaPihak2
        <br/><br/><br/><br/>
        <u>$perwakilanPihak2</u><br/>
        $jabatanWP2
        </b>
        </div>";
        $fixIsipdf.= "</body>";
        $fixIsipdf.= "</html>";

        Storage::disk('public_pdfs')->put("$data->nomor_surat/file.txt", $fixIsi);
        $pdf = PDF::loadHTML($fixIsipdf);
        $fileName = "$data->nomor_surat" . "srtutm";
        $pdf->save($folderPath . '/' . $fileName . '.pdf');
        
        //return $pdf->stream();

        return redirect()->route('surats.index')->with('status', 'Surat berhasil dibuat!!');
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

    public function updateOpsi(Request $request) {
        $namaDekan = $request->get('Dekan');
        $namaWakilDekan = $request->get('WakilDekan');
        $namaMagisterKaprodi = $request->get('MagisterKaprodi');
        $folderPath = public_path("assets");

        if (null !== ($request->file('uploadfileDekan'))) {
            $fileDekan = $request->file('uploadfileDekan'); 
            $fileDekan->move($folderPath, "TTDekan.png");
        }
        if (null !== ($request->file('uploadfileWakil'))) {
            $fileWakil = $request->file('uploadfileWakil');
            $fileWakil->move($folderPath, "TTWaDekan.png");
        }
        if (null !== ($request->file('uploadfileKaprodi'))) {
            $fileKaprodi = $request->file('uploadfileKaprodi');
            $fileKaprodi->move($folderPath, "TTDekan.png");
        }

        $opsi = "$namaDekan|$namaWakilDekan|$namaMagisterKaprodi";

        Storage::disk('public_assets')->put("opsi.txt", $opsi);

        return redirect()-> route('surats.opsi');
        //return view('surats.opsi', compact('namaDekan','namaWakilDekan','namaMagisterKaprodi'));
    }

}
