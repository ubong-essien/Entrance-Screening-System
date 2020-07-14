<?php
//Last Edited - 22-5-17 #2
function IsFreshStud($regNo){
	global $dbo;
	$currSes = CurrentSes();
	$currSesID = $currSes['SesID'];
	$startses = StudStartSes($regNo);
	$startses = ($startses === false)?$currSesID:$startses;
	if($startses == $currSesID){
		return true;
	}else{
		return false;
	}
}

//function to form breakdown condition
function FormBrkDwnCond($attr, $oprator, $value, $studrec){
	
	
}

//function to get faculty based on progID
function Fac($progID){
	global $dbo;
	global $phpf;
	 $progID = (int)$progID;
	$query = "select fc.* from fac_tb fc, programme_tb pr, dept_tb dt where pr.DeptID = dt.DeptID and dt.FacID = fc.FacID and pr.ProgID = {$progID} limit 1";
	$rw = "";
	$rst = $dbo->RunQuery($query);
	if(is_array($rst)){
		if($rst[1] > 0){
			$rw = $rst[0]->fetch_array();
			
		}
	}
	return $rw;
}


//function to get payment item breakdown
function PaymentBreakDown($PayBrkDn,$lvl,$sem,$studrec = array(),$sempart=3){

$brkDnArr = explode("***",$PayBrkDn);//break all payment items string as array
	  $cnt = 1;
	  $trs = "";
	  $totamt = 0.0;
	  $printBrkDwn = "";
	  if(count($brkDnArr) > 0){//if items found
		  for($d =0; $d < count($brkDnArr); $d++){ //loop through individual items
		      $include = false; //determine if the current payment item is to be included
			  $brkItem = $brkDnArr[$d]; //get current payment item string
			  $brkItemCondArr = explode("?",$brkItem); //break item string into array by the "?" condition character; to know if there exist a condition for the display of item
			  $cond = (1==1);
			  if(count($brkItemCondArr) > 1){ //if condition exist, i.e split exist meaning "?" condition exist
				  $condstr =  $brkItemCondArr[0]; //get the condition part
				  $brkItem = $brkItemCondArr[1]; //get the item real string
				  $condArr = explode("==",$condstr); //break condition down by spliting the attribute and value
				  if(count($condArr) > 1){//if conndition is checking "=="
					  $atr = $condArr[0]; //get atribute
					  $val = $condArr[1]; //get value
					  $opr = "==";
					  //Note - attribute must be one of studentinfo_tb field
					  $cond = ($studrec[$atr] == $val); //form the condition by checking if student atrribute value is same as supplied value
				  }else{ //if conndition is checking "!="
					  $condArr = explode("!=",$condstr);
					  if(count($condArr) > 1){
					  $atr = $condArr[0];//get the attribute
					  $val = $condArr[1];//get the value
					 // $opr = "==";
					  $cond = ($studrec[$atr] != $val); //form the condition by checking if student atrribute value is not same as supplied value
					  }
				  }
			  }
			  if( $cond == false){//if condition not satisfied break
			  //i.e skip the item for the student
				 continue; 
			  }
			  $itemcontArr = explode("|",$brkItem); //break down the real payment item string
			  if(count($itemcontArr) == 3){ //if total payment item element is 3 i.e a valid payment item string
				  $name = $itemcontArr[0]; //get the payment item name
				  $amtList = explode("~",$itemcontArr[1]); //breakdown the amount structure, to get varous amount for deferent levels
				 
				  if(count($amtList) > 0){// if multiple amount found
				   // $alllev = "";
					  foreach($amtList as $amtstr){ //loop through all the amounts
						  $amtArr = explode("=",$amtstr); //breakdown individual amount
						  if(count($amtArr) == 2){ //if a valid individual amount structure
							  if((int)$amtArr[0] == $lvl || $amtArr[0] == "-1"){//if payment item amount level is student level or is for all level(-1)
							  //get the amount condition for that level
							  
							  $amtRealarr = explode("#",$amtArr[1]);
							  if(count($amtRealarr) > 1){ //if multiple amount found
								  $identifier = $amtRealarr[0]; //get the name of the operation or field to confirm form, e.g Fac - get amount base on faculty
								  if(count($studrec) > 0){//if student details send
									 //Fac($progID)
									 //based on faculty 
									 if(trim($identifier) == "Fac"){
										$studProgId =  $studrec['ProgID'];//the students programme Id
										$facD = Fac($studProgId);// get the faculty details of the programme using the progID
										if(is_array($facD)){
											$facID = $facD['FacID']."";//get the students facID
											//loop through all amounts
											for($s = 1; $s < count($amtRealarr); $s++){
												$fisrtAmtArrm = explode("@",$amtRealarr[$s]);
									            $firstAmtm = $fisrtAmtArrm[1]; //get the amount
									           $facmID = $fisrtAmtArrm[0]; //get the facID
											   if(trim($facmID) == trim($facID)){ //if student facID is the curremt amount facID
												   $amtArr[1] = $firstAmtm; //set the real amount
												   break;
											   }
											}
											//$name = $amtArr[1];
											//$amtArr[1] = $identifier;
										}
									 }
								  }else{//if no student info send pick the first amount
									  //break down the first amount
									  $fisrtAmtArr = explode("~",$amtRealarr[1]);
									  $firstAmt = $fisrtAmtArr[1]; //get the amount
									  $amtArr[1] = $firstAmt;
								  }
								  
							  }
								  //calculate Tution for part payment
								  /* if(trim($name)=="Tuition" && $sem == 1){
									   $percent = 50; //percent deduction
									 $amtArr[1] = ($percent/100) * (float)$amtArr[1];
								 }*/
								 if($sem < 3 && trim($itemcontArr[2]) != 3){ //if part payment policy for the current payment item exit
								   $partpaymentlist = explode("~",$itemcontArr[2]); //breakdown the part payment policy string
								   
								    if(count($partpaymentlist) > 0){
										for($as = 0; $as < count($partpaymentlist) ; $as++){//loop through all the policies
											$partp = explode("=",$partpaymentlist[$as]);//breakdown the current policy to get the semester and percentage amount of the main amount
											$brdwnSem = trim($partp[0]); //the current break down semester
											//comfirm if it has a SemPart
											$SemPrtStr = explode("_",$brdwnSem);
											$SemPrtcond = count($SemPrtStr) > 1?true:false;//if more than one sem id found: It is a SemPart Structure
											//return $amtArr[0]."=".$amtArr[1];
											//return $SemPrtcond . " ; " . $brdwnSem;
											//return "Level: ".$amtArr[0]." ; Sem: ".$sem." ; ItemSem: ".$brdwnSem." ; SemPart: ".$sempart." ; ContainSemPart: ".$SemPrtcond;
											if(($SemPrtcond == false && (int)$brdwnSem == $sem) || ($SemPrtcond == true && $brdwnSem == $sem."_".$sempart)){ //if the part id = 1 or 2 for half share and 1_1, 1_2, 1_3, 2_1, 2_2, 2_3 for quater sharing exit, get the percentage part and calculate amount
												
												//calculate amount based on percentage part
												$amtArr[1] = round((float)$partp[1] * (float)$amtArr[1]);
												$include = true;
												break;
											}
										}
									}
								 }elseif($sem == 3){//if full payment selected
									$amtArr[1] = (float)$amtArr[1];
								    $include = true;
								 }elseif($sem == 1 && ($sempart == 1 || $sempart == 3) && (int)$itemcontArr[2] == 3){
									 //if user selected sem is first and aempart is first part or first full and the item is to be paid full allow it 
									 $amtArr[1] = (float)$amtArr[1];
								    $include = true;
								 }
								 
								 //if student sem is 2 or student is completing first sem payment i.e sem is 1 and sempart is 2 and the polycy of item is 3; i.e the item is for full payment or first payment only
								// if($include == false || (($sem == 2 || ($sem == 1 && $sempart == 2)) && (int)$itemcontArr[2] == 3)){
									 //do nothing
								 //}else{
								if($include){
								  $amt = number_format($amtArr[1], 2, '.', ','); //format the amount
								 // $amt = floatval($amt);
								  $totamt += floatval($amtArr[1]); //calculate the total amount
								 // $id = str_replace(" ","_",$name);
								 /* $trs .= "<tr class=\"phtrTp\" style=\"text-align:left\">
                                     	<td width=\"10%\">{$cnt}</td><td width=\"60%\">{$name}</td><td width=\"30%\">{$amt}</td>
                                     </tr >";*/
								//$printBrkDwn .= $brkDnArr[$d]."***";
								$printBrkDwn .= $name."~".$amtArr[1]."***"; //form break down for printing slip
								  $cnt++;
								 }
							  }
						  }
						  
					  }
				  }
			  }
		  }
	  }else{
		return "No Payment Break-Down Found";  
	  }
	 /* if($cnt > 1){ //if breakdown found
	      if((int)$stateID != 3 && (int)$payItemID == 2){ //if not indigene and payment is school fee, add developmental fee = 20,000
			  $trs .= "<tr class=\"phtrTp\" style=\"text-align:left\">
                                     	<td width=\"10%\">{$cnt}</td><td width=\"60%\">Development Fees</td><td width=\"30%\">20000.00</td>
                                     </tr >";
										  $cnt++;
										  $totamt += 20000.00;
										  $printBrkDwn .= "Development Fees|-1=20000.00|3"."***";
		  }
		  
		  //add the transaction charge
		  $trs .= "<tr class=\"phtrTp\" style=\"text-align:left\">
                                     	<td width=\"10%\">{$cnt}</td><td width=\"60%\">Transaction Charges</td><td width=\"30%\">300.00</td>
                                     </tr >";
										  $pricepay = $totamt;
									 $totamt += 300.00; //transaction charge
										  $printBrkDwn .= "Transaction Charges|-1=300.00|3";
	  }*/
	  $rtot = number_format($totamt, 2, '.', ',');
	  /*$trs .= "<tr class=\"phtrTp\" style=\"text-align:left; font-weight:bold\">
                                     	<td colspan=\"2\" style=\"text-align:right; padding-right:4px; \">Total:</td><td width=\"30%\">{$rtot}</td>
                                     </tr >";*/
									 
									 
	$printBrkDwn = rtrim($printBrkDwn,"***");
	return array($totamt,$rtot,$printBrkDwn);	
	
}

function GetPaymentItem($payID){
	global $dbo;
	$payID = (int)$payID;
	$query = "SELECT * FROM item_tb  WHERE ID = {$payID} LIMIT 1";
	$rst = $dbo->RunQuery($query);
		$err = NULL;
			if(is_array($rst)){
				if($rst[1] > 0){
			       $err = $rst[0]->fetch_array();
				}/*else{
					$err = NULL;
				}*/
			}/*else{
				$err = true;
			}*/
			return $err;
}
$paymentItems = array('1'=>array("Acceptance Fees","Pay for Acceptance Fee.","acceptpay"), '2'=>array("School Fees","The School fees payment and other school related payment.","schpay"), '3'=>array("putme Form","Buy Post-UTME form","putmepay"));

//function to load courses 
function LoadCourseReg($regno, $Lower = false, $rp = 0){
/*<tr class=\"phtrsel\" title=\"Click to Select/Deselect\">
                                     	<td width=\"10%\">1
                                      </td><td width=\"25%\">COM 123</td><td width=\"55%\">Computer Fundermental</td><td width=\"10%\" class=\"ch\">20</td>
                                     </tr >*/	
	$studinfo = GetBasicInfo($regno,"stud");
	global $dbo;
	$ProgID = (int)$studinfo['ProgID'];
	$lvlar =  StudLevelSpill($regno);
	$lvl = (int)$lvlar[0];
	$sem = GetCourseRegSem($regno,0,$rp);
	$sem = (int)$sem[0];
	$cont = "";
	$op = ($Lower)?"<":"=";
	
	$rst = $dbo->RunQuery("SELECT * FROM course_tb WHERE  Lvl {$op} {$lvl} AND DeptID = {$ProgID} AND Sem = {$sem} order by Lvl desc");
	if(is_array($rst)){
		if($rst[1] > 0){
			$cnt = 0;
			while($rstt = $rst[0]->fetch_array()){
				$cnt++;
				$code = $rstt['CourseCode'];
				$title = $rstt['Title'];
				$CH = $rstt['CH'];
				$CID = $rstt['CourseID'];
				$clss = ((int)$rstt['Elective'] == 1)?"phtre":"phtr"; //outstanding => phtrsel
				$cont .= "<tr class=\"{$clss}\" id=\"{$CID}course\"  onclick=\"CourseReg.Select(this)\" title=\"Click to Select/Deselect\">
                                     	<td width=\"10%\">{$cnt}</td><td width=\"25%\" class=\"CCode\" style=\"text-transform:uppercase\">{$code}</td><td width=\"55%\" class=\"TTit\" style=\"text-transform:uppercase\">{$title}</td><td  width=\"10%\" class=\"ch\">{$CH}</td>
                                     </tr>
						
									 ";
		
			}
			
			    if($op == "="){
					$cont .= "<tr  title=\"Load Lower Level Courses\" id=\"loadlC\">
                                     	<td colspan=\"4\" style=\"font-size:1.1em; color:#E9E9E9\"><a href=\"javascript:CourseReg.LoadLowerCourse('{$regno}')\" title=\"Load Lower Level Courses\" style=\"float:left;font-style:\">Load Lower Level Courses</a></td>
                                     </tr>
									 
									 ";
				}
			
			//$cont .= "SELECT * FROM course_tb WHERE  Lvl {$op} {$lvl} AND DeptID = {$ProgID} AND Sem = {$sem} order by Lvl desc";
		}else{
			$cont = "#";
		}
	}else{
		$cont = "##";
	}
	return $cont;
}

//functon to get all courses from database for a particular student, given the level and semester
function GetStudCourses($regno, $lvl, $sem, $lower = false,$ProgID = 0){
	global $dbo;
	$studinfo = GetBasicInfo($regno,"stud");
	$StudyID = $studinfo['StudyID'];
	//return $studinfo['RegNo'];
		if($ProgID == 0){
			$ProgID = (int)$studinfo['ProgID'];
		}
	$op = ($lower)?"<":"=";
	$lvl = (int)$lvl;
	$sem = (int)$sem;
	$rst = $dbo->RunQuery("SELECT * FROM course_tb WHERE  Lvl {$op} {$lvl} AND DeptID = {$ProgID} AND Sem = {$sem} AND StudyID = {$StudyID} order by Lvl desc, CourseCode ASC");
	//if(is_array($rst)){
		return  $rst;
	//}
}

//function to get the current activated semester
function GetCurrentSem(){
	global $dbo;
	$rst = $dbo->RunQuery("SELECT * FROM semester_tb WHERE Current = 1 LIMIT 1");
	if(is_array($rst)){
		   if($rst[1] > 0){
			   $rstrw = $rst[0]->fetch_array();
			   return $rstrw;
		   }else{
			  return false;   
		   }
		   
	}else{
		return false; 
	}
	
}
//function to get the next semester to register courses
/*function GetCourseRegSem($RegNo, $lvl = 0, $rp = "0"){
	$regCourse = GetRegCourses($RegNo,$lvl);
	 if(is_array($regCourse)){ //if the top registration semester is not 2
	    if($regCourse[0] < 2){
					  if($regCourse[0] == 0){ //if not registered at all sem is First
						  $semester = "First";
						  $semCode = 1;
					  }else{ //if first semester already registered sem is Second
						 $semester = "Second";
						   $semCode = 2;
					  }
			$regCourse = array($semCode,$semester);
		}else{
			$regCourse = array(0,"Registered");
		}
	 }else{
		 $regCourse = array(-1,"Error");
	 }
	 if($rp == "1"){
					  if($regCourse[0] == 0){
						 $regCourse = array(2,"Second"); 
					  }else if($regCourse[0] == 2){
						  $regCourse = array(1,"First"); 
					  }else{
						  $regCourse = array(-1,"Error"); 
					  }
				  }
	return $regCourse;
}*/

function GetCourseRegSem($RegNo, $lvl = 0, $rp = "0"){
	$regCourse = GetRegCourses($RegNo,$lvl);
	$currSem = GetCurrentSem(); //get the currently activated semester [0] => id, [1] => Semester name
	 if(is_array($regCourse)){ //if the top registration semester is not 2
	  
	    if($regCourse[0] != $currSem[0]){
					  /*if($regCourse[0] == 0){ //if not registered at all sem is First
						  $semester = "First";
						  $semCode = 1;
					  }else{ //if first semester already registered sem is Second
						 $semester = "Second";
						   $semCode = 2;
					  }*/
			$regCourse = array($currSem[0],$currSem[1]);
		}else{
			$regCourse = array(0,"Registered");
		}
	 }else{
		 $regCourse = array(-1,"Error");
	 }
	 if($rp == "1"){
					  if($regCourse[0] == 0){
						 $regCourse = array($currSem[0],$currSem[1]); 
					 
					  }else{
						  $regCourse = array(-1,"Error"); 
					  }
				  }
	return $regCourse;
}

//function to Get Corses Registered
function GetRegCourses($RegNo, $lvl = 0){
	global $dbo;
	if($lvl == 0){ //if no level suplied get the current student
		$lvl = StudLevel($RegNo);
	}
	$lvl = $dbo->SqlSave($lvl);
	$sqlRegNo = $dbo->SqlSave($RegNo);
	$query = "SELECT * FROM coursereg_tb WHERE RegNo = '{$sqlRegNo}' AND Lvl = {$lvl} order by Sem desc";
		$rst = $dbo->RunQuery($query);
		$courses = array();
			   $topSem = 0;
		if(is_array($rst)){
		   if($rst[1] > 0){
			   
			  while($rstrw = $rst[0]->fetch_array()){
				$courses[] = $rstrw;
				if($topSem == 0){
				 $topSem = $rstrw['Sem']; 
				}
			  }
			  //$paypol = rtrim($paypol,":");
			  return array($topSem,$courses);
		   }else{
			   return array($topSem,$courses);
		   }
		   
	}else{
		return $rst;
	}
		
}

//check if the supplied student has paid for the supplied item for a specific level
function HasPaid($regNo,$payID,$lvl = 0,$sem = 0,$sempart=3,$RegID=1){
	//if($dbo == NULL){
	global $dbo;
	//}
	
	/*if($lvl == 0){ //if no level suplied get the current student
		$lvl = StudLevel($regNo);
	}*/
	/*if($payID == 1){ //acceptance
		$rst = GetBasicInfo($regNo,"stud");
		return array($rst['Accept'],3,$payID,$lvl);
	}else{ //others*/
	/*	$query = "SELECT * FROM payhistory_tb WHERE RegNo = '{$regNo}' AND Lvl = {$lvl} AND PayID = {$payID} order by Sem desc";
		$rst = $dbo->RunQuery($query);*/
	
	//if(is_array($rst)){
		
		   //check if hasPaid locally
		    $paid = CheckPayLocal($regNo,$payID,$lvl,$sem,$sempart,$RegID);
			 //return $paid;
			//if has paid return payment status array
		   if($paid[0] == 1)return $paid;
		   
		   //if not paid check etransact, if paid in bank, update local database
			$cp = CheckPay($regNo,$payID,$lvl,$sem,$sempart,$RegID);
			//return $cp;
			/*if(is_array($cp)){
			   return array(0,0,$payID,$lvl,0,"Invalid Amount Paid in Bank",$cp[1]);
			}*/
			if(is_array($cp)){
				return $cp;
			}
			$cpbf = $cp;
			$cparr = explode("#",$cp);
			$cp = $cparr[0];
			if($cp == "0"){
				return array(0,0,$payID,$lvl,0,"Go to Bank with the generated Payment Analysis Slip to make payment",1,$cpbf);
			}elseif($cp == "1"){
				return array(0,0,$payID,$lvl,0,"Invalid Amount Paid",2,$cparr[1]);
			}elseif($cp == "2"){
				return array(0,0,$payID,$lvl,0,"Internal Error: Invalid Parameter received from Third-Party",3,$cparr[1]);
			}elseif($cp == "3"){
				return array(0,0,$payID,$lvl,0,"Make Payment",4,$cparr[1]);
			}elseif($cp == "4"){
				return array(0,0,$payID,$lvl,0,"Server Error",5,$cparr[1]);
			}elseif($cp == "5"){
				return array(0,0,$payID,$lvl,0,"Transaction Failed",6,$cparr[1]);
			}elseif($cp == "6"){
				return array(0,0,$payID,$lvl,0,"Invalid Parameter or Bad Network",7,$cparr[1]);
			}elseif($cp == "#"){
				   return CheckPayLocal($regNo,$payID,$lvl,0,$sempart,$RegID);
			}else{
			//return array(0,0,2,1,$cp);
			//check if paid local again and return payment status array
		 return array(0,0,$payID,$lvl,0,"UnKnown Error");
			}
			
	
		   
	/*}else{
		return $rst;
	}*/
		
	//}
}

//function to check payment local
function CheckPayLocal($regNo,$payID,$lvl = 0,$sem = 0,$sempart=3,$RegID=1){
	global $dbo;
	
	/*$putme = "";
	if($payID == 3){
		$putme = "p";
	}*/
	$pre = StudPreByPayID($payID,$RegID);
	if($lvl == 0){ //if no level suplied get the current student
		$lvl = StudLevel($regNo,$pre);
	}
	/*if($payID == 1){ //acceptance
		$rst = GetBasicInfo($regNo,"stud");
		return array($rst['Accept'],3,$payID,$lvl);
	}else{ //others*/
	//if sempart is zero it means that the semester part is not a criteria, so far at least one payment is made it will been seen as paid
	$sempartquery = (int)$sempart != 0?(int)$sempart > 1?"(SemPart = 2 OR SemPart = 3)":"SemPart = {$sempart}":"1 = 1"; //if sempart is 3 or 2 are financially thesame, because the two represent completion of payment,i.e are to be considered as such in payment verification
	$semquery = ($sem == 0)?" AND Sem = 3":" AND (Sem = 3 OR (Sem = {$sem} AND {$sempartquery}))";
	$lvl = (int)$lvl;
	$payID = (int)$payID;
	$sqlregNo = $dbo->SqlSave($regNo);
		$query = "SELECT * FROM payhistory_tb WHERE RegNo = '{$sqlregNo}' AND Lvl = {$lvl} AND PayID = {$payID} {$semquery} order by Sem desc, SemPart desc";
		$rst = $dbo->RunQuery($query);
	if(is_array($rst)){
		   if($rst[1] > 0){
			   $paypol = "";
			   $TopSem = 0; //the top payment 3 , 2 or 1
			   $TopSemPart = 0;
			  while($rstrw = $rst[0]->fetch_array()){
				  if($TopSem == 0){ //get the bigest payment policy
					  $TopSem = (int)$rstrw['Sem'];
					  $TopSemPart = (int)$rstrw['SemPart'];
				  }
				  if((int)$rstrw['Sem'] == 3){
					  $paypol = "3";
					  break;
				  }
				  $paypol .= $rstrw['Sem'] . ":";
			  }
			  $paypol = rtrim($paypol,":");
			  return array(1,$paypol,$payID,$lvl,$TopSem,"",0,"",$TopSemPart);
		   }else{
			  return array(0,0,$payID,$lvl,0,"Make Payment",6); //paid(1)NotPaid(0), Semester/PayPolicy(1=first:2=second:3=full), paymenttype(1=acceptance/2=schoolfees), Level 
		   }
		   
	}else{
		 return array(0,0,$payID,$lvl,0,"Server Error: Local Check",7);
		
	}
	
}

