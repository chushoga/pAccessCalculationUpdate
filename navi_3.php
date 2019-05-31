<?php 
//Navi Names
//----------------------
if ($languageChoice == '2'){
    $lan1 = "File";
    $lan1a = "New";
        $lan1aa = "Expense Record";
        $lan1ab = "Order Record";
    $lan1b = "Save";
    $lan1c = "Print";
    $lan1d = "Logout";
//----------------------
$lan2 = "Edit";
    $lan2a = "Export Excel";
    $lan2b = "Edit";
    $lan2d = "Duplicate Record";
//----------------------
/*
$lan3 = "Search";
    $lan3a = "Simple Search";
    $lan3b = "Date Search";
*/
//----------------------
$lan4 = "Programs";
    $lan4a = "Sale Price Settings";
    $lan4b = "Tform Project";
    $lan4c = "Expense Calculation";
    $lan4d = "Order Calculation";
//----------------------
$lan5 = "View";
    $lan5a = "Single";
    $lan5b = "All";
    $lan5c = "Toolbar";
    $lan5d = "History";
	$lan5e = "Simple";
	$lan5f = "SuperSimple";
//----------------------
$lan6 = "Help";
    $lan6a = "About pAccess";
    $lan6b = "Manual";
    $lan6c = "Language";
        $lan6ca = "Japanese";
        $lan6cb = "English";
//----------------------
} else {
   
    $lan1 = "ファイル";
    $lan1a = "新規";
        $lan1aa = "オーダー別経費計算表";
        $lan1ab = "オーダー別単価計算表";
    $lan1b = "保存";
    $lan1c = "印刷";
    $lan1d = "ログアウト";
//----------------------
$lan2 = "修正";
    $lan2a = "エクスポート Excel";
	$lan2a2 = "エクスポート Excel(短い形式)";
    $lan2b = "修正";
    $lan2d = "レコード コーピー";
//----------------------
$lan3 = "検索";
    $lan3a = "簡単検索 ";
    $lan3b = "日付で検索";
//----------------------
$lan4 = "プログラム";
    $lan4a = "販売価格設定";
    $lan4b = "Tformプロジェクト";
    $lan4c = "オーター別経費計算";
    $lan4d = "オーダー別単価計算";
//----------------------
$lan5 = "ビュー";
    $lan5a = "デフォルト";
    $lan5b = "一覧";
    $lan5c = "ツールバー";
    $lan5d = "元履歴: REMOVE";
	$lan5e = "履歴表";
	$lan5f = "新履歴(短いフォーマット)";
//----------------------
$lan6 = "ヘルプ";
    $lan6a = "pAccessについて";
    $lan6b = "説明書";
    $lan6c = "言語";
        $lan6ca = "日本語";
        $lan6cb = "英語";
//----------------------
}
?>
<div id='navi'>
	<div id='naviContents'>
<ul class='drop_menu'>
		<li><a href="#"><?php echo $lan1;?></a>
				<ul>
						<li><a href="#"><?php echo $lan1a;?> <span style='float: right; color: #969696;'>▶</span></a>
						<ul>
    						<li><a href="expenseInput.php?pr=3"><?php echo $lan1aa;?></a></li>
    						<!-- <li><a href="orderInput.php?pr=3"><?php // echo $lan1ab;?></a> -->
    						<!--<li><span style='color: #AAA; cursor: default;'><?php //echo $lan1ab;?></span></li>-->
						</ul>
						</li>
						
						
						<?php if ($baseName =='expenseInput.php'){?>
						<li><a href="#" onClick="return validateForm(); "><?php echo $lan1b;?></a></li>
						<?php } else if ($baseName =='editExpense.php'){?>
						<li><a href="#" onClick="document.getElementById('editExpense').submit()"><?php echo $lan1b;?></a></li>
						<?php } else if ($baseName =='calcexpense.php'){?>
						<li><a href="#" onClick="document.getElementById('calculationSave').submit()"><?php echo $lan1b;?></a></li>
						<?php } else { 
						    echo "<li><span style='color: #AAA; cursor: default;'>$lan1b</span></li>";
						}
						?>
						
						<?php if ($baseName =='expense.php'){?>
						<li><a href="" onClick="window.print()"><?php echo $lan1c;?></a></li>
						<?php } else { 
						    echo "<li><span style='color: #AAA; cursor: default;'>$lan1c</span></li>";
						}
						?>
						<?php echo "<li><a href='".$path."/master/exeLogout.php'>".$lan1d."</a></li>"; ?>
						
				</ul>
		</li>
		<li><a href="#"><?php echo $lan2;?></a>
				<ul>
						
						<?php if ($baseName =='expense.php' || $baseName == 'expenseHistory.php' || $baseName == 'expenseHistorySimple.php' || $baseName == 'expenseHistorySuperSimple.php'){?>
						<li><a download="<?php echo $saveFileName;?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'saveWrapper', '<?php echo $savFileDate;?>');"><?php echo $lan2a;?></a></li>
						<?php } else { 
						    echo "<li><span style='color: #AAA; cursor: default;'>$lan2a</span></li>";
						}
						?>
						
						<?php if ($baseName == 'expense.php'){?>
						<li><a href="editExpense.php?pr=3&id=<?php echo $idPass;?>"> <?php echo $lan2b;?></a></li>
						<?php } else { 
						     echo "<li><span style='color: #AAA; cursor: default;'>$lan2b</span></li>";
						}?>
						<li><span style='color: #AAA; cursor: default;'><?php echo $lan2d;?></span></li>
				</ul>
		</li>
