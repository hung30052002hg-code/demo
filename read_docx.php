<?php
function read_docx($filename){
    $striped_content = '';
    $content = '';

    if(!$filename || !file_exists($filename)) return "File $filename doesn't exist.";

    $zip = new ZipArchive;
    if ($zip->open($filename) === TRUE) {
        if (($index = $zip->locateName('word/document.xml')) !== false) {
            $data = $zip->getFromIndex($index);
            $zip->close();
            
            $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $data);
            $content = str_replace('</w:r></w:p>', "\n", $content);
            $striped_content = strip_tags($content);
            return $striped_content;
        }
        $zip->close();
    }
    return "Failed to open zip.";
}

$file1 = 'D:\bai wo\Đề cương ôn tập CN số.docx';
$file2 = 'D:\bai wo\Ôn tập.docx';

echo "--- " . basename($file1) . " ---\n";
$content1 = read_docx($file1);
echo substr($content1, 0, 5000) . "\n";
if (strlen($content1) > 5000) echo "... (truncated)\n";

echo "\n--- " . basename($file2) . " ---\n";
$content2 = read_docx($file2);
echo substr($content2, 0, 5000) . "\n";
if (strlen($content2) > 5000) echo "... (truncated)\n";
