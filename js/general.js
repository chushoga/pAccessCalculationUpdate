<script>

$('div.success').delay(0).fadeIn(800);
$('div.success').delay(2000).fadeOut(800);

$('div.error').delay(0).fadeIn(800);
$('div.error').delay(2000).fadeOut(800);

$('div.warning').delay(0).fadeIn(800);
$('div.warning').click(function(){
	$('div.warning').delay(2000).fadeOut(800);
});


$('div.info').delay(0).fadeIn(800);
$('div.info').delay(3000).fadeOut(800);



function confirmAction(){
    var confirmed = confirm("注意！削除してからレコードが消えます. いいですか？");
    return confirmed;
}
</script>

<script type="text/javascript">
$(function(){
	  $('ul.tabs li:first').addClass('active');
	  $('.block article').hide();
	  $('.block article:first').show();
	  $('ul.tabs li').on('click',function(){
	    $('ul.tabs li').removeClass('active');
	    $(this).addClass('active')
	    $('.block article').hide();
	    var activeTab = $(this).find('a').attr('href');
	    $(activeTab).show();
	    return false;
	  });
	})
</script>


<script type="text/javascript">

function truncate(num,precision) {
    var muldiv = Math.pow(10,precision-1);
    return Math.floor(num * muldiv) / muldiv;
}

</script>

<script type="text/javascript">


jQuery(function($) {
	
	  var PriceTextbox1 = $("#txtPurePrice1"); // main input
	  
	  var ResultTextbox1 = $("#txtfctTaxValue1"); // first result
	  var textbox1 = $("#txtTaxPercent1"); // cost 
	  
	  var ResultTextbox2 = $("#txtfctTaxValue2");
	  var textbox2 = $("#txtTaxPercent2");  
	  
	  var ResultTextbox3 = $("#txtfctTaxValue3");
	  var textbox3 = $("#txtTaxPercent3");  


		$([textbox1[0], PriceTextbox1[0]]).bind("change keyup keydown paste", function(e) {
		    var Result1;
		    Result1 = parseFloat(PriceTextbox1.val()) / parseFloat(textbox1.val());
		    ResultTextbox1.val(truncate(Result1, 3));
		});  

		$([textbox2[0], PriceTextbox1[0]]).bind("change keyup keydown paste", function(e) {
		    var Result2;
		    Result2 = parseFloat(PriceTextbox1.val()) / parseFloat(textbox2.val());
		    ResultTextbox2.val(truncate(Result2, 3));
		});
		
		$([textbox3[0], PriceTextbox1[0]]).bind("change keyup keydown paste", function(e) {
		    var Result3;
		    Result3 = parseFloat(PriceTextbox1.val()) / parseFloat(textbox3.val());
		    ResultTextbox3.val(truncate(Result3, 3));
		});
		

		
});

</script>
<script type="text/javascript">
$("#insert-more").click(function () {
	newRow = "<tr>" +
	"<td style='border-left: none;'><input type='text' name='orderNo'></td>" +
    "<td><input type='text' name='makerName'></td>" +
    "<td><select name='rate1'><option value='EUR'>EUR</option><option value='US$'>US$</option><option value='CNY'>CNY</option><option value='JPY'>JPY</option></select> <input style='width: 80px;' type='text' name='rate2'></td>" +
    "<td><input style='width: 50px;' type='text' name='currency'></td>" +
    "<td style='font-size: 10px; text-align: right; border-right: none;'>￥0,000</td>" +
"</tr>";
$('.sheetTable1 > tbody > tr:last').after(newRow); 
});

</script>

<script type="text/javascript">

function YNconfirm(id) {
    if (window.confirm('削除してもよろしいでしょうか?'))
    {
    	location.href = 'exe/delExpense.php?id=' + id;
        return true;
    }
    else
        return false;
};
</script>

<script type="text/javascript">
function validateForm()
{
var x=document.forms["inputForm"]["tax"].value;

var a=document.forms["inputForm"]["orderNo_1"].value;
var b=document.forms["inputForm"]["makerName_1"].value;
var c=document.forms["inputForm"]["currency2_1"].value;
var d=document.forms["inputForm"]["rate_1"].value;

if (
		x==null || x=="" ||
		a==null || a=="" ||
		b==null || b=="" ||
		c==null || c=="" ||
		d==null || d==""
)
{
alert("消費税, オーダーNo, メーカー名, 外貨代金, 為替レート 必要です");
return false;
} else {
	  document.getElementById('expenseInputForm').submit();
}
}

</script>
<script type="text/javascript">
function validateTermsAndConditionsForm()
{
var x=document.forms["inputForm"]["maker"].value;
var a=document.forms["inputForm"]["year"].value;
var b=document.forms["inputForm"]["rate"].value;
var c=document.forms["inputForm"]["percent"].value;
var d=document.forms["inputForm"]["netTerm"].value;
var e=document.forms["inputForm"]["sp1"].value;
var j=document.forms["inputForm"]["currency"].value;


if (
		x==null || x=="" ||
		a==null || a=="" ||
		b==null || b=="" ||
		c==null || c=="" ||
		d==null || d=="" || d=="選ぶ" ||
		e==null || e=="" ||
		j==null || j=="" || j=="選ぶ"
)
{
alert("※の場所で必ず書いてください");
return false;
} else {
	  document.getElementById('termsAndConditionsInputForm').submit();
}
}
/* maker PL import */
$('.openUpload').click(function(){
	$('.importMakerPL').toggle("slide", {direction: "up" }, 500);			
});
$('.closeUpload').click(function(){
	$('.importMakerPL').toggle("slide", {direction: "up" }, 500);			
});
/*FileMaker Import*/
$('.openFMUpload').click(function(){
	$('.importFileMaker').toggle("slide", {direction: "up" }, 500);			
});
$('.closeFMUpload').click(function(){
	$('.importFileMaker').toggle("slide", {direction: "up" }, 500);			
});
/*General History*/
$('.openGeneralHistory').click(function(){
	$('.showGeneralHistoryBox').toggle("slide", {direction: "up" }, 500);			
});
$('.closeGeneralHistory').click(function(){
	$('.showGeneralHistoryBox').toggle("slide", {direction: "up" }, 500);			
});


function checkListName()
{
    if (document.getElementById('listName').value==""
     || document.getElementById('listName').value==undefined
     || document.getElementById('makerName').value==""
	 || document.getElementById('makerName').value==undefined)
    {
        alert ("メーカー名・リスト名入れてください！");
        return false;
    }
    document.getElementById('listSave').submit();
    return true;
    
}




</script>

