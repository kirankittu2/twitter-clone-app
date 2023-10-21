<?php

require_once('assests/functions.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="http://localhost/gesto/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-4 mt-5 ps-0 pe-0 gesto-header-outer">
                <div class="col d-flex flex-column align-items-center gesto-header">
                    <h1 class="mb-0 mt-3 ms-3 me-3 font">G E S T O</h1>
                    <h3 class="mb-3 mt-0 ms-3 me-3 font">Reset Password</h3>
                </div>
                <form action="http://localhost/gesto/assests/actions.php" method="POST">
                    <input type="hidden" name="resetpassword">
                    <div class="col m-3">
                        <input class="form-control font" name="email"  type="text" placeholder="Email your otp here" >
                    </div>
                    <?= showError('email'); ?>
                    <div class="col m-3">
                        <button type="submit " class="btn btn-primary font">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>