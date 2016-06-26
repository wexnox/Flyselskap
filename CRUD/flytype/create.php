<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 17:39
 */
include ('../base/head.php');
include ('../base/nav.php');
require '../base/db-connection.php';
if ( !empty($_POST)) {
    // keep track validation errors
    $modelError = null;
    $navnError  = null;
    $seterError = null;

    // keep track post values
    $model  = $_POST['model'];
    $navn   = $_POST['navn'];
    $seter  = $_POST['seter'];

    // validate input
    $valid  = true;
    if (empty($model)) {
        $modelError = 'Please enter Model';
        $valid  = false;
    }

    if (empty($navn)) {
        $navnError  = 'Please enter Navn';
        $valid  = false;
    }
    if (empty($seter)) {
        $seterError = 'Please enter Max antallseter';
        $valid  = false;
    }

    //Check if record exists
    if (isset($_POST['submit']))
    {
        try {
            $stmt = $pdo->prepare('SELECT model FROM flytyper WHERE model = ?');
            $stmt -> bindParam(1, $_POST['model']);
            $stmt -> execute();
            while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {

            }
        }
        catch (PDOException $e){
            echo 'ERROR ' . $e->getMessage();
        }
        if ($stmt->rowCount() > 0){
            echo "the record exists!";
        }else {
            echo "The record is non-existant.";
        }
    }
    // <-duplicat end
    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO flytyper(model,navn,seter) values(?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($model,$navn,$seter));
        Database::disconnect();
        header("Location:index.php");
    }
}

?>
<div class="container">
    <div class="span10 offset1">
        <div class="row">
            <h3>Create a Customer</h3>
        </div>

        <form class="form-horizontal" action="create.php" method="post">
            <div class="control-group <?php echo !empty($modelError)?'error':'';?>">
                <label class="control-label">Model</label>
                <div class="controls">
                    <input name="model" type="text"  placeholder="Model" value="<?php echo !empty($model)?$model:'';?>">
                    <?php if (!empty($modelError)): ?>
                        <span class="help-inline"><?php echo $modelError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($navnError)?'error':'';?>">
                <label class="control-label">Navn</label>
                <div class="controls">
                    <input name="navn" type="text" placeholder="Navn" value="<?php echo !empty($navn)?$navn:'';?>">
                    <?php if (!empty($navnError)): ?>
                        <span class="help-inline"><?php echo $navnError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($seterError)?'error':'';?>">
                <label class="control-label">Maks antallseter</label>
                <div class="controls">
                    <input name="seter" type="text"  placeholder="Antallseter" value="<?php echo !empty($seter)?$seter:'';?>">
                    <?php if (!empty($seterError)): ?>
                        <span class="help-inline"><?php echo $seterError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Create</button>
                <a class="btn" href="index.php">Back</a>
            </div>
        </form>
    </div>

</div> <!-- /container -->

