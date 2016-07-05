<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 05/07/2016
 * Time: 03:24
 */
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT * FROM land' ;
$q = $pdo->prepare($sql);
$q->execute();
$land = $q->fetchAll();
Database::disconnect();