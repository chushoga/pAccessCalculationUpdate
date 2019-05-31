<?php require_once '../master/head.php';?>
<!DOCTYPE HTML>
<html lang="jp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title;?></title>
<?php
include_once '../master/config.php'; ?>
<script type="text/javascript">
$(document).ready( function() {

	/*AUTOCOMPLETE*/
	 $(function() {
		function log( message ) {
			$( "<div>" ).text( message ).prependTo( "#log" );
			$( "#log" ).scrollTop( 0 );
		}
		function discount( message2 ) {
				$( "<div>" ).text( message2 ).prependTo( "#logDiscountPar" );
				$( "#logDiscountPar" ).scrollTop( 0 );
				$( "<span>" ).text( message2 ).prependTo( ".logDiscountPar" );
				$( ".logDiscountPar" ).scrollTop( 0 );
		}
		function rate( message3 ) {
				$( "<div>" ).text( message3 ).prependTo( "#logRate" );
				$( "#logRate" ).scrollTop( 0 );
		}
		function percent( message4 ) {
				$( "<div>" ).text( message4 ).prependTo( "#logPercent" );
				$( "#logPercent" ).scrollTop( 0 );
		}
		function currency( message5 ) {
				$( "<div>" ).text( message5 ).prependTo( "#logCurrency" );
				$( "#logCurrency" ).scrollTop( 0 );
		}
		function productType( message6 ) {
				$( "<div>" ).text( message6 ).prependTo( "#productType" );
				$( "#productType" ).scrollTop( 0 );
		}

		$( "#makerImp" ).autocomplete({
				source: "exe/autocompleteTermsAndConditions.php",
				minLength: 2,
				select: function( event, ui ) {
				log( ui.item ?
				ui.item.label :
			"Nothing selected, input was " + this.value );
				discount( ui.item ?
						  ui.item.labelDiscountPar :
			"Nothing selected, input was " + this.value );
				rate( ui.item ?
						  ui.item.labelRate :
			"Nothing selected, input was " + this.value );
				percent( ui.item ?
						  ui.item.labelPercent :
			"Nothing selected, input was " + this.value );
				currency( ui.item ?
						  ui.item.labelCurrency :
			"Nothing selected, input was " + this.value );
			 }
		});

		$( "#productTypeImp" ).autocomplete({
				source: "exe/autocompleteType.php",
				minLength: 2,
				select: function( event, ui ) {
				productType( ui.item ?
				ui.item.labelproductType :
			"Nothing selected, input was " + this.value );
			 }
		});
	});

	$('#loading').delay(300).fadeOut(300);

	$(window).keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
});
</script>

<style type="text/css">
	.insertSingleBox {
		position: absolute;
		width: 100%; 
		height: 100px;
		top: calc(30% - 50px);
		background-color: #FFF;
		text-align: center;
	}

	.insertSingleBoxWrapper {
		width: 1500px;
		margin-left: auto;
		margin-right: auto;
		background-color: #FFF;
	}

	.preview {
		background-color: #CCF;
		float: left;	
		text-align: right;
		padding: 10px;
		outline: 2px solid #CCC;
	}

	.preview input[type=text]{
		width: 600px;
	}

	#calcMainInfo2 {
		outline: 2px solid #CCC;
		margin-left: 5px;
		width: 700px;
		background-color: #FFF;
		padding: 10px;
		float: left;
	}
</style>
	
</head>
<body>
<div id='wrapper'>
<!-- 
<div id='loading'>
		<span class='loadingGifMain'>
			<img src='<?php echo $path;?>/img/142.gif'><br>
			LOADING ...
		</span>
