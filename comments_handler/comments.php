<?php
    require_once('../assests/functions.php');

    $currentprofiledata = retriveUserProfileData();
    if(!array_key_exists('image_type', $currentprofiledata) && !array_key_exists('profile_pic', $currentprofiledata)){
        $currentuserimage = defaultProfilePicSetup();
    }else if($currentprofiledata['profile_pic'] == '' && $currentprofiledata['image_type'] == ''){
        $currentuserimage = defaultProfilePicSetup();
    }else{
        $currentuserimage = 'data:' . $currentprofiledata['image_type'] . ';base64,' . base64_encode($currentprofiledata['profile_pic']);
    }

    $upperComments = array();
    array_push($upperComments , $_POST['innercommentsclickid']);

    $comments = retriveAllComments($_POST['postID']);
    $post = postContent($_POST['postID']);
    if(!array_key_exists('image_type', $post) && !array_key_exists('profile_pic', $post)){
        $profileimage = defaultProfilePicSetup();
    }else if($post['profile_pic'] == '' && $post['image_type'] == ''){
        $profileimage = defaultProfilePicSetup();
    }else{
        $profileimage = 'data:' . $post['image_type'] . ';base64,' . base64_encode($post['profile_pic']);
    }

    $i = 0;
    while($i != count($upperComments)){
        foreach($comments as $comment){
            if($upperComments[$i] == $comment['comment_id'] && $comment['parent_comment_id'] != NULL){
                array_push($upperComments , $comment['parent_comment_id']);
            }
        }
        $i++;
    }

    $likes = retriveLikeIds();
    $likeArray = array();
    foreach($likes as $like){
        array_push($likeArray , $like['post_id']);
    }

    $commentLikes = retriveCommentIds();
    $commentlikearray = array();
    foreach($commentLikes as $commentlike){
    array_push($commentlikearray , $commentlike['comment_id']);
    }




