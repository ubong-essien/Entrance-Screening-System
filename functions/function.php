<?php
session_start();
//updated 2-7-19
function lb(){
	return "<br/>";
}
//send sms 
	function useHTTPGet($messagetext, $recipients) {
	//$url,
	$username='meetmontero@gmail.com';
	$apikey='91c2e5470d1c17a5663a8c303b18fcc039d9f14d';
	$flash=0;
	$url = "http://api.ebulksms.com:8080/sendsms";
	$sendername="AKSU-PUTME";
    $query_str = http_build_query(
	array(
	'username' => $username,
	'apikey' => $apikey,
	'sender' => $sendername, 
	'messagetext' => $messagetext,
	'flash' => $flash,
	'recipients' => $recipients
	)
		);
		
	$curlurl = $url."?".$query_str;
		$handle = curl_init();
		
    	curl_setopt($handle, CURLOPT_URL, $curlurl);
    	$data = curl_exec($handle);
    	curl_close($handle);
	
	
		/* if(file_get_contents("{$url}?{$query_str}")==FALSE){
			echo "cant fetch sms api,check network";
		}else{
			 return file_get_contents("{$url}?{$query_str}");
		} */
   
}
function home_base_url(){   

// first get http protocol if http or https

$base_url = (isset($_SERVER['HTTPS']) &&

$_SERVER['HTTPS']!='off') ? 'https://' : 'http://';

// get default website root directory

$tmpURL = dirname(__FILE__);

// when use dirname(__FILE__) will return value like this "C:\xampp\htdocs\my_website",

//convert value to http url use string replace, 

// replace any backslashes to slash in this case use chr value "92"

$tmpURL = str_replace(chr(92),'/',$tmpURL);

// now replace any same string in $tmpURL value to null or ''

// and will return value like /localhost/my_website/ or just /my_website/

$tmpURL = str_replace($_SERVER['DOCUMENT_ROOT'],'',$tmpURL);

// delete any slash character in first and last of value

$tmpURL = ltrim($tmpURL,'/');

$tmpURL = rtrim($tmpURL, '/');


// check again if we find any slash string in value then we can assume its local machine

    if (strpos($tmpURL,'/')){

// explode that value and take only first value

       $tmpURL = explode('/',$tmpURL);

       $tmpURL = $tmpURL[0];

      }

// now last steps

// assign protocol in first value

   if ($tmpURL !== $_SERVER['HTTP_HOST'])

// if protocol its http then like this

      $base_url .= $_SERVER['HTTP_HOST'].'/'.$tmpURL.'/';

    else

// else if protocol is https

      $base_url .= $tmpURL.'/';

// give return value

return $base_url; 

}
///////////////////////////////////////////////////////////////////////////////////
/////////////function get first row
 function Select4rmdbtb($conn,$tbs,$fields = "",$cond = ""){
	  if(isset($tbs)){ 
		  $query = "SELECT ";
		  //process fileds
		  $filds = "";
		  if(is_array($fields)){// fileds are morthen 1
			  foreach($fields as $f){
				 $filds .= $f . ", "; 
			  }
			  $filds = trim($filds, ", ");
		  }elseif(is_string($fields) && $fields != ""){
			  $filds = $fields;
		  }else{
			  $filds = "*";
		  }
		  $query .= $filds . " FROM ";
		  //process tables
		  $tbstr = "";
		  if(is_array($tbs)){// fileds are morthen 1
			  foreach($tbs as $t){
				 $tbstr .= $t . ", "; 
			  }
			  $tbstr = trim($tbstr, ", ");
		  }else{
			  $tbstr = $tbs;
		  }
		  $query .= $tbstr;
		  
		  //process conditions
		  if($cond != ""){
			$query .= " WHERE " . $cond;  
		  }
		   //return $query;
	return mysqli_query($conn,$query);
	  }
  }  
  //////////////////////////////////////////end of select
function getFirstRecord($conn,$table,$where=NULL,$limit=NULL,$order=NULL){
	$sql="SELECT * FROM ".$table;
	$sql.=" WHERE ".$where;
	$res=mysqli_query($conn,$sql);
	$arr=mysqli_fetch_array($res);
	return $arr;
}
//////////////////
function getAllRecord($conn,$table,$where=NULL,$order=NULL,$limit=NULL){
	$sql="SELECT * FROM ".$table;
	if($where!="" || $where!=NULL){
	$sql.=" WHERE ".$where;
		}
	if($order!="" || $order!=NULL){
	$sql.=" ORDER BY ".$order;
		}
	if($limit!="" || $limit!=NULL){
	$sql.=" LIMIT ".$limit;
		}
	$res=mysqli_query($conn,$sql);
	return $res;
}
 /*function Insert2Db($conn,$table,$formdata){
	$sql="INSERT INTO ".$table." ";
	$fields=array_keys($formdata);
	$fieldsNames=implode(',',$fields);
	$fieldsNames="($fieldsNames)";
	$values=implode(',',$formdata);
	$sql.= $fieldsNames;
$sql.=" VALUES({$values})";
	$res=mysqli_query($conn,$sql);
	
	return $sql;
} */
/////////////////////////////////////////
 function Insert2DbTb($conn,$fields,$tb){
	  $sql = "INSERT INTO ". $tb ." SET ";
		  foreach($fields as $key => $val){
			  if(is_string($val) || empty($val)){
				  $val = "'" . $val . "'";
			  }else if(!is_numeric($val)){
				 $val = "'" . $val . "'"; 
			  }
				  $sql .= "`".$key."`" . "=" . $val . ", ";
		  }
		  $sql = trim($sql,', ');
		$insert_res = mysqli_query($conn,$sql);
		
	 /* if($insert_res==TRUE) {
		return TRUE;
	  } else {
	  return FALSE; 
	  } */ 
	  return $insert_res;
  }
   //update table records
 function Updatedbtb($conn,$tb,$fieldsVal,$cond = ""){
	 if(isset($tb) && isset($fieldsVal)){
		 $qy = "UPDATE {$tb} SET ";
		 if(is_array($fieldsVal)){
			 foreach($fieldsVal as $field => $value){
				 $sep = (is_string($value)  || empty($val) )?"'":"";
				$qy .= $field ." = ". $sep . $value . $sep . ", "; 
			 }
			 $qy = trim($qy,", ");
			 if($cond != ""){
				$qy .= " WHERE ". $cond ; 
			 }
			/*return $qy;*/
			 $rst = mysqli_query($conn,$qy);
			  
				 return $rst;
			   
		 }
		  
	 }
 }
 
 ///////////////////////////////////
 //////////////////////////function to decode multiple programme  id
	function Displaylist($table,$field,$prog,$conn){
		//$a=explode(",",$prog);
		
	$prg=mysqli_query($conn,"SELECT ".$field." FROM ".$table." WHERE ProgID ={$prog}");
	$rowprog=mysqli_fetch_array($prg);
	return $rowprog['ProgName'];
	
}
/////////////////////////////////////////function to retrieve the system settings
function Loadsettings($conn){
	$getsettings=getAllRecord($conn,'screening_settings','id=1','','');
	$settingsarr=mysqli_fetch_array($getsettings);
	return 	$settingsarr;
	//return array($styleclass,$header,$searchcriteria,$backgroundimg);	
} 

