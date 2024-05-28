<?php

//definiu a pasta de destino
$pastaDestino = "/uploads/";
var_dump($_FILES);

var_dump($_FILES['arquivo']['size']);

//verificar se tamanho do arquivo é maior que 2mb
if(($_FILES['arquivo']['size']) > 2000000){
    echo "O tamanho do arquivo é maior que o limite permitido!";
    die();
}

// verificar se o arquivo é uma imagem
var_dump($_FILES['arquivo']['name']);
var_dump(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION)); 


?>