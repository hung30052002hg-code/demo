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

    $i = 0
    foreach ($p in $doc.Paragraphs) {
        $txt = $p.Range.Text
        if ($txt.Length -ge 6 -and $txt.Length -lt 20 -and $txt[0] -eq [char]272 -and $txt -match "p") {
            $p.Range.Text = ([char]272 + "áp " + [char]225 + "n: " + $answers[$i] + "`r")
            $i++
            if ($i -ge $answers.Length) { break }
        }
    }
    Write-Host "Replaced $i answers"

    $doc.SaveAs([ref]$targetFile, [ref]16)
    $doc.Close([ref]$false)

} finally {
    if ($word) {
        $word.Quit()
        [System.Runtime.InteropServices.Marshal]::ReleaseComObject($word) | Out-Null
    }
}
Write-Host "Done"
