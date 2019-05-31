<?php
$pr = $_GET['pr'];
echo "
							<form method='GET' action='tfProject.php' id='searchForm'>
                            <span style='float: right; margin-right: 10px;'>
                            <input type='text' name='search' class='searchBar'>
                            <input type='hidden' name='pr' value='$pr'>
                            <input type='hidden' name='record' value='0'> "; ?>
                            <button onClick="document.getElementById('searchForm').submit()" id='searchBtn'><i class="fa fa-search"></i></button>
                           
                            <?php echo "</span></form>";
?>