<?php
//Navi Names
//----------------------
if ($languageChoice == '2'){
	$lan1 = "File";
	$lan1a = "New";
	$lan1aa = "Terms & Conditions";
	$lan1ab = "Price Settings List";
	$lan1ac = "Set";
	$lan1ad = "Single";
	$lan1b = "Save";
	$lan1c = "Print";
	$lan1d = "Logout";
	//----------------------
	$lan2 = "Edit";
	$lan2a = "Export Excel";
	$lan2b = "Edit";
	$lan2ba = "Change Contents";
	$lan2bb = "Special Conditions";
	$lan2bc = "Set List Price";
	$lan2c = "Import";
	$lan2ca = "Import Maker PL CSV";
	$lan2cb = "Import FileMaker CSV";
	$lan2d = "Set Terms and Conditions";
	$lan2e = "Remove Old Filemaker Data";
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
	$lan5d = "General History";
	$lan5e = "Lists";
	//----------------------
	$lan6 = "Help";
	$lan6a = "About pAccess";
	$lan6b = "Manual";
	$lan6c = "Language";
	$lan6ca = "日本語";
	$lan6cb = "English";
	//----------------------

	$lan7 = "Lists";
	$lan7a = "Single List";
	$lan7b = "All Lists";

	//----------------------

} else {
	 
	$lan1 = "ファイル";
	$lan1a = "新規";
	$lan1aa = "取引条件";
	$lan1ab = "価格設定リスト";
	$lan1ac = "セット";
	$lan1ad = "単品";
	$lan1b = "保存";
	$lan1c = "印刷";
	$lan1d = "ログアウト";
	//----------------------
	$lan2 = "修正";
	$lan2a = "エクスポート Excel";
	$lan2b = "リスト修正";
	$lan2ba = "リストコンテンツ修正";
	$lan2bb = "特別条件";
	$lan2bc = "リスト価格設定";
	$lan2c = "インポート";
	$lan2ca = "メーカー価格表 CSV";
	$lan2cb = "FileMaker CSV";
	$lan2d = "商品取引条件設定";
	$lan2e = "古いFilemakerデーター掃除";
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
	$lan5d = "履歴";
	$lan5e = "リスト";
	//----------------------
	$lan6 = "ヘルプ";
	$lan6a = "pAccessについて";
	$lan6b = "説明書";
	$lan6c = "言語";
	$lan6ca = "日本語";
	$lan6cb = "English";
	//----------------------
	$lan7 = "リスト";
	$lan7a = "デフォルト";
	$lan7b = "一覧";

	//----------------------
}
?>
<div id='navi' class='navi_1'>

	<div id='naviContents'>
		<span style='float: left; color: #FC9A9A;'></span>
		<ul class='drop_menu'>
			<!-- FILE -->
			<li><a href="#"><?php echo $lan1;?> </a>
				<ul>
					<li><a href="#"><?php echo $lan1a;?> <span style='float: right; color: #969696;'>▶</span> </a>
						<ul>
							<li><a href="termsAndConditions.php?pr=1"><?php echo $lan1aa;?> </a></li>
							<li><a href="list_input.php?pr=1"><?php echo $lan1ab;?> </a></li>
							
						</ul>
					</li>
					<!-- SAVE -->

					<?php if ($baseName =='termsAndConditions.php'){?>
					<li><a href="#" onClick="return validateTermsAndConditionsForm(); "><?php echo $lan1b;?> </a></li>

					<?php } else if ($baseName =='setTermsAndConditions.php' || $baseName == 'setTermsAndConditionsNew.php'){?>
					<li><a href="#" onClick="document.getElementById('termsAndConditionsSave').submit();showLoading();"><?php echo $lan1b;?> </a></li>

					<?php } else if ($baseName =='putTheNextSaveAreaHere'){?>
					<li><a href="#" onClick="document.getElementById('calculationSave').submit();"><?php echo $lan1b;?> </a></li>

					<?php } else if ($baseName =='list_input.php'){?>
					<li><a href="#" onClick="return checkListName();showLoading();"><?php echo $lan1b;?> </a></li>

					<?php } else if ($baseName =='list_calculation.php'){?>
					<li><a href="#" onClick="document.getElementById('listSave').submit();"><?php echo $lan1b;?> </a></li>

					<?php } else if ($baseName =='list_edit_price.php'){?>
					<li><a href="#" onClick="document.getElementById('listSave').submit();"><?php echo $lan1b;?> </a></li>

					<?php } else if ($baseName =='list_edit_contents.php'){?>
					<li><a href="#" onClick="document.getElementById('listSave').submit();"><?php echo $lan1b;?> </a></li>

					<?php } else {
						echo "<li><span style='color: #AAA; cursor: default;'>$lan1b</span></li>";
					}
					?>
					<!-- EXPORT -->
					<?php if ($baseName =='calculation.php'){?>
					<li><a download="<?php echo $saveFileName;?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'saveWrapper', '<?php echo $savFileDate;?>');"><?php echo $lan2a;?> </a></li>
					<?php } else if ($baseName == 'termsAndConditions.php') {?>
					<li><a download="取引条件.xls" href="#" onclick="return ExcellentExport.excel(this, 'saveWrapper', '<?php echo $savFileDate;?>');"><?php echo $lan2a;?> </a></li>
					<?php } else if ($baseName == 'list_single.php') {?>
					<li><a download="<?php echo $saveFileName;?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'saveWrapper', '<?php echo $savFileDate;?>');"><?php echo $lan2a;?> </a></li>
					<?php } else if ($baseName == 'list_calculation_printView.php' || $baseName == 'list_calculation_printView_COPY.php') {?>
					<li><a download="<?php echo $saveFileName;?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'saveWrapper', '<?php echo $savFileDate;?>');"><?php echo $lan2a;?> </a></li>
					<?php } else if ($baseName == 'list_setDetails.php') {?>
					<li><a download="<?php echo $saveFileName;?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'saveWrapper', '<?php echo $savFileDate;?>');"><?php echo $lan2a;?> </a></li>
					<?php } else if ($baseName == 'list_calculationOLD.php') {?>
					<li><a download="<?php echo $saveFileName;?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'saveWrapper', '<?php echo $savFileDate;?>');"><?php echo $lan2a;?> </a></li>
					<?php }	else if ($baseName == 'list_calculation.php') {?>
					<li id="listDownloadExcel"><a href="#"><?php echo $lan2a;?> </a></li>
					<?php }	else if ($baseName == 'calculationAllFiles.php') {?>
					<li><a download="<?php echo $saveFileName;?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'saveWrapper', '<?php echo $savFileDate;?>');"><?php echo $lan2a;?> </a></li>
					<?php } else if ($baseName == 'arrayTest.php') {?>
					<li><a download="<?php echo $saveFileName;?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'saveWrapper', '<?php echo $savFileDate;?>');"><?php echo $lan2a;?> </a></li>
					<?php } else {
						echo "<li><span style='color: #AAA; cursor: default;'>$lan2a</span></li>";
					}
					?>
					<!-- IMPORT -->
					<li><a href="#"><?php echo $lan2c;?> <span style='float: right; color: #969696;'>▶</span> </a>
						<ul>
							<li><a href="#" class='openUpload' style='float: left; margin-left: 21px;'><?php echo $lan2ca;?> </a></li>
							<li><img src='<?php echo $path;?>/img/filemaker.png' style='float: left; margin-right: 5px;'> <a href="#" class='openFMUpload'><?php echo $lan2cb;?> </a></li>
						</ul>
					</li>

					<!-- PRINT -->
					<?php if ($baseName =='expense.php'){?>
					<li><a href="" onClick="window.print()"><?php echo $lan1c;?> </a></li>
					<?php } else {
						echo "<li><span style='color: #AAA; cursor: default;'>$lan1c</span></li>";
					}
					?>
					<?php echo "<li><a href='".$path."/master/exeLogout.php'>".$lan1d."</a></li>"; ?>

				</ul>
			</li>
			<!-- FILE -->
			<!-- EDIT -->
			<li><a href="#"><?php echo $lan2;?> </a>
				<ul>
				<?php
					if($baseName == 'list_calculation.php' || $baseName == 'list_edit_contents1.php' || $baseName == 'list_calculation_printView1.php'){
						
					echo "<li><img src='$path/img/file_edit.png' style='float: left; margin-right: 5px;'> <a href='list_edit_contents.php?pr=1&id=".$_GET['id']."'>$lan2ba</a></li>";
				
				/*	echo "<li><a href='#'> $lan2b <span style='float: right; color: #969696;'>▶</span></a>
							<ul>
								<li><img src='$path;/img/file_edit.png' style='float: left; margin-right: 5px;'> <a href='list_edit_contents.php?pr=1&id=".$_GET['id']."'> $lan2ba</a></li>
								<li><img src='$path;/img/specialCog.png' style='float: left; margin-right: 5px;'> <a href='list_specialConditions.php?pr=1&id=".$_GET['id']."'>$lan2bb</a></li>
								<li><img src='$path;/img/money_coin.png' style='float: left; margin-right: 5px;'> <a href='list_calculation.php?pr=1&id=".$_GET['id']."'>$lan2bc</a></li>
							</ul>
						</li>
					";*/
					 }
				?>
					

					<li><a href="setTermsAndConditionsNew.php?pr=1"><?php echo $lan2d;?> </a></li>
					<li><a href="removeOldFilemakerData.php?pr=1"><?php echo $lan2e;?> </a></li>
				</ul>
			</li>
			<!-- EDIT -->
			<!-- SEARCH -->
			<!-- 
		<li><a href="#"><?php echo $lan3;?></a>
				<ul>
						<li><a href="" onClick="popupwindow('searchSimple.php?baseName=<?php //echo $baseName;?>&pr=<?php //echo $pr;?>', 'searchSimple', '800', '500')"><?php //echo $lan3a;?></a></li>
						<li><a href="" onClick="popupwindow('searchAdvanced.php', 'searchAdvanced', '800', '500')"><?php //echo $lan3b;?></a></li>
				</ul>
		</li>
 -->
			<!-- SEARCH -->
			<!-- PROGRAMS -->
			<li><a href="#"><?php echo $lan4;?> </a>
				<ul>

					<!--<li><a href="../p_calculation/calculation.php?pr=1"><?php //echo $lan4a;?></a></li> -->
					<li><span style='color: #AAA; cursor: default;'><?php echo $lan4a;?> </span></li>
					<li><a href="../p_tfProject/tfProject.php?pr=2"><?php echo $lan4b;?> </a></li>
					<li><a href="../p_expense/expense.php?pr=3"><?php echo $lan4c;?> </a></li>
					<li><a href="../p_order/order.php?pr=4"><?php echo $lan4d;?> </a></li>
				</ul>
			</li>
			<!-- PROGRAMS -->

			<!-- VIEW -->
			<li><a href="#"><?php echo $lan5;?> </a>
				<ul>
					<li><a href="calculation.php?pr=1"><?php echo $lan5a;?> </a></li>
					<?php //check if only a single record and if not then display ichiran
					if (isset($_GET['search'])==true && $_GET['search'] != '' && $baseName == 'calculation.php'){
						echo "<li><a href='calculationAllFiles.php?pr=1&search=$search'>$lan5b</a></li>";
					} else {
						echo "<li><span style='color: #AAA; cursor: default;'>$lan5b</span></li>";
					}?>
					<!-- LISTS -->
					<li><a href="list_allFiles.php?pr=1"><?php echo $lan5e;?> </a></li>
					<!-- 
                		<li><a href="#"><?php echo $lan7;?><span style='float: right; color: #969696;'>▶</span></a>
                				<ul>
                						<li><a href="list_single.php?pr=1"><?php echo $lan7a;?></a></li>
                						<li><a href='list_allFiles.php?pr=1'><?php echo $lan7b;?></a></li>
                						
                				</ul>
                		</li>
                		 -->
					<!-- LISTS -->
					<!-- TOOLBAR -->
					<!-- <li><span style='color: #AAA; cursor: default;'><?php echo $lan5c;?></span></li> -->
					<!--<li><a href=""><?php // echo $lan5c;?></a></li>-->
					<li><a href="#" class='openGeneralHistory'><?php echo $lan5d;?> </a></li>

				</ul>
			</li>
			<!-- VIEW -->
			<!-- LANGUAGE -->
			<li><a href="#"><?php echo $lan6;?> </a>
				<ul>
					<li><a href="" onClick="popupwindow('../master/about.php', 'about', '400', '250')"><?php echo $lan6a;?> </a></li>
					<li><a href="" onClick="popupwindow('../master/manual.php', 'manual', '800', '500')"><?php echo $lan6b;?> </a></li>
					<li><a href=""><?php echo $lan6c;?> <span style='float: right; color: #969696;'>▶</span> </a>
						<ul>
							<!--<li><span style='color: #AAA; cursor: default;'><?php echo $lan6ca;?></span></li>-->
							<!--<li><span style='color: #AAA; cursor: default;'><?php echo $lan6cb;?></span></li>-->

							<li><a href="../master/setLanguage.php?language=1"><?php echo $lan6ca;?> </a></li>
							<li><a href="../master/setLanguage.php?language=2"><?php echo $lan6cb;?> </a></li>

						</ul>
					</li>
				</ul>
			</li>
			<!-- LANGUAGE -->
		</ul>
	</div>
	<!-- naviContents END -->

	<?php if ($baseName =='calculation.php'){
		echo "
							<form method='GET' action='calculation.php' id='searchForm'>
                            <span style='float: right; margin-right: 10px;'>
                            <input type='text' name='search' class='searchBar'>
                            <input type='hidden' name='pr' value='$pr'>
                            <input type='hidden' name='record' value='0'> "; ?>
	<button onClick="document.getElementById('searchForm').submit()" id='searchBtn'>
		<i class="fa fa-search"></i>
	</button>

	<?php echo "</span></form>";
	}
	if($baseName =='setTermsAndConditions.php' || $baseName == "setTermsAndConditionsNew.php") {
		echo "
							<form method='GET' action='setTermsAndConditionsNew.php' id='searchForm'>
                            <span style='float: right; margin-right: 10px;'>
                            <input type='text' name='search' class='searchBar'>
                            <input type='hidden' name='pr' value='$pr'>
                            <input type='hidden' name='record' value='0'> "; ?>
	<button onClick="document.getElementById('searchForm').submit()" id='searchBtn'>
		<i class="fa fa-search"></i>
	</button>

	<?php echo "</span></form>";
	}
	if($baseName =='calculationAllFiles.php') {
		echo "
							<form method='GET' action='calculationAllFiles.php' id='searchForm'>
                            <span style='float: right; margin-right: 10px;'>
                            <input type='text' name='search' class='searchBar'>
                            <input type='hidden' name='pr' value='$pr'>
                            <input type='hidden' name='record' value='0'> "; ?>
	<button onClick="document.getElementById('searchForm').submit()" id='searchBtn'>
		<i class="fa fa-search"></i>
	</button>

	<?php echo "</span></form>";
	}
	if($baseName =='list_input.php') {
		echo "
							<form method='GET' action='list_input.php' id='searchForm'>
                            <span style='float: right; margin-right: 10px;'>
                            <input type='text' name='search' class='searchBar'>
                            <input type='hidden' name='pr' value='$pr'>
                            <input type='hidden' name='record' value='0'> "; ?>
	<button onClick="document.getElementById('searchForm').submit()" id='searchBtn'>
		<i class="fa fa-search"></i>
	</button>

	<?php echo "</span></form>";
	}
	if($baseName =='list_single.php') {
		echo "
							<form method='GET' action='list_single.php' id='searchForm'>
                            <span style='float: right; margin-right: 10px;'>
                            <input type='text' name='search' class='searchBar'>
                            <input type='hidden' name='pr' value='$pr'>
                            <input type='hidden' name='record' value='0'> "; ?>
	<button onClick="document.getElementById('searchForm').submit()" id='searchBtn'>
		<i class="fa fa-search"></i>
	</button>

	<?php echo "</span></form>";
	}
	?>

