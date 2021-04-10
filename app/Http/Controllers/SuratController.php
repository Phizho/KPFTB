<?php

namespace App\Http\Controllers;

use App\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

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
             ->select(DB::raw('count(*) as jumlah_lampiran, surats.*, lampirans.nomor_surat as ns'))
             ->distinct()
             ->rightJoin('surats', 'lampirans.nomor_surat', '=', 'surats.nomor_surat')
             ->groupBy('surats.nomor_surat', 'surats.perihal', 'surats.jenis_surat', 'surats.created_at', 'surats.updated_at','lampirans.nomor_surat')
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
        $data->created_at = $request->get('Tanggal');
        $data->jenis_surat = $request->get('jenis');

        $data->save();
        $isi = $request->get('isiSurat');

        $folderPath = public_path("assets/pdf/$data->nomor_surat");
        $response = mkdir($folderPath);

        $pdf = PDF::loadHTML("<h1>$isi</h1>");
        $fileName = "$data->nomor_surat"."srtutm";
        $pdf->save($folderPath. '/' . $fileName.'.pdf');
        //return $pdf->stream();

        return redirect()->route('surats.index')->with('status','Surat berhasil dibuat!!');
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

    public function generatePDF($request)
    {

    }
}
