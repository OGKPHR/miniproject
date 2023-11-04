<?php session_start();
include("navbar.php");

// Connect to the database
require 'admin/connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM employee WHERE username = ?");
    $stmt->bind_param("s", $username);
    
    // Execute the statement
    $stmt->execute();
    
    // Store the result so we can check if the account exists in the database.
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store hashed passwords.
        $user = $result->fetch_assoc();

        // Verify user password and set $_SESSION
        if (password_verify($password, $user['USERPASS'])) {
           
            // Password is correct, so start a new session
            $_SESSION['user_id'] = $user['EMPID'];
            $_SESSION['username'] = $user['USERNAME'];
            $_SESSION['job_id'] =   $user['JOBPOSITION'];
            $_SESSION['time'] = time();
            var_dump($_SESSION);

            // Redirect to user dashboard page
            header("location: index.php");
            exit();
        } else {
            // Password is not valid, display a generic error message
            $error = 'Invalid password.';
        }
    } else {
        // Username doesn't exist, display a generic error message
        $error = 'Invalid username.';
    }
    
    // TODO: notify user error;
    echo "<script type='text/javascript'>alert('$error');</script>";
    
    $stmt->close();
}

// Close connection
$conn->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"
    ></script>
    <title>Login Page</title>
</head>
<body>
<section class="vh-100" style="background-color: #9a616d">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-10">
                <div class="card" style="border-radius: 1rem">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img
                                    src="https://images.pexels.com/photos/6177607/pexels-photo-6177607.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                    alt="login form"
                                    class="img-fluid"
                                    style="border-radius: 1rem 0 0 1rem; object-fit: cover"
                            />
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">
                                <form action="login.php" method="POST">
                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <i
                                                class="fas fa-cubes fa-2x me-3"
                                                style="color: #ff6219"
                                        ></i>
                                        <span class="h1 fw-bold mb-0">BETTER COMPANY</span>
                                    </div>

                                    <h5
                                            class="fw-normal mb-3 pb-3"
                                            style="letter-spacing: 1px"
                                    >
                                        Sign into your account
                                    </h5>

                                    <!-- Username input -->
                                    <div class="form-floating mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="floatingInput"
                                        name="username"
                                        placeholder="Username"
                                    />
                                    <label for="floatingInput">Username</label>
                                </div>

                                    <!-- Password input -->
                                    <div class="form-floating mt-3 mb-3">
                                        <input
                                                type="password"
                                                class="form-control"
                                                id="floatingPassword"
                                                name="password"
                                                placeholder="Password"
                                        />
                                        <label for="floatingPassword">Password</label>
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button
                                                class="btn btn-dark btn-lg btn-block"
                                                type="submit"
                                        >
                                            Login
                                        </button>
                                    </div>

                                    <a class="small text-muted" href="#!">Forgot password?</a>
                                    <p class="mb-5 pb-lg-2" style="color: #393f81;">
                                        Don't have an account?
                                        <a href="registerform.php"
                                           style="color: #393f81; text-decoration: underline;"
                                        >Register here</a>
                                    </p>
                                    <a href="#!" class="small text-muted">Terms of use.</a>
                                    <a href="#!" class="small text-muted">Privacy policy</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
