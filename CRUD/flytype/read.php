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
        <div class="row">
            <h3>Read a flytype</h3>
            <form class="form" role="form">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label>Registrert Model:</label>
                        <?php echo $data['model'];?>
                    </div>
                    <div class="form-group">
                        <label>Registrert Navn:</label>
                        <?php echo $data['navn'];?>
                    </div>
                    <div class="form-group">
                        <label>Registrert antallseter:</label>
                        <?php echo $data['seter'];?>
                    </div>
                        <a class="btn btn-default" href="index.php">Back</a>
                </div>
            </form>
        </div>
    </div>

<?php
include ('../base/footer.php');
?>