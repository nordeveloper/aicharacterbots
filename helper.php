<?php
function flush_messages($type=null){
    if( !empty($_SESSION['flush_message']) ){

        $types = [
            'errors',
            'success',
            'info'
        ];

        if( in_array($type, $types) ){
            $css = 'class="alert alert-'.$type.'"';
        }

        echo '<p '.$css.'>'.$_SESSION['flush_message'].'</p>';
        unset( $_SESSION['flush_message'] );
    }
}

function setCorsHeaders() {
    // Allow requests from any origin
    header("Access-Control-Allow-Origin: *");

    // Allow specific HTTP methods
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    // Allow specific headers
    header("Access-Control-Allow-Headers: Content-Type");

    // Set the maximum time for the preflight OPTIONS request
    header("Access-Control-Max-Age: 86400");

    // Allow credentials (e.g., cookies, authorization headers) to be sent in cross-origin requests
    header("Access-Control-Allow-Credentials: true");
}