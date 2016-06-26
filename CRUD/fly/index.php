<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 15:41
 */
include ('../base/head.php');
include ('../base/nav.php');
?>
<div class="container">
    <div class="row">
        <h3>PHP CRUD Grid</h3>
    </div>
    <div class="row">
        <p>
            <a href="create.php" class="btn btn-success">Create</a>
        </p>

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Flytype id</th>
                <th>kode</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include '../base/db-connection.php';
            $pdo = Database::connect();
            $sql = 'SELECT * FROM fly ORDER BY id DESC';
            foreach ($pdo->query($sql) as $row) {
                echo '<tr>';
                echo '<td>'. $row['flytype_id'] . '</td>';
                echo '<td>'. $row['kode'] . '</td>';
                echo '<td width=250>';
                echo '<a class="btn" href="read.php?id='.$row['id'].'">Read</a>';
                echo '&nbsp;';
                echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
                echo '&nbsp;';
                echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
            Database::disconnect();
            ?>
            </tbody>
        </table>
        <a class="btn" href="../index.php">Back</a>
    </div>
</div> <!-- /container -->
<?php
include ('../base/footer.php');
?>