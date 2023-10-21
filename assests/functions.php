<?php

require_once('config.php');



function validateRegistrationForm($formdata){


    $response = array();

    if(!$formdata['username']){
        $response['status'] = false;
        $response['msg'] = 'Please enter your Username';
        $response['field'] = 'username';
        return $response;
    }

    else if(!$formdata['email']){
        $response['status'] = false;
        $response['msg'] = 'Please enter your Email';
        $response['field'] = 'email';
        return $response;
    }

    else if(!$formdata['password']){
        $response['status'] = false;
        $response['msg'] = 'Please enter your Password';
        $response['field'] = 'password';
        return $response;
    } 

    else if(isEmailAlreadyRegistered($formdata['email'])){
        $response['status'] = false;
        $response['msg'] = 'Email Already Registered';
        $response['field'] = 'email';
        return $response;
    }

    else if(isUserNameAlreadyExist($formdata['username'])){
        $response['status'] = false;
        $response['msg'] = 'Username Already Exist';
        $response['field'] = 'username';
        return $response;
    }
    
    else {
        $response['status'] = true;
        return $response;
    }

}

function showError($field){

    if(isset($_SESSION['error'])){
        $error = $_SESSION['error'];
        
        if(strcmp($field, isset($error['field']) ? $error['field'] : '') === 0){
            ?>
                <div class="alert alert-dark" role="alert">
                    <?= $error['msg']?>
                </div>
            <?php

        }
    }

}


function isEmailAlreadyRegistered($email){

    global $db;

    $sql = 'SELECT COUNT(*) FROM users WHERE email = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    if($result > 0){
        return true;
    }else{
        return false;
    }

    $db = null;


}

function isUserNameAlreadyExist($username){

    global $db;

    $sql = 'SELECT COUNT(*) FROM users WHERE  username = :username';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":username" , $username , PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    if($result > 0){
        return true;
    }else{
        return false;
    }

    $db = null;


}

function createUser($userdata){
    global $db;

    $username =  $userdata['username'];
    $email =  $userdata['email'];
    $password = md5($userdata['password']);

    $sql = "INSERT INTO users(username,email,password) VALUES(:username , :email , :password)";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":password", $password, PDO::PARAM_STR);

    $stmt->execute();

    $db = null;
}

function verifyEmail($email){

    global $db;

    $sql = 'UPDATE users SET ac_status = :status WHERE email = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":status" , '1' , PDO::PARAM_STR);
    $stmt->bindParam(":email" , $email , PDO::PARAM_STR);
    $stmt->execute();

    $db = null;

}

function validateLoginForm($formdata){

    if(!$formdata['email']){
        $response['status'] = false;
        $response['msg'] = 'Please enter your Email';
        $response['field'] = 'email';
        return $response;
    }

    else if(!$formdata['login_password']){
        $response['status'] = false;
        $response['msg'] = 'Please enter your Password';
        $response['field'] = 'login_password';
        return $response;
    } 


    else{
        $response['status'] = true;
        return $response;
    }

}

function loginTheUser($formdata){
    $email = $formdata['email'];
    $password = md5($formdata['login_password']);

    global $db;

    $sql = 'SELECT COUNT(*) FROM users WHERE (username = :username OR email = :email) AND password = :password';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username' , $email , PDO::PARAM_STR);
    $stmt->bindParam(':email' , $email , PDO::PARAM_STR);
    $stmt->bindParam(':password' , $password , PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    if($result > 0){
        return true;
    }else{
        return false;
    }

}

function checkIfUserExists($formdata){

    $email = $formdata;

    global $db;

    $sql = 'SELECT COUNT(*) FROM users WHERE (username = :username OR email = :email)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username' , $email , PDO::PARAM_STR);
    $stmt->bindParam(':email' , $email , PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    if($result > 0){
        return true;
    }else{
        return false;
    }

}


function isUserRegisteredCorrectly($formdata){
    $email = $formdata['email'];

    global $db;

    $sql = 'SELECT ac_status FROM users WHERE (username = :username OR email = :email)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username' , $email , PDO::PARAM_STR);
    $stmt->bindParam(':email' , $email , PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($result['ac_status'] == 1){
        return true;
    }else{
        return false;
    }

    $db = null;


}

function retriveEmail($data){
    global $db;
    
    $sql = 'SELECT email FROM users WHERE (username = :username OR email = :email)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username' , $data ,  PDO::PARAM_STR);
    $stmt->bindParam(':email' , $data ,  PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['email'];
}

function newPassword($password){
      $email = $_SESSION['reset_email'];
      $newpassword = md5($password);
      global $db;

      $sql = 'UPDATE users SET password = :password WHERE email = :email';
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':password' , $newpassword , PDO::PARAM_STR);
      $stmt->bindParam(':email' , $email , PDO::PARAM_STR);
      $stmt->execute();

}

