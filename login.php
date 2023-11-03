<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect if the user is already logged in
    exit();
}

// Include a database connection file to interact with your database
include('admin/connect.php'); // Replace with the actual database connection file.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username and password
    $username = $_POST['username'];
    $providedPassword = $_POST['password'];

    // Retrieve the hashed password from the database based on the username
    $query = "SELECT * FROM employee WHERE USERNAME = '$username'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $storedPassword = $row['USERPASS'];

        // Verify the provided password against the stored hashed password
        if (password_verify($providedPassword, $storedPassword)) {
            // Authentication successful
            $_SESSION['user_id'] = $row['EMPID'];
            header("Location: index.php"); // Replace 'dashboard.php' with the actual page to redirect to upon successful login.
            exit();
        } else {
            // Authentication failed
            $login_error = "Invalid username or password";
        }
    } else {
        // Username not found
        $login_error = "Invalid username or password";
    }
}

// Close the database connection
mysqli_close($conn);
?>


<?php include('navbar.php');?>

<?php var_dump($_SESSION);?>
<!DOCTYPE html>
<html lang="en">
<head></head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous"
    />
    <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"
    ></script>
    <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
            crossorigin="anonymous"
    ></script>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Document</title>
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
                                <form action="process_login.php" method="POST">
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
                                        <a href="register.html"
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
