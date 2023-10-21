<?php
    require_once('assests/functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="http://localhost/gesto/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center m-5">
            <div class="col-4 gesto-header-outer"> 
                <div class="col"><h1>Email Verification</h1></div>
                <div class="col">OTP has sent to your email address</div>
                <form action="http://localhost/gesto/assests/actions.php" method="POST">
                    <input type="hidden" name="verify_email" >
                    <div class="col my-3"><input class="form-control" type="text" name="verification_code" placeholder="Enter your OTP"></div>
                    <?php showError('verification_code') ?>
                    <div class="col "><button type="submit" class="btn btn-primary font">Submit</button></div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>