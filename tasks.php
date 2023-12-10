<?php
session_start();

if(!isset($_SESSION['valid'])) {
    header('Location: auth-signin.php');
}

include "conf.php";


if($_SESSION['nivel_acesso'] == 1){
   $sql = "SELECT t.*, f.nome AS nome, f.avatar AS avatar
    FROM tarefas t
    INNER JOIN funcionario f ON t.id_funcionario = f.id"; 
}else{
    $sql = "SELECT t.*, f.nome AS nome, f.avatar AS avatar
    FROM tarefas t
    INNER JOIN funcionario f ON t.id_funcionario = f.id where id_funcionario = ".$_SESSION['id'];
}

$result = $conn->query($sql);

function prioridadeClass($prioridade) {
    switch ($prioridade) {
        case 'Baixa':
            return 'bg-success';
        case 'Media':
            return 'bg-warning';
        case 'Urgente':
            return 'bg-danger';
        default:
            return '';
    }
}

function statusClass($status) {
    switch ($status) {
        case 'Em Progresso':
            return 'bg-info';
        case 'Completo':
            return 'bg-success';
        case 'Pendente':
            return 'bg-danger';
        default:
            return '';
    }
}

if(isset($_GET['status'])){
    $tstatus = $_GET['status'];
    $tid = $_GET['id'];
    $sql1 = "UPDATE `tarefas` SET `estado`=$tstatus WHERE `id`=$tid";
    $result1 = $conn->query($sql1);
    header('Location: tasks.php');
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
        <div class="body d-flex py-lg-3 py-md-2">
            <div class="container-xxl">
                <div class="row align-items-center">
                    <div class="border-0 mb-4">
                        <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                            <h3 class="fw-bold mb-0">Tarefas</h3>
                            
                        </div>
                    </div>
                </div> <!-- Row end  -->
                <div class="row clearfix g-3">
                  <div class="col-sm-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Tarefa ID</th>
                                            <th>Descrição</th>
                                            <?php if($_SESSION['nivel_acesso'] == 1){ ?>
                                                <th>Responsavel</th>
                                            <?php } ?>
                                             
                                            <th>Data de Inicio</th> 
                                            <th>Data de Entrega</th>   
                                            <th>Prioridade</th>   
                                            <th>Status</th>   
                                            <th>Acções</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if ($result->num_rows > 0) {

                                            while ($row = $result->fetch_assoc()) {

                                        ?>
                                        <tr>
                                            <td>
                                                <a href="ticket-detail.html" class="fw-bold text-secondary"><?php echo $row['id']; ?></a>
                                            </td>
                                            <td>
                                            <?php echo $row['descricao']; ?>
                                            </td>
                                            <?php if($_SESSION['nivel_acesso'] == 1){ ?>
                                                <td>
                                            <?php
                                                echo '<img class="avatar rounded-circle" src="upload/'. $row['avatar'] . '" alt="">'?>
                                                <span class="fw-bold ms-1"><?php echo $row['nome']; ?></span>
                                            </td>
                                            <?php } ?>
                                            <td>
                                                <?php echo $row['inicio']; ?>
                                           </td>
                                           <td>
                                                <?php echo $row['prazo']; ?>
                                           </td>
                                           <td><span class="badge <?php echo prioridadeClass($row['prioridade']); ?>"><?php echo $row['prioridade']; ?></span></td>
                                           <td><span class="badge <?php echo statusClass($row['estado']); ?>"><?php echo $row['estado']; ?></span></td>

                                             <td>
                                                <?php if($_SESSION['nivel_acesso'] == 1){ ?>
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                     <a href="tasks-edit.php?id=<?php echo $row['id'];?>" class="btn btn-outline-secondary" ><i class="icofont-edit text-success"></i></a>
                                                     <a href="tasks-delete.php?id=<?php echo $row['id'];?>" class="btn btn-outline-secondary"><i class="icofont-ui-delete text-danger"></i></a>
                                                     </div>
                                                <?php } else { ?>
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                    <?php if($row['estado'] == "Pendente"){ ?>
                                                     <a href="tasks.php?id=<?php echo $row['id'];?>&status='Em Progresso'" class="btn btn-success" ><i class="icofont-ui-next text-sucess"></i></a>
                                                     <?php }if($row['estado'] == "Em Progresso"){ ?>
                                                     <a href="tasks.php?id=<?php echo $row['id'];?>&status='Completo'" class="btn btn-success" ><i class="icofont-ui-pause text-sucess"></i></a>
                                                     
                                                     <?php }if($row['estado'] == "Completo"){ ?>
                                                     <span class="badge bg-success">
                                                         Completo
                                                     </span>
                                                     <?php } ?>
                                                 </div>
                                                <?php } ?>
                                             </td>
                                         </tr>

                                         <?php
                                            }
                                        }
                                       ?>
                                    </tbody>
                                </table>
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
