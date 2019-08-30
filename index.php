<?php
include "includes/dbconnection.php";
$conn = connect();
$salesvar = getVariance($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Assessment</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  	


</head>
<body>
	<p id='test'>Table</p>
	<table id="table_id" class="display table table-bordered table-striped">
    <thead>
        <tr>
<!--             <th>Sal</th>
            <th>Column 2</th> -->
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Row 1 Data 1</td>
            <td>Row 1 Data 2</td>
        </tr>
        <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr>
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
	var columns = ['Sales Person'];
	var person = []

	var monthlySalesAndVariance = JSON.parse('<?php  echo json_encode($salesvar);?>');
  	var salesObj;
  	console.log(monthlySalesAndVariance)
 	
 	for (i in monthlySalesAndVariance){
 		person.push(i)
 		salesObj = monthlySalesAndVariance[i]
	}

 	for(j in salesObj){
 		columns.push(salesObj[j]['month'])
 		
 	}

 	// for(c in columns){
 	// 	$('table thead tr').appendTo('<th>'+columns[c]+'</th>')	
 	// }

 	
 // 	console.log(person)
	// console.log(columns)


</script>