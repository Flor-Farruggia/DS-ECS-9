<?php
require_once '../../modelo/medioCont.php';
require_once '../../modelo/vehiculo.php';
require_once 'responses/nuevoResponse.php';
require_once 'request/nuevoRequest.php';

header('Content-Type: application/json');
$resp = new NuevoResponse();

$json = file_get_contents('php://input',true);
$req = json_decode($json);

$resp->IsOk=true;
$resp->Mensaje[]=" ";

if ($req->NroPoliza >1000 || $req->NroPoliza<0){
    $resp->IsOk= false;
    $resp->Mensaje[]=" La póliza no existe ";
} else {
    if ($req->Vehiculo == NULL ){
        $resp->IsOk= false;
        $resp->Mensaje []="Debe indicar el vehículo";
    } else {
        if ($req->Vehiculo->Marca == NULL || $req->Vehiculo->Modelo == NULL 
        || $req->Vehiculo->Version == NULL || $req->Vehiculo->Anio == NULL){
        $resp->IsOk= false;
        $resp->Mensaje []="Debe indicar todas las propiedades del vehiculo";
        }
    }

    $medCont = 0;
    foreach ($req->ListMediosContacto as $mc) {
        $medCont = $medCont + 1;
    }
    if ($medCont==0){
        $resp->IsOk= false;
        $resp->Mensaje []="Debe indicar al menos un medio de contacto";
    } else {
        foreach ($req->ListMediosContacto as $mc) {
            if ($mc->MedioContactoDescripcion !== "Celular" 
            && $mc->MedioContactoDescripcion !== "Mail"){
                $resp->IsOk= false;           
                $resp->Mensaje []="Debe indicar medios de contacto válidos";
                break;
            } 
        }
    }
}

echo json_encode($resp);
