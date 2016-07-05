<?php

/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 17:39
 * TODO: trenger JavaScript validering
 * TODO: Her må jeg bytte ut rowCount med COUNT(*) og fetchcolumn se flytype\update.php
 */
include ('../base/head.php');
include ('../base/nav.php');
require '../base/db-connection.php';
if ( !empty($_POST)) {
    $flytype_idError = null;
    $kodeError = null;

    $flytype_id = $_POST['flytype_id'];
    $kode = $_POST['kode'];


    $valid = true;
    if (empty($flytype_id)) {
        $flytype_idError = 'Fyll ut flytype';
        $valid = false;
    }
    if (empty($kode)) {
        $kodeError = 'Fyll ut flykode';
        $valid = false;
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $pdo->prepare("SELECT COUNT(*) AS `total` FROM fly WHERE kode = :kode");
        $sql->execute(array(':kode' => $kode));
        $result = $sql->fetchObject();
        if ($result->total > 0)
        {
            echo '<div class="container">';
            echo '<div class="alert alert-danger">';
            echo '<p class="lead">Fly: <strong>' . $kode. '</strong> er allerede i bruk.<p>';
            echo '</div></div>';
        }
        else{
            if ($valid) {
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO fly(flytype_id, kode) VALUES(?, ?)";
                $q = $pdo->prepare($sql);
                $q->execute(array($flytype_id, $kode));
                Database::disconnect();
                header("Location:index.php");
            }
        }
    }
}
include ('listeboks-flytype.php');
?>
    <div class="container">
        <h3>Lag en ny flytype</h3>
        <div class="row">
            <div class="col-md-4">
                <form class="form-horizontal" role="form" action="create.php" method="post">
                    <div class="form-group <?php echo !empty($flytype_idError)?'error':'';?>">
                        <label for="flytype_id">Flytype ID:</label>
                        <select class="form-control" name="flytype_id" id="flytype_id">
                            <?php foreach ($flytype as $row): ?>
                                <option><?=$row["id"].$row["model"].$row["navn"]?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group <?php echo !empty($kodeError)?'error':'';?>">
                        <label for="kode">Fly Kode</label>
                        <input class="form-control" name="kode" id="kode" type="text" placeholder="Fyll ut flykode" value="<?php echo !empty($kode)?$kode:'';?>">
                        <?php if (!empty($kodeError)): ?>
                            <span class="help-inline"><?php echo $kodeError;?></span>
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