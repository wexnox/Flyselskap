<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 15:36
 */
// TODO: dropdown av flytype_id
include ('../base/head.php');
include ('../base/nav.php');
require '../base/db-connection.php';

if ( !empty($_POST)) {
    // keep track validation errors
    $flytype_idError = null;
    $kodelError = null;

    // keep track post values
    $flytype_id = $_POST['flytype_id'];
    $kode = $_POST['kode'];

    // validate input
    $valid = true;
    if (empty($flytype_id)) {
        $flytype_idError = 'Please enter flytype id';
        $valid = false;
    }

    if (empty($kode)) {
        $kode = 'Please enter flytype kode';
        $valid = false;
    }

    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO fly (flytype_id,kode) values(?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($flytype_id,$kode));
        Database::disconnect();
        header("Location: index.php");
    }
}
?>
    <div class="container">
        <div class="span10 offset1">
            <div class="row">
                <h3>Create a Fly</h3>
            </div>
            <form class="form-horizontal" action="create.php" method="post">
                <div class="control-group <?php echo !empty($flytype_idError)?'error':'';?>">
                    <label class="control-label">Flytype_id</label>
                    <div class="controls">
                        <input name="name" type="text"  placeholder="Flytype ID" value="<?php echo !empty($flytype_id)?$flytype_id:'';?>">
                        <?php if (!empty($flytype_idError)): ?>
                            <span class="help-inline"><?php echo $flytype_idError;?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="control-group <?php echo !empty($kodelError)?'error':'';?>">
                    <label class="control-label">Fly kode</label>
                    <div class="controls">
                        <input name="email" type="text" placeholder="Flytypekode" value="<?php echo !empty($kodelError)?$kodelError:'';?>">
                        <?php if (!empty($kodelError)): ?>
                            <span class="help-inline"><?php echo $kodelError;?></span>
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
<?php
include ('../base/footer.php');
?>