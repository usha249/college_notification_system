<?php
if(!isset($_GET['f'])) exit('No file');
$file = basename($_GET['f']);
$path = __DIR__ . '/uploads/' . $file;
if(!file_exists($path)) exit('File not found');
$mime = mime_content_type($path);
header('Content-Description: File Transfer');
header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Length: ' . filesize($path));
readfile($path);
exit;
?>