//function to check if paid in bank through etransact gateway
function CheckPay($regNo,$payID,$lvl = 0, $sem = 0,$sempart=3,$RegID=1){
	global $dbo;
	/*$putme = "";
	if($payID == 3){
		$putme = "p";
	}*/
	$payID = (int)$payID;
	$pre = StudPreByPayID($payID,$RegID);
	$msg = ""; //holds the message from third party
	if($lvl == 0){ //if no level suplied get the current student
		$lvl = StudLevel($regNo,$pre);
	}
	
	$sempartquery = (int)$sempart != 0?(int)$sempart > 1?"(SemPart = 2 OR SemPart = 3)":"SemPart = {$sempart}":"1 = 1"; //if sempart is 3 or 2 are financially thesame, because the two represent completion of payment,i.e are to be considered as such in payment verification
	$semquery = ($sem == 0)?" AND Sem = 3":" AND (Sem = 3 OR (Sem = {$sem} AND {$sempartquery}))";
	$sqlregNo = $dbo->SqlSave($regNo);
	$lvl = (int)$lvl;
	//get if student place other
	$query = "SELECT * FROM order_tb WHERE RegNo = '{$sqlregNo}' AND Lvl = {$lvl} AND ItemID = {$payID} {$semquery} order by RegDate desc, Sem desc, SemPart desc";
	//echo $query;
		$rst = $dbo->RunQuery($query);
	//note - the system currently is not checking order on simester bases which will pose issue on school fee part payment - RESOLVED
	if(is_array($rst)){
		    
		   if($rst[1] > 0){//st
		   $det = $rst[0]->fetch_array();
			  return VerifyPayRemote($det['ItemNo']);
		   }else{
			  return "3";	//no order placed 
		   }
		   
		   
	}else{
	return "4";
		//return array("4",$rst); //error
	}
}

// 07/10/2016 - TAG: function to check/comfirm payment from thirdparty
function VerifyPayRemote($orderNum,$rrr=false){
	global $dbo;
	
			
			 $thirdP = $dbo->Select4rmdbtbFirstRw("school_tb","PayThirdParty");
			 $cond = $rrr == true?"TransNum = '$orderNum'":"ItemNo = '$orderNum'";
			 $det = $dbo->Select4rmdbtbFirstRw("order_tb","",$cond);

			 if(!is_array($det)){return "7#No Payment Initiation";}
			  $transNo = $det['TransNum']; //rep PayeeId for Etransact / RRR - for Remita
			 $ItemNo = $det['ItemNo']; //rep - orderId for Remita
			 if(is_array($thirdP) && $thirdP[0] == "ETRANZACT"){
			  $etr = QueryEtransact($transNo);
			  $data = UrlToArray($etr);
			  
			  //$etr = implode("~",$data);
			  $data['BANK'] = 1; //Assume Bank Payment
			 // $data = array(); //querying etraansact disabled
			  //return $data;
			 }else{
				 $remitaid = $rrr == true?$transNo:$ItemNo;
				 $data = QueryRemita($remitaid,$rrr); //Order ID or RRR
				 $data['TRANS_AMOUNT'] = $det['Amt']; //remita dont return amt, (so we set amt to ordered amt)
				 $data['TRANS_DATE'] = date("Y-m-d");  //use order date because remiter dont return payment date
				// return $data;
				 
			 }
			 
			  $msg = isset($data['message'])?$data['message']:"";
			  
			  if((isset($data['SUCCESS']) && $data['SUCCESS'] == -1) || count($data) == 0){
				  //check if it is a bank payment or card payment
				  if(isset($data['BANK']) && $data['BANK'] == 1 ){
				  
					  return "0#".$msg ; //not yet paid in bank
				  }else if(count($data) == 0){
					 return "6#{$msg}"; //Invalid Parameter or Bad Network 
				  }else{
					  
					 return "5#{$msg}"; //transaction failed 
				  }
				  
			  }else{
				if(isset($data['TRANS_AMOUNT'])){
					$amtPaid = (float)$data['TRANS_AMOUNT'];
					$amtOrder = (float)$det['Amt'];
					if($amtPaid < $amtOrder){
						return "1#{$msg}";
					}else{
						
				  $RegNo = $det['RegNo'];
				  $sem = $det['Sem'];
				  $sempart = $det['SemPart'];
				    $Lvl = $det['Lvl'];
					$date = $data["TRANS_DATE"];
					$paytype = $det['ItemID'];
					$transaction_number = $transNo;
					$item = $det['ItemNo'];
					$bank_name = $data["BANK_NAME"];
					$bank_branch = $data["BRANCH_NAME"];
					$val_number = $transaction_number . $item;
					//$ses = CurrentSes();
					$sqlregNo = $dbo->SqlSave($RegNo);
					 //insert into pay history
				   $dbo->RunQuery("INSERT INTO payhistory_tb(TransID, Amt, Bank, BnkBranch,itemNum,PayDate,Sem,Ses,Lvl,RegNo,PayID,validationNo,SemPart) VALUES ('".$dbo->SqlSave($transaction_number)."', '".$amtPaid."', '".$dbo->SqlSave($bank_name)."','".$dbo->SqlSave($bank_branch)."','".$dbo->SqlSave($item)."','".$dbo->SqlSave($date)."',".$sem.",".$det['Ses'].",".$Lvl.",'".$sqlregNo."',".$dbo->SqlSave($paytype).",'".$val_number."',$sempart)","hgdsgh");
				    //check for acceptance or postUTME payment
					 /*$putme = "";
					  if($det['ItemID'] == 3){
						  $putme = "p";
					  }*/
					//  $pre = StudPreByPayID($det['ItemID']);
				  /*if($det['studType'] != "r"){
					 
					  //update the student accept field in studentent info_tb;
					   $rst = $dbo->RunQuery("UPDATE {$pre}studentinfo_tb SET Accept = 1 WHERE RegNo = '".$sqlregNo."' OR JambNo = '".$sqlregNo."'", "a");
				  }*/
				  //update the order tb (Paid field)
				  $item = $dbo->SqlSave($item);
				  $transaction_number = $dbo->SqlSave($transaction_number);
				   $rst = $dbo->RunQuery("UPDATE order_tb SET Paid = 1 WHERE ItemNo = '".trim($item)."' and TransNum = '".trim($transaction_number)."'", "jadvskj");
				   //return "#";
				   return array(1,$sem,$paytype,$Lvl,$sem,"",0,"",$sempart);
					}
				}else{
				  return "2#{$msg}";	
				}
				  
			  }
	
}

//function to confirm from etansact
function QueryEtransact($TransNum){
	global $dbo;
	
	//Etranzact
	//================================================================================
	$querys = "SELECT * FROM etranzact_tb Limit 1";
		$rst = $dbo->RunQuery($querys);
   //set POST variables
   
   if(is_array($rst)){
	   
	   $rstarr = $rst[0]->fetch_array();
	   
	   $use = (trim($rstarr['USE']) == "DEMO")?"_DEMO":"";
$url = $rstarr['POST_URL' . $use];
$fields = array(
						'TERMINAL_ID' => $rstarr['TERMINAL_ID'.$use],
						'PAYEE_ID' => urlencode($TransNum),
						'RESPONSE_URL' => ''
				);
				
$fields_string = "";
//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
$fields_string=rtrim($fields_string, '&');

//open connection
$ch = curl_init();
//echo $ch;
//print_r($ch);
//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt_array($ch, array(CURLOPT_RETURNTRANSFER => 1));

//execute post
$rst = curl_exec($ch);
$rst = rtrim($rst,"</html>");
$rst = trim($rst);
curl_close($ch);
return urldecode($rst);
   }else{
	  return $rst;
   }
//close connection
//======================================================================================================

}

//function to query remita
function QueryRemita($orderId,$rrr=false){
/*Remitter
=====================================================================================================
*/
global $dbo;
global $MERCHANTID;
global $SERVICETYPEID;
global $APIKEY;
global $GATEWAYURL;
global $GATEWAYRRRPAYMENTURL;
global $CHECKSTATUSURL;
if(isset($MERCHANTID)){
	   if($rrr == false){
			$concatString = $orderId . $APIKEY . $MERCHANTID; //OrderNo+api_key+merchantId
			$hash = hash('sha512', $concatString);
			$url 	= $CHECKSTATUSURL . '/' . $MERCHANTID  . '/' . $orderId . '/' . $hash . '/' . 'orderstatus.reg';
	   }else{
		   $concatString = $orderId . $APIKEY . $MERCHANTID; //RRR+api_key+merchantId
			$hash = hash('sha512', $concatString);
			$url 	= $CHECKSTATUSURL . '/' . $MERCHANTID  . '/' . $orderId . '/' . $hash . '/' . 'status.reg';
	   }
		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		$response = json_decode($result, true);
		
		$response_code = $response['status'];
		//return $response;
		$response['URL'] = $url;
		  if (isset($response['RRR']))
			  {
			  $rrr = $response['RRR'];
			  }
		  $response_message = $response['message'];
		  $retArr = array();
		  if($response_code == '01' || $response_code == '00') { //if suceesfull
			 //$response['SUCCESS'] = 1;
			 
		  }else{
			  if($response_code == '021') { //if bank branch option and payment still pending
				  $response['BANK'] = 1; 
			  }
			  $response['SUCCESS'] = -1;
		  }
		  
		  return $response;
		}
		return array();
		
/*
=====================================================================================================
*/	
	
	
}

// 07/10/2016 - TAG: Function to verify payment by payment id
function HasPaidByPayRef($payRef, $rrr = false){
	global $dbo;
   //check local first
   $rst = $dbo->Select4rmdbtbFirstRw("payhistory_tb","",(!$rrr)?"itemNum = '{$payRef}'":"TransID = '{$payRef}'");
   if(is_array($rst)){ //if exist i.e paid
      return array(1,$rst['Sem'],$rst['PayID'],$rst['Lvl'],$rst['Sem'],"",0,"",$rst['SemPart'],$rst['RegNo']);
   }else{//if not seen local
      //determine thirdparty
      return VerifyPayRemote($rst['itemNo'],$rst['TransID'],$rst['Amt'],$rrr);
   }

}
//function to convert url string to array
function UrlToArray($str){
	$str = trim($str);
	$rst = array();
	if($str != ""){
		$strarr = explode("&",$str);
		for($a=0; $a<count($strarr) ; $a++){
			$strv = $strarr[$a];
			$stratrvallarr = explode("=",$strv);
			if(count($stratrvallarr) == 2){
				$rst[$stratrvallarr[0]] = $stratrvallarr[1];
				
			}
			
		}
		
	}
	return $rst;
	
}

//function to get postutme result
function GetPUTMEResult($JambNo, $RegID = 1){
	global $dbo;
	$JambNo = $dbo->SqlSave($JambNo);
	$query = "select * from putme_result_tb where JambNo = '".$JambNo."' and RegID = {$RegID} limit 1";
	$rstt = false;
	$rst = $dbo->RunQuery($query);
	//return $query;
	if(is_array($rst)){
		if($rst[1] > 0){
			$rstt = $rst[0]->fetch_array();
		}
	}else{
		return $rst;
	}
	return $rstt;
}


//function to get sub

function GetBasicInfo($fregno, $scope = "", $putme = "", $RegID = 1){
	//negative $RegID means regid must be strictly the postive(absolute)
		global $dbo;
		$fregno = $dbo->SqlSave($fregno);
		$preAll = false;
		if(trim($putme) == "a"){
			$putme = "";
			$preAll = true;
		}
		$op = "<=";
		$ord = "DESC";
		if($RegID == 0){
         $op = ">";
		 $ord = "";
		}elseif($RegID < 0){
		   $op = "=";
		   $RegID = abs($RegID);	
		}
	//get basic information from database
	if($scope == "stud"){
		$query = "(SELECT * FROM {$putme}studentinfo_tb WHERE (JambNo = '{$fregno}' OR RegNo = '{$fregno}') AND RegID {$op} {$RegID} ORDER BY RegID $ord)";
        if($preAll){
		  $query .= " UNION (SELECT * FROM pstudentinfo_tb_ar WHERE (JambNo = '{$fregno}' OR RegNo = '{$fregno}') AND RegID {$op} {$RegID} ORDER BY RegID $ord)";	
		}
		$query .= " LIMIT 1";
	}elseif($scope == "all"){
		$query = "(SELECT st.*, fac.*, dpt.*, pr.*, so.*, ac.* FROM {$putme}studentinfo_tb st, fac_tb fac, dept_tb dpt, programme_tb pr, state_tb so, {$putme}accesscode_tb ac WHERE (st.JambNo = '{$fregno}' OR st.RegNo = '{$fregno}') AND st.ProgID = pr.ProgID AND pr.DeptID = dpt.DeptID AND dpt.FacID = fac.FacID AND st.StateId = so.StateID AND (st.JambNo = ac.JambNo OR st.RegNo = ac.JambNo) AND st.RegID {$op} {$RegID} ORDER BY st.RegID $ord)";
        if($preAll){
		  $query .= " UNION (SELECT st.*, fac.*, dpt.*, pr.*, so.*, ac.* FROM pstudentinfo_tb_ar st, fac_tb fac, dept_tb dpt, programme_tb pr, state_tb so, paccesscode_tb ac WHERE (st.JambNo = '{$fregno}' OR st.RegNo = '{$fregno}') AND st.ProgID = pr.ProgID AND pr.DeptID = dpt.DeptID AND dpt.FacID = fac.FacID AND st.StateId = so.StateID AND (st.JambNo = ac.JambNo OR st.RegNo = ac.JambNo) AND st.RegID {$op} {$RegID} ORDER BY st.RegID $ord)";	
		}
		$query .= " LIMIT 1";
	}elseif($scope == "sch"){
		$query = "(SELECT st.*, fac.*, dpt.*, pr.* FROM {$putme}studentinfo_tb st, fac_tb fac, dept_tb dpt, programme_tb pr WHERE (st.JambNo = '{$fregno}' OR st.RegNo = '{$fregno}') AND st.ProgID = pr.ProgID AND pr.DeptID = dpt.DeptID AND dpt.FacID = fac.FacID  AND st.RegID {$op} {$RegID} ORDER BY st.RegID $ord)";
        if($preAll){
		  $query .= " UNION (SELECT st.*, fac.*, dpt.*, pr.* FROM pstudentinfo_tb_ar st, fac_tb fac, dept_tb dpt, programme_tb pr WHERE (st.JambNo = '{$fregno}' OR st.RegNo = '{$fregno}') AND st.ProgID = pr.ProgID AND pr.DeptID = dpt.DeptID AND dpt.FacID = fac.FacID AND st.RegID {$op} {$RegID} ORDER BY st.RegID $ord)";	
		}
		$query .= " LIMIT 1";
	}elseif($scope == "ac"){
		$query = "(SELECT * FROM {$putme}accesscode_tb WHERE (JambNo = '{$fregno}' OR RegNo = '{$fregno}') AND RegID {$op} {$RegID} ORDER BY RegID $ord)";
        if($preAll){
		  $query .= " UNION (SELECT * FROM paccesscode_tb WHERE (JambNo = '{$fregno}' OR RegNo = '{$fregno}') AND RegID {$op} {$RegID} ORDER BY RegID $ord)";	
		}
		$query .= " LIMIT 1";
		
	}elseif($scope == "studsch"){
		$query = "(SELECT st.*, fac.*, dpt.*, pr.*, fac.Abbr as FacAbbr, dpt.Abbr as DeptAbbr, pr.Abbr as ProgAbbr FROM {$putme}studentinfo_tb st, fac_tb fac, dept_tb dpt, programme_tb pr WHERE (st.JambNo = '{$fregno}' OR st.RegNo = '{$fregno}') AND st.ProgID = pr.ProgID AND pr.DeptID = dpt.DeptID AND dpt.FacID = fac.FacID AND st.RegID {$op} {$RegID} ORDER BY st.RegID $ord)";
        if($preAll){
		  $query .= " UNION (SELECT st.*, fac.*, dpt.*, pr.* FROM pstudentinfo_tb_ar st, fac_tb fac, dept_tb dpt, programme_tb pr WHERE (st.JambNo = '{$fregno}' OR st.RegNo = '{$fregno}') AND st.ProgID = pr.ProgID AND pr.DeptID = dpt.DeptID AND dpt.FacID = fac.FacID AND st.RegID {$op} {$RegID} ORDER BY st.RegID $ord)";	
		}
		$query .= " LIMIT 1";
	}else{
		if($putme == "p"){
			$pquery = ", st.PUTMECombID, st.SeatNo, st.VenueID";
		}else if($preAll){ //if combine
			$pquery = ", 0 as temp1, 0 as temp2, 0 as temp3"; //make the union field corresspond
		}else{
			$pquery = "";
		}
		$query = "(SELECT st.SurName, st.FirstName, st.OtherNames, st.Gender, fac.FacName, fac.FacID, st.RegNo, st.JambNo, dpt.DeptName, pr.ProgName, pr.Degree, st.ModeOfEntry, st.RegDate, st.Passport, st.StateId, st.LGA, st.JambAgg, st.Accept, st.RegLevel, st.Addrs, st.Email, st.ProgID, st.Phone, sd.Name as StudyName, st.StudyID, st.RegID{$pquery} FROM {$putme}studentinfo_tb st, fac_tb fac, dept_tb dpt, programme_tb pr, study_tb sd WHERE (st.JambNo = '{$fregno}' OR st.RegNo = '{$fregno}') AND '{$fregno}' != '' AND st.ProgID = pr.ProgID AND pr.DeptID = dpt.DeptID AND dpt.FacID = fac.FacID AND st.StudyID = sd.ID AND st.RegID {$op} {$RegID} ORDER BY RegID $ord)";
        if($preAll){
		  $query .= " UNION (SELECT st.SurName, st.FirstName, st.OtherNames, st.Gender, fac.FacName, fac.FacID, st.RegNo, st.JambNo, dpt.DeptName, pr.ProgName, pr.Degree, st.ModeOfEntry, st.RegDate, st.Passport, st.StateId, st.LGA, st.JambAgg, st.Accept, st.RegLevel, st.Addrs, st.Email, st.ProgID, st.Phone, sd.Name as StudyName, st.StudyID, st.RegID, st.PUTMECombID, st.SeatNo, st.VenueID FROM pstudentinfo_tb_ar st, fac_tb fac, dept_tb dpt, programme_tb pr, study_tb sd WHERE (st.JambNo = '{$fregno}' OR st.RegNo = '{$fregno}') AND '{$fregno}' != '' AND st.ProgID = pr.ProgID AND pr.DeptID = dpt.DeptID AND dpt.FacID = fac.FacID AND st.StudyID = sd.ID AND st.RegID {$op} {$RegID} ORDER BY RegID $ord)";	
		}
		$query .= " LIMIT 1";
	}
	 //return $query;
		$rst = $dbo->RunQuery($query);
	
	if(is_array($rst)){
		   if($rst[1] > 0){
			  $rstrw = $rst[0]->fetch_array();
			  $reg = trim($rstrw['RegNo']);
			  if($reg == ""){
				 $reg = $fregno; 
			  }
			  if($scope == ""){
					 $name = $rstrw['SurName']." ".$rstrw['FirstName']." ".$rstrw['OtherNames'];
				  $gender = (strtoupper($rstrw['Gender']) == "M")?"MALE":"FEMALE";
				  $fac = $rstrw['FacName'];
				  $dept = $rstrw['DeptName'];
				  $prog = $rstrw['ProgName'];
				  $dt = $rstrw['RegDate'];
				  $rstarr = array('Name' => $name, 'Gen' => $gender, 'Fac' => $fac, 'Dept' => $dept, 'Prog' => $prog, 'Reg'=>$reg, 'Date'=> $dt, 'Passport' => $rstrw['Passport'],'StateId' => $rstrw['StateId'],'lga' => $rstrw['LGA'],'jamb' => $rstrw['JambAgg'],'pay'=>$rstrw['Accept'],'RegLevel'=>$rstrw['RegLevel'],'Addr'=>$rstrw['Addrs'],'Email'=>$rstrw['Email'],'Phone'=>$rstrw['Phone'],'ProgID'=>$rstrw['ProgID'],'StudyID'=>$rstrw['StudyID'],'ModeOfEntry'=>$rstrw['ModeOfEntry'],'FacID'=>$rstrw['FacID'],'StudyName'=>$rstrw['StudyName'],'Degree'=>$rstrw['Degree'],'RegID'=>$rstrw['RegID'],'RegNo'=>$rstrw['RegNo'],'JambNo'=>$rstrw['JambNo']);
				 // $rstrw['sql'] = 'dkjdkjdkjds'; 
				 if($putme == "p"){
					$rstarr['PUTMECombID'] =  $rstrw['PUTMECombID'];
					$rstarr['SeatNo'] =  $rstrw['SeatNo'];
					$rstarr['VenueID'] =  $rstrw['VenueID'];
				 }
				 return $rstarr; 
			  }else{
				// $rstrw['sql'] = $query; 
				return $rstrw;
			  }
		   }else{
			  return "0"; 
		   }
		   
	}else{
		return $rst; 
	}
}

//return the current session, which is assumed to be the last inserted session record in session_tb
function CurrentSes(){
	global $dbo;
	$query = "SELECT * FROM session_tb ORDER BY SesID DESC LIMIT 1";
	
		$rst = $dbo->RunQuery($query);
	if(is_array($rst)){
		   if($rst[1] > 0){
			   $rstrw = $rst[0]->fetch_array();
			   return $rstrw;
		   }else{
			  return false;   
		   }
		   
	}else{
		return false; 
	}
}

function StudStartSes($regNo, $putme = "", $RegID = 1){
	global $dbo;
	$regNo = $dbo->SqlSave($regNo);
	$query = "SELECT StartSes FROM {$putme}studentinfo_tb WHERE (RegNo = '{$regNo}' OR JambNo = '{$regNo}') AND RegID = $RegID LIMIT 1";
	
		$rst = $dbo->RunQuery($query);
		if(is_array($rst)){
			 if($rst[1] > 0){
				 $rstrw = $rst[0]->fetch_array();
				  $startses = (int)$rstrw[0];
				  return $startses;
			 }else{
				return false ;
			 }
		}else{
			return false ;
		}
}

