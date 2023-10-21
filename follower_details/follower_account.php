<?php
  require_once('../assests/functions.php');

  $data = retriveFollowerDetails($_POST['followerID']);
  if(!array_key_exists('image_type', $data[1]) && !array_key_exists('profile_pic', $data[1])){
      $image = defaultProfilePicSetup();
  }else if($data[1]['profile_pic'] == '' && $data[1]['image_type'] == ''){
      $image = defaultProfilePicSetup();
  }else{
      $image = 'data:' . $data[1]['image_type'] . ';base64,' . base64_encode($data[1]['profile_pic']);
  }


?>
<div class="row d-flex flex-column px-0 ">
  <div class="col d-flex headers-top-fixed p-3">
    <div class="d-flex justify-content-center align-items-center p-3">
      <i class="fa-solid fa-arrow-left" style="color: #ffffff"></i>
    </div>
    <div>
      <div> <?='@', isset($data[1]['username']) ? $data[1]['username'] : ""  ?></div>
      <div class="number-of-posts"><?= isset($data[0][1]['postCount']) ? $data[0][1]['postCount'] : '0'?> posts</div>
    </div>
  </div>         
  <div class="col profile-details-border">
    <div class="d-flex justify-content-between align-items-center py-3">
      <div class="">
        <img
          class="w-100 profile-picture"
          src="<?= $image ?>"
          alt="" />
      </div>
      <div class="d-flex ">
        <div data-id="<?=$data[2]['user_id']?>" id="message-box" class="d-flex justify-content-center align-items-center me-3 message-box">
          <i class="fa-regular fa-envelope" style="color: #ffffff;"></i>
        </div>
        <button  id="follow-button-2" class="btn profile-save-button-2" data-id="<?=$data[2]['user_id']?>" type="submit"> <?= $data[3] ? 'Following' : "Follow" ?> </button>
      </div>
    </div>
    <div class="mb-2"><?='@', isset($data[1]['username']) ? $data[1]['username'] : "" ?></div>
    <div class="mb-2"><?= isset($data[1]['bio']) ? $data[1]['bio']: 'Write your bio here' ?></div>
    <div class="d-flex mb-2">
      <div class="me-2"><?= isset($data[0][0]['followCount']) ? $data[0][0]['followCount'] : '0' ?> <span class="text-opacity">Following</span></div>
      <div><?= isset($data[0][2]['followingCount']) ? $data[0][2]['followingCount'] : '0' ?> <span class="text-opacity">Followers</span></div>
    </div>
  </div>
  <div class="col d-flex profile-posts-navigation">
    <div id="posts" class="py-2 post text-center">Posts</div>
    <div id="replies" class="py-2 replies text-center">Replies</div>
    <div id="likes" class="py-2 likes text-center">Likes</div>
  </div>
  <div id="posts-inner-content" class="col  d-flex flex-column px-0">
    
  </div>
</div>
