<?php

function route_get_path()
{
    $path = basename($_SERVER['REQUEST_URI']);

    if (!preg_match('/.(php|html)$/', $path)) {
        if ($path) {
            $path = $path."/index.php";
        }
        else {
            $path = "index.php";
        }
    }

    return "site/".$path;
}

?>