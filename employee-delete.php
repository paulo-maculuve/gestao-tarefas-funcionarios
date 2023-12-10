<?php 
session_start();

if(!isset($_SESSION['valid'])) {
    header('Location: auth-signin.php');
}

include "conf.php"; 

if (isset($_GET['id'])) {

    $fun_id = $_GET['id'];

    $sql = "DELETE FROM `funcionario` WHERE `id`='$fun_id'";

     $result = $conn->query($sql);

     if ($result == TRUE) {

        echo "Record deleted successfully.";
        header('Location: employee.php');

    }else{

        echo "Error:" . $sql . "<br>" . $conn->error;

    }

} 

?>

