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
    <h2 class="title-table">Laporan Keluhan Petugas</h2>
<div style="display: flex; justify-content: center; margin-bottom: 30px">
    <a href="/logout" style="text-align: center">Logout</a> 
    <div style="margin: 0 10px"> | </div>
    <a href="/" style="text-align: center">Home</a>
    <div style="margin: 0 10px"> | </div>
    <a href="{{route('data')}}">refresh</a>

</div>

@if (Session('responseSuccess'))
        <div style="width: 100%; background: green; padding: 10px">
        <ul class="alert alert-responseSuccess" role="alert">{{ session('responseSuccess') }}</ul>
        </div>
        <!-- bisa pake Session::get('successAdd') kalo pake :: itu class, jadi harus kapital awalnya-->
        @endif

<div style="padding: 0 30px">
    <table>
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Pengaduan</th>
            <th>Gambar</th>
            <th>Status</th>
            <th>Pesan</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @php
        $i = 1;
        @endphp

        @foreach ($reports as $data)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$data->nik}}</td>
                <td>{{$data->nama}}</td>
                <td>{{$data->telp}}</td>
                <td>{{$data->pengaduan}}</td>
                <td>
                    <img src="{{asset('assets/image/' . $data->foto)}}" width="120">
                </td>
                <td>
                    @if ($data->response)
                    {{$data->response['status']}}
                    @else 
                    - 
                    @endif
                </td>
                <td>
                    @if ($data->response)
                    {{$data->response['pesan']}}
                    @else 
                    tidak ada pesan
                    @endif
                </td>
                <td style="display: flex; justify-content:center;">
                <!-- kirim data id dari foreach report ke path dinamis yang punya route respone.edit -->
                <a href="{{route('response.edit', $data->id)}}" class="back-btn">Send Response</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>