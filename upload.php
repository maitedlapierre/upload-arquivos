<?php

//definiu a pasta de destino
$pastaDestino = "/uploads/";

//verificar se tamanho do arquivo é maior que 2mb
if(($_FILES['arquivo']['size']) > 2000000){
    echo "O tamanho do arquivo é maior que o limite permitido!";

//condição de guarda
    die();
}

// verificar se o arquivo é uma imagem
$extensao= strtolower (pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION));

if($extensao != "png" && $extensao != "jpg" && 
    $extensao != "jpeg" && $extensao != "gif" && 
    $extensao != "jfif" && $extensao != "svg") {
    echo "O arquivo não é uma imagem! Apenas selecione arquivos com extensão png,jpg, jpeg, gif, jfif ou svg.";

//condição de guarda
    die ();
}

//verificar se é uma imagem de fato
if(getimagesize($_FILES['arquivo']['tmp_name']) === "false") {
    echo "Problemas ao enviar a imagem. Tente novamente!";
    die();
}

$nomeArquivo= uniqid();

//se deu certo, faz o upload
$fezUp= move_uploaded_file($_FILES['arquivo']['tmp_name'], __DIR__ . $pastaDestino . $nomeArquivo . "." . $extensao);

if($fezUp == true) {
    $conexao= mysqli_connect("localhost", "root", "", "upload-arquivos");
    $slq= "INSERT INTO arquivo (nome_arquivo) VALUES ('$nomeArquivo.$extensao')";
    $resultado= mysqli_query ($conexao, $slq);
    if ($resultado != false ) {

        //se for uma alteração de arquivo
        if (isset($_POST['nome_arquivo'])) {
            $apagou= unlink (__DIR__ . $pastaDestino . $_POST['nome_arquivo']);
            if($apagou == true) {
            $slq= "DELETE FROM arquivo WHERE nome_arquivo='" . $_POST['nome_arquivo'] . "'";
            $resultado2= mysqli_query ($conexao, $slq);
            if($resultado2 == false) {
                echo "Erro ao apagar o arquivo do banco de dados.";
                die();
            }


            } else {
                echo "Erro ao apagar o arquivo antigo.";
                die();
            }
        }
        header("location:index.php");
    } else { 
        echo "Erro ao registrar o arquivo no banco de dados."; 
    }

} else {
    echo "Erro ao mover arquivo";
}



?>