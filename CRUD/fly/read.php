<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 17:39
 * TODO: har lyst på mer informasjon per fly
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
    $sql = "SELECT * FROM fly where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}

?>
    <div class="container">
        <div class="row">
            <h3>Fnformasjon om flyet</h3>
            <form class="form" role="form">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label>Registrert Flytype ID:</label>
                        <?php echo $data['flytype_id'];?>
                    </div>
                    <div class="form-group">
                        <label>Registrert Kode:</label>
                        <?php echo $data['kode'];?>
                    </div>
                    <a class="btn btn-default" href="index.php">Back</a>
                </div>
            </form>
        </div>
    </div>

<?php
include ('../base/footer.php');
?>