function retriveUserProfileData($followerID = ""){

    
    global $db;
    $gestoId =  $followerID ? $followerID : $_SESSION['gesto_id'];

    if(checkIfBioExist($gestoId)){

        $sql = 'SELECT users.username , user_biography.bio , user_biography.profile_pic , user_biography.image_type
                FROM users 
                INNER JOIN user_biography ON users.user_id = user_biography.user_id
                WHERE users.user_id = :id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id' , $gestoId , PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        
        return $result;

    }else{
        
        $sql = 'SELECT username FROM users WHERE user_id = :user_id';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':user_id' , $gestoId , PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        
        
        return $result;

    }


}

function retriveFollowandPostCount($followerID = ""){

    global $db;
    $gestoId =  $followerID ? $followerID :  $_SESSION['gesto_id'];

    $sql = 'SELECT COUNT(*) AS followCount 
            FROM user_followers
            WHERE user_id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id' , $gestoId , PDO::PARAM_INT);
    $stmt->execute();
    $followerCount = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql2 = 'SELECT COUNT(*) AS postCount
            FROM user_posts
            WHERE user_id = :id';
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindParam(':id' , $gestoId , PDO::PARAM_INT);
    $stmt2->execute();
    $postCount = $stmt2->fetch(PDO::FETCH_ASSOC);

    $sql3 = 'SELECT COUNT(*) AS followingCount
            FROM user_followers
            WHERE follower_id = :id';
    $stmt3 = $db->prepare($sql3);
    $stmt3->bindParam(':id' , $gestoId , PDO::PARAM_INT);
    $stmt3->execute();
    $followingCount = $stmt3->fetch(PDO::FETCH_ASSOC);

    


        
    return array(
    $followerCount,
    $postCount,
    $followingCount
    );
}



function checkIfBioExist($userdata = ""){
    global $db;

    $user_id = $userdata ? $userdata : $_SESSION['gesto_id'];


    $sql = 'SELECT COUNT(*) FROM user_biography WHERE user_id = :user_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $user_id , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    if($result > 0){
        return true;
    }else{
        return false;
    }


}

function validateEditProfileForm($formdata){

    $response = array();

    if(!$formdata['username']){
        $response['status'] = false;
        $response['msg'] = 'Please enter your Username';
        $response['field'] = 'username';
        return $response;
    }

    else{
        $response['status'] = true;
        return $response;
    }

}

function insertBioCheck($data){
    
   if(checkIfUserExists($data['username'])){
        if(checkIfUserAssociatedWithId($data['username'])){
            insertBio($data);
            header('location: http://localhost/gesto/'.$data['username'].'');
        }
   }else{
        insertBio($data);
        header('location: http://localhost/gesto/'.$data['username'].'');
   }
}

function updateBioCheck($data){
    if(checkIfUserExists($data['username'])){
        if(checkIfUserAssociatedWithId($data['username'])){
            updateBio($data);
            header('location: http://localhost/gesto/'.$data['username'].''); 
        }
    }else{
        updateBio($data);
        header('location: http://localhost/gesto/'.$data['username'].'');
    }
}

