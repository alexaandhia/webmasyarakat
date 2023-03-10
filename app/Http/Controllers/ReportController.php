<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use PDF;
use Excel;
use App\Exports\ReportsExport;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ASC: terkecil ke terbesar (1-9 / A-Z)
        //DESC: terbesar ke terbesar (9-1 / Z-A)
        $reports = Report::orderBy('created_at', 'DESC')->simplePaginate(2);

            return view('index', compact('reports'));
    
    }

    public function exportPDF(){
        $data = Report::with('response')->get()->toArray();
        view()->share('reports', $data);
        $pdf = PDF::loadView('print', $data)->setPaper('a4', 'landscape');
        return $pdf->download('laporan_pengaduan.pdf'); 

    }

    public function createdPDF($id){
        $data = Report::with('response')->where('id', $id)->get()->toArray();
        view()->share('reports', $data);
        $pdf = PDF::loadView('print', $data);
        return $pdf->download('data_pengaduan.pdf');
    }

    public function exportExcel(){
        //nama file yang akan terdownload, selain itu juga bisa pake .csv
        $file_name = 'laporan_pengaduan.xlsx';
        //buat manggil file reports dan download kaya nama $file_name
        return Excel::download(new ReportsExport, $file_name);
    }

    public function login(){
        return view('login');
    }

    public function auth(Request $request){
        //buat validasinya
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

         //ambil data dan disimpan ke variabel
         $user = $request->only('email', 'password');

         //simpen data ke auth dengan Auth::attempt dan cek proses penyimpanan ke auth berhasil atau tidak leway if else
         if (Auth::attempt ($user)){
            if(Auth::user()->role == 'admin'){
                return redirect()->route('data');
            }elseif(Auth::user()->role == 'petugas'){
                return redirect()->route('petugas');
            }
         }else{
             return redirect()->back()->with('errorLogin', 'login gagal, silahkan coba lagi');  
         }
    }

    public function data(Request $request){
        $search = $request->search;
        $reports = Report::with('response')->where('nama', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'DESC')->get();

            return view('data', compact('reports'));
    }

    public function petugas(Request $request){
        $search = $request->search;
        //with : ambil relasi di modelnya trs ambil data dari relasi itu
        $reports = Report::with('response')->where('nama', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'DESC')->get();
        return view('petugas', compact('reports'));

    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/')->with('successLogout', 'Berhasil Logout Akun');
    }

    public function error(){
        return view('error');
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
        $request->validate([
            'nik' => 'required|numeric',
            'nama' => 'required',
            'telp' => 'required|max:13',
            'pengaduan' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png,svg,jfif',
        ]);

        //tambah foto ke public
        $image = $request->file('foto');
        $imgName = rand() . '.' . $image->extension(); 
        $path = public_path('assets/image/');
        $image->move($path, $imgName);

        //tambah data ke database
        Report::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'telp' => $request->telp,
            'pengaduan' => $request->pengaduan,
            'foto' => $imgName,

        ]);
        return redirect()->back()->with('success', 'Berhasil menambahkan pengaduan');

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
        //cari data yang dimaksud
        $data = Report::where('id', $id)->firstOrFail();
        //$data isinya dari nis dampe foto pengaduan, hapus data foro dari folder public path nama fotony, nama foro diambil dari $data yg diatas trs ngambil dri columh 'foto'
        unlink('assets/image/'.$data['foto']);
       // hapus data dri db
       $data->delete();
       Response::where('report_id', $id)->delete();
        return redirect()->back()
        ->with('successDelete','Delete Success!');

        // $image = public_path('assets/image/'.$data['foto']);
    }

}
