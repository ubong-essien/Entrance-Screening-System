<br/><br/><br/><br/>
<?php
//error_reporting(0);
include('includes/header.php');
include('includes/connect.php');

$ch=getAllRecord($con,"coc","status='0'","","");
//var_dump($ch);
while($s=mysqli_fetch_array($ch)){
       $reg=$s['RegNo'];
        $dptss=$s['progID'];
        $score=$s['score'];
        $idd=$s['id'];

      $strr=Getcand_details($reg,$con);
      $st=mysqli_fetch_array($strr);
      $jmb= $st['JambNo'];
      $jmbagg=$st['JambAgg'];
       $dpt=$st['ProgID'];
       $id=$st['id'];
      
                            if($reg==$jmb ){
                                if($dpt !=$dptss){
                                    $fields=array('ProgID' => $dptss);
                                    $sqlupdate=Updatedbtb($con,'pstudentinfo_tb_ar',$fields,"id='$id'");

                                }
                                if($jmbagg==$score){
                                    $fields=array('JambAgg' => $score);
                                    $sqlupdate=Updatedbtb($con,'pstudentinfo_tb_ar',$fields,"id='$id'");
                                }

                        //        $sqlupdate=Updatedbtb($con,'pstudentinfo_tb_ar',$fields,"id='$id'");
                        $sta=1;
                         $f=array('status' => $sta);
                         $sqlupdate=Updatedbtb($con,'coc',$f,"id='$idd'");
       if($sqlupdate){
           echo "updated"."<br>";
       }else{echo "error"."<br>";}
                                
                        } 



    }