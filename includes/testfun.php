<?php
session_start();

function lb(){
	return "<br/>";
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
$selqry = mysqli_query($conn,"SELECT * FROM pstudentinfo_tb_ar WHERE JambNo = '$regid'");//decode programme id
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
																		header('Location:medical/index.php');
																		break;
													case 2:
																		$_SESSION['screenpanel']=$usr_details['Username'];
																		$_SESSION['panel']=$usr_details['Panel'];
																		$_SESSION['prev']=$usr_details['Privilege'];	
																		header('Location:panel/index.php');
																		break;
													case 3:
																		$_SESSION['screensuper']=$usr_details['Username'];
																		$_SESSION['panel']=$usr_details['Panel'];
																		$_SESSION['prev']=$usr_details['Privilege'];	
																		header('Location:index.php');
																	break;
																	default:
																		echo"wrong privilege";

																}//end of switch
							
														
										}
										else
										{ 
										$error="<div class=\"alert aler-danger\">Wrong Username/Password</div>";
										$_SESSION['error']=$error;
										}
							
								}
								else
								{
											$error="<div class=\"alert aler-danger\">Password is incorrect.</div>";
											$_SESSION['error']=$error;
								}//end of row chk.
											
}
else
{
	echo "<div class=\"alert aler-danger\">You Must provide a userName and password</div>";
	}// end of empty check(isset)
	
	return array($_SESSION['screensuper'],$_SESSION['panel'],$_SESSION['prev']);
		
	}//end of function
	/////////////////////////////////////////////////////////////////////
	function chksession(){
	if(!isset($_SESSION['screensuper'])){
	    
	return header('location:login.php');
	}
	elseif(!isset($_SESSION['screenpanel']) || !isset($_SESSION['screenmed'])){
	    
	    return  header('location:../login.php');
	    
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
/// this function picks the subject & grade of the subject and returns 1 if it meets the requirement for the dept and 0 if it does not
 function checkRequirement($conn, $subjId, $gradeId, $ProgId){
 	$result = FALSE;

 	$conditionsQuery = mysqli_fetch_assoc(Select4rmdbtb($conn,"waec_require",$fields = array("Subj_comb", "Special_cons"),$cond = "ProgID = '".$ProgId."'"));
 	$core = explode("~",$conditionsQuery['Subj_comb']);

 	//echo "COre count ".count($core); 
 	for ($i=0; $i < count($core); $i++) { 
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
 	}

 	return $result;
}

///////////////////////////////////////////////////////////////////////////////
function checkAdmissibleStatus($conn, $olevel, $ProgId){
	
	$OlevelResult = explode("###",$olevel);

    $Olevel1 = explode("||",$OlevelResult[0]);

    $finalarray;

    if(count($OlevelResult)>1){

    	$Olevel2 = explode("||",$OlevelResult[1]);
    	$finalarray = array_merge($Olevel1, $Olevel2);

    }else{
    	$finalarray = $Olevel1;
    } 

    $conditionsQuery = mysqli_fetch_assoc(Select4rmdbtb($conn,"waec_require",$fields = array("Subj_comb", "Special_cons"),$cond = "ProgID = '".$ProgId."'"));
 	
 	$core = explode("~",$conditionsQuery['Subj_comb']);

 	//$requiredCount=0; 
 	$requiredSubjects = array();

	 	for ($i=0; $i < count($core); $i++) { 
 		# code...
 		if(!stripos($core[$i], "||")){
 			$coreGrade = explode(":", $core[$i]);

 			for ($j=0; $j < count($finalarray); $j++) { //submitted result processing
 				$finalSubj = explode("=", $finalarray[$j]);

	 			if ($coreGrade[0] == $finalSubj[0] && $coreGrade[1] >= $finalSubj[1]) {
	 				//++$requiredCount;
	 				$requiredSubjects[]= $coreGrade[0];
	 			}else{
	 
	 			}
 			}
 		}else if (stripos($core[$i], "||")){

 			$condSubjGrade = explode("||", $core[$i]);
 		//	$condCount;
 			$tempValue=0;
 			
 			for ($k=0; $k < count($condSubjGrade); $k++) { 
 				# code...
 				$condGrade = explode(":", $condSubjGrade[$k]);

 				for ($l=0; $l < count($finalarray); $l++) { 
 					# code...
 					$finalSubj2 = explode("=", $finalarray[$l]);
		 			if ($condGrade[0] == $finalSubj2[0] && $condGrade[1] >= $finalSubj2[1]) {

		 				++$tempValue;
		 				if($tempValue == 1){
		 				$requiredSubjects[]= $condGrade[0];
		 				//echo " tempresult :". $tempValue;
		 				}else{
		 					break;
		 				}
		 			}else{

		 			}
 				}
 				//break;
 			}

 			
 		}
 	}

 	return count(array_unique($requiredSubjects));
}
//////////////////////////////////////////////////////////////
function checkJamb($conn,$candJamb,$reqJamb,$ProgID){
	$correctsubj=array();
	$hasopt=0;
	$corechk=0;
	$othrchk=0;
	$status="";
	$numOfoptions=0;
	//the format for the reqJamb =core~optional~others 1:7~NULL~6:9:13:18:26:27:35:40:42
	$can_Jmb=explode("~",$candJamb);
	$req_Jmb=explode("~",$reqJamb);
	// break the core subject
	$core=explode(":",$req_Jmb[0]);
	$numOfcore=count($core);
	foreach($core as $core_req){
		if(in_array($core_req,$can_Jmb))
		{	//$correctsubj=$core_req;
		
			echo "<tr><td>".getSubject($conn,$core_req)."<span style= 'color: green;'> &#10004;</span></td></tr>";
			
			//echo $corechk;
				$corechk++;
				//var_dump($core_req);
		}
		else
		{//var_dump($core_req);
			echo "<tr><td><p style= 'color: red;'><span style= 'color: red;'> &#10008</span>"." ".getSubject($conn,$core_req)." is a required subject</p></td></tr>";
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
							echo "<p style= 'color: green;'>$optchk &#10004;</p>";
						
							break;//the break is to ensure that two of the optional courses are not allowed for a student.i.e if bio or agric,bio and agric shd not work
						}
						else
						{
							echo "<p style= 'color: red;'>$optchk &#10008;</p>";
						}
						
					}
			}//echo"<hr>";
						/* if($hasopt==$numOfoptions){ // check if the
							echo "<p style= 'color: blue;'>"."correct "."&#10004;</p>";
							
						}else{echo "<p style= 'color: yellow;'>"."correct "."&#10004;</p>";} */
	}
	//////end of if		///////////////////////
	
	//check other subject if not NULL
	if($req_Jmb[2]!="NULL"){

	$othersub=explode(":",$req_Jmb[2]);//////break by :(7||8:6||13)=>(7||8,6||13)
	
	//$numOfoptions=count($option);//get the number of items in the option section of the string return 2 for 2 options and 1 for 1 option.
	
	foreach($othersub as $addsub){ //here,each is fed in i.e 7||8
		//$prt=explode("||",$addsub);//7,8
						if(in_array($addsub,$can_Jmb))
						{
							//$correctsubj=$addsub;
							$othrchk++;
							//echo lb();
							echo "<p style= 'color: green;'>$addsub &#10004;</p>";
							//break;
						}
						else
						{
							//echo "<p style= 'color: red;'>$addsub &#10008;</p>";
						}
						
					
			}
						
	}//////end of if		///////////////////////
	//echo $hasopt."-".$numOfcore."-".$othrchk;
	//var_dump($correctsubj);
	$total_subj=$hasopt + $numOfcore + $othrchk;
	if($hasopt==$numOfoptions){
		if($numOfcore==$corechk){
			
			if($total_subj>=4){
						echo "<h4 style= 'color: green;'>Complete required subject combination &#10004</h5>";
							$status=1;
							return $status;
						}else{echo "<tr><td><h5 style= 'color: red;'>&#10008 Error! Incorrect UTME Subject Combination </h5></td></tr>";
								$status=0;
								return $status;
							}
								}
								else
									{echo"<tr><td><h5 style= 'color: red;'>&#10008 Error! Incorrect UTME Subject Combination</h5></td></tr>";
									$status=0;
									return $status;
									}
			
							}
							else
							{echo"<tr><td><h5 style= 'color: red;'>&#10008 Error! Incorrect UTME Subject Combination</h4></td></tr>";
							$status=0;
							return $status;
							}
				print_r($correctsubj);
	return ;
	
}
//////////////////////////////////////////////////////////////////
function Getutmerequire($conn,$ProgId){
$utmegetQuery = mysqli_fetch_assoc(Select4rmdbtb($conn,"utme_require",$fields = "Subj_comb",$cond = "ProgID = '".$ProgId."'"));
 	
 	return $utmegetQuery['Subj_comb'];
}

//////////////////////////////////////////////////////////////////////
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
///////////////////////////////////function to decide the final admission status of a student
function SetFinal($conn,$candID){
	
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
					$stdQuery=Select4rmdbtb($conn,"pstudentinfo_tb_ar","","JambNo = '$JambNo'");
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
		$getAll=Select4rmdbtb($conn,"pstudentinfo_tb_ar","","JambNo = '$JambNo'");
		$stdArray=mysqli_fetch_array($getAll);
		return $stdArray;
	}
	
}
////////////////////////////////////////////////////////////////////////////////////////
?>