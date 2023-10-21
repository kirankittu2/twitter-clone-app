<?php

require_once('../assests/functions.php');

$singleComment = array();
$comments = retriveAllComments($_POST['postID']);

foreach($comments as $comment){
    if($comment['parent_comment_id'] == $_POST['commentid']){
        array_push($singleComment , $comment);
        break;
    }
}


if(!array_key_exists('image_type', $singleComment[0]) && !array_key_exists('profile_pic', $singleComment[0])){
    $image = defaultProfilePicSetup();
}else if($singleComment[0]['profile_pic'] == '' && $singleComment[0]['image_type'] == ''){
    $image = defaultProfilePicSetup();
}else{
    $image = 'data:' . $singleComment[0]['image_type'] . ';base64,' . base64_encode($singleComment[0]['profile_pic']);
}


$commentLikes = retriveCommentIds();
$commentlikearray = array();
foreach($commentLikes as $commentlike){
  array_push($commentlikearray , $commentlike['comment_id']);
}




?>
<div class="col inner-comment-container comment-parent-click" data-comment-id="<?=$singleComment[0]['comment_id']?>" data-post-id="<?= $_POST['postID'] ?>" >
    <div  class="d-flex ">
        <div class="d-flex flex-column">
            <img class="feed-profile-picture" src="<?= $image ?>" alt="">             
        </div>
        <div class="d-flex flex-column w-100 comment-click">
        <div>
            <div class="ms-3 d-flex comment-click">
                <div><?= $singleComment[0]['username'] ?></div>
                <div class="text-opacity">@<?= $singleComment[0]['username'] ?></div>
            </div>
            <div class="ms-3 comment-click"><?= $singleComment[0]['comment_content'] ?></div>
        </div>
        <div class="d-flex ms-3 mt-2">
            <div class="w-50 d-flex align-items-center comment-click">
                <i data-post-id="<?= $_POST['postID'] ?>" data-comment-id="<?= $singleComment[0]['comment_id'] ?>" class="fa-regular fa-comment comment inside-comment" style="color: #979797"> </i
                ><span class="like-comment ms-1"><?= globalInnerCommentCount($singleComment[0]['comment_id']) ?></span>
            </div>
            <div class="w-50 d-flex align-items-center comment-click">
                <i  data-comment-id="<?= $singleComment[0]['comment_id'] ?>" class=" <?= (in_array($singleComment[0]['comment_id'] , $commentlikearray) ? 'fa-solid' : 'fa-regular') ?> fa-heart comment-like like" style="color: #979797"> </i
                ><span  class=" like-comment ms-1"><?= globalCommentLikesCount($singleComment[0]['comment_id']) ?></span>
            </div>
        </div>
        </div>
    </div>
</div>
