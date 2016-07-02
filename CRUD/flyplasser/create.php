<?php

/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 17:39
 * TODO: trenger JavaScript validering
 * TODO: Her må jeg bytte ut rowCount med COUNT(*) og fetchcolumn
 */
include ('../base/head.php');
include ('../base/nav.php');
require '../base/db-connection.php';
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
    // TODO: Her må jeg sette inn en check for og se om navn ikke er i bruk, om det er tilfellet vil den få $valid = false; erstatte nåværende løsning
//    if ($navn) {
//        $sql = 'SELECT COUNT(*) FROM flyplasser WHERE navn = ? LIMIT 1';
//        $stmt = $pdo->prepare($sql);
//        $stmt->bindParam(1, $_GET['navn'], PDO::PARAM_STR);
//        $stmt->execute();
////        $res = $DB->query('SELECT COUNT(*) FROM table');
////        $num_rows = $res->fetchColumn();
//        if ($stmt->fetchColumn()){
//            $valid = false;
////            die('found');
//        }
    
    else {
        $pdo = Database::connect();
        $count= $pdo->prepare('SELECT model FROM flytyper WHERE model=:model');
        $count ->bindParam(":model",$model);
        $count->execute();
        $no=$count->rowCount();
        if ($no > 0){
            $valid =false;
        }
        else{
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO flytyper(model,navn,seter) VALUES(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($model, $navn, $seter));
            Database::disconnect();
            header("Location:index.php");
        }
    }
}
?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>Lag en ny flytype</h3>

                <form class="form-horizontal" action="create.php" method="post">
                    <div class="form-group <?php echo !empty($modelError)?'error':'';?>">
                        <label for="model">Model:</label>
                        <input class="form-control" name="model" id="model" type="text"  placeholder="Model" value="<?php echo !empty($model)?$model:'';?>">
                        <?php if (!empty($modelError)): ?>
                            <span class="help-inline"><?php echo $modelError;?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group <?php echo !empty($navnError)?'error':'';?>">
                        <label for="name">Navn:</label>
                        <input class="form-control" name="navn" id="name" type="text" placeholder="Navn" value="<?php echo !empty($navn)?$navn:'';?>">
                        <?php if (!empty($navnError)): ?>
                            <span class="help-inline"><?php echo $navnError;?></span>
                        <?php endif;?>
                    </div>
                    <div class="form-group <?php echo !empty($seterError)?'error':'';?>">
                        <label for="seter">Maks antallseter:</label>
                        <input class="form-control" name="seter" id="seter" type="text"  placeholder="Antallseter" value="<?php echo !empty($seter)?$seter:'';?>">
                        <?php if (!empty($seterError)): ?>
                            <span class="help-inline"><?php echo $seterError;?></span>
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