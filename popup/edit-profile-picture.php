<?php

    $fileInfo = $_FILES['image'];

    $blobData = file_get_contents($fileInfo['tmp_name']);
    $mimeType = $fileInfo['type'];
    $base64Data = base64_encode($blobData);
    $dataUri = 'data:' . $mimeType . ';base64,' . $base64Data;

?>

<div class="m-3">
    <div class="d-flex mb-3">
      <div
        id="profile-cross-button"
        class="me-3 d-flex justify-content-center align-items-center profile-picture-cross-button">
        &#10006;
      </div>
      <div class="d-flex justify-content-center align-items-center">
        Edit profile Picture
      </div>
      <div class="ms-auto">
        <button class="btn profile-picture-save-button" type="submit">Save</button>
      </div>
    </div>
    <div class="d-flex justify-content-center">
    <div class="profile-picture-crop ">
        <img class="profile-picture-edits" src="<?= $dataUri ?>" alt="">
    </div>
    </div>
</div>