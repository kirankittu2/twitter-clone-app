<?php

require_once('../assests/functions.php');

$currentprofiledata = retriveUserProfileData();
  if(!array_key_exists('image_type', $currentprofiledata) && !array_key_exists('profile_pic', $currentprofiledata)){
    $image = defaultProfilePicSetup();
  }else if($currentprofiledata['profile_pic'] == '' && $currentprofiledata['image_type'] == ''){
    $image = defaultProfilePicSetup();
  }else{
    $image = 'data:' . $currentprofiledata['image_type'] . ';base64,' . base64_encode($currentprofiledata['profile_pic']);
  }
$posts = retrievFeedPosts();

$likes = retriveLikeIds();

$likeArray = array();

foreach($likes as $like){
  array_push($likeArray , $like['post_id']);
}



?>
<div class="col pt-3 pb-4 heading-bold headers-top-fixed">Home</div>

<div class="col d-flex top-border p-3">
  <div>
    <img
      class="feed-profile-picture"
      src="<?= $image ?>"
      alt="" />
  </div> 
  <div class="w-100 ms-3">
  <form action="assests/actions.php" method="post">
    <input type="hidden" name="createpost" />
      <textarea
        name="post_content"
        id="auto-expand-textarea"
        class="form-control feed-form-control mb-3"
        placeholder="What is Happening?"></textarea>
      <button type="submit" class="btn custom-blue-button ms-2">Post</button>
    </div>
  </form>
</div>
 
  <?php  
    foreach($posts as $post){  
      if(!array_key_exists('image_type', $post) && !array_key_exists('profile_pic', $post)){
        $image = defaultProfilePicSetup();
      }else if($post['profile_pic'] == '' && $post['image_type'] == ''){
        $image = defaultProfilePicSetup();
      }else{
        $image = 'data:' . $post['image_type'] . ';base64,' . base64_encode($post['profile_pic']);
      }

      echo '<div data-gesto-post-id="'.$post['post_id'].'" data-gesto-post-username="'.$post['username'].'" class="px-0 post-container parent">';
      echo '<div class="col d-flex top-border p-3 gesto-post posts">';
      echo '<div class="posts">
              <img
                class="feed-profile-picture"
                src="'.$image.'"
                alt="" />
            </div>';
      echo '<div class="w-100 ms-3 posts">';
      echo '<div class=" posts ">' . $post['username'] .'<span class="text-opacity"> @' .$post['username']. '</span></div>';
      echo '<div class="mb-2 posts">'. $post['post_content'] .'</div>';
      echo '<div class="d-flex">      
              <div class="w-50 d-flex align-items-center posts">
                <i data-post-id="'.$post['post_id'].'" class=" fa-regular home-comment fa-comment comment" style="color: #979797"> </i
                ><span class="like-comment ms-1">'.globalCommentsCount($post['post_id']).'</span>
              </div>
              <div class="w-50 d-flex align-items-center posts">
                <i data-post-id="'.$post['post_id'].'" class=" '. (in_array($post['post_id'] , $likeArray) ? 'fa-solid' : 'fa-regular') . ' fa-heart post-like like" style="color: #979797"> </i
                ><span data-post-id="'.$post['post_id'].'" class="like-comment ms-1">'.globalLikesCount($post['post_id']).'</span>
              </div>
            </div>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    } 
  ?>