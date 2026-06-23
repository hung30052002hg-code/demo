<?php
$text = file_get_contents('c:\xampp\htdocs\Shoptrasua\cn_so.txt');
echo "Count: " . substr_count($text, 'Đáp án');
