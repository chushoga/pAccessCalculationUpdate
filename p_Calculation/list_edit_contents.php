<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $title;?>
    </title>
    <?php
include_once '../master/config.php'; ?>
    <script type="text/javascript">
        $(document).ready(function() {
            /*DATATABLES START*/
            var defaultOptions = {
                "bJQueryUI": true,
                "bPaginate": false,
                "bInfo": false,
                "sScrollX": "100%",
                "iDisplayLength": 100
            }; //options
            var calcDataTableHeight = function() {
                // navi: 20px + uiToolbar: 38px + thHeight: 25px + toolBarFooter: 40px; = 123px 
                var navi = 20;
                var uiToolbar = 38;
                var thHeight = 116;
                var toolBarFooter = 185;
                var minusResult = navi + uiToolbar + thHeight + toolBarFooter;
                var h = Math.floor($(window).height() - minusResult);
                return h + 'px';
            };
            defaultOptions.sScrollY = calcDataTableHeight();

            var oTable = $('#listTable').dataTable(defaultOptions);

            $(window).bind('resize', function() {
                $('div.dataTables_scrollBody').css('height', calcDataTableHeight());
                oTable.fnAdjustColumnSizing();
            });
            /*DATATABLES END*/
            var $sourceFields = $("#sourceFields");
            var $destinationFields = $("#destinationFields");
            var $chooser = $("#fieldChooser").fieldChooser(sourceFields, destinationFields);

            $('#listSave').bind("keyup keypress", function(e) {
                var code = e.keyCode || e.which;
                if (code == 13) {
                    e.preventDefault();
                    return false;
                }
            });

            $('#loading').delay(300).fadeOut(300);
        });

    </script>
    <style type="text/css">
        #loading {
            position: fixed;
            z-index: 9000;
            width: 100%;
            height: 100%;
            background-color: #FFF;
        }

        .loadingGifMain {
            background-color: #FFF;
            width: 150px;
            height: 10px;
            position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -75px;
            margin-top: -10px;
            text-align: center;
        }

        .R1 {
            background-color: #D0F4F5;
            ;
            height: 40px;
        }

        .R2 {
            background-color: #C1ED9D;
            ;
            height: 40px;
        }

        .yearChoice {
            background-color: #F5F2D0;
            ;
            height: 40px;
        }

        .listEditDetails {
            width: 400px;
            margin: auto;
        }

        .listEditDetails input {
            width: 60px;
        }

        div#fieldChooser {
            width: 100%;
            height: 100%;
            background-color: #FFF;
        }

        div#sourceFields {
            background-color: #B3B3B3;
        }

        div#destinationFields {
            background-color: #E8E8E8;
        }

        .fc-field {
            width: calc(100% -4px);
            height: 45px;
            margin-bottom: 0px;
            padding: 2px;
            background-color: #FFF;
            box-shadow: 0px 0px 10px 0px rgba(222, 222, 222, 1.0);
        }

        .fc-field:hover {
            outline: #cacaca solid 1px;
        }

        .fc-field {
            cursor: move;
        }

        .fc-selected {
            background-color: #D6F1FF;
        }

        .fc-selected:hover {
            background-color: #EBF8FF;
        }

        .fc-field-list {
            width: 50%;
            height: 200px;
            margin: 0px;
            padding: 0px;
            overflow: auto;
            background-color: green;
        }

        .fc-source-fields {
            float: left;
        }

        .fc-destination-fields {
            float: right;
        }

        .listImg {
            background-color: none;
            height: 45px;
            width: 45px;
            overflow: hidden;
        }

        .listTfNo {
            background-color: none;
            height: 40px;
            width: 150px;
            float: left;
            overflow: hidden;
            padding-left: 10px;
            padding-top: 5px;
        }

        .listSeries {
            background-color: none;
            height: 40px;
            width: 150px;
            float: left;
            overflow: hidden;
            padding-left: 10px;
            padding-top: 5px;
        }

        .listSpecial {
            background-color: none;
            height: 45px;
            width: 350px;
            float: left;
            overflow: hidden;
            line-height: 45px;
            padding-left: 10px;
        }

        .listMemo {
            background-color: none;
            height: 45px;
            width: 45px;
            float: right;
            overflow: hidden;
            line-height: 45px;
            text-align: right;
            margin-right: 5px;
        }

        .preSearch {
            width: 400px;
            height: 100px;
            background-color: #FFF;
            outline: solid 1px #CCC;
            z-index: 2;
            position: fixed;
            top: 400px;
            left: calc(50% - 200px);
        }

        .headCol {
            background-color: darkorange;
            color: white;
        }

    </style>
