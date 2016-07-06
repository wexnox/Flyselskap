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
include ('../base/head.php');
include ('../base/nav.php');
require '../base/db-connection.php';
$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: index.php");
}

if ( !empty($_POST)) {
    $flytype_idError = null;
    $kodeError = null;

    $flytype_id = $_POST['flytype_id'];
    $kode = $_POST['kode'];
    
    $valid = true;

    if (empty($flytype_id)) {
        $flytype_idError = 'Fyll ut Flytype ID';
        $valid = false;
    }

    if (empty($kode)) {
        $kodeError = 'Fyll ut Fly Kode';
        $valid = false;
    }
    if (!empty($kode)){  // denne her skal videreføres
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $pdo->prepare("SELECT COUNT(*) AS `total` FROM fly WHERE kode = :kode");
        $sql->execute(array(':kode' => $kode));
        $result = $sql->fetchObject();
        if ($result->total > 0)
        {
            echo '<div class="container">';
            echo '<div class="alert alert-danger">';
            echo '<p class="lead">Fly kode: <strong>' . $kode. '</strong> er allerede i bruk.<p>';
            echo '</div></div>';
        }
        else  {
            if ($valid) {
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE fly  SET kode = ?, flytype_id = ? WHERE id = ?";
                $q = $pdo->prepare($sql);
                $q->execute(array($kode, $flytype_id, $id));
                Database::disconnect();
                header("Location: index.php");
            }
        }
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM fly WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $kode = $data['kode'];
    $flytype_id = $data['flytype_id'];
    Database::disconnect();
}
include ('listeboks-flytype.php');
?>

    <div class="container">
        <div class="row">
            <h3>Update a Flytype</h3>
            <div class="col-lg-4">
                <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
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
                        <input class="form-control" id="kode" name="kode" type="text" placeholder="Fyll ut Navn" value="<?php echo !empty($kode)?$kode:'';?>">
                        <?php if (!empty($kodeError)): ?>
                            <span class="help-inline"><?php echo $kodeError;?></span>
                        <?php endif;?>
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