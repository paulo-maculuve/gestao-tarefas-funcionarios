<?php
session_start();

if(!isset($_SESSION['valid'])) {
    header('Location: auth-signin.php');
}

include "conf.php";

if (isset($_POST['update'])) {

    $id = $_GET['id'];
    $descricao = $_POST['descricao'];
    $dataInicio = $_POST['dataInicio'];
    $dataEntrega = $_POST['dataEntrega'];
    $prioridade = $_POST['prioridade'];
    $status = $_POST['status'];
    $idFuncionario = $_POST['idFuncionario'];

    $inicioDataFormatada = date('Y-m-d', strtotime($dataInicio));
    $entregaDataFormatada = date('Y-m-d', strtotime($dataEntrega));

    $sql = "UPDATE `tarefas` SET `descricao`='$descricao',`inicio`='$inicioDataFormatada',`prazo`='$entregaDataFormatada',`prioridade`='$prioridade',`estado`='$status', `id_funcionario` = '$idFuncionario' WHERE `id`='$id'"; 
    $result = $conn->query($sql);
    if ($result == TRUE) {
       
        header("Location: tasks.php");?>
        <div role="alert" class="alert alert-success">Tarefa adicionado com sucesso!</div>
        <?php
        exit();
  
    }else{

    // echo "Error:". $sql . "<br>". $conn->error;

    } 
  
    $conn->close(); 
  
  
}

$sql = "SELECT * FROM funcionario where nivel_acesso = 0";

$resultFunc = $conn->query($sql);

