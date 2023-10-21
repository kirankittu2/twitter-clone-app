<?php

require_once('functions.php');

require_once('config.php');

require_once('send-code.php');


if(isset($_POST['register'])){
  $response =  validateRegistrationForm($_POST);
  if($response['status']){
     createUser($_POST);
     $_SESSION['userdata'] = $_POST;
     unset($_SESSION['error']);
     $code = rand(111111,999999);
     $_SESSION['code'] = $code;
     sendCode($_SESSION['userdata']['email'] , 'Your Verification Code' , $code);
     header('location: http://localhost/gesto/verify-email');
  }else{
     $_SESSION['error'] = $response;
     header('location: http://localhost/gesto/registration');
  }
}

if(isset($_POST['verify_email'])){
   if($_SESSION['code'] == $_POST['verification_code']){  
      verifyEmail(retriveEmail($_SESSION['userdata']['email']));
      unset($_SESSION['error']);
      unset($_SESSION['code']);
      header('location: http://localhost/gesto/home');

   }else{
      $error['msg'] = 'Please enter the correct code ' . $_SESSION['error'] . '' ;
      $error['field'] = 'verification_code';
      $_SESSION['error'] = $error;
      header('location: http://localhost/gesto/verify-email');

   }
}

if(isset($_POST['login'])){
   $response = validateLoginForm($_POST);
   if($response['status']){
      if(loginTheUser($_POST)){
         $_SESSION['userdata'] = $_POST;
         if(isUserRegisteredCorrectly($_POST)){
            unset($_SESSION['error']);
            header('location: http://localhost/gesto/home');
         }else{
            $code = rand(111111,999999);
            $_SESSION['code'] = $code;  
            sendCode(retriveEmail($_POST['email']) , 'Verify Your Email' , $code);
            header('location: http://localhost/gesto/verify-email');
         }
        
      }else{
         $error['msg'] = 'Email doesnt exist please register' ;
         $error['field'] = 'email';
         $_SESSION['error'] = $error;
         header('location: http://localhost/gesto/login');
      }
   }else{
      $_SESSION['error'] = $response;
      header('location: http://localhost/gesto/login');
   }
}

if(isset($_POST['forgotpassword'])){
   if(!$_POST['email']){
      $error['msg'] = 'Please Enter Correct Email Address or Username';
      $error['field'] = 'email';
      $_SESSION['error'] = $error;
      header('location: http://localhost/gesto/forgot-password');
   }else{
      if(checkIfUserExists($_POST['email'])){
          $code = rand(111111,999999);
          $_SESSION['code'] = $code;  
          $reset_email = retriveEmail($_POST['email']);
          $_SESSION['reset_email'] = $reset_email;
          sendCode($reset_email , 'Reset Password OTP' , $code);
          header('location: http://localhost/gesto/reset-password');
      }else{
         $error['msg'] = 'Credentials does not match';
         $error['field'] = 'email';
         $_SESSION['error'] = $error;
         header('location: http://localhost/gesto/forgot-password');
      }
   }
}

if(isset($_POST['resetpassword'])){
   if($_POST['email']){
      if($_SESSION['code'] == $_POST['email']){
         header('location: http://localhost/gesto/forgot-password?reset');
      }
   }else{
      $error['msg'] = 'Enter correct otp';
      $error['field'] = 'email';
      $_SESSION['error'] = $error;
      header('location: http://localhost/gesto/reset-password');
   }
}

if(isset($_POST['newpassword'])){
   if($_POST['password']){
      newPassword($_POST['password']);
      header('location: http://localhost/gesto/login');
   }else{
      $error['msg'] = 'Enter your new password';
      $error['field'] = 'password';
      $_SESSION['error'] = $error;
      header('location: http://localhost/gesto/forgot-password');
   }
}

if(isset($_POST['editprofile'])){
   $response = validateEditProfileForm($_POST);
   if($response['status'] == true){
      if(checkIfUserExists($_SESSION['userdata']['email']) && checkIfBioExist()){
         updateBioCheck($_POST);
         $ud['email'] = $_POST['username'];
         $_SESSION['userdata'] = $ud;
      }else{
         insertBioCheck($_POST);
         $ud['email'] = $_POST['username'];
         $_SESSION['userdata'] = $ud;
      }
   }else{
     
   }
}

if(isset($_POST['createpost'])){
   if($_POST['post_content']){
     createPost($_POST); 
     header('location: http://localhost/gesto/home');
   }
}

if(isset($_POST['logout'])){
   logout();
  header('location: http://localhost/gesto/login');
}

if(isset($_POST['dataId'])){
   if(alreadyFollowed($_POST['dataId'])){
      unfollow($_POST['dataId']);
      echo 'Follow';
   }else{
      follow($_POST['dataId']);
      echo 'Following';
   }
}

if(isset($_POST['mainuserid'])){
   $result = getUsernameUsingIDForProfile();
   echo $result['username'];
}

if(isset($_POST['likepostid'])){
   likeThePost($_POST['likepostid']);
   echo 'liked';
}

if(isset($_POST['unlikepostid'])){
   unlikeThePost($_POST['unlikepostid']);
   echo 'unliked';
}

if(isset($_POST['likecommentid'])){
   likeTheComment($_POST['likecommentid']);
   echo 'liked';
}

if(isset($_POST['unlikecommentid'])){
   unlikeTheComment($_POST['unlikecommentid']);
   echo 'unliked';
}

if(isset($_POST['createcomment'])){
   createComment($_POST);
   header('location: http://localhost/gesto/home');
}

if(isset($_POST['createcommentinner'])){
   createCommentInner($_POST);
   header('location: http://localhost/gesto/home');
}

if(isset($_POST['post-comments-post-id'])){
   createNestedCommentts($_POST);
   header('location: http://localhost/gesto/home');
}

if(isset($_POST['messagefollowerID'])){
   if(!alreadyHadRelationship($_POST['messagefollowerID'])){
      createMessageRelationship($_POST['messagefollowerID']);
   }
}

?>