import os
import zipfile
import xml.etree.ElementTree as ET
import sys

def read_docx(path):
    text = ""
    try:
        with zipfile.ZipFile(path) as docx:
            xml_content = docx.read('word/document.xml')
            tree = ET.XML(xml_content)
            for paragraph in tree.iter('{http://schemas.openxmlformats.org/wordprocessingml/2006/main}p'):
                texts = [node.text for node in paragraph.iter('{http://schemas.openxmlformats.org/wordprocessingml/2006/main}t') if node.text]
                if texts:
                    text += ''.join(texts) + '\n'
                else:
                    text += '\n'
    except Exception as e:
        return f"Error reading {path}: {e}"
    return text

file1 = r"D:\bai wo\Đề cương ôn tập CN số.docx"
file2 = r"D:\bai wo\Ôn tập.docx"

print(f"--- {os.path.basename(file1)} ---")
content1 = read_docx(file1)
print(content1[:5000])
if len(content1) > 5000:
    print(f"... (truncated, total length {len(content1)})")

print(f"\n--- {os.path.basename(file2)} ---")
content2 = read_docx(file2)
print(content2[:5000])
if len(content2) > 5000:
    print(f"... (truncated, total length {len(content2)})")
