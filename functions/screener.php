<?php





function getscreenbydept($conn,$dept){

//pick all not admissible from recommendation tb

$getAllnonadm=getAllRecord($conn,"recommendation_tb","dept='$dept' AND ModeOfEntry=1  AND final_status=0","","");

while($rw= mysqli_fetch_assoc($getAllnonadm)){

    echo $JambNo=$rw['RegNo'];

    echo $id=$rw['id'];

    

    }

}
/******************************** */
function getscreenbYREG($conn,$REG){

    //pick all not admissible from recommendation tb
    
    $getAllnonadm=getAllRecord($conn,"recommendation_tb","RegNo='$REG'","","");
    
    $rw= mysqli_fetch_assoc($getAllnonadm);
    
         $JambNo=$rw['RegNo'];
    
         $id=$rw['id'];
    
        
    
        return $id;
    
    }
/******************************* */
function getar($conn,$dept){
    //pick all not admissible from recommendation tb
    $getAllnonadm=getAllRecord($conn,"pstudentinfo_tb_ar","dept='$dept' AND ModeOfEntry=1","","");
    while($rw= mysqli_fetch_assoc($getAllnonadm)){
       // echo $JambNo=$rw['RegNo'];
        echo $JambNo=$rw['JambNo'];
        echo $id=$rw['id'];
        
        }
    }
/***************************************************************** */

function candet($conn,$JambNo){

                $getAll=getAllRecord($conn,"pstudentinfo_tb_ar","JambNo='$JambNo'","","");

            $stdInfo = mysqli_fetch_array($getAll);



            $jambNo = $stdInfo['JambNo'];



            if(isset($jambNo) && $jambNo !=''){



                //$_SESSION['system_rec'] = '';



            // echo "Jamb number: ".$jambNo;

            $name = $stdInfo['SurName'] . ", ".  $stdInfo['FirstName']. " ".  $stdInfo['OtherNames'];

            $programme=$stdInfo['ProgID'];

            $jambScore = $stdInfo['JambAgg'];

             $modeOfEntry = $stdInfo['ModeOfEntry'];

            $UTMEsubjects=$stdInfo['JmbComb'] ;

            //$score=$stdInfo['JambAgg'] ;

           $olvl= $stdInfo['OlevelRst2'];



           /*  $OlevelResult = explode("###",$stdInfo['OlevelRst2']);



            $Olevel1 = explode("||",$OlevelResult[0]);



            if(count($OlevelResult)>1){



            $Olevel2 = explode("||",$OlevelResult[1]);



            } */



        }

        return array(

            'Score'=>$jambScore,

            'modeOfEntry'=>$modeOfEntry,

            'UTMEsubjects'=>$UTMEsubjects,

            'olevel'=>$olvl,

            'canddept'=>$programme



                  );

}// end of function get cand



function checkcandjamb($conn,$jambScore,$jambsubj,$programme,$jambNo){

    $sys_reason="";



    $score_check=checkjambAgg($conn,$jambScore,$programme); 

    if($score_check==0){

        $sys_score_status=0;

        //$sys_reason_score="Jamb Aggregate is below cutoff mark, ";

        //$sys_reason.=$sys_reason_score;

        //echo "<b style='color:red'>NOT-ADMISSIBLE</b>"; 

    }else{

        $sys_score_status=1;

    }



    $utme_req = Getutmerequire($conn,$programme);

	$Response_status = checkJamb($conn,$jambsubj,$utme_req,$programme,$jambNo );

//score error=45,subject error=55 both error=65 both ok=1

            if(($sys_score_status==0) && ($Response_status==0)){

                echo "!";

                    $status_code = 65;

                    $sys_reason="Incorect UTME subject combination and Jamb Aggregate is below cutoff.";

            }else if(($sys_score_status==0) && ($Response_status==1)){

                echo "@";

                $status_code = 45;

                $sys_reason="Jamb Aggregate is below cutoff.";

            }else if(($sys_score_status==1) && ($Response_status==0)){

                echo "#";

                $status_code = 55;

                $sys_reason="Incorrect UTME subject combination.";

            }else if(($sys_score_status==1) && ($Response_status==1)){

                echo "%";

                $status_code = 1;

                $sys_reason.="";

            }



             return array($status_code,$sys_reason);

}

