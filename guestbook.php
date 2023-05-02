<?php
session_start();

$aConfig = require_once 'config.php';

if (isset($_POST)){
    $db = mysqli_connect(
        $aConfig['host'],
        $aConfig['user'],
        $aConfig['pass'],
        $aConfig['name']
    );
    $query = "INSERT INTO comments (name, email, comment, dignity, limitations) VALUES (
    '". $_POST['name']."',
    '". $_POST['email']."',
    '". $_POST['comment']."',
    '". $_POST['dignity']."',
    '". $_POST['limitations']."'
    )";

    mysqli_query($db, $query);
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html>

<?php require_once 'sectionHead.php' ?>

<body>

<div class="container">
    <!-- navbar menu -->
    <?php require_once 'sectionNavbar.php' ?>
    <br>
    <!-- guestbook section -->
    <div class="card card-primary">
        <div class="card-header bg-primary text-light">
            GuestBook form
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <form method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input class="form-control" type="text" name="name"/>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email"/>
                        </div>
                        <div class="form-group">
                            <label>Comments</label>
                            <input class="form-control" type="text" name="comment"/>
                        </div>
                        <div class="form-group">
                            <label>Dignity</label>
                            <input class="form-control" type="text" name="dignity"/>
                        </div>
                        <div class="form-group">
                            <label>Limitations</label>
                            <input class="form-control" type="text" name="limitations"/>
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="form"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card card-primary">
        <div class="card-header bg-body-secondary text-dark">
            Сomments
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    $db = mysqli_connect(
                        $aConfig['host'],
                        $aConfig['user'],
                        $aConfig['pass'],
                        $aConfig['name']
                    );

                    $query = 'SELECT * FROM comments';
                    $dbResponse = mysqli_query($db, $query);
                    $aComments = mysqli_fetch_all($dbResponse, MYSQLI_ASSOC);
                    mysqli_close($db);

                    foreach($aComments as $comment) {
                        echo $comment ['name'] . '<br>';
                        echo $comment ['email'] . '<br>';
                        echo $comment ['comment'] . '<br>';
                        echo "Достоинства";
                        echo '<br>' . $comment ['dignity'] . '<br>';
                        echo "Недостатки";
                        echo '<br>' . $comment ['limitations'] . '<br><hr>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
