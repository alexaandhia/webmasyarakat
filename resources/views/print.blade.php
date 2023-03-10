<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>
<body>
    <h2 class="title-table">Laporan Keluhan</h2>

<div style="padding: 0 30px">
    <table>
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Waktu Pengaduan</th>
            <th>Pengaduan</th>
            <th>Gambar</th>
            <th>Status Response</th>
            <th>Pesan Response</th>
        </tr>
        </thead>
        <tbody>
        @php
        $i = 1;
        @endphp

        @foreach ($reports as $data)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$data['nik']}}</td>
                <td>{{$data['nama']}}</td>
                <td>{{$data['telp']}}</td>
                <td> {{\Carbon\Carbon::parse($data['created_at'])->format('j, F, Y')}}</td>
                <td>{{$data['pengaduan']}}</td>
                <td>
                    <img src="assets/image/{{$data['foto']}}" width="120">
                </td>
                <td>
                    @if ($data['response'])
                    {{$data['response']['status']}}
                    @else 
                    - 
                    @endif
                </td>
                <td>
                    @if ($data['response'])
                    {{$data['response']['pesan']}}
                    @else 
                    tidak ada pesan
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>