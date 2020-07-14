// Verify Page
//ajax object
//alert('putme');
AJTimeOut = 1*60*1000;
var Verify = new function(){
 this.VerifyAjax = null;
 
   this.Start = function(){
	   Verify.VerifyAjax = new Ajax(AJTimeOut);
	   //making sure that regno is uppercase
	   _('regNo').value = _('regNo').value.Trim().toUpperCase().Replace(" ",""); 
	var RegNo = _('regNo').value.Trim();
	Verify.Reset();
	if(RegNo == ""){
		MessageBox.ShowText("NO ENTRANCE NUMBER SUPPLIED","_('regNo').focus()");
	}else{
		var lo = _('verifybtn').StartLoading("Verifying ...");
		//alert(lo);
		if(lo == true){
			if(_('infoblock') == null){ //if verification is to be  done(STUDENT)
			
			var nm = ""; //send name as empty
			}else{
				//alert(_('infoblock').style.display);
				if(_('infoblock').style.maxHeight != "0px"){ //if other info box is displayed (i.e, user record has not been registered first
				/*alert(_('sname').Text() + "; " + _('fname').Text() + "; " +_('oname').Text()  + "; "+_('genders.i').Text()  + "; "+ _('facs.i').Text() + "; "+ _('depts.i').Text()+ "; "+ _('jambagg').Text());
				_('verifybtn').StopLoading();*/
				//return;
				if(_('sname').Text().Trim() == "" || _('fname').Text().Trim() == "" || _('jambagg').Text().Trim() == "" || _('depts.i').Text() == "0" || _('study.i').Text() == "0" || _('moes.i').Text() == "0"){ //valid entring
					MessageBox.ShowText("COMPLETE REQUIRED FIELDS <br /> Click CANCEL to Cancel Verification","_('sname').focus()","Verify.ClearInit()");
					_('verifybtn').StopLoading();
					return;
				}
				var t = "";
				if(_('teller') != null){
				  if((_('teller').style.display == "block" && _('teller').value.Trim() == "")){
					  MessageBox.ShowText("COMPLETE REQUIRED FIELDS","_('sname').focus()");
					_('verifybtn').StopLoading();
					return;
				  }
				   t = (_('bankpaid.i').Text() == "2")?"&teller="+_('teller').value.Trim():"";
				}
				
				var nm = "&name="+escape(_('sname').Text())+"~"+escape(_('fname').Text())+"~"+escape(_('oname').Text())+"&gender="+_('genders.i').Text()+"&dept="+_('depts.i').Text()+"&jamb="+_('jambagg').Text()+"&study="+_('study.i').Text()+"&moe="+_('moes.i').Text()+t; //form name(record) url string
				}else{ //if user is just to verify ordinary, even thou verification is NONE ( is to check if user has inputed data at least once)
					var nm = "&name=#";
				}
			}
			//alert(nm)
		Verify.VerifyAjax.PostResponse("regNo="+escape(RegNo)+nm,"Admin/PUTME/verifyResponse.php",function(res,url,param){
			/*alert(res);
			//return;
			if(res.Trim() != "##")return;*/
			/*if(res.Trim() == "####"){
			   MessageBox.ShowText("VALID TELLER NUMBER","_('teller').focus()");
				//Verify.ClearInit();
				_('teller').Text("");
				_('verifybtn').StopLoading();
			}else */
			if(res.Trim() == "###"){
			   MessageBox.ShowText("INVALID TELLER NUMBER","_('teller').focus()");
				//Verify.ClearInit();
				_('teller').Text("");
				_('verifybtn').StopLoading();
			}else if(res.Trim() == "#"){
				MessageBox.ShowText("INVALID CANDIDATE","_('regNo').focus()");
				Verify.ClearInit();
				_('verifybtn').StopLoading();
			
			}else if(res.Trim() == "##@"){
				MessageBox.ShowText("REGISTRATION CLOSED","_('regNo').focus()");
				Verify.ClearInit();
				_('verifybtn').StopLoading();
			}else if(res.Trim() == "#*"){
				MessageBox.ShowText("SERVER ERROR: Cannot save data","_('sname').focus()");
				//Verify.ClearInit();
				_('verifybtn').StopLoading();
				
			}else if(res.Trim() == "##"){
				MessageBox.ShowText("Please Confirm your "+"ENTRANCE"+' NUMBER: <span style="font-size:1.4em;text-transform:uppercase;font-weight:bolder">' + unescape(param['regNo']) + "</span>","Verify.ShowInit()","Verify.ClearInit()");
				_('verifybtn').StopLoading();
			}else{
				//alert(res);
				Verify.ClearInit();
				_('studDetails').innerHTML = res;
				_('verifybtn').StopLoading();
				_('studDetails').Animate({CSSRule:"opacity:1;margin-left:0px",Time:_NORMAL});
			}
			
			
			
		},"text",function(res,url,param){
			MessageBox.ShowText("SERVER ERROR: "+res.toUpperCase(),"_('regNo').focus()");
			    //Verify.ClearInit();
				_('verifybtn').StopLoading();
			
		});
		}
	}
  }
  
  //function to show intial details form 
  this.ShowInit = function(){
	  //alert('ss');
	  _('infoblock').style.overflow='hidden';
	   _('infoblock').Animate({CSSRule:"max-height:350px;opacity:1", Time:1000, EndAction:"_('infoblock').style.overflow='auto'"});
	   _('sname').focus();
	   _('regNo').disabled  = true;
	   _('cancelreg').Show();
  }
  
     //function to clear initial details
  this.ClearInit = function(){
	  if(_('infoblock') != null){
	  _('infoblock').style.overflow='hidden';
	  	  if(_('infoblock') != null){
			  //_('infoblock').Hide();
			  _('infoblock').Animate({CSSRule:"max-height:0px;opacity:0", Time:500});
		  _('fname','sname','oname','jambagg').Text("");
		  
	  }
	  }
	   _('regNo').disabled = false;
	  _('regNo').focus();
	  _('cancelreg').Hide();
  }
 
 this.ShowTeller = function(input){
	 var status = input.value;
	 _('teller').value = "";
	 if(status == "1"){
		 
		 _('teller_cont').Hide();
	 }else{
		 _('teller_cont').Show();
	 }
 }
 
 
 
 

/*  
  //function to clear initial details
  this.ClearInit = function(){
	  	  if(_('infoblock') != null){
			  _('infoblock').Hide();
		  _('fname','sname','oname','jambagg').Text("");
		  
	  }
  }*/
  
  //function to reset the verified details
  this.Reset = function(){
	 _('studDetails').SetStyle("opacity:0;margin-left:10px");
	 if(_('payStatus') != null){
		_('payStatus').value = ""; 
	 }
	 
	 if(_('regStatus') != null){
		_('regStatus').value = ""; 
	 }
	 _('vuserpassport').value = "";
	 _('vphone').value = "";
	 _('vaddress').value = "";
	 _('vemail').value = "";
  }
  
  this.inputKeyup = function(e){
	  if(e.keyCode == 13){
		// _('verifyform').submit(); 
	  }else{
		 //Verify.Reset(); 
	  }
	  //_('infoblock').Hide();
  }
  
  this.Validate = function(){
	  var ver = true;
	  if(_('closeStatus') != null){
		 var clos = _('closeStatus').value; 
		 //alert(clos);
		 if(clos.ToNumber() == 1){
			return "REGISTRATION CLOSED"; 
		 }
	  }
	   if(_('payStatus') != null ){
		var pay = _('payStatus').value;
		//alert(pay);
		if(pay == "0"){
			return "PAYMENT NOT MADE";
		}else if(pay.Trim() == ""){
			return "No Payment Details Found";
		}else if(pay == "-1"){
			
		}
	 }else{
		 return "No Verification Details Found";
	 }
	 
	 if(_('regStatus') != null){
		 var reg = _('regStatus').value;
		if(reg == "-1"){
			return "Registration NOT allowed".toUpperCase();
		}else if(reg.Trim() == ""){
			return "No Registration Details Found";
		}else if(reg == "6"){
			return "You are a Registered Student";
		}
	 }else{
		 return "No Verification Details Found";
	 }
	 return ver;
  }

}

