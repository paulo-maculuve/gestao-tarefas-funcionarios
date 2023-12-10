<?php
session_start();

if(!isset($_SESSION['valid'])) {
    header('Location: auth-signin.php');
}
include "conf.php";
$sql_usuarios = "SELECT COUNT(*) AS total_usuarios FROM funcionario";
if($_SESSION['nivel_acesso'] == 1){
   $sql_tarefas = "SELECT COUNT(*) AS total_tarefas FROM tarefas"; 
}else{
    $sql_tarefas = "SELECT COUNT(*) AS total_tarefas FROM tarefas where id_funcionario = ".$_SESSION['id'];
}

$sql_funcionarios = "SELECT COUNT(*) AS total_funcionarios FROM funcionario";
$sql_departamentos = "SELECT COUNT(*) AS total_departamentos FROM departamento";


$result_usuarios = $conn->query($sql_usuarios);
$result_tarefas = $conn->query($sql_tarefas);
$result_funcionarios = $conn->query($sql_funcionarios);
$result_departamentos = $conn->query($sql_departamentos);


if (!$result_usuarios || !$result_tarefas || !$result_funcionarios || !$result_departamentos) {
    die("Erro na consulta: " . $conn->error);
}


$row_usuarios = $result_usuarios->fetch_assoc();
$row_tarefas = $result_tarefas->fetch_assoc();
$row_funcionarios = $result_funcionarios->fetch_assoc();
$row_departamentos = $result_departamentos->fetch_assoc();
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Gestão das Tarefas de Funcionarios</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <!-- project css file  -->
    <link rel="stylesheet" href="assets/css/my-task.style.min.css">
</head>

<body  data-mytask="theme-indigo">
<div id="mytask-layout">
    
    <?php include 'menu.php' ?>

    <!-- main body area -->
    <div class="main px-lg-4 px-md-4">

        <!-- Body: Header -->
        <div class="header">
            <nav class="navbar py-4">
                <div class="container-xxl">
    
                    <?php include('profile-info.php') ?>
    
                    <!-- menu toggler -->
                    <button class="navbar-toggler p-0 border-0 menu-toggle order-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainHeader">
                        <span class="fa fa-bars"></span>
                    </button>
    
                    <!-- main menu Search-->
                    <div class="order-0 col-lg-4 col-md-4 col-sm-12 col-12 mb-3 mb-md-0 ">
                        
                    </div>
    
                </div>
            </nav>
        </div>


        <!-- Body: Body -->
        <div class="body d-flex py-3">
            <div class="container-xxl">
                <div class="row clearfix g-3">
                    <?php if($_SESSION['nivel_acesso'] == 1){ ?>
                    <div class="col-xl-8 col-lg-12 col-md-12 flex-column">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                        <h6 class="mb-0 fw-bold ">Bem vindo ao sistema de gestão de tarefas</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="ac-line-transparent" id="apex-emplyoeeAnalytics"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                        <h6 class="mb-0 fw-bold ">Dados</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-2 row-deck">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body ">
                                                        <i class="icofont-checked fs-3"></i>
                                                        <h6 class="mt-3 mb-0 fw-bold small-14">Tarefas </h6>
                                                        <span class="text-muted"><?php echo $row_tarefas['total_tarefas'];?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="card">
                                                    <div class="card-body ">
                                                            <i class="icofont-stopwatch fs-3"></i>
                                                        <h6 class="mt-3 mb-0 fw-bold small-14">Departamentos</h6>
                                                        <span class="text-muted"><?php echo $row_departamentos['total_departamentos'];?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                        <h6 class="mb-0 fw-bold ">Total Funcionarios</h6>
                                        <h4 class="mb-0 fw-bold "><?php echo  $row_funcionarios['total_funcionarios'];?></h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="mt-3" id="apex-MainCategories"></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-12">
                        <div class="row g-3 row-deck">
                            <div class="col-md-6 col-lg-6 col-xl-12">
                                <div class="card bg-primary">
                                    <div class="card-body row">
                                        <div class="col">
                                            <span class="avatar lg bg-white rounded-circle text-center d-flex align-items-center justify-content-center"><i class="icofont-file-text fs-5"></i></span>
                                            <h1 class="mt-3 mb-0 fw-bold text-white"><?php echo $row_tarefas['total_tarefas'];?></h1>
                                            <span class="text-white">Tarefas</span>
                                        </div>
                                        <div class="col">
                                            <img class="img-fluid" src="assets/images/interview.svg" alt="interview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <?php } ?>

                    <?php if($_SESSION['nivel_acesso'] == 0){ ?>
                    <div class="col-xl-8 col-lg-12 col-md-12 flex-column">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                        <h6 class="mb-0 fw-bold ">Bem vindo ao sistema de gestão de tarefas</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="ac-line-transparent" id="apex-emplyoeeAnalytics"></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-12">
                        <div class="row g-3 row-deck">
                            <div class="col-md-6 col-lg-6 col-xl-12">
                                <div class="card bg-primary">
                                    <div class="card-body row">
                                        <div class="col">
                                            <span class="avatar lg bg-white rounded-circle text-center d-flex align-items-center justify-content-center"><i class="icofont-file-text fs-5"></i></span>
                                            <h1 class="mt-3 mb-0 fw-bold text-white"><?php echo $row_tarefas['total_tarefas'];?></h1>
                                            <span class="text-white">Tarefas</span>
                                        </div>
                                        <div class="col">
                                            <img class="img-fluid" src="assets/images/interview.svg" alt="interview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <?php } ?>
                </div><!-- Row End -->
            </div>
        </div> 

        
    </div>

 
</div>

<!-- Jquery Core Js -->
<script src="assets/bundles/libscripts.bundle.js"></script>

<!-- Plugin Js-->
<script src="assets/bundles/apexcharts.bundle.js"></script>

<!-- Jquery Page Js -->
<script src="../js/template.js"></script>
<script src="../js/page/hr.js"></script>
</body>

</html> 