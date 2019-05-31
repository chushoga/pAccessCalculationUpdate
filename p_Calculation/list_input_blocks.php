<?php 

$counterTemp++;

echo "<div>";
echo "<div class='listImg'>";
if($img != ""){
    echo "<img src='http://www.tform.co.jp/$img' style='max-width: 45px; max-height: 45px;'>";
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
echo "[ ".$counterTemp." ] ";

echo "</div>";


echo "<div class='listSpecial'>";
if ($set != ''){
echo "<span style='color: red;'> (セット) </span>";
}
/*
echo "".$mainPlCounter;
echo "-";
echo "".$searchNoPl;
echo "-";
echo "".$innerSetChecker;
*/
if ($mainPlCounter != 1) {
    echo "";
} else {
    echo "<span style='color: #C771F0;'>入力不足</span>";
}
echo "</div>";
if ($web == 1){
    $webShow = "WEB紹介<span style='color: #E34B4B'> <i class='fa fa-check-square-o'></i></span>";
} else {
    $webShow = "WEB紹介  <i class='fa fa-square-o'></i>";
}
echo "<div class='listMemo'>".$memo." ".$webShow."</div>";

echo "</div>";

?>