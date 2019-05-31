Sub pAccessFileMaker()


' ----------------------------------------------------------------------
' Delete the starting lines if there is no tformNo set then end the loop
' ----------------------------------------------------------------------
     Dim i As Long 'Counter variable for looping this function
     Dim rowsDeletedTotal As Long 'Count total deleted
     
     i = 2 ' start at row 2 so you can skip the header row
     rowsDeletedTotal = 0
     
     Do Until Cells(i, 2) <> ""
         If Cells(i, 2) = "" Then
             MsgBox "[ID: " & Cells(i, 1) & ", Tform品番:  " & Cells(i, 2) & " ] 削除しました! 理由：Tform品番なし"
             Rows(i).Delete
             rowsDeletedTotal = rowsDeletedTotal + 1
         End If
     Loop
' ----------------------------------------------------------------------
    

    'Uncomment the next line to speed up the code
    Application.ScreenUpdating = False

    Dim lastRow As Long 'Last active row in named column
    Dim r As Long 'Counter variable for looping
    Dim NextNonBlankRow As Long 'Counter for next blank row number
    Dim CopyRow As Long
    Dim TestString 'String value in test cell


    lastRow = ActiveSheet.Cells(Rows.Count, 2).End(xlUp).Row

    For r = 1 To lastRow 'Starting at row 1 assumes you DO NOT have a header row, change if needed
        If Cells(r, 2) <> "" Then 'Check to see if Col A is populated

             'Find the next populated cell in Col A
            NextNonBlankRow = r + 1
            Do Until Cells(NextNonBlankRow, 1) <> "" Or NextNonBlankRow = lastRow + 1
                NextNonBlankRow = NextNonBlankRow + 1
            Loop

             'Copy contents of col B for rows with col A blank into previous row
            For CopyRow = r To NextNonBlankRow - 1
                If CopyRow <> r Then
                    Cells(r, 11) = Cells(r, 11) & ", " & Cells(CopyRow, 11)
                    Cells(r, 10) = Cells(r, 10) & ", " & Cells(CopyRow, 10)
                    Cells(CopyRow, 11).Clear
                End If
            Next CopyRow
        End If

        If r <> lastRow Then
            r = NextNonBlankRow - 1 'Move to next populated col A cell (subtracts 1 to allow for loop to add one)
        End If

    Next r

     'Delete blank rows
     'Uncomment the next seven lines to delete the blank rows

     r = lastRow
     Do Until r = 1
         If Cells(r, 1) = "" Then
             Rows(r).Delete
         End If
         r = r - 1
     Loop

' ----------------------------------------------------------------------------------

' FINAL CLEANUP
' UsedRange property to find the last used row number in a worksheet
' SELECT and delete first row

Rows("1:1").Select
Selection.Delete Shift:=xlUp

' INSERT black column into A and fill with 0
Columns("A:A").Select
Selection.Insert Shift:=xlToRight, CopyOrigin:=xlFormatFromLeftOrAbove
Range("A1").Select
ActiveCell.FormulaR1C1 = "0"
Selection.Copy

Dim lastRow2 As Long

lastRow2 = ActiveSheet.UsedRange.Rows(ActiveSheet.UsedRange.Rows.Count).Row

Range("A1:A" & lastRow2).Select
ActiveSheet.Paste

Application.ScreenUpdating = True

MsgBox " ** Finished ** " & vbNewLine & "追加: " & Range("A" & Rows.Count).End(xlUp).Row & vbNewLine & "削除: " & rowsDeletedTotal



End Sub


