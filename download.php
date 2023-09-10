<?php
$imageFile = __DIR__ . '/output/' . $_GET['genFile'];

// Set the appropriate headers for a file download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($imageFile) . '"');


header('Content-Length: ' . filesize($imageFile));

// Output the image file contents
readfile($imageFile);