</head>

<body>
    <?php
//variables
// make sure $page always = something
if (isset($_GET['record'])){
	$record = $_GET['record'];
	$previous = $record - 1; // minus from the current record
	$next = $record + 1; // add to the current record
	if ($record < 0){
		$record = 0;
		$previous = $record; // minus from the current record
		$next = $record; // add to the current record
	}

} else {
	$record = 0;
	$previous = $record - 1; // minus from the current record
	$next = $record + 1; // add to the current record
}
// make sure $search always = something
if (isset($_GET['search'])){
	$search = $_GET['search'];
} else {
	$search = "NULL";
}
if (isset($_GET['id']) == true){
	$recordId = $_GET['id'];
	$setQuery = "SELECT * FROM `makerlistcontents` WHERE `listName` = '$recordId'";
} else {
	//$setQuery = "SELECT * FROM `sp_disc_rate` WHERE `id` LIKE '%$search%' OR `maker` LIKE '%$search%' OR `date` LIKE '%$search%'";
	$setQuery = "SELECT * FROM `makerlistcontents` WHERE `listName` LIKE '%$search%'";
}



//get total amount of results.
$iAmount = 0;
$resultAmount = mysql_query("$setQuery");
$searchEmptyCheck2 = mysql_num_rows($resultAmount);
while ($rowAmount = mysql_fetch_assoc($resultAmount)){
	$iAmount++;
}
// ---------------------------
$iRecord = $record +1;

//SET FILENAME SAVE HERE
$result = mysql_query("$setQuery ORDER BY ID ASC LIMIT $record, 1");
$idPass = 0; // initialize the record Id
$id = 0; // initialize the id;
while ($row = mysql_fetch_assoc($result)){
	$idPass = $row['listName']; //set the recordId
	$id = $row['id'];

	$savFileDate = date ("Y-m-d H:i:s");
	$saveFileProjectName = "価格設定リスト";

	$saveFileName = $saveFileProjectName."_".$savFileDate;

}

