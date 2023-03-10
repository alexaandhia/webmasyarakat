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
<div style="display: flex; justify-content: center; margin-bottom: 30px">
    <a href="/logout" style="text-align: center">Logout</a> 
    <div style="margin: 0 10px"> | </div>
    <a href="/" style="text-align: center">Home</a>
    <div style="margin: 0 10px"> | </div>
    <a href="{{ route('export.pdf') }}">Export to PDF</a>
    <div style="margin: 0 10px"> | </div>
    <a href="{{route('export.excel')}}">Export to Excel</a>
    <div style="margin: 0 10px"> | </div>

    <div style="display: flex; padding: 0 30px;">
    <form action="" method="GET">
        <input type="text" name="search" placeholder="search by name...">
        <button type="submit" class="btn-login">cari</button>
    </form>
    </div>

</div>
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
            <th>Status Response</th>
            <th>Pesan Response</th>
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
                @php
                //substr_replace = mengubah karakter stream_set_blocking
                //punya  argumen, argumen 1 data yg mau dimasukin ke string, arg 2 mulai dari mana diubahnya, arg 3 sampe index mana 
                $wa =substr_replace($data->telp, "62",0,1 );
                @endphp
                @php
                if ($data->response){
                $message = 'Hallo '. $data->nama . '! pengaduan anda dalam status '. $data->response['status'] . ' Pesan petugas untuk anda: ' . $data->response['pesan'];
                }else{
                    $message = 'no response yet.';
                }
                @endphp
                <td><a href="https://wa.me/{{$wa}}/?text=%20{{$message}}%20" target="_blank">{{$wa}}</a></td>
                <td>{{$data->pengaduan}}</td>
                <td>
                    <a href="../assets/image/{{$data->foto}}" target="_blank">
                    <img src="{{asset('assets/image/' . $data->foto)}}" width="120">
                    </a>
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
                <td>
                    <form action="/delete/{{$data->id}}" method="post">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn-delete">Hapus</button>
                    </form>
                    <div>
                        <form action="{{route('created.pdf', $data->id)}}" method="GET">
                            @csrf
                            <button class="submit" type="submit">Print</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>