<?php
ob_start("ob_gzhandler");
ob_start("compress");
header("Content-type: text/css; charset: UTF-8");
header("Cache-Control: must-revalidate");
$off = 0; # Set to a reaonable value later, say 3600 (1 hr);
$exp = "Expires: " . gmdate("D, d M Y H:i:s", time() + $off) . " GMT";
header($exp);

function compress($buffer) {
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer); // remove comments
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer); // remove tabs, spaces, newlines, etc.
    $buffer = str_replace('{ ', '{', $buffer); // remove unnecessary spaces.
    $buffer = str_replace(' }', '}', $buffer);
    $buffer = str_replace('; ', ';', $buffer);
    $buffer = str_replace(', ', ',', $buffer);
    $buffer = str_replace(' {', '{', $buffer);
    $buffer = str_replace('} ', '}', $buffer);
    $buffer = str_replace(': ', ':', $buffer);
    $buffer = str_replace(' ,', ',', $buffer);
    $buffer = str_replace(' ;', ';', $buffer);
    return $buffer;
}

$rootpath = $_SERVER['DOCUMENT_ROOT'] . "/";
$file =  $rootpath.$_GET['file'];

echo file_get_contents($file);
?>