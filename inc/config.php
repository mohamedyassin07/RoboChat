<?php 

define('production', false  );

if(production ==  true){
    define('domain', 'devbx.udh.sa' );
}else {
    define('domain', 'robochat' );
}