<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 06/07/2016
 * Time: 00:03
 */
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM flytyper' ;
$q = $pdo->prepare($sql);
$q->execute();
$flytype = $q->fetchAll();
Database::disconnect();