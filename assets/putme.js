// Verify Page
//ajax object
//alert('putme');
AJPUTimeOut = 1*60*1000;
var Verify = new function(){
 this.VerifyAjax = null;
 
   this.Start = function(){
	  // alert("s"+AJPUTimeOut);
	   Verify.VerifyAjax = new Ajax(AJPUTimeOut);
	   //making sure that regno is uppercase
	   _('regNo').value = _('regNo').value.Trim().toUpperCase().Replace(" ",""); 
	var RegNo = _('regNo').value.Trim();
	var RegID = _('RegID').value;
	//alert(RegID);
	Verify.Reset();
	if(RegNo == ""){
		MessageBox.Hint("NO ENTRANCE NUMBER SUPPLIED");
		_('regNo').focus();
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
				//L=>29
				if(_('sname').Text().Trim() == "" || _('fname').Text().Trim() == ""  || _('depts.i').Text() == "0" || _('study.i').Text() == "0"){ //valid entring  || _('moes.i').Text() == "0"
					MessageBox.ShowText("COMPLETE REQUIRED FIELDS <br /> Click CANCEL to Cancel Verification","_('sname').focus()","Verify.ClearInit()",null,"REQUIRED FIELDS");
					_('verifybtn').StopLoading();
					return;
				}
				var t = "";
				if(_('teller') != null){
				  if((_('teller').style.display == "block" && _('teller').value.Trim() == "")){
					  MessageBox.Hint("COMPLETE REQUIRED FIELDS");
					_('verifybtn').StopLoading();
					_('sname').focus()
					return;
				  }
				   t = (_('bankpaid.i').Text() == "2")?"&teller="+_('teller').value.Trim():"";
				}
				
				var nm = "&name="+escape(_('sname').Text())+"~"+escape(_('fname').Text())+"~"+escape(_('oname').Text())+"&gender="+_('genders.i').Text()+"&dept="+_('depts.i').Text()+"&study="+_('study.i').Text()+"&moe=0"+t; //form name(record) url string +_('moes.i').Text()
				}else{ //if user is just to verify ordinary, even thou verification is NONE ( is to check if user has inputed data at least once)
					var nm = "&name=#";
				}
			}
			//alert(nm)
		/*Verify.VerifyAjax.PostResponse("regNo="+escape(RegNo)+nm+"&regID="+RegID,"Admin/PUTME/verifyResponse.php",function(res,url,param){
			
			if(res.Trim() == "###"){
			   MessageBox.ShowText("INVALID TELLER NUMBER");
				//Verify.ClearInit();
				_('teller').Text("");
				_('verifybtn').StopLoading();
				_('teller').focus();
			}else if(res.Trim() == "#"){
				MessageBox.ShowText("INVALID CANDIDATE");
				Verify.ClearInit();
				_('verifybtn').StopLoading();
				_('regNo').focus();
			
			}else if(res.Trim() == "##@"){
				MessageBox.ShowText("REGISTRATION CLOSED");
				Verify.ClearInit();
				_('verifybtn').StopLoading();
				_('regNo').focus();
			}else if(res.Trim() == "#*"){
				MessageBox.Hint("SERVER ERROR: Cannot save data");
				_('sname').focus();
				//Verify.ClearInit();
				_('verifybtn').StopLoading();
				
			}else if(res.Trim() == "##"){
				MessageBox.ShowText("Please Confirm your "+"ENTRANCE"+' NUMBER: <span style="font-size:1.4em;text-transform:uppercase;font-weight:bolder">' + unescape(param['regNo']) + "</span>","Verify.ShowInit()","Verify.ClearInit()",null,"CONFIRMATION");
				_('verifybtn').StopLoading();
			}else{
				//alert(res);
				Verify.ClearInit();
				_('studDetails').innerHTML = res;
				_('verifybtn').StopLoading();
				_('studDetails').Animate({CSSRule:"opacity:1;margin-left:0px",Time:_NORMAL});
			}
			
			
			
		},"text",function(res,url,param){
			//alert(txt);
			MessageBox.ShowText("SERVER ERROR: "+res.toUpperCase(),"_('regNo').focus()");
			    //Verify.ClearInit();
				_('verifybtn').StopLoading();
			
		});*/
		Verify.VerifyAjax.Post({
				Action:"Admin/PUTME/verifyResponse.php",
				PostData:"regNo="+escape(RegNo)+nm+"&regID="+RegID,
				OnProgress:function(delta){
                   delta = Math.floor(delta*100);
					if(delta < 100){
						MessageBox.Progress.HintTo(delta,null,"Loading",'Verify.VerifyAjax.abort()');
					}else{
						MessageBox.Progress.HintTo(-1,"Verifying ...","Loading",'Verify.VerifyAjax.abort()'); 
					}
				},
				OnComplete:function(res,url,param){
					//alert(res);
					//resarr = res.split("``");
                   var resarrs = res.split("``");
			var otherinfo = "";
			if(resarrs.length > 1){
				res = resarrs[0].Trim();
				otherinfo = resarrs[1].Trim();
			}
                  MessageBox.CloseHint();
                  if(res.Trim() == "###"){
			   MessageBox.ShowText("INVALID TELLER NUMBER",'',null,null,'INVALID OPERATION');
				//Verify.ClearInit();
				_('teller').Text("");
				_('verifybtn').StopLoading();
				_('teller').focus();
			}else if(res.Trim() == "#"){
				MessageBox.ShowText("INVALID CANDIDATE",'',null,null,'INVALID OPERATION');
				Verify.ClearInit();
				_('verifybtn').StopLoading();
				_('regNo').focus();
			
			}else if(res.Trim() == "##@"){
				MessageBox.ShowText("REGISTRATION CLOSED",'',null,null,'INVALID OPERATION');
				Verify.ClearInit();
				_('verifybtn').StopLoading();
				_('regNo').focus();
			}else if(res.Trim() == "#*"){
				MessageBox.ShowText("SERVER ERROR: Cannot save data",'',null,null,'OPERATION FAILED');
				_('sname').focus();
				//Verify.ClearInit();
				_('verifybtn').StopLoading();
				
			}else if(res.Trim() == "##"){
				MessageBox.ShowText("Please Confirm your "+"ENTRANCE"+' NUMBER: <span style="font-size:1.4em;text-transform:uppercase;font-weight:bolder">' + unescape(param['regNo']) + "</span>","Verify.ShowInit('"+otherinfo+"')","Verify.ClearInit()",null,"CONFIRMATION");
				_('verifybtn').StopLoading();
			}else{
				//alert(res);
				Verify.ClearInit();
				_('studDetails').innerHTML = res;
				_('verifybtn').StopLoading();
				_('studDetails').Animate({CSSRule:"opacity:1;margin-left:0px",Time:_NORMAL});
			}
				},
				OnAbort:function(){
                 _('verifybtn').StopLoading();           
				},
				OnError:function(res){
                  MessageBox.CloseHint();
				  MessageBox.ShowText(res.toUpperCase(),"_('regNo').focus()",null,null,'SERVER ERROR');
			    //Verify.ClearInit();
				_('verifybtn').StopLoading();
				}
			});
		}
	}
  }
  
  //function to show intial details form 
  this.ShowInit = function(det){
	   if(typeof det != _UND && det.Trim() != ""){//user has register for entrance
		  detarr = det.ToDataArray();
		  var allnm = detarr["Name"].Trim();
		  //alert(allnm);
		  var allnmarr = allnm.split(" ");
		  //allnmarr = allnmarr.Exact();
		  if(allnmarr.length > 1){
		  _('sname').Text(allnmarr[0]);
		  _('fname').Text(allnmarr[1]);
		    if(allnmarr.length > 2)_('oname').Text(allnmarr[2]);
		  }
		  _("study").ComboSelect(detarr["StudyID"]);
		  _("facs").ComboSelect(detarr["FacID"]);
		 // _("moes").ComboSelect(detarr["ModeOfEntry"]);FacID
		 // Filter.DirectSelect("study",studyid);
		  //_('jambagg').Text(detarr["JambAgg"]);//JambAgg
	  }else{
		_('fname','sname','oname').Text("");  
	  }
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
	 //_('vuserpassport').value = "";
	 //_('vphone').value = "";
	// _('vaddress').value = "";
	// _('vemail').value = "";
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
	this.Ajax = new Ajax(AJPUTimeOut);
  this.Check = function(){
	  var regNo = _('regNo').value;
	  var RegID = _('RegID.i').value;
	 // alert(RegID);
	  if(regNo.Trim() == ""){MessageBox.Hint("ENTER A VALID REGISTRATION NUMBER");return}
	  if(RegID.ToNumber() < 1){MessageBox.Hint("SELECT A VALID REGISTRATION TYPE");return}
	  var lo = _('crstbtn').StartLoading("Checking ...");
	  if(lo == true){
	   _('rstDetails').Animate({CSSRule:"opacity:0;margin-left:10px",Time:_NORMAL});
	 // var regNo = Cookie.Get('LoginName');
	 /* Result.Ajax.PostResponse("regNo="+escape(regNo),"Admin/PUTME/checkRstResponse.php",
	  function(res,url,param){
		 if(res == "#"){
			  MessageBox.Hint("INVALID JAMB NUMBER SUPPLIED");
			  _('crstbtn').StopLoading();
		  }else if(res.substr(0,1) == "#"){
			  var compl = res.TrimLeft("#");
			  compl = (compl.Trim() == "")?"":"<br /> Send your complaint to "+compl;
			  MessageBox.Hint("NO RESULT FOUND"+compl);
			  _('crstbtn').StopLoading();
		  }else{
			_('rstDetails').innerHTML = res;
			  _('rstDetails').Animate({CSSRule:"opacity:1;margin-left:0px",Time:_NORMAL});
			  _('crstbtn').StopLoading();  
		  }
	  },"text",function(res,url,param){MessageBox.Hint("SERVER ERROR: "+res.toUpperCase(),"");_('crstbtn').StopLoading();});*/
	  Result.Ajax.Post({
				Action:"Admin/PUTME/checkRstResponse.php",
				PostData:"regNo="+escape(regNo)+"&RegID="+escape(RegID),
				OnProgress:function(delta){
                   delta = Math.floor(delta*100);
					if(delta < 100){
						MessageBox.Progress.HintTo(delta,null,"Loading",'Result.Ajax.abort()');
					}else{
						MessageBox.Progress.HintTo(-1,"Loading ...","Loading",'Result.Ajax.abort()'); 
					}
				},
				OnComplete:function(res,url,param){
					//alert(res);
					_('crstbtn').StopLoading();
					MessageBox.CloseHint();
                   if(res == "#"){
			        MessageBox.ShowText("INVALID JAMB NUMBER SUPPLIED","",null,null,"INVALID ENTERING");
					}else if(res.substr(0,1) == "#"){
						var compl = res.TrimLeft("#");
						compl = (compl.Trim() == "")?"":"<br /> Send your complaint to "+compl;
						MessageBox.ShowText("NO RESULT FOUND"+compl,"",null,null,"ENTRANCE RESULT");
						//_('crstbtn').StopLoading();
					}else{
						_('rstDetails').innerHTML = res;
						_('rstDetails').Animate({CSSRule:"opacity:1;margin-left:0px",Time:_NORMAL});
						//_('crstbtn').StopLoading();  
					}
				},
				OnAbort:function(){
                  _('crstbtn').StopLoading();
					MessageBox.CloseHint();
				},
				OnError:function(res){
                MessageBox.Hint(res.toUpperCase(),"",null,null,"SERVER ERROR");
				_('crstbtn').StopLoading();
				MessageBox.CloseHint();
				}
			});
	  }
  }
	
}