function updateBio($data){
    $binaryData = base64_decode($data['binarydataofimage']);
    global $db;

    $userdata = $_SESSION['gesto_id'];

    $sql = 'UPDATE users SET username = :username WHERE user_id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username' , $data['username'] , PDO::PARAM_STR);
    $stmt->bindParam(':id' , $userdata , PDO::PARAM_INT);
    $stmt->execute();

    $sql2 = 'UPDATE user_biography SET bio = :bio , profile_pic = :profile_pic , image_type = :image_type WHERE user_id = :id';
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindParam(':bio' , $data['bio'] , PDO::PARAM_STR);
    $stmt2->bindParam(':id' , $userdata , PDO::PARAM_INT);
    $stmt2->bindParam(':profile_pic' , $binaryData , PDO::PARAM_LOB);
    $stmt2->bindParam(':image_type' , $data['imagetype'] , PDO::PARAM_STR);
    $stmt2->execute();


}



function insertBio($data){
    $binaryData = base64_decode($data['binarydataofimage']);
    global $db;

    $userdata = $_SESSION['gesto_id'];

    $sql = 'UPDATE users SET username = :username WHERE user_id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username' , $data['username'] , PDO::PARAM_STR);
    $stmt->bindParam(':id' , $userdata , PDO::PARAM_INT);
    $stmt->execute();

    $sql2 = 'INSERT INTO user_biography(user_id,bio,profile_pic,image_type) VALUES(:user_id , :bio, :profile_pic, :image_type)';
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindParam(':user_id' , $userdata , PDO::PARAM_INT);
    $stmt2->bindParam(':bio' , $data['bio'] , PDO::PARAM_STR);
    $stmt2->bindParam(':profile_pic' , $binaryData , PDO::PARAM_LOB);
    $stmt2->bindParam(':image_type' , $data['imagetype'] , PDO::PARAM_STR);
    $stmt2->execute();

}

function createPost($data){

    global $db;

    $userdata = $_SESSION['gesto_id'];

    $sql = 'INSERT INTO user_posts(user_id,post_content) VALUES(:user_id  ,:post_content)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userdata , PDO::PARAM_INT);
    $stmt->bindParam(':post_content' , $data['post_content'] , PDO::PARAM_STR);
    $stmt->execute();

    
}

function retrivePosts(){

    if(checkIfBioExist()){

    global $db;
    $gestoId = $_SESSION['gesto_id'];

    $sql = 'SELECT users.username , user_posts.post_content , user_posts.post_id , user_biography.profile_pic , user_biography.image_type
            FROM users 
            INNER JOIN user_posts ON users.user_id = user_posts.user_id 
            INNER JOIN user_biography ON users.user_id = user_biography.user_id 
            WHERE users.user_id = :id 
            ORDER BY user_posts.post_id DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id' , $gestoId , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;

    }else {

    global $db;
    $gestoId = $_SESSION['gesto_id'];

    $sql = 'SELECT users.username , user_posts.post_content , user_posts.post_id 
            FROM users 
            INNER JOIN user_posts ON users.user_id = user_posts.user_id 
            WHERE users.user_id = :id 
            ORDER BY user_posts.post_id DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id' , $gestoId , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
    }

}

