<?php

/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 17:39
 * TODO: trenger JavaScript validering
 * TODO: Her må jeg bytte ut rowCount med COUNT(*) og fetchcolumn
 * TODO: Her må jeg sette inn en check for og se om navn ikke er i bruk, om det er tilfellet vil den få $valid = false; erstatte nåværende løsning
 */
include ('../base/head.php');
include ('../base/nav.php');
require '../base/db-connection.php';
if ( !empty($_POST)) {
    $kodeError = null;
    $navnError = null;

    $kode = $_POST['kode'];
    $navn = $_POST['fpnavn'];
    $land_id = $_POST['land_id'];

    $valid = true;
    
    if (empty($kode)) {
        $kodeError = 'Fyll ut Kode';
        $valid = false;
    }
    if (empty($navn)) {
        $navnError = 'Fyll ut Navn';
        $valid = false;
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $pdo->prepare("SELECT COUNT(*) AS `total` FROM flyplasser WHERE kode = :kode");
        $sql->execute(array(':kode' => $kode));
        $result = $sql->fetchObject();
        if ($result->total > 0)
        {
            echo '<div class="container">';
            echo '<div class="alert alert-danger">';
            echo '<p class="lead">Flyplassen: <strong>' . $kode. '</strong> er allerede i bruk.<p>';
            echo '</div></div>';
        }
        else{
            if ($valid) {
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO flyplasser(land_id, kode,navn) VALUES(?, ?, ?)";
                $q = $pdo->prepare($sql);
                $q->execute(array($land_id, $kode, $navn ));
                Database::disconnect();
                header("Location:index.php");
            }
        }
    }
}
include ("listebox-land.php");
?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>Lag en ny flyplass</h3>
                <form class="form-horizontal" action="create.php" method="post">
                    <div class="form-group <?php echo !empty($kodeError)?'error':'';?>">
                        <label for="kode">Flyplass kode:</label>
                        <input class="form-control" name="kode" id="kode" type="text"  placeholder="Fyll ut flyplass kode" value="<?php echo !empty($kode)?$kode:'';?>">
                        <?php if (!empty($kodeError)): ?>
                            <span class="help-inline"><?php echo $modelError;?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group <?php echo !empty($navnError)?'error':'';?>">
                        <label for="fpname">Navn:</label>
                        <input class="form-control" name="fpnavn" id="fpname" type="text" placeholder="Fyll ut navn på flyplassen" value="<?php echo !empty($navn)?$navn:'';?>">
                        <?php if (!empty($navnError)): ?>
                            <span class="help-inline"><?php echo $navnError;?></span>
                        <?php endif;?>
                    </div>
                    <div class="form-group">
                        <label for="land_id">Tilhørende Land:</label>
                            <select class="form-control" name="land_id" id="land_id">
                                <?php foreach ($land as $row): ?>
                                    <option><?=$row["navn"]?></option>
                                <?php endforeach ?>
                            </select>
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