//check result
var Result = new function(){
	this.Ajax = new Ajax(AJTimeOut);
  this.Check = function(){
	  var lo = _('crstbtn').StartLoading("Checking ...");
	  if(lo == true){
	   _('rstDetails').Animate({CSSRule:"opacity:0;margin-left:10px",Time:_NORMAL});
	  var regNo = Cookie.Get('LoginName');
	  Result.Ajax.PostResponse("regNo="+escape(regNo),"Admin/PUTME/checkRstResponse.php",
	  function(res,url,param){
		 if(res == "#"){
			  MessageBox.ShowText("INVALID JAMB NUMBER SUPPLIED","");
			  _('crstbtn').StopLoading();
		  }else if(res.substr(0,1) == "#"){
			  var compl = res.TrimLeft("#");
			  compl = (compl.Trim() == "")?"":"<br /> Send your complaint to "+compl;
			  MessageBox.ShowText("NO RESULT FOUND"+compl,"");
			  _('crstbtn').StopLoading();
		  }else{
			_('rstDetails').innerHTML = res;
			  _('rstDetails').Animate({CSSRule:"opacity:1;margin-left:0px",Time:_NORMAL});
			  _('crstbtn').StopLoading();  
		  }
	  },"text",function(res,url,param){MessageBox.ShowText("SERVER ERROR: "+res.toUpperCase(),"");_('crstbtn').StopLoading();});
	  }
  }
	
}