/****************************************************************/

function check_waec($conn,$olvl,$programme,$jambNo,$allowAR){

    $sys_reason_waec="";

    if(empty($olvl)){

        //this is responsible 4 allowing AR to be admissible

                    if($allowAR=='ALLOW'){

                        $waec_adm_status=1;

                    }else if($allowAR=='DISALLOW'){

                        $waec_adm_status=0;

                    }

        //end of allow AR TO BE ADMISSIBLE

        

}else{

     if(checkAdmissibleStatus($conn, $olvl, $programme,$jambNo) >=5)

            {	$waec_adm_status=1;

               // echo "<b style='color:green;display:block;border-radius:2px;background-color:#efefef;'><li class='fa fa-check'></li> CANDIDATE'S O' LEVEL IS OK </b>"; 

                }

                else {

                $waec_adm_status=0;

               $sys_reason_waec="-Deficiency In O-level Subject-";

                //echo "<b style='color:red;display:block;border-radius:2px;background-color:#efefef;'> <li class='fa fa-remove'></li> ERROR! IN O'LEVEL SUBJECTS</b><br/>";

                

                }

    }



    return array($waec_adm_status,$sys_reason_waec);

}

/********************************************** */

function computeStatus($sys_reason_waec,$utmesys_reason,$waec_adm_status,$utmestatus_code){

    $systemreason="";

    if(($waec_adm_status==0) && ($utmestatus_code!=1)){

        echo "^";

		$error_code=11;

            $system=0;

            $systemreason=$sys_reason_waec.",".$utmesys_reason;



    }else if(($waec_adm_status==1) && ($utmestatus_code!=1)){

        echo "&";

		$error_code=21;

        $system=0;

        $systemreason=$utmesys_reason;

    }else if(($waec_adm_status==0) && ($utmestatus_code==1)){

        echo "(";

		$error_code=31;

        $system=0;

        $systemreason=$sys_reason_waec;

    }else if(($waec_adm_status==1) && ($utmestatus_code==1)){

        echo ")&";

		$error_code=41;

        $system=1;

        $systemreason="";

    }

    /*******check if system reason is set to avoid sending an empty array for admissible candidates********/

        

            return array(

                'system_reason'=>$systemreason,'system_status'=>$system,'code'=>$error_code

				);

        



}    



function implementstatus($conn,$jambNo,$sys_adm_status,$system_reason,$errorcode){



    if($errorcode!=41){

        $fields=array('RegNo' => $jambNo,'system_rec' => $sys_adm_status,'system_reason' => $system_reason);

    }else{

        $fields=array('RegNo' => $jambNo,'system_rec' => $sys_adm_status);

    }

    

    //echo"<br/>candidate already exist";

    $sqlupdate=Updatedbtb($conn,'recommendation_tb',$fields,"RegNo='$jambNo'");

   /*  if($sqlupdate=true){

        

        $st="<b style='font-family:monospace;color:green'>Screened</b><br/>";

    }else{

        $st="<b style='font-family:monospace;color:red'>Error Screening</b><br/>";

    }

return $st; */

}

function screen($conn,$score,$utmesubj,$canddept,$JambNo,$olvel,$allowAR){
    
    $allowAR = 'DISALLOW';
    ///////check jamb/////////
$utme_status=checkcandjamb($conn,$score,$utmesubj,$canddept,$JambNo);
  $utmestatuscode=$utme_status[0];
  $utmereason=$utme_status[1];
  ///////////check waec//////////
$waec_status=check_waec($conn,$olvel,$canddept,$JambNo,$allowAR);
  $waecstatuscode=$waec_status[0];
  $waecreason=$waec_status[1];
  ///////////compute status/////////
$computed_status=computeStatus($waecreason,$utmereason,$waecstatuscode,$utmestatuscode);
  if(is_array($computed_status)){
      $reason_to_db=$computed_status['system_reason'];
      $status_to_db=$computed_status['system_status'];
      $generatedcode=$computed_status['code'];

  
  //////implement the status as generated above////////////////
  $imp=implementstatus($conn,$JambNo,$status_to_db,$reason_to_db,$generatedcode);
  //echo $imp; 
    }  

  }
                   

 ?>

