<?php
include "includes/dbconnection.php";
$conn = connect();
$salesvar = getVariance($conn);
$month = selectMonth($conn);



?>
<!DOCTYPE html>
<html>
<head>
	<title>Assessment</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  	


</head>
<body>

	<table id="table_id" class="display table table-bordered table-striped">
    <thead>
        <tr>
             <th>Sales person</th>
             <?php 
                foreach ($month as $key => $value) {
                    echo "<th>".$value."</th>";
                }
             ?>

        </tr>
    </thead>
    <tbody>
        
            <?php
            $varianceColour = "";
            foreach ($salesvar as $key => $value) {
                echo "<tr>";
                echo "<td>".$key."</td>";
                // print_r($value);
               foreach ($value as $key1 => $value1) {
                
                $variance =  ($key1 === 0 ? 0:round($value1['variance']));

                    if($variance > 0){
                        $varianceColour = "green";
                    } else if($variance < 0){
                        $varianceColour = "red";
                    } else{
                        $varianceColour = "blue";
                    } 

                     


                   echo "<td>".$value1['total']." <span style='color: ".$varianceColour."'> ".   $variance ."% </span></td>";
                
               }
                echo "</tr>";
            }

            ?>
        <span ></span>
        
    </tbody>
</table>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript">
	$(document).ready( function () {
    	$('#table_id').DataTable();
	} );


</script>