<?php
error_reporting(0);
//updated 2-7-19
include('../../includes/connect.php');
include('../../functions/function.php');

								$cand_id=mysqli_real_escape_string($con,(trim($_POST['cand_id'])));
							 	$med_recom=mysqli_real_escape_string($con,(trim($_POST['med_recom']))); 
								$med_reason=mysqli_real_escape_string($con,(trim($_POST['med_reason'])));
								$regno=mysqli_real_escape_string($con,(trim($_POST['regno'])));
								$score=mysqli_real_escape_string($con,(trim($_POST['score'])));
								$dpt=mysqli_real_escape_string($con,(trim($_POST['dept'])));
								$cand_phone=mysqli_real_escape_string($con,(trim($_POST['cand_phone'])));
								$cand_name=mysqli_real_escape_string($con,(trim($_POST['cand_name'])));
								$cand_email=mysqli_real_escape_string($con,(trim($_POST['cand_email'])));
								$VenueID=mysqli_real_escape_string($con,(trim($_POST['VenueID'])));
								
								 
									/*$cand_id=1;
									$panel_rec=1;
									$p_reason="";		
									$card=2;*/
								if(empty($med_reason) || $med_reason=="")
								{
									$fields=array('medical_rec' => $med_recom,'medical_reason' => "");
								}
								else
								{
									$fields=array('medical_rec' => $med_recom,'medical_reason' => $med_reason);
								}
									//echo $cand_id;
									$sqlupdate=Updatedbtb($con,'recommendation_tb',$fields,"id='$cand_id'");
									
								if($sqlupdate==true){
												$finaladmstatus=SetFinal($con,$cand_id,$regno,$cand_phone);
												getAllAdmissible($con,$regno,$score,$dpt);
												if($finaladmstatus==true){$admit=" completed";}else{$admit=" not";}
									echo"<div class=\"row\"><div class=\"alert alert-success col-lg-10 hidden-print\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> screening".$admit." sucessful !</strong></div></div>";

								}else{echo"<div class=\"row\"><div class=\"alert alert-danger col-lg-10\" style=\"margin-left:20px;\">
											  <strong><span class=\"glyphicon glyphicon-info-sign\"></span> error submitting screening status</strong></div></div>";}
				
				//fetch data for mail
				
				$slot = GetTimeslot($VenueID,$con);
				$Day = $slot['Day'];
				$PanelID = $slot['PanelID'];
				$Date = $slot['Date'];
				$Time = $slot['Time'];
				/////////////////////////
						 				
						// Import PHPMailer classes into the global namespace
						// These must be at the top of your script, not inside a function
						use PHPMailer\PHPMailer\PHPMailer;
						use PHPMailer\PHPMailer\Exception;

						// Load Composer's autoloader
						require '../../vendor/autoload.php';

						// Instantiation and passing `true` enables exceptions
						$mail = new PHPMailer(true);

						try {
							//Server settings
							$mail->SMTPDebug = 0;  
							
							$mail->isSMTP();
					/* 	$mail->Host = 'relay-hosting.secureserver.net';
						$mail->Port = 25;
						$mail->SMTPAuth = false;
						$mail->SMTPSecure = false;
 */
							// Enable verbose debug output
							$mail->isSMTP();                                            // Set mailer to use SMTP
							$mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
							$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
							$mail->Username   = 'ubonge80@gmail.com';                     // SMTP username
							$mail->Password   = 'imaobong';                               // SMTP password
							$mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
							$mail->Port       = 465;                                    // TCP port to connect to

							//Recipients
							//$cand_email = 'ubonge80@gmail.com';
							$cand_email = 'mfonisoasuquo@aksu.edu.ng';
							$mail->setFrom('ubonge80@gmail.com', 'Mailer');
							$mail->addAddress($cand_email, 'Joe User');     // Add a recipient
							//$mail->addAddress('ellen@example.com');               // Name is optional
							//$mail->addReplyTo('info@example.com', 'Information');
							//$mail->addCC('cc@example.com');
							//$mail->addBCC('bcc@example.com');

							// Attachments
							//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
							//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
							$mail->SMTPOptions = array(
										'ssl' => array(
											'verify_peer' => false,
											'verify_peer_name' => false,
											'allow_self_signed' => true
										)
									);
											
							$mail->AddEmbeddedImage('../../assets/img/logoban.png', 'logoimg', 'logoban.jpg');
								
							// Content
							$mail->isHTML(true);                                  // Set email format to HTML
							$mail->Subject = 'AKSU PUTME SCREENING ';
							$mail->Body    = "<img src=\"cid:logoimg\" /><br/><br/>Dear, ".$cand_name." You have successfully completed your screening process<br/>
												<p>Your Screening details are: </p>
												<ul>
												<li>Name: ".$cand_name."</li>
												<li>Phone: ". $cand_phone."</li>
												<li>Email: ". $cand_email."</li>
												<li>Panel: Panel ". $PanelID."</li>
												<li>Day: ".$Day."</li>
												<li>Time: ".$Time."</li>
												</ul>
												<p>KIndly visit http://www.aksu.edu.ng/putme-admission to check your admission status.Ensure your O-level is uploaded to the Jamb Portal to avoid delay in Admission.</p>";
							//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

							$mail->send();
							echo 'Message has been sent';
						} catch (Exception $e) {
							echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
						}				 
								
			?>