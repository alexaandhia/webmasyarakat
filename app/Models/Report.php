<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\ReportController;
use App\Models\Response;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik',
        'nama', 
        'telp',
        'pengaduan',
        'foto',
    ];

    //hasOne: one to one 
    //table yang berperan sebagai PK
    //nama fungsi == nama model FK
    //nama function diambil dari nama model FK
    public function response(){
        return $this->hasOne(Response::class);
    }
} 