//----------------------------------
?>
    <div id='wrapper'>
        <div id='loading'>
            <span class='loadingGifMain'> <img src='<?php echo $path;?>/img/142.gif'><br> LOADING ... </span>
        </div>
        <?php require_once '../header.php';?>
        <div class='contents'>
            <!-- PAGE CONTENTS START HERE -->
            <?php
		// initalize variables
		$listID = 0; // initialize
		$listName = ""; // initialize
		$plCurrent = 0;
		$plNet = 0;
		$yenPrice = 0;
		$yenPriceTest1 = 0;
		$yenPriceTest2 = 0;
		$bairitsu =  0;
		$bairitsu1 =  0;
		$bairitsu2 =  0;
		$sp_disc_rate_id = 0;
		$selected = "";
		$rate = "";
		$percent = "";


		//run query
		// get the list data
		$listContentsQuery = mysql_query("SELECT * FROM `makerlistcontents` WHERE `id` = '$id'");
		while ($rowListContentsQuery = mysql_fetch_assoc($listContentsQuery)){
			$makerName = $rowListContentsQuery['maker'];
			$listName = $rowListContentsQuery['listName'];
			$listID = $rowListContentsQuery['id'];
			$testRate1 = $rowListContentsQuery['testRate1'];
			$percent1 = $rowListContentsQuery['percent1'];
			$testRate2 = $rowListContentsQuery['testRate2'];
			$percent2 = $rowListContentsQuery['percent2'];
			$testRate3 = $rowListContentsQuery['testRate3'];
			$percent3 = $rowListContentsQuery['percent3'];
			$memo = $rowListContentsQuery['memo'];
			$historyYear = $rowListContentsQuery['historyYear'];

		}

		?>



            <!-- MAIN TABLE HERE -->

            <div id='saveWrapper'>
                <div style='margin-top: 20px; padding-left: 5px;'>
                    <?php echo $listName;?>
                    [
                    <?php echo $listID;?> ]
                    <input type="button" value="<< リストへ戻る" style='padding: 2px; padding-left: 5px; padding-right: 5px; margin-right: 5px; margin-top: 2px; margin-bottom: 2px;' class='cancelBtn' onClick="location.href='list_calculation.php?pr=1&id=<?php echo $idPass;?>'">
                </div>

                <table id="listTable">
                    <thead>
                        <tr>
                            <th style='min-width: 60px;'>イメージ</th>
                            <th style='min-width: 100px;'>Tform品番</th>
                            <th>メーカー品番</th>
                            <th>シリーズ</th>
                            <th>WEB表示</th>
                            <th>メーカー品番</th>
                            <th>tform品番</th>
                            <th>販売終了</th>
                            <th>PL</th>
                            <th>set</th>
                            <th>削除</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
					$listInfoQuery = mysql_query("SELECT * FROM `makerlistinfo` WHERE `listName` = '$listName'");
					while ($rowListInfoQuery = mysql_fetch_assoc($listInfoQuery)){
						$listTformNo = $rowListInfoQuery['tformNo'];
						$listTformNoId = $rowListInfoQuery['id'];

						// main
						$mainQuery = mysql_query("SELECT * FROM `main` WHERE `tformNo` = '$listTformNo'");
						while ($rowMainQuery = mysql_fetch_assoc($mainQuery)){
							$img = $rowMainQuery['thumb'];
							$maker = $rowMainQuery['maker'];
							$makerNo = $rowMainQuery['makerNo'];
							$tformPriceNoTax = $rowMainQuery['tformPriceNoTax'];
							$series = $rowMainQuery['series'];
							
							// new check
							$flgWeb = $rowMainQuery["web"];
							$flgCancelMaker = $rowMainQuery["cancelMaker"];
							$flgCancelTform = $rowMainQuery["cancelTform"];
							$flgCancelSelling = $rowMainQuery["cancelSelling"];
							
							// change to checkboxes for flags
							$flgWeb = checkOrNotFilter($flgWeb);
							$flgCancelMaker = checkOrNotFilter($flgCancelMaker);
							$flgCancelTform = checkOrNotFilter($flgCancelTform);
							$flgCancelSelling = checkOrNotFilter($flgCancelSelling);
							
							
							if (empty($rowMainQuery['set'])){
								$isSet = '×';
							} else {
								$isSet = "<span style='color: red;'>セット</span>";
							}
						}
						// sp_plcurrent
						$plCurrentQuery = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` = '$listTformNo'");
						if (mysql_num_rows($plCurrentQuery)){
							while ($rowPlCurrent = mysql_fetch_assoc($plCurrentQuery)){
								$plCurrent = $rowPlCurrent['plCurrent'];
							}
						} else {
							$plCurrent = "メーカー価格なし";
						}
						?>
                        <tr>
                            <td>
                                <div class='listImg' style='margin: auto;'>
                                    <?php
								if($img != ""){
									$thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum060", $img);
									echo "<img src ='".$filemakerImageLocation.$img."' style='max-width: 45px; max-height: 45px;'>";
								} else {
									echo "<li class='fa fa-picture-o' style='font-size: 40px; color: #CCC;'></li>";
								}
								?>
                                </div>
                            </td>
                            <td>
                                <?php echo $listTformNo;?>
                            </td>
                            <td>
                                <?php echo $makerNo;?>
                            </td>
                            <td>
                                <?php echo $series;?>
                            </td>

                            <td>
                                <?php echo $flgWeb;?>
                            </td>
                            <td>
                                <?php echo $flgCancelMaker;?>
                            </td>
                            <td>
                                <?php echo $flgCancelTform;?>
                            </td>
                            <td>
                                <?php echo $flgCancelSelling;?>
                            </td>

                            <td>
                                <?php echo $plCurrent;?>
                            </td>
                            <td>
                                <?php echo $isSet;?>
                            </td>


                            <td><a href='exe/exeSetListRemove.php?tformid=<?php echo $listTformNoId;?>&id=<?php echo $idPass;?>' onClick='return confirm(\"エントリー削除?\")'>
                                    <div style='width: 100%; background-color: red; color: #FFF;'>
                                        <i class='fa fa-times'></i>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- SAVE WRAPER END -->
        <?php
		echo "<div style='width: 100%; height: 20px;' class='headCol'>";
		echo "<span style='float: left; margin-left:20px; font-weight: 700;'>※ 品番追加の場合はサーチバーでを検索DRAG & DROP ➤</span>";
		echo "
			<form method='GET' action='list_edit_contents.php' id='searchForm'>
			<span style='float: right; margin-right: 10px;'>
			<input type='text' name='search' class='searchBar'>
			<input type='hidden' name='pr' value='$pr'>
			<input type='hidden' name='id' value='$idPass'> "; ?>
        <button onClick="document.getElementById('searchForm').submit()" id='searchBtn'>
            <i class="fa fa-search"></i>
        </button>

        <?php echo "</span>
		
		<span style='float: right; color: #000000; margin-right: 10px; line-height: 20px;'>
			WEB <input type='checkbox' name='flgWeb' value='1'>
			| メーカー廃番 <input type='checkbox' name='flgMakerH' value='1'>
			| TFORM廃番 <input type='checkbox' name='flgTformH' value='1'>
			| 販売終了 <input type='checkbox' name='flgFin' value='1'>
		</span>
		
		</form>";
		echo "</div>";

		?>
        <div id="fieldChooser" tabIndex="1">
            <div id="sourceFields">
                <?php
				
				// filter for search query
				$flagQueryFilter = "";
				
				// CHECKING FLAGS -------------------------------------------
				if(isset($_GET['flgWeb'])){
					if($_GET['flgWeb'] == 1){
						$showWeb = true;
						$flagQueryFilter .= "AND `web` = 1";
					} else {
						$showWeb = false;
					}
				} else {
					$showWeb = false;
				}
				// CHECKING FLAGS -------------------------------------------
				if(isset($_GET['flgMakerH'])){
					if($_GET['flgMakerH'] == 1){
						$showMakerHinban = true;
						$flagQueryFilter .= "AND `cancelMaker` = 1";
					} else {
						$showMakerHinban = false;
					}
				} else {
					$showMakerHinban = false;
				}
				
				// CHECKING FLAGS -------------------------------------------
				
				if(isset($_GET['flgTformH'])){
					if($_GET['flgTformH'] == 1){
						$showTformHinban = true;
						$flagQueryFilter .= "AND `cancelTform` = 1";
					} else {
						$showTformHinban = false;
					}
				} else {
					$showTformHinban = false;
				}
				// CHECKING FLAGS -------------------------------------------
				if(isset($_GET['flgFin'])){
					if($_GET['flgFin'] == 1){
						$showFinishedSelling = true;
						$flagQueryFilter .= "AND `cancelSelling` = 1";
					} else {
						$showFinishedSelling = false;
					}
				} else {
					$showFinishedSelling = false;
				}
				// CHECKING FLAGS -------------------------------------------
				
				
				
			if($search == "" || $search == " "){
				$result = mysql_query("SELECT * FROM `main` WHERE `tformNo` = 'null' ORDER BY `cancelSelling`") or die(mysql_error());
			} else {
				$result = mysql_query("SELECT * FROM `main` WHERE `tformNo` LIKE '%$search%' $flagQueryFilter ORDER BY `tformNo`") or die(mysql_error());
			}
			while ($row = mysql_fetch_assoc($result)){
				$img = $row['thumb'];
				$tformNo = $row['tformNo'];
				$makerNo = $row['makerNo'];
				$maker = $row['maker'];
				$series = $row['series'];
				$mainId = $row['id'];
				$rate = 0;
				$percent = 0;
				$discount = 0;
				
				// new check
				$flgWeb = $row["web"];
				$flgCancelMaker = $row["cancelMaker"];
				$flgCancelTform = $row["cancelTform"];
				$flgCancelSelling = $row["cancelSelling"];
				
				$setHaiban = $row['memo']; // DONT NEED FOR THIS ANYMORE, NOT USED....

/* CHECK FOR HAIBAN AND SET HAIBAN COLOR */
if (isHaibanNew($tformNo) == true){
	$memo = "<span style='color: red;'> (廃番)</span>";
} else {
	$memo = "";
}

				//results for sp_plcurent
				$resultCurrent = mysql_query("SELECT * FROM `sp_plcurrent` WHERE `tformNo` = '$tformNo' ") or die(mysql_error());
				if (mysql_num_rows($resultCurrent) == false){
					$sp_plCurrent = "<span style='color: red;'>メーカーPL無し</span>";
					$sp_disc_rate_id = 0;
				}
				while ($rowCurrent = mysql_fetch_assoc($resultCurrent)){
					$sp_plCurrent = $rowCurrent['plCurrent'];
					$sp_disc_rate_id = $rowCurrent['sp_disc_rate_id'];

					//query for the detailed rate info

					$resultTerms = mysql_query("SELECT * FROM `sp_disc_rate` WHERE `id` = '$sp_disc_rate_id' ") or die(mysql_error());
					if (mysql_num_rows($resultTerms) == true){
						while ($rowTerms = mysql_fetch_assoc($resultTerms)){
							$rate = $rowTerms['rate'];
							$percent = $rowTerms['percent'];
							$discountPar = $rowTerms['discountPar'];

						}
					}
				}
				//end of results for sp_plcurrent
if (isHaibanNew($tformNo) == false){

				echo "<div>";

				echo "<div class='listImg' style='float: left;'>";
				if($img != ""){
					echo "<img src='".$filemakerImageLocation.$img."' style='max-width: 45px; max-height: 45px;'>";
				} else {
					echo "<li class='fa fa-picture-o' style='font-size: 40px; color: #CCC;'></li>";
				}
				echo "</div>";
				echo "<div class='listTfNo'>";
				echo $tformNo."<br>";
				echo $makerNo;
				echo "<input type='hidden' name='".$tformNo."' value='".$tformNo."'>";
				echo "</div>";
				echo "<div class='listSeries'>";
				if ($series != ''){
					echo $maker."<br>".$series;
				} else {
					echo $maker;
				}
				echo "</div>";
				//Maker Price List(before discount)
				echo "<div class='listSpecial'>";
				
				echo "<span style='color: #FA555E;'>WEB ".checkOrNot($flgWeb)." | メーカー廃番 ".checkOrNot($flgCancelMaker)." | TFORM廃番 ".checkOrNot($flgCancelTform)." | 販売終了 ".checkOrNot($flgCancelSelling)."</span>";
				
				echo "</div>";
				echo "<div class='listMemo'>".$memo."</div>";

				echo "</div>";
				
		} // if not hinban only show above
			} // end of loop
				function checkOrNot($val){
					$check = "";
					if($val == 1){
						$check = "<i class='fa fa-check-square-o'></i>";
					} else {
						$check = "<i class='fa fa-square-o'></i>";
					}
					return $check;
				}
				
				function checkOrNotFilter($val){
					$check = "";
					if($val == 1){
						$check = " X ";
					} else {
						$check = " ";
					}
					return $check;
				}
			?>
            </div>
            <form method="post" action='exe/exeSetListUpdate.php' id='listSave'>
                <div id="destinationFields"></div>
                <input type="hidden" name='listId' value='<?php echo $idPass;?>'>

            </form>

        </div>
        <!-- PAGE CONTENTS END HERE -->
    </div>
    </div>
    <?php require_once '../master/footer.php';?>
</body>

</html>
