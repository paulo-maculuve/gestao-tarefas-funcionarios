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
    $avatar = time() . '.' . $_FILES['avatar']['extension'];
    move_uploaded_file($_FILES['avatar']['tmp_name'], 'upload/' . $avatar);

    $nomeLider = $_POST['nomeLider'];

    $nomeDepartamento = $_POST['nomeDepartamento'];

    $numFuncionario = $_POST['numFuncionario'];

    $sql = "UPDATE `departamento` SET `avatar`='$avatar',`nome_lider`='$nomeLider',`nome_departamento`='$nomeDepartamento',`numero_funcionario`='$numFuncionario' WHERE `id`='$id'"; 

    $result = $conn->query($sql); 

    if ($result == TRUE) {

        header('Location: department.php');
        exit();

    }else{

        echo "Error:" . $sql . "<br>" . $conn->error;

    }

} 
if (isset($_GET['id'])) {

    $dep_id = $_GET['id']; 

    $sql = "SELECT * FROM `departamento` WHERE `id`='$dep_id'";
    
    $result = $conn->query($sql); 

    

    if ($result->num_rows > 0) {        

        while ($row = $result->fetch_assoc()) {

            $avatar = $row['avatar'];

            $nomeLider = $row['nome_lider'];

            $nomeDepartamento = $row['nome_departamento'];

            $numFuncionario  = $row['numero_funcionario'];

            $id = $row['id'];
        } 

?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gestão das Tarefas de Funcionarios - Departments</title>
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
                            <h3 class="fw-bold mb-0">Editar departamento</h3>
                            
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
                                                        <label for="avatar" class="form-label">Avatar do lider</label>
                                                        <input type="file" class="form-control" id="avatar" name="avatar" required value="<?php echo $avatar; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nome" class="form-label">Nome do lider</label>
                                                        <input type="text" class="form-control" id="nomeLider" name="nomeLider" required value="<?php echo $nomeLider; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nomeDepartamento" class="form-label">Nome do Departamento</label>
                                                        <input type="text" class="form-control" id="nomeDepartamento" name="nomeDepartamento" required value="<?php echo $nomeDepartamento; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="numFuncionario" class="form-label">Número de Funcionarios</label>
                                                        <input type="number" class="form-control" id="depone" name="numFuncionario" required value="<?php echo $numFuncionario; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <button type="submit"
                                                            class="btn btn-primary" name="update">Adicionar</button>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </form>
                            </div>
                        </div>
                  </div>
                </div><!-- Row End -->
            </div>
        </div>
        
       <?php
        } else{ 

            
    
        } 
    
    }
       ?>
      
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