//function to get the student mode of entring
function GetMOE($regNo, $putme="", $RegID = 1){
		global $dbo;
		$regNo = $dbo->SqlSave($regNo);
	$query = "SELECT ModeOfEntry FROM {$putme}studentinfo_tb WHERE (RegNo = '{$regNo}' OR JambNo = '{$regNo}') AND RegID = $RegID LIMIT 1";
	
		$rst = $dbo->RunQuery($query);
		if(is_array($rst)){
			 if($rst[1] > 0){
				 $rstrw = $rst[0]->fetch_array();
				  $startses = $rstrw[0];
				  return $startses ;
			 }else{
				return false ;
			 }
		}else{
			return false ;
		}
}

//function to get the students department Year of study
function StudYearOfStudy($regNo,$putme="",$RegID = 1){
	global $dbo;
	$regNo = $dbo->SqlSave($regNo);
	$query = "SELECT p.YearOfStudy FROM programme_tb p, {$putme}studentinfo_tb s WHERE (s.RegNo = '{$regNo}' OR s.JambNo = '{$regNo}') and s.ProgID = p.ProgID and RegID = $RegID LIMIT 1";
	
		$rst = $dbo->RunQuery($query);
		if(is_array($rst)){
			 if($rst[1] > 0){
				 $rstrw = $rst[0]->fetch_array();
				  $years = $rstrw[0];
				  return $years ;
			 }else{
				return false ;
			 }
		}else{
			return false ;
		}
}

//function to calculate the student current level
function StudLevel($regNo, $putme="", $RegID = 1){
	$startses = StudStartSes($regNo,$putme,$RegID); //get the start session of the student
	$studModeofEn = GetMOE($regNo,$putme,$RegID); //get the student mode of entry
	$studModeofEn = GetMOEID($studModeofEn); //if utme 1 else 0
	
	if($startses === false)return $startses;
	//if start ses is zero
	 $currSes = CurrentSes();
			   $currSesID = $currSes['SesID'];
			   //$startses = (int)$rstrw[0];
			   if($startses < 1){ //if student has not registered use current seesion as the startsession
				   $startses = (int)$currSesID;
			   }
	//$startses = $startses - $studModeofEn; // calculate the startsession for direct entry student ( =1)
	//$startses = ($startses < 1)?1:$startses; //if the calculated startsession is less than 1 set start session to 1
			   //$rstrw = mysql_fetch_array($rst[0]);
			  
			   $lvl = ((int)$currSesID - $startses) + $studModeofEn; 
			   //($lvl - $studModeofEn) + $startses = $currSesID;
			   //calculate level
			   $lvl = ($lvl < 1)?1:$lvl;
			   return "$lvl";
	
}

//function to calculate student level in a particular session 
function StudLevelSes($RegNo,$Ses=0){
	global $dbo;
	$studD = $dbo->SelectFirstRow("studentinfo_tb","","RegNo='$RegNo' OR JambNo='$RegNo' LIMIT 1");
	if(is_array($studD)){
      $moe = $studD['ModeOfEntry'];
	  $moe = GetMOEID($moe);
	  $startSes = (int)$studD['StartSes'];
      if($Ses == 0){
		  $currSes = CurrentSes();
		$Ses = $currSes['SesID'];
	  }
     $lvl = ((int)$Ses - $startSes) + $moe; 
			   //($lvl - $studModeofEn) + $startses = $currSesID;
			   //calculate level
			   $lvl = ($lvl < 1)?1:$lvl;
			   return "$lvl";
	}
	return 1;
}

//function to get student level and spillover startus
function StudLevelSpill($regNo,$putme="",$RegID = 1){
	$lvl = StudLevel($regNo,$putme,$RegID); // calculate students expected level
	$years = StudYearOfStudy($regNo,$putme,$RegID); //get the years of study
	$spill = $lvl - $years; //get the spillovers
	$lvl2 = ($lvl > $years)?$years:$lvl; //reset level to number of years when spilled
	return array($lvl2,$spill,$lvl,$years);
}

function BreakDownRst($sitd,$sit){
	/*$sitd = @$rstrw['OlevelRstDetails'];
				$sit = @$rstrw['OlevelRst'];*/
				$sitdarr = explode("###",$sitd);
				$sitarr = explode("###",$sit);
				
				$sitd1 = @$sitdarr[0];
				$sitd2 = @$sitdarr[1];
				
				$sit1 = @$sitarr[0];
				$sit2 = @$sitarr[1];
				
				if(trim($sitd1) != ""){
				$sitrealdarr1 = explode("`~",$sitd1);	
				}else{
					$sitrealdarr1 = array ("","","","");
				}
				if(trim($sitd2) != ""){
				$sitrealdarr2 = explode("`~",$sitd2);	
				}else{
					$sitrealdarr2 = array ("","","","");
				}
				
				//results array
				if(trim($sit1) != ""){
				$sit1arr = explode(";",$sit1);
				}else{
					$sit1arr = array();
				}
				if(trim($sit2) != ""){
				$sit2arr = explode(";",$sit2);
				}else{
					$sit2arr = array();
				}
				
				return array($sitrealdarr1,$sit1arr,$sitrealdarr2,$sit2arr);
	
}

//function to Get payment information upon request from bank
function GetPayInfo($payeeID,$payType){
	global $dbo;
	$payType = $dbo->SqlSafe($payType);
	$queryPtype = "select ID, ControlTable from item_tb where ItemName = '{$payType}'"; //get the item id through the item name
	$prst = $dbo->RunQuery($queryPtype);
	if(is_array($prst)){
	if($prst[1] <= 0){
			return "PayeeName=N/A~Faculty=N/A~Department=N/A~Level=N/A~ProgrammeType=N/A~Session=N/A~PayeeID=N/A~Amount=N/A~FeeStatus=N/A~Semester=N/A~PaymentType=Wrong Payment Type~MatricNumber=N/A~Email=N/A~PhoneNumber=N/A"; 
		}
		$itemarr = $prst[0]->fetch_array();
		$itemID = $itemarr[0];
		$controlTb = @$itemarr['ControlTable']; //get the control table of the collection using the payment item (the control table contain the record set by admin for the collection e.g the prefix
		$pref = "";
		if(trim($controlTb) != ""){
			$cond = "";
			if(trim($controlTb) == "putme"){ //if general
              $cond = "where PayID=$itemID";
			}
			$prfrst = $dbo->RunQuery("select StudInfoPref from {$controlTb} $cond");
			if(is_array($prfrst)){
				if($prfrst[1] > 0){
					$prefs = $prfrst[0]->fetch_array();
					$pref = $prefs[0];
				}
			}
		}
		//$putme = ((int)$itemID == 3)?"p":"";
		$payeeID = $dbo->SqlSafe($payeeID);
	$query = "SELECT st.SurName, st.FirstName, st.OtherNames, st.Phone, st.Email, fac.FacName, dpt.DeptName, pr.ProgName, ord.ItemNo, ord.TransNum, ord.ItemName, ord.Amt, ord.Currency, ord.RegNo, ord.Sem, ord.Lvl, ord.ItemID, ord.Paid, ord.RegDate, se.SesName FROM {$pref}studentinfo_tb st, order_tb ord, session_tb se, fac_tb fac, dept_tb dpt, programme_tb pr WHERE (st.JambNo = ord.RegNo OR st.RegNo = ord.RegNo) AND ord.TransNum = '{$payeeID}' AND ord.ItemName='{$payType}' AND st.ProgID = pr.ProgID AND pr.DeptID = dpt.DeptID AND dpt.FacID = fac.FacID AND ord.Ses = se.SesID LIMIT 1";
	/*return $query;
	exit;*/
		$rst = $dbo->RunQuery($query);
	
	if(is_array($rst)){
		   if($rst[1] > 0){
			  $rstrw = $rst[0]->fetch_array();
			  $sname = $rstrw['SurName'];
			  $fname = $rstrw['FirstName'];
			  $oname = $rstrw['OtherNames'];
			   $fac = $rstrw['FacName'];
			    $dept = $rstrw['DeptName'];
				 $prog = $rstrw['ProgName'];
				  $itemName = $rstrw['ItemName'];
				   $amt = $rstrw['Amt'];
				    $phone = $rstrw['Phone'];
					 $email = $rstrw['Email'];//SesName
					 $lvl = (int)$rstrw['Lvl'] * 100;
					 $ses = $rstrw['SesName'];
					 $status = ($rstrw['Paid'] == 1)?"Fee has been paid":"Fee has not been paid";
					 $sem = $rstrw['Sem'];
					 if($sem == 1){
						$sem = "FIRST"; 
					 }else if($sem == 2){
						 $sem = "SECOND"; 
					 }else{
						 $sem = "FIRST-SECOND"; 
					 }
					 $reg = $rstrw['RegNo'];
					// $putme = PUTME();
					 
					/* if(is_array($putme)){
						 $ses = SessionName($putme['Session']);
					 }*/
					// $itemName = $rstrw['ItemName'];
			  return "PayeeName={$sname} {$fname} {$oname}~Faculty={$fac}~Department={$dept}~Level={$lvl}~ProgrammeType={$prog}~Session={$ses}~PayeeID={$payeeID}~Amount={$amt}~FeeStatus={$status}~Semester={$sem}~PaymentType={$itemName}~MatricNumber={$reg}~Email={$email}~PhoneNumber={$phone}";
		   }else{
			  return "PayeeName=N/A~Faculty=N/A~Department=N/A~Level=N/A~ProgrammeType=N/A~Session=N/A~PayeeID=Wrong Payee_ID~Amount=N/A~FeeStatus=N/A~Semester=N/A~PaymentType=Wrong Payment Type~MatricNumber=N/A~Email=N/A~PhoneNumber=N/A"; 
		   }
	}else{
		return $rst; 
	}
	
	}else{
	  return "PayeeName=N/A~Faculty=N/A~Department=N/A~Level=N/A~ProgrammeType=N/A~Session=N/A~PayeeID=N/A~Amount=N/A~FeeStatus=N/A~Semester=N/A~PaymentType=Wrong Payment Type~MatricNumber=N/A~Email=N/A~PhoneNumber=N/A"; 	
	}
	
}

//function to get all putme details
function PUTME($ID = 1){
	global $dbo;
	
	$rst2 = $dbo->RunQuery("select * from putme where ID <= $ID ORDER BY ID desc limit 1");
	//$subcomb = "";
	if(is_array($rst2)){
		if($rst2[1] > 0){
			$subj = $rst2[0]->fetch_array();
			return $subj;
		}
	}
	return "";
}

//function to get the school registration type (Verification Type for bio data registration
function STUDREG($RegID = 1){
	global $dbo;
	$rst2 = $dbo->RunQuery("select * from form_tb where ID <= {$RegID} order by ID desc limit 1");
	$subcomb = "";
	if(is_array($rst2)){
		if($rst2[1] > 0){
			$subj = $rst2[0]->fetch_array();
			return $subj;
		}
	}
	return "";
}

//function to Get student subjComb
function GetSubjComb($regNo, $studpre = "p",$RegID = 1){
	global $dbo;
	$rst = GetBasicInfo($regNo,"stud",$studpre,$RegID);
	$progID = (int)$rst['ProgID'];
	$rst2 = $dbo->RunQuery("select * from putme_subj_tb where DeptId = {$progID}");
	$subcomb = array();
	if(is_array($rst2)){
		if($rst2[1] > 0){
			while($subj = $rst2[0]->fetch_array()){
				$sub1 = GetSubj2($subj[2]);
				$sub1 =$sub1[1];
				$sub2 = GetSubj2($subj[3]);
				$sub2 =$sub2[1];
				$sub3 = GetSubj2($subj[4]);
				$sub3 =$sub3[1];
				$sub4 = GetSubj2($subj[5]);
				$sub4 =$sub4[1];
				$key = $subj[0];
			$subcomb[$key.""] = $sub1  . " | ". $sub2 . " | ". $sub3 . " | ". $sub4; 
			//$subcomb[$subj[0]] = $subj[2]. " | ". $subj[3] . " | ". $subj[4] . " | ". $subj[5]; 
			}
		}
	}
	return $subcomb;
}

// Get subject combination by ID
function GetSubjCombID ($ID){
	global $dbo;
	$ID = (int)$ID;
	$rst2 = $dbo->RunQuery("select * from putme_subj_tb where PutmeSubjId = {$ID}");
	$subcomb = "";
	if(is_array($rst2)){
		if($rst2[1] > 0){
			$subj = $rst2[0]->fetch_array();
				$sub1 = GetSubj2($subj[2]);
				$sub1 =$sub1[1];
				$sub2 = GetSubj2($subj[3]);
				$sub2 =$sub2[1];
				$sub3 = GetSubj2($subj[4]);
				$sub3 =$sub3[1];
				$sub4 = GetSubj2($subj[5]);
				$sub4 =$sub4[1];
				$key = $subj[0];
			$subcomb = $sub1  . " | ". $sub2 . " | ". $sub3 . " | ". $sub4; 
			//$subcomb[$subj[0]] = $subj[2]. " | ". $subj[3] . " | ". $subj[4] . " | ". $subj[5]; 
			
		}
	}
	return $subcomb;
}

//function to get subject by id
function GetSubj2($ID){
	global $dbo;
	$sub = "";
	$subavr = "";
	$ID = (int)$ID;
	$rst2 = $dbo->RunQuery("select * from  olvlsubj_tb where SubId = {$ID}");
	if(is_array($rst2)){
		$subb = $rst2[0]->fetch_array();
		$sub = $subb[1];
	}
	
	if($sub != ""){
		$subavr = substr($sub,0,3);
	}
	return array($sub, $subavr);
}

//function to get all subjects in alphabetic order
function GetSubjAll(){
	global $dbo;
	$sub = "";
	$subavr = "";
	$subjarr = array();
	$rst2 = $dbo->RunQuery("select * from  olvlsubj_tb");
	if(is_array($rst2)){
		while($subb = $rst2[0]->fetch_array()){
			$subjarr[$subb[0]] = $subb[1];
		}
	}
	return $subjarr;
}

function ResolveSeatNo($seatNo){
  $seatNo = $seatNo."";
  $strlen = count($seatNo);
  $rem = 3 - $strlen;
  $zero = "";
  for($d=0; $d<$rem; $d++){
      $zero .= "0";
  }
  return $zero.$seatNo;
}
//562389421357
//get a postutme venue and seat number of a student base on the department/programme
function GetVenue($RegNo, $RegID = 1){
	global $dbo;
	$venu = NULL;
	$RegNo = $dbo->SqlSave($RegNo);
	$progID = $dbo -> RunQuery("select ProgID from pstudentinfo_tb_ar where (JambNo = '{$RegNo}' or RegNo = '{$RegNo}') and RegID = {$RegID} limit 1");
	if(is_array($progID) && $progID[1] > 0){
	$progIDarr = $progID[0]->fetch_array();
	$progID = $progIDarr[0];
	$totreg = TotalPutmeReg($progID,$RegID);
	$tottemp = $totreg; //hold the total  student registered for the department
	$progID = (int)$progID;
	$rst2 = $dbo->RunQuery("select * from  venue_tb where DeptID = {$progID}");
	//return $totreg;
	if(is_array($rst2) && $rst2[1] > 0){
		//$cnt = 0;
		$lstvenue = array();
		while($venu = $rst2[0]->fetch_array()){ //loop through all venue of the department
			if($totreg < $venu['capacity']){
				$venu['SeatNo'] = ResolveSeatNo($totreg + 1);
				return $venu;
			}else{
				$totreg -= $venu['capacity'];
			}
			$lstvenue = $venu;
		}
		//if all venue are field up return the last venue and increament the seat no
		$lstvenue['SeatNo'] = ResolveSeatNo($tottemp + 1);
		return $lstvenue;
		//$veb = $subb[1];
	}
	
	}
	return NULL;
}

function Venue($ID){
	global $dbo;
	$ven = "";
	$ID = (int)$ID;
	$rst2 = $dbo->RunQuery("select * from  venue_tb where venueId = {$ID}");
	if(is_array($rst2) && $rst2[1] > 0){
		$venu = $rst2[0]->fetch_array();
		$ven = $venu['venue'];
	}
	return $ven;
}

function Venue2($ID){
	global $dbo;
	$ven = "";
	$ID = (int)$ID;
	$rst2 = $dbo->RunQuery("select * from  venue_tb where venueId = {$ID}");
	if(is_array($rst2) && $rst2[1] > 0){
		$venu = $rst2[0]->fetch_array();
		$ven = $venu['campus'];
	}
	return $ven;
}

//get total post utme student that registerd in a partucular department
function TotalPutmeReg($ProgID,$RegID = 1){
	global $dbo;
	$ProgID = (int)$ProgID;
	$rst2 = $dbo->RunQuery("select count(*) from  pstudentinfo_tb_ar where RegLevel = 6 and ProgID = $ProgID and RegID = ".$RegID);
	$tot = 0;
	if(is_array($rst2) && $rst2[1] > 0){
		$totarr = $rst2[0]->fetch_array();
		$tot = $totarr[0];
	}
	return $tot;
}

//get putme date and time
function PUTMEDateTime($ProgID){
	global $dbo;
	if(isset($ProgID)){
		//Select4rmdbtbFirstRw($tbs,$fields = "",$cond = "")
	  $putmerst = $dbo->Select4rmdbtbFirstRw("pschedule_tb","","ProgID=$ProgID");
	  if(is_array($putmerst)){
		  $day = $putmerst["pDateTime"];
		 // $date = $putmerst["Date"];
		 // $time = $putmerst["Time"];
		 $dateputme = new DateTime($day);
		  return $dateputme->format("d/m/y | h:m A");
	  }/*else{
		  return "";
	  }*/
	}/*else{
	
	$putmerst = $dbo->RunQuery("select * from putme where ID = {$RegID}");
				$dateputmer = "";
				if(is_array($putmerst)){
					if($putmerst[1] > 0){
						$pdt = $putmerst[0]->fetch_array();
						$dateputme = new DateTime($pdt[1]);
						$dateputmer = $dateputme->format("d/m/y | h:m A");
					}
				}
				return $dateputmer;
	}*/
return "";
}

//get state of origin by state id
function GetState($StateID){
	global $dbo;
	$StateID = (int)$StateID;
	$putmerst = $dbo->RunQuery("select * from state_tb where StateID = {$StateID} limit 1");
				$state = "";
				if(is_array($putmerst)){
					if($putmerst[1] > 0){
						$pdt = $putmerst[0]->fetch_array();
						$state = $pdt[1];
						//$dateputmer = $dateputme->format("d/m/y | h:m A");
					}
				}
				return $state;
}

function GetSchool(){
	global $dbo;
	$putmerst = $dbo->RunQuery("select * from school_tb limit 1");
				$pdt = "";
				if(is_array($putmerst)){
					if($putmerst[1] > 0){
						$pdt = $putmerst[0]->fetch_array();
						//$state = $pdt[1];
						//$dateputmer = $dateputme->format("d/m/y | h:m A");
					}
				}
				return $pdt;
}

function GetPortal(){
	global $dbo;
	$putmerst = $dbo->RunQuery("select * from portal_tb limit 1");
				$pdt = "";
				if(is_array($putmerst)){
					if($putmerst[1] > 0){
						$pdt = $putmerst[0]->fetch_array();
						//$state = $pdt[1];
						//$dateputmer = $dateputme->format("d/m/y | h:m A");
					}
				}
				return $pdt;
}

