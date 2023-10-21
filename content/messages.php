<?php 
    
    require_once('../assests/functions.php');
    require_once('../assests/config.php');

    if(isset($_POST['msgFollowerID']) && $_POST['msgFollowerID'] != "" ){
        $id = $_POST['msgFollowerID'];
    }
?>

<div class="col message-container p-0">
    <div id="real-message" class="col messages"></div>
    <div class="col send-message-input-container py-2 px-3 d-flex">
        <input id="userID" type="hidden" value="<?=$_SESSION['gesto_id']?>">
        <input type="text" id="message-to-be-sent" class="form-control gesto-search" placeholder="Start a new message">
        <button id="send-message-button" class="btn">Send</button>
    </div>
</div>

