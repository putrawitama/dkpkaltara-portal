<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $details['subject'] }}</title>
</head>
<body>
    <h1>{{ $details['subject'] }}</h1> <br>
    <h3>Nama: {{ $details['name'] }}</h3>
    <h3>Email: {{ $details['email'] }}</h3>
    <h3>No HP: {{ $details['phone'] }}</h3> <br><br>
    <p>{{ $details['content'] }}</p>
</body>
</html>