//function to verify payment //requires the caller page to have included the object.php, phplb.php, config.php
function Verify($regNo , $studPre="", $payID = 3, $name="",$verifyType="",$RegID = 1){
	
	global $dbo;
	//get verification type bassed on the payment type(payID)
	/* if($payID == 3){ //if post-UTME
	  $putme = PUTME(); //get the putme detail
	  $verifyType = (is_array($putme) && $putme['Verify'] == "STUDENT")?"STUDENT":"NONE";
	 }elseif($payID == 4 || $payID == 1){ //application form fee or acceptance fee, meaning student is verifying upon bio data registrtion
		 $frm = STUDREG(); //get the form registration detail
		 $verifyType = $frm['Type'];
	 }*/
	 
	//get student preloaded info ($studPre indicate the student table to use)
	//$studrecType = (is_array($putme) && $putme['Verify'] == "STUDENT")?"":"stud";
  $DB = GetBasicInfo($regNo,"",$studPre,-$RegID); //p represent target table (PUTME);
  
  if(is_array($DB)){//if student record exist
	  /*if($verifyType == "NONE"){ //if verification type is NONE, format the $DB paramater to suite the one of normal verification so that other code still apply
		    $DB['Name'] = $DB['SurName']." ". $DB['FirstName'] ." ". $DB['OtherNames'];
			$DB['pay'] = $DB['Accept'];
			//$DB['RegLevel'] = $DB['SurNames'];  
	  }*/
	  
	  if($verifyType == "PU"){ //if pstume result as to be verified
		  
		  //get the students putme result
		  $prst = GetPUTMEResult($regNo,$RegID);
		  if(is_array($prst)){
			  $aggr = (int)@$prst['Score1'] + (int)@$prst['Score2'] + (int)@$prst['Score3'] + (int)@$prst['Score4'];
			  //get the students department(programme)'s putme passmark
			  $passm = PUTMEPassMark($DB['ProgID']);
			  if($passm <= 0){
				 return "@@##"; //represent invalid putme passmark
			    // return; 
			  }
			  if($aggr < $passm){
				  return "@@@##"; //represent student score below passmark
			     //return; 
			  }
			  
		  }else{
			  return "@##"; //represent student jamb result can not be found
			  //return;
		  }
		  
	  }
	  
	return VerifyR($DB, $regNo, $payID,$verifyType,$studPre,$RegID);
	  
  }else{ //if student record not found
     
	  if($verifyType == "STUDENT" || $verifyType == "JN" || $verifyType == "PU"){ // if verification is normal i.e STUDENT-for putme, JN- for biodata reg, PU-also biodata reg
	  return "#"; //return # to ajax call to display invalid registration number
	  }else{ //if not normal verification
	  
	  if($verifyType == "NONE"){
		//$printobj =   "PRegister";
		$putmes = PUTME($RegID);
        $closed  = ($putmes['Status'] == "CLOSED")?1:0;
		
		
	  }else{
		 //$printobj =   "FVerify";
		 $putmes = STUDREG($RegID);
        $closed  = ($putmes['Status'] == "CLOSED")?1:0; 
	  } 
	  
		  if($name === ""){ //if basic candidate information not send
			  return "#"; //return invalid regno as well
			  //return;
		  }elseif($name['name'] == "#"){ //if name is "#" meaning the candidate try to verify for the first time, then return ## to ajax call meaning the student should be allowed to enter his/her details and verify again
			if((int)$closed == 1){
				return "##@";
			}else{
				//if($studPre != "p"){// if the verification is not from entrance verification, check if the student has register for entrance, then return with it other entrance details for data preload
					$DBP = GetBasicInfo($regNo,"","a",0); //0 RegID look for any registration done
					if(is_array($DBP)){// student has registered for entrance
					  $datstr = $dbo->DataString($DBP); //convert the student info array to a data string for ajax transfer
					  return "##``".$datstr;
					}
				//}
				return "##";
			}
			   
			 // return;
		  }
		  
		  //else i.e the student sends his/her information, so it will be inserted as required
		  $names = strtoupper($name['name']);
		  $namearr = explode("~",$names);
		  $surname = isset($namearr[0])?$namearr[0]:"";
		  $firstname = isset($namearr[1])?$namearr[1]:"";
		  $othername = isset($namearr[2])?$namearr[2]:"";
		  $jamb = "";
		  if(isset($name['jamb'])){
		   $jamb = $name['jamb'];
		  }
		  $ProgID = $name['dept'];
		  $gender = $name['gender'];
		  $study = $name['study'];
		  $lvl = (int)$name['lvl'];
		  $lvl = ($lvl == 0)?1:$lvl;
		  $moe = (int)$name['moe'] == 0?1:(int)$name['moe'];
		  $currSes = CurrentSes();
		  $payed = 0;
	$currSesID = $currSes['SesID'];
	     $startSes = $currSesID - ($lvl - $moe);
		 
		  if(isset($name['teller'])){ //if user already paid directly in bank
		 
			  $teller = $dbo->SqlSave($name['teller']);
			  $recs = $dbo->Select4rmdbtbFirstRw("pay_teller_tb","","TellerNo='{$teller}'");
			  if(is_array($recs)){
				 $regNoT = $recs['RegNo'];
				 //if regno exist for the teller number
				 if(trim($regNoT) != ""){
					 //if regno is same with teller number regno
					 if(trim($regNoT) == trim($regNo)){
						 //update student payment details
						 $payed = MakePaid($regNo,3800,3,$currSesID,1,3); 
					 }else{
						 return "#";
						// return;
					 }
				 }else{//if regNo is empty
					 //update the pay_teller_tb to carry the regno for the teller number
					 $sqlRegNo = $dbo->SqlSave($regNo);
					 $payquery = "UPDATE pay_teller_tb SET RegNo = '{$sqlRegNo}' WHERE TellerNo = '{$teller}'";
					 $payupd = $dbo->RunQuery($payquery,"hgdsgh");
					  if(is_array($payupd)){
						  //update candidate payment status
						   $payed = MakePaid($regNo,3800,3,$currSesID,1,3);
						   //echo "pay_teller_tb updated"; 
					  }
				 }
			  }else{
				  return "###";
				  //return;
			  }
		  }
		  //
		   
		  if($verifyType == "FN"){
			  //generate form number
			  $gFN = mt_rand(1000000,999999999);
			  $gFN = strtoupper(substr($surname,0,2)).$gFN;
			  $chn = $dbo->CheckDbValue(array('JambNo'=>$gFN),"{$studPre}studentinfo_tb");
			 
			  while($chn === true){
				  $gFN = mt_rand(1000000,999999999);
				  $gFN = strtoupper(substr($surname,0,2)).$gFN;
			      $chn = $dbo->CheckDbValue(array('JambNo'=>$gFN),"{$studPre}studentinfo_tb");
			  }
			$regNo = $gFN; 
			
		  }
		   
		  $query = "INSERT INTO {$studPre}studentinfo_tb(JambNo, SurName, FirstName, OtherNames,Gender, JambAgg, ProgID, Accept,StudyID,StartSes,ModeOfEntry,RegID) VALUES ('".$dbo->SqlSave($regNo)."', '".$dbo->SqlSave($surname)."', '".$dbo->SqlSave($firstname)."','".$dbo->SqlSave($othername)."','{$gender}','".$dbo->SqlSave($jamb)."',{$ProgID},{$payed},{$study},{$startSes},{$moe},{$RegID})";
		/*  echo $query;
         exit; 
		  */
		  //insert student
		  $insert = $dbo->RunQuery($query,"hgdsgh");
		  if(is_array($insert)){
			 $DB = GetBasicInfo($regNo,"",$studPre,-$RegID); //negative regid search with strict regid i.e must be equal to 
			// return $studPre;
			if(is_array($DB)){ 
			return VerifyR($DB, $regNo, $payID,$verifyType,$studPre,$RegID);
			}else{
				return "#";
			}
		  }else{
			return "#*";  
		  }
	  }
  }
	
}

//function to make student paid
function MakePaid($RegNo,$amtPaid,$sem,$ses,$Lvl,$paytype){
	global $dbo;
	$date = date("Y-m-d");
	$qr = "INSERT INTO payhistory_tb(Amt,PayDate,Sem,Ses,Lvl,RegNo,PayID) VALUES ('".$amtPaid."','".$date."',".$sem.",".$ses.",".$Lvl.",'".$RegNo."',".$paytype.")";
	 $dd = $dbo->RunQuery($qr,"hgdsgh");
	 if(is_array($dd)){
		 return 1;
	 }else{
		 return 0;
	 }
	/* echo $qr;
	exit;*/
				    //check for acceptance or postUTME payment
					/* $putme = "";
					  if($paytype == 3){
						  $putme = "p";
					  }
				  if($paytype == 1 || $paytype == 3){
					 
					  //update the student accept field in studentent info_tb;
					  // $rst = $dbo->RunQuery("UPDATE {$putme}studentinfo_tb SET Accept = 1 WHERE RegNo = '".$RegNo."' OR JambNo = '".$RegNo."'", "a");
					   //return true;
				  }*/
	
}

//function to perform verification proper
function VerifyR($DB,$regNo,$payID,$verifyType,$pre = "p",$RegID = 1){
	global $curtitcolorind;
	global $phpf;
	global $dbo;
	$curtitcolorind = 3;
   $rtn = GroupBoxTitle_r("Candidate Details");
   
       //$pre = StudPreByPayID($payID);
	   if($verifyType == "STUDENT" || $verifyType == "NONE"){ //Entrance
		$printobj =   "PRegister";
		$putme = PUTME($RegID);
        $closed  = ($putme['Status'] == "CLOSED")?1:0;
		$regType = $putme['PayReg'];
		
	  }else{ //Bio Data
		 $printobj =   "FVerify";
		 $putme = STUDREG($RegID);
        $closed  = ($putme['Status'] == "CLOSED")?1:0; 
		$regType = $putme['PayReg'];
	  }
	  
	   //check if payment is to be made
		 if($regType != "REG"){
	  //Check candidate payment status
	  //if((int)$DB['pay'] == 0){ //if not pay
	      //use the third party/local payment checker
		  $DB['pay'] = 0;
		  $paystatus = HasPaid($regNo,$payID,1);
		  
		 // echo implode(",",$paystatus);
		  //return "hhhh";
		  //return implode(" ... ",$paystatus);
	    
		  if($paystatus[0] == 0){
			$payfunc = ($closed == 1)?"MessageBox.ShowText('REGISTRATION CLOSED','')":"MessageBox.Show('Admin/Payment/mesPayOption.php?RegNo={$regNo}&PayId={$payID}&Sem=3&pre={$pre}&lvl=1&RegID={$RegID}',null,'',null,'Payment Option')";
		  $pay =  "<a style=\"\" class=\"linkbtn errbtn\" href=\"javascript:void\" onclick=\"{$payfunc}\"><i class=\"fa fa-exclamation-triangle\"></i> #".$paystatus[6]." <strong>NOT PAID</strong> - Click to Make Payment</a>";
		  }else{
			  /*ID 	ItemNo 	TransNum 	ItemName 	ItemDescr 	Amt 	Currency 	RegNo 	Sem 	Lvl 	ItemID 	Paid 	RegDate 	Ses*/
			  $orderdet = $dbo->Select4rmdbtbFirstRw("order_tb","ItemNo","RegNo = '$regNo' and  ItemID='$payID' and Sem = 3 and Lvl = 1 ");
			  if(is_array($orderdet)){
				  $orderNo = $orderdet["ItemNo"];
				  //Pay.Printer.Preview('Payment Slip','Admin/Payment/Bank/Slip.php?ItemNo={$orderNo}',function(){_('prpayslip').StopLoadingsm();});
				  //Pay.Printer.Print('Admin/Payment/Bank/Slip.php?ItemNo={$orderNo}',function(){_('prpayslip').StopLoadingsm();});
			   $payfunc = "_('prpayslip').StartLoadingsm();Pay.PrintPay('ItemNo={$orderNo}&RegID={$RegID}',function(){_('prpayslip').StopLoadingsm();});";
			  }else{
				  $payfunc = "MessageBox.Hint('PAYMENT ORDER DETAILS NOT FOUND')";
			  }
			$pay = "<strong style=\"color:#578404;\">PAID</strong><a style=\"color:#578404;float:right\" href=\"javascript:void\" onclick=\"{$payfunc}\" title=\"Print Payment Receipt\" id=\"prpayslip\" > <i class=\"fa fa-print\" style=\"color:#333; font-size:1.5em\" > </i> </a>" ; 
			$DB['pay'] = 1; //set payment to paid
		  }
		
	  
	  /*}else{
		  $payfunc = "Pay.BankPay(null,'{$regNo}',{$payID},3,'{$pre}','1',this)";
		$pay = "<strong style=\"color:#578404;\">PAID</strong><a style=\"color:#578404;float:right\" href=\"javascript:\" onclick=\"{$payfunc}\" title=\"Print Payment Receipt\"> <img src=\"Resource/Images/printsm.png\" alt=\"Print\" /> </a>" ;
		  
	  }*/
		 }
	  
	  $regTitle = ($verifyType == "FN")?"FORM NUMBER":"REGISTRATION NUMBER";
	 
	 // $printobj = ($verifyType == "STUDENT" || $verifyType == "NONE")?"PRegister":"FVerify";
	   $DB['pay'] = ($regType != "REG")?$DB['pay']:"-1";
	  $pay .= "<input type=\"hidden\" id=\"payStatus\" name=\"payStatus\" value=\"".$DB['pay']."\" />";
	  
	  //check if registration is allowed 
	  if($regType != "PAY"){
	  $regLvl = ((int)$DB['RegLevel'] < 6)?"<span style=\"color:#CC3300\"  ><strong><i class=\"fa fa-exclamation-triangle\"></i> NOT REGISTERED</strong></span>":"<strong style=\"color:#578404;\">REGISTERED</strong><a href=\"javascript:void\" onclick=\"{$printobj}.PrintSlip('{$regNo}',null,null,'{$RegID}')\" id=\"reprSlip\" style=\"color:#578404;float:right\" title=\"Print Registration Slip\"><i class=\"fa fa-print\" style=\"color:#333; font-size:1.5em\" > </i> </a>";
	  }
	  //$regNo = $phpf->SqlSave($regNo);
	  $DB['RegLevel'] = ($regType != "PAY")?$DB['RegLevel']:"-1";
	  $regLvl .= "<input type=\"hidden\" id=\"regStatus\" name=\"regStatus\" value=\"".$DB['RegLevel']."\" /><input type=\"hidden\" id=\"closeStatus\" name=\"closeStatus\" value=\"".$closed."\" />";
	  $arrval  = array(array("[NAME]","<strong>".strtoupper($DB['Name'])."</strong><input type=\"hidden\" id=\"fName\" name=\"fName\" value=\"".$DB['Name']."\" />"),
            array("[{$regTitle}]","<strong>".strtoupper($regNo)."</strong><input type=\"hidden\" id=\"fRegNo\" name=\"fRegNo\" value=\"{$regNo}\" />"));
			$paydet = GetBy("ID",$payID,"item_tb"); //get the payment details
			$itemnm = (is_array($paydet))?"<strong>".strtoupper($paydet['ItemName'])."</strong>":"";
	  //

           $arrval[] =  array("[GENDER]",$DB['Gen']);
		   $arrval[] = array("[SCHOOL TYPE]",strtoupper($DB['StudyName']));
			$arrval[] = array("[FACULTY/SCHOOL]",strtoupper($DB['Fac']));
			$arrval[] = array("[DEPARTMENT]",strtoupper($DB['Dept']));
			$arrval[] = array("[PROGRAMME]",strtoupper($DB['Prog']));
			if($verifyType == "STUDENT"){
			if((int)$DB['StateId'] > 0){
			$arrval[] = array("[STATE]",GetState($DB['StateId']));
			}
			if(trim($DB['lga']) != ""){
			$arrval[] = array("[LOCAL GOVT. AREA]",strtoupper(GetLGA($DB['lga'])));
			}
			}
			if($verifyType != "FN" && $verifyType != "RN"){
				if((int)$DB['jamb'] > 0){
			$arrval[] = array("[JAMB AGGREGATE]",$DB['jamb']);
				}
			}
			
			if($verifyType == "PU"){
				 $prst = GetPUTMEResult($regNo,$RegID);
		  if(is_array($prst)){
			  $aggr = (int)@$prst['Score1'] + (int)@$prst['Score2'] + (int)@$prst['Score3'] + (int)@$prst['Score4'];
			  $arrval[] = array("[PUTME AGGREGATE]",$aggr);
		  }
				
			}
			
	 // }
	  if($regType != "PAY"){
	$arrval[] = array("[REGISTRATION STATUS]",$regLvl);
	if($printobj == "FVerify"){ //determine if not putme registration
		/*$scr = CheckScreen($regNo,$putme['StudInfoPref'],$RegID);
			if($scr !== false){
				$screen = $putme['Screening'];
				if($screen == 'TRUE'){
				$scrr = $scr === NULL?"<strong class=\"errorColor\">FAILED</strong><input type=\"hidden\" id=\"scrnval\" name=\"scrnval\" value=\"0\" />":"<strong class=\"successColor\">PASSED</strong><input type=\"hidden\" id=\"scrnval\" name=\"scrnval\" value=\"1\" />";
				$arrval[] = array("[SCREENING]",$scrr);
				}
			}*/
	}
	  }else{
		echo $regLvl;  
	  }
	  if($regType != "REG"){
		    if($itemnm != ""){
				$arrval[] = array("[PAYMENT TYPE]",$itemnm);
			}
			$arrval[] = array("[PAYMENT STATUS]",$pay);
	  }else{
		  echo $pay; 
	  }
	$rtn .= Table_r($arrval,"","100%*550px");	
	return $rtn;
	
}

function FormAC(){
	$charset = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	$ac = "";
	$s=1;
	while($s < 9){
	  $rand = mt_rand(0,25);
	  $ac .= $charset[$rand];
	$s++;	
	}
	return $ac;
}

//function to create list of faculties for Filter combobox
function GetFacFilter(){
	global $dbo;
	$facarr = array(strtoupper("0#Faculty/School"));
	$putmerst = $dbo->RunQuery("select * from fac_tb");
				//$pdt = "";
				if(is_array($putmerst)){
					if($putmerst[1] > 0){
						while($pdt = $putmerst[0]->fetch_array()){
							$facarr[] = $pdt['FacID']."#".strtoupper($pdt['FacName']);
						}
						//$state = $pdt[1];
						//$dateputmer = $dateputme->format("d/m/y | h:m A");
					}
				}
				return $facarr;
}

//function to get the studentinfo_tb prefix letter by payment type (ID)
function StudPreByPayID($payID,$RegID = 1){
		global $dbo;
		$payID = (int)$payID;
		$ratt = $dbo->RunQuery("select ControlTable from item_tb where ID = " .$payID);
		if(is_array($ratt)){
			if($ratt[1] > 0){
				$pre = $ratt[0]->fetch_array();
				$tb = $pre[0];
				$ratt2 = $dbo->RunQuery("select StudInfoPref from {$tb} where ID=$RegID LIMIT 1");
				///return $ratt2;
				$pre2 = $ratt2[0]->fetch_array();
				return @$pre2[0];
			}
		}
		return "";
}

//function to get departmetal putme passmark
function PUTMEPassMark($ProgID){
	global $dbo;
	$ProgID = (int)$ProgID;
		$ratt = $dbo->RunQuery("select putmeagr from programme_tb where ProgID = " .$ProgID);
		if(is_array($ratt)){
			if($ratt[1] > 0){
				$pre = $ratt[0]->fetch_array();
				return (int)$pre[0];
			}
		}
}

//function to get record by id
function GetBy($Key,$value,$table){
	global $dbo;
	$pre = array();
	$value = $dbo->SqlSave($value);
	$q = "select * from {$table} where {$Key} = '" .$value . "'";
		$ratt = $dbo->RunQuery($q);
		if(is_array($ratt)){
			if($ratt[1] > 0){
				$pre = $ratt[0]->fetch_array();
				return $pre;
			}
		}
		return $pre;
}



//function to get course settings details
function COURSE(){
	global $dbo;
	$rst2 = $dbo->RunQuery("select * from coursecontrol_tb");
	//$subcomb = "";
	if(is_array($rst2)){
		if($rst2[1] > 0){
			$subj = $rst2[0]->fetch_array();
			return $subj;
		}
	}
	return "";
}

//function to get school type details by ID
function SchoolType($ID){
	global $dbo;
	$ID = (int)$ID;
	$rst2 = $dbo->RunQuery("select * from schooltype_tb where ID = {$ID}");
	//$subcomb = "";
	if(is_array($rst2)){
		if($rst2[1] > 0){
			$subj = $rst2[0]->fetch_array();
			return $subj;
		}
	}
	return "";
}

//function to load payment analysis into table
function PayAnalysis($payID,$lvl,$paypol,$RegNo,$loadlvl = 0,$sempart = 3,$RegID = 1){
	global $dbo;
	global $curtitcolorind;
	$paydet = GetPaymentItem($payID); //get the payment details based on payID
	if($paydet != NULL){//if payment details is found
	//get all student info
	$StudInfo = GetBasicInfo($RegNo,"all","",$RegID);
	   $loadlvl = $loadlvl > 0 ? $loadlvl : $lvl; //set the level to be used to load analysis
		$anal = PaymentBreakDown($paydet['PayBrkDn'],$loadlvl,$paypol,$StudInfo,$sempart);
	
		if(is_array($anal)){
			$brdwn = $anal[2];
			$tot = $anal[1];
			$curtitcolorind = 2;
			GroupBoxTitle("Payment Analysis");
	  //PayAnalysis(2,1,3);
	        $itemarr = explode("***",$brdwn);
			if(count($itemarr) > 0){
				$arrval[] = array(array("class=header"),array("ITEM","AMOUNT"));
				for($sd = 0; $sd < count($itemarr); $sd++){
					$item = $itemarr[$sd];
					$nameAmt = explode("~",$item);
					$name = strtoupper($nameAmt[0]);
					$amt = $nameAmt[1];
					 $arrval[] =  array("[{$name}]","{$amt}");
				}
			
	//Table($arrval,"","100%*370px");	
	TableNew($arrval,"style=width:100%,autoheightdiff=257px");
	$arrval2[] = array("<strong>[TOTAL]</strong>","<strong>{$tot}</strong>");
	Table($arrval2,"","100%*50px");
	ButtonImg("money","Pay","id=paybtn,title=Pay Now,onclick=".SafeData("MessageBox.Show('Admin/Payment/mesPayOption.php?RegNo={$RegNo}&PayId={$payID}&Sem={$paypol}&pre=&lvl={$lvl}&loadlvl={$loadlvl}&sempart={$sempart}&RegID={$RegID}',null,'',null,'Payment Option')").",style=margin-top:10px");//	
			}else{
				echo "##"; //no payment details found
			}
	  /* $arrval[] =  array("[TUITION FEE]","35,000");
			$arrval[] = array("[DEVELOPMENTAL FEE]","10,000");
			$arrval[] = array("[ID CARD]","2000");
			$arrval[] = array("[EXAMINATION]","3000");
	        $arrval[] = array("[TRANSACTION CHARGE]","500");*/
			
		}else{
			//echo "###"; //invalid payment analysis
			echo $anal;
		}
	}else{
		echo "####"; //server error canot get the payment item details from database
	}
}



