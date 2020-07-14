<?php
	class MainIntelligentPHP {
		private $servername = "localhost";
		private $username = "root";
		private $password = "";
		private $dbname = "uuc_db";
		var $cookie_name;
		var $cookie_value;
		var $cookie_expiredate;
		var $check_enabled_cookie;
		var $myfile;
		var $text;
		var $handler;
		var $csvrow = 0;
		var $output;
		var $tbNames;
		var $setFildNames;
		var $values;
		var $msg;
		var $reS;
		/*public function __construct($servername,$username,$password,$dbname){
			$this->servername=$servername;
			$this->username=$username;
			$this->password=$password;
			$this->dbname=$dbname;
		}*/
		////////////////////////////////////////////////////////////////////////
		//DB methods
		public function connectDB(){
			$con = new mysqli($this->servername,$this->username,$this->password,$this->dbname);
			//check connection
			if($con->connect_error){
				die("Connection failed: " .$con->connect_error);
			}
			return $con;
		}
		//query db
		public function queryDB($queryStr){
			$result = $this->connectDB()->query($queryStr);
			return $result;
		}

		public function allowANinRegEx($name){
			return preg_replace("/[^A-Za-z0-9 -_]/"," ", $name); 
			//return preg_replace("/[^a-zA-Z 0-9]+/", "", $name );
			//return preg_replace("^[A-Za-z0-9 -_]+_Prog\\.(exe|EXE)$", "", $name );
			//return "^[A-Za-z0-9 -_]+_Prog\\.(exe|EXE)$";
		}
			//this mehod will filter injection from hacker
		public function escape_String($data){
				$cnn = $this->connectDB();
				$data = mysqli_real_escape_string($cnn,$data);
				return $data;
		}
		//this method test for error
		public function dbError(){  
			$cn1 = $this->connectDB();
			return mysqli_error($cn1);
		}
		// function insert data into db       $this->connectDB()->query($sql)
		public function InsertIntoDBTB($tbNames,$tbflNames,$values1,$msg){
			$sql = "INSERT INTO $tbNames($tbflNames) VALUES($values1)";
			if($this->connectDB()->query($sql) === TRUE){
				return $msg;
			}else{
				echo "Error:" . $sql . "<br>".$this->connectDB()->error;
			}
		}

			// function to insert to DB with array
		public function InsertIntoDBTBArray($tbNames,$tbflNames,$values1,$msg){
				$sql = "INSERT INTO $tbNames($tbflNames) VALUES($values1)";
				if($this->connectDB()->query($sql) === TRUE){
					return $msg;
				}else{
					echo "Error:" . $sql . "<br>".$this->connectDB()->error;
				}
			}
		public function InsertIntoDBTBReTLstInstedID($tbNames,$tbflNames,$values1){
			$sql = "INSERT INTO $tbNames($tbflNames) VALUES($values1)";
			if($this->connectDB()->query($sql) === TRUE){
				return $last_inserted_row = $this->connectDB()->insert_id();
			}else{
				echo "Error:" . $sql . "<br>".$this->connectDB()->error;
			}
		}
		//function to get the last inserted id
		public function lastInsertedRow($tbflNames,$values,$msg){
			$sql = "INSERT INTO ($tbflNames) VALUES($values)";
			if($this->connectDB()->query($sql)){
				return $last_inserted_row = $this->connectDB()->insert_id();
			}else{
				echo "Error:" . $sql . "<br>".$this->connectDB()->error;
			}
		}
		//fuction tha fetch data from db using table name  without condition
		public function selectDtaFrmDBAR_PORTSeting($tbflNames,$tbName){
			$sql ="SELECT $tbflNames FROM $tbName";
			$result = $this->connectDB()->query($sql);
				return $result;
		}
		//fuction tha fetch data from db
		public function selectDtaFrmDB($tbflNames,$tbName,$werConditn){
			$sql ="SELECT $tbflNames FROM $tbName WHERE $werConditn";
			$result = $this->connectDB()->query($sql);
				return $result;
		}
		//fuction tha fetch data from db
		public function selectDtaFrmDB2($tbflNames,$tbName,$werConditn){
			$sql ="SELECT $tbflNames FROM $tbName WHERE $werConditn LIMIT 1";
			$result = $this->connectDB()->query($sql);
				if($result->num_rows > 0){
					return $result->fetch_assoc();
						//return $row;
					//}
				}else{
					return "@";
				}
		}
		//fuction tha fetch data from db using table name as $tbfnames, $table name
		public function selectDtaFrmDBMC($tbflNames,$tbName,$curFilname,$suppliedFieldName,$DBconditn){
			$sql ="SELECT $tbflNames FROM $tbName WHERE $curFilname='$suppliedFieldName' AND $DBconditn";
			$result = $this->connectDB()->query($sql);
			return $result;
		}

		//fuction tha fetch data from db
		public function selectDtaFrmDBNOLIMITAT($tbflNames,$tbName,$werConditn){
			$sql ="SELECT DISTINCT $tbflNames FROM $tbName WHERE $werConditn";
			$result = $this->connectDB()->query($sql);
				return $result;
		}

		//fuction tha fetch data from db
		public function selectDtaFrmDBNOLIMITATTwoCDN($tbflNames,$tbName,$werConditn,$werConditn2){
			$sql ="SELECT $tbflNames FROM $tbName WHERE $werConditn AND $werConditn2 LIMIT 2";
			$result = $this->connectDB()->query($sql);
				return $result;
		}
		public function selectDtaFrmDBNOLIMITATTwoCDNTRACT($tbflNames,$tbName,$werConditn,$werConditn2,$werConditn3){
			$sql ="SELECT $tbflNames FROM $tbName WHERE $werConditn AND $werConditn2 AND $werConditn3 ORDER BY Lvl DESC";
			$result = $this->connectDB()->query($sql);
				return $result;
		}

		public function selectDtaFrmDBNOLIMITATTwoCDNTRACT4aug($tbflNames,$tbName,$werConditn,$werConditn2,$werConditn3,$werConditn4){
			$sql ="SELECT $tbflNames FROM $tbName WHERE $werConditn AND $werConditn2 AND $werConditn3 AND $werConditn4";
			$result = $this->connectDB()->query($sql);
				return $result;
		}
		//fuction tha fetch data from db
		public function selectDtaFrmDBALL($tbflNames,$tbName,$werConditn){
			$sql ="SELECT $tbflNames FROM $tbName WHERE $werConditn LIMIT 1";
			$result = $this->connectDB()->query($sql);
				return $result;
		}
		//fuction tha fetch data from db limiting
		public function selectDtaFrmDBLIMIT($tbflNames,$tbName,$werConditn){
			$sql ="SELECT $tbflNames FROM $tbName LIMIT $werConditn";
			$result = $this->connectDB()->query($sql);
				return $result;
		}
		//fuction tha fetch data from db with no LIMIT specification
		public function selectDtaFrmDBALLNOLIMIT($tbflNames,$tbName,$werConditn,$condTN2,$Spcolumn){
			$sql ="SELECT $tbflNames FROM $tbName WHERE $werConditn AND $condTN2 GROUP BY $Spcolumn";
			$result = $this->connectDB()->query($sql);
				return $result;
		}
		//fuction tha fetch all data from db
		public function selectALLDtaFrmDB($tbflNames,$tbName){
			$sql ="SELECT $tbflNames FROM $tbName";
			$result = $this->connectDB()->query($sql);
			return $result;
		}
		//fuction tha fetch data from db
		public function selectDtaFrmDBHasPass($tbflNames,$tbName,$werConditn){
			$sql ="SELECT $tbflNames FROM $tbName WHERE $werConditn";
			$result = $this->connectDB()->query($sql);
			return $result;
		}
		//function that delete data from db Table
		public function deleteDBTable($tbflNames,$tbID,$value,$msg){
			$sql = "DELETE FROM $tbflNames WHERE $tbID = '$value' ";
			$result = $this->connectDB()->query($sql);
				if($result){
					echo $msg;
				}
		}
		public function maxID($tbflNames,$tbName){
			$sql ="SELECT MAX($tbflNames) AS ID FROM $tbName";
			$result = $this->connectDB()->query($sql);
			return $result;
		}
		//function to update db
		function updateDBTable($tbName,$setFiledNames,$tbID,$theCurrID){
			$sql ="UPDATE $tbName SET $setFiledNames WHERE $tbID='$theCurrID'";
			$result = $this->connectDB()->query($sql);
			return $result;
		}
		//function to update db simpler
		function updateDBTableDB($tbName,$setFildName,$werConditn,$werConditn2,$msg){
			$sql ="UPDATE $tbName SET $setFildName WHERE $werConditn AND $werConditn2";
			$result = $this->connectDB()->query($sql);
				if($result){return $msg;}
		}
		//function to update db
		function updateDBTable4aug($tbName,$setFildName,$setFiledName,$werConditn2,$werConditn3,$werConditn4,$setFiledName5){
			$sql ="UPDATE $tbName SET $setFildName = '$setFiledName',$setFiledName5 WHERE $werConditn2 AND $werConditn3 AND $werConditn4";
			$result = $this->connectDB()->query($sql);
				return $result;
		}
		function insertCSS(){
			return '<link href="../assets/w3c.CSS" rel="stylesheet" type="text/css" />
			<link href="../assets/cssRevision.css" rel="stylesheet" type="text/css" />
			<link href="../font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
			<script src="../assets/IntelligentJS.js" type="text/javascript"></script>
			';
		}
		//function to update multiplecol db
		function updateDBMULTTable($tbName,$setFiledName,$tbID,$theID,$msg){
			$sql ="UPDATE $tbName SET $setFiledName WHERE $tbID= $theID";
			$result = $this->connectDB()->query($sql);
				if($result){return $msg;}else{return 'error';}
		}

		//function for like operator
		//function for like operator
		public function likeOprator($tbflName,$tbName,$werConditn,$werConditn3,$percentage,$percentage1,$rstFiTB){
			$sql ="SELECT $tbflName FROM $tbName WHERE ($rstFiTB LIKE $percentage OR $rstFiTB LIKE $percentage1) AND $werConditn AND $werConditn3 LIMIT 1";
			$result = $this->connectDB()->query($sql);
				return $result;
		}
		
		//DB method ends
		/////////////////////////////////////////////////////////////
         //function to encrypt password
		//function to encrypt password
		public function encryptPasswrd($userPasword){
			$options = [
				'cost' => 11,
			];
			return	password_hash($userPasword,PASSWORD_BCRYPT, $options);
		}
		
		//function to decrypt password
		public function decryptPassword($userGivenPassword,$DBPasswordHas){
			if(password_verify($userGivenPassword,$DBPasswordHas)){
				return "@!!";
			}else{
				return "#";
			}
		}
			//sending mail
		public function sendMail($mailFrom,$subject,$bodyOfThTxt,$mailTo){
				if(isset($_POST[$mailFrom])){
					$mail = new PHPMailer();
				  $mail -> isSMTP();
				  $mail -> SMTPDebug = 1;
				  $mail -> SMTPAuth = true;
				  $mail -> SMTPSecure ='ssl';
				  $mail -> Host="smtp.gmail.com";
				  $mail -> Port=465;//or 587
				  $mail -> isHTML(true);
				  $mail -> Username="enefiokduke4info@gmail.com";
				  $mail -> Password="documentary1";
				  //$mail -> SetFrom("enefiokduke4info@gmail.com");
				  $mail -> SetFrom($_POST[$mailFrom]); 
				  $mail -> Subject=$_POST[$subject];
				  $mail -> Body=$_POST[$bodyOfThTxt];
				  $mail -> AddAddress($_POST[$mailTo]);
					if(!$mail->send()){
						 return "Mailer Error:".$mail->ErrorInfo;
						}else{
							return "~";//Mail Has Been Sent
							}	 
					  }
		}//end mail method
		
		//file checking and upload for first sitting
		public function fileUpoadAndCheckingStaf($partToFileUpload,$getEleFileName,$stafName){
			//$target_dir = "../uploads/";
			$target_dir = $partToFileUpload;//note $partToFileUpload=../uploads/,$getEleFileName=file1
				$target_file = $target_dir . basename($_FILES[$getEleFileName]["name"]);
				$getLPSLASHplus = (strrpos("".$target_file."","/"))+1;
				$getLPSLASHplus1 = (strrpos("".$target_file."",""))+0;//this to to remove ../../epconfig/UserImages/STAFF/staffname.jpeg and be left with staffname.jpeg
				$getWordbwdtwo = substr_replace("".$target_file."","".$stafName."","".$getLPSLASHplus."",-4);
				$getWordbwdtwo1 = substr_replace("".$target_file."","".$stafName."","".$getLPSLASHplus1."",-4);
					$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($getWordbwdtwo,PATHINFO_EXTENSION));
							// Check if image file is a actual image or fake image
							if(isset($_POST[$getEleFileName])) {
							$check = getimagesize($_FILES[$getEleFileName]["tmp_name"]);
							if($check !== false) {
								echo "File is an image - " . $check["mime"] . ".";
								$uploadOk = 1;
							} else {
								//echo "File is not an image.";
								return 2;
								$uploadOk = 0;
							}
						}
							//exit();
							// Check if file already exists
							//if (file_exists($getWordbwdtwo)) {
								//echo "Sorry, file already exists.";
							//	return "@&";
							//	$uploadOk = 0;
							//}
							//exit();
							// Check file size
							if ($_FILES[$getEleFileName]["size"] > 100000) {
								//echo "Sorry, your file is too large.";
								return 4;
								$uploadOk = 0;
							}
							//exit();
							// Allow certain file formats
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType !="jpeg" ) {
								//echo "Sorry, only JPG, JPEG, PDF, PNG & GIF files are allowed.";
								return 5;
								$uploadOk = 0;
							}
							/////
							////
							//exit();
							// Check if $uploadOk is set to 0 by an error

							if ($uploadOk == 0) {
								//echo "Sorry, your file was not uploaded.";
								return 6;
							// if everything is ok, try to upload file

								} else {
									if (move_uploaded_file($_FILES[$getEleFileName]["tmp_name"], $getWordbwdtwo)) {
										//echo "The file ". basename( $_FILES[$getEleFileName]["name"]). " has been uploaded.";
											$dosya = $_FILES[$getEleFileName]["name"];
											//return 	$dosya;
											return 	$getWordbwdtwo1;
											//return 	 "3@";
											
									} else {
										//echo "Sorry, there was an error uploading your file.";
										return 7;
									}
								}

		}//end of fileUpoadAndChecking method
		//file checking and upload for second sitting
		public function fileUpoadAndChecking2s($partToFileUpload,$getEleFileName,$jamNo){
			//$target_dir = "../uploads/";
			$target_dir = $partToFileUpload;//note $partToFileUpload=../uploads/,$getEleFileName=file1
				$target_file = $target_dir . basename($_FILES[$getEleFileName]["name"]);
				$getLPSLASHplus = (strrpos("".$target_file."","/"))+1;
				$getWordbwdtwo = substr_replace("".$target_file."","".$jamNo."_1","".$getLPSLASHplus."",-4);
					$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($getWordbwdtwo,PATHINFO_EXTENSION));
							// Check if image file is a actual image or fake image
							if(isset($_POST[$getEleFileName])) {
							$check = getimagesize($_FILES[$getEleFileName]["tmp_name"]);
							if($check !== false) {
								echo "File is an image - " . $check["mime"] . ".";
								$uploadOk = 1;
							} else {
								//echo "File is not an image.";
								return "@";
								$uploadOk = 0;
							}
						}
							//exit();
							// Check if file already exists
							/*if (file_exists($getWordbwdtwo)) {
								//echo "Sorry, file already exists.";
								return "@&";
								$uploadOk = 0;
							}*/
							//exit();
							// Check file size
							if ($_FILES[$getEleFileName]["size"] > 100000) {
								//echo "Sorry, your file is too large.";
								return "@&@";
								$uploadOk = 0;
							}
							//exit();
							// Allow certain file formats
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" && $imageFileType !="pdf" && $imageFileType !="csv" ) {
								//echo "Sorry, only JPG, JPEG, PDF, PNG & GIF files are allowed.";
								return "&@";
								$uploadOk = 0;
							}
							/////
							////
							//exit();
							// Check if $uploadOk is set to 0 by an error

							if ($uploadOk == 0) {
								//echo "Sorry, your file was not uploaded.";
								return "9@";
							// if everything is ok, try to upload file

								} else {
									if (move_uploaded_file($_FILES[$getEleFileName]["tmp_name"], $getWordbwdtwo)) {
										//echo "The file ". basename( $_FILES[$getEleFileName]["name"]). " has been uploaded.";
											$dosya = $_FILES[$getEleFileName]["name"];
											return 	$dosya;
											//return 	 "3@";
											
									} else {
										//echo "Sorry, there was an error uploading your file.";
										return "2@";
									}
								}

		}//end of fileUpoadAndChecking method
		//file checking and upload
		public function fileUpoadAndChecking($partToFileUpload,$getEleFileName){
			//$target_dir = "../uploads/";
			$target_dir = $partToFileUpload;//note $partToFileUpload=../uploads/,$getEleFileName=file1
				$target_file = $target_dir . basename($_FILES[$getEleFileName]["name"]);
					$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
							// Check if image file is a actual image or fake image
							if(isset($_POST[$getEleFileName])) {
							$check = getimagesize($_FILES[$getEleFileName]["tmp_name"]);
							if($check !== false) {
								echo "File is an image - " . $check["mime"] . ".";
								$uploadOk = 1;
							} else {
								return "@";//File is not an image.
								$uploadOk = 0;
							}
						}
							//exit();
							// Check if file already exists
							if (file_exists($target_file)) {
								return "@~";//Sorry, file already exists.
								$uploadOk = 0;
							}
							//exit();
							// Check file size
							if ($_FILES[$getEleFileName]["size"] > 500000000) {
								return "@~@";//Sorry, your file is too large.
								$uploadOk = 0;
							}
							//exit();
							// Allow certain file formats
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
							&& $imageFileType != "gif") {// && $imageFileType !="pdf" && $imageFileType !="csv"
								return "9@";//Sorry, only JPG, JPEG, PDF, PNG & GIF files are allowed.
								$uploadOk = 0;
							}
							/////
							////
							//exit();
							// Check if $uploadOk is set to 0 by an error

							if ($uploadOk == 0) {
								return "@8";//Sorry, your file was not uploaded.
							// if everything is ok, try to upload file

								} else {
									if (move_uploaded_file($_FILES[$getEleFileName]["tmp_name"], $target_file)) {
										//echo "The file ". basename( $_FILES[$getEleFileName]["name"]). " has been uploaded.";
											$dosya = $_FILES[$getEleFileName]["name"];
											return 	$dosya;
											
									} else {
										return "5@";//Sorry, there was an error uploading your file.
									}
								}

		}//end of fileUpoadAndChecking method

		// csv file upload and upload
		public function csvFileUpoadAndChecking($partToFileUpload,$getEleFileName){
			//$target_dir = "../uploads/";
			$target_dir = $partToFileUpload;//note $partToFileUpload=../uploads/,$getEleFileName=file1
				$target_file = $target_dir . basename($_FILES[$getEleFileName]["name"]);
					$uploadOk = 1;
						$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
							// Check if image file is a actual image or fake image
							if(isset($_POST[$getEleFileName])) {
							$check = getimagesize($_FILES[$getEleFileName]["tmp_name"]);
							if($check !== false) {
								echo "File is an image - " . $check["mime"] . ".";
								$uploadOk = 1;
							} else {
								echo "File is not an image.";
								$uploadOk = 0;
							}
						}
							//exit();
							// Check if file already exists
							if (file_exists($target_file)) {
								echo "Sorry, file already exists.";
								$uploadOk = 0;
							}
							//exit();
							// Check file size
							if ($_FILES[$getEleFileName]["size"] > 500000000) {
								echo "Sorry, your file is too large.";
								$uploadOk = 0;
							}
							//exit();
							// Allow certain file formats
							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
							&& $imageFileType != "gif" && $imageFileType !="pdf" && $imageFileType !="csv" ) {
								echo "Sorry, only JPG, JPEG, PDF, PNG & GIF files are allowed.";
								$uploadOk = 0;
							}
							/////
							////
							//exit();
							// Check if $uploadOk is set to 0 by an error

							if ($uploadOk == 0) {
								echo "Sorry, your file was not uploaded.";
							// if everything is ok, try to upload file

								} else {
									if (move_uploaded_file($_FILES[$getEleFileName]["tmp_name"], $target_file)) {
										//echo "The file ". basename( $_FILES[$getEleFileName]["name"]). " has been uploaded.";
											$dosya = $_FILES[$getEleFileName]["name"];
											return 	$dosya;
											
									} else {
										echo "Sorry, there was an error uploading your file.";
									}
								}

		}//end of csv method

		//function to check user during password authentication
		public function check_user_credentials($username, $password,$DBuserid,$tbName,$errorMsg){
			$sql = "SELECT $DBuserid FROM $tbName WHERE $DBusername= '$username' AND $DBPassword='$password'";
			//fetch the data from DB
			$result = $this->queryDB($sql);
			if($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				if($row){
					$userid = $row['userid'];
				}else{
					throw new AuthException("".$errorMsg."");
				}
				return $userid;
			}else{
				die("is not reach able");
			}
		}
		//function that checks password for both letter and numbers
		public function good_password($password){
			if(strlen(trim($password) < 8)){
				//return 0;
			}
			//run match for numbers \d which is numbers between 0-9
			if(!preg_match("/\d/",trim($password))){
				///return "";
			}
			if(!preg_match("/[a-z]/i",trim($password))){
				//return 0;
			}
			return $password;
		}
		
		//function that checks cookie
		public function checkCookie(){
			$this->check_enabled_cookie=setcookie("test_cookie", "test",time() + 3600, '/');
			if(count($_COOKIE) > 0) {
				//$this->create_cookie();
			}else{
				echo "Cookies are disabled.";
			}
		}
		//function to create cookie
		public function create_cookie($username,$uservalue){
			$this->cookie_name = "".$username.""; //e.g user
			$this->cookie_value = "".$uservalue.""; //e.g user or enefiok duke
			$this->cookie_expiredate = time() + (86400 + 30); //cookie wiil expire after 30days
				setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
				if(!isset($_COOKIE[$this->cookie_name ])){
					echo "Cookie named '" . $this->cookie_name . "' is not set!";
				}
		}
		public function deleteCookie($user){
			return setcookie("".$user."", "", time() - 3600);
		}

		public function chkses($session,$location){
			if(!isset($session)){
				header("Location: $location");
			}
		}

		//function that will create file
		public function createAnyFile($fileName,$getText){
			$this->myfile= fopen("$fileName","w");
			$this->text = "$getText";
			fwrite($this->myfile,$this->text);
			return $this->myfile;
			fclose($this->myfile);
		}
			//function that allows u to call day automatically
		public function selectDay(){
						//date
			//echo '<select name="day">';
			for($i = 1; $i <= 31; $i++){
				echo "<option value=\"$i\">$i</option>";
			} 
		}
			//function that allows u to call month automatically
		public function selectMonth(){
						//month
			//echo '<select name="month">';
			for($i = 1; $i <= 12; $i++){
				$dt = DateTime::createFromFormat('!m', $i);
				echo "<option value=\"$i\">".$dt->format('F')."</option>";
			}
		}
		//function that allows u to call year automatically
		public function selectYear(){
			//year
			//echo '<select name="year">';
			for($i = date('Y'); $i >= date('Y', strtotime('-90 years')); $i--){
			echo "<option value=\"$i\">$i</option>";
			} 
		}
		//method to remove string and return only numbers
		public function getNumFromStr($getStr){
			return preg_replace('/[^0-9]/', '', $getStr);
		}

		public function getDTYRDiff($getPasDT){
			$TECY = array(
				"PY"=>array(10,11,12),
				"CY"=>array(1,2,3,4,5,6,7,8,9)
			);
			$getPDM = explode("/",$getPasDT); //03/2017
			$getM = $getPDM[0]; 
			$getY = $getPDM[1]; 
			//print_r(count($TECY['PY']));
			//1/10/2017 - 30/09/2018
				//$currentYear = date("Y");//2018
				$currentYear = 2018;//2018
				$currentMonth = 10;
				$endMonth = $currentMonth-1;
				$endYear = $currentYear;
				$preYear = ($currentYear - 1); //2017
				if((in_array($getM,$TECY['PY'])  && ($getY == $preYear)) || (in_array($getM,$TECY['CY'])  && ($getY == $endYear))){
					echo "It is";
				}else{
					echo "it is not";
				}
				exit;
				/*$currentYandM = $currentMonth."/".$currentYear;//  9/2018
				//$preYear = date("Y") - 1; //2017
				$preYear = ($currentYear - 1); //2017
				//$preMonth = $currentMonth + 2; //10
				$preMonth = $currentMonth; //10
				//$preMonth1 = "0{$preMonth}";
				$startYandM = $preMonth."/".$preYear;// start year
				$endYandM = $endMonth."/".$endYear;// start year
				
				//echo $startYandM."--".$endYandM;
				//exit;
					if($getPasDT >= $startYandM && $getPasDT <= $endYandM){//10/2018 $$ 10but=2018
						echo "true";
					}else{
						echo "false";
					}*/
		}
	//how to use token function $getLen = $_POST['getUserTractID'];echo getToken($getLen)
	function crypto_rand_secure($min, $max){
		$range = $max - $min;//0,20
		if ($range < 1) return $min; // not so random...20-0=20
		$log = ceil(log($range, 2));//20,2
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd > $range);
		return $min + $rnd;
	}
	
	function getToken($length){
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		//$codeAlphabet.= "0123456789";
		$max = strlen($codeAlphabet); // edited
	
		for ($i=0; $i < $length; $i++) {
			$token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
		}
	
		return $token;
	}
	//function toupload image
	public function returnImage($imgeName,$imgWidth,$imgHeight){
		$imagePhoto = '<img id="repl" class="w3-circle w3-center" src="../'.$imgeName.'" width="'.$imgWidth.'" height="'.$imgHeight.'" alt="photo" >';
		return $imagePhoto;
	}
	public function returnImagesqure($imgeName,$imgWidth,$imgHeight){
		$imagePhoto = '<img id="repl" class=" w3-center" src="../'.$imgeName.'" width="'.$imgWidth.'" height="'.$imgHeight.'" alt="photo" >';
		return $imagePhoto;
	}
	//generate 10 digit number
	function gidi10(){
		$tranDDTEST =  mt_rand(10000, 99999);
		$tranIDD =  mt_rand(788, 998);
		$getSUBtr = substr(time(),8);
		$transId = $tranDDTEST.$tranIDD.$getSUBtr;
		return $transId;
	}
	/********************************************************************/
	//HTML REUSEABLE ELEMENT START
	//progressbar 1
	function proGreBar(){
		return '<div class="inv-proGresBar"><div id="progBar" class="inv-proGRa" style="display:none;"></div></div>';
	}
	//tool tips
	//top tool tips will be for used extensively for info
	function topToolTips($hoverMEText,$tookTipText){
		return '<div class="tooltiptopleft">'.$hoverMEText.'<span class="tooltiptext">'.$tookTipText.'</span></div>';
	}
	function bottomToolTips($hoverMEText,$tookTipText){
		return '<div class="tooltiptopleft">'.$hoverMEText.'<span class="tooltiptext">'.$tookTipText.'</span></div>';
	}
	function rightToolTips($hoverMEText,$tookTipText){
		return '<div class="tooltiptopleft">'.$hoverMEText.'<span class="tooltiptext">'.$tookTipText.'</span></div>';
	}
	function leftToolTips($hoverMEText,$tookTipText){
		return '<div class="tooltiptopleft">'.$hoverMEText.'<span class="tooltiptext">'.$tookTipText.'</span></div>';
	}
	// public function generatePDF($html,$marginLeft,$marginRight,$watermakText){
	// 	require_once __DIR__ . '/vendor/autoload.php';
	// 	$mpdf = new Mpdf\mPDF([
	// 		'mode' => 'UTF-8',
	// 		'format' => 'Legal',//
	// 		'default_font_size' => 0,//
	// 		'default_font' => '',
	// 		'margin_left' => $marginLeft,//
	// 		'margin_right' => $marginRight,//
	// 		'margin_top' => 5,//
	// 		'margin_bottom' => 16,//
	// 		// 'margin_header' => 9,
	// 		// 'margin_footer' => 9,
	// 		'orientation' => 'P',//
	// 	]);
	// $mpdf->SetTitle('Print Slip');
	// $stylsheet = file_get_contents('../assets/w3c.CSS');
	// $stylsheet1 = file_get_contents('../assets/cssRevision.css');
	// $mpdf->SetWatermarkText("$watermakText");
	// $mpdf->showWatermarkText = true;
	// $mpdf->setFooter('{PAGENO}');
	// $mpdf->WriteHTML($stylsheet,1);
	// $mpdf->WriteHTML($stylsheet1,1);
	// $mpdf->WriteHTML($html,2);
	// $mpdf->SetDisplayMode('fullpage');
	// // $mpdf->SetFooter('{PAGENO} / {nb}');
	// $mpdf->Output('mpdf.pdf', \Mpdf\Output\Destination::INLINE);
	// }
	// //mpdf v6.1.3
	public function generategeneratePDFv6($html,$marginLeft,$marginRight,$watermakText){
		include("mpdf-6.1.3/mpdf.php");
		$mpdf=new mPDF('',array(235,355),0,'',$marginLeft,$marginRight,1,15,0,0,'P');
		$mpdf->SetTitle('Print Slip');
		$stylsheet = file_get_contents('../assets/w3c.CSS');
		$stylsheet1 = file_get_contents('../assets/cssRevision.css');
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetWatermarkText("$watermakText");
		$mpdf->showWatermarkText = true;
		$mpdf->SetFooter('<div style="margin:0px;">{PAGENO} / {nb}</div>');
		$mpdf->WriteHTML($stylsheet,1);
		$mpdf->WriteHTML($stylsheet1,1);
		$mpdf->WriteHTML($html,2);
		// $mpdf->SetFooter('{PAGENO} / {nb}');
		$mpdf->Output();
		//exit;
		}
	//javscript tag
	public function getJavascriptTag(){
		$js = "<script>
		document.body.style.cursor = 'wait';
		window.onload = function(){document.body.style.cursor='default';}
		</script>";
		return $js;
	}
	function insertBodyCSS(){
		return '<link href="assets/w3c.CSS" rel="stylesheet" type="text/css" />
		<link href="assets/cssRevision.css" rel="stylesheet" type="text/css" />
		<link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<script src="assets/IntelligentJS.js" type="text/javascript"></script>
		';
	}
	public function genLoginSystem(){
		echo $this->insertBodyCSS();
		 return <<<_END
		 <body>
			<div class="adv-cnt-bdy">
				<div class="w3-display-container" style="height:100%;">
					<div class="w3-display-middle">
						<form action="javascript:void(0)" onsubmit="__I.GenLoginSys.loginSys('usenval','paswrdval')">
							<div class="w3-center" style=""><input id="usenval" class="w3-input w3-border" type="text" placeholder="Username" style="border-top-left-radius: 10px;border-top-right-radius: 10px;"></div>
							<div class="w3-center" style="margin-top:4px;"><input id="paswrdval" class="w3-input w3-border" type="password" placeholder="Username"></div>
							<div class="w3-center" style="margin-top:4px;width:100%;"><button class="w3-button w3-center w3-indigo w3-round" style="width:100%;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">Login <i id="hid_Cog" class="fa fa-cog fa-spin" style="visibility:hidden;"></i></button></div>
						</form>
					</div>
				</div>
			</div>
		 </body>
_END;
	 }

	//  log page
	public function logPage(){
		echo $this->insertBodyCSS();
		return <<<_PIN
		<div id="exitsubPinPg" class="putme-PinLog-cont w3-animate-opacity">
			<div style="position:relative;width:100%;height:100%;overflow:hidden;">
				<div style="position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);color:white;width:300px;height:400px;background-color:white;border-radius:10px;">
					<div style="width:width:100%;height:100px;background-color: #e71f05!important;color:white;border-top-left-radius:10px;border-top-right-radius:10px;position:relative;">
						<div style="text-align:center;"><strong>ENTER PIN</strong></div>
						<div style="position:absolute;bottom:0;width:100%;height:50px;padding:10px;">
							<div title="CLEAR" class="w3-center">
								<input id="getTvlue" type="hidden">
								<span id="getCalVal"></span>
								<div onclick="putme.allAnimations.Pin.calclear(this)" class="w3-right"><div class="w3-circle w3-button w3-light-grey w3-small" style="margin-top:-10px;">X</div></div>
							</div>
						</div>
					</div>
					<div class="w3-container">
						<div class="w3-row-padding w3-margin">
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">7</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">8</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">9</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">A</button>
							</div>
						</div>
						<div class="w3-row-padding w3-margin">
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">4</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">5</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">6</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">B</button>
							</div>
						</div>
						<div class="w3-row-padding w3-margin">
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">1</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">2</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">3</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">C</button>
							</div>
						</div>
						<div class="w3-row-padding w3-margin">
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">0</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">*</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button w3-light-grey w3-circle w3-large">@</button>
							</div>
							<div class="w3-col s3">
								<button onclick="putme.allAnimations.Pin.calC(this)" class="w3-button  w3-circle w3-large" style="background-color: #e71f05!important;color:white;">#</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
_PIN;
	}
	 
	//HTML REUSEABLE ELEMENT END
	/********************************************************************/
	}

    //class that will take care of all DB quweries and other manipulations
	class Operations extends MainIntelligentPHP{
		
		//function that controls csv upload   $seletedFile "../akscoepayrepe.csv" n loop tousands of row into array
		//befor sending it to db
		public function getUrCSVfile($psrt){
			$sql="";
			if(($this->handler = fopen("../CSVfiles/$psrt","r"))!=false){
				while(($data = fgetcsv($this->handler, 1000, ",")) !== FALSE) {
					$num = count($data);
					$this->tbNames = 'amt_tb';
					$this->setFildNames = 'RegNo,Name,Date,Department,Shool,ReceivingBank,Amount';
					$this->values = "'$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]'";
					$this->msg = 'Successful';
					$sql .="INSERT INTO ".$this->tbNames."(".$this->setFildNames.") VALUES(".$this->values.");";
					//$this->reS = $this->InsertIntoDBTB($this->tbNames,$this->setFildNames,$this->values,$this->msg);
					/* 	$sql = "INSERT INTO $tbNames($tbflNames) VALUES($values)";
			if($this->connectDB()->query($sql) === TRUE){
				return $msg;
			}else{
				echo "Error:" . $sql . "<br>".$this->connectDB()->error;
			} */

				}
				if($this->connectDB()->multi_query($sql) === TRUE){
					echo $this->msg;
				}else{
					echo "Error:" . $sql . "<br>".$this->connectDB()->error;
				}
				/* if($this->reS){
					echo "Successful";
					
				} */
				fclose($this->handler);
			}
		}
	}	//$obj = new MainIntelligentPHP("localhost","root","","futo");//form this in another class
?>
