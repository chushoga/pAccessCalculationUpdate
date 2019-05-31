<?php date_default_timezone_set('Asia/Tokyo'); require_once '../../master/dbconnect.php';

		/////////////////////////////// SET VARIABLES ///////////////////////////////
		/////////////////////////////////////////////////////////////////////////////
		
		$jpRate = $_POST['tax']/100;
        
		$date = $_POST['date'];
		$forwarder = $_POST['forwarder'];
		$vessle = $_POST['vessle'];
		$packing = $_POST['packing'];
		// set the number of differnt variables
		// loop 20 times
		//SET LOOP TIMES
		$l=20;
		//

		$topAmountSub = 0;
		$topRateSub = 0;
		
		$divide = 0;
		
		$topMakerTotal = $topAmountSub + $topRateSub;
		// ------------------------------------
		if ($_POST['bankChargeTotal'] == ''){
		    $bankCharge = $_POST['bankCharge'];
		    $bankChargeTimes = $_POST['bankChargeTimes'];
		    $bankChargeTotal = $bankCharge * $bankChargeTimes;
		} else {
		    $bankCharge = $_POST['bankCharge'];
		    $bankChargeTimes = $_POST['bankChargeTimes'];
		    $bankChargeTotal = $_POST['bankChargeTotal'];
		}
		if ($_POST['shippingChargeTotal'] == ''){
		    $shippingCharge = $_POST['shippingCharge'];
		    $shippingChargeTimes = $_POST['shippingChargeTimes'];
		    $shippingChargeTotal = $shippingCharge * $shippingChargeTimes;
		} else {
		    $shippingCharge = $_POST['shippingCharge'];
		    $shippingChargeTimes = $_POST['shippingChargeTimes'];
		    $shippingChargeTotal = $_POST['shippingChargeTotal'];
		}
		$shippingTotal = $_POST['shippingTotal'];
		$insuranceTotal = $_POST['insuranceTotal'];
		$clearanceTotal = $_POST['clearanceTotal'];
		$customsTotal = $_POST['customsTotal'];
		$inspectionTotal = $_POST['inspectionTotal'];
		$inlandShippingTotal = $_POST['inlandShippingTotal'];
		$otherTotal = $_POST['otherTotal'];
		$consumptionTaxTotal = ($customsTotal+$inlandShippingTotal+$otherTotal)*$jpRate;
		$tarrifTotal = $_POST['tarrifTotal'];
		$memo = $_POST['memo'];
		$consumptionTotal = $_POST['consumptionTotal'];
		//$localConsumptionTotal = $_POST['localConsumptionTotal'];

		// top total -------------
		//$topTotal =
		//$currency2 * $rate;
		//bottom total -----------
		$bottomTotal =
		$bankChargeTotal +
		$shippingTotal +
		$shippingChargeTotal +
		$insuranceTotal +
		$clearanceTotal +
		$customsTotal +
		$inspectionTotal +
		$inlandShippingTotal +
		$otherTotal +
		$consumptionTaxTotal +
		$tarrifTotal;
		//---------------------------------------------------------------------------
          // INSERT CODE
				
		         $sql = "INSERT INTO expense 
		         			(
		         			`date`, 
		         			`forwarder`,
							`vessle`,
							`packing`,
							`bankCharge`,
							`bankChargeTimes`,
							`bankChargeTotal`,
							`shippingTotal`,
							`shippingCharge`,
							`shippingChargeTimes`,
							`shippingChargeTotal`,
							`insuranceTotal`,
							`clearanceTotal`,
							`customsTotal`,
							`inspectionTotal`,
							`inlandShippingTotal`,
							`otherTotal`,
							`tarrifTotal`,
							`memo`,
							`consumptionTotal`,
							`jpRate`
							) 
							VALUES
							(
							 '$date',
		         			'$forwarder',
							'$vessle',
							'$packing',
							'$bankCharge',
							'$bankChargeTimes',
							'$bankChargeTotal',
							'$shippingTotal',
							'$shippingCharge',
							'$shippingChargeTimes',
							'$shippingChargeTotal',
							'$insuranceTotal',
							'$clearanceTotal',
							'$customsTotal',
							'$inspectionTotal',
							'$inlandShippingTotal',
							'$otherTotal',
							'$tarrifTotal',
							'$memo',
							'$consumptionTotal',
							'$jpRate'
							)";
                $result = mysql_query($sql);
                
		$id = mysql_insert_id();
		//-----------------------------------------------------------------------------
	
            for ($i = 1; $i<=$l; $i++) {
            
            if ($orderNo_[$i] == ' '){
		        $orderNo_[$i] = 0;
    		    $makerName_[$i] = 0;
    		    $currency1_[$i] = 0;
    		    $currency2_[$i] = 0;
    		    $rate_[$i] = 0;
				$date_[$i] = "";
		    } else {
    		        $orderNo_[$i] = $_POST['orderNo_'.$i];
    		        $makerName_[$i] = $_POST['makerName_'.$i];
    		        $currency1_[$i] = $_POST['currency1_'.$i];
    		        $currency2_[$i] = $_POST['currency2_'.$i];
    		        $rate_[$i] = $_POST['rate_'.$i];
					$date_[$i] = $_POST['date_'.$i];
		    }
		    
		    $orderNo = "orderNo_$i";
		    $makerName = "makerName_$i";
		    $currency1 = "currency1_$i";
		    $currency2 = "currency2_$i";
		    $rate = "rate_$i";
			$recordDate = "date_$i";
			
		    $sql = "UPDATE expense SET 
 			`$orderNo` = '$orderNo_[$i]',
			`$makerName` = '$makerName_[$i]',
			`$currency1` = '$currency1_[$i]',
			`$currency2` = '$currency2_[$i]',
			`$rate` = '$rate_[$i]',
			`$recordDate` = '$date_[$i]'
			WHERE
				`id` = '$id'
			";
            $result = mysql_query($sql);


//----------------------------------------------------------------------------	
		    if ($rate_[$i] != ''){
		        // top sub total -------------
		        $topSubTotal_[$i] = $currency2_[$i] * $rate_[$i];
		    } else {
		        // top sub total -------------
		        $topSubTotal_[$i] = $currency2_[$i];
		    }

		    $topAmountSub += $currency2_[$i];
		    $topRateSub += $rate_[$i];
		    // set amount of times to divide to get the rateSubtotal
		    if( $rate_[$i] != '') {
		        $divide++;
		    }
		    //-----------------------------------------------------

		}
          
		//---------------------------------------------------------------------------
        // SAVED CODE
