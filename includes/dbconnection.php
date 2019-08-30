<?php


  



function connect(){

$db_name = 'buymore';  
$db_user = 'root';  
$db_pass = 'root';
$db_host = 'localhost';

$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
 

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} else{
return $link;
}
 


}




function selectUser($conn) {  
    
$sql = "SELECT distinct rep_name,rep_surname  FROM sales ";
$result = $conn->query($sql);
$salesPerson = []; 

   
	if($result->num_rows > 0){
	    
	    while ($row = $result->fetch_assoc()) {

	    	$salesPerson ["sales_person"][] = [$row["rep_name"]." ".$row["rep_surname"]];

	    }

	}else{
		
		array_push($salesPerson,"no data available");
		echo "no data available";

	}
	
return $salesPerson;

} 


function selectUserName($conn) {  
    
$sql = "SELECT distinct rep_name  FROM sales ";
$result = $conn->query($sql);
$salesPersonName = []; 

   
	if($result->num_rows > 0){
	    
	    while ($row = $result->fetch_assoc()) {
	    	array_push($salesPersonName,$row['rep_name']);
	    	

	    }

	}else{
		
		array_push($salesPersonName,"no data available");
		echo "no data available";

	}
	

return $salesPersonName;

} 






function selectMonth($conn){

$sql = "SELECT distinct month  FROM sales ";
$result = $conn->query($sql);
$month = []; 

   
	if($result->num_rows > 0){
	    
	    while ($row = $result->fetch_assoc()) {
	    	
	    	array_push($month,$row['month']);
	    
	    }

	}else{
		
		array_push($month,"no data available");
	
	}

return $month;

}


function getSalespersonMonthlyTotal($conn, $firstName, $id ,$month){

$salesPerson = [];

	for ($i=0; $i <sizeof($month) ; $i++) { 
		for ($j=0; $j <sizeof($id) ; $j++) { 
			
			$sql = "SELECT sum(total) as total FROM sales where sales_id = ".$id[$j]." and month = '".$month[$i]."'";
			// print_r($sql);
			$result = $conn->query($sql);
			
			if($result->num_rows > 0){

				while ($row = $result->fetch_assoc()) {

					

						$salesPerson [$id[$j]][] = [  'name' =>$firstName[$j],
													  "month" => $month[$i],
													  "total" => $row['total']];

				}

			}
		}
	}


return $salesPerson;

}

function selectUserSurname($conn) {  
    
$sql = "SELECT distinct rep_surname  FROM sales ";
$result = $conn->query($sql);
$salesPersonSurname = []; 

   
	if($result->num_rows > 0){
	    
	    while ($row = $result->fetch_assoc()) {
	    	array_push($salesPersonSurname,$row['rep_surname']);
	    	

	    }

	}else{
		
		array_push($salesPersonSurname,"no data available");
		echo "no data available";

	}
	

return $salesPersonSurname;

} 

function selectUserEmail($conn) {  
    
$sql = "SELECT distinct rep_email  FROM sales ";
$result = $conn->query($sql);
$salesPersonEmail = []; 

   
	if($result->num_rows > 0){
	    
	    while ($row = $result->fetch_assoc()) {
	    	array_push($salesPersonEmail,$row['rep_email']);
	    	

	    }

	}else{
		
		array_push($salesPersonEmail,"no data available");
		echo "no data available";

	}
	

return $salesPersonEmail;

} 


function createSalespersonTable($conn){

$sql = "CREATE TABLE sales_person (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		firstname VARCHAR(30) NOT NULL,
		lastname VARCHAR(30) NOT NULL,
		email VARCHAR(50)
		)";

$result = $conn->query($sql);



	if($result){

		echo "Table MyGuests created successfully";
	} else {
		echo "Error creating table: " . $conn->error;
	}


}

function selectID($conn , $firstname){
$id = [];

	for ($i=0; $i < sizeof($firstname) ; $i++) { 
		$sql = "SELECT id   FROM sales_person where firstname = '".$firstname[$i]."' ";
		$result = $conn->query($sql);
		$salesPersonEmail = []; 


		if($result->num_rows > 0){

		while ($row = $result->fetch_assoc()) {
			array_push($id,$row['id']);
			

		}

		}else{

		array_push($id,"no data available");
		echo "no data available";

		}	
	}

	return $id;

}



function updateSales($conn, $firstname, $id){


	for ($i=0; $i < sizeof($firstname) ; $i++) { 

		$sql = "UPDATE sales SET sales_id  = ".$id[$i]." where rep_name = '".$firstname[$i]."'";	
		// echo $sql;
		$result = $conn->query($sql);

		if($result){

			echo "Data inserted successfully";
		} else {
			echo "Error inserting data: " . $conn->error;
		}


	}

}








function insertIntoSalesPerson($conn, $firstname, $lastname, $email){


	for ($i=0; $i < sizeof($firstname) ; $i++) { 

		$sql = "INSERT INTO sales_person (firstname, lastname, email) VALUES ('".$firstname[$i]."','".$lastname[$i]."','".$email[$i]."')";	
		$result = $conn->query($sql);

		if($result){

			echo "Data inserted successfully";
		} else {
			echo "Error inserting data: " . $conn->error;
		}


	}

}

function createSalespersonMonthlyToatlTable($conn){

$sql = "CREATE TABLE sales_person_monthly_total (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		total decimal(18,2) NOT NULL,
		month char(2) NOT NULL,
		sales_id INT(6) NOT NULL		
		)";

$result = $conn->query($sql);



	if($result){

		echo "Table sales_person_monthly_total created successfully";
	} else {
		echo "Error creating table: " . $conn->error;
	}


}


function insertIntoMonthlySales($conn, $salesPersonMonthlyTotal){

	foreach ($salesPersonMonthlyTotal as $key => $value) {
		foreach ($value as $key1 => $value1) {
			
			$sql = "INSERT INTO sales_person_monthly_total (total, month, sales_id) VALUES ('".$value1['total']."','".$value1['month']."','".$key."')";
			$result = $conn->query($sql);
			
			if($result){

				echo "Data inserted successfully";
			} else {
				echo "Error inserting data: " . $conn->error;
			}

		}
	}

}

function getVariance($conn){

$salesVariance = [];	
$tot = [];
$sales_person = [];
$month = [];
$var = 0;

		
$sql ="SELECT T2.total,T2.month,T1.firstname,T1.lastname FROM sales_person as T1 INNER JOIN sales_person_monthly_total as T2 ON T2.sales_id = T1.id;";
$result = $conn->query($sql);


if($result->num_rows > 0){

	while ($row = $result->fetch_assoc()) {

		array_push($tot,$row['total']);
		array_push($sales_person, $row['firstname']." ".$row['lastname']);
		array_push($month, $row['month']);
	}
}

for ($j=0; $j < sizeof($tot); $j++) { 	
		
	if($j > 0){
		// var_dump($j);
		$var = ($tot[$j] - ($tot[$j-1]))/$tot[$j]*100;		
		// array_push($hold, ($tot[$j] - ($tot[$j-1]))/$tot[$j]*100);
	}

	$salesVariance[$sales_person[$j]][] = [ 
									'month'=> $month[$j],
									'total'=>$tot[$j],
									'variance' => $var
									]; 		
}


return $salesVariance;


}

?>