//Register Page
var PRegister = new function(){
	this.RegAjax = new Ajax();

	this.Loader = new FileUpload(300000,"../epconfig/UserImages/PUTME/","jpg");
	this.Error = false;
this.Abort = function(){
	PRegister.RegAjax.abort();
}

this.ViewImageFile = function(imgholderid,fn){
	var imgholder = _(imgholderid);
	if(imgholder != null){
		var src = imgholder.src;
		var loaded = imgholder.Data('loaded');
		if(loaded.Trim() == "true"){
			MessageBox.ShowText('<img src="'+src+'" alt="CANNOT LOAD IMAGE" style="max-width:100%" />',"",null,null,fn)
		}else{
			MessageBox.Hint(fn+" NOT FOUND");
		}
	}else{
		MessageBox.Hint("INTERNAL ERROR");
	}

}

this.AttachImageFile = function(imgholderid,fileName,tbid){
  var imgholder = _(imgholderid);
  var params = {'ImageHolder':imgholderid,'FileName':fileName,'TextBox':tbid};
 /* params['ImageHolder'] = imgholderid;
  params['FileName'] = fileName;
  params['TextBox'] = tbid;*/
  var paramsStr = JSON.stringify(params);
  //alert(paramsStr);
  if(imgholder == null){
	  MessageBox.Hint("Internal Error");
	  return;
  }
  imgholder.SetFromFile({
	 start:"_('"+imgholderid+"').value = 'ATTACHING ...'",
	 onload:function(){
		 var params = unescape(_(this.id+"_file").Data("defaultSrc"));
		 if(params.Trim() != ""){
			// alert(params);
		   params = JSON.parse(params);
		   var tb = _(params.TextBox);
		   if(tb != null){
			   tb.value = params.FileName;
			   //tb.SetStyle("border-color: rgba(204,51,0,.7);background-color:rgba(204,51,0,.05);color: rgba(204,51,0,1);");
			   //border-color: rgba(0,121,0,.7);background-color: rgba(0,121,0,.05);
			   tb.SetStyle("background-color:rgba(0,121,0,.05);color: rgba(0,121,0,1)");
			   var logo = _(tb.id+"_logo");
			   if(logo != null){
				   logo.innerHTML = 'check'.Icon();
			   }
			   //tb.classList.add("tbsuccess");
			   //tb.classList.remove("tbdanger");
			   MessageBox.Hint(params.FileName + " SET");
			   this.Data('loaded','true');
			   _(this.id+'_status').value = 'true';
               return;
		   }
		  // _(params.TextBox).value = 
		 }
		 this.Data('loaded','false');
		 _(this.id+'_status').value = 'false';
		 MessageBox.Hint("INTERNAL ERROR");
	   //alert(this.src);
	   //alert(unescape(params));
	 },
	 onerror:function(res){
		 //alert('sss');
		res = !IsString(res)?"INVALID FILE":res;
		MessageBox.Hint(res);
		this.Data('loaded','false');
		_(this.id+'_status').value = 'false';
		var params = unescape(_(this.id+"_file").Data("defaultSrc"));
		if(params.Trim() != ""){
		   // alert(params);
		  params = JSON.parse(params);
		  var tb = _(params.TextBox);
          if(tb != null){
			tb.value = params.FileName;
			//tb.classList.remove("tbsuccess");
			//tb.classList.add("tbdanger");
			
			tb.SetStyle("background-color:rgba(204,51,0,.05);color: rgba(204,51,0,1)");
			var logo = _(tb.id+"_logo");
			if(logo != null){
				logo.innerHTML = 'times'.Icon();
			}
		  }
		  //this.src = "";
		}
	 },
	 maxSize:102400,//100KB
	 minSize:20840,//20KB
	 defaultSrc:paramsStr
  })
}
	//upload passport
	this.Upload = function(regNo,dsrc){
		/*regNo = regNo.Replace("/","_");
		
		PRegister.Loader.rootfolder = _DATA.Data("sub-domain");
		PRegister.Loader.Upload(regNo,PRegister.UploadFinish,"Admin/fileuploadbridge.php");*/
		_('userpassp').SetFromFile({
			start:"_('passploading').Appear()",
			onload:function(){
              _('passploading').Disappear();
			// alert(this.src);
			if(PRegister.Error){
				_('userpassport').value = unescape(_(this.id+"_file").Data("defaultSrc"));
				PRegister.Error = false;
			}else{
			 _('userpassport').value = "##";//file exist
			}
			// alert(_('userpassport').value);
			},
			onerror:function(res){
				res = !IsString(res)?"Invalid Image":res;
				//alert(this.id+"_image");
				PRegister.Error = true;
				_('userpassport').value = unescape(_(this.id+"_file").Data("defaultSrc"));
				//alert(_('userpassport').value);
				_('userpassp').src = _('userpassport').value;
				// alert(_('userpassport').value);
                _('passploading').Disappear();
				MessageBox.Hint(res);
			},
			maxSize:70000,
			minSize:20840,
			defaultSrc:dsrc
	})
		
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

  this.ValidateRegister = function(){

	var pasload = _('passploading');
	if(pasload != null){
		if(pasload.style.visibility == "visible"){
			//MessageBox.Hint("OPERATION TERMINATED: LOADING PASSPORT PHOTOGRAPH");
			return "OPERATION TERMINATED: LOADING PASSPORT PHOTOGRAPH";
		}
	}
	var dobval = _('dob').value.Trim();
	if(dobval == ""){ //check empty date of birth
		return "NO <b style=\"font-weight:bolder; color:#CC3300\">DATE OF BIRTH</b> SUPPLIED";
	}
	var dob = dobval.IsDate();
	if(dob != true){
		return "<b style=\"font-weight:bolder; color:#CC3300\">"+dob.toUpperCase()+"</b> SUPPLIED";
	}
	if(_('phone').value.Trim() == "" || IsPhoneNumber(_('phone').value) == false){
		//MessageBox.Hint("INVALID <b style=\"font-weight:bolder; color:#CC3300\">PHONE NUMBER</b> SUPPLIED");
		return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">PHONE NUMBER</b> SUPPLIED";
	}
	
	if(_('email').value.Trim() == "" || IsEmail(_('email').value) == false){
	   //MessageBox.Hint("INVALID <b style=\"font-weight:bolder; color:#CC3300\">EMAIL ADDRESS</b> SUPPLIED");
		return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">EMAIL ADDRESS</b> SUPPLIED"; 
	}
	
	
	if(_('userpassport').value.Trim() == "" || _('userpassport').value.Trim() == "Resource/Images/userbig.jpg"){
	  // MessageBox.Hint("SELECT YOUR <b style=\"font-weight:bolder; color:#CC3300\">PASSPORT PHOTOGRAPH</b> <br /> Select by Double-Clicking the Passport Viewer.");
		return "SELECT YOUR <b style=\"font-weight:bolder; color:#CC3300\">PASSPORT PHOTOGRAPH</b> <br /> Select by Double-Clicking the Passport Viewer."; 
	}
	
	//subjcomb
	for(var s=1; s<=4; s++){
	if(_('subjcomb'+s+'.i') != null){
	  if(_('subjcomb'+s+'.i').value.Trim() == "" || _('subjcomb'+s+'.i').value.Trim() == "0"){
		 //MessageBox.Hint("SELECT A <b style=\"font-weight:bolder; color:#CC3300\">SUBJECT COMBINATION</b>");
		 return "SELECT A VALID <b style=\"font-weight:bolder; color:#CC3300\">SUBJECT COMBINATION</b>"; 
	  }
	}
}

//L=>325 State Inject 
	if(_('state.i') != null){
	  if(_('state.i').value.Trim() == "" || _('state.i').value.Trim() == "0"){
		 //MessageBox.Hint("SELECT YOUR <b style=\"font-weight:bolder; color:#CC3300\">STATE OF ORIGIN</b>");
		 return "SELECT YOUR <b style=\"font-weight:bolder; color:#CC3300\">STATE OF ORIGIN</b>"; 
	  }
	  //lga
	  if(_('lga.i').value.Trim() == "" || _('lga.i').value.Trim() == "0"){
		// MessageBox.Hint("SELECT YOUR <b style=\"font-weight:bolder; color:#CC3300\">LOCAL GOVERNMENT AREA</b>");
		 return "SELECT YOUR <b style=\"font-weight:bolder; color:#CC3300\">LOCAL GOVERNMENT AREA</b>";
	  }


	}

	if(_('address').value.Trim() == ""){
		//MessageBox.Hint("INVALID <b style=\"font-weight:bolder; color:#CC3300\">EMAIL ADDRESS</b> SUPPLIED");
		 return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">ADDRESS</b> SUPPLIED"; 
	 }
	
	if(_('attachHolder') != null && _('attachHolder').Data('loaded').Trim() != "true"){
		return "ATTACH YOUR <b style=\"font-weight:bolder; color:#CC3300\">CERTIFICATE OF ORIGIN</b>";
	}
	
	//if()
	var jambrst = _('jambagg');
	if(jambrst != null){
		jambrst = jambrst.value.ToNumber();
	if(jambrst < 1 || jambrst > 400){
		return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">UTME RESULT</b> ENTERED";
	}
}

	if(_('jambRstHolder') != null && _('jambRstHolder').Data('loaded').Trim() != "true"){
		return "ATTACH YOUR <b style=\"font-weight:bolder; color:#CC3300\">UTME RESULT PRINT-OUT</b>";
	}

	var DipName = _('dipSchNm');
	if(DipName != null && DipName.value.Trim() == ""){
        return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">DIPLOMA SCHOOL NAME</b> ENTERED";
	}

	//dipStudy
	var dipStudy = _('dipStudy');
	if(dipStudy != null && dipStudy.value.Trim() == ""){
        return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">DIPLOMA COURSE OF STUDY</b> ENTERED";
	}

	var gyear = _('gyear.i');
	if(gyear != null && (gyear.value.Trim() == "" || gyear.value.Trim() == "0")){
        return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">DIPLOMA GRADUATION YEAR</b> SELECTED";
	}

	var dipclassofpass = _('dipclassofpass.i');
	if(dipclassofpass != null && (dipclassofpass.value.Trim() == "" || dipclassofpass.value.Trim() == "0")){
        return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">DIPLOMA CLASS OF PASS</b> SELECTED";
	}

	if(_('diplomaRstHolder') != null && _('diplomaRstHolder').Data('loaded').Trim() != "true"){
		return "ATTACH YOUR <b style=\"font-weight:bolder; color:#CC3300\">DIPLOMA CERTIFICATE</b>";
	}


	return true;
  }

  this.ValidatePg2 = function(){
	if(_('exmtype') == null){
		return "INVALID OPERATION, PAGE ERROR";
	}
	var exmtype = _('exmtype.i').value.Trim();
	var exmtype2 = _('exmtype2.i').value.Trim();
	if(exmtype == "0")return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">EXAM TYPE</b> SUPPLIED";
	
	if(exmtype != "1"){ //if not awaiting result
		//alert(exmtype);
	  if(_('eyear.i').value.Trim() == "0" || _('eyear.i').value.IsYear() != true){
		   return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">EXAM YEAR</b> SUPPLIED";
	  }

	  if(_('ebatch.i').value.ToNumber() == 0){
		return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">EXAM BATCH</b> SUPPLIED";
   }
	  
	  if(_('esch').value.Trim() == ""){
		   return "NO <b style=\"font-weight:bolder; color:#CC3300\">SCHOOL NAME</b> SUPPLIED";
	  }

	  if(_('enum').value.Trim() == ""){
		return "NO <b style=\"font-weight:bolder; color:#CC3300\">EXAM NUMBER</b> SUPPLIED";
   }
	  
	  //olevel1
	  if(_('olevel1').value.Trim() == ""){
		   return "NO <b style=\"font-weight:bolder; color:#CC3300\">RESULT</b> FOUND";
	  }
	  
	  if((_('pass1').value.Trim().ToNumber() + _('fail1').value.Trim().ToNumber()) < 7 || (_('pass1').value.Trim().ToNumber() + _('fail1').value.Trim().ToNumber()) > 9){
		   return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">RESULT</b> SUPPLIED. <br /> MINIMUM SUBJECT IS SEVEN(7)";
	  }
      var olvelFile1Holder =_('olvelFile1Holder');
	  if(olvelFile1Holder != null && olvelFile1Holder.Data('loaded').Trim() != "true"){
		return "ATTACH YOUR <b style=\"font-weight:bolder; color:#CC3300\">OLEVEL RESULT</b>";
	}
	
	}
	
	if(exmtype2 != "0"){
		
	if(_('olevel2').value.Trim() != "" && _('eyear2.i').value.Trim() == "0" ){
		return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">EXAM YEAR</b> SUPPLIED FOR OTHER RESULT";
	}

	if(_('olevel2').value.Trim() != "" && _('ebatch2.i').value.ToNumber() == 0){
		return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">EXAM BATCH</b> SUPPLIED FOR OTHER RESULT";
   }
	
		if(_('olevel2').value.Trim() != "" && _('esch2').value.Trim() == "" ){
		return "NO <b style=\"font-weight:bolder; color:#CC3300\">SCHOOL NAME</b> SUPPLIED FOR OTHER RESULT";
	}

	if(_('olevel2').value.Trim() != "" && _('enum2').value.Trim() == "" ){
		return "NO <b style=\"font-weight:bolder; color:#CC3300\">EXAM NUMBER</b> SUPPLIED FOR OTHER RESULT";
	}

	if(_('olevel2').value.Trim() != "" && ((_('pass2').value.Trim().ToNumber() + _('fail2').value.Trim().ToNumber()) < 7 || (_('pass2').value.Trim().ToNumber() + _('fail2').value.Trim().ToNumber()) > 9) ){
		return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">RESULT</b> SUPPLIED FOR OTHER RESULT. <br /> MINIMUM SUBJECT IS SEVEN(7)";
	}
   var olvelFile2Holder = _('olvelFile2Holder');
	if(_('olevel2').value.Trim() != "" && olvelFile2Holder != null && olvelFile2Holder.Data('loaded').Trim() != "true"){
		return "ATTACH YOUR <b style=\"font-weight:bolder; color:#CC3300\">OLEVEL OTHER RESULT</b>";
	}
	
	}

  if(_('instattend') != null){
	
	if(_('intname').value.Trim() == ""){
		return "NO <b style=\"font-weight:bolder; color:#CC3300\">INSTITUTION NAME</b> FOUND. <br /> Click the INSTITUTION ATTENDED Header to OPEN/CLOSE Panel";
	}
	
	if(_('intdept').value.Trim() == ""){
		return "NO <b style=\"font-weight:bolder; color:#CC3300\">DEPARTMENT</b> SUPPLIED FOR INSTITUTION ATTENDED DETAILS. <br /> Click the INSTITUTION ATTENDED Header to OPEN/CLOSE Panel";
	}
	
	if(_('intregno').value.Trim() == ""){
		return "NO <b style=\"font-weight:bolder; color:#CC3300\">REGISTRATION NUMBER</b> SUPPLIED FOR INSTITUTION ATTENDED DETAILS. <br /> Click  the INSTITUTION ATTENDED Header to OPEN/CLOSE Panel";
	}
	
	if(_('intyearad').value.Trim() == "" || _('intyearad').value.IsYear() != true){
		 return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">ADMISSION YEAR</b> SUPPLIED.  <br /> Click  the INSTITUTION ATTENDED Header to OPEN/CLOSE Panel";
	}
	
	if(_('intdategrad').value.Trim() == ""){
		 return "NO <b style=\"font-weight:bolder; color:#CC3300\">GRADUATION DATE</b> SUPPLIED.  <br /> Click  the INSTITUTION ATTENDED Header to OPEN/CLOSE Panel";
	}
	//intmode
	if(_('intmode').value.Trim() == ""){
		 return "INVALID <b style=\"font-weight:bolder; color:#CC3300\">MODE OF ADMISSION</b> SUPPLIED.  <br /> Click  the INSTITUTION ATTENDED Header to OPEN/CLOSE Panel";
	}
	//intgrade
	if(_('intgrade').value.Trim() == ""){
		 return "NO <b style=\"font-weight:bolder; color:#CC3300\">GRADE OF PASS</b> SUPPLIED.  <br /> Click  the INSTITUTION ATTENDED Header to OPEN/CLOSE Panel";
	}
  }
	
	return true;
}
  
  this.Submit = function(){
	  //alert('aaa');
	  /*alert(Wizard.GetInputs());
	  return;*/
	  var pasload = _('passploading');
	  var val = PRegister.ValidatePg2(); //in form.js
	  if(val !== true){
		 MessageBox.Hint(val);
		 return;
	  }
		  
		  var fl = _('pregsubmit').StartLoading("Submitting...");
	  if(fl){
//State Inject End
    

	  //making sure that the regno is uppercase
	  
	  /*var fl = _('pregsubmit').StartLoading("Submitting...");
	  if(fl){*/
		   MessageBox.Progress.HintTo(1,null,"Submitting",'PRegister.Abort()');
		_("navbtn").Hide();  
	  var data = Wizard.GetInputs();
		//alert(data);
	//return;
	PRegister.RegAjax.Post({
		Action:"Admin/PUTME/submit.php",
		PostData:data,
		OnProgress:function(delta){
           delta = Math.floor(delta * 100);
		   if(delta < 100){
			   MessageBox.Progress.HintTo(delta,null,"Submitting",'PRegister.Abort()');
		   }else{
			  MessageBox.Progress.HintTo(delta,"Saving ...","Submitting",'PRegister.Abort()'); 
		   }
		},
		OnComplete:function(res,url,param){
			//alert(res);
			//return;
           if(res.substr(0,1) == "#"){
			    res = res.substr(1);
				MessageBox.ShowText("SERVER ERROR: "+ res,"");
			  _('pregsubmit').StopLoading();
			  _("navbtn").Show();
			}else{
				//alert(res);
				//return;
                var RegID = param['RegID'];
				resarr = res.split("~");
				//if(resarr.length == 6){
			    var info = 'Registration Number: '+resarr[0].toUpperCase()+' <br />Access Code: <strong style="font-weight:bolder;">'+resarr[2]+'</strong>';	
				resarr[0] = resarr[0].Trim();
				MessageBox.ShowText(info,null,"","#PRegister.PrintSlip('"+escape(resarr[0])+"',MessageBox.Loading,MessageBox.Close,"+RegID+")",'<span style="font-size:1.0em"> '+'check'.Icon()+'</span> REGISTRATION SUCCESSFUL');
				//if(typeof Admin.Sel != _UND){
					Admin.Sel.click();
				//}
				//_('prev').click();
				//}
				}
			MessageBox.CloseHint();
		},
		OnAbort:function(){
          MessageBox.ShowText("Operation Aborted","");
		  MessageBox.CloseHint();
		  _('pregsubmit').StopLoading();
			  _("navbtn").Show();
			  _('prev').click();
		},
		OnError:function(){
			MessageBox.ShowText("SERVER ERROR: "+res.toUpperCase(),"");
				_('pregsubmit').StopLoading();
				_("navbtn").Show();
				MessageBox.CloseHint();
		}
	});
	  /*PRegister.RegAjax.PostResponse(data,"Admin/PUTME/submit.php",function(res,url,param){
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
			
		});*/
	  //MessageBox.Show('Admin/PUTME/mesSuccess.php','');
	  }
  }
  
 
  //function to print putme slip
  this.PrintSlip = function(RegNo,StartFunc,EndFunc,RegID){
	  RegID = typeof RegID == _UND?1:RegID;
	  /*StartFunc = (typeof StartFunc == "undefined")?function(){}:StartFunc;
	  EndFunc = (typeof EndFunc == "undefined")?function(){}:EndFunc;
	  StartFunc("Proccessing ...");*/
	  /*if(_('reprSlip') != null && StartFunc == null){
	  _('reprSlip').StartLoadingsm();
	  EndFunc = function(){ if(_('reprSlip') != null)_('reprSlip').StopLoadingsm();}
	  }else{
		 StartFunc = (typeof StartFunc == "undefined")?function(){}:StartFunc;
	     EndFunc = (typeof EndFunc == "undefined")?function(){}:EndFunc;
	     StartFunc("Proccessing ..."); 

	  }
	  var pr = new Printer();
	 // pr.Print("Admin/PUTME/Slip.php?RegNo="+escape(RegNo),EndFunc);
	 pr.Preview("Entrance Print Slip","Admin/Slip.php?folder=PUTME&RegNo="+escape(RegNo)+"&RegID="+RegID,EndFunc);*/
	 PDFPrinter.Print("Admin/Slip.php","folder=PUTME&RegNo="+escape(RegNo)+"&RegID="+RegID+"&paper=A4&orientation=P&MT=4&MB=14","Entrance_"+RegNo+".pdf");
	  
  }
  
  
  

}

  //set validation function
  WizardPageCheck['Admin/PUTME/verify.php'] = Verify.Validate;
  WizardPageCheck['Admin/PUTME/register.php'] = PRegister.ValidateRegister;

var PUTME = new function(){
	  //function to print putme result
  this.PrintResult = function(RegNo,RegID){
	  RegID = typeof RegID == _UND?1:RegID;
	 /* var lo = _('rprintbtn').StartLoadingsm();
	  if(lo == true){
	 var pr = new Printer();
	 // pr.Print("Admin/PUTME/RstSlip.php?RegNo="+escape(RegNo),function(){_('rprintbtn').StopLoadingsm();});
	 pr.Preview("Entrance Result","Admin/PUTME/RstSlip.php?RegNo="+escape(RegNo)+"&RegID="+escape(RegID),function(){_('rprintbtn').StopLoadingsm();});
	  }*/
	  PDFPrinter.Print("Admin/PUTME/RstSlip.php","RegNo="+escape(RegNo)+"&RegID="+escape(RegID)+"&paper=A4&orientation=P&MT=4&MB=14","Entrance_Result_"+RegNo.Replace("/","_")+".pdf");
  }
}