//function to load courses for registration
function LoadCoursesReg($regNo, $lvl, $sem,$payID){
	/*echo "aaa";
	return;*/
	global $dbo;
	global $curtitcolorind;
	 $schpaydet = SchoolPayDet();
	$schpayShare = !is_array($schpaydet)?'HALF':$schpaydet['PartPayShare'];
	$paid = HasPaid($regNo,$payID,$lvl,$sem,0); //sempart is 0, meaning if student has paid anything for the sem
	//RegNo,payID,Paypol,Lvl
	if($paid[0] == 0){
		//Text("style=color:red;font-size:1.4em,name=courselnk","PAYMENT NOT MADE");
		$curtitcolorind = 1;
	GroupBoxTitle("payment not made");
		//$paypols = $paid[1];
		
		echo "<div name=\"courselnk\">";
		if((int)$sem == 2){
			//check if 1st sem paid
			$paidfirst = HasPaid($regNo,$payID,$lvl,1,0);
			if($paidfirst[0] == 1){//if payed first payment
		//echo "<li>";
		        //(1,$paypol,$payID,$lvl,$TopSem,"",0,"",$TopSemPart)
				$TopSem = $paidfirst[4];
				$TopSemPart = (int)$paidfirst[8];
               
				if($schpayShare == 'HALF'){
				InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,2\,$lvl),text=<i class\=\"fa fa-star-half-o\"></i> SECOND PAYMENT");
				}else{//else QUATER
					if($TopSemPart < 2){ //if only first part is paid, display to complete part first
						InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,'1_2'\,$lvl),text=<i class\=\"fa fa-star\"></i> FIRST PAYMENT(COMPLETE)");
					}else{ //if complete first payment, display second payments options
						InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,'2_1'\,$lvl),text=<i class\=\"fa fa-star-half-o\"></i> SECOND PAYMENT(PART),error=true,style=margin-right:20px");
						InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,'2_3'\,$lvl),text=<i class\=\"fa fa-star\"></i> SECOND PAYMENT(FULL)");
					}
				}
         			
		//HLink("javascript:Course.LoadPay('{$regNo}',$payID,$sem,$lvl)","Complete your Payment","style=font-size:1.1em;text-decoration:;color:inherit");
		//echo "</li>";
			}else{ //make full payment
				//echo "<li>";
				if($schpayShare != 'HALF'){//quater payment devision
					
				}
				InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,3\,$lvl),text=<i class\=\"fa fa-star\"></i> FULL PAYMENT");
		//HLink("javascript:Course.LoadPay('{$regNo}',$payID,3,$lvl)","Make Full Payment","style=font-size:1.1em;text-decoration:;color:inherit");
		//echo "</li>";
			}
		}else{ //Sem is 1
			 
             
			if($schpayShare == 'HALF'){
				InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,1\,$lvl),text=<i class\=\"fa fa-star-half-o\"></i> FIRST PAYMENT,error=true,style=margin-right:20px");
				InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,3\,$lvl),text=<i class\=\"fa fa-star\"></i> FULL PAYMENT");
		
				
			}else{
				//check if student has complete second payment 100 level, if level is more than 100 ***********
				$prevlvl = (int)$lvl - 1;
			$paidprevlev = array(0);
			$prevlvlseen = false;
					if($prevlvl > 0){
						$paidprevlev = HasPaid($regNo,$payID,$prevlvl,2,0);
						$prevlvlseen = true;
					}
				if(!$prevlvlseen || ($paidprevlev[0] == 1 && (int)$paidprevlev[8] > 2)){ //if no prev level found or prevpayment made
					InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,'1_1'\,$lvl),text=<i class\=\"fa fa-star-half-o\"></i> FIRST PAYMENT(PART),error=true,style=margin-bottom:10px");
					InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,'1_3'\,$lvl),text=<i class\=\"fa fa-star-half-o\"></i> FIRST PAYMENT(FULL),style=margin-left:20px;margin-bottom:10px");
					InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,3\,$lvl),text=<i class\=\"fa fa-star\"></i> FULL PAYMENT,style=margin-bottom:10px");
				}elseif($prevlvlseen && ($paidprevlev[0] == 1 && (int)$paidprevlev[8] == 1)){
					InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,'2_2'\,$prevlvl),text=<i class\=\"fa fa-star-half-o\"></i> SECOND PAYMENT(COMPLETE),error=true");
				}else{
					InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,'1_1'\,$lvl),text=<i class\=\"fa fa-star-half-o\"></i> FIRST PAYMENT(PART),error=true,style=margin-bottom:10px");
					InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,'1_3'\,$lvl),text=<i class\=\"fa fa-star-half-o\"></i> FIRST PAYMENT(FULL),style=margin-left:20px;margin-bottom:10px");
					InlineBtn("onclick=Course.LoadPay('{$regNo}'\,$payID\,3\,$lvl),text=<i class\=\"fa fa-star\"></i> FULL PAYMENT,style=margin-bottom:10px");
				}
              
			
			}
		//HLink("javascript:Course.LoadPay('{$regNo}',$payID,1,$lvl)","Make Part Payment","style=font-size:1.1em;text-decoration:;color:inherit");
		//echo "</li>";-half
		}
		echo "</div>";
		Box("style=display:none;color:#333;width:auto;height:auto;font-size:1.1em,id=cpayloading,class=");
		Logo("cog fa-spin");
		echo " &nbsp;Loading Payment Analysis. Please wait";
	  _Box();
		//echo '<i  style="position:;z-index:1;margin-left:10px;display:none" id="cpayloading" class="fa fa-cog fa-spin" ></i>';
		return;
	}
	
	$yearofSt = StudYearOfStudy($regNo,"");
	$clvl = (($lvl - $yearofSt) > 0)?$yearofSt:$lvl;
	$studinfo = GetBasicInfo($regNo,"stud");
	$progID = (int)$studinfo["ProgID"];

	$scourses = GetStudCourses($regNo, $clvl, $sem,false,$progID);
	
	if(is_array($scourses)){
		//if($scourses[1] > 0){ //semester courses exist
	$curtitcolorind = 1;
	
	
	$presel = "";
	$sqlregNo = $dbo->SqlSave($regNo);
	$lvl = (int)$lvl;
	$sem = (int)$sem;
	$curcourses = "";
	$OutsPreSel = ""; //the preselected string for outstanding courses
	$ReptPreSel = ""; //the preselected string for repeat courses
	$OutstCourses = null; //the Outstanding courses database rows if exist
	$RepeatCourses = null; //the repeat courses database rows if exist
	$genpresel = "";
	  // $check = $dbo->RunQuery("select CoursesID from coursereg_tb where RegNo = '{$sqlregNo}' and Lvl = {$lvl} and Sem = {$sem}");
	   $check = $dbo->SelectFirstRow("coursereg_tb","CoursesID","RegNo = '{$sqlregNo}' and Lvl = {$lvl} and Sem = {$sem}");
	   
	   if(is_array($check)){
		   $genpresel = $check["CoursesID"];
		   
		   $genpresel = ResolveRegCourses($genpresel);
		  // echo $genpresel;
		   /*if($check[1] > 0){
			  $presel =  $check[0]->fetch_array();
			  $presel = $presel["CoursesID"];
			  $presel = ResolveRegCourses($presel);
		   }*/
	   }
	   $totchdb = -1;
	   $probyear = false; //if student in his probation year
		   //get the immediate prev result  $RegNo,$CurLvl,$CurSem
           $imdprevrst = GetPrevResult($regNo,$lvl,$sem);
		   if($lvl > 1){
			   $probcgpa = -1;
			if((int)$sem == 1){ //if sem is 1 i.e immdiate result = lvl - 1, sem = 2
				if(is_array($imdprevrst)){
				$probcgpa = (int)$imdprevrst['CCH'] > 0?number_format((int)$imdprevrst['CGP']/(int)$imdprevrst['CCH']):$probcgpa;
				}
			}else{
				//get the last year cgpa
				$imdprevrstprob = GetPrevResult($regNo,$lvl,1);
				if(is_array($imdprevrstprob)){
				$probcgpa = (int)$imdprevrstprob['CCH'] > 0?number_format((int)$imdprevrstprob['CGP']/(int)$imdprevrstprob['CCH']):$probcgpa;
				}
			}
			$grdstr = $dbo -> SelectFirstRow("resultinfo_tb","","ID = (select GrdStrucID from school_tb limit 1)");
            $problimit = (float)$grdstr['ProbationLimit'];
			$probTCH = (int)$grdstr['ProbationTCH'];
			if($probcgpa > -1 && $probcgpa < $problimit){//if in prob year
               $totchdb = $probTCH;
			   $probyear = true;
			}
		   }
		   if(is_array($imdprevrst)){ //if prev result exist
             $OutSt = $imdprevrst['Outst'];
			 $OutStArr = explode("+",$OutSt);
			 $OutSt = count($OutStArr) > 1?$OutStArr[1]:$OutStArr[0];
			 $Rept = $imdprevrst['Rept'];
			 $ReptArr = explode("+",$Rept);
			 $Rept = count($ReptArr) > 1?$ReptArr[1]:$ReptArr[0];
             //load oustanding courses 
			 if(trim($OutSt) != ""){
				$foutsStr = trim($OutSt,":");
				$OutsPreSel = str_replace("::","~",$foutsStr);
				$presel = $OutsPreSel;
				$queryOutst = str_replace("::"," OR CourseID=",$foutsStr);
				$OutstCRst = $dbo->Select("course_tb","","(CourseID=".$queryOutst.") AND Sem=".$sem);
				if(is_array($OutstCRst)){
					if($OutstCRst[1] > 0){
						$OutstCourses = $OutstCRst[0];
					}
				}
			 }
			 //load repeat courses 
             if(trim($Rept) != ""){
				$freptStr = trim($Rept,":");
				
				$ReptPreSel = str_replace("::","~",$freptStr);
				$presel .= trim($OutsPreSel) == ""?$ReptPreSel:"~".$ReptPreSel;
				$queryRept = str_replace("::"," OR CourseID=",$freptStr);
				$ReptCRst = $dbo->Select("course_tb","","(CourseID=".$queryRept.") AND Sem=".$sem);
				if(is_array($ReptCRst)){
					if($ReptCRst[1] > 0){
						$RepeatCourses = $ReptCRst[0];
					}
				}
			 }
			 
		   }
	   $presel .= "~".$genpresel;
	   $preselArr = explode("~",$presel);
	   $preselArr = array_unique($preselArr);
	   $presel = trim(implode("~",$preselArr),"~");
	  /// echo $genpresel;

	  //check if courses not found
      if($scourses[1] < 1 && is_null($OutstCourses) &&  is_null($RepeatCourses)){
        exit("###");
	  }
	  $ortherinfo = $probyear?" - Probation Year":"";
	  GroupBoxTitle("Courses".$ortherinfo);
	   //check if student already have result
		$hasRst = false;
		$hasRstOBJ = $dbo->SelectFirstRow("result_tb","Rst","Lvl=$lvl AND Sem=$sem AND RegNo='".$dbo->SqlSafe($regNo)."'");
		if(is_array($hasRstOBJ)){
			if(trim($hasRstOBJ['Rst']) != ""){
				$hasRst = true;
			}
			
		}
		$disable = $hasRst?"true":"false";
		$loaded = array(); //array holding the displayed courses whill be used to eleminate duplicate courses
		$loadedpresel = $genpresel; //hold all real selected courses
		$totChCnt = 0; //calculate total Outst and Repeat loaded at a particular instance
		$AllCH = array(); //hold all courses CHs
		if($totchdb < 0){
		$totchdb = GetBy("ProgID",$progID,"programme_tb");
		 $totchdb = $totchdb["TotalCH"];
		}
		//echo $totchdb;
	  $rtnregc = OpenCheckList_r("name=courselist,id=courselist,style=width:495px;font-weight:,autoheightdiff=257px", $presel,"Course.SelectCourse","Course.UnSelectCourse");
	   $rtnregc .= CheckListHeader_r("<div style=\"width:94px\">CODE</div><div style=\"width:355px;text-transform:uppercase\">TITLE</div><div style=\"width:45px\" id=\"{$id}ch\">CH</div>","");
		 $first = true;
		 $outStPreSelReal = "";
		 //display all outstanding courses
		 if(!is_null($OutstCourses)){
			 $rtnregc .= CheckListHeader_r("<div style=\"width:495px;text-align:center;font-weight:bold\"> UN-REGISTERED COURSES </div>","");
			 while($outstC = $OutstCourses->fetch_array()){
				 
				 $cls = ($first)?"first":"";
			    $id = $outstC['CourseID'];
				if(in_array($id,$loaded)){ //if already loaded skip
					continue;
				}
			    $courseCode = $outstC['CourseCode'];
			    $cTitle = $outstC['Title'];//Title
			    $CH = $outstC['CH'];
				if(((int)$CH + $totChCnt) > (int)$totchdb){ //if acumulated $CH is greater than total allowable CH
					break;
				}
				 $rtnregc .= CheckListItem_r("<div style=\"width:94px\">{$courseCode}</div><div style=\"width:355px;text-transform:uppercase\">{$cTitle}</div><div style=\"width:45px\" id=\"{$id}ch\">{$CH}</div>","name=courselist,id={$id},class={$cls},disable=true");
				 $first = false;
				 $loaded[] = $id;
				 $AllCH[$id] = $CH;
				 $outStPreSelReal .= $id."~";
				 $totChCnt += (int)$CH;
			 }
			 $outStPreSelReal = rtrim($outStPreSelReal,"~");
		 }

$reptPreSelReal = "";
//display all repeat courses 
		 if(!is_null($RepeatCourses)){
			 $rtnregc .= CheckListHeader_r("<div style=\"width:495px;text-align:center;font-weight:bold\"> REPEAT COURSES </div>","");
			 while($reptC = $RepeatCourses->fetch_array()){
				 $cls = ($first)?"first":"";
			    $id = $reptC['CourseID'];
				if(in_array($id,$loaded)){ //if already loaded skip
					continue;
				}
			    $courseCode = $reptC['CourseCode'];
			    $cTitle = $reptC['Title'];//Title
			    $CH = $reptC['CH'];
				if(((int)$CH + $totChCnt) > (int)$totchdb){ //if acumulated $CH is greater than total allowable CH
					break;
				}
				 $rtnregc .= CheckListItem_r("<div style=\"width:94px\">{$courseCode}</div><div style=\"width:355px;text-transform:uppercase\">{$cTitle}</div><div style=\"width:45px\" id=\"{$id}ch\">{$CH}</div>","name=courselist,id={$id},class={$cls},disable=true");
				 $first = false;
				 $loaded[] = $id;
				 $AllCH[$id] = $CH;
				 $reptPreSelReal .= $id."~";
				 $totChCnt += (int)$CH;
			 }
			 $reptPreSelReal = rtrim($reptPreSelReal,"~");
		 }
		// $fgg = @$_POST['ss'];
		if($scourses[1] > 0 && $probyear == false){
		if(count($loaded) > 0){
		$rtnregc .= CheckListHeader_r("<div style=\"width:495px;text-align:center;font-weight:bold\"> SEMESTER COURSES </div>","");
		}
		 while($curse = $scourses[0]->fetch_array()){
			 $cls = ($first)?"first":"";
			 $id = $curse['CourseID'];
			 if(in_array($id,$loaded)){ //if already loaded skip
					continue;
				}
			 $courseCode = $curse['CourseCode'];
			 $cTitle = $curse['Title'];//Title
			 $CH = $curse['CH'];
		  $rtnregc .= CheckListItem_r("<div style=\"width:94px\">{$courseCode}</div><div style=\"width:355px;text-transform:uppercase\">{$cTitle}</div><div style=\"width:45px\" id=\"{$id}ch\">{$CH}</div>","name=courselist,id={$id},class={$cls},disable=$disable");
		  $first = false;
		  $curcourses .= $id."~";
		  $loaded[] = $id;
		  $AllCH[$id] = $CH;
		 }
		}
		 $curcourses = rtrim($curcourses,"~");
		 $courseCntr = $dbo->SelectFirstRow("coursecontrol_tb");
		 $lowerlvl = is_array($courseCntr)?$courseCntr['LowerLevel']:"TRUE";
		 if($lowerlvl == "TRUE" && $probyear == false){ //if lower level loading is allowed and student not in probation year
		 $lcourses = GetStudCourses($regNo, $lvl, $sem, true,$progID);
		 if(is_array($lcourses)){
			 if($lcourses[1] > 0){
		          $rtnregc .= CheckListHeader_r("<div style=\"width:495px;text-align:center;font-weight:bold\"> LOWER LEVEL COURSES </div>","");
				   while($lcurse = $lcourses[0]->fetch_array()){
			         $cls = ($first)?"first":"";
			         $id = $lcurse['CourseID'];
					 if(in_array($id,$loaded)){ //if already loaded skip
					continue;
				}
			         $courseCode = $lcurse['CourseCode'];
			         $cTitle = $lcurse['Title'];//Title
			          $CH = $lcurse['CH'];
		  $rtnregc .= CheckListItem_r("<div style=\"width:94px\">{$courseCode}</div><div style=\"width:355px;text-transform:uppercase\">{$cTitle}</div><div style=\"width:45px\" id=\"{$id}ch\">{$CH}</div>","name=courselist,id={$id},class={$cls},disable=$disable");
		  $first = false;
		  $loaded[] = $id;
		  $AllCH[$id] = $CH;
		 }
			 }
		 }
		 }
		//eee
	/*else{
		CheckListItem("<div style=\"width:99px\">[000]</div><div style=\"width:292px;text-transform:uppercase\">jhjj</div><div style=\"width:99px\">[10 Crd Unt]</div>","name=courselist,id=1,class=first");
	   //echo ;	
	}*/
	   $realsel = trim($outStPreSelReal."~".$reptPreSelReal."~".$genpresel,"~");
       $realSelArr = array_unique(explode("~",$realsel));
	   $realsel = implode("~",$realSelArr);
	   $realsel = trim($realsel) == ""?"#":$realsel;
		$rtnregc .= CloseCheckList_r($realsel);
		echo $rtnregc;
		$totch = 0;
		
		if(trim($realsel) != ""){
			$selarr = explode("~",$realsel);
			$tot = count($selarr);
			$totch = 0;
			foreach($selarr as $sel){
				$CH = $AllCH[$sel];
				$totch += (int)$CH;
			}
		}
		Hidden("name=totCH,id=totCH,value=".$totch);
		Hidden("id=curcourses,value=".$curcourses);
	     TextBox("name=selcourse,id=selcourse,value=Total Course Selected - {$tot}         Total Credit Unit - {$totch},disabled=disabled,style=font-weight:bolder,width=495px,logo=tag");
		 
		 echo '<input type="hidden" id="totavCH" value="'.$totchdb.'" />';
		  //generate RegNo 
		  $autogendata = AutoGenRegNo($regNo);
		  if(is_array($autogendata)){
             list($newReg,$passpn) = $autogendata;
		  }else{
			list($newReg,$passpn) = array($autogendata,"");
		  }
		
		Hidden("name=newreg,id=newreg,value=".$newReg);
		Hidden("name=passpreg,id=passpreg,value=".$passpn);
		if($newReg != "#" && $newReg != "##" && $newReg != "###" && $newReg != "####" && $newReg != "#####"){
			//if generated
          $regNo = $newReg;
		}
		
		if(!$hasRst){ //if no result
		 if(trim($genpresel) == ""){ //if no registration found
		 ButtonImg("list-alt","Register","id=regcoursebtn,title=Register Selected Courses,onclick=Course.Register(this\,'{$regNo}'\, $lvl\, $sem)");
		 }else{
		 ButtonImg("list-alt","Update","id=regcoursebtn,title=Update Registered Courses,onclick=Course.Register(this\,'{$regNo}'\, $lvl\, $sem)");         ButtonImg("print","Print","id=regcourseprintbtn,title=Print Course Form,style=margin-left:20px,onclick=Course.PrintSlip('{$regNo}'\,{$lvl}\,{$sem})");
		 }
		}else{ //if has result allow print only
			 ButtonImg("print","Print","id=regcourseprintbtn,title=Print Course Form,style=margin-left:0px,onclick=Course.PrintSlip('{$regNo}'\,{$lvl}\,{$sem})");
		}
		/*}else{
			echo "###";//no course found
		}*/
	}else{
		echo "##";
	}
	
}

//function to return the credit unit of the supplied course ID
function GetCH($courseID){
	global $dbo;
	$courseID = (int)$courseID;
	$check = $dbo->RunQuery("select CH from course_tb where CourseID = {$courseID}");
	   if(is_array($check)){
		   if($check[1] > 0){
			  $presel =  $check[0]->fetch_array();
			  $presel = $presel["CH"];
			  return $presel;
		   }
	   }
	   return "";
}

//function to resolve the older partern of storing registered course into database to the new format
function ResolveRegCourses($regcourse){
	// echo $regcourse;
	$regcoursearr = explode("||",$regcourse);
	$courseStr = "";
	if(count($regcoursearr) > 1){ //check if former patern
		for($d=0;$d<count($regcoursearr);$d++){ //loop through and get only the Course IDs
			$course = $regcoursearr[$d];
			$courseID = (int)$course;
			$courseStr .= $courseID ."~"; //form the new type course reg string
		}
	}else{ //if format not realy old
		if(count($regcoursearr) == 1){ //if only one string formed
		 $rccc = explode("~~",$regcourse); //check if it is old but its only one course registered by student
		 if(count($rccc) > 1){
			 $courseID = (int)$regcourse;
			 $courseStr .= $courseID ."~";
		 }else{ //if not old patern
			 //check the string if it is new pertern
			 $rccc2 = explode("~",$regcourse); 
			 //i.e it is in new version/perthern
			
			 if(count($rccc2) > 1){  
				 $courseStr = $regcourse;
			 }else{
				$courseStr = (int)$regcourse; 
			 }
		 }
		}
	}
	$courseStr = rtrim($courseStr,"~");
	return $courseStr;
}

//function to get level name based on the level id
function LevelName($lvl, $StudyID = 5){
	global $dbo;
	$lvl = (int)$lvl;
	$StudyID = (int)$StudyID;
  $rst = $dbo -> RunQuery("select Name from schoollevel_tb where SchoolTypeID = (select Type from school_tb limit 1) and Level = {$lvl} and StudyID = {$StudyID}");	
  if(is_array($rst)){
	  if($rst[1] > 0){
		  $rstval = $rst[0]->fetch_array();
		  return $rstval[0];
	  }
  }
  return $lvl;
	
}

//function to get cuorse details by supplying the courseID
function CourseDetails($courseID){
	global $dbo;
	global $phpf;
	$courseID = $dbo->SqlSave($courseID);
  $rst = $dbo -> RunQuery("select * from course_tb where CourseID = {$courseID}");	
  if(is_array($rst)){
	  if($rst[1] > 0){
		  $rstval = $rst[0]->fetch_array();
		  return $rstval;
	  }
  }
  return "";
	
}

// function to resolve the old student passprot path
function ResolvePassport($path){
	
	$str = str_replace("StudPassP","../epconfig/UserImages/Student",$path);
	if(strpos($path,"epconfig") === false){
		$str = str_replace("UserImages","../epconfig/UserImages",$str);
	}
	return $str;
}

//function to get paymnet type details (information) using the id
function PaymnetInfo($payID){
	global $dbo;
	$payID = (int)$payID;
	$rst = $dbo -> RunQuery("select * from item_tb where ID = {$payID}");
	 if(is_array($rst)){
	  if($rst[1] > 0){
		  $rstval = $rst[0]->fetch_array();
		  $cntrTb =  $rstval['ControlTable'];
		  $rst2 = $dbo -> RunQuery("select * from {$cntrTb}");
		   if(is_array($rst2)){
	  		if($rst2[1] > 0){
		  		$rstval2 = $rst2[0]->fetch_array();
				return $rstval2;
			}
		   }
	  }
  }
  return "";
	
}

//function to Get the admission Status
function AdmissionStatus($RegNo,$RegID = 1){
 global $dbo;
 $str = "";
 	$rst = $dbo -> RunQuery("select * from studentbank_tb ORDER BY ID");
	 if(is_array($rst)){
	  if($rst[1] > 0){
		 //$rw = mysql_fetch_array($rst[0]);GetBasicInfo
		 //move through all student bank moving from the first which nust be studentinfo
		while($sbrw = $rst[0]->fetch_array()){
			$studpref = $sbrw["StudInfoPref"];
			$det = GetBasicInfo($RegNo,"",$studpref,0);
			if(is_array($det)){
				 $str .= GroupBoxTitle_r("Adimission Details");
		 $arrval[] =  array("[NAME]","<strong>".strtoupper($det['Name'])."</strong>");
			$arrval[] = array("[REGISTRATION NUMBER]","<strong>".strtoupper($RegNo)."</strong>");
		   $arrval[] =  array("[GENDER]",strtoupper($det['Gen']));
			$arrval[] = array("[FACULTY/SCHOOL]",strtoupper($det['Fac']));
			$arrval[] = array("[DEPARTMENT]",strtoupper($det['Dept']));
			$arrval[] = array("[PROGRAMME]",strtoupper($det['Prog']));
			
			$form = STUDREG();
			//$RegIDsc = (trim($studpref) == "")?1:$RegID; // if user admited change RegID to one general for main student in studentinfo_tb
			if(is_array($form) && $form['Screening'] == "TRUE"){
				$scr = CheckScreen($RegNo,$studpref,$RegID);
				//echo $scr;
				if($scr !== false){
					$scrr = $scr === NULL?"<strong class=\"errorColor\">FAILED</strong>":"<strong class=\"successColor\">PASSED</strong>";
					$arrval[] = array("[SCREENING]",$scrr);
				}
			}
			//if found in main studentinfo_tb, meaning is admitted else, though register entrance but not registered
			$status = (trim($studpref) == "")?"<strong class=\"successColor\">ADMITTED</strong>":"<strong class=\"errorColor\">NOT YET ADMITTED</strong>";
			$arrval[] = array("[ADMISSION STATUS]",$status);
			$str .= Table_r($arrval,"","100%*550px");	
			if(trim($studpref) == ""){
			  $str .= Text_r("","Click the <span class=\"bold\">Bio Data</span> menu to continue Registration");
			}
			return $str;
			}
		}
		
	  }else{
		$str = "##"; //no student data bank found  
	  }
	  
	 }else{
		$str = "#@"; //error loading student data bank 
	 }
	 
	 return $str;
	
}

