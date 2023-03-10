<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <title>Send response</title>
</head>
<body>
    <form action="{{route('response.update', $reportId)}}" method="post" enctype="multipart/form-data" style="width: 500px; margin: 50px auto; display:block; padding-bottom:10px;">
    <h2>Beri Respon Pada Laporan</h2>
        @csrf
        @method('PATCH')
        <div class="input-card">
            @if ($report)
            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="ditolak" {{ $report['status'] == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="diproses" {{ $report['status'] == 'diproses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ $report['status'] == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            @else
            <select name="status" id="">
                <option selected hidden disabled>Pilih status</option>
                <option value="ditolak">Ditolak</option>
                <option value="diproses">Proses</option>
                <option value="selesai">Selesai</option>
            </select>
            @endif
        </div>
        <div class="input-card">
        <label for="pesan">pesan</label>
        <textarea name="pesan" id="pesan" rows="3">{{$report ? $report['pesan'] : ''}}</textarea>
        </div>
        <button type="submit">Kirim Response</button>
    </form>
</body>
</html>