</div>
<!-- navi END -->
<!-- importMakerPL -->
<div class='importMakerPL'>
	<div class='uploadForm'>
		<br> <span class='closeUpload'> <i class="fa fa-times"></i> </span><br> <br>


		<?php
		echo "<form method='POST' action='exe/exeplUpdate.php' enctype='multipart/form-data'>";
		echo "<h3>メーカーPLインポート</h3>";
		echo "<input type='file' name='filename' style='border: #CCC 2px solid;'>";
		echo "<br><br><br>";
		echo "<input type='submit' value='アップロード' class='go' onclick='showImage();'>";
		echo "</form>";
		echo "<br><span class='loadingGif'><img src='$path/img/142.gif'></span>";
		?>
	</div>
</div>
<!-- importFileMaker -->
<div class='importFileMaker'>
	<div class='uploadForm'>
		<br> <span class='closeFMUpload'><i class="fa fa-times"></i> </span><br> <br>
		<?php
		echo "<form method='POST' action='exe/exeFileMakerUpdate.php' enctype='multipart/form-data'>";
		echo "<h3><img src='$path/img/filemaker.png'> FileMaker PL インポート</h3>";
		echo "<input type='file' name='filename' style='border: #CCC 2px solid;'>";
		echo "<br><br><span style='color: red'>※数分かかりますので1回だけ押してください。</span><br>";
		echo "<input type='submit' value='アップロード' class='go' onclick='showImage();'>";
		echo "</form>";
		echo "<br><span class='loadingGif'><img src='$path/img/142.gif'></span>";
		?>
	</div>