//function to get grade
function GetGrade($score, $gradstr = "", $grades = array()){
		global $dbo;
		if($gradstr == ""){ //if grade string not send get from database
		$rst = $dbo -> RunQuery("select * from resultinfo_tb where ID = (select GrdStrucID from school_tb limit 1)");
			if(is_array($rst)){
				if($rst[1] > 0){
					$grad = $rst[0]->fetch_array();
					$gradstr = @$grad['Grading'];
				}
			}
		}
		//if grading structure processing nedded (all grades in datastring format)
		if($score < 0){
          if(count($grades) == 0){
			  $grades = GetGradeDetAll();
		  }
		  $processgrdstr = "";
		  $indgrads = explode("&",$gradstr);
				if(count($indgrads) > 0){
                    for($s=0; $s < count($indgrads); $s++){
						$indgrad = $indgrads[$s];
						if(trim($indgrad) != ""){
							//break to get score and equivalent grade
							$scoregrd = explode("=",$indgrad);
							if(count($scoregrd) == 2){
                             $val = trim($scoregrd[0]);
							 $grd = trim($scoregrd[1]);
                             $grddet = $grades[$grd];
							 $processgrdstr .= $val ."=".rawurlencode($grddet["Grade"]) . "&";
							}

						}

					}
					$processgrdstr = rtrim($processgrdstr,"&");
				}
            return $processgrdstr == ""?$gradstr:$processgrdstr;
		}
			if(trim($gradstr) != ""){
				//break into individual grades
				$indgrads = explode("&",$gradstr);
				if(count($indgrads) > 0){
					for($s=0; $s < count($indgrads); $s++){
						$indgrad = $indgrads[$s];
						if(trim($indgrad) != ""){
							//break to get score and equivalent grade
							$scoregrd = explode("=",$indgrad);
							if(count($scoregrd) == 2){
								$val = trim($scoregrd[0]);
								$grd = trim($scoregrd[1]);
								
								//get gradepoint
								/*$grdpntarr = explode("|",$grd);
								$point = 0;
								if(count($grdpntarr) == 2){
									$grd = $grdpntarr[0];
									$point = (float)$grdpntarr[1];
								}*/
								//check for < and >
								//get the first char
								$fcahr = substr($val, 0, 1);
								if($fcahr == "<"){//if lessthan
									$val = substr($val, 1);
									//check if score certisfy cond
									if($score < (float)$val){
										return isset($grades[$grd])?$grades[$grd]:GetGradeDet($grd);
									}
								}else if($fcahr == ">"){
									$val = substr($val, 1);
									if($score > (float)$val){
										return isset($grades[$grd])?$grades[$grd]:GetGradeDet($grd);
									}
								}else{ //if not < or >
									//check if is range
									$rangarr = explode("-",$val);
									if(count($rangarr == 2)){//if range
										$lval = (float)$rangarr[0];
										$mval = (float)$rangarr[1];
										if($score >= $lval && $score <= $mval){
											return isset($grades[$grd])?$grades[$grd]:GetGradeDet($grd);
										}
									}else{//if direct value
										if($score == (float)$val){
											return isset($grades[$grd])?$grades[$grd]:GetGradeDet($grd);
										}
									}
								}
							}
						}
						
					}
				}
			}
		//}
	//}
	return "0";
	
}
//fetch all grade structure from school grade to be use in GetGrade function Preload
function GetGradeDetAll(){
	global $dbo;
   $rtn = array();
	$rst = $dbo -> RunQuery("select * from schgrade_tb");
	
	if(is_array($rst)){
      if($rst[1] > 0){
        while($grds = $rst[0]->fetch_array()){
             $rtn[$grds[0]] = $grds;
		}
	  }
	}
	return $rtn;
}
//function to get gradedet from schgrade table
function GetGradeDet($GradeID){
	global $dbo;
	$rtn = array();
	$rst = $dbo -> RunQuery("select * from schgrade_tb where ID = {$GradeID} limit 1");
	if(is_array($rst)){
      if($rst[1] > 0){
        return $rst[0]->fetch_array();
	  }
	}
}

function GetClassPassDetAll(){
	global $dbo;
   $rtn = array();
	$rst = $dbo -> RunQuery("select * from classofpass_tb");
	
	if(is_array($rst)){
      if($rst[1] > 0){
        while($grds = $rst[0]->fetch_array()){
             $rtn[$grds[0]] = $grds;
		}
	  }
	}
	return $rtn;
}
//function to get gradedet from schgrade table
function GetClassPassDet($ClassID){
	global $dbo;
	$rtn = array();
	$rst = $dbo -> RunQuery("select * from classofpass_tb where ID = {$ClassID} limit 1");
	if(is_array($rst)){
      if($rst[1] > 0){
        return $rst[0]->fetch_array();
	  }
	}
}

//function to get the class of pass structure
function GetClassPassStruct(){
	global $dbo;
	//if($classstr == ""){ //if classofpass string not send get from database
		$rst = $dbo -> RunQuery("select * from resultinfo_tb where ID = (select GrdStrucID from school_tb limit 1)");
			if(is_array($rst)){
				if($rst[1] > 0){
					$grad = $rst[0]->fetch_array();
					return $grad['ClassOfPass'];
				}
			}
			return "";
		//}
}

//function to get the class of pass based on the cgpa sent
function GetClassPass($cgpa = 0,$classstr="",$clasesDet = array()){
     global $dbo;
	if($classstr == ""){ //if classofpass string not send get from database
		$classstr = GetClassPassStruct();
	}

		if(count($clasesDet) == 0){ //if class of pass details not sent
			  $clasesDet = GetClassPassDetAll();
		  }
      
	  //breackdown class structure
	  $classStrArr = explode("&",$classstr);
	  if(count($classStrArr) > 0){ //if structure element found
         //loop throug each structure element 
		 foreach($classStrArr as $indclassstr){
			 //get the range and classid 
			 $rangvalArr = explode("=",$indclassstr);
			 if(count($rangvalArr) == 2){
				 $classRange = trim($rangvalArr[0]);
				 $rangeClassID = (int)$rangvalArr[1];
				 //test range
                $firstChar = substr($classRange,0,1);
				if($firstChar == "<" || $firstChar == ">"){//if is lessthan or greaterthan range structure
					//get the rangeval
					$testval = (float)substr($classRange,1);
					$cond = $firstChar == "<"?$cgpa < $testval:$cgpa > $testval;
					if($cond){
						return isset($clasesDet[$rangeClassID])?$clasesDet[$rangeClassID]:GetClassPassDet($rangeClassID);
					}
				}else{
					$ranges = explode("-",$classRange);
					if(count($ranges) == 2){ //if range boundary set
                       $min = (float)$ranges[0];
					   $max = (float)$ranges[1];
					   if($cgpa >= $min && $cgpa <= $max){
						  return isset($clasesDet[$rangeClassID])?$clasesDet[$rangeClassID]:GetClassPassDet($rangeClassID); 
					   }
					}
				}

			 }
		 }
	  }

return NULL;

    
}

//function to get grade point from grade
function GetPoint($igrd){
	global $dbo;
	$igrd = trim($igrd);
	$rst = $dbo -> RunQuery("select * from resultinfo_tb");
	if(is_array($rst)){
		if($rst[1] > 0){
			$grad = $rst[0]->fetch_array();
			$gradstr = @$grad['Grading'];
			if(trim($gradstr) != ""){
				//break into individual grades
				$indgrads = explode("~",$gradstr);
				if(count($indgrads) > 0){
					for($s=0; $s < count($indgrads); $s++){
						$indgrad = $indgrads[$s];
						if(trim($indgrad) != ""){
							//break to get score and equivalent grade
							$scoregrd = explode("=",$indgrad);
							if(count($scoregrd) == 2){
								$val = trim($scoregrd[0]);
								$grd = trim($scoregrd[1]);
								//get gradepoint
								$grdpntarr = explode("|",$grd);
								//$point = 0;
								if(count($grdpntarr) == 2){
									$grd = trim($grdpntarr[0]);
									if(strtolower($grd) == strtolower($igrd)){
									return (float)$grdpntarr[1];
									}
								}
							}
						}
					}
					
				}
			}
			
		}
		
	}
	return 0;
}
//$GPU = array("A"=>5,"B"=>4,"C"=>3,"D"=>2,"E"=>1,"F"=>0);
//calculate GPA and CGPA
function GPA($regNo, $lvl, $sem){
	global $dbo;
	$sqlregNo = $dbo->SqlSave($regNo);
	$lvl = (int)$lvl;
	$sem = (int)$sem;
	$rsult = $dbo->RunQuery("select * from result_tb where RegNo='{$sqlregNo}' and Lvl <= $lvl and Sem <= $sem");
	// and Lvl = {$lvl} and Sem = {$sem}
	$GPA = 0.0;
	$CGPA = 0.0;
	$TGPV = 0.0;
	$TCH = 0.0;
	$CTGPV = 0.0;
	$CTCH = 0.0;
	 if(is_array($rsult)){
		 if($rsult[1] > 0){
			 while($rstarr = $rsult[0]->fetch_array()){
				  $results = $rstarr['Rst'];
		  		if(trim($results) != ""){
					$indrst = explode("~",$results);
			        if(count($indrst) > 0){
						for($a =0; $a < count($indrst); $a++){
						  $result = $indrst[$a];
						  if(trim($result) != ""){
							  //break to form result details
							  $resultdet = explode("|",$result);
							  if(count($resultdet) == 3){
								 $courseID = $resultdet[0];
								 $CA = (float)$resultdet[1];
								 $Exm = (float)$resultdet[2];
								  $courseDet = CourseDetails($courseID); //get the course Details
								  if(is_array($courseDet)){
									  $Cd = trim($courseDet['CourseCode']);
									  $tit = $courseDet['Title'];
									  $CH = (float)$courseDet['CH'];
									  $tot = $CA + $Exm;
									  $grd = GetGrade($tot);
									  $pnt = GetPoint($grd);
									  $GPV = $pnt * $CH;
									  $CTGPV += $GPV;
									  $CTCH += $CH;
									  if($lvl == $rstarr['Lvl'] && $sem == $rstarr['Sem']){//if the current result
										 $TGPV += $GPV;
									     $TCH += $CH; 
									  }
									//$arrval2[] = array(str_replace(" ","&nbsp;",$Cd),"[".strtoupper($tit)."]","[{$CA}]","[{$Exm}]",$tot,$grd);  
								  }
							  }
						  }
						}
					}
				}
			 }
		 }
		 
	 }
	 if($TCH > 0){
		$GPA = $TGPV / $TCH; 
	 }
	 
	 if($CTCH > 0){
		$CGPA = $CTGPV / $CTCH; 
	 }
	 return array(number_format($GPA,2),number_format($CGPA,2));
}


//function to resolve the individual result
function GetIndResult($indrststr){
	$result = $indrststr;
	$rtn = "";
	if(trim($result) != ""){
					  //break to form result details
					  $resultdet = explode("|",$result);
					  if(count($resultdet) == 3){
						 $courseID = $resultdet[0];
						 $CA = (float)$resultdet[1];
						 $Exm = (float)$resultdet[2];
						  $courseDet = CourseDetails($courseID); //get the course Details
						  if(is_array($courseDet)){
							  $Cd = trim($courseDet['CourseCode']);
							  $tit = $courseDet['Title'];
							  $CH = $courseDet['CH'];
							  $tot = $CA + $Exm;
							  $grd = GetGrade($tot);
							  $pnt = GetPoint($grd);
							 // $grdd = $grd. "-" .GetPoint($grd);
							return array($Cd,$tit,$CH,$CA,$Exm,$tot,$grd,$pnt); 
						  }
					  }
				  }
				  return $rtn;
}

//function to get immediate prevouse level semester details
function GetPrevLvlSem($rlvl, $rsem){
	$rlvl = (int)$rlvl; $rsem = (int)$rsem;
	 if($rlvl == 1 && ($rsem != 2))return array("err"=>"None");//if freshers, i.e no prevous payment record
	 if($rlvl == 0 || $rsem == 0)return array("err"=>"Invalid");//if freshers, i.e no prevous payment record
	 $rsem = ($rsem == 3)?1:$rsem; //if current payment is full take like first payment so that it can check for prev lvel sem 1
	 $sem = $rsem - 1; //calculate prevouse semester
	 $sem = ($sem == 0)?2:$sem; // if no semester for prev, den set semester to 2, meaning second semester of the prev level
	 $lvl = $rlvl - $sem + 1; //calculate prevous level
	 return array("err"=>"","level"=>$lvl,"semester"=>$sem);
 }
 
 //function to get the modeof entry id by name
 function GetMOEID($MOE){
	 if((int)$MOE > 0) return $MOE;
	 return (strtolower(trim($MOE)) == "direct-entry")?2:1;
 }
 
 //function to get MOE name by ID
 function GetMOEName($id){
	 global $dbo;
	 $rst = $dbo->RunQuery("SELECT Name FROM modeofentry_tb WHERE Level = $id LIMIT 1");
	 if(is_array($rst)){
		 if($rst[1] > 0){
			$rstarr = $rst[0]->fetch_array();
			return $rstarr[0]; 
		 }
		 return "NA";
	 }
	 return "Error";
 }
 
 //function to check is screened
function CheckScreen($regNo,$pref="",$RegID = 1){
	//get level
	global $dbo;
	$RegIDr = trim($pref) == ""?1:$RegID; //if checking stud level from main studentinfo_tb, set RegID to 1(general for all Student)
	$studLvl = StudLevel($regNo, $pref, $RegIDr);
	//$studModeofEn = GetMOE($regNo,$pref,$RegID); //get the student mode of entry
	 // $studModeofEn = GetMOEID($studModeofEn); //get id
	 // $rlvl = (int)$studLvl - ($studModeofEn - 1);
	//return $studLvl;
	if($studLvl == 1){
		//check if student exist in screening table
		$studscreen = $dbo->SelectFirstRow("screening_tb","","RegNo = '$regNo' AND RegID = $RegID");
		if(is_array($studscreen)){ //if found
			return $studscreen; //screend
		}
	}else{
		
		return false; //wrong student
	}
	return NULL; //not screened
	//
}

//this function will generate RRR (Remita payment platform only)
//it receives the payee details as array of the following keys => amt,orderId,pname,pemail,pphone,resurl
function GenerateRRR($payeeDet){
	global $dbo;
global $REMITAPARAM;
extract($REMITAPARAM);
/*global $MERCHANTID;
global $SERVICETYPEID;
global $APIKEY;
global $GATEWAYURL;
global $GATEWAYRRRPAYMENTURL;
global $CHECKSTATUSURL;*/
if(isset($MERCHANTID)){
	$SERVICETYPEID = $payeeDet['serviceType'];
	$totalAmount = $payeeDet["amt"]; 
	$timesammp=DATE("dmyHis");		
	$orderID = $payeeDet["orderId"];
	$payerName = $payeeDet["pname"];
	$payerEmail = $payeeDet["pemail"];
	$payerPhone = $payeeDet["pphone"];
	$responseurl = $payeeDet["resurl"];
	$hash_string = $MERCHANTID . $SERVICETYPEID . $orderID . $totalAmount . $responseurl . $APIKEY;
	$hash = hash('sha512', $hash_string);
	$itemtimestamp = $timesammp;
	//return $BC.";".$DFF;
	$ITEMAR = explode("~",$ITEM);
	$BNAR = explode("~",$BN);
	$BAAR = explode("~",$BA);
	$BCAR = explode("~",$BC);
	$DFFAR = explode("~",$DFF);
	$BAMTAR = $payeeDet["AmtSplit"];
   // return implode(";",$BAMTAR);
	$content = '{"merchantId":"'. $MERCHANTID
	.'"'.',"serviceTypeId":"'.$SERVICETYPEID
	.'"'.",".'"totalAmount":"'.$totalAmount
	.'","hash":"'. $hash
	.'"'.',"orderId":"'.$orderID
	.'"'.",".'"responseurl":"'.$responseurl
	.'","payerName":"'. $payerName
	.'"'.',"payerEmail":"'.$payerEmail
	.'"'.",".'"payerPhone":"'.$payerPhone
	.'","lineItems":[';
	for($s=0; $s < count($ITEMAR); $s++){
		$ITEMCUR = $ITEMAR[$s].$itemtimestamp;
		$BNCUR = $BNAR[$s];
		$BACUR = $BAAR[$s];
		$BCCUR = $BCAR[$s];
		$DFFCUR = $DFFAR[$s];
		$BAMTCUR = $BAMTAR[$s];
$content .='{"lineItemsId":"'.$ITEMCUR.'","beneficiaryName":"'.$BNCUR.'","beneficiaryAccount":"'.$BACUR.'","bankCode":"'.$BCCUR.'","beneficiaryAmount":"'.$BAMTCUR.'","deductFeeFrom":"'.$DFFCUR.'"},';
	}
	$content = rtrim($content,",").']}';
   //return $content;
	/*$itemid1="itemid1".$itemtimestamp;
	$itemid2="34444".$itemtimestamp;
	$itemid3="8694".$itemtimestamp;
	$beneficiaryName="Oshadami Mke";
$beneficiaryName2="Mujib Ishola";
	$beneficiaryName3="Ogunseye Olarewanju";
	$beneficiaryAccount="6020067886";
	$beneficiaryAccount2="0360883515";
	$beneficiaryAccount3="4017904612";
	
	$bankCode="011";
	$bankCode2="050";
	$bankCode3="070";
		$beneficiaryAmount ="900";
	$beneficiaryAmount2 ="50";
	$beneficiaryAmount3 ="50";
	$deductFeeFrom=1;
	$deductFeeFrom2=0;
	$deductFeeFrom3=0;
	
	//The JSON data.
	$content = '{"merchantId":"'. $MERCHANTID
	.'"'.',"serviceTypeId":"'.$SERVICETYPEID
	.'"'.",".'"totalAmount":"'.$totalAmount
	.'","hash":"'. $hash
	.'"'.',"orderId":"'.$orderID
	.'"'.",".'"responseurl":"'.$responseurl
	.'","payerName":"'. $payerName
	.'"'.',"payerEmail":"'.$payerEmail
	.'"'.",".'"payerPhone":"'.$payerPhone
	.'","lineItems":[
	{"lineItemsId":"'.$itemid1.'","beneficiaryName":"'.$beneficiaryName.'","beneficiaryAccount":"'.$beneficiaryAccount.'","bankCode":"'.$bankCode.'","beneficiaryAmount":"'.$beneficiaryAmount.'","deductFeeFrom":"'.$deductFeeFrom.'"},
	{"lineItemsId":"'.$itemid2.'","beneficiaryName":"'.$beneficiaryName2.'","beneficiaryAccount":"'.$beneficiaryAccount2.'","bankCode":"'.$bankCode2.'","beneficiaryAmount":"'.$beneficiaryAmount2.'","deductFeeFrom":"'.$deductFeeFrom2.'"},
	{"lineItemsId":"'.$itemid3.'","beneficiaryName":"'.$beneficiaryName3.'","beneficiaryAccount":"'.$beneficiaryAccount3.'","bankCode":"'.$bankCode3.'","beneficiaryAmount":"'.$beneficiaryAmount3.'","deductFeeFrom":"'.$deductFeeFrom3.'"}
	]}';*/
	//return $content;
	/*,	{"lineItemsId":"'.$itemid2.'","beneficiaryName":"'.$beneficiaryName2.'","beneficiaryAccount":"'.$beneficiaryAccount2.'","bankCode":"'.$bankCode2.'","beneficiaryAmount":"'.$beneficiaryAmount2.'","deductFeeFrom":"'.$deductFeeFrom2.'"},
	{"lineItemsId":"'.$itemid3.'","beneficiaryName":"'.$beneficiaryName3.'","beneficiaryAccount":"'.$beneficiaryAccount3.'","bankCode":"'.$bankCode3.'","beneficiaryAmount":"'.$beneficiaryAmount3.'","deductFeeFrom":"'.$deductFeeFrom3.'"}*/
	//return $GATEWAYURL;
	$curl = curl_init($GATEWAYURL);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER,
	array("Content-type: application/json"));
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
	$json_response = curl_exec($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	curl_close($curl);
	$jsonData = substr($json_response, 6, -1);
	$response = json_decode($jsonData, true);
	$statuscode = $response['statuscode'];
	$statusMsg = $response['status'];
	//$rrr = "";
	if($statuscode=='025'){
	  $rrr = trim($response['RRR']);
	  return array("RRR"=>$rrr,"Code"=>$statuscode,"Message"=>$statusMsg);
	}else{
	  return array("RRR"=>"","Code"=>$statuscode,"Message"=>$statusMsg);	
	}
	
  }
	return "Wrong Payment Parameter Set";
}

//function to get the student payment load level sending the student level and moe
function PayLoadLevel($lvl = 0, $MOE = 1){
	if($lvl == 0 || $lvl == $MOE)return 1; //if student level is the MOE id means the student is just starting, then load 100 level payment
	return $lvl;
	
}

//function to return the slip footer
function SlipFooter($schabbr,$qrurl,$print = "",$thirdpartpay = ""){
	$thirdpartpay = trim($thirdpartpay) != ""?'| <strong>'.$thirdpartpay.'</strong>':"";
  echo '<div style="text-align:; bottom:0px; margin:auto; width:95%; font-size:1em; border-top:#000 2px solid; border-bottom:none; margin-top:30px">
   <div style="float:left; width:150px; height:150px;">
	   <img src="'.$qrurl.'" alt="QR Code" title="Scan To Verify Documnet" style="width:inherit; height:inherit" />
	 </div>
     <div style="float:left; padding-top:20px; margin-left:20px;"><div style="">'.$print.'</div><div style="display:block; font-size:0.9em">'.date("d/m/Y | g:i:s A").'</div><div style="display:block; font-size:0.9em">WEB PRINT</div><div style="display:block; font-size:0.9em">'.mt_rand().'</div> <div style="">&copy;'.date("Y").' '.$schabbr.' | eduPorta '.$thirdpartpay.' </div><div style="display:block; font-size:0.9em">Powered by TAQUATECH</div>
	 </div>
	
     <div style="clear:both"></div>
  </div>';
  ;
}

// 24/09/2016 - TAG: Function to Get the Semester and Semester Part Payment String e.g FIRST PAYMENT(PART)
function FormPayPolicy($Sem, $SemPart = 3){
	global $dbo;
	$partPayShare = "HALF";
	$schpay = SchoolPayDet();
	if(is_array($schpay)){
		$partPayShare = $schpay['PartPayShare'];
	}
	if(!isset($Sem)){
		return "NO PAYMENT";
		}
	$semnames = array(1=>"FIRST",2=>"SECOND",3=>"FULL");
	if($partPayShare != "HALF"){
     $semparts = array(1=>"(PART)",2=>"(COMPLETE)",3=>"(FULL)");
	}else{
	 $semparts = array(1=>"(PART)",2=>"(COMPLETE)",3=>"");	
	}
	if((int)$Sem == 3 && (int)$SemPart == 3){
	return $semnames[(int)$Sem]." PAYMENT";	
	}else{
	return $semnames[(int)$Sem]." PAYMENT".$semparts[(int)$SemPart];
	}

}

