<?php

/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 17:39
 * TODO: trenger JavaScript validering
 * TODO: Her må jeg bytte ut rowCount med COUNT(*) og fetchcolumn
 * TODO: on create msg
 */
include ('../base/head.php');
include ('../base/nav.php');
require '../base/db-connection.php';
if ( !empty($_POST)) {
    $navnError = null;

    $navn = $_POST['navn'];

    $valid = true;

    if (empty($navn)) {
        $navnError= 'Fyll ut navnet på landet';
        $valid = false;
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $pdo->prepare("SELECT COUNT(*) AS `total` FROM land WHERE navn = :navn");
        $sql->execute(array(':navn' => $navn));
        $result = $sql->fetchObject();
        if ($result->total > 0)
        {
            echo '<div class="container">';
            echo '<div class="alert alert-danger">';
            echo '<p class="lead">Land: <strong>' . $navn. '</strong> er allerede i bruk.<p>';
            echo '</div></div>';
        }
        else{
            if ($valid) {
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO land(navn) VALUES(?)";
                $q = $pdo->prepare($sql);
                $q->execute(array($navn));
                Database::disconnect();
//                header("Location:index.php");
            }
        }
    }
}
?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>Legg til et nytt land</h3>
                <form class="form-horizontal" action="create.php" method="post">
                    <div class="form-group <?php echo !empty($navnError)?'error':'';?>">
                        <label for="navn">Landnavn:</label>
                        <input class="form-control" name="navn" id="navn" type="text"  placeholder="Fyll ut navnet på landet" value="<?php echo !empty($navn)?$navn:'';?>">
                        <?php if (!empty($navnError)): ?>
                            <span class="help-inline"><?php echo $navnError;?></span>
                        <?php endif;?>
                    </div>
                    <button type="submit" class="btn btn-success">Create</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <a class="btn btn-default" href="index.php">Back</a>
                </form>
            </div>
        </div>
    </div>
<?php
include ('../base/footer.php');
?>