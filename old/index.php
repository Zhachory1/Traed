<?php
    session_start();
    if (isset($_SESSION['login']) && ($_SESSION['login'] == 1) && (isset($_SESSION['uid']))) {
        header('Location: dashboard.php');
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
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link rel="icon" href="media/favicon.ico">
    </head>

    <body>

    <div id="contain" class="container-fluid">
        <div class="row">
    		<div id="login" class="col-md-offset-9 col-md-3">
                <form id="logForm">
                    <h2>Login</h2>
                    <div class="form-group"> 
                        <input type="email" id="email" name="email" placeholder="Email"></input>
                    </div>
                    <div class="form-group"> 
                        <input type="password" id="password" name="password" placeholder="Password"></input>
                    </div>
                    <button id="log" type="submit" class="btn btn-success">Login</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#registerModal">Register</button>
                </form>
                <div id="logErr" class="alert alert-danger" style="display:none;"></div>
            </div>
        </div>

        <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="registerModalLabel">Registration Form</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div id="error" style="display:none;" class="alert alert-danger"></div>
                            </div>
                            <div class="row">
                                <div id="succ" style="display:none;" class="alert alert-success"></div>
                            </div>
                            <div class="row">
                                <p class="text-center" id="modal-body" style="padding-bottom: 10px">Please fill out all fields to register.</p>
                                <form id="register-form" class="form-inline">
                                    
                                    <div class="input-group email-group col-md-12">
                                        <span class="input-group-addon" style="width: 150px">Name</span>
                                        <input type="text" name="fname" class="form-control form-required" id="fname" placeholder="John Smith" alt="Name"></input>
                                    </div><br/>                                
                                    
                                    <div class="input-group email-group col-md-12">
                                        <span class="input-group-addon" style="width: 150px">Email</span>
                                        <input type="email" name="email" class="form-control form-required" id="email" placeholder="email@example.com"></input>
                                    </div><br/>
                                    
                                    <div class="input-group application-group col-md-12">
                                        <span class="input-group-addon" style="width: 150px">Password</span>
                                        <input id="passwordReg" type="password" name="passwordReg" class="form-control form-required" placeholder="Password" alt="Password"></input>
                                    </div><br/>
                                    
                                    <div class="input-group application-group col-md-12">
                                        <span class="input-group-addon" style="width: 150px">Confirm Password</span>
                                        <input id="passwordRegConf" type="password" name="passwordRegConf" class="form-control form-required" placeholder="Confirm" alt="Password" value =""></input>
                                    </div><br/><br/>
                                    
                                    <div class="input-group col-md-offset-5">
                                        <button id="reg" class="btn-lg btn-success" type="submit" name="register" value="Register">Register</button>
                                    </div>
                                </form>
                            </div> <!-- End row -->
                        </div> <!-- End container-fluid -->
                    </div> <!-- End modal-body -->
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            //Register
            $("#reg").click(function(e) {
                e.preventDefault();
                var regData = $("#register-form").serializeArray();
                if(regData[2]['value'] != regData[3]['value']) {
                    $("#error").html("Passwords do not match!").fadeIn(500).delay(5000).fadeOut(500);
                    return;
                }
                if(regData[0]['value'] == "" || regData[1]['value'] == "" || regData[2]['value'] == "" || regData[3]['value'] == "") {
                    $("#error").html("Please fill in all the fields!").fadeIn(500).delay(5000).fadeOut(500);
                    return;
                }
                $.get("scripts/checkEmail.php?email="+regData[1]['value'], function(data) {
                    if(data == 2) {
                        $("#error").html("There was a problem connecting to the DB.").fadeIn(500).delay(5000).fadeOut(500);
                    } else if(data == 1) {
                        $("#error").html("That email is already registered.").fadeIn(500).delay(5000).fadeOut(500);
                    } else if(data != 0) {
                        $("#error").html(data).fadeIn(500).delay(5000).fadeOut(500);
                    } else {
                        $("#succ").html("Registering. Waiting for a confirmation message...").fadeIn(500).delay(3000).fadeOut(500);
                        var data = {
                            name     : regData[0]['value'],
                            email    : regData[1]['value'],
                            password : regData[2]['value']
                        };
                        $.ajax({
                            url    : "scripts/register.php",
                            data   : data,
                            method : "POST"
                        }).done(function(data) {
                            if(data == 2) {
                                $("#error").html("There was a problem connecting to the DB.").fadeIn(500).delay(5000).fadeOut(500);
                            } else if(data == 1) {
                                $("#error").html("There was a problem inserting").fadeIn(500).delay(5000).fadeOut(500);
                                console.log(data);
                            } else if(data != 0) {
                                $("#error").html("There was a problem. Please contact the system admin.").fadeIn(500).delay(5000).fadeOut(500);
                                console.log(data);
                            } else {
                                $("#succ").html("You have been registered. Login normally.").fadeIn(500).delay(5000).fadeOut(500);
                            }
                        });
                    }
                });
            });

            //Login
            $("#log").click(function(e) {
                e.preventDefault();
                var logData = $("#logForm").serializeArray();
                
                if(logData[0]['value'] == "" || logData[1]['value'] == "") {
                    $("#logErr").html("Please fill in all the fields!").fadeIn(500).delay(5000).fadeOut(500);
                    return;
                }

                var data = {
                    email    : logData[0]['value'],
                    password : logData[1]['value']
                };
                $.ajax({
                    type        : 'POST',
                    url         : 'scripts/login.php', 
                    data        : data, 
                    encode      : true
                }).done(function(data) {
                    // Their login was valid, redirect to main page
                    if (data == 0) {
                        window.location.href = 'http://localhost/stock_app/dashboard.php'; 
                    }
                    // Their login was not valid, display error
                    else {
                        $("#logErr").html("Your email and password was not found in our system.").fadeIn(500).delay(5000).fadeOut(500);
                    }
                });
            });
        });
    </script>

    </body>
</html>