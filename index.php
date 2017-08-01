<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Php Authenticate</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</head>
<body>

<div class="container">
    <div class="row">
        <div class="span12">
            <div class="" id="loginModal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3>Have an Account?</h3>
                </div>
                <div class="modal-body">
                    <div class="well">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                            <li><a href="#create" data-toggle="tab">Create Account</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane active in" id="login">
                                <form class="form-horizontal" action="process.php?action=login" method="POST">
                                    <fieldset>
                                        <div id="legend">
                                            <legend class="">Login</legend>
                                        </div>
                                        <div class="control-group">
                                            <!-- Username -->
                                            <label class="control-label" for="username">Username</label>
                                            <div class="controls">
                                                <input type="text" id="username" name="username" placeholder=""
                                                       class="input-xlarge" required>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <!-- Password-->
                                            <label class="control-label" for="password">Password</label>
                                            <div class="controls">
                                                <input type="password" id="password" name="password" placeholder=""
                                                       class="input-xlarge" required>
                                            </div>
                                        </div>


                                        <div class="control-group">
                                            <!-- Button -->
                                            <div class="controls">
                                                <button class="btn btn-success" type="submit">Login</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="create">
                                <form id="tab" class="form-horizontal" action="process.php?action=register"
                                      method="POST">
                                    <div class="control-group">
                                        <!-- Username -->
                                        <label class="control-label" for="username">Username</label>
                                        <div class="controls">
                                            <input type="text" value="akkerise" id="username" name="username"
                                                   placeholder="" class="input-xlarge" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <!-- Last Name -->
                                        <label class="control-label" for="password">Password</label>
                                        <div class="controls">
                                            <input type="text" value="1chocxuongho" id="password" name="password"
                                                   placeholder="" class="input-xlarge" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <!-- Last Name -->
                                        <label class="control-label" for="firstname">First Name</label>
                                        <div class="controls">
                                            <input type="text" value="Nguyen" id="firstname" name="firstname"
                                                   placeholder="" class="input-xlarge" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <!-- Last Name -->
                                        <label class="control-label" for="lastname">Last Name</label>
                                        <div class="controls">
                                            <input type="text" value="Thanh" id="lastname" name="lastname"
                                                   placeholder="" class="input-xlarge" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <!-- Last Name -->
                                        <label class="control-label" for="email">Email</label>
                                        <div class="controls">
                                            <input type="text" value="nguyenthanh.rise.88@gmail.com" id="email"
                                                   name="email" placeholder="" class="input-xlarge" required>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <!-- Last Name -->
                                        <label class="control-label" for="address">Address</label>
                                        <div>
                                            <textarea id="address" rows="5" cols="23"
                                                      class="input-xlarge" name="address" required>
                                            </textarea>
                                        </div>
                                    </div>

                                    <div>
                                        <button class="btn btn-primary" type="submit">Create Account</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>