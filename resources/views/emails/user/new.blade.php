
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>{{$user->name}}</h2><h3>tu  registro se realizó exitosamente, tus credenciales son:</h3>
<ul>
    <li>Usuario:  {{ $user->email }} </li>
    <li>Contraseña:  {{ $user->password}} </li>
    <h1>BIENVENIDO A MECANIAPP</h1>
</ul>
</body>
</html>
