<?php 
//check if the request method is Get 

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	// include class file 
	include_once "api_function.php";

	//create object class 
	$obj = new Register();

	//MAKE USE OF GET USER METHOD 
	$output = $obj->getUsers();

	echo $output;
}else{

$response = array(
				"status"=>"Failed",
				"message"=> "Method Not Allowed",
				"data"=> []

			);

			echo json_encode($response);

}

?>