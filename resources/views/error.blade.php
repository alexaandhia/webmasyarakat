<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
@if (Session('errorLogin'))
        <div style="width: 100%; background: red; padding: 10px">
        <ul class="alert alert-errorLogin" role="alert">{{ session('errorLogin') }}</ul>
        </div>
        <!-- bisa pake Session::get('successAdd') kalo pake :: itu class, jadi harus kapital awalnya-->
        @endif
<img src="{{asset('assets/image/error.jpg')}}" alt="" style="width: 800px; max-width: 100%;">
</body>
</html>