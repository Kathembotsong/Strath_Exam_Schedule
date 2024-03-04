<?php
session_start();
include '../system/dbcon.php';

try {
    if (isset($_POST["login"])) {
        if (empty($_POST["user_code"]) || empty($_POST["password"])) {
            $message = '<label>All fields are required</label>';
        } else {
            $user_code = $_POST["user_code"];
            $password = $_POST["password"];

            // Fetch user data by user_code
            $query = "SELECT * FROM users WHERE user_code = :user_code";
            $statement = $conn->prepare($query);
            $statement->execute(['user_code' => $user_code]);
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify password
                if (password_verify($password, $user["user_password"])) {
                    $_SESSION["user_code"] = $user_code;
                    $_SESSION["role"] = $user["role"];
                    $_SESSION["username"] = $user["username"];

                    // Store the current page in a session variable
                    $_SESSION["current_page"] = basename($_SERVER['PHP_SELF']);

                    // Redirect based on role
                    switch ($user["role"]) {
                        case "schoolAdmin":
                            header("Location: ../system/schooladmin_dashboard.php");
                            exit();
                        case "examofficer":
                            header("Location: ../system/exam_officer_dashboard.php");
                            exit();
                        case "facAdmin":
                            switch ($user["school"]) {
                                case "BBIT":
                                    header("Location: ../system/bbit_facAdmin_dashboard.php");
                                    exit();
                                case "SCS":
                                    header("Location: ../system/scs_facAdmin_dashboard.php");
                                    exit();
                                case "SLS":
                                    header("Location: ../system/sls_facAdmin_dashboard.php");
                                    exit();
                                case "BCOM":
                                    header("Location: ../system/bcom_facAdmin_dashboard.php");
                                    exit();
                                case "TOURISM":
                                    header("Location: ../system/tourism_facAdmin_dashboard.php");
                                    exit();
                                default:
                                    header("Location: login.php");
                                    exit();
                            }
                        case "student":
                            switch ($user["role"]) {
                                case "student":
                                    header("Location: ../system/student_dashboard.php");
                                    exit();
                                default:
                                    header("Location: login.php");
                                    exit();
                            }
                        case "lecturer":
                            switch ($user["school"]) {
                                case "BBIT":
                                    header("Location: ../system/bbit_lecturer_dashboard.php");
                                    exit();
                                case "SCS":
                                    header("Location: ../system/scs_lecturer_dashboard.php");
                                    exit();
                                case "SLS":
                                    header("Location: ../system/sls_lecturer_dashboard.php");
                                    exit();
                                case "BCOM":
                                    header("Location: ../system/bcom_lecturer_dashboard.php");
                                    exit();
                                case "TOURISM":
                                    header("Location: ../system/tourism_lecturer_dashboard.php");
                                    exit();
                                default:
                                    header("Location: login.php");
                                    exit();
                            }
                        default:
                            header("Location: login.php");
                            exit();
                    }
                } else {
                    $message = '<label>The code or password is incorrect</label>';
                }
            } else {
                $message = '<label>The code or password is incorrect</label>';
            }
        }
    }
} catch (PDOException $error) {
    $message = $error->getMessage();
}
?>



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

