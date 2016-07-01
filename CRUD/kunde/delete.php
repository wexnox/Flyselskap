<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 17:40
 * TODO: trenger JavaScript
 */

?>
<?php
include ('../base/head.php');
include ('../base/nav.php');
require '../base/db-connection.php';
$id = 0;

if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( !empty($_POST)) {
    // keep track post values
    $id = $_POST['id'];

    // slett data
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM flytyper  WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    Database::disconnect();
    header("Location: index.php");

}
?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h3>Slett en flytype</h3>
                <form class="form-horizontal" action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <p class="alert alert-error">Are you sure to delete ?</p>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-danger">Yes</button>
                        <a class="btn btn-default" href="index.php">No</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
include ('../base/footer.php');
?>