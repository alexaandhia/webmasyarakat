<?php

namespace App\Exports;

use App\Models\Report;
//mengambil data dari database
use Maatwebsite\Excel\Concerns\FromCollection;
//mengatur nama column header di excelnya
use Maatwebsite\Excel\Concerns\WithHeadings;
//mengatur data uang dimunculkan tiap column di excelnya
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //disini boleh menyertakan perintah eloquent lain seperti where, all, dll
        return Report::with('response')->orderBy('created_at', 'DESC')->get();
    }
    public function headings(): array
    {
        return[
            'ID',
            'NIK',
            'Nama',
            'No Telp',
            'Tanggal Melapor',
            'Deskripsi Pengaduan',
            'status respon',
            'pesan',

        ];
    }
    //mengatur data yang ditampilkan per column di excelnya
    //fungsinya seperti foreach,  $item merupakan bagian as pada foreach
    public function map($item): array
    {
        return[
            $item->id,
            $item->nik,
            $item->nama,
            $item->telp,
            \Carbon\Carbon::parse($item->created_at)->format('j, F, Y'),
            $item->pengaduan,
            $item->response ? $item->response['status'] : '-',
            $item->response ? $item->response['pesan'] : '-',
        ];
    }
}
