<?php
header("Content-type: application/json; charset=utf-8");
require_once '../../master/dbconnect.php'; // CONNECT TO THE DATABASE


// listName
$listName = $_POST["listName"];

// ------------------------------------------------
// FUNCTIONS
// ------------------------------------------------
function truncate($val, $f="0")
{
	if(($p = strpos($val, '.')) !== false) 
	{
		$val = floatval(substr($val, 0, $p + 1 + $f));
	}
	return $val;
}

// ------------------------------------------------
// INITIALIZE ARRAYS
// ------------------------------------------------

	$rows = array(); // finished array

	$specialItemsArray = array(); // special Items if any

	$compiledArray = array(); // FINISHED COMPLILED ARRAY

    $setTemp = array(); // clears out array
    
    $specialItemsArrayTemp = array(); // clears out array

    $orderNo = "";

    $productSize = "";

    $series = "";

    $img = "";

// ------------------------------------------------
// GET LIST CONTENTS
// ------------------------------------------------

	$sth = mysql_query("SELECT tformNo, specialItems, isHidden FROM makerlistinfo WHERE listName = '$listName' ORDER BY tformNo ASC");
	while ($r = mysql_fetch_assoc($sth))
	{
		$rows[] = array(
			"tformNo" => $r['tformNo'],
			"specialItem" => $r['specialItems'],
			"isHidden" => $r['isHidden']
		);
	}

