<?php

include "src/route.php";
include "src/doc.php";
include "src/ext.php";

ext_init();

$filepath_info = route_get_path();

if ($filepath_info["found"]) {
    if ($filepath_info["isHtml"]) {
        doc_render($filepath_info["path"]);
    }
    else {
        route_content_type();
        include $filepath_info["path"];
    }
}
else {
    header("HTTP/1.0 404 Not Found");
}

?>