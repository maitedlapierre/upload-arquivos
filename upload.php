<?php

$pastaDestino = "uploads/";
$nomeArquivo  = $_FILES['arquivo']['name'];
var_dump($_FILES['arquivo']['name']);
var_dump($_SERVER);
file_exists($_SERVER . $pastaDestino . $nomeArquivo);

?>