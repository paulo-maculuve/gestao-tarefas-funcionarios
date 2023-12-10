<?php
session_start();

if(!isset($_SESSION['valid'])) {
    header('Location: auth-signin.php');
}
include "conf.php";

$sql = "SELECT * FROM funcionario";

$result = $conn->query($sql);

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
                            <h3 class="fw-bold mb-0">Funcionario</h3>
                            
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
                                            <th>Funcionario ID</th>
                                            <th>Funcionario Nome</th> 
                                            <th>Telefone</th> 
                                            <th>Cargo do funcionario</th>   
                                            <th>Departamento</th>  
                                            <th>Action</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {

                                            while ($row = $result->fetch_assoc()) {

                                        ?>
                                        <tr>
                                            <td>
                                                <span class="fw-bold"><?php echo $row['id']; ?></span>
                                            </td>
                                           <td class="d-flex align-items-center"> <?php
                                           echo '<img class="avatar rounded-circle" src="upload/'. $row['avatar'] . '" alt="">'?>
                                               <div>
                                                <span class="fw-bold ms-1"><?php echo $row['nome']; ?></span>
                                               </div>
                                           </td>
                                           <td>
                                                <?php echo $row['telefone']; ?>
                                           </td>
                                           <td>
                                                <?php echo $row['cargo']; ?>
                                           </td>
                                           <td>
                                                <?php echo $row['departamento']; ?>
                                           </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                    <a href="employee-edit.php?id=<?php echo $row['id'];?>" class="btn btn-outline-secondary" ><i class="icofont-edit text-success"></i></a>
                                                    <a href="employee-delete.php?id=<?php echo $row['id'];?>" class="btn btn-outline-secondary"><i class="icofont-ui-delete text-danger"></i></a>
                                                </div>
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