// 26/09/2016 - TAG: Function to get school payment Details
function SchoolPayDet(){
	global $dbo;
	$schpay = $dbo->Select4rmdbtbFirstRw("schoolpayment_tb");
	return $schpay;
}

// 21/10/2016 - TAG: get state of origin by state id
function GetLGA($LGA){
	global $dbo;
	$LGAID = (int)$LGA;
	if($LGAID < 1)return $LGA;
	$putmerst = $dbo->RunQuery("select * from lga_tb where LGAID = {$LGAID} limit 1");
				$lganm = "";
				if(is_array($putmerst)){
					if($putmerst[1] > 0){
						$pdt = $putmerst[0]->fetch_array();
						$lganm = $pdt[1];
						//$dateputmer = $dateputme->format("d/m/y | h:m A");
					}
				}
				return $lganm;
}

//function to get olevel grades
function GetOLevelGrades(){
  global $dbo;
  $rst = $dbo->RunQuery("select * from olvlgrade_tb where Status = 1 ORDER BY Level");
  if(is_array($rst)){
      if($rst[1] > 0){
		  return $rst[0];
	  }
  }
  return NULL;
}

function SessionName($sesID){
	$sesdet = GetBy("SesID",$sesID,"session_tb");
	if(is_array($sesdet)){
      return $sesdet['SesName'];
	}
	return "";
}
//function to get user paid policy and the remaining
function GetPayPolicyRem($RegNo,$Lvl,$PayID){
    //get database object 
	global $dbo;
	//clean datas for db 
	$RegNo = $dbo->SqlSafe($RegNo);
	$Lvl = $dbo->SqlSafe($Lvl);
	$PayID = $dbo->SqlSafe($PayID);
	$PaymentItem = GetPaymentItem($PayID);
	$studType = $PaymentItem['studType'];
	if($studType == "f"){ //if the payment type if for fresh student load only Full Payment (which is the only allowable payment policy)
		return array("3_3"=>"FULL PAYMENT");
	}
	$query = "SELECT * FROM payhistory_tb WHERE Lvl = $Lvl AND RegNo = '$RegNo' AND PayID = $PayID ORDER BY Sem ASC, SemPart ASC";
	//return array($query);
	//get the student Payments for the supplied level
    $pays = $dbo->RunQuery($query);
	$PaypolArr = array();
	if(is_array($pays)){ //if query runs
	//get the payment policy part share 
	$partPayShare = "HALF";
	//return $partpayShare;
		$schpay = SchoolPayDet();
		
		if(is_array($schpay)){
			$partPayShare = strtoupper($schpay['PartPayShare']);
			
		}
		$highestPay = "0_0";
		
		$paypols = PayPolNames();
		
		if($pays[1] > 0){ //if rows found
           //move through rows
		   while($pay = $pays[0]->fetch_array()){
			   $paypolid = $pay['Sem']."_".$pay['SemPart'];
			   $cpaypolname = $paypols[$partPayShare][$paypolid];
			   if($cpaypolname != null){
                  $PaypolArr[$paypolid] =  $cpaypolname;
				  $highestPay = $paypolid;
			   }
              
		   }
		   
		}
        
		//determine the remaining expected paypolicy
		   $RemPayPolArr = PayPolRem();
		   $RemPayPol = $RemPayPolArr[$highestPay][$partPayShare];
		   //return $partpayShare;
		   if($RemPayPol != null){
			   $RemPayPolArr = explode(",",$RemPayPol);
			   foreach($RemPayPolArr as $rempayid){
				  $PaypolArr[$rempayid] =  $paypols[$partPayShare][$rempayid];   
			   }
		   }

	}
	return $PaypolArr;
}

function PayPolRem($PayPolID){
	$arrRemPayPol["0_0"] = array("HALF"=>"1_3,3_3","QUATER"=>"1_1,1_3,3_3");
	$arrRemPayPol["1_1"] = array("HALF"=>null,"QUATER"=>"1_2");
	$arrRemPayPol["1_2"] = array("HALF"=>null,"QUATER"=>"2_1,2_3");
	$arrRemPayPol["1_3"] = array("HALF"=>"2_3","QUATER"=>"2_1,2_3");
    $arrRemPayPol["2_1"] = array("HALF"=>null,"QUATER"=>"2_2");
	$arrRemPayPol["2_2"] = array("HALF"=>null,"QUATER"=>null);
	$arrRemPayPol["2_3"] = array("HALF"=>null,"QUATER"=>null);
	$arrRemPayPol["3_3"] = array("HALF"=>null,"QUATER"=>null);
	return $arrRemPayPol;
}

//function to get payment policy name
function PayPolNames(){
	//Get current set share payment policy (HALF/QUATER)
	$arrNames = array();
	
	//set names
	$arrNames["HALF"]["1_1"] = null;
	$arrNames["HALF"]["1_2"] = null;
	$arrNames["HALF"]["1_3"] = "FIRST PAYMENT";
	$arrNames["HALF"]["2_1"] = null;
	$arrNames["HALF"]["2_2"] = null;
	$arrNames["HALF"]["2_3"] = "SECOND PAYMENT";
	$arrNames["HALF"]["3_3"] = "FULL PAYMENT";

    $arrNames["QUATER"]["1_1"] = "FIRST PAYMENT(PART)";
	$arrNames["QUATER"]["1_2"] = "FIRST PAYMENT(COMPLETE)";
	$arrNames["QUATER"]["1_3"] = "FIRST PAYMENT(FULL)";
	$arrNames["QUATER"]["2_1"] = "SECOND PAYMENT(PART)";
	$arrNames["QUATER"]["2_2"] = "SECOND PAYMENT(COMPLETE)";
	$arrNames["QUATER"]["2_3"] = "SECOND PAYMENT(FULL)";
	$arrNames["QUATER"]["3_3"] = "FULL PAYMENT";
	return $arrNames;
   
}
function GetPayPolicy($RegNo,$Lvl,$PayID,$All=false){
	//get the student payment parameters
//RegNo+"' and Lvl = "+Lvl+" and PayID = "+PayID

global $dbo;
$RegNo  = $dbo->SqlSafe($RegNo);
$Lvl  = $dbo->SqlSafe($Lvl);
$PayID  = $dbo->SqlSafe($PayID);
$retnval = "";
//get the school payment settings
$schpay = $dbo->Select4rmdbtbFirstRw("schoolpayment_tb");
$payItem = $dbo->Select4rmdbtbFirstRw("item_tb","","ID=".$PayID);
	  $studType = trim($payItem["studType"]);
	  //$partpay = $schpay['PartPay'];
	 
if(is_array($schpay)){
   $partpay = $schpay['PartPay'];
   $partpayShare = $schpay['PartPayShare'];
   $prevcheck = $schpay['PrevCheck']; //**
   //get all payment made by student in the selected level
   $payhist = $dbo->RunQuery("SELECT * FROM payhistory_tb WHERE RegNo = '$RegNo' AND Lvl = $Lvl AND PayID = $PayID");
  
   if(is_array($payhist)){
      //echo $payhist[1];
       if($payhist[1] < 1){
           //no payment found
           //set the policy based on the part pay division set
             //echo "hhhh3";
  // exit;
     if($studType  == "f"){
		  return "3=FULL PAYMENT";
	      }
           $rst = ($partpayShare != 'QUATER')?"1=FIRST PAYMENT&3=FULL PAYMENT":"1_1=FIRST PAYMENT(PART)&1_3=FIRST PAYMENT(FULL)&3=FULL PAYMENT";
           $retnval .= $rst;
       }else{//if student has made payment
       $pays = $partpayShare != 'QUATER'?array('1'=>'FIRST PAYMENT','2'=>'SECOND PAYMENT','3'=>'FULL PAYMENT'):array('1_1'=>'FIRST PAYMENT(PART)','1_2'=>'FIRST PAYMENT(COMPLETE)','1_3'=>'FIRST PAYMENT(FULL)','2_1'=>'SECOND PAYMENT(PART)','2_2'=>'SECOND PAYMENT(COMPLETE)','2_3'=>'SECOND PAYMENT(FULL)','3'=>'FULL PAYMENT');
	   $paidstr = ""; 
        while ($recs = $payhist[0]->fetch_array()){
              $Sem = $recs['Sem']."";
              $SemPart = $recs['SemPart']."";
              if((int)$Sem == 3){//complete payment already made
                $retnval .= $All?"3=FULL PAYMENT":"#";
                return $retnval;
              }else{
                  if($partpayShare != 'QUATER'){//half sharing payment
				    $paidstr .= $Sem . "=". $pays[$Sem]."&";
                    $pays[$Sem] = "";
                  }else{
					 $paidstr .= $Sem."_".$SemPart . "=". $pays[$Sem."_".$SemPart]."&"; 
                    $pays[$Sem."_".$SemPart] = "";
                  }
                
              }
        }
		$paidstr = rtrim($paidstr,"&");
         if($studType  == "f"){
		  return "3=FULL PAYMENT";
	      }
            //form the display policy list
            if($partpayShare != 'QUATER'){//half sharing payment
                //case first paid and second not paid
                if($pays['1'] == '' && $pays['2'] != '') $retnval .= $All?"1=FIRST PAYMENT&2=SECOND PAYMENT":"2=SECOND PAYMENT";
                //case first not paid second paid (unusual)
                if($pays['1'] != '' && $pays['2'] == '') $retnval .= $All?"1=FIRST PAYMENT&2=SECOND PAYMENT":"1=FIRST PAYMENT";
                //case first not paid second not paid (unusual)
                if($pays['1'] != '' && $pays['2'] != '') $retnval .= "1=FIRST PAYMENT&3=FULL PAYMENT";
                //case first paid second paid 
                if($pays['1'] == '' && $pays['2'] == '') $retnval .= $All?"1=FIRST PAYMENT&2=SECOND PAYMENT":"#";
            }else{//quater sharing payment
            //Paid second full only
            
              if($pays['2_3'] == '') {$retnval .= $All?$paidstr:"#";return $retnval;}
              //Paid second complete only
              if($pays['2_1'] == '' && $pays['2_2'] == '') {$retnval .= $All?$paidstr:"#";return $retnval;}
              //Paid Second Part only
              if($pays['2_1'] == '' && $pays['2_2'] != '') {$retnval .= $All?$paidstr."&2_2=SECOND PAYMENT(COMPLETE)":"2_2=SECOND PAYMENT(COMPLETE)";return $retnval;}
              //Paid First Full
              if($pays['1_3'] == '') {$retnval .= $All?$paidstr."&2_1=SECOND PAYMENT(PART)&2_3=SECOND PAYMENT(FULL)":"2_1=SECOND PAYMENT(PART)&2_3=SECOND PAYMENT(FULL)";return $retnval;}
              //Paid First complete only
              if($pays['1_1'] == '' && $pays['1_2'] == '') {$retnval .= $All?$paidstr."&2_1=SECOND PAYMENT(PART)&2_3=SECOND PAYMENT(FULL)":"2_1=SECOND PAYMENT(PART)&2_3=SECOND PAYMENT(FULL)";return $retnval;}
            //Paid First Part only
              if($pays['1_1'] == '' && $pays['1_2'] != '') {$retnval .= $All?$paidstr."&1_2=FIRST PAYMENT(COMPLETE)":"1_2=FIRST PAYMENT(COMPLETE)";return $retnval;}

			  //unusual cases
			  //not paid First Part, But Paid First Complete
			  if($pays['1_1'] != '' && $pays['1_2'] == '') {
				  if($prevcheck == "TRUE"){
                     $retnval .= $All?$paidstr."&1_1=FIRST PAYMENT(PART)":"1_1=FIRST PAYMENT(PART)";return $retnval;
				  }else{
					  $retnval .= $All?$paidstr."&1_1=FIRST PAYMENT(PART)&2_1=SECOND PAYMENT(PART)&2_3=SECOND PAYMENT(FULL)":"2_1=SECOND PAYMENT(PART)&2_3=SECOND PAYMENT(FULL)";return $retnval;
                    
				  }
				  
            }
			//not paid Second Part, But Paid Second Complete
			  if($pays['2_1'] != '' && $pays['2_2'] == '') {
				  if($prevcheck == "TRUE"){
                     $retnval .= $All?$paidstr."&2_1=SECOND PAYMENT(PART)":"2_1=SECOND PAYMENT(PART)";return $retnval;
				  }else{
					  $retnval .= $All?$paidstr."&2_1=SECOND PAYMENT(PART)":"#";return $retnval;
                    
				  }
				  
            }
          
       }
   }
}
} //Added to correctly close all opened bracket 22-5-17 #1
return $retnval;
}

function ExtraLevelString(){
	$sch = GetBy("ID","1","school_tb");
	$ExtraLevelStr= "Spillover";
	if(count($sch) > 0){
      $ExtraLevelStr = $sch["ExtraYearPrefix"];
	}
    return $ExtraLevelStr;

}

//function to generate itemnum and transnum(unique) 
function generateTransInfoOnly(){
	global $dbo;
	$item_num = mt_rand(1000,999999999).date("dmyHis");
				 do{
				  $trans_nums = mt_rand(1000000000,9999999999); //rep PAYEE ID here
				  //$trans_nums = $trans_nums;
				  $chek = $dbo -> Select4rmdbtbFirstRw("order_tb","","TransNum = '".$dbo->SqlSave($trans_nums)."'");
				  }while(is_array($chek));
				
				return array($item_num,$trans_nums);
}
function generateTransInfo(){
	//return array(747488484,744884746);
	global $dbo;
	global $thirdP;
	global $Amt;
	global $studinfo;
	global $PayID;
	global $Sem;
	global $sempart;
				$item_num = mt_rand(1000,999999999).date("dmyHis"); //rep orderID for REMITA
				if($thirdP == 2){
				
				  do{
				  $trans_nums = mt_rand(1000000000,9999999999); //rep PAYEE ID here
				  //$trans_nums = $trans_nums;
				  $chek = $dbo -> Select4rmdbtbFirstRw("order_tb","","TransNum = '".$dbo->SqlSave($trans_nums)."'");
				  }while(is_array($chek));
				  /*{
					  //$item_num = mt_rand(1000,999999999);
					  $trans_nums = mt_rand(1000000000,9999999999);
					  //$trans_nums = $trans_nums."".$item_num;
					  $chek = $dbo -> Select4rmdbtbFirstRw("order_tb","","TransNum = '".$dbo->SqlSave($trans_nums)."'");
				  }*/
				}else{//if remita
					//call the function that generate the RRR for the current payment request of the payee
					//amt,orderId,pname,pemail,pphone,resurl http://localhost/projects/rportals/Admin/remita/sample-receipt-page.php
					$payitem = GetPaymentItem($PayID); //get the payment item details
					$serviceType = $payitem['PaymentID']; //get the service charge
					$amtsplit = GetPaymentSplit(array("Sem"=>$Sem,"SemPart"=>$sempart,"Amt"=>$Amt,"PayID"=>$PayID)); //get the amt split
					$studinfo["Email"] = trim($studinfo["Email"]) == ""?"support@".$_SERVER['HTTP_HOST']:$studinfo["Email"];
					$requestData = array("amt"=>$Amt."","orderId"=>$item_num,"pname"=>$studinfo["Name"],"pemail"=>$studinfo["Email"],"pphone"=>$studinfo["Phone"],"resurl"=>'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/finish.php","serviceType"=>$serviceType,"AmtSplit"=>$amtsplit);
					//print_r($requestData);
					$rrrarr = GenerateRRR($requestData);
					//echo $rrrarr;
					if(is_array($rrrarr)){ //if valid
						$RRR = $rrrarr["RRR"];
						$Code = $rrrarr["Code"];
						$Msg = $rrrarr["Message"];
						if($RRR == ""){
							return '<h1 style="font-size:1.1em; font-weight: lighter">Error: Cannot Generate Payment Reference<h1><h1 style="font-size:1.2em; font-weight: lighter">'.$Msg.'<h1>';
							//exit;
						}else{
							$trans_nums = $RRR;
						}
					}else{//invalid parameter
						return '<h1 style="font-size:1.1em; font-weight: lighter">Error: Cannot Generate Payment Reference<h1><h1 style="font-size:1.2em; font-weight: lighter">'.$rrrarr.'<h1>';
						//exit;
					}
				}
				
				return array($item_num,$trans_nums);
}

//Auto Registration Number Functions 
//function to get the RegNoFormat
function GetAutoRegNoParam($ProgID = 1){
	global $dbo;
	$fmt = "";
	$RegNoStart = 0;
	$fmtTable = "programme_tb";
	$NumStartTable = "programme_tb";
	//get from programme_tb (LOCAL)
	$rst = $dbo->SelectFirstRow("programme_tb","RegNoFormat,RegNumStart","ProgID = $ProgID");
	if(is_array($rst)){
		$fmt = trim($rst['RegNoFormat']);
		$RegNoStart = (int)$rst['RegNumStart'];
	}

//get from school_tb (GLOBAL) if not found locally
	if($fmt == "" || $RegNoStart == 0){
		$rst2 = $dbo->SelectFirstRow("school_tb","RegNoFormat,RegNumStart");
		if(is_array($rst2)){
			if($fmt == ""){
				$fmt = trim($rst2['RegNoFormat']);
				$fmtTable = "school_tb";
			}
			if($RegNoStart == 0){
				$RegNoStart = (int)$rst2['RegNumStart'];
				$NumStartTable = "school_tb";
			}
		}	
	}

	//if no found atall
	if($fmt == ""){
		$fmt ="?AUTONUM?";
		$fmtTable = "";
	}
if($RegNoStart == 0){
  $RegNoStart = 1;
  $NumStartTable = "";
}
   return array($fmt,$RegNoStart,$fmtTable,$NumStartTable);
}

//function to generate registration number for the selected student
function AutoGenRegNo($RegNo,$RegID=1){
	global $dbo;
   
   $Sch = $dbo->SelectFirstRow("school_tb");
   if(is_array($Sch)){
     if($Sch['AutoRegNo'] == "FALSE"){//check if auto reg is enabled
		 return "##"; //auto regno generation disabled
	 }
    //check if student exist
	//$StudDet = $dbo->SelectFirstRow("studentinfo_tb","","(RegNo = '$RegNo' OR JambNo = '$RegNo') AND REGID = $RegID");
	$StudDet = GetBasicInfo($RegNo,"studsch","",-$RegID);
	if(is_array($StudDet)){
		$StartSes = (int)$StudDet['StartSes'];
		 $curSes = CurrentSes();
		 $SesID = (int)$curSes['SesID'];
		 if($SesID != $StartSes){ //if not fresh student
           return "##"; //return as if auto reg is disabled
		 }
		 $StudRegNo = strtoupper(trim($StudDet['RegNo']));
		 $StudJambNo = strtoupper(trim($StudDet['JambNo']));
      if($StudRegNo == "" || $StudRegNo == $StudJambNo){ //if student has no regno or student jambno is regno
		  $sprogID = $StudDet['ProgID'];
         //No RegNo
		 //Get the RegNoFormat and RegNoStart
		 list($RegoFormat,$AutoNumStart,$frmTable,$NumStartTable) = GetAutoRegNoParam($sprogID);
		 $FacAbbr = $StudDet['FacAbbr'];
		 $DeptAbbr = $StudDet['DeptAbbr'];
		 $ProgAbbr = $StudDet['ProgAbbr'];
		 $curSes = CurrentSes();
		 $SesName = $curSes['SesName'];
		 $SesAbbr = $curSes['Abbr'];
		 $SchAbbr = "SCH";
		 $sch = GetSchool();
		 if(is_array($sch)){
           $SchAbbr = $sch['Abbr'];
		 }
		 $tolerance = -1; //use to search next available generation if current generated exist
		 do{
			 $tolerance++;
			 //get last regno generated student record
			 $LastGenStud = $dbo->SelectFirstRow("studentinfo_tb","","AutoGenReg = 'TRUE' AND RegID = $RegID AND ProgID = $sprogID ORDER BY AutoNum DESC");
			 $LastAutoNum = 0;
             if(is_array($LastGenStud)){ //if last generated student exist
			   $LastAutoNum = $LastGenStud['AutoNum'];
			 }
			 $UseAutoNum = 1; //the new AutoNum
			 //check if AutoNumStart is Negative (i.e reset generation (Force to increament from the AutoNumStart))
			 if($AutoNumStart < 0){
                $UseAutoNum = abs($AutoNumStart);
				//update Auto Start to positive
				if($NumStartTable != ""){
					$cond = $NumStartTable == "programme_tb"?"ProgID = ".$StudDet['ProgID']:"";
                   $dbo -> Update($NumStartTable,array("RegNumStart"=>$UseAutoNum),$cond);
				} 
			 }else{
				 if($AutoNumStart <= $LastAutoNum){//increment LastAutoNum
                   $UseAutoNum = $LastAutoNum + 1 + $tolerance;
				 }else{
					 $UseAutoNum = $AutoNumStart + $tolerance;
				 }
			 }
			 //format UseAutoNum to have minimium of 2 digit
			 $UseAutoNumStr = $UseAutoNum."";
			 $len = strlen($UseAutoNumStr);
			 $rem = 3 - $len;
			 if($rem > 0){
				 $UseAutoNum = str_repeat("0",$rem).$UseAutoNum;
			 }
			 //Form the RegNo 
			 $NewRegNo = str_replace(array("?FAC?","?DEPT?","?PROG?","?SESNAME?","?SES?","?SCH?","?AUTONUM?"),array($FacAbbr,$DeptAbbr,$ProgAbbr,$SesName,$SesAbbr,$SchAbbr,$UseAutoNum),$RegoFormat);

		 }while(is_array($dbo->SelectFirstRow("studentinfo_tb","","(RegNo = '$NewRegNo' OR JambNo = '$NewRegNo') AND RegID = $RegID")));
		 //Update Student RegNo 
		 $dbo->Bigin();
		
		 //Update Student accesscode det 
		 $accescod = $dbo->Updatedbtb("accesscode_tb",array("JambNo" => $NewRegNo),"JambNo = '$RegNo' AND RegID = $RegID");
		 //update in course reg
			$coursereg = $dbo->Updatedbtb("coursereg_tb",array("RegNo" => $NewRegNo),"RegNo = '$RegNo'");
			//update in order 
			$order = $dbo->Updatedbtb("order_tb",array("RegNo" => $NewRegNo),"RegNo = '$RegNo'");
			//update in payment history
			$payhist = $dbo->Updatedbtb("payhistory_tb",array("RegNo" => $NewRegNo),"RegNo = '$RegNo'");
			//update in result tb
			$result = $dbo->Updatedbtb("result_tb",array("RegNo" => $NewRegNo),"RegNo = '$RegNo'");
			//update in screaning screening_tb
			$screening = $dbo->Updatedbtb("screening_tb",array("RegNo" => $NewRegNo),"RegNo = '$RegNo'");

			$passp = trim($StudDet['Passport']);
			$newpassp = $passp;
			$rname = true;
            if($passp != ""){
				$passp = ResolvePassport($passp);
				$passp = explode("?",$passp);
				$passp = $passp[0];
				$passpu = "../../".$passp;
				//echo $passpu;
				if(file_exists($passpu)){
					$pregNo = str_replace("/","_",$NewRegNo);
					$patharr = explode("/",$passp);
					$names = array_pop($patharr);
					$newpassp = implode("/",$patharr)."/".$pregNo.".jpg";
					
					$newpasspu = "../../".$newpassp;
					$rname = rename($passpu,$newpasspu);
				}
			}
			 //Update Student student det 
		 $studreg = $dbo->Updatedbtb("studentinfo_tb",array("RegNo" => $NewRegNo,"AutoNum" => $UseAutoNum, "Passport"=>$newpassp,"AutoGenReg" => "TRUE"),"JambNo = '$RegNo' AND RegID = $RegID");
			if(!is_array($coursereg) || !is_array($order)  || !is_array($payhist)  || !is_array($result)  || !is_array($screening)  || !is_array($studreg)  || !is_array($accescod) || $rname == false){
				
		        $dbo->Rollback();
		        return "#####"; //Error Updating generated RegNo
			}else{
                $dbo->Commit();
				return array($NewRegNo,$newpassp);
				//$totupdate += $coursereg[1] + $order[1] + $payhist[1] + $result[1] + $screening[1];
			}
	  }else{
		  return "####"; //Already Has a RegNo
	  }
	}else{
		return "###"; //student not exist
	}
   }else{//cannot get school deteails
      return "#";
   }
}


//function to load a staff courses in cportal result upload
function LoadStaffCourses($loadcond,$ses = NULL,$showdept = false){
	//extract($_POST);
	global $dbo;
	if(!isset($ses) || is_null($ses)){
		$curses = CurrentSes();
		$ses = $curses['SesID'];
	}
	//$loadcond = !isset($loadcond)?"c.Lvl = " .$lvl." AND c.Sem = ".$sem." AND c.DeptID = ".$dept." AND c.StudyID = ".$stid:
if(isset($loadcond)){
    $courses = $dbo->Select("course_tb c,fac_tb f, dept_tb d, study_tb s, session_tb se, programme_tb p, schoollevel_tb l, semester_tb sem","c.CourseCode,c.Title,c.CH,c.CourseID,c.StudyID,c.Lvl,c.Sem,c.DeptID, p.ProgName, s.Name, se.SesID, se.SesName,f.FacID, f.FacName, d.DeptID as Dept, d.DeptName,l.Name as Level,sem.Sem as Semester,p.Abbr","(".$loadcond.") AND f.FacID = d.FacID AND d.DeptID = p.DeptID AND p.ProgID = c.DeptID AND c.Lvl = l.Level AND l.SchoolTypeID = (select Type from school_tb limit 1) AND l.StudyID = c.StudyID AND se.SesID = $ses AND sem.ID = c.Sem AND s.ID = c.StudyID");
	//echo "course_tb c,fac_tb f, dept_tb d, study_tb s, session_tb se, programme_tb p, schoollevel_tb l, semester_tb sem","c.CourseCode,c.Title,c.CH,c.CourseID,c.StudyID,c.Lvl,c.Sem,c.DeptID, p.ProgName, s.Name, se.SesID, se.SesName,f.FacID, f.FacName, d.DeptID as Dept, d.DeptName,l.Name as Level,sem.Sem as Semester",$loadcond." AND f.FacID = d.FacID AND d.DeptID = p.DeptID AND p.ProgID = c.DeptID AND c.Lvl = l.Level AND l.SchoolTypeID = (select Type from school_tb limit 1) AND l.StudyID = c.StudyID AND se.SesID = $ses AND sem.ID = c.Sem AND s.ID = c.StudyID";
	//return;
    if(is_array($courses)){
       if($courses[1] > 0){
           Table("rowselect=true,style=width:250px;font-size:0.7em;margin:auto,id=coursetb,onselect=Exams.ResultUpload.Load,onunselect=,multiselect=false,data-type=table");
             //$rtnstr .= __TRecord(array(""),"id=0");
			 if($showdept){
               THeader(array("DEPT","CODE","TITLE","CH"));
			 }else{
               THeader(array("CODE","TITLE","CH"));
			 }
             
          while($course = $courses[0]->fetch_array()){
              $trid = $course['CourseID'];
			  if($showdept){
                 //$course['ProgName']
				 TRecord(array($course['Abbr'],str_replace(" ","&nbsp;",$course[0]),'<div style="text-align:left">'.$course[1].'</div>',$course[2]),"data-id={$trid}");
			  }else{
             TRecord(array(str_replace(" ","&nbsp;",$course[0]),'<div style="text-align:left">'.$course[1].'</div>',$course[2]),"data-id={$trid}");//"data-id=$reglw"
			  }
             //get fac and dept det 
             //$facDept = $dbo->SelectFirstRow("fac_tb f, dept_tb d, programme_tb p","f.FacID,f.FacName,d.DeptID,d.DeptName,p.ProgID,p.ProgName","f.DeptID = d.DeptID and p.DepID = d.DeptID and p.ProgID = ".$course['DeptID']);
             $SesID = $course['SesID'];$SesName = rawurlencode($course['SesName']);$StudyID = $course['StudyID'];$StudyName = rawurlencode($course['Name']);$FacID = $course['FacID'];$FacName = rawurlencode($course['FacName']);$DeptID = $course['Dept'];$DeptName = rawurlencode($course['DeptName']);$ProgName = rawurlencode($course['ProgName']);$LvlName = rawurlencode($course['Level']);$Lvl = $course['Lvl'];$SemID = $course['Sem'];$SemName = rawurlencode($course['Semester']);$ProgID = $course['DeptID'];
             Hidden($trid."_det","rstudstudy=$StudyID:$StudyName&rstudfac=$FacID:$FacName&rstuddept=$DeptID:$DeptName&rstudprog=$ProgID:$ProgName&rstudlvl=$Lvl:$LvlName&semest=$SemID:$SemName");
          }
          _Table();
       }else{
          Icon("exclamation-triangle");
        echo " NO COURSE FOUND";  
       }
    }else{
        Icon("exclamation-triangle");
    echo " INTERNAL ERROR: CANNOT LOAD COURSES "; 
    }
}else{
    Icon("exclamation-triangle");
    echo " INVALID SELECTION";
}
}

//function to load the style sheet for printing
function PrintStyle(){
$style = <<<sss
<style type="text/css"  >
.topic{
	/*background:#999999;*/
	text-align:center;
	font-size:1.2em;
	font-weight:600;
	border-bottom:#CCCCCC solid 2px;
	text-transform:uppercase;	
}

.title, .value{
	font-weight:600;
	width:50%;
}
.value{
	font-weight:normal;
}
table{
	width:95%; margin:auto; border-collapse:collapse; margin-top:15px;align:center; font-weight:500;
}

tr,td,th{
	border:#D5D5D5 thin solid;
	
	padding:5px;
	
}
th{text-transform:uppercase; text-align:center;background-color:rgba(0,0,0,.06);
	}
.err{
   background-color:rgba(0,0,0,.06);
	}

.inv{
   color:#555;
	}

td.title{
	padding-left:20px;
	vertical-align:top;
	text-align:start;
	
}
#passp{
	width:200px;
	height:200px;
	display:block;
	margin-left:auto;
	margin-right:auto;
	margin-bottom:15px;
	margin-top:8px;
	border:#CCCCCC solid thin;	
}

.linebottom{
	border-bottom:#CCCCCC solid 2px;
}

.secondColor{
	color:;
}

body{
	font-family:"Segoe UI Light","Segoe UI" ;
	font-weight:lighter;
	margin:0px;
	padding:0px;
	margin-bottom:50px;
	
	background-color:;
	font-size:0.8em;
}

#TitleDiv{
	width:100%;
	height:auto;
	margin-top:0px;
}