function retrievFeedPosts(){
    global $db;
    $gestoId = $_SESSION['gesto_id'];

    $sql = 'SELECT users.username , user_posts.post_content , user_posts.post_id , user_biography.profile_pic , user_biography.image_type
            FROM users 
            INNER JOIN user_posts ON users.user_id = user_posts.user_id 
            INNER JOIN user_biography ON users.user_id = user_biography.user_id 
            WHERE users.user_id = :user_id OR users.user_id IN (SELECT follower_id FROM user_followers WHERE user_id = :user_id)
            ORDER BY user_posts.post_id DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $gestoId , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function checkIfUserAssociatedWithId($username){
    global $db;

    $userdata = $_SESSION['gesto_id'];

    $sql = 'SELECT COUNT(*) FROM users WHERE user_id = :id AND username = :username';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id' ,  $userdata , PDO::PARAM_INT);
    $stmt->bindParam(':username' , $username , PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    if($result > 0){
        return true;
    }else{
        return false;
    }

}

function retriveIDFromUsername(){


    global $db;

    $usernameOremail = $_SESSION['userdata']['email'];

    $sql = 'SELECT user_id , username FROM users WHERE username = :username OR email = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username' , $usernameOremail , PDO::PARAM_STR);
    $stmt->bindParam(':email' , $usernameOremail , PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    $_SESSION['gesto_id'] = $result['user_id'];

    return $result;

}

function retriveAccountsToFollow(){

    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'SELECT users.user_id , users.username , user_biography.profile_pic , user_biography.image_type
            FROM users 
            INNER JOIN user_biography ON users.user_id = user_biography.user_id
            WHERE users.user_id != :id 
            ORDER BY RAND() 
            LIMIT 3';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id' ,  $userId , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;

}



function alreadyFollowed($followerID){
   global $db;
   $userId = $_SESSION['gesto_id'];


   $sql = 'SELECT * FROM user_followers WHERE user_id = :user_id AND follower_id = :follower_id';
   $stmt = $db->prepare($sql);
   $stmt->bindParam(':user_id' , $userId ,  PDO::PARAM_INT);
   $stmt->bindParam(':follower_id' , $followerID , PDO::PARAM_INT);
   $stmt->execute();
   $result = $stmt->fetchColumn();

    if($result > 0){
        return true;
    }else{
        return false;
    }

}

function unfollow($followerID){
    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'DELETE FROM user_followers WHERE user_id = :user_id AND follower_id = :follower_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId ,  PDO::PARAM_INT);
    $stmt->bindParam(':follower_id' , $followerID , PDO::PARAM_INT);
    $stmt->execute();

}

function follow($followerID){
    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'INSERT INTO user_followers(user_id , follower_id) VALUES(:user_id , :follower_id)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId ,  PDO::PARAM_INT);
    $stmt->bindParam(':follower_id' , $followerID , PDO::PARAM_INT);
    $stmt->execute();
}

function getUsernameUsingIDForProfile(){
    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'SELECT * FROM users WHERE user_id = :user_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId ,  PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function retriveFollowerDetails($followerusername){
    

    $id = retriveFollowerID($followerusername);

    $counts = retriveFollowandPostCount($id['user_id']);
    $usernameandbio  = retriveUserProfileData($id['user_id']);
    $follow = alreadyFollowed($id['user_id']);
    

    return array(
        $counts ,
        $usernameandbio,
        $id,
        $follow
    );

}

function retriveFollowerPosts($followerusername){
    global $db;

    $id = retriveFollowerID($followerusername);


    $sql = 'SELECT users.username , user_posts.post_content , user_posts.post_id , user_biography.profile_pic , user_biography.image_type
    FROM users 
    INNER JOIN user_posts ON users.user_id = user_posts.user_id 
    INNER JOIN user_biography ON users.user_id = user_biography.user_id
    WHERE users.user_id = :id 
    ORDER BY user_posts.post_id DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id' ,  $id['user_id']  , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;


}

function retriveFollowerID($followerusername){

    global $db;
    
    $sql = 'SELECT user_id FROM users WHERE username = :username';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username' , $followerusername ,  PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}


function logout(){
    unset($_SESSION['userdata']);
    unset($_SESSION['gesto_id']);
}

function likeThePost($postID){
    global $db;
    $userId = $_SESSION['gesto_id'];


    $sql = 'INSERT INTO user_likes(user_id , post_id) VALUES(:user_id , :post_id)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId , PDO::PARAM_INT);
    $stmt->bindParam(':post_id' , $postID , PDO::PARAM_INT);
    $stmt->execute();
}

function likeTheComment($commentID){
    global $db;
    $userId = $_SESSION['gesto_id'];


    $sql = 'INSERT INTO user_comment_likes(user_id , comment_id) VALUES(:user_id , :comment_id)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId , PDO::PARAM_INT);
    $stmt->bindParam(':comment_id' , $commentID , PDO::PARAM_INT);
    $stmt->execute();
}

function unlikeThePost($postID){
    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'DELETE FROM user_likes WHERE post_id = :post_id AND user_id = :user_id' ;
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':post_id' , $postID , PDO::PARAM_INT);
    $stmt->bindParam(':user_id' , $userId , PDO::PARAM_INT);
    $stmt->execute();
}


function unlikeTheComment($commentID){
    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'DELETE FROM user_comment_likes WHERE comment_id = :comment_id AND user_id = :user_id' ;
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':comment_id' , $commentID , PDO::PARAM_INT);
    $stmt->bindParam(':user_id' , $userId , PDO::PARAM_INT);
    $stmt->execute();
}


function retriveLikeIds(){
    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'SELECT post_id FROM user_likes WHERE user_id = :user_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function retriveCommentIds(){
    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'SELECT comment_id FROM user_comment_likes WHERE user_id = :user_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function retriveGlobalLikes($id){
    global $db;

    $sql = 'SELECT post_id , COUNT(*) AS likes_count FROM user_likes WHERE post_id = :post_id GROUP BY post_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':post_id' , $id , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function retriveGlobalCommentLikes($id){
    global $db;

    $sql = 'SELECT comment_id , COUNT(*) AS comment_likes_count FROM user_comment_likes WHERE comment_id = :comment_id GROUP BY comment_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':comment_id' , $id , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function retriveGlobalComments($id){
    global $db;

    $sql = 'SELECT post_id , COUNT(*) AS comment_count FROM user_comments WHERE post_id = :post_id GROUP BY post_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':post_id' , $id , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;

}

function retriveInnerCommentCount($id){
    global $db;

    $sql = 'SELECT parent_comment_id , COUNT(*) AS inner_comment_count FROM user_comments WHERE parent_comment_id = :parent_comment_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':parent_comment_id' , $id , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function globalInnerCommentCount($id){
    $globalinnercomment = retriveInnerCommentCount($id);
    if($globalinnercomment){
         return $globalinnercomment['inner_comment_count'];
    }else{
         return '';
    }
    
}


function globalLikesCount($id){
    $globallikes = retriveGlobalLikes($id);

    if($globallikes){
         return $globallikes['likes_count'];
    }else{
         return '';
    }
    
}

function globalCommentLikesCount($id){    
    $globalCommentlikes = retriveGlobalCommentLikes($id);
    if($globalCommentlikes){
         return $globalCommentlikes['comment_likes_count'];
    }else{
         return '';
    }
    
}

function globalCommentsCount($id){
    $globalcomments = retriveGlobalComments($id);

    if($globalcomments){
         return $globalcomments['comment_count'];
    }else{
         return '';
    }

}

function retrieveIndividualPostContent($postid){
    
    $postcomments = retriveCommentsOfPosts($postid);
    $allcomments = retriveAllCommentsExceptNotNull($postid);

    $result2 = postContent($postid);

    return array(
        $result2,
        $postcomments,
        $allcomments
    ); 

}

function postContent($postid){
    global $db;

    $userid = retrieveUseridUsingPostid($postid);

    $sql2 = 'SELECT users.username , user_posts.post_content , user_posts.created_on , user_biography.profile_pic , user_biography.image_type
             FROM users 
             INNER JOIN user_posts ON users.user_id = user_posts.user_id 
             INNER JOIN user_biography ON users.user_id = user_biography.user_id
             WHERE user_posts.user_id = :user_id AND user_posts.post_id = :post_id';
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindParam(':user_id' , $userid['user_id'] , PDO::PARAM_INT);
    $stmt2->bindParam(':post_id' , $postid , PDO::PARAM_INT);
    $stmt2->execute();
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    return $result2;
}

function retriveCommentsOfPosts($postID){
    global $db;

    $sql = 'SELECT  users.username , user_comments.comment_id,  user_comments.comment_content , user_comments.created_on , user_biography.profile_pic , user_biography.image_type
            FROM users 
            INNER JOIN user_comments ON users.user_id = user_comments.user_id 
            INNER JOIN user_biography ON users.user_id = user_biography.user_id
            WHERE user_comments.post_id = :post_id AND parent_comment_id IS NULL';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':post_id' , $postID , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function retriveAllCommentsExceptNotNull($postID){
    global $db;

    $sql3 = 'SELECT user_comments.comment_id , user_comments.parent_comment_id , users.username , user_comments.comment_id,  user_comments.comment_content , user_comments.created_on FROM users INNER JOIN user_comments ON users.user_id = user_comments.user_id WHERE user_comments.post_id = :post_id AND parent_comment_id IS NOT NULL';
    $stmt3 = $db->prepare($sql3);
    $stmt3->bindParam(':post_id' , $postID , PDO::PARAM_INT);
    $stmt3->execute();
    $result = $stmt3->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function retriveAllComments($postID){
    global $db;

    $sql3 = 'SELECT user_comments.comment_id , user_comments.parent_comment_id , users.username , user_comments.comment_id,  user_comments.comment_content , user_comments.created_on , user_biography.profile_pic , user_biography.image_type
             FROM users 
             INNER JOIN user_comments ON users.user_id = user_comments.user_id 
             INNER JOIN user_biography ON users.user_id = user_biography.user_id
             WHERE user_comments.post_id = :post_id';
    $stmt3 = $db->prepare($sql3);
    $stmt3->bindParam(':post_id' , $postID , PDO::PARAM_INT);
    $stmt3->execute();
    $result = $stmt3->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function retrieveUseridUsingPostid($postid){
    global $db;

    $sql = 'SELECT user_id FROM user_posts WHERE post_id = :post_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':post_id' , $postid , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function createComment($data){
    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'INSERT INTO user_comments(user_id , post_id , comment_content) VALUES(:user_id , :post_id , :content)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId , PDO::PARAM_INT);
    $stmt->bindParam(':post_id' , $data['createcomment'] , PDO::PARAM_INT);
    $stmt->bindParam(':content' , $data['post_content'] , PDO::PARAM_STR);
    $stmt->execute();
}

function createCommentInner($data){
    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'INSERT INTO user_comments(user_id , post_id , parent_comment_id , comment_content) VALUES(:user_id , :post_id  , :parent_comment_id , :content)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId , PDO::PARAM_INT);
    $stmt->bindParam(':post_id' , $data['createcommentinner'] , PDO::PARAM_INT);
    $stmt->bindParam(':parent_comment_id' , $data['parentcommentid'] , PDO::PARAM_INT);
    $stmt->bindParam(':content' , $data['post_content'] , PDO::PARAM_STR);
    $stmt->execute();
}

function createNestedCommentts($data){
    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'INSERT INTO user_comments(user_id , post_id , parent_comment_id ,  comment_content) VALUES(:user_id , :post_id , :parent_comment_id , :content)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId , PDO::PARAM_INT);
    $stmt->bindParam(':post_id' , $data['post-comments-post-id'] , PDO::PARAM_INT);
    $stmt->bindParam(':parent_comment_id' , $data['post-comments-comment-id'] , PDO::PARAM_INT);
    $stmt->bindParam(':content' , $data['post_content'] , PDO::PARAM_STR);
    $stmt->execute();

}
function retriveCommentDetails($commentID){
    global $db;

    $sql = 'SELECT  users.username , user_comments.comment_id,  user_comments.comment_content , user_comments.created_on FROM users INNER JOIN user_comments ON users.user_id = user_comments.user_id WHERE user_comments.comment_id = :comment_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':comment_id' , $commentID , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function defaultProfilePicSetup(){
    $imageFile = 'http://localhost/gesto/images/profile-pic.jpg';
    $imageData = file_get_contents($imageFile);
    $base64Image = base64_encode($imageData);
    $image = 'data:image/jpg;base64,' . $base64Image;

    return $image;

}

function createMessageRelationship($followerID){
    global $db;
    $userId = $_SESSION['gesto_id'];

    $sql = 'INSERT INTO user_conversations(user1,user2) VALUES(:user_id, :follower_id)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId , PDO::PARAM_INT);
    $stmt->bindParam(':follower_id' , $followerID , PDO::PARAM_INT);
    $stmt->execute();
}

function alreadyHadRelationship($followerID){
    global $db;
    $userId = $_SESSION['gesto_id'];


    $sql = 'SELECT * FROM user_conversations WHERE user1 = :user_id OR user1 = :follower_id  AND user2 = :follower_id OR user2 = :user_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id' , $userId ,  PDO::PARAM_INT);
    $stmt->bindParam(':follower_id' , $followerID , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchColumn();

    if($result > 0){
        return true;
    }else{
        return false;
    }
}

function fetchAllMessages(){
    
}

function testing(){
    
}


?>