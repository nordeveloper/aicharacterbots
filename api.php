<?php
require __DIR__ . '/system.php';
use classes\Character;
use classes\Chat;
use classes\User;

$chat = new Chat();
$chat->apiKey = $api_key;
$chat->char = $char['name'];

$userObj = new User();
$user = $userObj->auth_user();

if( isset($_REQUEST['msg']) ){   
    echo $chat->send($user['id'], $_REQUEST['msg']);
}

//get chat history
if ( !empty($_REQUEST['history']) ) {
    $history = $chat->get_history($user['id']);
    echo json_encode($history, JSON_UNESCAPED_UNICODE);
}


//delete chat history
if ( !empty($_REQUEST['delete']) ) {
    $chat->delete_history($user['id']);
    header("location: ".$_SERVER['HTTP_REFERER']."");
}


//save settings
if( !empty($_REQUEST['save']) && $_REQUEST['save']=='chat_settings' && !empty($_REQUEST['max_tokens']) && !empty($_REQUEST['temperature']) ){
    $request = $_REQUEST;
    $chat->save_settings($request);
    header("location:settings.php");
}


//get settings
if( !empty($_REQUEST['settings']) ){
    $chatParamsJson = $chat->get_settings();
    echo $chatParamsJson;
}


// get characters
if( !empty($_REQUEST['characters']) ) {
    $character = new Character();
    $arCharacters = $character->getCharacters();
    echo json_encode($arCharacters);
}

if( !empty($_REQUEST['character']) ) {
    $character = new Character();
    $arCharacter = $character->getCharacter($_REQUEST['character']);
    echo json_encode($arCharacter, JSON_UNESCAPED_UNICODE);
}


// save character
if( !empty($_REQUEST['save']) && $_REQUEST['save']=='character' && !empty($_REQUEST['char_name']) ){
    $char = new Character();
    $request = array_merge($_REQUEST, $_FILES);
    $char->save($request);
    header("location:character.php?char_name=".$request['char_name']);
}

if( !empty($_REQUEST['action']) && $_REQUEST['action']=='import' ){
    $char = new Character();
    $request = array_merge($_REQUEST, $_FILES);
    $char->import($request);
    header("location:character.php?char_name=".$request['char_name']);
}


// delete character
if(!empty($_REQUEST['remove']) && !empty($_REQUEST['char_name']) ){
    $character = new Character();
    $character->removeCharacter($_REQUEST['char_name']);    
    header("location:characters.php");
}