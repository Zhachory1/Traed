<?php
    session_start();
    if (isset($_SESSION['login']) && ($_SESSION['login'] == 1) && (isset($_SESSION['uid']))) {
    }
    else {
        header('Location: index.php');
    }
?>
<!doctype html>
<html>
<head>
    <title>Traed Stocks</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/select2.min.css">
    <link rel="icon" href="media/favicon.ico">
    <script src="js/accounting.js"></script>
    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/highstock.js"></script>
    <script src="js/clock.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="js/main.js"></script>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-bottom">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img id="logo" src="media/traed_big_clearbg.png" /></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a data-toggle="modal" data-target="#set">Set Aggressiveness</a></li>
                <li><a id="logout" href="#">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div id="contain" class="container-fluid">
    <div class="row">
		<div class="col-md-3" id="left">
			<h1>
                Your Stocks 
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#add">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </h1>
            <div id="sl">
                <div id="listOfSL"></div>
			</div>
            <h1>Zhach Index</h1>
            <div id="per"></div>
		</div>
		<div class="col-md-9" id="graph"></div>
    </div>
</div>

<div id="welcome">
    <h6>Welcome, <?php echo $_SESSION['name'];?></h6>
    <h6 id="time"></h6>
</div>

<div id="add" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">Add stocks</h2>
                <p>Let's add some stocks!</p>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <form id="addStock">
                            <div class="alert alert-success" id="addSuc"></div>
                            <div class="alert alert-danger"  id="addErr"></div>
                            <div class="form-group">
                                <label for="sym">Stock Symbol to add:</label>
                                <input type="text" class="form-control" name="sym" id="sym">
                            </div>
                            <button type="submit" class="btn btn-success">Add</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="set" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">Set Aggressiveness</h2>
            </div>
            <div class="modal-body">
                <p>Let's do something with stocks!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>
