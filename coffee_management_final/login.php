<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Management Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <div class="row">
                <div class="col-md-6 login-left">
                    <h2>Login Here</h2>
                    <form action="validation.php" method="post">

                        <?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success">
                                Registration successful! Please login.
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">
                                <?php
                                if ($_GET['error'] == 'invalid')
                                    echo 'Invalid username or password!';
                                if ($_GET['error'] == 'nouser')
                                    echo 'Account does not exists!';
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="user" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="remember_me" id="rememberCheck">
                            <label class="form-check-label" for="rememberCheck">Remember me</label> 
                        </div>

                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>

                <div class="col-md-6 login-right">
                    <h2>Register Here</h2>
                    <form action="registration.php" method="post">

                        <?php if (isset($_GET['reg_error'])): ?>
                            <div class="alert alert-danger">
                                <?php
                                if ($_GET['reg_error'] == 'exists')
                                    echo 'Username already exists!';
                                if ($_GET['reg_error'] == 'fail')
                                    echo 'Registration failed, please try again.';
                                ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="user" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>