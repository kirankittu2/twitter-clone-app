<?php
  require_once('../assests/functions.php');

  $data = retriveUserProfileData();
  if(!array_key_exists('image_type', $data) && !array_key_exists('profile_pic', $data)){
    $image = defaultProfilePicSetup();
  }else if($data['profile_pic'] == '' && $data['image_type'] == ''){
    $image = defaultProfilePicSetup();
  }else{
    $image = 'data:' . $data['image_type'] . ';base64,' . base64_encode($data['profile_pic']);
  }

  $count = retriveFollowandPostCount();
  
  $likes = retriveLikeIds();
  $likeArray = array();
  foreach($likes as $like){
    array_push($likeArray , $like['post_id']);
  }

?>

<div class="row d-flex flex-column px-0 ">
  <div class="col d-flex headers-top-fixed p-3">
    <div class="d-flex justify-content-center align-items-center p-3">
      <i class="fa-solid fa-arrow-left" style="color: #ffffff"></i>
    </div>
    <div>
      <div> <?='@', $data['username'] ?></div>
      <div class="number-of-posts"><?= isset($count[1]['postCount']) ? $count[1]['postCount'] : '0'?> posts</div>
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
      <div>
        <button id="edit-profile" class="btn custom-button">Edit profile</button>
      </div>
    </div>
    <div class="mb-2"><?='@', $data['username'] ?></div>
    <div class="mb-2"><?= array_key_exists('bio', $data) ? $data['bio']: 'Write your bio here' ?></div>
    <div class="d-flex mb-2">
      <div class="me-2"><?= isset($count[0]['followCount']) ? $count[0]['followCount'] : '0' ?> <span class="text-opacity">Following</span></div>
      <div><?= isset($count[2]['followingCount']) ? $count[2]['followingCount'] : '0' ?> <span class="text-opacity">Followers</span></div>
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
