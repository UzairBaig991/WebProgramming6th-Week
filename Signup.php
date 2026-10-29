<?php
$con = mysqli_connect('localhost', 'root', '', 'userregistration');
if (!$con) {
    die("Connection Failed");
}
$message = "";
if (isset($_POST['btn'])) {
    $username     = trim($_POST['username']);
    $email        = trim($_POST['email']);
    $fn           = trim($_POST['fn']);
    $password     = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];
    if (empty($username) || empty($email) || empty($fn) || empty($password) || empty($confirm_pass)) {
        $message = "<div class='alert error'>Please fill all the fields!</div>";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert error'>Invalid email format!</div>";
    }
    elseif ($password !== $confirm_pass) {
        $message = "<div class='alert error'>Passwords do not match!</div>";
    }
    elseif (strlen($password) < 6) {
        $message = "<div class='alert error'>Password must be at least 6 characters!</div>";
    }
    else {
        $username = mysqli_real_escape_string($con, $username);
        $email    = mysqli_real_escape_string($con, $email);
        $fn       = mysqli_real_escape_string($con, $fn);

        $check = mysqli_query($con, "SELECT * FROM signup WHERE username = '$username' OR email = '$email'");
        
        if (mysqli_num_rows($check) > 0) {
            $message = "<div class='alert error'>Username or Email already exists!</div>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO signup (username, email, father_name, password) 
                      VALUES ('$username', '$email', '$fn', '$hashed_password')";
            
            $result = mysqli_query($con, $query);
            if ($result) {
                $message = "<div class='alert success'>Registration Successful! You can now login.</div>";
            } else {
                $message = "<div class='alert error'>Something went wrong. Please try again.</div>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 15px;
        }

        .card {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            border: 1px solid #eef0f4;
        }

        .card-header {
            background: #ffffff;
            text-align: center;
            padding: 36px 30px 10px;
        }

        .card-header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .card-header p {
            font-size: 14px;
            color: #64748b;
        }

        .card-body {
            padding: 28px 32px 36px;
        }

        .input-group {
            margin-bottom: 18px;
            position: relative;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #475569;
            margin-bottom: 6px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 44px 12px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14.5px;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.25s ease;
        }

        .input-group input:focus {
            border-color: #64748b;
            background: #ffffff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(100, 116, 139, 0.1);
        }

        .input-group input::placeholder {
            color: #94a3b8;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 37px;
            cursor: pointer;
            color: #94a3b8;
            font-size: 15px;
            transition: 0.2s;
        }

        .toggle-password:hover {
            color: #475569;
        }

        .btn {
            width: 100%;
            padding: 13px;
            background: #1e293b;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.25s ease;
            margin-top: 8px;
        }

        .btn:hover {
            background: #0f172a;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.15);
        }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13.5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .footer-text {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #64748b;
        }

        .footer-text a {
            color: #1e293b;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h1>Create Account</h1>
            <p>Please fill in the details to register</p>
        </div>

        <div class="card-body">
            <?php echo $message; ?>

            <form method="POST">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="input-group">
                    <label>Father's Name</label>
                    <input type="text" name="fn" placeholder="Enter father's name" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter password" required>
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
                </div>

                <div class="input-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required>
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('confirm_password', this)"></i>
                </div>

                <button type="submit" name="btn" class="btn">Sign Up</button>
            </form>

            <div class="footer-text">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>