<!-- 
		<li><a href="#"><?php echo $lan3;?></a>
				<ul>
						<li><a href="" onClick="popupwindow('searchSimple.php?baseName=<?php //echo $baseName;?>&pr=<?php //echo $pr;?>', 'searchSimple', '800', '500')"><?php //echo $lan3a;?></a></li>
						<li><a href="" onClick="popupwindow('searchAdvanced.php', 'searchAdvanced', '800', '500')"><?php //echo $lan3b;?></a></li>
				</ul>
		</li>
 -->
		<li><a href="#"><?php echo $lan4;?></a>
				<ul>
						
						<li><a href="../p_calculation/calculation.php?pr=1"><?php echo $lan4a;?></a></li>
						 <!--<li><span style='color: #AAA; cursor: default;'><?php //echo $lan4a;?></span></li> -->
						<li><a href="../p_tfProject/tfProject.php?pr=2"><?php echo $lan4b;?></a></li>
						<li><span style='color: #AAA; cursor: default;'><?php echo $lan4c;?></span></li>
						<li><a href="../p_order/order.php?pr=4"><?php echo $lan4d;?></a></li>
				</ul>
		</li>
		<li><a href="#"><?php echo $lan5;?></a>
				<ul>
						<li><a href="expense.php?pr=3"><?php echo $lan5a;?></a></li>
						<li><a href="expenseAllFiles.php?pr=3"><?php echo $lan5b;?></a></li>
					
					<!--<li><a href="expenseHistory.php?pr=3"><?php echo $lan5d;?></a></li>
					<li><a href="expenseHistorySimple.php?pr=3"><?php echo $lan5e;?></a></li>-->
					<li><span style='color: #AAA; cursor: default;'><?php echo $lan5d;?></span></li>
                    <li><a href="expenseHistorySimple.php?pr=3"><?php echo $lan5e;?></a></li>
					
					<li><a href="expenseHistorySuperSimple.php?pr=3"><?php echo $lan5f;?></a></li>
					<li><span style='color: #AAA; cursor: default;'><?php echo $lan5c;?></span></li>
						
						<!--<li><a href=""><?php // echo $lan5c;?></a></li>-->
				</ul>
		</li>
		<li><a href="#"><?php echo $lan6;?></a>
				<ul>
						<li><a href=""  onClick="popupwindow('../master/about.php', 'about', '400', '250')"><?php echo $lan6a;?></a></li>
						<li><a href="" onClick="popupwindow('../master/manual.php', 'manual', '800', '500')"><?php echo $lan6b;?></a></li>
						<li><a href=""><?php echo $lan6c;?> <span style='float: right; color: #969696;'>▶</span></a>
						<ul>
							<!--<li><span style='color: #AAA; cursor: default;'><?php echo $lan6ca;?></span></li>-->
							<!--<li><span style='color: #AAA; cursor: default;'><?php echo $lan6cb;?></span></li>-->
							
    						<li><a href="../master/setLanguage.php?language=1"><?php echo $lan6ca;?></a></li>
    						<li><a href="../master/setLanguage.php?language=2"><?php echo $lan6cb;?></a></li>
    						
						</ul>
						</li>
				</ul>
		</li>
</ul>
	</div><!-- naviContents END -->
	
	<?php if ($baseName !='expense.php'){
						
						} else { 
						    echo "
							<form method='GET' action='expense.php' id='searchForm'>
                            <span style='float: right; margin-right: 10px;'>
                            <input type='text' name='search' class='searchBar'>
                            <input type='hidden' name='pr' value='$pr'>
                            <input type='hidden' name='record' value='0'> "; ?>
                            <button onClick="document.getElementById('searchForm').submit()" id='searchBtn'><i class="fa fa-search"></i></button>
                           
                            <?php echo "</span></form>";
						}
						?>
</div> <!-- navi END -->

