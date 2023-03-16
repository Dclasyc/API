<?php  
header("Access-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


//check if method is post 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//get the raw data from request body
	$rawdata = file_get_contents('php://input');

	$data = json_decode($rawdata);

	//validate all input

	if (empty($data->phone) || empty($data->mobile_network) || empty($data->message)) {

		$response = array(
				"status"=>"Failed",
				"message"=> "Bad Request Fill All Required Fields",
				"data"=> []

			);


		echo json_encode($response);

	}else{

		// include class

		include_once "api_function.php";

		//create object of class Register

		$obj = new Register();

        // //generate user unique reference code
        // $refcode = "DC".rand().time();

		// reference insertUser Method

		$output = $obj->insertUser($data->phone,$data->mobile_network,$data->message,$data->refcode);

		echo $output;

	}

}else{
		$response = array(
				"status"=>"Failed",
				"message"=> "Method Not Allowed",
				"data"=> []

			);


		echo json_encode($response);
}
 
 

?>