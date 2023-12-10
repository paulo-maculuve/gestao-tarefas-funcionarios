<?php

$servername = "localhost";

$username = "root"; 

$password = ""; 

$dbname = "gestao_tarefas_funcionario"; 

// nome_do_servidor, nome do usuario, password, nome_base_dados

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}else{
    // echo "LIVE";
}

?> 