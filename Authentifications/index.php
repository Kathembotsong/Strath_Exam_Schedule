
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        section {
            margin-top: 7%;
        }

        .card {
            width: 25rem;
            background-color:#2A7FFF;
            border-radius: 15%;
        }
        .card-img-top {
            width: 50%;
            border-radius: 15%;
            margin-top:10%;
            padding:3%;
        }
        .mb-3{
            padding:3%;
        }

        .message {
            margin-left: 15%;
            color: red;
            background:yellow;
            width:70%;
            margin:3%;
        }
    </style>
</head>
<body>
<section>
    <center>
        <form action="login.php" method="post" enctype="multipart/form-data">
            <div class="card">
                <img src="image/login.jpeg" class="card-img-top" alt="login image" >
                <div class="card-body">
                    <p class="message"><?php if (isset($message)) { echo $message; } ?></p>
                    <div class="mb-3">
                        <input type="text" class="form-control" required placeholder="user_code" name="user_code">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" required placeholder="password" name="password">
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary" value="Login" name="login">
                    </div>
                    <div class="mb-3">
                        <a href="../twilio_php_main/example/password_reset_request.php" style="text-decoration: none; color:white;">Forgot password?</a>
                    </div>
                </div>
            </div>
        </form>
    </center>
</section>
</body>
</html>

