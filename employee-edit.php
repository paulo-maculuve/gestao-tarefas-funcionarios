<?php
session_start();

if(!isset($_SESSION['valid'])) {
    header('Location: auth-signin.php');
}
require_once('conf.php');

if (isset($_POST['update'])) {

    $id = $_POST['id'];

    $avatar = $_POST['avatar'];

    $avatar = null;
    $avatar = time() . '.' . $_FILES['avatar']['name'];
    move_uploaded_file($_FILES['avatar']['tmp_name'], 'upload/' . $avatar);

    $nomeFunc = $_POST['nomeFunc'];
    $telefone = $_POST['telefone'];
    $cargoFunc = $_POST['cargoFunc'];
    $departamento = $_POST['departamento'];

    $sql = "UPDATE `funcionario` SET `nome`='$nomeFunc',`telefone`='$telefone',`cargo`='$cargoFunc',`departamento`='$departamento', `avatar`= '$avatar' WHERE `id`='$id'"; 

    $result = $conn->query($sql); 

    if ($result == TRUE) {

        header('Location: employee.php');
        exit();

    }else{

        echo "Error:" . $sql . "<br>" . $conn->error;

    }

} 

$sql = "SELECT * FROM departamento";

$resultDep = $conn->query($sql);

if (isset($_GET['id'])) {

    $fun_id = $_GET['id']; 

    $sql = "SELECT * FROM `funcionario` WHERE `id`='$fun_id'";
    
    $result = $conn->query($sql); 

    

    if ($result->num_rows > 0) {        

        while ($row = $result->fetch_assoc()) {

            $avatar = $row['avatar'];

            $nomeFunc = $row['nome'];

            $telefone = $row['telefone'];

            $cargoFunc  = $row['cargo'];

            $departamento = $row['departamento'];

            $id = $row['id'];
            $email = $row['email'];
            $nivel_acesso = $row['nivel_acesso'];
        } 

?>


<!doctype html>
<html class="no-js" lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gestão das Tarefas de Funcionarios - Employee</title>
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
                            <h3 class="fw-bold mb-0">Funcionario > Editar</h3>
                            
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
                                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                        <label for="nome" class="form-label">Avatar do funcionario</label>
                                                        <input type="file" class="form-control" id="nome" name="avatar"required value="<?php echo $avatar; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nome" class="form-label">Nome do funcionario</label>
                                                        <input type="text" class="form-control" id="nome" name="nomeFunc" required value="<?php echo $nomeFunc; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="depone" class="form-label">Telefone</label>
                                                        <input type="text" class="form-control" id="depone" name="telefone" required value="<?php echo $telefone; ?>"> 
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="depone" class="form-label">Cargo do funcionario</label>
                                                        <input type="text" class="form-control" id="depone" name="cargoFunc" required value="<?php echo $cargoFunc; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="depone" class="form-label">Departamento</label>
                                                        <select class="form-control" name="departamento" required>
                                                        <?php
                                                            if ($resultDep->num_rows > 0) {

                                                                while ($row = $resultDep->fetch_assoc()) {

                                                            ?>
                                                            <option value="<?php echo $row['nome_departamento']; ?>"><?php echo $row['nome_departamento']?></opction>
                                                            <?php

                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="depone" class="form-label">Email</label>
                                                        <input type="text" class="form-control"  value="<?php echo $email; ?>" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="depone" class="form-label">Nível de acesso</label>
                                                        <select class="form-control" name="nivel_acesso" required>
                                                        
                                                            <option <?php echo ($nivel_acesso == 1)?"seleted":"" ?> value="1">Admin</opction>
                                                            <option <?php echo ($nivel_acesso == 1)?"seleted":"" ?> value="0">Funcionário</opction>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button type="submit"
                                                            class="btn btn-primary" name="update">Actualizar</button>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </form>
                            </div>
                        </div>

                        <?php
                            } else{ 

                                
                        
                            } 
                        
                        }
                        ?>
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

        <!-- Add Department-->
        <div class="modal fade" id="depadd" tabindex="-1"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> Loan Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1111" class="form-label">Employee Name</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1111">
                    </div>
                    <div class="deadline-form">
                        <form>
                            <div class="row g-3 mb-3">
                              <div class="col-sm-6">
                                <label for="depone" class="form-label">Loan Amount</label>
                                <input type="text" class="form-control" id="depone">
                              </div>
                              <div class="col-sm-6">
                                <label for="deptwo" class="form-label">Date</label>
                                <input type="date" class="form-control" id="deptwo">
                              </div>
                              <div class="col-sm-12">
                                <label for="deponep" class="form-label">Loan Purpose </label>
                                <input type="text" class="form-control" id="deponep">
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
            </div>
        </div>

        <!-- Edit Loan-->
        <div class="modal fade" id="depedit" tabindex="-1"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depeditLabel"> Loan Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput11111" class="form-label">Employee Name</label>
                        <input type="text" class="form-control" id="exampleFormControlInput11111" value="Joan Dyer"> 
                    </div>
                    <div class="deadline-form">
                        <form>
                            <div class="row g-3 mb-3">
                              <div class="col-sm-6">
                                <label class="form-label">Loan Amount</label>
                                <input type="text" class="form-control" id="exampleFormControlInput111111" value="$4000">
                              </div>
                              <div class="col-sm-6">
                                <label for="deptwo48" class="form-label">Date</label>
                                <input type="date" class="form-control" id="deptwo48" value="2022-01-14">
                              </div>
                              <div class="col-sm-12">
                                <label for="deponepp" class="form-label">Loan Purpose </label>
                                <input type="text" class="form-control" id="deponepp" value="for weddings and family functions">
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                    <button type="submit" class="btn btn-primary">Save</button>
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

<!-- Mirrored from pixelwibes.com/template/my-task/html/dist/loan.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 31 Oct 2023 07:52:47 GMT -->
</html>