?>
<div class="row flex-column p-0">
    <div class="col d-flex headers-top-fixed py-2">
        <div class="d-flex justify-content-center align-items-center p-2">
            <i class="fa-solid fa-arrow-left" style="color: #ffffff"></i>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <div class="heading-bold headers-top-fixed ">Post</div>
        </div>
    </div>
    <div class="px-0 post-container ">
        <div class="col d-flex py-1  px-3 gesto-post posts">
            <div class="d-flex flex-column">
                    <img
                        class="feed-profile-picture"
                        src="<?= $profileimage ?>"
                        alt="" />
                        <div class="d-flex justify-content-center h-100 "><div class="line"></div></div>
                    </div>
            <div class="w-100 ms-3 ">
            <div class="  "><?= $post['username'] ?><span class="text-opacity"> @<?= $post['username'] ?></span></div>
            <div class="mb-2 "><?= $post['post_content'] ?></div>
            <div class="d-flex">      
                    <div class="w-50 d-flex align-items-center ">
                        <i data-post-id="<?= $_POST['postID'] ?>"  class="fa-regular fa-comment home-comment comment" style="color: #979797"> </i
                        ><span class="like-comment ms-1"><?= globalCommentsCount($_POST['postID']) ?></span>
                    </div>
                    <div class="w-50 d-flex align-items-center ">
                        <i data-post-id="<?= $_POST['postID'] ?>" class="<?= (in_array($_POST['postID'] , $likeArray) ? 'fa-solid' : 'fa-regular') ?> fa-heart like" style="color: #979797"> </i
                        ><span  class="like-comment ms-1"><?=globalLikesCount($_POST['postID'])?></span>
                    </div>
                    </div>
            </div>
            </div>
        </div>
    <?php
    for($i = count($upperComments) - 1 ; $i > 0 ; $i--){
        foreach($comments as $comment){
            if(!array_key_exists('image_type', $comment) && !array_key_exists('profile_pic', $comment)){
                $image = defaultProfilePicSetup();
            }else if($comment['profile_pic'] == '' && $comment['image_type'] == ''){
                $image = defaultProfilePicSetup();
            }else{
                $image = 'data:' . $comment['image_type'] . ';base64,' . base64_encode($comment['profile_pic']);
            }
            if($upperComments[$i] == $comment['comment_id']){
                echo '<div class="px-0 post-container ">
                <div class="col d-flex py-2  px-3 gesto-post posts">
                <div class="d-flex flex-column">
                        <img
                            class="feed-profile-picture"
                            src="'.$image.'"
                            alt="" />
                            <div class="d-flex justify-content-center h-100 "><div class="line"></div></div>
                        </div>
                <div class="w-100 ms-3 ">
                <div class="  ">' . $comment['username'] .'<span class="text-opacity"> @' .$comment['username']. '</span></div>
                <div class="mb-2 ">'. $comment['comment_content'] .'</div>
                <div class="d-flex">      
                        <div class="w-50 d-flex align-items-center ">
                            <i data-post-id="'.$_POST['postID'].'" data-comment-id="'.$comment['comment_id'].'"  class=" fa-regular fa-comment inside-comment comment" style="color: #979797"> </i
                            ><span class="like-comment ms-1">'.globalInnerCommentCount($comment['comment_id']).'</span>
                        </div>
                        <div class="w-50 d-flex align-items-center ">
                            <i data-comment-id="'.$comment['comment_id'].'" class=" '.(in_array($comment['comment_id'] , $commentlikearray) ? 'fa-solid' : 'fa-regular').' fa-heart comment-like like" style="color: #979797"> </i
                            ><span  class="like-comment ms-1">'.globalCommentLikesCount($comment['comment_id']).'</span>
                        </div>
                        </div>
                </div>
                </div>
                </div>';
            }
        }
    }
    foreach($comments as $comment){
        if($comment['comment_id'] == $upperComments[0]){
            if(!array_key_exists('image_type', $comment) && !array_key_exists('profile_pic', $comment)){
                $imageofmain = defaultProfilePicSetup();
            }else if($comment['profile_pic'] == '' && $comment['image_type'] == ''){
                $imageofmain = defaultProfilePicSetup();
            }else{
                $imageofmain = 'data:' . $comment['image_type'] . ';base64,' . base64_encode($comment['profile_pic']);
            }
            $postedTime = date('g:i A', strtotime($comment['created_on']));
            $postedDate = date('M d, Y', strtotime($comment['created_on']));
            echo'<div class="row flex-column px-3">
                <div class="col">
                    <div class="d-flex ">
                        <div>
                            <img class="feed-profile-picture" src="'.$imageofmain.'" alt="">
                        </div>
                        <div class="ms-3 d-flex flex-column justify-content-center">
                            <div>'. $comment['username'] .'</div>
                            <div class="text-opacity">@'. $comment['username'] .'</div>
                        </div>
                        <div class="ms-auto d-flex align-items-center">
                            <i class="fa-solid fa-ellipsis" style="color: #ffffff;"></i>
                        </div>
                    </div>
                </div>
                <div class="col ">
                    <div class="py-2">'. $comment['comment_content'] .'</div>
                </div>
                <div class="col mb-2">
                    <span class="text-opacity py-2 ">'.$postedTime.'</span> <span class="text-opacity">'.$postedDate.'</span>
                </div>
                </div>';
        }
    }
    ?>
    <div class="col">
        <div class="d-flex ps-2 py-3 post-like-comment-border">
            <div class="w-50 d-flex align-items-center ">
                <i data-post-id="<?= $_POST['postID'] ?>" data-comment-id="<?= $upperComments[0] ?>" class="fa-regular fa-comment inside-comment comment" style="color: #979797"> </i
                ><span class="like-comment ms-1"><?= globalInnerCommentCount($upperComments[0]) ?></span>
              </div>
              <div class="w-50 d-flex align-items-center">
                <i data-comment-id="<?= $comment['comment_id'] ?>"  class=" <?= (in_array($upperComments[0] , $commentlikearray) ? 'fa-solid' : 'fa-regular') ?> fa-heart comment-like like" style="color: #979797"> </i
                ><span class="like-comment ms-1"><?=globalCommentLikesCount($upperComments[0]) ?></span>
            </div>
        </div>
    </div>
    <div class="col">
         <div data-id="'.$account['username'].'" class="d-flex p-2 ">
            <div>
                <img class="feed-profile-picture" src="<?= $currentuserimage ?>" alt="">
            </div>
            <form action="http://localhost/gesto/assests/actions.php" method="post">
            <input type="hidden" name="createcommentinner" value="<?=$_POST['postID']?>"/>
            <input type="hidden" name="parentcommentid" value="<?=$upperComments[0]?>"/>
            <div class="ms-3 d-flex flex-column justify-content-center w-100">
                <textarea
                    name="post_content"
                    id="auto-expand-textarea"
                    class="form-control feed-form-control "
                    placeholder="Post your reply"></textarea>
            </div>
            <div class=" d-flex align-items-center">
                <button  class="btn profile-save-button "  type="submit">Reply</button>
            </div>
            </form>
        </div>
    </div>
    <?php
    foreach($comments as $comment){
        if($comment['parent_comment_id'] == $_POST['innercommentsclickid']){
            if(!array_key_exists('image_type', $comment) && !array_key_exists('profile_pic', $comment)){
                $imageofcomments = defaultProfilePicSetup();
            }else if($comment['profile_pic'] == '' && $comment['image_type'] == ''){
                $imageofcomments = defaultProfilePicSetup();
            }else{
                $imageofcomments = 'data:' . $comment['image_type'] . ';base64,' . base64_encode($comment['profile_pic']);
            }
    echo '<div class="col top-border p-0">
         <div data-post-id="'.$_POST['postID'].'" data-comment-id="'.$comment['comment_id'].'" class="d-flex px-3 py-2 comment-container comment-parent-click">
            <div class="d-flex flex-column">
                <img class="feed-profile-picture" src="'.$imageofcomments.'" alt="">    
                <div class="d-flex justify-content-center h-100 "><div class="line"></div></div>         
            </div>
            <div class="d-flex flex-column w-100 comment-click">
            <div>
                <div class="ms-3 d-flex comment-click">
                    <div>'.$comment['username'].'</div>
                    <div class="text-opacity">@'.$comment['username'].'</div>
                </div>
                <div class="ms-3 comment-click">'. $comment['comment_content'] .'</div>
            </div>
            <div class="d-flex ms-3 mt-2">
                <div class="w-50 d-flex align-items-center comment-click">
                    <i data-post-id="'.$_POST['postID'].'" data-comment-id="'.$comment['comment_id'].'" class="fa-regular fa-comment inside-comment comment" style="color: #979797"> </i
                    ><span class="like-comment ms-1">'.globalInnerCommentCount($comment['comment_id']).'</span>
                </div>
                <div class="w-50 d-flex align-items-center comment-click">
                    <i data-comment-id="'.$comment['comment_id'].'"  class=" '.(in_array($comment['comment_id'] , $commentlikearray) ? 'fa-solid' : 'fa-regular').' fa-heart comment-like like" style="color: #979797"> </i
                    ><span  class=" like-comment ms-1">'.globalCommentLikesCount($comment['comment_id']).'</span>
                </div>
            </div>
            </div>  
        </div>';
        foreach($comments as $innercomment){
            if($innercomment['parent_comment_id'] == $comment['comment_id']){
                echo '<div data-post-id="'.$_POST['postID'].'" data-comment-id="'.$comment['comment_id'].'" class="show-more"><span  class="show-more-color">Show replies</span></div>';
                break;
            }
        }
        echo '</div>';
    }
    }?>
</div>