/*
				 $resultVar = mysql_query("SELECT * FROM expense WHERE `id` = '$id' ") or die(mysql_error());
				while ($rowVar = mysql_fetch_assoc($resultVar)){
			    $date = date ('Y.m.d', strtotime($rowVar['date']));
    		    $forwarder = $rowVar['forwarder'];
    		    $vessle = $rowVar['vessle'];
		        $packing = $rowVar['packing'];
		        
		if ($rowVar['bankChargeTotal'] == ''){
		    $bankCharge = $rowVar['bankCharge'];
		    $bankChargeTimes = $rowVar['bankChargeTimes'];
		    $bankChargeTotal = $bankCharge * $bankChargeTimes;
		} else {
		    $bankCharge = $rowVar['bankCharge'];
		    $bankChargeTimes = $rowVar['bankChargeTimes'];
		    $bankChargeTotal = $rowVar['bankChargeTotal'];
		}
		if ($rowVar['shippingChargeTotal'] == ''){
		    $shippingCharge = $rowVar['shippingCharge'];
		    $shippingChargeTimes = $rowVar['shippingChargeTimes'];
		    $shippingChargeTotal = $shippingCharge * $shippingChargeTimes;
		} else {
		    $shippingCharge = $rowVar['shippingCharge'];
		    $shippingChargeTimes = $rowVar['shippingChargeTimes'];
		    $shippingChargeTotal = $rowVar['shippingChargeTotal'];
		}
		$shippingTotal = $rowVar['shippingTotal'];
		$insuranceTotal = $rowVar['insuranceTotal'];
		$clearanceTotal = $rowVar['clearanceTotal'];
		$customsTotal = $rowVar['customsTotal'];
		$inlandShippingTotal = $rowVar['inlandShippingTotal'];
		$otherTotal = $rowVar['otherTotal'];
		$consumptionTaxTotal = ($customsTotal+$inlandShippingTotal+$otherTotal)*$jpRate;
		$tarrifTotal = $rowVar['tarrifTotal'];
		$memo = $rowVar['memo'];
		$consumptionTotal = $rowVar['consumptionTotal'];
		//$localConsumptionTotal = $rowVar['localConsumptionTotal'];
		    
				}
		$C = (($consumptionTotal)/$z)*100;
		*/
		//-----------------------------------------------------------------------------
header("location: ../expense.php?pr=3&id=$id&message=success");		

		?>
