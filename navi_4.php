<?php 
//Navi Names
//----------------------
if ($languageChoice == '2'){
$lan1 = "File";
    $lan1a = "<i class='fa fa-file-text-o'></i>New";
    $lan1b = "<i class='fa fa-save'></i>Save";
    $lan1c = "<i class='fa fa-print'></i>Print";
    $lan1d = "<i class='fa fa-sign-out'></i>Logout";
//----------------------
$lan2 = "Edit";
    $lan2a = "<i class='fa fa-table'></i>Export Excel";
    $lan2b = "<i class='fa fa-wrench'></i>Edit";
	$lan2f = "<i class='fa fa-pencil'></i>Rename Order";
    $lan2d = "<i class='fa fa-copy'></i>Duplicate Record";
	$lan2e = "<i class='fa fa-upload'></i><span style='font-size: 11px;'>Upload order WITH pricelist</span>";
	
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
    $lan1a = "<i class='fa fa-file-text-o'></i>新規";
    $lan1b = "<i class='fa fa-save'></i>保存";
    $lan1c = "<i class='fa fa-print'></i>印刷";
    $lan1d = "<i class='fa fa-sign-out'></i>ログアウト";
//----------------------
$lan2 = "修正";
    $lan2a = "<i class='fa fa-table'></i>エクスポート Excel";
    $lan2b = "<i class='fa fa-wrench'></i>修正";
	$lan2f = "<i class='fa fa-pencil'></i>オーダーNo.変更";
    $lan2d = "<i class='fa fa-copy'></i>オーダーコーピー";
	$lan2e = "<i class='fa fa-upload'></i><span style='font-size: 11px;'>オーダーアップロード[ﾒｰｶｰ価格付]</span>";
	
//----------------------
$lan3 = "検索";
    $lan3a = "簡単検索 ";
    $lan3b = "日付で検索";
//----------------------
$lan4 = "プログラム";
    $lan4a = "販売価格設定";
    $lan4b = "Tformプロジェクト";
    $lan4c = "オーダー別経費計算";
    $lan4d = "オーダー別単価計算";
//----------------------
$lan5 = "ビュー";
    $lan5a = "デフォルト";
    $lan5b = "一覧";
    $lan5c = "ツールバー";
	
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
						
                        <?php if ($baseName =='order.php'){?>
						<li id='newOrd'><a href="#"><?php echo $lan1a;?></a></li>
						<?php } else { 
						    echo "<span style='color: #AAA; cursor: default;'><?php echo $lan1a;?></span>";
						}
						?>
						
						
						<?php if ($baseName =='order.php' && isset($_GET['orderNo']) == true){?>
						<li><a href="#" onClick="document.getElementById('updateOrder').submit()"><?php echo $lan1b;?></a></li>
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
						
						<?php if ($baseName =='expense.php'){?>
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
					
						<?php if ($baseName == 'order.php'){?>
						<li><a href="#" id='renameOrderBtn'> <?php echo $lan2f;?></a></li>
						<?php } else { 
						     echo "<li><span style='color: #AAA; cursor: default;'>$lan2f</span></li>";
						}?>
						
						<?php if ($baseName == 'order.php'){?>
						<li><a href="#" id='copyOrderBtn'> <?php echo $lan2d;?></a></li>
						<?php } else { 
						     echo "<li><span style='color: #AAA; cursor: default;'>$lan2d</span></li>";
						}?>
					
						<?php if ($baseName == 'order.php'){?>
						<li><a href="#" id='dialogUploadOrderWithPriceBtn'> <?php echo $lan2e;?></a></li>
						<?php } else { 
						     echo "<li><span style='color: #AAA; cursor: default;'>$lan2e</span></li>";
						}?>
					
					
						
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
						 <!--<li><span style='color: #AAA; cursor: default;'><?php // echo $lan4a;?></span></li>-->
						<li><a href="../p_tfProject/tfProject.php?pr=2"><?php echo $lan4b;?></a></li>
						<li><a href="../p_expense/expense.php?pr=3"><?php echo $lan4c;?></a></li>
						<!-- <li><a href="../p_order/order.php?pr=4"><?php //echo $lan4d;?></a></li> -->
						<li><span style='color: #AAA; cursor: default;'><?php echo$lan4d;?></span></li>
				</ul>
		</li>
		<li><a href="#"><?php echo $lan5;?></a>
				<ul>
						
						<li><span style='color: #AAA; cursor: default;'><?php echo $lan5a;?></span></li>
						<li><span style='color: #AAA; cursor: default;'><?php echo $lan5b;?></span></li>
						<li><span style='color: #AAA; cursor: default;'><?php echo $lan5c;?></span></li>
						
						<!--
						<li><a href="expense.php?pr=3"><?php // echo $lan5a;?></a></li>
						<li><a href="expenseAllFiles.php?pr=3"><?php // echo $lan5b;?></a></li>
						<li><a href=""><?php // echo $lan5c;?></a></li>
						-->
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

