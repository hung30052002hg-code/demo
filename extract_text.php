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

file_put_contents('c:\xampp\htdocs\Shoptrasua\cn_so.txt', read_docx($file1));
file_put_contents('c:\xampp\htdocs\Shoptrasua\on_tap.txt', read_docx($file2));
echo "Done extracting to text files.";
