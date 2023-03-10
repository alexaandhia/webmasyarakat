<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function edit($report_id)
    {
        // ambil data response yang bakal dimunculin, data yang diambil data response yg report_id sama kaya yang path dinamis web.php
        // kalo ada datanya, diambil satu, kalo pake firstorfail nanti munculnya not found
        $report = Response::where('report_id', $report_id)->first();
        //buat kirim datanya buat route update
        $reportId = $report_id;
        return view('response', compact('report', 'reportId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $report_id)
    {
        $request->validate(
            [
                'status' => 'required',
                'pesan' => 'required',
            ]);

            //updateorcreate buat melakukan update kalo di db responsenya udah ada data yang punya report_id sama dengan report_id dari path dinamis, kl gaada maka create
            //array pertama : acuan dari datanya
            // array kedua: data yang dikirim
            // kenapa pke updateorcreate? soalnya response ini kalo gaada jadi ditambah, kalo ada jadi diupdate
            Response::updateOrCreate(
            [
                'report_id' => $report_id,
            ],
            [
                'status' => $request->status,
                'pesan' => $request->pesan,
            ]
            );

            //klo udah langsung return redirect
            return redirect()->route('petugas')->with('responseSuccess', 'berhasil menguvah response!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function destroy(Response $response)
    {
        //
    }
}
