<?php

$route_html_files = array("php", "htm", "html");

function route_get_filename($url) {
    return "site/".$url;
}
function route_find_index($path) {
    global $route_html_files;

    if (!is_dir($path) && $path) {
        $path = $path."/";
    }

    foreach ($route_html_files as $route_html_file) {
        $c_path = $path."index.".$route_html_file;
        if (file_exists(route_get_filename($c_path))) {
            return $c_path;
        }
    }
}

function route_get_path()
{
    global $route_html_files;

    $path = $_SERVER['REQUEST_URI'];
    $path_ext = pathinfo($path, PATHINFO_EXTENSION);

    $file_found = false;

    if (!$path_ext) {
        $path = route_find_index($path);

        if ($path) {
            $file_found = true;
            $path_ext = pathinfo($path, PATHINFO_EXTENSION);
        }
    } 
    else {
        $file_found = file_exists(route_get_filename($path));
    } 

    return array(
        "path" => route_get_filename($path),
        "isHtml" => in_array($path_ext, $route_html_files),
        "found" => $file_found
    );
}

?>