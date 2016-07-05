<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 26/06/2016
 * Time: 17:40
 */
include ('../base/head.php');
include ('../base/nav.php');
?>
    <div class="container">
        <div class="row">
            <h3>Fly CRUD</h3>
        </div>
        <div class="row">
            <p>
                <a href="create.php" class="btn btn-success">Create</a>
            </p>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Flytype ID</th>
                    <th>Kode</th>
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
                    echo '<a class="btn btn-default" href="read.php?id='.$row['id'].'">Read</a>';
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
        </div>
    </div>
<?php
include ('../base/footer.php');
?>