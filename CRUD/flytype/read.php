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
$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( null==$id ) {
    header("Location: index.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM flytyper where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}

?>
    <div class="container">
        <div class="span10 offset1">
            <div class="row">
                <h3>Read a flytype</h3>
            </div>
            <div class="form-horizontal" >
                <div class="control-group">
                    <label class="control-label">Model</label>
                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['model'];?>
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Navn</label>
                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['navn'];?>
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">seter</label>
                    <div class="controls">
                        <label class="checkbox">
                            <?php echo $data['seter'];?>
                        </label>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn" href="index.php">Back</a>
                </div>
            </div>
        </div>
    </div> <!-- /container -->

<?php
include ('../base/footer.php');
?>