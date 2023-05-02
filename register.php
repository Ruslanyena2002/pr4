<?php

session_start();
$aConfig = require_once 'config.php';

if (!empty($_SESSION['auth'])) {
    header('Location: /admin.php');
    die;
}
$infoMessage = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $isAlreadyRegistered = false;

    $db = mysqli_connect(
        $aConfig['host'],
        $aConfig['user'],
        $aConfig['pass'],
        $aConfig['name']
    );
    $query = "SELECT * FROM users where email = '{$_POST['email']}'" ;
    $dbResponse = mysqli_query($db, $query);
    $aUser = mysqli_fetch_assoc($dbResponse);
    echo($query);
    mysqli_close($db);

    if (!empty($aUser)) {
        $isAlreadyRegistered = true;
        $infoMessage = "Такой пользователь уже существует! Перейдите на страницу входа. ";
        $infoMessage .= "<a href='/login.php'>Страница входа</a>";
    }

    if (!$isAlreadyRegistered) {
        $db = mysqli_connect(
            $aConfig['host'],
            $aConfig['user'],
            $aConfig['pass'],
            $aConfig['name']
        );
        $query = "INSERT INTO users (email, password) VALUES (
            '". $_POST['email']."',
            '". $_POST['password']."'
        )";
        mysqli_query($db, $query);
        mysqli_close($db);
        header('Location: /login.php');
        die;
    }

} elseif (!empty($_POST)) {
    $infoMessage = 'Заполните форму регистрации!';
}

?>


<!DOCTYPE html>
<html>

<?php require_once 'sectionHead.php' ?>

<body>

<div class="container">

    <?php require_once 'sectionNavbar.php' ?>

    <br>

    <div class="card card-primary">
        <div class="card-header bg-success text-light">
            Register form
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email"/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password"/>
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="formRegister"/>
                </div>
            </form>
            <?php
                if ($infoMessage) {
                    echo '<hr/>';
                    echo "<span style='color:red'>$infoMessage</span>";
                }
            ?>
        </div>

    </div>
</div>

</body>
</html>