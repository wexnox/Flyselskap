<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 17:39
 * TODO: trenger JavaScript validering
 * TODO: Her må jeg bytte ut rowCount med COUNT(*) og fetchcolumn
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
    $modelError = null;
    $navnError = null;
    $seterError = null;

    $model = $_POST['model'];
    $navn = $_POST['navn'];
    $seter = $_POST['seter'];
    $valid = true;
    if (empty($model)) {
        $modelError = 'Fyll ut Model';
        $valid = false;
    }

    if (empty($navn)) {
        $navnError = 'Fyll ut Navn';
        $valid = false;
    }

    if (empty($seter)) {
        $seterError = 'Fyll ut Max antallseter';
        $valid = false;
    }
    if (!empty($model)){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT COUNT(*)FROM flytyper WHERE model=? LIMIT 1';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $_GET['model'], PDO::PARAM_STR);
        $stmt ->execute();
        if($stmt->fetchColumn())
//            die ('found');
        $valid=false;
    }
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE flytyper  SET model = ?, navn = ?, seter =? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($model, $navn, $seter, $id));
        Database::disconnect();
        header("Location: index.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM flytyper WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $model = $data['model'];
    $navn = $data['navn'];
    $seter = $data['seter'];
    Database::disconnect();
}
?>
    <div class="container">
        <div class="row">
            <h3>Update a Flytype</h3>
            <div class="col-lg-4">
                <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
                    <div class="form-group <?php echo !empty($modelError)?'error':'';?>">
                        <label for="model">Model:</label>
                        <input class="form-control" id="model" name="model" type="text"  placeholder="Fyll ut model" value="<?php echo !empty($model)?$model:'';?>">
                        <?php if (!empty($modelError)): ?>
                            <span class="help-inline"><?php echo $modelError;?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group <?php echo !empty($navnError)?'error':'';?>">
                        <label for="navn">Navn:</label>
                        <input class="form-control" id="navn" name="navn" type="text" placeholder="Fyll ut Navn" value="<?php echo !empty($navn)?$navn:'';?>">
                        <?php if (!empty($navnError)): ?>
                            <span class="help-inline"><?php echo $navnError;?></span>
                        <?php endif;?>
                    </div>
                    <div class="form-group <?php echo !empty($seterError)?'error':'';?>">
                        <label for="seter">Antallseter</label>
                        <input class="form-control" id="seter" name="seter" type="text"  placeholder="Fyll ut max antallseter" value="<?php echo !empty($seter)?$seter:'';?>">
                        <?php if (!empty($seterError)): ?>
                            <span class="help-inline"><?php echo $seterError;?></span>
                        <?php endif;?>
                    </div>
                    <button class="btn btn-success" type="submit" >Update</button>
                    <button class="btn btn-danger" type="reset">Reset</button>
                    <a class="btn btn-default" href="index.php">Back</a>
                </form>
            </div>
        </div>
    </div>
<?php
include ('../base/footer.php');
?>