</div>
<!-- showGeneralHistory -->
<div class='showGeneralHistoryBox'>
	<div class='generalHistoryForm'>
		<br> <span class='closeGeneralHistory'><i class="fa fa-times"></i> </span><br> <br>

		<table id='genHistTable'>
			<thead>
				<tr>
					<th style='min-width: 75px;'>アクション</th>
					<th>メモ</th>
					<th style='min-width: 140px;'>日付</th>
				</tr>
			</thead>
			<tbody>
			<?php
			echo "<h3>修正履歴 <a href='historyGeneral.php?pr=1' style='color: orange;'>(一覧)</a></h3>";
			$result = mysql_query("SELECT * FROM `sp_history_general` ORDER BY `created` DESC LIMIT 20");
			while ($row = mysql_fetch_assoc($result)){
				switch ($row['action']){
					case 'INS':
						$color = 'green';
						break;
					case 'UPD':
						$color = 'blue';
						break;
					case 'DEL':
						$color = 'red';
						break;
					default:
						$color = '#000';
						break;
				}

				echo " <tr>";
				echo "<td style='color: $color; text-align: center;'>".$row['action']."</td>";
				echo "<td>".$row['memo']."</td>";
				echo "<td>".$row['created']."</td>";
				echo " </tr>";
			}
			?>

			</tbody>
		</table>
	</div>
</div>
