<?php

require_once('../assests/functions.php');


    $data = retriveCommentDetails($_POST['commentID']);



?>


<div class="flex-column ">
    <div class="col d-flex mx-3 mb-3">
      <div
        id="profile-cross-button"
        class="me-3 d-flex justify-content-center align-items-center profile-cross-button">
        &#10006;
      </div>
      <div class="d-flex justify-content-center align-items-center ms-auto">
        Drafts
      </div>
    </div>
    <div class="col">
         <div data-id="'.$account['username'].'" class="d-flex p-2 ">
            <div class="d-flex flex-column">
                <img class="feed-profile-picture" src="http://localhost/gesto/images/H_OYTLBB_400x400.jpg" alt="">
                <div class="d-flex justify-content-center h-100 my-2"><div class="line"></div></div>
            </div>
            <div>
                <div class="ms-3 d-flex">
                    <div><?= $data['username'] ?></div>
                    <div class="text-opacity">@<?=$data['username']?></div>
                </div>
                <div class="ms-3"><?= isset($data['post_content']) ? $data['post_content'] : $data['comment_content'] ?></div>
                <div class="ms-3 mt-2"><span class="text-opacity">Replying to @<?= $data['username'] ?></span></div>
            </div>
        </div>
    </div>
    <div class="col d-flex px-2">
        <div>
            <img
                class="feed-profile-picture"
                src="http://localhost/gesto/images/H_OYTLBB_400x400.jpg"
                alt="" />
        </div> 
        <div class="w-100 ">
        <form action="http://localhost/gesto/assests/actions.php" method="post" class="d-flex">
            <input type="hidden" name="post-comments-comment-id" value="<?= $data['comment_id'] ?>"/>
            <input type="hidden" name="post-comments-post-id" value="<?= $_POST['postID'] ?>"/>
            <textarea
                name="post_content"
                id="auto-expand-textarea"
                class="form-control feed-form-control ms-3 p-0"
                placeholder="Post your reply"></textarea>
            <button type="submit" class="btn custom-blue-button ms-2">Reply</button>
            </div>
        </form>
    </div>
</div>