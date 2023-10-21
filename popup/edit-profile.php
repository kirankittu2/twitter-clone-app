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

  $commaPos = strpos($image, ',');
  $base64Data = substr($image, $commaPos + 1);

?>




<div class="m-3">
  <form action="http://localhost/gesto/assests/actions.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="editprofile" />
    <input id="binarydataofimage" type="hidden" name="binarydataofimage" value="<?= isset($data['profile_pic']) ? base64_encode($data['profile_pic']) : $base64Data ?>">
    <input id="imagetype" type="hidden" name="imagetype" value="<?= isset($data['image_type']) ? $data['image_type'] : 'image/jpg' ?>">
    <div class="d-flex mb-5">
      <div
        id="profile-cross-button"
        class="me-3 d-flex justify-content-center align-items-center profile-cross-button">
        &#10006;
      </div>
      <div class="d-flex justify-content-center align-items-center">
        Edit profile
      </div>
      <div class="ms-auto">
        <button class="btn profile-save-button" type="submit">Save</button>
      </div>
    </div>
    <div class="mb-3 d-flex justify-content-center image-position">
      <label class="imagelabel" for="image"></label>
      <input type="file" class="imageinput" id="image" name="image" accept="image/*">
      <div class="profile-picture-editable">
      <img
        class="profile-picture-main"
        src="<?= $image ?> "
        alt="" />
      </div>
    </div>
    <div class="mb-3">
      <label for="exampleFormControlText1" class="form-label">Username</label>
      <input
        type="text"
        name="username"
        class="form-control"
        value = <?= $data['username'] ?>
        id="exampleFormControlText1" />
    </div>
    <div class="mb-3">
      <label for="exampleFormControlTextarea1" class="form-label">Bio</label>
      <textarea
        name="bio"
        class="form-control"
        rows="2"
        id="exampleFormControlTextarea1"><?= array_key_exists('bio', $data) ? $data['bio']: '' ?></textarea>
    </div>
  </form>
</div>
