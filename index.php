<?php

include "src/route.php";
include "src/doc.php";
include "src/ext.php";

ext_init();

$filepath = route_get_path();

if (file_exists($filepath)) {
    doc_render($filepath);
}
else {
    header("HTTP/1.0 404 Not Found");
}

?>