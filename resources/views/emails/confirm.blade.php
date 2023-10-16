<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div style="
            padding:10px;
            font-family:Arial, Helvetica, sans-serif;
            font-size: 20px;
        ">

        <p>Please use the otp {{ $data->token }} <a href="{{ route('confirmEmail')}}"
            style="display:block; padding:10px;">Confirm Email</a></p>
    </div>
</body>
</html>
