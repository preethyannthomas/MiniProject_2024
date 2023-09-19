<?php require_once('auth.php') ?>
<?php 
if(isset($_GET['logout'])){
    session_destroy();
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient">
        <div class="container">
            <a class="navbar-brand" href="./">Google OAuth Integration in PHP</a>
            <div>
                <a href="https://sourcecodester.com" class="text-light fw-bolder h6 text-decoration-none" target="_blank">SourceCodester</a>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-5 col-md-7 col-sm-12 mx-auto">
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="container-fluid">
                            <h2>You are Logged In</h2>
                            <hr>
                            <div class="text-center">
                                <img src="<?= $_SESSION['login_picture'] ?>" alt="" class="img-thumb-nail rounded-circle">
                            </div>
                            <dl>
                                <dt>Name</dt>
                                <dd class="ps-4"><?= ucwords($_SESSION['login_givenName'] . " " .$_SESSION['login_familyName']) ?></dd>
                                <dt>Email</dt>
                                <dd class="ps-4"><?= $_SESSION['login_email']  ?></dd>
                            </dl>
                            <hr>
                            <div class="text-center">
                                <a href="./?logout" class="btn btn btn-danger btn-sm rounded-0">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>