<?php
session_start();
//var_dump($_POST);
$error = "กรุณากรอกข้อมูล";
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if($username === 'admin' && $password === 'admin') {
        $_SESSION['admin'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "คุณไม่ใช่แอดมินตัวจริง";
    }
}
include  "../Admin/Libary.html";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

</head>
<body>
<div class="container-md" style="max-width: 400px;">
    <div class="d-flex flex-column bg-light p-4 mt-5 rounded-3 border border-dark">
        <h1 class="text-center mb-4">Login</h1>
        <?php if(isset($error)) { ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <div class="form">
            <form action="" method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
