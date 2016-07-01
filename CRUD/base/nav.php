<?php
/**
 * Created by PhpStorm.
 * User: wexnox
 * Date: 08/06/2016
 * Time: 17:12
 *
 * <li><a href="#">Reise</a></li>
 * <li><a href="#">Flyrute</a></li>
 * <li><a href="#">Flybilettbestilling</a></li>
 * <li><a href="#">Prisliste</a></li>
 *
 *
 *
 */
?>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../index.php">Home</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Fly<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="fly/index.php">Fly</a></li>
                            <li><a href="flytype/index.php">Flytype</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="land/index.php">Land</a></li>
                            <li><a href="flyplasser/index.php">Flyplass</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kunde<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="kunde/index.php">Kunde</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">User Account<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="admin/index.php">Edit User Settings</a></li>
                            <li><a href="admin/chpass.php">Change password</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#admin/logout.php">logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>