#TitleDiv #InnerDiv{
	min-width:100px;
	width:auto;
	margin:auto;
	height:auto;
	background-color:;	
	
}

#TitleDiv #InnerDiv img{
	display:block;
	width:150px;
	height:150px;
	background-color:;
	margin:auto;
}

#TitleDiv #InnerDiv #TitleBox{
	display:block;
	background-color:;
	text-align:center;
}

#TitleDiv #InnerDiv #TitleBox #SchoolName{
	font-size:1.5em;
	text-transform:uppercase;
	font-weight:normal;
}

#TitleDiv #InnerDiv #TitleBox #SchoolAddress{
	font-size:1.2em;
	
	
}

#TitleDiv #InnerDiv #TitleBox #payTitle{
	font-size:1.3em;
	text-transform:uppercase;
	font-weight:normal;
}

.InfoDiv, #AnalDiv{
	width:calc(95% - 20px);
	margin:auto;
	border:#D5D5D5 thin solid;
	background:rgba(0,0,0,.06);
	margin-top:10px;
	height:auto;
	border-radius:0px;
	font-size:1em;
	padding:10px;
	font-weight:normal;
	overflow:hidden;
}

.InfoDiv .detailSide{
	width:60%;
	float:left;
}

.InfoDiv #passp{
	width:170px;
	height:170px;
	float:right;
	
	background-color:;
	margin:7px;
}

.InfoDiv #passp img{
	width:inherit;
	height:inherit;
}

#AnalDiv{
	background:none;
}

.InfoDiv .IndItem, .IndItemHeader{
	width:100%;
	height:auto;
	padding-top:4px;
	padding-bottom:4px;
	border-bottom:#D5D5D5 thin solid;
}
.IndItemHeader{
  border-bottom:#AAA 2px solid;
  background-color:rgba(255,255,255,.01);
  text-align:center;
  text-transform:uppercase;
  font-weight:bold;
}

.InfoDiv .IndItem .itemname{
	width:35%;
	text-indent:10px;
	display: inline-block;
	vertical-align:middle;
	text-transform:uppercase;
}

.InfoDiv .IndItem .itemvalue{
	width:60%;
	margin-left:10px;
	display: inline-block;
	vertical-align:middle;
	font-weight:600;
	text-transform:uppercase;
}

#AnalDiv{
	border-collapse:collapse;
	/*border:inherit;*/
	
}

#AnalDiv th{
	text-align:center
}

#AnalDiv td{
	text-indent:10px
}

#AnalDiv strong{
	font-weight:bolder;
}

.errl{margin-top:30px; text-align:center; font-size:2.5em;	
}
body{
font-family: 'Segoe UI Light', 'Segoe UI Semilight', 'Segoe UI Semibold', 'Segoe UI', 'Eras Light ITC', Calibri
	}
.bx{
    display:inline-block;border:#D5D5D5 thin solid;
	background-color:rgba(255,255,255,.7);margin-right:10px; vertical-align:top
	}
</style>
sss;
echo $style;
}

//function to display info on slip
function PrintInfoBox(){
	echo "<div class=\"InfoDiv\">";
}
function _PrintInfoBox(){
	echo "</div>";
}

function PrintInfo($title,$value){
	echo "<div class=\"IndItem\" >";
	echo "<div class=\"itemname\" >$title</div>";
	echo "<div class=\"itemvalue\" >$value</div>";
	echo "</div>";
}

function PrintInfoTitle($title){
	echo "<div class=\"IndItemHeader\" >";
	echo $title;
	echo "</div>";
}

function PrintBox($size = 4){
	$size = floor($size * 25) - 2;
	echo "<div class=\"bx\" style=\"width:{$size}%\">";
}
function _PrintBox(){
	echo "</div>";
}

//function to get print header 
function PrintHeader($title,$school){
$school = !isset($school)?GetSchool():$school;
$logo = _CONFIGDIR_.$school['logo'];
$abbr = $school['Abbr'];
$nm = $school['Name'];
$shtabbr = $school['ShortAddr'];
$header = <<<sss
<div id="TitleDiv">
   <div id="InnerDiv">
      <img src="{$logo}" name="SchoolImg" alt="{$abbr}"  />
      <div id="TitleBox">
        <div id="SchoolName">{$nm}</div>
         <div id="SchoolAddress">{$shtabbr}</div>
         <div id="payTitle">{$title}</div>
      </div>
   </div>
</div>
sss;
echo $header;
}

//function to load the resultinfo
function LoadResultAppr($deptCond,$limit = 500,$searchval = "",$filter = 0){
	//echo "sss";
	 global $dbo;
	 global $UID;
	 $searchvalp = $searchval;
	 $filterCond = "";
	 if($filter == 1){
       //approved only 
	   $filterCond = "AND ra.Status='TRUE'";
	 }else if($filter == 2){
		$filterCond = "AND ra.Status='FALSE'"; 
	 }
          $dump = array();
          //get the result info 
          $rstinfos = $dbo->Select("resultapprove_tb ra, fac_tb f, dept_tb d, programme_tb p, course_tb c, session_tb s, study_tb st, schoollevel_tb l,semester_tb se","ra.*,f.FacID,d.DeptID,s.SesName,st.Name as StudyName,f.FacName,d.DeptName,p.ProgName,l.Name as LvlName,se.Sem as Semester, CONCAT(c.Title,' (',c.CourseCode,')') as CourseName, ra.ID as RSID",$deptCond." AND f.FacID = d.FacID AND d.DeptID = p.DeptID AND p.ProgID = ra.ProgID AND ra.CourseID = c.CourseID AND ra.Ses = s.SesID AND st.ID = ra.StudyID AND st.SchoolType = (Select Type from school_tb limit 1) AND l.Level = ra.Lvl AND l.SchoolTypeID = st.SchoolType AND l.StudyID = st.ID AND se.ID = ra.Sem $filterCond ORDER BY ra.ID DESC LIMIT $limit");
		  //echo "resultapprove_tb ra, fac_tb f, dept_tb d, programme_tb p, course_tb c, session_tb s, study_tb st, schoollevel_tb l,semester_tb se","ra.*,f.FacID,d.DeptID,s.SesName,st.Name as StudyName,f.FacName,d.DeptName,p.ProgName,l.Name as LvlName,se.Sem as Semester, CONCAT(c.Title,' (',c.CourseCode,')') as CourseName, ra.ID as RSID",$deptCond." AND f.FacID = d.FacID AND d.DeptID = p.DeptID AND p.ProgID = ra.ProgID AND ra.CourseID = c.CourseID AND ra.Ses = s.SesID AND st.ID = ra.StudyID AND st.SchoolType = (Select Type from school_tb limit 1) AND l.Level = ra.Lvl AND l.SchoolTypeID = st.SchoolType AND l.StudyID = st.ID AND se.ID = ra.Sem ORDER BY ra.ID DESC LIMIT $limit";
          // echo "resultapprove_tb ra, fac_tb f, dept_tb d, programme_tb p","ra.*,f.FacID,d.DeptID","(".$deptCond.") AND f.FacID = d.FacID AND d.DeptID = p.DeptID AND p.ProgID = ra.ProgID ORDER BY ra.ID DESC LIMIT 500";
          if(is_array($rstinfos)){
            if($rstinfos[1] > 0){
              //( [rstudstudy] => 5 [rstudfac] => 1 [rstuddept] => 3 [rstudprog] => 3 [rstudlvl] => 1 [semest] => 1 [sestb] => 1 [rcourse] => 1 )
              while($rstinfo = $rstinfos[0]->fetch_array()){
                $rstinfo['Status'] = $rstinfo['Status'] == "TRUE"?1:0;
				$fieldarr = array("SesName","StudyName","FacName","DeptName","ProgName","LvlName","Semester","CourseName","RSID","Status");
				$rw = array();
				$searchval = strtolower($searchval);
				$searchvalarr = explode(" ",$searchval);
				//$replarr = array();
				
				 // $replarr[] = '<strong class="altColor">'.strip_tags($searcc).'</strong>';	
				//}
				foreach($fieldarr as $fieldName){
					
					$strdis = strtolower($rstinfo[$fieldName]);
					foreach($searchvalarr as $searcc){
						if(strpos($strdis,$searcc) !== false){
                            $strdis = str_replace($searcc,'<strong class="altColor">'.strip_tags($searcc).'</strong>',$strdis);
							break;
						}
					}
                  $rw[] = $strdis;
				}
				//$rw[] =  $status;
				$rw["logo"] =  "*print";
				$rw["info"] =  "View/Print";
				$rw["Action"] =  "Exams.Approval.View('rstudstudy=".$rstinfo['StudyID']."&rstudfac=".$rstinfo['FacID']."&rstuddept=".$rstinfo['DeptID']."&rstudprog=".$rstinfo['ProgID']."&rstudlvl=".$rstinfo['Lvl']."&semest=".$rstinfo['Sem']."&sestb=".$rstinfo['Ses']."&rcourse=".$rstinfo['CourseID']."')";
                //$dump[] = array($rstinfo['SesName'],$rstinfo['StudyName'],$rstinfo['FacName'],$rstinfo['DeptName'],$rstinfo['ProgName'],$rstinfo['LvlName'],$rstinfo['Semester'],$rstinfo['CourseName'],$rstinfo['RSID'],$status,"logo"=>"*eye","info"=>"View/Print","Action"=>"Exams.Approval.View('rstudstudy=".$rstinfo['StudyID']."&rstudfac=".$rstinfo['FacID']."&rstuddept=".$rstinfo['DeptID']."&rstudprog=".$rstinfo['ProgID']."&rstudlvl=".$rstinfo['Lvl']."&semest=".$rstinfo['Sem']."&sestb=".$rstinfo['Ses']."&rcourse=".$rstinfo['CourseID']."')");
				$dump[] = $rw;
              }
            }
          }
          if(count($dump) > 0){
           $header=array("*Sesap"=>"SESSION",
           "*StudyIDap"=>"STUDY TYPE",
            "*Facap"=>"FACULTY",
               "*Deptap"=>"DEPARTMENT",
               "*ProgIDap"=>"PROGRAMME",
               "*Lvlap"=>"LEVEL",
               "*Semap"=>"SEMESTER",
               "*Coursesap"=>"COURSE",
               "*Rsid"=>"RSID",
               "*Rstappr"=>array("APPROVED","YES|NO")
           );
           SpreadSheet("rowselect=false,style=width:calc(100% - 12px);margin:auto;margin-top:6px;margin-bottom:6px,id=rstapprssb,multiselect=false,cellfocus=,cellblur=,cellkeypress=,dynamiccolumn=false,dynamicrow=false,minrow=-1,readonly=Sesap;StudyIDap;Facap;Deptap;ProgIDap;Lvlap;Semap;Coursesap;Rsid,trimtext=<strong class=\"altColor\">;</strong>;<strong class=\"altcolor\">",$header,$dump);
		    Hidden("paramrstapp","UID=$UID&limit=$limit&val=$searchvalp&filter=$filter");
          }else{
            Info("EMPTY SET","No Result Found");
          }
}
//function to get all course less than the sent level in a particular Prog
function GetCourses($ProgID=0,$MaxLvl = 20,$MaxSem = 2){
	
    $rtn = array();
	$ProgID = $ProgID > 0?"DeptID = $ProgID":"1=1";
	$current = array();
	$old = array();
    global $dbo;
	$course = $dbo->RunQuery("SELECT * FROM course_tb WHERE (Lvl < $MaxLvl OR (Lvl = $MaxLvl AND Sem <= $MaxSem)) AND $ProgID");
	//return "SELECT * FROM course_tb WHERE (Lvl < $MaxLvl OR (Lvl = $MaxLvl AND Sem <= $MaxSem)) AND $ProgI
	if(is_array($course)){//if no error
	//return $course[1];
	//exit();
      if($course[1] > 0){
		  while($indcourse = $course[0]->fetch_array()){
			  if($indcourse['Lvl'] == $MaxLvl && $indcourse['Sem'] == $MaxSem){ //added '&& (int)$indcourse['Former'] < 1' to also check if course is not old course else add to old array(created above) 22-5-17 #2
			  if((int)$indcourse['Former'] < 1){
               $current[$indcourse['CourseID']] = $indcourse;
			  }else{
               $old[$indcourse['CourseID']] = $indcourse;
			  }
				  
			  }
			  $rtn[$indcourse['CourseID']] = $indcourse;
		  }
	  }
	}
	$rtn['Current'] = $current;
	$rtn['Old'] = $old;
	return $rtn;
}

//function to get the immediate priv result 
function GetPrevResult($RegNo,$CurLvl,$CurSem){
	global $dbo;
	$RegNo = $dbo->SqlSafe($RegNo);
	$Rst = null;$Lvl=$CurLvl;$Sem=$CurSem;
	do{
		$prevLvlSem = GetPrevLvlSem($Lvl,$Sem); //get immediate prev lvl and sem
		if($prevLvlSem['err'] != ""){ //if not found stop loop
			break;
		}
		$Lvl = $prevLvlSem['level'];
		$Sem = $prevLvlSem['semester'];
       $Rst = $dbo->SelectFirstRow("result_tb","","RegNo = '$RegNo' AND Lvl = $Lvl AND Sem = $Sem ORDER BY ID DESC LIMIT 1");
	}while(!is_array($Rst));
	return $Rst;
}

//function to get the student current session 
function StudSes($RegNo="",$Lvl=1,$startSes=0,$modeEntry =0){
	global $dbo;
	$RegNo = $dbo->SqlSafe($RegNo);
	//return 1 . "";
	if($startSes == 0 || $modeEntry == 0){
      $studDet = $dbo->SelectFirstRow("studentinfo_tb","StartSes, ModeOfEntry","RegNo='$RegNo' OR JambNo = '$RegNo' LIMIT 1");
	  if(is_array($studDet)){ //if student details exist
        $startSes = (int)$studDet[0];
		$modeEntry = GetMOEID($studDet[1]);
		//return $startSes . " = ".$modeEntry;
	  }else{//invalid student 
        return 0;
	  }
	}
	//($lvl - $studModeofEn) + $startses = $currSesID;
	
	$curses = ($Lvl - $modeEntry) + $startSes;
	$currSesN = CurrentSes();
	   $currSesID = (int)$currSesN['SesID'];
	  $curses = $curses > $currSesID?$currSesID:$curses;
	return $curses < 1?"0":$curses."";
}

//function to log Payment (11/5/2017)
function LogPayment($PayDes,$Message,$Type){
  global $dbo;
  //get the payment in log if exist
  /*$paym = $dbo->SelectFirstRow("paymentlog_tb","","Description='".$dbo->SqlSafe($PayDes)."' AND Type='".$dbo->SqlSafe($Type)."'");
  if(is_array($paym)){//update counter and message

  }*/
  //echo $PayDes;
  if(trim($PayDes) == "")return false;
  
  $ins = $dbo->Insert("paymentlog_tb",array("Description"=>$PayDes,"Message"=>$Message,"Type"=>$Type));
  
  if($ins == "#"){
	  return true;
  }else{
	  return false;
  }
}
?>