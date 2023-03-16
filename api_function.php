<?php 

	include_once "dbconnection.php";

	//clASS definition

	class Register{

		//member variables 
		public $phone;
		public $mobile_network;
		public $message;
        public $refcode;
		public $conn; // database connection handler 


		//member function 

		public function __construct(){
			//open db connection 
			$this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASENAME);

			//CHECK IF CONNECTED 

			if ($this->conn->connect_error) {
				$response = array(
                    "status"=>"Failed",
                    "message"=> "DB Connection Failed".$this->conn->connect_error,
                    "data"=> []
    
                );
    
                return json_encode($response);
            }


		}
		//begin insert user method 

		public function insertUser($phone,$network,$message,$refcode){

        //generate user unique reference code
        $refcode = "DC".rand().time();

            //prepare statement
    
            $stmt = $this->conn->prepare("INSERT INTO users(phone,mobile_network,message,refcode) VALUES(?,?,?, ? )");
    
            //bind parameters 
    
            $stmt->bind_param("ssss",$phone,$network,$message,$refcode);
    
            //execute Query
    
            $stmt->execute();
    
            //check if inserted successfully 
    
            if ($stmt->affected_rows == 1) {
                $response = array(
                    "status"=>"Success",
                    "message"=> "A Member record was successfully inserted",
                    "data"=> $stmt->insert_id
    
                );
            }else{
                $response = array(
                    "status"=>"Failed",
                    "message"=> "Member Record  Was not inserted successfully ",
                    "data"=> []
    
                );
            }
            return json_encode($response);
        }

		//end insert user method 


        //begin get user 

	public function getUsers(){

		$stmt = $this->conn->prepare("SELECT * FROM  users");	

		//execute Query

		$stmt->execute();

			$result =$stmt->get_result();

			$records = array();

		if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {

			$records[] = $row;
		}

			$response = array(
				"status"=>"Success",
				"message"=> "All members Data",
				"data"=> $records

			);

			}else{
				$response = array(
				"status"=>"Success",
				"message"=> "No Records Found",
				"data"=>[]

			);

		}
		echo json_encode($response);	
	}
	//end get user method


	}


?>