<!DOCTYPE HTML>
<html lang="jp">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- JQUERY JS -->
    <script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
    <style>
        #differenceTable {
            border: 1px solid #FFF;
            border-collapse: collapse;
            text-align: center;
        }
        #differenceTable td {
            padding: 5px;
            border: 1px solid #FFF;
            border-collapse: collapse;
        }
        #differenceTable tr:nth-child(odd) {
            background: crimson;
            color: white;
        }
        
        #differenceTable tr:nth-child(odd) button {
            background: green;
            color: white;
            width: 50px;
            height: 50px;
        }
    </style>
    <script>
        $(document).ready(function(){
	
	// ******************************************************************************************
	// GLOBAL VARIABLES
	// ******************************************************************************************

	// ******************************************************************************************
	//  _____                 _   _
	// |  ___|   _ _ __   ___| |_(_) ___  _ __  ___
	// | |_ | | | | '_ \ / __| __| |/ _ \| '_ \/ __|
	// |  _|| |_| | | | | (__| |_| | (_) | | | \__ \
	// |_|   \__,_|_| |_|\___|\__|_|\___/|_| |_|___/
	// ******************************************************************************************

	// submit the file input to get info for csv
	function SubmitFilemakerCSV(csv){
        
        var counter = 0;
        
        //var formData = new FormData();
        //formData.append('filename', csv);
        //formData.append('action', 'ChangeTformNo');
                
		$.ajax({
			type: "POST",
			url: "exe/processUpdateTformNo.php",
			data: csv,
            cache: false,
			contentType: false,
			processData: false,
			success: function(data){
                //console.log(data[1].from);
                //console.log(data[1].to);
                console.log("-----------------------------");
                console.log(data);
                console.log("-----------------------------");
				if(data == ""){
					//LoadMessage("info", "No Cleaning needed! Everything is ok!");
                    console.log("hummm");
				}
				
				if (data != "error"){

					var table = $("#differenceTable tbody");

					// clear table first.
					table.empty();
                    var content = "";

					for(var i = 0; i < data.length; i++){
                        if(data[i].from != undefined){
                            counter++;
                            
                            content = "\
                                <tr>\
                                    <td>"+counter+"</td>\
                                    <td>"+data[i].from+"</td>\
                                    <td>"+data[i].to+"</td>\
                                </tr>\
                            ";
                            
                            table.append(content);
                        }
                        
					}

				} else {
					//LoadMessage("error", data + ": Check CSV. If Maker name does not match for all then error. If not saved as BOMなしwill get error.");
                    console.log("errr");
				}
                
                $("#counter").html(counter + " items.");
                 
			},
			error: function(e){
                console.log("ERROR something");
				console.log(e);
				//LoadMessage("error", "No CSV or Empty CSV selected. Check format and try again.");
			}
		});
	}

    
    function CleanTformNoFromTable(){
        
        var tableName = $("#cleanTformNoFromTableInput").val();
        
        $.ajax({
			type: "POST",
			url: "exe/processUpdateTformNo.php",
			data: "action=CleanTformNoFromTable&tableName="+tableName,
			success: function(data){
                console.log(data);
            }, 
            error: function(){
                
            }
        });
    }
           
    function AddProductId(){
        
        var tableName = $("#addProductIdInput").val();
        
        if(tableName != "" && tableName != " "){
            $.ajax({
			type: "POST",
			url: "exe/processUpdateTformNo.php",
			data: "action=AddProductId&tableName="+tableName,
			success: function(data){
                
              console.log(data);
              console.log("TEST");
                
                var table = $("#differenceTable tbody");

					// clear table first.
					table.empty();
                    var content = "";
                    var counter = 0;
					for(var i = 0; i < data.length; i++){
                        
                        counter++;

                        content = "\
                            <tr>\
                                <td>"+counter+"</td>\
                                <td>"+data[i].productId+"</td>\
                                <td>"+data[i].tformNo+"</td>\
                            </tr>\
                        ";

                        table.append(content);

                        
					}
              
                },
                error: function(e){
                    console.log(e);
                }
            });
        }
        
    }
           
    function CleanDoubles(){
        var listName = $("#cleanDoublesInput").val();
        
        if(listName != "" && listName != " "){
            $.ajax({
			type: "POST",
			url: "exe/processUpdateTformNo.php",
			data: "action=CleanDoubles&listName="+listName,
			success: function(data){
                
              console.log(data);
              console.log("TEST");
                
                var table = $("#differenceTable tbody");

					// clear table first.
					table.empty();
                    var content = "";
                    var counter = 0;
					for(var i = 0; i < data.length; i++){
                        
                        counter++;

                        content = "\
                            <tr>\
                                <td>"+counter+"</td>\
                                <td>"+data[i].id+"</td>\
                                <td>"+data[i].listName+"</td>\
                                <td>"+data[i].productId+"</td>\
                                <td>"+data[i].tformNo+"</td>\
                                <td>"+data[i].testPrice+"</td>\
                                <td>"+data[i].haiban+"</td>\
                                <td>"+data[i].checked+"</td>\
                                <td>"+data[i].memo+"</td>\
                                <td>"+data[i].specialItems+"</td>\
                                <td>"+data[i].isHidden+"</td>\
                                <td><button class='deleteRow' data-listname='"+data[i].listName+"' data-id='"+data[i].id+"'> DEL </button></td>\
                            </tr>\
                        ";

                        table.append(content);
                        
					}
              
                },
                error: function(e){
                    console.log(e);
                }
            });
        }
    }

    // Delete the single item from the list
    function DeleteFromTable(listName, id){
        
        $.ajax({
            type: "POST",
            url: "exe/processUpdateTformNo.php",
            data: "action=DeleteFromTable&listName="+listName+"&id="+id,
            success: function(data){
                console.log(data);
            },
            error: function(e){
                alert("error");
                console.log(e);
            }
        });
        
    }
	// ******************************************************************************************
	//  _____                 _
	// | ____|_   _____ _ __ | |_ ___
	// |  _| \ \ / / _ \ '_ \| __/ __|
	// | |___ \ V /  __/ | | | |_\__ \
	// |_____| \_/ \___|_| |_|\__|___/
	// ******************************************************************************************
	
    // -- ADD tform product ids --
    $("#AddProductId").on("click", function(){
        AddProductId();
    });
           
    // -- ADD tform product ids --
    $("#cleanTformNoFromTable").on("click", function(){
        CleanTformNoFromTable();
    });
           
    // -- CLEAN doubles --
    $("#cleanDoubles").on("click", function(){
        CleanDoubles();
    });
           
    $("body").on("click", ".deleteRow", function(){
        console.log("ffff");
        var listName = $(this).attr("data-listname");
        var id = $(this).attr("data-id");
        
        $(this).closest("tr").fadeOut();
        
        DeleteFromTable(listName, id);
        
    });
           
           
	// ******************************************************************************************
	/* FORM */
	// ******************************************************************************************
	
	// -- Submit Form --
	$("body").on("click", "#submitBtn", function(){
		
		// --------------------------------------------------------
		// TEST CHECK, uncomment this once IsSameMaker is fixed.
		
		var form = $("#csvForm");
		var data = new FormData(form[0]);
		
		var input = $.trim($("#searchInput").val());
		
        SubmitFilemakerCSV(data);
        
        
		// check if not empty first
		/*
		if(input.length > 0){
			
		} else {
			console.log("empty");
		}
		*/
		// --------------------------------------------------------
		
	});
	
	// -- open file callback --
	$("#csvFileInput").on("change", function(e){
		var fileName = e.target.files[0].name;
		var target = $("#selectedFileNameText");
		
		target.text(fileName);
	});

});
    </script>

