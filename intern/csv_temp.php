<?php
// Validate user authentication and authorization before allowing download

$file = 'exam_questions.csv';

if (file_exists($file)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Length: ' . filesize($file));
    readfile($file);
} else {
    echo "File not found.";
}
?>
