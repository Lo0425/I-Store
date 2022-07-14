<?php 

//to access session variabvle and session methods you need to session_start()
session_start();

//delete all session variable
session_unset();

//destroy all data registered in the session
// session_destroy();

header("Location: /");
?>