</div>
-->
<?php require_once '../header.php';?>
<div class='contents'>
<!-- PAGE CONTENTS START HERE -->
	<div class='insertSingleBox'>
			<div class='insertSingleBoxWrapper'>
			<h2>単品入力</h2>
			<div class='preview'>
				<form action="exe/exeInsertSingle.php" method="POST">
					品番:
					<input type='text' id='maker' style='width: 40px; padding: 2px; font-size: 14px;' maxlength='3'>
					<input type='text' id='type' style='width: 35px; padding: 2px; font-size: 14px;'  maxlength='2'>
					<input type='text' id='model' style='width: 45px; padding: 2px; font-size: 14px;'  maxlength='4'>
					<input type='text' id='color' style='width: 32px; padding: 2px; font-size: 14px;'  maxlength='3'>
					<br><br><input type='hidden' name='tformNo' value='' class='output' style='padding: 2px; font-size: 14px;'><br>

					メーカー品番: <input type='text' name='makerNo' id='makerNo'><br><br>
					タイプ: <input type='text' name='productType' id='productTypeImp'><br><br>
					メーカー名: <input type='text' name='maker' id='makerName'><br><br>
					シリーズ: <input type='text' name='series' id='series'><br><br>
					伝票詳細表記:<input type='text' name='memo' id='memo'><br><br>
					PL: <input type='text' name='pl' id='pl'><br><br>

					<label for="maker">dbID/メーカー: </label>
					<input id="makerImp" name='rate_disc_id' style='width: 50px; height: 19px; text-align: center;'><br>
					<input type='hidden' name='tformPriceNoTax' id='rateTest'>

					<div class="ui-widget" style='float: left; margin-left: 3px; font-size: 10px;'>
						<div id="log" style=""></div>
					</div><br>

					TF価格: <input type='text' name='tformPriceNoTax' id='tformPriceNoTax'><br><br>

					<input type='submit' value='決定' class='submit' style='margin-top: 10px;' onClick="return confirm('単品品番追加宜しいですか？')">
				</form>
			</div>

			<div id='calcMainInfo2'>
				<table border="0">
					<tr>
						<td> 更新日:</td>
						<td>
							<div class='toptd'  style='width: 125px;'>
							  <?php echo date("Y/m/d")?>
							</div>
						</td>
						<td>PL:</td>
						<td> 
							<div class='toptd' style='width: 150px;'>
								<span class='pl'></span>
							</div>
						</td>
						<td rowspan='8' style='max-width: 200px;'>
							<div style='width: 200px; height: 200px; background-color: #CCC; text-align: center;'>
							<?php
								echo "<li class='fa fa-picture-o' style='font-size: 80px; color: #FFF; line-height: 200px;'></li>";
							?>
							</div>
						</td>
					</tr>
					<tr>
						<td>品番:</td>
						<td>
							<div class='toptd'>
								<span class='output'></span>
							</div>
						</td>
						<td>通貨:</td>
						<td>
							<div class='toptd'>
								 <div id="logCurrency" style=""></div>
							</div>
						</td>
					</tr>
					<tr>
						<td>メーカー品番:</td>
						<td>
							<div class='toptd'>
							   <span class='makerNo'></span>
							</div>
						</td>
						<td>%割引:</td>
						<td>
							<div class='toptd'>
									<div id="logDiscountPar" style="" ></div>
							</div>
						</td>
					</tr>
					<tr>
						<td>タイプ:</td>
						<td>
							<div class='toptd'>
								<div id='productType'></div>
							</div>
						</td>
						<td>NET(PL):</td>
						<td>
							<div class='toptd'>
								<span class='netPrice'></span>
							</div>
						</td>
					</tr>
					<tr>
						<td>メーカー:</td>
						<td>
							<div class='toptd'>
								<span class='makerName'></span>
							</div>
						</td>
						<td>レート:</td>
						<td>
							<div class='toptd'>
								<div id="logRate" style="" ></div>
							</div>
						</td>
					</tr>
					<tr>
						<td>シリーズ:</td>
						<td>
							<div class='toptd'>
								<span class='series'></span>
							</div>
						</td>
						<td>%:</td>
						<td >
							<div class='toptd'>
								<div id="logPercent" style=""></div>
							</div>
						</td>
					</tr>

					<tr>
						<td class='topth'>伝票詳細表記:</td>
						<td  style='color: red;'>
							<div class='toptd'>
								<span class='memo'></span>
							</div>
						</td>

						<td>原価:</td>
						<td>
							<div class='toptd'></div>
						</td>
					</tr>
					
					<tr>
						<td></td>
						<td></td>

						<td>TF価格:</td>
						<td>
							<div class='toptd' style='font-size: 11px;'>
								<span class='tformPriceNoTax'></span>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>

		<script>
			jQuery(function($) {
				var InputA = $("#maker");
				var InputB = $("#type");
				var InputC = $("#model");
				var InputD = $("#color");

				var Output = $(".output");
				var OutputHidden = $(".output");

				var InputE = $("#makerNo");
				//var InputF = $("#productType");
				var InputG = $("#makerName");
				var InputH = $("#series");
				var InputI = $("#memo");
				var InputJ = $("#pl");
				var InputK = $("#tformPriceNoTax");

				var OutputE = $(".makerNo");
				//var OutputF = $(".productType");
				var OutputG = $(".makerName");
				var OutputH = $(".series");
				var OutputI = $(".memo");
				var OutputJ = $(".pl");
				var OutputK = $(".tformPriceNoTax");

				$([InputA[0], InputB[0], InputC[0], InputD[0]]).bind("change keyup keydown paste", function(e) {
					var Result;
					Result = InputA.val().toUpperCase() + "" + InputB.val() + "-" + InputC.val() + "-" + InputD.val().toUpperCase();
					OutputHidden.val(Result);
					Output.text(Result);
				});

				$([InputE[0]]).bind("change keyup keydown paste", function(e) {
					var Result;
					Result = InputE.val();
					OutputE.text(Result);
				});
				/* /product type
				$([InputF[0]]).bind("change keyup keydown paste", function(e) {
					var Result;
					Result = InputF.val();
					OutputF.text(Result);
				});
				*/
				$([InputG[0]]).bind("change keyup keydown paste", function(e) {
					var Result;
					Result = InputG.val();
					OutputG.text(Result);
				});
				$([InputH[0]]).bind("change keyup keydown paste", function(e) {
					var Result;
					Result = InputH.val();
					OutputH.text(Result);
				});
				$([InputI[0]]).bind("change keyup keydown paste", function(e) {
					var Result;
					Result = InputI.val();
					OutputI.text(Result);
				});
				$([InputJ[0]]).bind("change keyup keydown paste", function(e) {
					var Result;
					Result = InputJ.val();
					OutputJ.text(Result);
				});
				$([InputK[0]]).bind("change keyup keydown paste", function(e) {
					var Result;
					Result = "￥" + InputK.val().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
					OutputK.text(Result);
				});
			});
		</script>
<!-- PAGE CONTENTS END HERE -->
		</div>
</div>
<?php require_once '../master/footer.php';?>
</body>
</html>