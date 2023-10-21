<?php
    require_once('../assests/functions.php');

    if(isset($_POST['msgFollowerID']) && $_POST['msgFollowerID'] != "" ){
        $data = retriveUserProfileData($_POST['msgFollowerID']);
        if(!array_key_exists('image_type', $data) && !array_key_exists('profile_pic', $data)){
            $image = defaultProfilePicSetup();
        }else if($data['profile_pic'] == '' && $data['image_type'] == ''){
            $image = defaultProfilePicSetup();
        }else{
            $image = 'data:' . $data['image_type'] . ';base64,' . base64_encode($data['profile_pic']);
        }
    }

    $messageList = fetchAllMessages();

    var_dump(testing());

    
    
?>

<div class="row">
    <div>
    <div class="col heading-bold pt-3 ">Messages</div>
    <div class="col pt-3">
        <input type="text" class="form-control gesto-search" placeholder="Search Direct Messages">
    </div>
    </div>
    <?php
    foreach($messageList as $message){
        if(!array_key_exists('image_type', $message) && !array_key_exists('profile_pic', $message)){
            $image2 = defaultProfilePicSetup();
        }else if($message['profile_pic'] == '' && $message['image_type'] == ''){
            $image2 = defaultProfilePicSetup();
        }else{
            $image2 = 'data:' . $message['image_type'] . ';base64,' . base64_encode($message['profile_pic']);
        }
        echo '<div data-conversation-id="'.$message['id'].'" data-follower-id="'.$message['user_id'].'" class="px-0 mt-1 message-containers msg-parent">
                <div class="col d-flex my-2 mx-3 msg">
                    <div class="msg">
                        <img
                            class="feed-profile-picture msg"
                            src="'.$image2.'"
                            alt="" />
                    </div>
                    <div class="w-100 ms-3 msg">
                        <div class="msg">'.$message['username'].' <span class="text-opacity msg">@'.$message['username'].'</span></div>
                        <div class="mb-2 msg">Hello</div>
                        </div>
                    </div>
                </div>';
    }
    ?>
</div>