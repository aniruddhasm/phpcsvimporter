<?php 
getcsv_PHP();
 
function getcsv_PHP(){
	$final_arr = array();
	$inputFilename = 'students.csv'; // the location of the csv file.
	include 'db_config.php';
	$conn = new mysqli($db_host,$db_user, $db_password, $db_name);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	echo "Data importing started<br/><br/>";
    	if (($handle = fopen($inputFilename, "r")) !== FALSE){
        	$length = 1000;
        	$delimiter = ",";
        
        	$i = 0; 
        	while ( ( $data = fgetcsv( $handle, $length, $delimiter ) ) !== FALSE ){
			if( $i != 0){
				$query = $conn->prepare("INSERT INTO users (firstname, lastname, email, created_at, modified_at) VALUES (?,?,?,?,?)");
				$query->bind_param('sssss', $data['0'], $data['1'], $data['2'], date("Y-m-d H:i:s"), date("Y-m-d H:i:s"));
				$query->execute();
				echo "Inserted ". $i. " record<br/>";
			}
			$i++;
        	}
        	fclose($handle);
    	}
    	echo "Data imported successfully.";
}
?>
