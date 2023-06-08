<?php

$credenciales["http"]["method"] = "POST";
$credenciales["http"]["header"] = "Content-type: application/json";

  $data = [
    "nombre"=> $_POST["nombre"],
    "apellido"=> $_POST["apellido"],
    "edad"=> $_POST["edad"],
    "direccion"=> $_POST["direccion"],
    "email"=> $_POST["email"],
    "hora" => $_POST["hora"],
    "team" => $_POST["team"],
    "trainer" => $_POST["trainer"],
    "cedula" => $_POST["cedula"]
  ];
  
  $data = json_encode($data);
  
  $credenciales["http"]["content"] = $data;
  $config = stream_context_create($credenciales);
  $_DATA = file_get_contents("https://6480e399f061e6ec4d49ff8e.mockapi.io/informacion", false, $config);
    print_r($_DATA);
    



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Taller CRUD</title>
</head>
<body>
    <div class="container">
        <form method="POST">
            <div class="row justify-content-center mt-3">
                <div class="col-4">
                  <input type="text" placeholder="Nombres:" name="nombre">
                </div>
                <div class="col-4">
                  <Label>Campus Lands</Label>
                </div>
            </div>    
            <div class="row justify-content-center mt-3">
                <div class="col-4">
                  <input type="text" placeholder="Apellidos:" name="apellido">
                </div>
                <div class="col-4">
                  <input type="number" placeholder="Edad:" name="edad">
                </div>
            </div>    
            <div class="row justify-content-center mt-3">
                <div class="col-4">
                  <input type="text" placeholder="Direccion:" name="direccion">
                </div>
                <div class="col-4">
                  <input type="email" placeholder="Email:" name="email">
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-4">
                  <input type="time" placeholder="Hora de Entrada:" name="hora">
                </div>
                <div class="col-2">
                  <input type="submit" value="✅" name="guardar">
                </div>
                <div class="col-2">
                  <input type="submit" value="❌">
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-4">
                  <input type="text" placeholder="Team:" name="team">
                </div>
                <div class="col-2">
                  <input type="submit" value="✏️">
                </div>
                <div class="col-2">
                  <input type="submit" value="🔎">
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-4">
                  <input type="text" placeholder="Trainer:" name="trainer">
                </div>
                <div class="col-4">
                  <input type="number" placeholder="Cedula:" name="cedula">
                </div>
            </div>               
        </form>
        <table class="table mt-3">
            <thead>
              <tr>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Direccion</th>
                <th scope="col">Edad</th>
                <th scope="col">Email</th>
                <th scope="col">Hora Entrada</th>
                <th scope="col">Team</th>
                <th scope="col">Trainer</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</body>
</html>