// ------------------------------------------------
// MAIN LOOP START
// ------------------------------------------------

	for($i = 0; $i < count($rows); $i++)
	{
		// Initialize Variables
		$tfNo = $rows[$i]['tformNo']; // set tformNo to temp variable
		$set = null;
		$makerNo = null;
		$isHaiban = false; // set the haiban to false by default
		$webHyoji = false;
        //$colorVar = false;
		$tformPriceNoTax = null;
		$isSet = false;
		$thumb = null;
		$isHidden = $rows[$i]['isHidden']; // if the item should be shown or not in the list

		
		// ######################################################################################################################################
		// START OF QUERY =======================================================================================================================
		// ######################################################################################################################################
		$sth = mysql_query("SELECT `set`, productSize, series, cancelMaker, cancelTform, cancelSelling, tformPriceNoTax, thumb, web, webVariation FROM main WHERE tformNo = '$tfNo'");
		while ($r = mysql_fetch_assoc($sth))
		{
			
			$set = $r['set']; // set the set contents from the query
			
			// If any of the following are haiban then set haiban to true for the main item.
			if ($r['cancelMaker'] == 1 || $r['cancelTform'] == 1 || $r['cancelSelling'] == 1)
			{
				
				$isHaiban = true;
				
			}
			
			// If there is either web or weVariation tick then go ahead and say it is web hyouji
			if ($r['web'] == 1 || $r['webVariation'] == 1)
			{
				
				$webHyoji = true;
				
			}
			
			$tformPriceNoTax = $r['tformPriceNoTax'];
			
			
			$productSize = $r['productSize'];
			$series = $r['series'];
			
			// -----------------------------------------------------------------------------------------------------------------------------
			// IMG CODE
			// -----------------------------------------------------------------------------------------------------------------------------
			
			
			$thumb = $r['thumb'];
			$img = "";
            $imgLink = "";
			
			//SET IMAGE LOCATION
			$filemakerImageLocation = "http://160.86.229.76/db_img/";
			
			if($thumb != ""){
				$thumRep = str_replace("img/img_phot/photo", "img/img_phot/photo_thum060", $thumb);
				$img = "<img src ='".$filemakerImageLocation.$thumb."'>";
                $imgLink = $filemakerImageLocation.$thumb;
			} else {
				$img = "<li class='fa fa-picture-o' style='font-size: 40px; color: #CCC;'></li>";
                $imgLink = "";
			}
			 
			// -----------------------------------------------------------------------------------------------------------------------------
			
			
			// Remove whitespace from the set array and special item array
			$set = explode(',', preg_replace('/\s+/', '', $set)); 
			$specialItemsArray = explode(',', preg_replace('/\s+/', '', $rows[$i]['specialItem']));
			
			
			// -------------------------------------
			// clean out arrays if empty before join
			// -------------------------------------
			$setTemp = array(); // clears out array
			$specialItemsArrayTemp = array(); // clears out array
			
			// clean out arrays if empty before join
			// NORMAL SET
			foreach ($set as $key => $value)
			{
				if (empty($value))
				{
					unset($set[$key]);// cleans out array if empty
				}
			}
			
			// SPECIAL ITEMS
			foreach ($specialItemsArray as $key => $value)
			{
				if (empty($value))
				{
					unset($specialItemsArray[$key]); // cleans out array if empty
				}
			}
			
			// Initalize the set and special items array if not empty
			if(!empty($set))
			{
				foreach ($set as $key => $value)
				{
					$setTemp[] = array(
						"tformNo" => $value,
						"haiban" => null,
						"makerNo" => null,
						"orderNo" => null,
						"plHistory" => null,
						"plHistoryBai" => null,
						"currency" => null,
						"discountPar" => 0,
						"net" => null,
						"rate" => null,
						"percent" => null,
						"specialItem" => false
					);
				}
			}
			
			if (!empty($specialItemsArray))
			{
				foreach ($specialItemsArray as $key => $value)
				{
					$specialItemsArrayTemp[] = array(
						"tformNo" => $value,
						"haiban" => null,
						"makerNo" => null,
						"orderNo" => null,
						"plHistory" => null,
						"plHistoryBai" => null,
						"currency" => null,
						"discountPar" => 0,
						"net" => null,
						"rate" => null,
						"percent" => null,
						"specialItem" => true
					);
				}
			}
			
		}
		// ######################################################################################################################################
		// END OF QUERY =======================================================================================================================
		// ######################################################################################################################################
		
		// -------------------------------------
		/* UPDATE SET AND SPECIAL ITEMS ARRAY */
		// -------------------------------------

		$set = $setTemp;// update the set array
		$specialItemsArray = $specialItemsArrayTemp;// update the special items array

		// Merge sets into a single array set
		$setModifiedArray = array_merge($set, $specialItemsArray);
		
		// If it is not a set, add the current tform num starts to the array instead.
		if (!empty($setModifiedArray)){
			$isSet = true;
		} else {
			$isSet = false;
			
			$setModifiedArray[] = array(
				"tformNo" => $tfNo,
				"haiban" => $isHaiban,
				"makerNo" => null,
				"orderNo" => null,
				"plHistory" => null,
				"plHistoryBai" => null,
				"historyColorId" => "#CCCCCC",
				"historyYear" => "",
				"historyMemo" => "",
				"currency" => null,
				"plCurrent" => null,
				"plCurrentColorId" => "#CCCCCC",
				"currentYear" => "",
				"currentMemo" => "",
				"discountPar" => 0,
				"net" => null,
				"rate" => null,
				"percent" => null,
				"specialItem" => false,
				"shiire" => null
			);
			
			// add the current info to the $setModifiedArray
		}
		
		// GET INFO FOR THE SET CONTENTS
		
		$totalPrice = null;
		$mainBairitsu = null;
		
		// loop through set tformNo and query for remaining data.
		foreach ($setModifiedArray as $key => $value) 
		{
			// check main for the needed info: makerNo, haiban

			
			$t = $setModifiedArray[$key]['tformNo'];
			$plCurrent = null;
			$currency = null;
			$discount = 0;
			$rate = null;
			$percent = null;
			$shiire = null;
			$colorId = "#CCCCCC";
			$currentYear = "EMPTY";
			$currentMemo = "EMPTY";
			$historyColorId = "#CCCCCC";
			$historyYear = "EMPTY";
			$historyMemo = "EMPTY";
			
			$setItemIsHaiban = false; // initalize the set item hinban
			
			// MAIN --
			$sth = mysql_query("SELECT makerNo, orderNo, cancelMaker, cancelTform, cancelSelling FROM main WHERE tformNo = '$t'");
			while ($r = mysql_fetch_assoc($sth))
			{
				// If any of the following are haiban then set haiban to true for the main item.
				if ($r['cancelMaker'] == 1 || $r['cancelTform'] == 1 || $r['cancelSelling'] == 1)
				{

					$setItemIsHaiban = true;

				}
				
				$makerNo = $r['makerNo'];
				$orderNo = $r['orderNo'];
			}
			
			// sp_plCurrent --
			// sp_disc_rate --
			$sth = mysql_query ("SELECT 
									sp_plcurrent.plCurrent,
									sp_plcurrent.sp_disc_rate_id,
									sp_disc_rate.rate,
									sp_disc_rate.percent,
									sp_disc_rate.discount,
									sp_disc_rate.currency,
									sp_disc_rate.colorId,
									sp_disc_rate.year,
									sp_disc_rate.memo
								 FROM sp_plcurrent
								 INNER JOIN sp_disc_rate ON sp_plcurrent.sp_disc_rate_id = sp_disc_rate.id
								 WHERE 
								 	sp_plcurrent.tformNo = '$t'
								 ");
			
			$a = null; // no history so set default
			$b = null; // no history so set default
			$c = null; // no history so set default
			
			while($r = mysql_fetch_assoc($sth))
			{
				
				// set variables
				$plCurrent = $r['plCurrent'];
				$discRateId = $r['sp_disc_rate_id'];
				$rate = $r['rate'];
				$percent = $r['percent'];
				$discount = $r['discount'];
				$currency = $r['currency'];
				$colorId = $r['colorId'];
				$currentYear = $r['year'];
				$currentMemo = $r['memo'];
				
				// --------------------------------------------------------------------------------------------
				// get history PL here.
				// --------------------------------------------------------------------------------------------
				
				
								
				$sthInner = mysql_query ("SELECT plCurrent, sp_disc_rate_id FROM sp_history 
											WHERE
												tformNo = '$t' AND
												sp_disc_rate_id != $discRateId
												ORDER BY `modified` DESC LIMIT 1
				");
				
				// check if not null first so we are not pulling info from the table when there are no matches.
				if(mysql_num_rows($sthInner) == false){
					$a = "履歴なし"; // no history so set default
					$b = "履歴なし"; // no history so set default
					$c = "履歴なし"; // no history so set default
				} else {
					while($rInner = mysql_fetch_assoc($sthInner)){
						$a = $rInner['sp_disc_rate_id'];
						$b = $rInner['plCurrent'];
						
						// check division by 0
						if ($b == 0 || $plCurrent == 0){
							$c = 0;
						} else {
							$c = (($plCurrent - $b)/$b)*100;
							$c = round($c, 2);
						}
						
					}
				}
				
				// Get the color, year, memo from sp_disc_rate
				$sthHistoryDetails = mysql_query("
					SELECT year, memo, colorId FROM sp_disc_rate
						WHERE
							id = '$a'
				");
				
				if(mysql_num_rows($sthHistoryDetails) == false	 ){
					$historyColorId = "#CCCCCC";
					$historyYear = "EMPTY";
					$historyMemo = "EMPTY";
				} else {
					while($rHistoryDetails = mysql_fetch_assoc($sthHistoryDetails)){
						$historyYear = $rHistoryDetails['year'];
						$historyMemo = $rHistoryDetails['memo'];
						$historyColorId = $rHistoryDetails['colorId'];
					}
				}
				
				// --------------------------------------------------------------------------------------------
				
				// check here if yen or not
				if($currency == 'YEN')
				{
					$shiire = $plCurrent * $discount;
				} else
				{
					$shiire = round(round(($plCurrent*$discount),2)*$rate*(1+($percent/100)),0);
				}
				
				// Count up the total Price
				$totalPrice += $shiire;

			}
			// --------------------------------------
			
			// HERE ADD THE CORRECT ITEMS TO THE SET ARRAY!!
				if (!empty($setModifiedArray)) {
					$setModifiedArray[$key]['haiban'] = $setItemIsHaiban;
					$setModifiedArray[$key]['makerNo'] = $makerNo;
					$setModifiedArray[$key]['orderNo'] = $orderNo;
					$setModifiedArray[$key]['productSize'] = $productSize;
					$setModifiedArray[$key]['series'] = $series;
															
					$setModifiedArray[$key]['plHistory'] = $b;
					$setModifiedArray[$key]['historyColorId'] = $historyColorId;
					$setModifiedArray[$key]['historyYear'] = $historyYear;
					$setModifiedArray[$key]['historyMemo'] = $historyMemo;
										
					$setModifiedArray[$key]['plHistoryBai'] = $c;
					
					$setModifiedArray[$key]['currency'] = $currency;
					
					$setModifiedArray[$key]['plCurrent'] = $plCurrent;
					$setModifiedArray[$key]['plCurrentColorId'] = $colorId;
					$setModifiedArray[$key]['currentYear'] = $currentYear;
					$setModifiedArray[$key]['currentMemo'] = $currentMemo;
					
					// if Dont do this then result would be 100% instead of 0%
					if ($discount == 0){
						$setModifiedArray[$key]['discountPar'] = 0;
					} else {
						$setModifiedArray[$key]['discountPar'] = (100-($discount*100));
					}
					$setModifiedArray[$key]['net'] = round(($plCurrent * $discount),2);
					$setModifiedArray[$key]['rate'] = $rate;
					$setModifiedArray[$key]['percent'] = $percent;
					
					$setModifiedArray[$key]['shiire'] = $shiire;
				}
		}
		
		// add up biritsu for main
		// check for 0 before division
		if($tformPriceNoTax == 0 || $totalPrice == 0){

			$mainBairitsu = 0;

		} else {

			$mainBairitsu = round(($tformPriceNoTax/$totalPrice),2);

		}
		
		$compiledArray[] =
		array(
			"tformNo" => $tfNo,
			"haiban" => $isHaiban,
			"webHyoji" => $webHyoji,
			"isSet" => $isSet,
			"productSize" => $productSize,
			"series" => $series,
			"setContents" => $setModifiedArray,
			"totalPrice" => $totalPrice,
			"bairitsu" => $mainBairitsu,
			"tformPriceNoTax" => $tformPriceNoTax,
			"image" => $img,
            "imageLink" => $imgLink,
			"isHidden" => $isHidden
		);
		
	}
// ------------------------------------------------
// MAIN LOOP END
// ------------------------------------------------


// ------------------------------------------------
// SEND BACK FINAL RESULTS FOR FINISHED ROW DATA
// ------------------------------------------------

	echo json_encode($compiledArray, JSON_PRETTY_PRINT);

?>