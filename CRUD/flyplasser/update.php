<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 17:39
 * TODO: trenger JavaScript validering
 */
?>
<?php
require '../base/db-connection.php';
include ('../base/head.php');
include ('../base/nav.php');
$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}
if ( null==$id ) {
    header("Location: index.php");
}
if ( !empty($_POST)) {
    $kodeError = null;
    $navnError = null;

    $kode = $_POST['kode'];
    $navn = $_POST['navn'];
    $land_id = $_POST['id'];
    $valid = true;

    if (empty($kode)) {
        $kodeError = 'Fyll ut Model';
        $valid = false;
    }
    if (empty($navn)) {
        $navnError = 'Fyll ut Navn';
        $valid = false;
    }
    if (!empty($kode)){  // denne her skal videreføres
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
        } else {
            if ($valid) {
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE flyplasser  SET kode = ?, navn = ?, id =? WHERE id = ?";
                $q = $pdo->prepare($sql);
                $q->execute(array($kode, $navn, $land_id, $id));
                Database::disconnect();
                header("Location: index.php");
            }
        }
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM flyplasser WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $kode = $data['kode'];
    $navn = $data['navn'];
    $land_id = $data['id'];
    Database::disconnect();
}
include ("listebox-land.php");
?>
    <div class="container">
        <div class="row">
            <h3>Update a Flytype</h3>
            <div class="col-lg-4">
                <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
                    <div class="form-group <?php echo !empty($kodeError)?'error':'';?>">
                        <label for="kode">Flyplass kode:</label>
                        <input class="form-control" id="kode" name="kode" type="text"  placeholder="Fyll ut flyplass kode" value="<?php echo !empty($kode)?$kode:'';?>">
                        <?php if (!empty($kodeError)): ?>
                            <span class="help-inline"><?php echo $kodeError;?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group <?php echo !empty($navnError)?'error':'';?>">
                        <label for="navn">Navn:</label>
                        <input class="form-control" id="navn" name="navn" type="text" placeholder="Fyll ut navn på flyplassen" value="<?php echo !empty($navn)?$navn:'';?>">
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
                    <button class="btn btn-success" type="submit" >Update</button>
                    <a class="btn btn-default" href="index.php">Back</a>
                </form>
            </div>
        </div>
    </div>
<?php
include ('../base/footer.php');
?>