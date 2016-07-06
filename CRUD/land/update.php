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
    $navnError = null;
    $navn = $_POST['navn'];
    $valid = true;

    if (empty($navn)) {
        $navnError = 'Fyll ut Navn';
        $valid = false;
    }
    if (!empty($navn)){  // denne her skal videreføres
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = $pdo->prepare("SELECT COUNT(*) AS `total` FROM land WHERE navn = :navn");
        $sql->execute(array(':navn' => $navn));
        $result = $sql->fetchObject();
        if ($result->total > 0)
        {
            echo '<div class="container">';
            echo '<div class="alert alert-danger">';
            echo '<p class="lead">Landet: <strong>' . $navn. '</strong> er allerede i bruk.<p>';
            echo '</div></div>';
        } else {
            if ($valid) {
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE land  SET navn = ? WHERE id = ?";
                $q = $pdo->prepare($sql);
                $q->execute(array($navn, $id));
                Database::disconnect();
                header("Location: index.php");
            }
        }
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM land WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $navn = $data['navn'];
    Database::disconnect();
}
?>
    <div class="container">
        <div class="row">
            <h3>Update navnet på land</h3>
            <div class="col-lg-4">
                <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
                    <div class="form-group <?php echo !empty($navnError)?'error':'';?>">
                        <label for="navn">Landnavn:</label>
                        <input class="form-control" id="navn" name="navn" type="text"  placeholder="Fyll navnet på landet" value="<?php echo !empty($navn)?$navn:'';?>">
                        <?php if (!empty($navnError)): ?>
                            <span class="help-inline"><?php echo $navnError;?></span>
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