function join2values($val1,$val2){
	
	return implode($val1,$val2);
}
/****function to get the local government from the lga table*****/

function GetLGA($lgaid,$conn){
		
		$sel_lga = mysqli_query($conn,"SELECT * FROM lga_tb WHERE LGAID = '$lgaid'");//decode programme id
					$rowlga=mysqli_fetch_array($sel_lga);
		$loc_govt=$rowlga['LGAName'];
		
return $loc_govt;
}
/****function to decode the state of origin*****/
function GetState($StateId,$conn){
		if(is_numeric($StateId)){
		$sel_state = mysqli_query($conn,"SELECT * FROM state_tb WHERE StateId = '$StateId'");//decode programme id
					$rowstate=mysqli_fetch_assoc($sel_state);
return $rowstate['StateName'];
		}

	}
/*function to get programme details from programme_tb*/

function GetProgDetails($id,$conn){
$seldept = mysqli_query($conn,"SELECT * FROM programme_tb WHERE ProgID = '$id'");//decode programme id
			$rowdept=mysqli_fetch_array($seldept);
return $rowdept['ProgName'];
}
////////////////////////fetch details by jamb number_format
function Getcand_details($regid,$conn){
$selqry = mysqli_query($conn,"SELECT * FROM pstudentinfo_tb WHERE JambNo = '$regid'");//decode programme id
return $selqry;
}
////////////////////////////////////////////////////////////////////////
function chklogin($user,$pass,$connect){
if(isset($user)&& isset($pass))

{
		//$usr="SELECT * FROM report_privilege WHERE Username='$user'";
							$login_res=mysqli_query($connect,"SELECT * FROM screening_users WHERE Username='$user'");
							$rowuser=mysqli_num_rows($login_res);
							
				if($rowuser==1){
							
											$usr_details=mysqli_fetch_array($login_res);
											$prvlge=$usr_details['Privilege'];
												$login_user_dept=$usr_details['Panel'];
												$login_pswd=$usr_details['password'];
												//echo $login_pswd."-".$login_user_dept;
												
												$pswd_chk=password_verify($pass,$login_pswd);//check encrypted pswd
												
					if($pswd_chk==TRUE){
						
												switch ($prvlge) {
													case 1:
																		$_SESSION['screenmed']=$usr_details['Username'];
																		$_SESSION['panel']=$usr_details['Panel'];
																		$_SESSION['prev']=$usr_details['Privilege'];	
																		 echo("<script>location.href = 'medical/index.php';</script>");
																		break;
													case 2:
																		$_SESSION['screenpanel']=$usr_details['Username'];
																		$_SESSION['panel']=$usr_details['Panel'];
																		$_SESSION['prev']=$usr_details['Privilege'];	
																		echo("<script>location.href = 'panel/index.php';</script>");
																		break;
													case 3:
																		$_SESSION['screensuper']=$usr_details['Username'];
																		$_SESSION['panel']=$usr_details['Panel'];
																		$_SESSION['prev']=$usr_details['Privilege'];	
																		echo("<script>location.href = 'index.php';</script>");
																	break;
																	default:
																		echo"wrong privileg";

																}//end of switch
							
														
										}
										else
										{ 
										echo "<div class=\"alert aler-danger\">Wrong Username/Password</div>";
										}
							
								}
								else
								{
											echo "<div class=\"alert aler-danger\">Password is incorrect.</div>";
								}//end of row chk.
											
}
else
{
	echo "<div class=\"alert aler-danger\">You Must provide a userName and password</div>";
	}// end of empty check(isset)
	
	return array($_SESSION['screenuser'],$_SESSION['panel'],$_SESSION['prev']);
		
	}//end of function
	/////////////////////////////////////////////////////////////////////
	function chkAdminsession(){
	if(!isset($_SESSION['screensuper'])){
	    echo("<script>location.href = 'login.php';</script>");
	return;
	}
}
	/////////////////////////////////////////////////////////////////////
	function chksessionpanel(){
if(!isset($_SESSION['screenpanel'])){
	     echo("<script>location.href = '../login.php';</script>");
	    return ;
	    
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function chksessionmed(){
if(!isset($_SESSION['screenmed'])){
	     echo("<script>location.href = '../login.php';</script>");
	    return ;
	    
	}
}
///////////////////////////////////profile page functions////////////////////////////////////////////////////////////////////
 function findAge($dob){
# procedural
	return date_diff(date_create($dob), date_create('today'))->y;
 }

 function getGrade($conn, $gradeId){

 	$gradeQuery = mysqli_fetch_assoc(Select4rmdbtb($conn,"olvlgrade_tb",$fields = "Grade",$cond = "Level = '".$gradeId."'"));
 	return $gradeQuery['Grade'];
 }

 function getSubject($conn, $SubId){
 	$gradeQuery = mysqli_fetch_assoc(Select4rmdbtb($conn,"olvlsubj_tb",$fields = "SubName",$cond = "SubId = '".$SubId."'"));
 	return $gradeQuery['SubName'];
 }
///////// this function picks the subject & grade of the subject and returns 1 if it meets the requirement for the dept and 0 if it does not
 /*function checkRequirement($conn, $subjId, $gradeId, $ProgId){
 	$result = FALSE;

 	$conditionsQuery = mysqli_fetch_assoc(Select4rmdbtb($conn,"waec_require",$fields = array("Subj_comb", "Special_cons"),$cond = "ProgID = '".$ProgId."'"));
 	$core = explode("~",$conditionsQuery['Subj_comb']);

 	//echo "COre count ".count($core); 
 	for ($i=0; $i < count($core); $i++) { 	//1:7~7:7||13:7~8:7~6:7~4:7||5:7~9:8
 		# code...
 		if(!stripos($core[$i], "||")){
 			$coreGrade = explode(":", $core[$i]);

 			if ($subjId == $coreGrade[0] && $gradeId <= $coreGrade[1]) {
 				$result = TRUE;
 
 			}else{
 
 			}
 			
 		}else if (stripos($core[$i], "||")){


 			$condSubjGrade = explode("||", $core[$i]);
 			$tempResult = FALSE;
 			
 			for ($j=0; $j < count($condSubjGrade); $j++) { 
 				# code...
 				$condGrade = explode(":", $condSubjGrade[$j]);

	 			if ($subjId == $condGrade[0] && $gradeId <= $condGrade[1]) {

	 				$tempResult = TRUE;
	 			}else{

	 			}
 			}

 			if($tempResult){
 				$result = TRUE;
 			}
 		}
 	}/////////////end of for loop

 	return $result;
}*/

//1=7||2=1||5=4||6=4||13=1||7=4||16=1||15=7
/*function checkAdmissibleStatus($conn, $olevel, $ProgId){
	$optcount=0;
	$OlevelResult = explode("###",$olevel);

    $Olevel1 = explode("||",$OlevelResult[0]);

    $finalarray;

    if(count($OlevelResult)>1){

    	$Olevel2 = explode("||",$OlevelResult[1]);
    	$finalarray = array_merge($Olevel1, $Olevel2);// merge all of them to make provision for checking if ttotal will be 5 credit

    }else{
    	$finalarray = $Olevel1;// final array is a string with all candidates result into one,both first and second sitting
    } 

    $conditionsQuery = mysqli_fetch_assoc(Select4rmdbtb($conn,"waec_require",$fields = array("Subj_comb", "Special_cons"),$cond = "ProgID = '".$ProgId."'"));
 	//1:7~7:7||13:7~8:7~6:7~4:7||5:7~9:8
 	$core = explode("~",$conditionsQuery['Subj_comb']);// breaks waec requirement into 1:7,7:7,8:7

 	//$requiredCount=0; 
 	$requiredSubjects = array();

	 	for ($i=0; $i < count($core); $i++) { 
 		# code...
 		if(!stripos($core[$i], "||")){
 			$coreGrade = explode(":", $core[$i]);// 1 and 7 in an array

 			for ($j=0; $j < count($finalarray); $j++) { //submitted result processing
 				$finalSubj = explode("=", $finalarray[$j]);

	 			if ($coreGrade[0] == $finalSubj[0] && $coreGrade[1] >= $finalSubj[1]) { //the actual check
	 				//++$requiredCount;
	 				$requiredSubjects[]= $coreGrade[0];
	 			}else{
	 
	 			}
 			}
 		}else if (stripos($core[$i], "||")){
// processing the optional subjects
 			$condSubjGrade = explode("||", $core[$i]);
 		//	$condCount;
 			$tempValue=0;
 			$noconditional = mysqli_fetch_assoc(Select4rmdbtb($conn,"waec_require","no_conditional",$cond = "ProgID = '".$ProgId."'"));
 			for ($k=0; $k < count($condSubjGrade); $k++) { 
 				# code...
 				$condGrade = explode(":", $condSubjGrade[$k]);

 				for ($l=0; $l < count($finalarray); $l++) { 
 					# code...
 					$finalSubj2 = explode("=", $finalarray[$l]);
		 			if ($condGrade[0] == $finalSubj2[0] && $condGrade[1] >= $finalSubj2[1]) {

		 				++$tempValue;
		 				if($tempValue <= $noconditional['no_conditional']){
		 				$requiredSubjects[]= $condGrade[0];
		 				//echo " tempresult :". $tempValue ." subject ". $condGrade[0] ." cand  ". $finalSubj2[0];
						//echo " tempgrade :". $tempValue ." subject ". $condGrade[1] ." cand  ". $finalSubj2[1];
		 				}else{
		 					break;
		 				}
		 			}else{

		 			}
 				}
 				//break;
 			}

 			
 		}//END OF ELSE IF
		////////////////////////////////////////////////
		
 	}
$core_cond=count(array_unique($requiredSubjects));
//echo $core_cond;
$finalcount=($core_cond + $optcount);
 	return $req;
}*/


//////////////////////////////////*************************************************************////////////////////////

//this function produces the ticks for grade and subjects for the waec
function checkRequirement($conn, $subjId, $gradeId, $ProgId){
$result = FALSE;	
$conditionsQuery = mysqli_fetch_assoc(Select4rmdbtb($conn,"waec_require",$fields = array("Subj_comb", "Special_cons","no_conditional"),$cond = "ProgID = '".$ProgId."'"));
 	
$x= $conditionsQuery['Subj_comb'];	

$z=explode("&",$x);//EXPLODE REQUIREMENT

///CHECK AGAINST CORE
$Core_array=explode("~",$z[0]);
foreach($Core_array as $corereq){
	$core=explode(":",$corereq);
	$corenum=count($core);

	//$core[0];
	//$core[1];if ($subjId == $condGrade[0] && $gradeId <= $condGrade[1]) {
	if(($core[0]==$subjId) && ($gradeId <= $core[1])){
					$result = TRUE;
			
			}
	}//end of foreach

///////////////////////////end of core checks
/************************process optional requirement********************************/



		//CHECK AGAINST CORE

$z=explode("&",$x);//EXPLODE REQUIREMENT

if($z[1]!="NONE"){
	$optional_array=explode("#",$z[1]);
foreach($optional_array as $optreq){
	$optional=explode(":",$optreq);
	

						if(($optional[0]==$subjId) && ($gradeId <= $optional[1])){
								$result = TRUE;
					}else{}
			
			}//end of foreach
	
	}

//break;

/************************************conditional courses*******************************************/
			

		//CHECK AGAINST CORE

$z=explode("&",$x);//EXPLODE REQUIREMENT

if($z[2]!="NONE"){
	$cond_array=explode("||",$z[2]);
			foreach($cond_array as $condreq){
				$cond=explode(":",$condreq);
				

							if(($cond[0]==$subjId) && ($gradeId <= $cond[1])){
							$result = TRUE;
		 				}else{
		 					
		 				}
										
							
						
						}//end of foreach
				
		}

//break;
// FOR SUBJECTS NOT LISTED HERE ON THE REQUIREMENT
//if(($z[1]=="NONE") && ($z[2]=="NONE")){
	
	
	if((isset($subjId)) && ($gradeId <=7)){
				$result = TRUE;
	}
//}

return $result;
}

////////////////////************************************************************************//////////////////////////////////////////
function checkAR($olvlRstDet){
	//check if candidate submitted awaiting result
	
	if($olvlRstDet=="AR" || (stripos($olvlRstDet,"AR")==TRUE)){
			return true;
			 	
		}
	
}

/////////////////////////////////////////////////////////////

//////////////////////////
function Exist($conn,$chkfield,$checkitem,$tblname){
	$chkresult=getAllRecord($conn,$tblname,$where="$chkfield='$checkitem'","","");
	$numrow=mysqli_num_rows($chkresult);
	$row=mysqli_fetch_array($chkresult);
	
	if($numrow > 0)
	{
		return array(TRUE,$row[0]);
	}
	else
	{
		return array(FALSE);
	}
	
}
/////////////////////////////////////////////////////////////

//this function checks the olevel and returns the number of equired olevel subject acandidiate has
function checkAdmissibleStatus($conn,$olvl,$ProgId,$Regno){
//$ProgId=37;
$core_array=array();//this will be used to form array for comparison
$opt_array=array();//this will be used to form array for comparison
$deficient=array();//this holds the deficient subjects
$requiredSubjects = array();//this holds the candidates correct subjects that matches requirement
$corecount=0;
//$d="1=4||2=4||4=4||7=7||5=7||6=7||13=4||16=8||15=7###1=4||2=4||4=4||7=7||5=9||6=7||13=4||16=8||15=7";
//checkAR($olvlRstDet);
//$OlevelResult=explode("###",$olvl);
$OlevelResult = explode("###",$olvl);
//check if candidate submitted awaiting result.


if(empty($OlevelResult[1]) || $OlevelResult[1]==""){
	$CAND_subj=$OlevelResult[0];
}else{
	$CAND_subj=$OlevelResult[0]."||".$OlevelResult[1];
}
//print($CAND_subj);
$olvl_sub_grade=explode("||",$CAND_subj);
//print_r($olvl_sub_grade); 


	//$subjgrade[0];//subject
	//$subjgrade[1];//cand olvl grade
//echo $subjgrade[0].lb();
//echo $subjgrade[1];
//pick requirement from the table;check if it has optional
$conditionsQuery = mysqli_fetch_assoc(Select4rmdbtb($conn,"waec_require",$fields = array("Subj_comb", "Special_cons"),$cond = "ProgID = '".$ProgId."'"));
 	
$x= $conditionsQuery['Subj_comb'];
$z=explode("&",$x);//EXPLODE REQUIREMENT
//print_r($z[0]);
//$Core_array=array();
///CHECK AGAINST CORE
if(strpos($z[0],"~")){
	//if the core is more than one subject
	$Core_array=explode("~",$z[0]);
	//print_r($Core_array);
	foreach($Core_array as $corereq){
				$core=explode(":",$corereq);
				$corenum=count($core);
				$core_arr[]=$core[0];
				//$core[0];
				/********************************************************************************/
				foreach($olvl_sub_grade as $Olevel){
						//CHECK AGAINST CORE
						$subjgrade=explode("=",$Olevel);//1,7
						
						

						//$core[1];
						if(($core[0]==$subjgrade[0]) && ($subjgrade[1] <= $core[1])){
									$requiredSubjects[]= $subjgrade[0];
									
									//echo $core[0]."----".$subjgrade[0]."----".$core[1]."----".$subjgrade[1]."<p style= 'color: green;'>&#10004;</p>";
								}else if(($core[0]==$subjgrade[0]) && ($subjgrade[1] > $core[1])){
									
									$deficient[]=$subjgrade[0];
									//	print_r($deficient);
									
								}else if(($core[0]!=$subjgrade[0])){
									
									
								} 
				}//end of foreach
	}
}else{
	//if the core is one
	$Core_array=$z[0];
	$core=explode(":",$Core_array);
	$corenum=count($core);
	$core_array[]=$core[0];
	$core[0];
	$core[1];
	foreach($olvl_sub_grade as $Olevel){
		//CHECK AGAINST CORE
		$subjgrade=explode("=",$Olevel);//1,7
		
		

		//$core[1];
		if(($core[0]==$subjgrade[0]) && ($subjgrade[1] <= $core[1])){
					$requiredSubjects[]= $subjgrade[0];
					
					//echo $core[0]."----".$subjgrade[0]."----".$core[1]."----".$subjgrade[1]."<p style= 'color: green;'>&#10004;</p>";
				}else if(($core[0]==$subjgrade[0]) && ($subjgrade[1] > $core[1])){
					
					$deficient[]=$subjgrade[0];
					//	print_r($deficient);
					
				}else if(($core[0]!=$subjgrade[0])){
					//do nothing

					
					
				} 
			}//end of foreach
}
//echo $Core_array;


///////////////////////////end of core checks
/************************process optional requirement********************************/
$optional_arr=array();
$optchk=0;

//$z=explode("&",$x);//EXPLODE REQUIREMENT

if($z[1]!="NONE"){//that means that the optional part is present
$optional_array=explode("#",$z[1]);

foreach($optional_array as $optreq){
	$optional=explode(":",$optreq);
	$optnum=count($optional);
	$opt_array[]=$optional[0];
//check the students result against conditional

foreach($olvl_sub_grade as $Olevel){
		//CHECK AGAINST CORE
	$subjgrade=explode("=",$Olevel);//1,7
	//$subjgrade[0];//subject
	//$subjgrade[1];//cand olvl grade
						if(($optional[0]==$subjgrade[0]) && ($subjgrade[1] <= $optional[1])){
							$optional_arr[]=$subjgrade[0];//assign the 
							$requiredSubjects[]= $subjgrade[0];
									
									//echo $optional[0]."----".$subjgrade[0]."----".$optional[1]."----".$subjgrade[1]."<p style= 'color: green;'>&#10004;</p>";
								break;
					}else if(($optional[0]==$subjgrade[0]) && ($subjgrade[1] > $optional[1])){
						$deficient[]=$subjgrade[0];

					}else if(($optional[0]!=$subjgrade[0])){
						
						
					} 
			
			}//end of foreach
	
	}

//break;
}else{//75101645GJbreak;
} 
/************************************conditional courses*******************************************/
$tempValue=0;
$noconditional = mysqli_fetch_assoc(Select4rmdbtb($conn,"waec_require","no_conditional",$cond = "ProgID = '".$ProgId."'"));
 			

	//$subjgrade[0];//subject
	//$subjgrade[1];//cand olvl grade
$z=explode("&",$x);//EXPLODE REQUIREMENT

if($z[2]!="NONE"){
	$cond_array=explode("||",$z[2]);
			foreach($cond_array as $condreq){
				$cond=explode(":",$condreq);
				$optnum=count($cond);
				$cond[0];

							foreach($olvl_sub_grade as $Olevel){
									//CHECK AGAINST CORE
								$subjgrade=explode("=",$Olevel);//1,7

														if(($cond[0]==$subjgrade[0]) && ($subjgrade[1] <= $cond[1])){
																	if(!(in_array($cond[0] , $requiredSubjects))){
																		++$tempValue;

																	if($tempValue <= $noconditional['no_conditional']){
																						$requiredSubjects[]= $cond[0];
																						//echo $cond[0]."----".$subjgrade[0]."----".$cond[1]."----".$subjgrade[1]."<p style= 'color: green;'>&#10004;</p>";
																				
																						}else{
																							break;
																						}
																	}
														
												
													}else if(($cond[0]!=$subjgrade[0])){


													}
											
									}//end of foreach

//break;
						}//end of foreach


}else{//break;
}

$unique_requiredSubject=array_unique($requiredSubjects);
// this part is to ensure the two optional course that is required is not selectedl
if($z[1]!="NONE"){

$optarray=array_unique($optional_arr);


					if(is_array($optarray) && (count($optarray) ==2)){

								if(in_array($optarray[0],$unique_requiredSubject) && in_array($optarray[1],$unique_requiredSubject)){
											// this checks if the required subject contains the both optional subjects
												$available=count($unique_requiredSubject);

												// this reduces the total number of subjects in the 
											$result=$available-1;
											//echo $result;this is to make sure only one subject is used even if two optional are available
										}
						
					}else if(is_array($optarray) && (count($optarray) ==1)){
						$result=count($unique_requiredSubject);
								//echo $result;
							
						
					}else if(is_array($optarray) && (count($optarray) ==0)){
								$result=count($unique_requiredSubject);
								
							}	
			}else{
	$result=count($unique_requiredSubject);
				}

/////////////////////////now compare the deficient subject array against the core course to find the course that is deficient
$def=array_unique($deficient);
//print_r($def);
$x=array_diff($def,$requiredSubjects);
//print_r($x);

$sub_def=implode($x,"~");
//echo $sub_def;


//$exist=Exist($conn,"RegNo",$Regno,"deficiency");

//if($exist[0]==FALSE){//if it does not exist insert
	//echo $Regno;
$fields=array('RegNo' => $Regno,'Olvl_Deficiency' => $sub_def);				
	$exist_q=getAllRecord($conn,"deficency","RegNo = '$Regno'","","");
					$q_num=mysqli_num_rows($exist_q);

				

					if($q_num > 0){
						
							$exist_array=mysqli_fetch_array($exist_q);
							$exist_id=$exist_array[0];
							$sqlres =Updatedbtb($conn,'deficency',$fields,$cond = "id='$exist_id'");

							}else{

							$sqlres =Insert2DbTb($conn,$fields,'deficency');
							}
					

								//$listid=mysqli_insert_id($conn);
								
								
								
							/* 	elseif($exist[0]==TRUE){//if it exist update
									$listid=$exist[1];
									//echo"<br/>candidate already exist";
									
									
									
									$fields=array('RegNo' => $Regno,'Olvl_Deficiency' => $sub_def);
									$sqlupdate=Updatedbtb($conn,'deficiency',$fields,"RegNo='$Regno'");
									
						} */
/////////////////first form the core array 


/* $cre=array_unique($core_arr);//the unique core subjects
//$cre=array_unique($core_arr);//the unique core subjects

foreach($cre as $cores){
	if(in_array($cores,$def)){
		echo "<p style='color:red'>".getSubject($conn, $cores)." is required in Olvl</p>";
	}
	
}
//$def_subj=array_diff($cre,$def);
///////////////////end of core check
$availdefopt=0;
$opt_sub=array_unique($opt_array);//get the unique array
print_r($opt_sub);

foreach($opt_sub as $opts){
	if(in_array($opts,$def)){
		$availdefopt++;
		
		if($availdefopt!=count($opt_sub)){
			echo "<p style='color:red'>".getSubject($conn, $opts)." is required in Olvl</p>";
		}else{
			//if candidate does not have both optional courses
			$def_both=1;
		//	echo "<p style='color:red'>".getSubject($conn, $opts[0])." Or".getSubject($conn, $opts[1])." is required in Olvl</p>";
			
		}

	}
	
}
if(isset($def_both) && $def_both==1){
	//echo "<p style='color:red'>".getSubject($conn, $opts[0])." Or".getSubject($conn, $opts[1])." is required in Olvl</p>";
			
}
//$def_subj=array_diff($cre,$def);


//print_r($def_subj);




//echo "<br/>".$corenum;
//print_r($optional); */
//implode()



//print_r($def);
return $result;
}
//////////////////////////////////////////////////////////////
function checkJamb($conn,$candJamb,$reqJamb,$ProgID,$regno){
	$optUTMEsubj=array();
	$hasopt=0;
	$corechk=0;
	$othrchk=0;
	$status="";
	$utme_def=array();
	$numOfoptions=0;
	//the format for the reqJamb =core~optional~others 1:7~NULL~6:9:13:18:26:27:35:40:42
	$can_Jmb=explode("~",$candJamb);
	$req_Jmb=explode("~",$reqJamb);
	// break the core subject
	$core=explode(":",$req_Jmb[0]);
	$numOfcore=count($core);// this will return the number of core check
	
	foreach($core as $core_req){
		if(in_array($core_req,$can_Jmb))
		{	$coresubj[]=$core_req;
				
			echo "<tr><td>".getSubject($conn,$core_req)."<span style= 'color: green;'> &#10004;</span></td></tr>";
			
			//echo $corechk;
				$corechk++;
				//var_dump($core_req);
		}else{//var_dump($core_req);
			//$utme_def[]=$core_req;
	
			$utmereq=getSubject($conn,$core_req);
				$utme_def[]=$utmereq;
			echo "<tr><td><p style= 'color: red;'><span style= 'color: red;'> &#10008</span>".$utmereq." is a required subject</p></td></tr>";
			
								//echo lb();
		}
		
	}
//	echo lb();
	//echo"<hr>";
	// break the optional subject
	if($req_Jmb[1]!="NULL"){

	$option=explode(":",$req_Jmb[1]);//////break by :(7||8:6||13)=>(7||8,6||13)
	$numOfoptions=count($option);//get the number of items in the option section of the string return 2 for 2 options and 1 for 1 option.
	
	foreach($option as $opt){ //here,each is fed in i.e 7||8
		$prt=explode("||",$opt);//7,8
		foreach($prt as $optchk){
						if(in_array($optchk,$can_Jmb))
						{	//$correctsubj=$optchk;
							$hasopt++;
							echo "<tr><td><p style= 'color: green;'>$optchk &#10004;</p></td></tr>";
							$optUTMEsubj[]=$optchk;
							break;//the break is to ensure that two of the optional courses are not allowed for a student.i.e if bio or agric,bio and agric shd not work
						
						}
						else
						{
							echo "<p style= 'color: red;'>$optchk &#10008;</p>";
							
							$utmeopt=getSubject($conn,$optchk);
							
							$utme_def[]=$utmeopt." OR ";
						}
						
					}
			}//echo"<hr>";
						/* if($hasopt==$numOfoptions){ // check if the
							echo "<p style= 'color: blue;'>"."correct "."&#10004;</p>";
							
						}else{echo "<p style= 'color: yellow;'>"."correct "."&#10004;</p>";} */
	}
	//////end of if		///////////////////////
	//echo $jm;
	
	
	
	//check other subject if not NULL
	if($req_Jmb[2]!="NULL"){

	$othersub=explode(":",$req_Jmb[2]);//////break by :(7||8:6||13)=>(7||8,6||13)
	
	//$numOfoptions=count($option);//get the number of items in the option section of the string return 2 for 2 options and 1 for 1 option.
	
	foreach($othersub as $addsub){ //here,each is fed in i.e 7||8
		//$prt=explode("||",$addsub);//7,8
						if(in_array($addsub,$can_Jmb))
						{
							//$correctsubj=$addsub;
							$odaUTMEsubj[]=$addsub;
						//	echo "<tr><td>".getSubject($con,$addsub)."<span style= 'color: green;'> &#10004;</span></td></tr>";
							$othrchk++;
							//echo lb();
							
							//break;
							
						}
						else
						{
							$utmeoda=getSubject($conn,$addsub);
							//$utmeoda.=" & ";
							//$utme_def[]=$utmeoda;
							//echo "<p style= 'color: red;'>$utmeoda &#10008;</p>";
							//print_r($utme_def);
						}
						
					
			}
					
	}//////end of if		///////////////////////
	
	
//add toknowthe number of found subjects
	$total_subj=$hasopt + $corechk + $othrchk;

	
		echo"<table class='table'>";					
							
/*********************************************this block does the reverse to remove the wrongly added subject by the studnet****************************************************/
/* 	if(($total_subj < 4)){
		
		$foundsub=array_merge($coresubj,$odaUTMEsubj,$optUTMEsubj);
		
	//print_r($foundsub);
	 foreach($can_Jmb as $jmbcomb):
	if(!in_array($jmbcomb,$foundsub)){
									echo "<tr><td style= 'color: red;'><span > &#10008;</span>".getSubject($conn,$jmbcomb)." is not required</td></tr>";
								
									//$utmeoda=getSubject($conn,$addsub);
									//$utme_def[]=$utmeoda.",";
									//echo "<p style= 'color: red;'>$addsub &#10008;</p>";
								}
	
	endforeach;
	} */
	/***************************************this block was moved in to the checks below**********************************/	
if($hasopt==$numOfoptions){
		if($numOfcore==$corechk){
			
			if($total_subj==4){
				
						echo "<tr><td><span class='alert alert-success' style='font-size:13px;'>Complete subject combination &#10004</span></td></tr>";
							$status=1;
							//return $status;
						}else{
							$foundsub=array_merge($coresubj,$odaUTMEsubj,$optUTMEsubj);
		
	//print_r($foundsub);
							 foreach($can_Jmb as $jmbcomb):
							if(!in_array($jmbcomb,$foundsub)){
														//	echo "<tr><td style= 'color: red;'><span > &#10008;</span>".getSubject($conn,$jmbcomb)." is not required</td></tr>";
														
															//$utmeoda=getSubject($conn,$addsub);
															//$utme_def[]=$utmeoda.",";
															//echo "<p style= 'color: red;'>$addsub &#10008;</p>";
														}
							
							endforeach;
							
							
							echo "<tr><td><span class='alert' style='font-size:11px;color:red'>&#10008 Error! Incorrect UTME Subject Combination </span></td></tr>";
								$status=0;
								//return $status;
							}
								}
								else
									{echo"<tr><td><span class='alert' style='font-size:11px;color:red'>&#10008 Error! Incorrect core UTME Subject Combination</span></td></tr>";
									$status=0;
									//return $status;
									}
			
							}
							else
							{echo"<tr></td><span class='alert' style= style='font-size:11px;color:red'>&#10008 Error! optional Incorrect UTME Subject Combination</span></td></tr>";
							$status=0;
							//return $status;
		//var_dump($utme_def);					
		}	
	echo"</table>";	
	
	
			//print_r($utme_def);	
			$jm=implode($utme_def,",");
			//echo $jm;
			//echo $regno."%";
			$fields=array('Utme_Deficiency' => $jm);
								
			$ex=Updatedbtb($conn,"deficency",$fields,"RegNo='$regno'");
			if(!$ex){
			echo "xxxxxx";
					}
	
				//print_r($correctsubj);
	return $status;
	
}
/******************************************************************/
function Getutmerequire($conn,$ProgId){
$utmegetQuery = mysqli_fetch_assoc(Select4rmdbtb($conn,"utme_require",$fields = "Subj_comb",$cond = "ProgID = '".$ProgId."'"));
 	
 	return $utmegetQuery['Subj_comb'];
}
/////////////////////////////sms log,this is to know the number of applicants that got the sms
function log_sms_recipient($conn,$reg,$phone){
	// check if number exist already
	$smsexistchk=getAllRecord($conn,"sms_log","RegNo='$reg'","","");
			$smsexist_num=mysqli_num_rows($smsexistchk);

			$smsrow=mysqli_fetch_row($smsexistchk);
			//var_dump($smsexistchk);
			//var_dump($smsrow);
			
			if($smsexist_num > 0){
				$sms_count = (int)$smsrow[3] + 1;
				$fieldsVal=array('sms_status' => $sms_count);
				Updatedbtb($conn,"sms_log",$fieldsVal,"id='$smsrow[0]'");
				
			}else{
				
				$sms_count = 1;
				$fieldsVal=array('sms_status' => $sms_count,'RegNo' => $reg,'Phone' => $phone);
				Insert2DbTb($conn,$fieldsVal,"sms_log");
			}
	return "User Notified";
}
///////////////////////////////////function to decide the final admission status of a student
function SetFinal($conn,$candID,$regNo,$recipients){
	
		if(isset($candID) && is_numeric($candID))
		{
			$cand_sc_details=getAllRecord($conn,"recommendation_tb","id='$candID'","","");
			$screen_row=mysqli_fetch_array($cand_sc_details);
			$chk1=$screen_row['system_rec'];
			$chk2=$screen_row['panel_rec'];
			$chk3=$screen_row['medical_rec'];
		//	echo $chk1."-".$chk2."-".$chk3;
				if(($chk1==1) && ($chk2==1) && ($chk3==1))// incase its needed: || ($chk1==1 && $chk2==1 && $chk3==0)
				{
					$fieldsVal=array('final_status' => 1);
					
				}else
				{
					$fieldsVal=array('final_status' => 0);
					
				}
			$f_update=Updatedbtb($conn,"recommendation_tb",$fieldsVal,"id='$candID'");
					if($f_update==true){
						$messagetext = "This is to notify you that you have successfully completed your screening process (Panel & Medicals).";
						$recipients = '07032874388';
						$st = useHTTPGet($messagetext, $recipients);
						//$sms_status = explode("|",$st);
						
						$sms_now = log_sms_recipient($conn,$regNo,$recipients);
						echo "<p>".$sms_status[0]."-".$sms_now."</p>";
						return true;
					}
					else
					{
					return false;
					}
		}
		else
		{
			echo "row id to be updated not fetched";
		}
	
}
//////////////////////////////////////////
/* function header($privilege){
			if($privilege==3){
		return include('includes/header.php');
		}
		else
		{
			return include('includes/header_user.php');
		}
	
} */

///////////////////function to check previledge on user pages and enforces the previlledges
function checkprev($user,$prev,$exp_prev){
	if(isset($user)&& isset($prev)){
		if($prev!==$exp_prev){
			echo"<div class=\"alert alert-danger col-lg-10\" style=\"font-weight:bold;margin-top:250px;margin-left:20px;\">YOU DO NOT HAVE THE CORRECT PREVILLEGE TO VIEW THIS PAGE,PLEASE LOG THE CURRENT USER OUT AND LOGIN</div>";
			die();
		}
		return;
	}
	
}
/**********************************check n return non empty variables************************************************/
function chkempty($var){
				if(!empty($var))
					{
				
				return $var;
					}
					else
					{
						return NULL;
					}
					
}
/**********************************check n return non empty variables************************************************/
function GetActiveTime($conn,$panelid,$prev,$JambNo){
	$timeID=array();
	$timeDept=array();
	if(is_numeric($prev))
	{
		$privilege=$prev;
	}
	//////////////////////////////////////////////////////////////////////////
	if($privilege==2)
	{
		$paneldet=getAllRecord($conn,"time_slot","PanelID='$panelid' AND Status='ACTIVE'","","");
		
				while($timerows=mysqli_fetch_array($paneldet)){
					$timeID[]=$timerows['id'];//get all id of timeslot that is active for the panel
					$timeDept[]=$timerows['ProgID'];
					
					echo lb();
					//var_dump($timeDept);
					}
					//print_r($timeID);
					$stdQuery=Select4rmdbtb($conn,"pstudentinfo_tb","","JambNo = '$JambNo'");
					$stdRecord=mysqli_fetch_array($stdQuery);
					if(in_array($stdRecord['VenueID'],$timeID))// (&& in_array($stdRecord['ProgID'],$timeDept) this checks if the candidate is to be screened by the panel and if its at the time slot
					{
						
					return $stdRecord;// if the candidate is valid for the paneln time slot,them send the resource to fetch the candidate details
					}
					else
					{
						echo"<div class=\"alert alert-danger col-lg-10\" style=\"font-weight:bold;margin-top:100px;margin-left:20px;\">THE CANDIDATE IS NOT ASSIGNED TO YOUR PANEL OR TIME SLOT IS NOT YET ACTIVE,SEND THE CANDIDATE TO ICT FOR CONFIRMATION</div>";
						die();
					}
	}
	else
	{
		$getAll=Select4rmdbtb($conn,"pstudentinfo_tb","","JambNo = '$JambNo'");
		$stdArray=mysqli_fetch_array($getAll);
		return $stdArray;
	}
	
}
////////////////////////////////////////////////////////////////
function Olvlexam($conn,$examtype){
	$olvl_exams=getAllRecord($conn,"olevelexamtype_tb","ID='$examtype'","","");
	$exam_type=mysqli_fetch_array($olvl_exams);	
	
	return $exam_type['Name'];
}
//////////////////////////////////////////
function getexset($set){
	if($set==1){echo "INTERNAL";}else{echo"EXTERNAL";}
	return;
}
function GetPanel($PanelID){
	switch ($PanelID) {
    case 1:
       $panel="PANEL ONE";
	 
	break;
    case 2:
		 $panel="PANEL TWO";
		
        break;
    case 3:
         $panel="PANEL THREE";
		
        break;
	case 4:
         $panel="PANEL FOUR";
		
        break;
		
    default:
        echo"";

					}//end of switch
return $panel; 					
	
}
/////////////////////////////////////////////////////////////////////////////


function GetScreenStatus($status){
	if($status==-1) {
       $label="<b style='color:red'>NOT-SCREENED</b>";
}else{
	$label="<b style='color:green'>SCREENED</b>";
	}
return $label; 		
}
///////////////////////////////////////////////////
function GetadmStatus($admstatus){
	if($admstatus==1){
		$admit_status="<b style='color:green'>ADMISSIBLE</b><br/>";
	}elseif($admstatus==0){
		$admit_status="<b style='color:red'>NOT-ADMISSIBLE</b><br/>";
	}
return $admit_status; 		
}
//////////////////////////////////
function getDeStatus($conn, $classofpass){

	$getPoint=mysqli_fetch_assoc(Select4rmdbtb($conn,"classofpass_tb","Point","ID = '$classofpass'"));

	$point = $getPoint['Point'];

	if($point>=2){
		//echo 'Point '.$point;
		$admit_status=1;
	}else{
		//echo 'Point '.$point;
		$admit_status=0;
	}
return $admit_status; 		
}
//////////////////////////////////////
function GetDEgrade($conn,$gradeid){
	$grd=getAllRecord($conn,"classofpass_tb","ID='$gradeid'","","");
	$grdtype=mysqli_fetch_array($grd);	
	
	return $grdtype['Abbr'];
}
function GetDEFullgrade($conn,$gradeid){
	$grd=getAllRecord($conn,"classofpass_tb","ID='$gradeid'","","");
	$grdtype=mysqli_fetch_array($grd);	
	
	return $grdtype['ClassName'];
}
////////////////////
function Getdeficiency($conn,$require){
	
	$deficiency = array_diff($require, $res_array);
	return $deficiency;
}
function GetReason($conn,$reason){
	$grd=getAllRecord($conn,"screening_reason","id='$reason'","","");
	$grdtype=mysqli_fetch_array($grd);	
	
	return $grdtype['Reason'];

}

function correct_venue(){
	$d=1;
	$grd=getAllRecord($conn,"pstudentinfo","VenueID='$d' AND RegLevel='6'","","");
	while($dd=mysqli_fetch_array($grd)):
			echo $dd['JambNo'];
	endwhile;

}

function checkjambAgg($conn,$score,$dept){
	$Agggrd=getAllRecord($conn,"dept_cutoff","ProgID='$dept'","","");
	$dd=mysqli_fetch_array($Agggrd);
	$cutoff=$dd['cutoff_mark'];
//	echo intval($dd['cutoff_mark']);
	if(isset($cutoff)):
			if((intval($score) >= intval($cutoff))){
//($dd['cutoff_mark']!=0) && 
//echo "true";
//echo intval($dd['cutoff_mark'])."/".intval($score);
				return 1;
			}else{
				return 0;
			}
		else:
			echo "Wrong score type passed";
			return 0;
		endif;

}
//functio to store all admissible with score below and above cutoff
function getAllAdmissible($conn,$regno,$score,$dpt){
	$above=1;
	$below=0;
	$scr_chk=checkjambAgg($conn,$score,$dpt);

	$cand_sc_details=getAllRecord($conn,"recommendation_tb","RegNo='$regno'","","");
			$screen_row=mysqli_fetch_array($cand_sc_details);
			$chk1=$screen_row['system_rec'];
			$chk2=$screen_row['panel_rec'];
			$chk3=$screen_row['medical_rec'];
			$chk4=$screen_row['panel_reason'];

	if($scr_chk==1){
		//if score is above cutoff
		 if(($chk1==1) && ($chk2==1) && ($chk3==1))// incase its needed: || ($chk1==1 && $chk2==1 && $chk3==0)
				{
					$fieldsVal=array('RegNo' => $regno,'ProgID' => $dpt,'status' => $above);
					
				}
			
	}else if($scr_chk==0){
		////if score is below cutoff
	//	if(($chk4==7)){// incase its needed: || ($chk1==1 && $chk2==1 && $chk3==0)
		
			$fieldsVal=array('status' => $below);
			
	//	}
	}
			$existchk=getAllRecord($conn,"admissible_tb","RegNo='$regno'","","");
			$exist_num=mysqli_num_rows($existchk);

			$admissrow=mysqli_fetch_row($existchk);

			//var_dump($existchk);
			if($exist_num>0){
				Updatedbtb($conn,"admissible_tb",$fieldsVal,"id='$admissrow[0]'");
			}else{
				Insert2DbTb($conn,$fieldsVal,"admissible_tb");
			}
	
	
		return;			
	

}

 function getSubjectAbbr($conn, $SubId){
	$gradeQuery = mysqli_fetch_assoc(Select4rmdbtb($conn,"olvlsubj_tb",$fields = "Abbr",$cond = "SubId = '".$SubId."'"));
	return $gradeQuery['Abbr'];
}

	function GetStateAbbr($StateId,$conn){
		if(is_numeric($StateId)){
		$sel_state = mysqli_query($conn,"SELECT * FROM state_tb WHERE StateId = '$StateId'");//decode programme id
					$rowstate=mysqli_fetch_assoc($sel_state);
return $rowstate['StateAbbr'];
		}

	}
	
	function GetTimeslot($id,$conn){
		if(is_numeric($id)){
		$sel_slot = mysqli_query($conn,"SELECT * FROM time_slot WHERE id = '$id'");//decode programme id
					$sel_arr=mysqli_fetch_assoc($sel_slot);
return $sel_arr;
		}

	}
function genPHPMEmail($mailTo,$mailFrom,$subject,$msg){
	// 
		$mailto = "$mailTo";
		$from_name = "AKSU";
		$from_mail = "$mailFrom";
		$subject = "$subject";
		$message = "$msg";
		$boundary = "XYZ-" . date('dmYis') . "-ZYX";
		$header = "--$boundary\r\n";
		$header .= "Content-Transfer-Encoding: 8bits\r\n";
		$header .= "Content-Type: text/html; charset=ISO-8859-1\r\n\r\n";
		$header .= "$message\r\n";
		$header .= "--$boundary\r\n";

		$header2 = "MIME-Version: 1.0\r\n";
		$header2 .= "From: ".$from_name." \r\n";
		$header2 .= "Return-Path: ".$from_mail." \r\n";
		$header2 .= 'Cc: ubonge80@gmail.com' . "\r\n";
		$header2 .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
		$header2 .= "$boundary\r\n";
		$getRespons = mail($mailto,$subject,$header,$header2,"-r".$from_mail);
		if($getRespons){
			return "Mail Sent";
		}else{
			return "Not Sent";
		}
	}
function getsubsc($conn){
	$s = getAllRecord($conn,"subscribers","","","");
	while($sel_arr=mysqli_fetch_array($s)){
		$d[] = $sel_arr['email'];
		
	}
	 
	$re = implode(',',$d);
	return $re;
}