<?php

session_start();

function colocarDatos($responseGET){
  if (isset($_POST['seleccionado'])){
    $index = intval($_POST['seleccionado']);
  }
  else{
    $index = $_POST['index'];
  }
  
  $_SESSION['nombre'] = $responseGET[$index]->nombre;
  $_SESSION['apellido'] = $responseGET[$index]->apellido;
  $_SESSION['edad'] = $responseGET[$index]->edad;
  $_SESSION['direccion'] = $responseGET[$index]->direccion;
  $_SESSION['email'] = $responseGET[$index]->email;
  $_SESSION['hora'] = $responseGET[$index]->hora;
  $_SESSION['team'] = $responseGET[$index]->team;
  $_SESSION['trainer'] = $responseGET[$index]->trainer;
  $_SESSION['cedula'] = $responseGET[$index]->cedula;
}
function enviarDatos(){

  $data = [
    "nombre"=> $_POST["nombre"],
    "apellido"=> $_POST["apellido"],
    "edad"=> $_POST["edad"],
    "direccion"=> $_POST["direccion"],
    "email"=> $_POST["email"],
    "hora" => $_POST["hora"],
    "team" => $_POST["team"],
    "trainer" => $_POST["trainer"],
    "cedula" => $_POST["cedula"],
  ];
  $data = json_encode($data);
  $credenciales["http"]["method"] = "POST";
  $credenciales["http"]["header"] = "Content-type: application/json";
  $credenciales["http"]["content"] = $data;
  $config = stream_context_create($credenciales);
  file_get_contents("https://6480e399f061e6ec4d49ff8e.mockapi.io/informacion", false, $config);
  $_SESSION=[];
}

function buscarDatos($responseGET){
  $id = null;
  $_POST['index'] = array_search($_POST['cedula'], array_column($responseGET, 'cedula'));
  colocarDatos($responseGET);
}

function eliminarDatos($responseGET){
  $id = null;
  foreach ($responseGET as $key => $value) {
    if ($value->cedula == $_POST['cedula']) {
      $id = $value->id;
      break;
    }
  }
  $credenciales["http"]["method"] = "DELETE";
  $credenciales["http"]["header"] = "Content-type: application/json";
  $config = stream_context_create($credenciales);
  file_get_contents("https://6480e399f061e6ec4d49ff8e.mockapi.io/informacion/$id", false, $config);
  $_SESSION = [];
}

$responseGET = file_get_contents("https://6480e399f061e6ec4d49ff8e.mockapi.io/informacion");
$responseGET = json_decode($responseGET);
$tablaGET = "";
foreach($responseGET as $key=>$value) {
  $tablaGET .= "<tr>
      <td>{$value->nombre}</td>
      <td>{$value->apellido}</td>
      <td>{$value->edad}</td>
      <td>{$value->direccion}</td>
      <td>{$value->email}</td>
      <td>{$value->hora}</td>
      <td>{$value->team}</td>
      <td>{$value->trainer}</td>
      <td>
        <form action='index.php' method='POST'>
          <input type='submit' name='accion' value='🔝'>
          <input type='hidden' name='seleccionado' value={$key}>
        </form>
      </td>
    </tr>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  switch($_POST['accion']){
    case '✅':
      enviarDatos();
      break;
    case '❌':
      eliminarDatos($responseGET);
      break;
    case '🔝':
      colocarDatos($responseGET);
      break;
    case '🔎':
      buscarDatos($responseGET);
      break;
  }
  header("Location: index.php");
  exit();
}
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
                  <input type="text" placeholder="Nombres:" name="nombre" value=<?php
                  if (isset($_SESSION['nombre'])) {
                      echo $_SESSION['nombre'];
                  }
                  ?>>
                </div>
                <div class="col-4">
                  <Label>Campus Lands</Label>
                </div>
            </div>    
            <div class="row justify-content-center mt-3">
                <div class="col-4">
                  <input type="text" placeholder="Apellidos:" name="apellido" value=<?php
                  if (isset($_SESSION['apellido'])) {
                      echo $_SESSION['apellido'];
                  }
                  ?>
                  >
                </div>
                <div class="col-4">
                  <input type="number" placeholder="Edad:" name="edad" value=<?php
                if (isset($_SESSION['edad'])) {
                    echo $_SESSION['edad'];
                }
                ?>
                >
                </div>
            </div>    
            <div class="row justify-content-center mt-3">
                <div class="col-4">
                  <input type="text" placeholder="Direccion:" name="direccion" value=<?php
                  if (isset($_SESSION['direccion'])) {
                      echo $_SESSION['direccion'];
                  }
                  ?>
                  >
                </div>
                <div class="col-4">
                  <input type="email" placeholder="Email:" name="email" value=<?php
                  if (isset($_SESSION['email'])) {
                      echo $_SESSION['email'];
                  }
                  ?>
                  >
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-4">
                  <input type="time" placeholder="Hora de Entrada:" name="hora" value=<?php
                  if (isset($_SESSION['hora'])) {
                      echo $_SESSION['hora'];
                  }
                  ?>
                  >
                </div>
                <div class="col-2">
                  <input type="submit" value="✅" name="accion">
                </div>
                <div class="col-2">
                  <input type="submit" value="❌" name="accion">
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-4">
                  <input type="text" placeholder="Team:" name="team" value=<?php
                  if (isset($_SESSION['team'])) {
                      echo $_SESSION['team'];
                  }
                  ?>
                  >
                </div>
                <div class="col-2">
                  <input type="submit" value="✏️" name="accion">
                </div>
                <div class="col-2">
                  <input type="submit" value="🔎"name="accion" >
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-4">
                  <input type="text" placeholder="Trainer:" name="trainer" value=<?php
                  if (isset($_SESSION['trainer'])) {
                      echo $_SESSION['trainer'];
                  }
                  ?>
                  >
                </div>
                <div class="col-4">
                  <input type="number" placeholder="Cedula:" name="cedula" value=<?php
                  if (isset($_SESSION['cedula'])) {
                      echo $_SESSION['cedula'];
                  }
                  ?>
                  >
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
                <th scope="col">Editar</th>
              </tr>
            </thead>

            <tbody>
              <?php
                echo $tablaGET;
              ?>
            </tbody>

        </table>
    </div>
</body>
</html>