</head>

<body>
    <?php 
        
            echo 'Current PHP version: ' . phpversion();
        
        ?>
    <div class='importFileMaker'>

        <!-- *********************************************** -->

        <h1>Clean table of non-existant tformNo</h1>
        <button id="cleanTformNoFromTable">
            Clean <b>tformNo</b> that are not in the main table from:
        </button>
        <input type="text" id='cleanTformNoFromTableInput'> table. (sp_plcurrent, sp_plupdate, sp_history, makerlistinfo)
        <br>
        <hr>

        <!-- *********************************************** -->

        <h1>Update and Add productId(file maker Id) to TformNo that do not currently have them.</h1>
        
        <input type="text" id='addProductIdInput'>
        <button id="AddProductId">ADD Product Id to existing tformNo</button>
        <br>
        <hr><br>

        <!-- *********************************************** -->

        <h1>Change tformNo in all tables from the CSV A => B</h1>
        <div class='uploadForm'>

            <form id='csvForm' method='POST' action='exe/exeFileMakerUpdate.php' enctype='multipart/form-data'>
                <h3 id='selectedFileNameText'>FileMaker PL インポート</h3>
                <h3 id='counter'></h3>
                <input id='csvFileInput' type='file' name='filename' style='border: #CCC 2px solid;'>
            </form>

            <button id="submitBtn">CLICK ME</button><br>
            <hr>

            <hr>

            <!-- *********************************************** -->
            <h1>CLEAN DOUBLES FROM MAKER LIST INFO</h1>
            <button id="cleanDoubles">Clean Doubles from list name: </button>
            <input type="text" id='cleanDoublesInput'>
            <br>
            <hr><br>

            <!-- *********************************************** -->

            <hr>

            <table id="differenceTable">
                <tbody></tbody>
            </table>

        </div>




    </div>
</body>

</html>
