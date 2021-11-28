<?php
include('../headers.php');
session_start();
session_destroy();
exit('Logged out');
