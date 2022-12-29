<?php

function url_for($script_path)
{
    // add the leading '/' if not present
    if ($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
}

function u($string="")
{
    return urlencode($string);
}

function raw_u($string="")
{
    return rawurlencode($string);
}

function h($string="")
{
    return htmlspecialchars($string);
}

function hd($string="")
{
    return htmlspecialchars_decode($string);
}

function h_decode($string="")
{
    return htmlspecialchars_decode($string);
}

function error_404()
{
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit();
}

function error_500()
{
    header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
    exit();
}

function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}

function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function is_empty($array)
{
    if (count($array) == 0) {
        return true;
    } else {
        return false;
    }
}

// PHP on Windows does not have a money_format() function.
// This is a super-simple replacement.
if (!function_exists('money_format')) {
    function money_format($format, $number)
    {
        return '$' . number_format($number, 2);
    }
}

function reArrayFiles($file_post)
{
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}

function getURL()
{
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return $url; // Outputs: Full URL
}

function first_position($array)
{
    foreach ($array as $i => $post) {
        if ($post->position == 1) {
            return $i;
        }
    }
}

function duration($seconds)
{
    $h = floor($seconds / 3600);
    $remainder = $seconds - $h * 3600;

    $m = floor($remainder / 60);
    $remainder = $remainder - $m * 60;

    $s = round($remainder, 3);
    $s = number_format($s, 3, '.', '');

    $h = str_pad($h, 2, '0', STR_PAD_LEFT);
    $m = str_pad($m, 2, '0', STR_PAD_LEFT);
    $s = str_pad($s, 6, '0', STR_PAD_LEFT);

    $duration = $h . ":" . $m . ":" . $s;

    return $duration;
}