if (isset($_GET['id'])) {

    $tar_id = $_GET['id']; 

    $sql = "SELECT * FROM `tarefas` WHERE `id`='$tar_id'";
    
    $result = $conn->query($sql); 

    

    if ($result->num_rows > 0) {        

        while ($row = $result->fetch_assoc()) {

            $id = $row['id'];
            $descricao = $row['descricao'];
            $dataInicio = $row['inicio'];
            $dataEntrega = $row['prazo'];
            $prioridade = $row['prioridade'];
            $status = $row['estado'];
            $idFuncionario = $row['id_funcionario'];
            
        } 

?>



<!doctype html>
<html class="no-js" lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gestão das Tarefas de Funcionarios - Tasks</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <!-- plugin css file  -->
    <link rel="stylesheet" href="assets/plugin/datatables/responsive.dataTables.min.css">
    <link rel="stylesheet" href="assets/plugin/datatables/dataTables.bootstrap5.min.css">
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
                    <a href="auth-signin.php" class="btn btn-link sidebar-mini-btn text-light">
                        <span class="ms-2"><i class="icofont-bubble-right"></i></span>
                    </a>
    
                    <!-- main menu Search-->
                    <div class="order-0 col-lg-4 col-md-4 col-sm-12 col-12 mb-3 mb-md-0 ">
                        
                    </div>
    
                </div>
            </nav>
        </div>

        <!-- Body: Body -->       
        <div class="body d-flex py-lg-3 py-md-2">
            <div class="container-xxl">
                <div class="row align-items-center">
                    <div class="border-0 mb-4">
                        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                            <h3 class="fw-bold mb-0">Tarefas > Adicionar</h3>
                            
                        </div>
                    </div>
                </div> <!-- Row end  -->
                <div class="row clearfix g-3">
                  <div class="col-sm-12">
                        <div class="card mb-3">
                            <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">

                                <div class="deadline-form">

                                    <div class="row g-3 mb-3">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="mb-3">
                                                        <input type="hidden" name="id">
                                                        <label for="descricao" class="form-label">Descrição</label>
                                                        <textarea id="" class="form-control" cols="30" rows="4" name="descricao"><?php echo $descricao; ?></textarea>
                                                    
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nome" class="form-label">Data de Inicio</label>
                                                        <input type="date" class="form-control" id="nome" required name="dataInicio" value="<?php echo $dataInicio; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="depone" class="form-label">Data de Entrega</label>
                                                        <input type="date" class="form-control" id="depone" required name="dataEntrega" value="<?php echo $dataEntrega; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="depone" class="form-label">Prioridade</label>
                                                        <select class="form-control" name="prioridade" required>
                                                            <option select disible><?php echo $prioridade; ?></option>
                                                            <option value="Baixa">Baixa</opction>
                                                            <option value="Media">Media</opction>
                                                            <option value="Urgente">Urgente</opction>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="depone" class="form-label">Status</label>
                                                        <select class="form-control" name="status" required>
<option <?php echo ($status == "Pendente")?"selected":"" ?> value="Pendente">Pendente</option>
<option <?php echo ($status == "Em Progresso")?"selected":"" ?> value="Em Progresso">Em Progresso</option>
<option <?php echo ($status == "Completo")?"selected":"" ?> value="Completo">Completo</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="depone" class="form-label">Funcioanrio Responsavel</label>
                                                        <select class="form-control" name="idFuncionario" required>
                                                             <option select disible>Selecione o funcionario</option>
                                                        <?php
                                                            if ($resultFunc->num_rows > 0) {

                                                                while ($row = $resultFunc->fetch_assoc()) {

                                                            ?>
                                                            
                                                            <option <?php echo ($idFuncionario == $row['id'])?"selected":"" ?> value="<?php echo $row['id']; ?>"><?php echo $row['nome']; ?></option>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button type="submit"
                                                            class="btn btn-primary" name="update">Update</button>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <?php
                                    } else{ 

                                        
                                
                                    } 
                                
                                }
                                ?>

                            </form>
                            </div>
                        </div>
                  </div>
                </div><!-- Row End -->
            </div>
        </div>
        
        <!-- Modal Members-->
        <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="addUserLabel">Employee Invitation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="inviteby_email">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email address" id="exampleInputEmail1" aria-describedby="exampleInputEmail1">
                            <button class="btn btn-dark" type="button" id="button-addon2">Sent</button>
                        </div>
                    </div>
                    <div class="members_list">
                        <h6 class="fw-bold ">Employee </h6>
                        <ul class="list-unstyled list-group list-group-custom list-group-flush mb-0">
                            <li class="list-group-item py-3 text-center text-md-start">
                                <div class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                    <div class="no-thumbnail mb-2 mb-md-0">
                                        <img class="avatar lg rounded-circle" src="assets/images/xs/avatar2.jpg" alt="">
                                    </div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <h6 class="mb-0  fw-bold">Rachel Carr(you)</h6>
                                        <span class="text-muted">rachel.carr@gmail.com</span>
                                    </div>
                                    <div class="members-action">
                                        <span class="members-role ">Admin</span>
                                        <div class="btn-group">
                                            <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="icofont-ui-settings  fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                              <li><a class="dropdown-item" href="#"><i class="icofont-ui-password fs-6 me-2"></i>ResetPassword</a></li>
                                              <li><a class="dropdown-item" href="#"><i class="icofont-chart-line fs-6 me-2"></i>ActivityReport</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item py-3 text-center text-md-start">
                                <div class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                    <div class="no-thumbnail mb-2 mb-md-0">
                                        <img class="avatar lg rounded-circle" src="assets/images/xs/avatar3.jpg" alt="">
                                    </div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <h6 class="mb-0  fw-bold">Lucas Baker<a href="#" class="link-secondary ms-2">(Resend invitation)</a></h6>
                                        <span class="text-muted">lucas.baker@gmail.com</span>
                                    </div>
                                    <div class="members-action">
                                        <div class="btn-group">
                                            <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Members
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                              <li>
                                                  <a class="dropdown-item" href="#">
                                                    <i class="icofont-check-circled"></i>
                                                      
                                                    <span>All operations permission</span>
                                                   </a>
                                                   
                                                </li>
                                                <li>
                                                     <a class="dropdown-item" href="#">
                                                        <i class="fs-6 p-2 me-1"></i>
                                                           <span>Only Invite & manage team</span>
                                                       </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="icofont-ui-settings  fs-6"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                              <li><a class="dropdown-item" href="#"><i class="icofont-delete-alt fs-6 me-2"></i>Delete Member</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item py-3 text-center text-md-start">
                                <div class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                    <div class="no-thumbnail mb-2 mb-md-0">
                                        <img class="avatar lg rounded-circle" src="assets/images/xs/avatar8.jpg" alt="">
                                    </div>
                                    <div class="flex-fill ms-3 text-truncate">
                                        <h6 class="mb-0  fw-bold">Una Coleman</h6>
                                        <span class="text-muted">una.coleman@gmail.com</span>
                                    </div>
                                    <div class="members-action">
                                        <div class="btn-group">
                                            <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Members
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                              <li>
                                                  <a class="dropdown-item" href="#">
                                                    <i class="icofont-check-circled"></i>
                                                      
                                                    <span>All operations permission</span>
                                                   </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="fs-6 p-2 me-1"></i>
                                                           <span>Only Invite & manage team</span>
                                                       </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-group">
                                            <div class="btn-group">
                                                <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icofont-ui-settings  fs-6"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                  <li><a class="dropdown-item" href="#"><i class="icofont-ui-password fs-6 me-2"></i>ResetPassword</a></li>
                                                  <li><a class="dropdown-item" href="#"><i class="icofont-chart-line fs-6 me-2"></i>ActivityReport</a></li>
                                                  <li><a class="dropdown-item" href="#"><i class="icofont-delete-alt fs-6 me-2"></i>Suspend member</a></li>
                                                  <li><a class="dropdown-item" href="#"><i class="icofont-not-allowed fs-6 me-2"></i>Delete Member</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Add Tickit-->
        <div class="modal fade" id="tickadd" tabindex="-1"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="leaveaddLabel"> Tickit Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sub" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="sub">
                    </div>
                    <div class="deadline-form">
                        <form>
                            <div class="row g-3 mb-3">
                              <div class="col">
                                <label for="depone" class="form-label">Assign Name</label>
                                <input type="text" class="form-control" id="depone">
                              </div>
                              <div class="col">
                                <label for="deptwo" class="form-label">Creted Date</label>
                                <input type="date" class="form-control" id="deptwo">
                              </div>
                            </div>
                        </form>
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Status</label>
                        <select class="form-select">
                            <option selected>In Progress</option>
                            <option value="1">Completed</option>
                            <option value="2">Wating</option>
                            <option value="3">Decline</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                    <button type="submit" class="btn btn-primary">sent</button>
                </div>
            </div>
            </div>
        </div>

         <!-- Edit Tickit-->
         <div class="modal fade" id="edittickit" tabindex="-1"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="edittickitLabel"> Tickit Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="sub1" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="sub1" value="punching time not proper">
                    </div>
                    <div class="deadline-form">
                        <form>
                            <div class="row g-3 mb-3">
                              <div class="col">
                                <label for="depone11" class="form-label">Assign Name</label>
                                <input type="text" class="form-control" id="depone11" value="Victor Rampling">
                              </div>
                              <div class="col">
                                <label for="deptwo56" class="form-label">Creted Date</label>
                                <input type="date" class="form-control" id="deptwo56" value="2021-02-25">
                              </div>
                            </div>
                        </form>
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Status</label>
                        <select class="form-select">
                            <option selected>Completed</option>
                            <option value="1">In Progress</option>
                            <option value="2">Wating</option>
                            <option value="3">Decline</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                    <button type="submit" class="btn btn-primary">sent</button>
                </div>
            </div>
            </div>
        </div>
    </div>

</div>
 
<!-- Jquery Core Js -->
<script src="assets/bundles/libscripts.bundle.js"></script>

<!-- Plugin Js-->
<script src="assets/bundles/dataTables.bundle.js"></script>

<!-- Jquery Page Js -->
<script src="../js/template.js"></script>
<script>
    // project data table
    $(document).ready(function() {
        $('#myProjectTable')
        .addClass( 'nowrap' )
        .dataTable( {
            responsive: true,
            columnDefs: [
                { targets: [-1, -3], className: 'dt-body-right' }
            ]
        });
        $('.deleterow').on('click',function(){
        var tablename = $(this).closest('table').DataTable();  
        tablename
                .row( $(this)
                .parents('tr') )
                .remove()
                .draw();

        } );
    });
</script>
</body>

</html>
