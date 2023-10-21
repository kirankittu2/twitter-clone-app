<?php

    require_once('assests/config.php');

    require_once('assests/send-code.php');

    require_once('assests/functions.php');

    
    if(!isset($_SESSION['userdata'])){
        header('location: http://localhost/gesto/registration');
    }


    retriveIDFromUsername();

    
    $currentprofiledata = retriveUserProfileData();
    if(!array_key_exists('image_type', $currentprofiledata) && !array_key_exists('profile_pic', $currentprofiledata)){
        $image = defaultProfilePicSetup();
    }else if($currentprofiledata['profile_pic'] == '' && $currentprofiledata['image_type'] == ''){
        $image = defaultProfilePicSetup();
    }else{
        $image = 'data:' . $currentprofiledata['image_type'] . ';base64,' . base64_encode($currentprofiledata['profile_pic']);
    } 

    $accounts = retriveAccountsToFollow();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link
      href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.css"
      rel="stylesheet" />
    <link rel="stylesheet" href="http://localhost/gesto/css/style.css">
    
    <script
      src="https://kit.fontawesome.com/8b8cc22d8c.js"
      crossorigin="anonymous"></script>
</head>
<body >
    <div class="container-fluid" ">
        <div class="row">
            <div class="col ">
                
            </div>
            <div class="col-8 p-0 ">
                <div class="row d-flex justify-content-center">

                    <div class="col-2 profile">         
                        <div class="d-flex flex-column profile-inner ">
                            <div class="logo py-3  profile-inner-1">
                                G E S T O
                            </div>
                            <div class="  mb-auto">
                                <ul class="p-0">
                                    <li id="home">
                                        <div class="d-flex">
                                            <div class="profile-icon">
                                                <i class="fa-solid fa-house" style="color: #ffffff;"></i>
                                            </div>
                                            <div class="profile-label">
                                                Home
                                            </div>
                                        </div>
                                    </li>
                                    <li id="notifications">
                                        <div class="d-flex">
                                            <div class="profile-icon">
                                                <i class="fa-solid fa-bell" style="color: #ffffff;"></i>
                                            </div>
                                            <div class="profile-label">
                                                Notifications
                                            </div>
                                        </div>
                                    </li>
                                    <li id="messages">
                                        <div class="d-flex">
                                            <div class="profile-icon">
                                                <i class="fa-solid fa-envelope" style="color: #ffffff;"></i>
                                            </div>
                                            <div class="profile-label">
                                                Messages
                                            </div>
                                        </div>
                                    </li>
                                    <li id="settings">
                                        <div class="d-flex">
                                            <div class="profile-icon">
                                                <i class="fa-solid fa-gear" style="color: #ffffff;"></i>
                                            </div>
                                            <div class="profile-label">
                                                Settings
                                            </div>
                                        </div>
                                    </li>
                                    <li id="profile">
                                        <div class="d-flex">
                                            <div class="profile-icon">
                                                <i class="fa-solid fa-user" style="color: #ffffff;"></i>
                                            </div>
                                            <div class="profile-label">
                                                Profile
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div id="switch-account" class="flex-column  mb-3 py-2 px-3 logout">
                                <form action="http://localhost/gesto/assests/actions.php" method="POST">
                                    <input type="hidden" name="logout">
                                <button class="switch-account-button w-100" type="submit">
                                <div class="d-flex">               
                                    <div>
                                        <img class="feed-profile-picture" src="<?= $image ?>" alt="">
                                    </div>
                                    <div class="ms-2">
                                        <div><?=$currentprofiledata['username']?></div>
                                        <div class="text-opacity">@<?= $currentprofiledata['username'] ?></div>
                                    </div>           
                                </div>
                                </button>
                                </form>
                            </div>    
                        </div>                
                    </div>

                    <div class="col-6 main-content-border">
                        <div id="popup-outer" class="popup-outer ">
                            <div id="popup-inner" class="popup-inner py-3"></div>
                        </div>
                        <div id="inner-main-content" class="row flex-column align-items-center">
                           
                        </div>
                        <div id="popup-outer-2" class="popup-outer-2">
                            <div id="popup-inner-2" class="popup-inner-2 py-3"></div>
                        </div>
                        <div id="inner-main-content-2" class="row flex-column align-items-center">
                           
                        </div>
                    </div>

                    <div class="col-2 search" id="listofmessages">
                        <div class="row ">
                            <div class="col">
                            <div class="col py-3">
                                <input type="text" class="form-control gesto-search" placeholder="Search">
                            </div>

                            <div class="col who-to-follow d-flex flex-column">
                                <div class="p-3 mx-3 who-to-follow-text">
                                    Who To Follow
                                </div>  
                                
                                <?php
                                foreach($accounts as $account){
                                    if(!array_key_exists('image_type', $account) && !array_key_exists('profile_pic', $account)){
                                        $image = defaultProfilePicSetup();
                                    }else if($account['profile_pic'] == '' && $account['image_type'] == ''){
                                        $image = defaultProfilePicSetup();
                                    }else{
                                        $image = 'data:' . $account['image_type'] . ';base64,' . base64_encode($account['profile_pic']);
                                    }
                                    echo '<div data-id="'.$account['username'].'" class="d-flex p-2 mx-3 follower-container">';
                                    echo '<div>';
                                    echo '<img class="feed-profile-picture" src="'.$image.'" alt="">';
                                    echo '</div>';
                                    echo '<div class="ms-3 d-flex flex-column justify-content-center">';
                                    echo '<div>' .$account['username']. '</div>';
                                    echo '<div class="text-opacity">@' . $account['username'] .'</div>';
                                    echo '</div> ';
                                    echo '<div class="ms-auto d-flex align-items-center">';
                                    echo '<button  class="btn profile-save-button follow-button" data-id="'. $account['user_id'] .'" type="submit">Follow</button>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>      
            </div>
            <div class="col ">
                
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.js"></script>
    <script src="http://localhost/gesto/js/index.js"></script>
</body>
</html>