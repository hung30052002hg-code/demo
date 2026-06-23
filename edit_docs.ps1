$ErrorActionPreference = "Stop"
try {
    $word = New-Object -ComObject Word.Application
    $word.Visible = $false

    $m1 = "CAAACAAAAAACBCBBDCBCACAACACABDCDCCBAAAACCAAACBCBADBBCADDDDACDABCCDADCBACBCBCBABABBDACA"
    $m2 = "CCBCDBCBDDACBCAAABDADDDDCBADACBDADDBCDCCDABDCDBDDBCDDCAADBABBBDACCBAAC"
    $m3 = "BCCBBBAAADBBADCBDADABACACDCABBACDACCBCADDBAAAADBCACBADCBDBDBDCADCBCADA"
    $m4 = "CBBDCBCBDBCCCBDCCCCADDDDBDBDBCBDDDCADCBACABAADAADCBBCBBDBBBADBDAADCCAC"
    $m5 = "BDBDDACCABAABBBAAADBBCBCABBDCCACABADDDCCACBACBCCDDBBDCCAABDADDAABBBCABBABACCBBBAAADABC"
    $m6 = "BBCBBCBBCBCBBBBBACBBBBCABCBBBBACABABABABBBBBBCAABBBBAAAAAAAAAAAAAAAAAAAAAAA"
    $answers = $m1 + $m2 + $m3 + $m4 + $m5 + $m6

    $sourceFile = (Get-ChildItem "D:\bai wo\*CN*.docx" | Where-Object { $_.Name -notmatch "Hoan_Thanh" }).FullName
    $targetFile = "D:\bai wo\De_cuong_on_tap_CN_so_Hoan_Thanh.docx"

    Write-Host "Opening document... $sourceFile"
    $doc = $word.Documents.Open($sourceFile)

    $find = $doc.Content.Find
    $find.ClearFormatting()
    
    # "Đáp án"
    $findText = [char]272 + "áp " + [char]225 + "n"
    $find.Text = $findText

    $i = 0
    while ($find.Execute() -and $i -lt $answers.Length) {
        $ans = $answers[$i]
        $doc.Range($find.Parent.Start, $find.Parent.End).Text = $findText + ": " + $ans
        $find.Parent.Start = $find.Parent.End
        $i++
    }
    Write-Host "Replaced $i answers"

    $doc.SaveAs([ref]$targetFile, [ref]16)
    $doc.Close([ref]$false)

    # Edit Ôn tập.docx
    $sourceFile2 = (Get-ChildItem "D:\bai wo\*.docx" | Where-Object { $_.Name -notmatch "CN" -and $_.Name -notmatch "Hoan_Thanh" }).FullName
    $targetFile2 = "D:\bai wo\On_tap_Hoan_Thanh.docx"

    Write-Host "Opening essay document... $sourceFile2"
    $doc2 = $word.Documents.Open($sourceFile2)
    $range = $doc2.Range()
    $range.Collapse(0) # wdCollapseEnd
    $range.InsertBreak(7) # wdPageBreak
    $text = [System.IO.File]::ReadAllText("C:\Users\Admin\.gemini\antigravity\brain\bf00db81-0246-4087-9f13-237d556cc9a0\Dap_an_tu_luan.md", [System.Text.Encoding]::UTF8)
    $range.InsertAfter($text)

    $doc2.SaveAs([ref]$targetFile2, [ref]16)
    $doc2.Close([ref]$false)
} finally {
    if ($word) {
        $word.Quit()
        [System.Runtime.InteropServices.Marshal]::ReleaseComObject($word) | Out-Null
    }
}
Write-Host "Done"