//set validation function
WizardPageCheck['Admin/PUTME/verify.php'] = Verify.Validate;


//Register Page
var PRegister = new function(){
	this.RegAjax = new Ajax(AJTimeOut);
	this.Loader = new FileUpload(300000,"../epconfig/UserImages/PUTME/","jpg");
	//upload passport
	this.Upload = function(regNo){
		_('passploading').Appear();
		regNo = regNo.Replace("/","_");
		/*_('userpassp').src = 'Resource/Images/userbig.jpg';
		_('userpassport').value = '';*/
		PRegister.Loader.rootfolder = _DATA.Data("sub-domain");
		PRegister.Loader.Upload(regNo,PRegister.UploadFinish,"Admin/fileuploadbridge.php");
		
		
	}
	//image laoder object
	this.PLoader = new ImageLoader(false);
	//this.CurrentLoadPath = ""; //hold the current uploaded image path
  //end function for passport upload
  this.UploadFinish = function(path){
	  var patharr = path.split('~');
	  if(patharr[0].Trim() == '0'){
		  MessageBox.ShowText(patharr[2].toUpperCase(),'');
		  _('passploading').Disappear()
	  }else{
		 // patharr[1] = patharr[1].Replace("../epconfig",TaquaLoader.b);
		  _('userpassport').value = patharr[1]+"?"+new Date().getTime();
		 // PRegister.CurrentLoadPath = 
		  //alert(_('userpassp').src);Resource/Images/userbig.jpg
	  //_('userpassp').src = 'Resource/Images/userbig.jpg';
	// alert(patharr[1]);
	//alert(TaquaLoader.b);
	_('userpassp').src = _('userpassport').value.Replace("../epconfig",TaquaLoader.b);
	_('userpassp').onload = function(){_('passploading').Disappear();_('title').Text(Main.SchoolName)}
	 // PRegister.PLoader.Load({image:_('userpassport').value,onload:function(img){_('userpassp').src = _('userpassport').value;_('passploading').Disappear();_('title').Text(Main.SchoolName)}});
	  }
  }
  
  this.Submit = function(){
	  //alert('aaa');
	  /*alert(Wizard.GetInputs());
	  return;*/
	  var pasload = _('passploading');
	  if(pasload != null){
		  if(pasload.style.visibility == "visible"){
			  MessageBox.ShowText("OPERATION TERMINATED: LOADING PASSPORT PHOTOGRAPH","");
			  return;
		  }
	  }
	  if(_('phone').value.Trim() == "" || IsPhoneNumber(_('phone').value) == false){
		  MessageBox.ShowText("INVALID <b style=\"font-weight:bolder; color:#CC3300\">PHONE NUMBER</b> SUPPLIED","");
		  return;
	  }
	  
	  if(_('email').value.Trim() == "" || IsEmail(_('email').value) == false){
		 MessageBox.ShowText("INVALID <b style=\"font-weight:bolder; color:#CC3300\">EMAIL ADDRESS</b> SUPPLIED","");
		  return; 
	  }
	  
	  
	  if(_('userpassport').value.Trim() == "" || _('userpassport').value.Trim() == "Resource/Images/userbig.jpg"){
		 MessageBox.ShowText("SELECT YOUR <b style=\"font-weight:bolder; color:#CC3300\">PASSPORT PHOTOGRAPH</b> <br /> Select by Double-Clicking the Passport Viewer.","");
		  return; 
	  }
	  
	  //subjcomb
	  if(_('subjcomb.i') != null){
		if(_('subjcomb.i').value.Trim() == "" || _('subjcomb.i').value.Trim() == "0"){
		   MessageBox.ShowText("SELECT A <b style=\"font-weight:bolder; color:#CC3300\">SUBJECT COMBINATION</b>","");
		   return; 
		}
	  }
	  //making sure that the regno is uppercase
	  
	  var fl = _('pregsubmit').StartLoading("Submitting...");
	  if(fl){
		_("navbtn").Hide();  
	  var data = Wizard.GetInputs();
	 
	  PRegister.RegAjax.PostResponse(data,"Admin/PUTME/submit.php",function(res,url,param){
			//alert(res);
			if(res.substr(0,1) == "#"){
				MessageBox.ShowText("Server Error "+ res,"");
			  _('pregsubmit').StopLoading();
			  _("navbtn").Show();
			}else{
				//alert(res);
				resarr = res.split("~");
				//if(resarr.length == 6){
			    var info = '<strong style="font-weight:bolder;"><span style="font-size:1.0em"> '+'check fa-2x'.Icon()+'</span> PUTME REGISTRATION SUCCESSFUL</strong> <br />Registration Number: '+resarr[0].toUpperCase()+' <br />Access Code: <strong style="font-weight:bolder;">'+resarr[2]+'</strong>';	
				resarr[0] = resarr[0].Trim();
				MessageBox.ShowText(info,null,"","#PRegister.PrintSlip('"+escape(resarr[0])+"',MessageBox.Loading,MessageBox.Close)");
				_('prev').click();
				//}
			}
			
		},"text",function(res,url,param){
			MessageBox.ShowText("SERVER ERROR: "+res.toUpperCase(),"");
				_('pregsubmit').StopLoading();
				_("navbtn").Show();
			
		});
	  //MessageBox.Show('Admin/PUTME/mesSuccess.php','');
	  }
  }
  
 
  //function to print putme slip
  this.PrintSlip = function(RegNo,StartFunc,EndFunc){
	  /*StartFunc = (typeof StartFunc == "undefined")?function(){}:StartFunc;
	  EndFunc = (typeof EndFunc == "undefined")?function(){}:EndFunc;
	  StartFunc("Proccessing ...");*/
	  if(_('reprSlip') != null && StartFunc == null){
	  _('reprSlip').StartLoadingsm();
	  EndFunc = function(){ if(_('reprSlip') != null)_('reprSlip').StopLoadingsm();}
	  }else{
		 StartFunc = (typeof StartFunc == "undefined")?function(){}:StartFunc;
	     EndFunc = (typeof EndFunc == "undefined")?function(){}:EndFunc;
	     StartFunc("Proccessing ..."); 
	  }
	  var pr = new Printer();
	 // pr.Print("Admin/PUTME/Slip.php?RegNo="+escape(RegNo),EndFunc);
	 pr.Preview("Entrance Print Slip","Admin/Slip.php?folder=PUTME&RegNo="+escape(RegNo),EndFunc);
	  
  }
  
  
  

}

var PUTME = new function(){
	  //function to print putme result
  this.PrintResult = function(RegNo){
	  var lo = _('rprintbtn').StartLoadingsm();
	  if(lo == true){
	 var pr = new Printer();
	 // pr.Print("Admin/PUTME/RstSlip.php?RegNo="+escape(RegNo),function(){_('rprintbtn').StopLoadingsm();});
	 pr.Preview("Entrance Result","Admin/PUTME/RstSlip.php?RegNo="+escape(RegNo),function(){_('rprintbtn').StopLoadingsm();});
	  }
  }
}
