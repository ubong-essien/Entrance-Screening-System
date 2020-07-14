//created on 5 June,2018 by Enefiok Duke for easy work around
//function that returns _ as document.getElementById()
//declarations
var myCalendar; //for calender plugin
var getId1 = "";
// Slideshow
/////////
if(typeof _ == "undefined"){
    _ = function(el) {
        return document.getElementById(el);
    }
}
if(typeof _cn == "undefined"){
    _cn = function(el){
        return getElementByClassName(el);
    }
}
//xmlHTTP obj is created here
var xmlHttp = createXmlHttpRequestObject();
function createXmlHttpRequestObject() {
    var xmlHttp;
    if (window.ActiveXObject) {
        try {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {
            xmlHttp = false;
        }
    } else {
        try { 
            xmlHttp = new XMLHttpRequest();
        } catch (e) {
            xmlHttp = false;
        }
    }
    if (!xmlHttp)
        alert("cant create that Object hoss");
    else
        return xmlHttp;
}
//obj that is controlling all the elememnt
var __I = {
//this method helps to handle POST Response fron server
    A_jaxPost:function(URL,msg,VALUE){
        ajaxPOST("widget/"+URL+"",function(){
            if (this.readyState == 4 || this.status == 200) {
                var responsses = this.responseText;
               if(responsses){
                   alert(""+msg+"");
               }else{
                    alert(responsses);
               }
            }
        },VALUE);
    },
//this ajax function will always receive html from php and display on html web page with VALUE
//how to use ajax(r.php,id,value)

    A_jaxGetM:function(URL,id,VALUE){
        ajax("widget/"+URL+"",function(id) {
            if (this.readyState == 4 || this.status == 200) {
                var responsses = this.responseText;
                _(""+id+"").innerHTML=responsses;
            }
        },VALUE);
    },
//normal display block
    S_how:function(id){
      return  _(""+id+"").style.display="block";
    },
// display no block
    H_ide:function(id){
      return  _(""+id+"").style.display="none";
    },
    //contol mouse evnt
    _CursorContol:function(cur){//
        document.body.style.cursor = cur;
    },
//normal visibilty to visible
    S_howV:function(id){
        return  _(""+id+"").style.visibility = "visible";
    },
    // nomal visibility to hidden
    H_ideV:function(id){
        return  _(""+id+"").style.visibility = "hidden";
    },
 //this ajax function will always receive html from php and display on html web page
//how to use ajax(r.php,id) note:use GET method
    A_jaxGetNOVaL:function(URL,id,refreshId){
       // _(""+id+"").innerHTML="unytr";
      
        ajax("widget/"+URL+"",function() {
            if (this.readyState == 4 || this.status == 200) {
                __I.H_ide(refreshId);
                var responsses = this.responseText;
                _(""+id+"").innerHTML=responsses;
            }
        });
    },
    //use to display and hide,show refresh button
    A_jaxGetNOVaLDef:function(URL,id,ID2,refreshId){
        __I.S_how(refreshId);
         ajax(""+URL+"",function() {
             if (this.readyState == 4 || this.status == 200) {
                 __I.H_ide(refreshId);
                 __I.H_ide(ID2);
                 var responsses = this.responseText;
                 _(""+id+"").innerHTML=responsses;
             }
         });
     },
    //func that takes in .php,id will get the respons, refreshid will be show and displace on response
    A_jaxGetNOVaL3Para:function(URL,id,ID2,refreshId){
        // _(""+id+"").innerHTML="unytr";
                 __I.S_how(refreshId);
         ajax("widget/"+URL+"",function() {
             if (this.readyState == 4 || this.status == 200) {
                __I.H_ide(ID2);
                 __I.H_ide(refreshId);
                 var responsses = this.responseText;
                 _(""+id+"").innerHTML=responsses;
             }
         });
     },
    A_jaxGetShHid:function(URL,id,ID2){
                 __I.S_how(ID2);   
         ajax(""+URL+"",function() {
             //console.log("this.readyState: "+this.readyState+ " this.status: "+ this.status);
              if (this.readyState == 4) {
                  if(this.status == 200){
                      __I.H_ide(ID2);
                 var responsses = this.responseText;
                 _(""+id+"").innerHTML=responsses;
                 //AllAction.UnUploadedC.loadSem();
                  }else{
                     __I.H_ide(ID2);
                    _("disPlyMM234").style.display = "block";
                  }
                 
             }
         });
     },
     A_jaxGetShHidUpdR:function(URL,id,ID2){
        __I.S_how(ID2);   
    ajax(""+URL+"",function() {
        //console.log("this.readyState: "+this.readyState+ " this.status: "+ this.status);
        if (this.readyState == 4) {
            if(this.status == 200){
                __I.H_ide(ID2);
            var responsses = this.responseText;
            _(""+id+"").innerHTML=responsses;
            //AllAction.UnUploadedC.loadSem();
            }else{
                __I.H_ide(ID2);
            _("disPlyMM234").style.display = "block";
            }
            
        }
    });
    },

    //insertadj into tb
    A_jaxGetShHidAj:function(URL,id,ID2){
        __I.S_how(ID2);   
    ajaxPOST(""+URL+"",function() {
        //console.log("this.readyState: "+this.readyState+ " this.status: "+ this.status);
        if (this.readyState == 4) {
            if(this.status == 200){
                __I.H_ide(ID2);
                //alert(this.responseText);
            var getjsnpars = JSON.parse(this.responseText);
            //alert(getjsnpars);return;
            var i;
            //var getInsertJ = _(id).innerHTML;
            var tt = "<tr class='uv2-newap-light-grey'><th>ProgID</th><th>ProgName</th></td>";
            for(i = 0; i < getjsnpars.length; i++){
                var getRR = getjsnpars[i];
                // var getbot = (JSON.parse(getRR)).SujID+" => "+(JSON.parse(getRR)).SubjN;
                
                //_('trtb').classList.add('');
                //getInsertJ.insertAdjacentHTML('beforeend','<tr><div id="remov" class="uv2-animate-tr"><td>'+(JSON.parse(getRR)).SujID+'</td><td>'+(JSON.parse(getRR)).SubjN+'</td></div></tr>');
                //_('remov').classList.remove('w3-animate-right');
                tt+='<tr><td>'+getRR.SujID+'</td><td>'+getRR.SubjN+'</td></tr>';
            }
            //alert(tt);
            // getInsertJ = tt;
            _(id).innerHTML=tt; 
            }else{
                __I.H_ide(ID2);
            _("disPlyMM234").style.display = "block";
            }
            
        }
    });
    },
    //how to use this obj is => onclick="__I.InsertRuleObj.addStylesheetRules([['h2',['color', 'red'],['background-color', 'green', true]], ['.myClass', 
    //['background-color', 'yellow']],['.tr3',['background-color','purple'],['color', 'white'],['padding','10px']]])"
    clContrAlrtMsg:function(msg){
        __I.ControlAlertMsg.InsertRuleObj.addStylesheetRules(
            [
                ['.spt-bigBox-cont',['background-color','rgb(0, 0, 0)',true],['background-color','rgba(0, 0, 0,0)',true],['position','fixed'],['top','0'],['left','0'],['bottom','0'],['right',0],['width','100%'],['height','100%'],['z-index','5']],
                ['.stp-border',['border','solid thin #aaaaaa33']],
                ['.av2-border',['border','solid thin #0866c6']],
                ['.av2-altB-cont',['min-width','400px'],['height','150px'],['border','1px solid #ddd'],['border-radius','6px']],
                ['.av2-alt-padding',['padding','12px']],
                ['.av2-alt-col',['background-color','#0866c6'],['color','#ffffff']]
            ]
        );
        __I.ControlAlertMsg.mainInit(msg);
    },
    ControlAlertMsg:{
        mainInit:function(msg){
            if(_('mainBCont') == null){
                this.init();
            }
            _('altMsg').innerHTML = msg;
            __I.S_how('mainBCont');// _('oveCnt').classList.add('alt-zoom-in');alt-ext-animate-top
            setTimeout(function(){
                __I.H_ide('mainBCont');
                _('oveCnt').classList.remove('alt-zoom-in');
                _('oveCnt').classList.remove('alt-ext-animate-top');
            },2500);
        },

        init:function(){
            document.body.insertAdjacentHTML('beforeend',
                '<div id="mainBCont" class="spt-bigBox-cont"><div class="w3-display-container" style="height:100%;"><div class="w3-display-middle"><div id="oveCnt" class="av2-altB-cont w3-animate-top w3-card w3-white"><div class="w3-border w3-border-bottom putme-bgrcolor-altbox av2-alt-padding">Alert<span onclick="__I.ControlAlertMsg.dismisMainBCont()" class="w3-right" style="cursor:pointer;">x</span></div><div id="altMsg" class="av2-alt-padding w3-border-top"></div><div class="w3-border-top av2-alt-padding"><span onclick="__I.ControlAlertMsg.dismisMainBCont()" class="w3-right w3-circle w3-button putme-bgrcolor-altbox">ok</span></div></div></div></div></div>'
            );
        },
        PlayAnimation:{
            cntrAdAnimation:function(herd,herd2,herd3,herd4,ovrcnt){
                __I.S_how(ovrcnt);
                this.removeAnimate(herd,herd2,herd3,herd4);
                _(herd).classList.add('w3-animate-left');
                _(herd2).classList.add('w3-animate-right');
                _(herd3).classList.add('w3-animate-right');
                _(herd4).classList.add('w3-animate-left');
            },
            cntrRemovAnimation:function(herd,herd2,herd3,herd4,ovrcnt){
                _(herd).classList.add('av2-anim-left');
                _(herd2).classList.add('av2-anim-right');
                _(herd3).classList.add('av2-anim-right');
                _(herd4).classList.add('av2-anim-left');
                setTimeout(" __I.H_ide('"+ovrcnt+"')",100);
            },
            removeAnimate:function(herd,herd2,herd3,herd4){
                _(herd).classList.remove('av2-anim-left');
                _(herd2).classList.remove('av2-anim-right');
                _(herd3).classList.remove('av2-anim-right');
                _(herd4).classList.remove('av2-anim-left');
            },
        },
        //insert rule with css
         //how to use this obj is => onclick="__I.InsertRuleObj.addStylesheetRules([['h2',['color', 'red'],['background-color', 'green', true]], ['.myClass', 
    //['background-color', 'yellow']],['.tr3',['background-color','purple'],['color', 'white'],['padding','10px']]])"
        InsertRuleObj:{
            addStylesheetRules:function(rules){
                //create style <style></style>
                var styleEl = document.createElement('style');
                // Append <style> element to <head>
                document.head.appendChild(styleEl);
                 // Grab style element's sheet
                 var styleSheet = styleEl.sheet;
                //  alert(rules.length);return;
                // console.log(rule[0]);return;
                    for (var i = 0; i < rules.length; i++) {//
                        //['.myClass',['background-color', 'yellow']]
                    var j = 1, 
                        rule = rules[i], 
                        selector = rule[0], 
                        propStr = '';
                    // If the second argument of a rule is an array of arrays, correct our variables.
                    if (Array.isArray(rule[1][0])) {
                    rule = rule[1];
                    j = 0;
                    }
    
                    for (var pl = rule.length; j < pl; j++) {
                    var prop = rule[j];
                    propStr += prop[0] + ': ' + prop[1] + (prop[2] ? ' !important' : '') + ';\n';
                    }
    
                    // Insert CSS Rule
                    var index = styleSheet.insertRule(selector + '{' + propStr + '}', styleSheet.cssRules.length);
                    //delete css rule
                    //CSSStyleSheet.deleteRule();
                }
            },
        },
        dismisMainBCont:function(){
            _('oveCnt').classList.add('alt-zoom-in');
           setTimeout(function(){
            _('oveCnt').classList.add('alt-ext-animate-top');
            
           },200)
        },
    },

     A_jaxGetShHidsems:function(URL,id,id2,id3,id4){ 
        __I.H_ide(id3);
        __I.S_how(id4);
        ajaxPOST(""+URL+"",function() {
            if (this.readyState == 4) {
                if(this.status == 200){
                var responsses = this.responseText;
                __I.S_how(id3);
                __I.H_ide(id4);
                _(id).classList.remove('hidden');
                _(id).classList.add('visible');
                _(""+id+"").innerHTML=responsses;
                // _("getRegN").value = null;
                }else{
                
                }
                
            }
        },id2);
        },
        //conrol cursor
        cursorwait:function(){
            document.body.style.cursor='wait'; return true;
        },
        searchTable:function(){
            // Declare variables 
            var input, filter, table, tr, td, i, txtValue;
            input = _("myInput");//uduakobong okorie
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByClassName("pro-tb");//uduakobong okorie
            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                } 
            }
        },
        A_jaxGetShHidUnplodedc:function(URL,id,id2){
            __I.H_ide('UUdismSubtn');
            __I.S_how('UUdismiCog');    
             //var getUnplDetails = "getUnploddet="+id2;
            ajaxPOST(""+URL+"",function(){
                if (this.readyState == 4) {
                    if(this.status == 200){
                    var responsses = this.responseText;
                    __I.S_how('UUdismSubtn');
                    __I.H_ide('UUdismiCog');
                    __I._CursorContol('default');
                    //_('disUnuploadedC').classList.add('visible');
                    //_('disUnuploadedC').style.display = "block";
                    _('disUnuploadedC').classList.remove('hidden');
                    _('disUnuploadedC').classList.add('visible');
                    //return;
                    _(""+id+"").innerHTML=responsses;
                    }else{}
                }
            },id2);
        },
        A_jaxGetShHidsemsUpdR:function(URL,id,ID2){
            __I.H_ide('dismSubtnUpd');
            __I.S_how('dismiCogUpdatr');    
             //var getUnplDetails = "getUnploddet="+id2;
            ajaxPOST("widget/"+URL+"",function(){
                if (this.readyState == 4) {
                    if(this.status == 200){
                    var responsses = this.responseText;
                    __I.S_how('dismSubtnUpd');
                    __I.H_ide('dismiCogUpdatr');
                    __I._CursorContol('default');
                    //_('disUnuploadedC').classList.add('visible');
                    //_('disUnuploadedC').style.display = "block";
                    _('disUpdateResult').classList.remove('hidden');
                    _('disUpdateResult').classList.add('visible');
                    //return;
                    _(""+id+"").innerHTML=responsses;
                    }else{}
                }
            },ID2);
        },
     
    A_jaxGetShHidInv:function(URL,id,ID2){
        __I.S_how(ID2);   
ajax("widget/"+URL+"",function() {
    if (this.readyState == 4 || this.status == 200) {
        __I.H_ide(ID2);
        var responsses = this.responseText;
         _(""+id+"").innerHTML=responsses;
         setTimeout(getallNecPltFmInfo, 1000);
         //getallNecPltFmInfo();
        //this function will be called to shift button from left to right 
    }
  
});
},
     CID:0,
     //functionfor two para
    A_jaxGetShHidA:function(URL,ID2,param){
        
       // __I.CID = id;
               // __I.H_ide(ID2); 
                //alert("widget/"+URL); 
        ajax("widget/"+URL+"",function() {
            if (this.readyState == 4 || this.status == 200) {
                //__I.H_ide(ID2);
                //__I.S_how(ID2);
                var responsses = this.responseText;
                
                _(""+ID2+"").innerHTML=responsses;
                
            }
        },param);
        },
     //function that get location
     A_jaxGetShHidLoctn:function(URL){
                window.location=""+URL+"";  
        },
            
     //funct to handl show hide manipultn
     A_jaxGetShHidManipu:function(URL,id,ID2,ID3){
        __I.H_ide(ID2);
        __I.S_how(ID3);   
        ajax("widget/"+URL+"",function() {
            if (this.readyState == 4 || this.status == 200) {
                //__I.H_ide(ID2);
                var responsses = this.responseText;
                _(""+id+"").innerHTML=responsses;
            }
        });
        },
         //method that is interacting with DB pstin
     A_jaxGetShHidcogMani:function(URL,id,ID2,ID3,JamID){
        //get user input to uppercase
        var jamNum = (_(""+JamID+"").value).toUpperCase();
        //check if user input exist
        if(jamNum!=''){
            //trim user input
            var getj = __I.T_trim(jamNum);
            //send the dt to db
            var JamNum = "jamNUM="+getj;
            //this hide verify logo
            __I.H_ide(ID2);
            //this shows cog spin
            __I.S_how(ID3);
            //ajax connectn to db 
            ajaxPOST("widget/"+URL+"",function() {
                if (this.readyState == 4 || this.status == 200) {
                    //onsuccess, hide cog spin
                    __I.H_ide(ID3);
                     //onsuccess, show verify logo
                    __I.S_how(ID2);
                    var responsses = this.responseText;
                    //get responds back to pg
                        _(""+id+"").innerHTML=responsses;
                }
            },JamNum);
        }else{
            alert("PROVIDE JAMB NUMBER")
        }
        
        },
    //how to use ajax(r.php,id) note:use GET method and when u need cog spin in ur app
    A_jaxGetNOVaLNCog:function(URL,id,cogID){
        // _(""+id+"").innerHTML="unytr";
        __I.S_how(cogID);
        var logoadpro = _(""+cogID+"");
        logoadpro .className = logoadpro .className.replace("arrow-right", "cog");
        logoadpro .classList.add("fa-spin");
         ajax("widget/"+URL+"",function() {
             if (this.readyState == 4 || this.status == 200) {
                var logoadpro = _(""+cogID+"");
                logoadpro .className = logoadpro .className.replace("cog", "arrow-right");
                logoadpro .classList.remove("fa-spin");
                 var responsses = this.responseText;
                 _(""+id+"").innerHTML=responsses;
             }
         });
     },
     //function for window.loaction 
     L_ocation:function(URL,id){
        this.S_how(id);
        ajax(""+URL+"",function() {
            if (this.readyState == 4 || this.status == 200) {
                __I.H_ide(id);
                var responsses = this.responseText;
                if(responsses){
                window.location=""+URL+"";
                }
            }
        });
     },

 //call this function anytime u want to preview a selected PDF file
    R_eadMultipleFilesMainFUNCT:function(id,evt) {
        //Retrieve all the files from the FileList object
        var files = evt.target.files; 
        if (files) {
            for (var i=0, f; f=files[i]; i++) {
                  var r = new FileReader();
                r.onload = (function(f) {
                    return function(e) {
                        var contents = e.target.result;
                        var ty = f.name;
                        _(""+id+"").innerHTML=f.name;
                       /*alert( "Got the file.n" 
                              +"name: " + f.name + "n"
                              +"type: " + f.type + "n"
                              +"size: " + f.size + " bytesn"
                              + "starts with: " + contents.substr(1, contents.indexOf("n"))
                       );*/
                    };
                })(f);
    
                r.readAsText(f);
            }   
        } else {
              alert("Failed to load files"); 
        }
      },
 //call this function anytime u want to preview a selected image
      P_review_imageMainFUNCT:function(id,event) {
        var reader = new FileReader();
        reader.onload = function()
        {
         var output = document.getElementById(""+id+"");
         output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    },
    //onblur clearfontColo function
   
//function to trim both left and rtrim
    T_trim:function(val){
        return val.replace(/^\s+/, '').replace(/\s+$/, '');
    },
    //
    initAKSUStafSpinCog:function(){
        //document.body.insertAdjacentHTML('beforeend','<div id="exitSpinCog" class="w3-display-container aks-staff-ani" style="height:auto;"><div class="w3-display-middle"><i class="fa fa-cog w3-text-white fa-spin fa-3x fa-fw"></i></div></div>');
        _('exitSpinCog').style.display="block";
    },
    //exit spin akspin load
    exitinitAKSUStafSpinCog:function(){
        //var elem =_("exitSpinCog");
        //elem.parentElement.removeChild(elem);
        _('exitSpinCog').style.display="none";
       // alert("Processing........");
       // _("exitSpinCog").classList.add("aks-staff-exit-cog");
       // _("exitSpinCog").classList.remove("aks-staff-exit-cog");
    },
    //display a shot msg box during form validation
    aksuAKSUStaffAlert:function(msg){
        if(_('dispStaff')==null){
            myDialogueBoxes.initAKSUStaff();
        }
        _("aks_mry").innerHTML=msg;
        _("dispStaff").style.display="block";
        setTimeout('_("dispStaff").style.display="none"',1500);
    },
    //main msg formatn
    initAKSUStaff:function(){
        document.body.insertAdjacentHTML('beforeend','<div id="dispStaff" class="w3-display-container"><div class="w3-display-topmiddle"><div class="aks-alert-container w3-card-4 w3-display-container"><div id="aksdisplayinfo" class="aks-alert-content w3-display-middle"><div class="aks-info-arr"><i class="fa fa-exclamation-triangle"></i></div><div id="aks_mry" class="aks-main-alert"></div></div></div></div></div>');
    },    
//this function will always pass in calender when an element is focussed
    C_alender:function(calID){
        return myCalendar = new dhtmlXCalendarObject(""+calID+"");
     },
     //function to colo fontawesome when user click input btn. colr is the colo to pass in
     fontColo:function(id,colr){
        _(""+id+"").style.color=""+colr+"";
     },
 //function to colo fontawesome when user click input btn. colr is the colo to pass in
     fontColoBlack:function(id,colr){
        _(""+id+"").style.color=""+colr+"";
     },
     //function will change the backg img
     //var myImages = new Array(“usa.gif”,”canada.gif”,”jamaica.gif”,”mexico.gif”);
    changeImg:function(imgNumber){
        var imgClicked = document.images[imgNumber];
        var newImgNumber = Math.round(Math.random() * 3);
        while (imgClicked.src.indexOf(myImages[newImgNumber]) != -1)
        {
        newImgNumber = Math.round(Math.random() * 3);
        }
        imgClicked.src = myImages[newImgNumber];
        return false;
    },
    getLocate:function(URL){
        window.location=""+URL+"";
    },
    //methode to encode url
    encodeURLJS:function(URL){
        var reTENCODE = encodeURIComponent(URL)
        return reTENCODE;
    },
    //method that return the numba of element in an object
    objCount:function(ogarr1){
        var count= Object.keys(ogarr1).length
        return count;
    },
    //function to upload just image file
    GenLoginSys:{
        loginSys:function(usernva,pasrdval){
             if(_(usernva).value != ""){
                 if(_(pasrdval).value != ""){
                     __I.S_howV('hid_Cog');
                     sajx = "userNm="+escape(_(usernva).value)+"&pawd="+escape(_(pasrdval).value);
                     ajaxPOST("assets/genloginengine.php",function(){
                         if (this.readyState == 4) {
                             if(this.status == 200){
                                 var responsses = __I.T_trim(this.responseText);
                                 if(responsses == "@|"){
                                     __I.H_ideV('hid_Cog');
                                    window.location = 'widget/';
                                 }else{ __I.H_ideV('hid_Cog');__I.ControlAlertMsg.mainInit('Wrong password and username');return;}
                             }
                         }
                      },sajx);
                 }else{
                     __I.ControlAlertMsg.mainInit('Password needed'); 
                 }
             }else{
                 __I.ControlAlertMsg.mainInit('Username needed');
             }
            // // __I.ControlAlertMsg.mainInit('uuu');
        },
    },
}//end of __I object

//send with GET
function ajax(url,handler,param){
    var xhttp;
    xhttp = new XMLHttpRequest();
    //console.log("enter ajax");
    xhttp.onreadystatechange = handler; //end of xhttp object 

    xhttp.open("GET", url+"?"+param, true);
    /*xhttp.upload.onprogress = function(e){

    }
    
    */
    xhttp.send();
}
//send with POST
function ajaxPOST(url,handler,param){
    var xhttp;
    xhttp = new XMLHttpRequest();
    //console.log("enter ajax");
    xhttp.onreadystatechange = handler; //end of xhttp object 

    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(param);
}

//functions with progress bar and ajax
function ajaxPOSTProgreeBar(url,handler,param){
    var xhttp;
    xhttp = new XMLHttpRequest();
    //console.log("enter ajax");
    xhttp.onreadystatechange = handler; //end of xhttp object 

    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onprogress = function (e) {
        if (e.lengthComputable) {
            console.log(e.loaded+  " / " + e.total)
        }
    }
    xhttp.onloadstart = function (e) {
        console.log("start")
    }
    xhttp.onloadend = function (e) {
        console.log("end")
    }
    xhttp.send(param);
}
//send with post and file
function ajaxPOSTFile(url,handler,param){
    var xhttp;
    xhttp = new XMLHttpRequest();
    //console.log("enter ajax");
    xhttp.onreadystatechange = handler; //end of xhttp object 

    xhttp.open("POST", url, true);
    xhttp.send(param);
}
//this will print the entire content of the page

function printDivN(divName,btnID,btnID1,btnID2) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    _(btnID).style.display = "none";
    _(btnID1).style.display = "none";
    _(btnID2).style.display = "none";
    window.print();

    document.body.innerHTML = originalContents;
    _(btnID).style.display = "block";
    _(btnID1).style.display = "block";
    _(btnID2).style.display = "block";
}
function printDiv(divName,btnID) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    _(btnID).style.display = "none";
    // _(btnID1).style.display = "none";
    window.print();

    document.body.innerHTML = originalContents;
    _(btnID).style.display = "block";
    // _(btnID1).style.display = "block";
}
currentid = 0;
currentid2s = 0;
var ogarr1 = {};
var ogarr2s = {};
var sujBid;
var sujBid2s;
//this function update the O'Level
function T_ableComp(TBid,sujName,gradeid){
    //gradeid is the grade
    //TBid is the modal dialog
    //sujName is subject id
    sujBid = sujName;
     //getId1 = obj;//mtn
     //alert(sujName);//the smal dialog to show the content of a1, a2 etc
     //sujName. this represent the subject id
    // return;
     if(typeof ogarr1["subj_"+sujName] == "undefined" || ogarr1["subj_"+sujName] == null){
        currentid = sujName;
        //ogarr1["subj_"+sujName] = sujName;
       // alert(TBid);
       _(""+TBid+"").style.display="block";
     }else{
        _("grade_"+sujName).textContent = "";
        ogarr1["subj_"+sujName] = null;
        delete ogarr1["subj_"+sujName];
        
      // _("total").innerHTML = __I.objCount(ogarr1);
     }
    
     _("total").innerHTML = (__I.objCount(ogarr1));
 }
 
 //this function update the O'Level 2 sitting
function T_ableComp2s(TBid,sujName,gradeid){
    //gradeid is the grade
    //TBid is the modal dialog
    //sujName is subject id
    sujBid2s = sujName;
     //getId1 = obj;//mtn
     //alert(sujName);//the smal dialog to show the content of a1, a2 etc
     //sujName. this represent the subject id
    // return;
     if(typeof ogarr2s["subj2s_"+sujName] == "undefined" || ogarr2s["subj2s_"+sujName] == null){
        currentid2s = sujName;
        //ogarr1["subj_"+sujName] = sujName;
       // alert(TBid);
       _(""+TBid+"").style.display="block";
     }else{
        _("grade2s_"+sujName).textContent = "";
        ogarr2s["subj2s_"+sujName] = null;
        delete ogarr2s["subj2s_"+sujName];
      // _("total").innerHTML = __I.objCount(ogarr1);
     }
    //alert();
     _("total2s").innerHTML =(__I.objCount(ogarr2s));
     //_("total").innerHTML = (__I.objCount(ogarr1));
 }
 function O_level(obj,ID2){
     // obj is grade
     //ID2 is the modal that will display grades
    //var ogarr = [];
     /* alert(currentid);
     return; */
     if(currentid > 0){
        //var getID = obj.id;
        var t = _("subj_"+currentid).textContent;
       //if(typeof ogarr["Subid" == ])  
       //if(typeof ogarr["Subid",sujBid,"Gradeid",obj.id,"Grade",obj.textContent == "undefined"] || ogarr["Subid",sujBid,"Gradeid",obj.id,"Grade",obj.textContent == null]){
        //if(typeof ogarr["subj_"+currentid] == "undefined" || ogarr["subj_"+currentid] == null){
            ogarr1["subj_"+currentid]  = {"Subid":sujBid,"SubName":t,"Gradeid":obj.id,"Grade":obj.textContent};
                    //ogarr.push({"Subid":sujBid,"SubName":t,"Gradeid":obj.id,"Grade":obj.textContent});
                    _("grade_"+currentid).innerHTML = obj.textContent;
          //  }else{
                    //ogarr["Subid",sujBid,"Gradeid",obj.id,"Grade",obj.textContent == null];
           // }
            currentid = 0;
         //   ogarr.push({"Subid":sujBid,"SubName":t,"Gradeid":obj.id,"Grade":obj.textContent}) ; 
       // _("grade_"+currentid).innerHTML = obj.textContent;
       // _("total").innerHTML = ogarr.length;
        //console.log(JSON.stringify(ogarr1));
        //console.log(ogarr["Subid",sujBid,"Gradeid",obj.id,"Grade",obj.textContent == "undefined"] || ogarr["Subid",sujBid,"Gradeid",obj.id,"Grade",obj.textContent == null]);
        //alert((__I.objCount(ogarr1)));
        _("total").innerHTML = (__I.objCount(ogarr1));
     }
    
   // var myForm = _("tyy");
    //var myControls = myForm.elements['p_id[]'];
    //for(var i=0; i < myControls.length; i++){
    //    alert(myControls[i]);
   // }
   //var list ={}; var count= Object.keys(list).length;
    
    __I.H_ide(ID2);
  
 }
 //ol2s
 function O_level2s(obj,ID2){
    // obj is grade
    //ID2 is the modal that will display grades
   //var ogarr = [];
    /* alert(currentid);
    return; */
    if(currentid2s > 0){
       //var getID = obj.id;
       var t = _("subj2s_"+currentid2s).textContent;
      //if(typeof ogarr["Subid" == ])  
      //if(typeof ogarr["Subid",sujBid,"Gradeid",obj.id,"Grade",obj.textContent == "undefined"] || ogarr["Subid",sujBid,"Gradeid",obj.id,"Grade",obj.textContent == null]){
       //if(typeof ogarr["subj_"+currentid] == "undefined" || ogarr["subj_"+currentid] == null){
           ogarr2s["subj2s_"+currentid2s]  = {"Subid2s":sujBid2s,"SubName2s":t,"Gradeid2s":obj.id,"Grade2s":obj.textContent};
                   //ogarr.push({"Subid":sujBid,"SubName":t,"Gradeid":obj.id,"Grade":obj.textContent});
                   _("grade2s_"+currentid2s).innerHTML = obj.textContent;
         //  }else{
                   //ogarr["Subid",sujBid,"Gradeid",obj.id,"Grade",obj.textContent == null];
          // }
          
  
           currentid2s = 0;
        //   ogarr.push({"Subid":sujBid,"SubName":t,"Gradeid":obj.id,"Grade":obj.textContent}) ; 
      // _("grade_"+currentid).innerHTML = obj.textContent;
      // _("total").innerHTML = ogarr.length;
       //console.log(JSON.stringify(ogarr2s));
       //console.log(ogarr["Subid",sujBid,"Gradeid",obj.id,"Grade",obj.textContent == "undefined"] || ogarr["Subid",sujBid,"Gradeid",obj.id,"Grade",obj.textContent == null]);
      
        
      _("total2s").innerHTML = (__I.objCount(ogarr2s));
    }
   
  // var myForm = _("tyy");
   //var myControls = myForm.elements['p_id[]'];
   //for(var i=0; i < myControls.length; i++){
   //    alert(myControls[i]);
  // }
  //var list ={}; var count= Object.keys(list).length;
  
   __I.H_ide(ID2);
 
}
 /*investors js*/
 //function to change bg color when window is double clicked
 var u=0;
 var objy;
 function imgChange(id){
    objy = id;
     var getBgID = _(""+id+"");
     var bgCs = ["#4CAF50","#f9f9f9","#003300"];
        getBgID.style.background = bgCs[u];
    u++;
    if(u==4){
       imgChange(objy);
    }
 }
//var txt = 1;

 function focusLo(id,col){
     _(""+id+"").classList.toggle(""+col+"");
     //var t = _(""+id5+"").textContent;
     //ogarr[t] = getId1;
     //ogArr.push({"Sujname":t,"Score":getId1});
     //alert(ogArr.length);
    // alert(ogArr);
     //console.log( JSON.stringify(ogArr, null, "    ") );
     //_(""+id2+"").innerHTML = txt;
    //txt++;
 }
//
 
function choosecsv(rstpasport,mer){
    var data = new FormData();
    data.append("file1",document.querySelector("#"+rstpasport+"").files[0]);
        ajaxPOSTFile('widget/choosecsv.php',function(){
            if (this.readyState == 4 || this.status == 200) {
             var responsses = this.responseText;
             _(""+mer+"").innerHTML = responsses;
         }
    },data);  //"Category_id="+id+"&CategoryName="+value 
 }
 function newFormData(){
     var data = new FormData();
     return data;
 }
 //finction to loop through all the properties of an object
 function tbobject(objId,displ){
    
    /* */
     var objId = _(""+objId+"");
    // objid.requestPointerLock();
    var text = "";
    var x;
    for(x in objId){
        text += objId[x] + " ";
    }
    document.getElementById(""+displ+"").innerHTML = text;
 }
//function to add row to table
 var smalRow = 0;
 function addRow(tbObj){
    var objId = _(""+tbObj+"");
    var row = objId.insertRow(-1);
    var cell = row.insertCell(-1);
    var cell1 = row.insertCell(-1);
     var cell2 = row.insertCell(-1);
    var cell14 = row.insertCell(-1);
     var cell5 = row.insertCell(-1);
    var cell16 = row.insertCell(-1);
    var cell17 = row.insertCell(-1);
    var cell18 = row.insertCell(-1);
    cell.innerHTML = ""+smalRow+"";
    cell1.innerHTML = "<div contentEditable=true id='row_"+smalRow+"col1'></div>";
    cell2.innerHTML = "<div contentEditable=true id='row_"+smalRow+"col2'></div>";
    cell14.innerHTML = "<div contentEditable=true id='row_"+smalRow+"col3'></div>";
    cell5.innerHTML = "<div contentEditable=true id='row_"+smalRow+"col4'></div>";
    cell16.innerHTML = "<div contentEditable=true id='row_"+smalRow+"col5'></div>";
    cell17.innerHTML ="<div contentEditable=true id='row_"+smalRow+"col6'></div>";
    cell18.innerHTML = "<div contentEditable=true id='row_"+smalRow+"col7'></div>";
     smalRow++;
 }
//function that loops csv tith extra comma
function handleFileSelect(display,evt){
    var files = evt.target.files; // FileList object
    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++)
    {
        var reader = new FileReader();
        reader.onload = (function(reader)
        {
            return function()
            {
                var contents = reader.result;
                var lines = contents.split('\n');
                var i;

                for(i = 1; i < lines.length; i++){
                    var indline = lines[i];
                    if(indline === ""){
                        continue;
                    }
                    var qi = indline.indexOf('"');
                    do{
                  
                    if(qi > -1){ //opening qoute exist
                        var qic = indline.indexOf('"',qi+1);
                        if(qic > -1){ //closing qoute exist
                          var instr = indline.substr(qi,(qic-qi)+1);
                          var rp = instr.substr(1,instr.length - 2);
                          rp = rp.replace(",","~~#$%");
                          indline = indline.replace(instr,rp);
                          //alert(indline)
                        }
                    }
                    qi = indline.indexOf('"');
                    }while(qi > -1)
                    var slity = indline.split(",");
                    str = "<tr><td>"+smalRow+"</td>";
                    for(r = 0; r < slity.length; r++){
                     var filed = slity[r].replace("~~#$%",",");
                     str += "<td><div contentEditable=true>"+filed+"</div></td>"
                    }
                    str += "</tr>";
                    /* "<tr><td>"+smalRow+"</td><td><div contentEditable=true>"+slity[0]+"</div></td><td><div contentEditable=true>"+slity[1]+"</div></td><td><div contentEditable=true>"+slity[2]+"</div></td><td><div contentEditable=true>"+slity[3]+"</div></td><td><div contentEditable=true>"+slity[4]+"</div></td><td><div contentEditable=true>"+slity[5]+"</div></td><td><div contentEditable=true>"+slity[6]+"</div></td></tr>" */
                    _(""+display+"").insertAdjacentHTML("beforeend",str);
                    smalRow++;
                }
                //////
               // document.getElementById(""+display+"").innerHTML=contents;
               // document.getElementById(""+display+"").innerHTML=slity[0];
               // document.getElementById(""+display+"").innerHTML=lines[1];
            }
        })(reader);

        reader.readAsText(f);
    }
}
//function to check maximun file size upload
 validate = function(el) {
    var maxfilesize = 1024 * 1024;  // 1 Mb
    //var maxfilesize = 1024 * 1024,  // 1 Mb
        //filesize    = el.files[0].size,
        filesize    = el.files[0].size;
        
        warningel   = document.getElementById( 'lbError' );
  
    if ( filesize > maxfilesize )
    {
      warningel.innerHTML = "File too large: " + filesize + ". Maximum size: " + maxfilesize;
      return false;
    }
    else
    {
      warningel.innerHTML = '';
      return true;
    }   
  }
  //function to get file content and max file size too
  var fileName;
  var filesize;
  maxFileUpload = function(id,evt) {
    //Retrieve all the files from the FileList object
    var maxfilesize = 1024 * 1024;  // 1 Mb
    var files = evt.target.files; 
    filesize = _(""+id+"").files[0].size;
    if(filesize > maxfilesize){
        alert("MAXIMUM FILE SIZE SHOULD 100KB");
    }else{
        if (files) {
            for (var i=0, f; f=files[i]; i++) {
                  var r = new FileReader();
                r.onload = (function(f) {
                    return function(e) {
                       // var contents = e.target.result;
                        //var ty = f.name;
                        fileName=f.name;
                        //alert(f.name);
                       /*alert( "Got the file.n" 
                              +"name: " + f.name + "n"
                              +"type: " + f.type + "n"
                              +"size: " + f.size + " bytesn"
                              + "starts with: " + contents.substr(1, contents.indexOf("n"))
                       );*/
                    };
                })(f);
    
                r.readAsText(f);
            }   
        } else {
              alert("Failed to load files"); 
        }
    }
  }
//function that handles all tab code / horizontal tab
tabCode = function(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
} 
//function that handles tab with color as active. this vertical side bar tab
coloTabs = function(evt, cityName,id4) {
    _(id4).style.display = "none";
    var i, x, tablinks;
    x = document.getElementsByClassName("city");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < x.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" w3-indigo", ""); 
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " w3-indigo";
  }
// putme Engine
var putme = {
    // handdles panel recommendation
    recomd:{
        notAdmiss:function(IDThis){
            if(IDThis.value == "2"){
                __I.S_how('getResons');
            }else{__I.H_ide('getResons');}
        },
    },
    allAnimations:{
        putmeMsgBox:{
            mainInit:function(msg){
                if(_('payroll_alrt') == null){
                    this.init();
                }
                _('payrol_altMsg').innerHTML = msg;
                __I.S_how('payroll_alrt');// _('oveCnt').classList.add('alt-zoom-in');alt-ext-animate-top
            }, 
            init:function(){   
                document.body.insertAdjacentHTML('beforeend',
                    '<div id="payroll_alrt" class="spt-bigBox-cont"><div class="stp-border" style="width:100%;position:absolute;top:50%;left:0%;transform:translate(-0%,-50%);"><div id="reduceH" style="position:relative;width:inherit;height:180px;transition:0.4s;overflow-x:hidden;"><div class="putme-bgrcolor-altbox pay-anim-left1 stp-border" style="width:inherit;height:45px;text-align:center;color:white;padding:7px;font-size:20px;"><strong><i class="fa fa-exclamation-circle"></i> AKSU PUTME SCREENING</strong></div><div id="payrol_altMsg" class="pay-anim-right1 w3-xlarge" style="width:inherit;background-color:black;height:90px;text-align:center;padding:30px;color:white;"><strong></strong></div><div class="w3-black pay-anim-left1 " style="width:inherit;height:45px;text-align:center;padding:9px;position:relative;"><div title="Close" onclick="putme.allAnimations.putmeMsgBox.d_dismisal()" class="putme-bgrcolor-altbox pay-hover-ok" style="width:30px;height:30px;border-radius:50%;position:absolute;left:49%;cursor:pointer;"><div style="margin-top:5px;">ok</div></div></div></div></div></div>'
                );
            },
            ty:"",
            d_dismisal:function(){
                _('reduceH').style.height = "0px";
                __I.ControlAlertMsg.payrollCustom.ty = setTimeout(function(){__I.H_ide('payroll_alrt');_('reduceH').style.height = "180px";},300)
            },
        },
        putmeLoading:{
            // dstv loading
            mainInitLoading:function(msg){
                if(_('payroll_Loading') == null){
                    this.initLoading();
                }
                // _('payrol_altMsg-loading').innerHTML = msg;
                __I.S_how('payroll_Loading');// _('oveCnt').classList.add('alt-zoom-in');alt-ext-animate-top
            }, 
            initLoading:function(){
                document.body.insertAdjacentHTML('beforeend',
                    '<div id="payroll_Loading" class="spt-bigBox-cont-dst w3-animate-opacity w3-text-white"><div class="w3-display-container" style="height:100%;"><div id="" class="w3-display-middle"><div class="pay-loading-anm w3-xxlarge">Loading Candidate.</div></div></div></div>'
                );
            },
            exitLoad:function(){
                __I.H_ide('payroll_Loading');
            },
        },
        // show login page
        shLgin:function(){
            _('exitSubLogin').classList.add('putme-animate-zoom1');
            __I.S_how('exitLogin');
            setTimeout(function(){
                _('exitSubLogin').classList.remove('putme-animate-zoom1');
            },100)
        },
        // show home page
        shHome:function(IDHome){
            __I.S_how(IDHome);
        },
        exitContainer:function(cntr,extcnt){
            _(cntr).classList.add('alt-zoom-in-ext');
            setTimeout(function(){
                __I.H_ide(extcnt);
                _(cntr).classList.remove('alt-zoom-in-ext');
            },500);
        },
        logAcess:function(cntr,extcnt){
            var jsonComp,inArr,i,elem;
            inArr = [
                [_('putm_usern').value,"Provide Username"],
                [_('putme_paswr').value,"Provide Password"]
            ];
            for(i = 0; i < inArr.length; i++){
                elem = inArr[i];
                if(elem[0] == ""){__I.ControlAlertMsg.mainInit(elem[1]);return;}
            }
            jsonComp = {"d_USN":__I.T_trim(_('putm_usern').value),"d_PSW":__I.T_trim(_('putme_paswr').value)};
            __I.H_ide('d_btnmain');
            __I.S_how('d_hid_Cog');
            ajaxPOST('script/userlogin.php',function() {

                if (this.readyState == 4) {
                    if(this.status == 200){
                        __I.H_ide('d_hid_Cog');
                        __I.S_how('d_btnmain');
                        var responsses = __I.T_trim(this.responseText);
                        switch(responsses){

                            case "*2":
                                putme.allAnimations.exitContainer(cntr,extcnt);
                            break;

                            case "*3":
                               //window.location = "medicals/"; 
                            break;

                            default:
                                __I.ControlAlertMsg.mainInit('Contact AKSU ICT');return;
                            break;
                        }
                    }
                }
            },'d_userD='+escape(JSON.stringify(jsonComp)));
        },
        sideBarLeftOver:function(widL){
            _(widL).style.width = "150px";
        },
        sideBarLeftOut:function(widL){
            _(widL).style.width = "49px";
        },
        Pin:{
            shPin:function(){
                __I.S_how('exitLogPinpage');
            },
            pointer:0,
            calC:function(calID){
                this.pointer++;
                var getTvlue = _('getTvlue').value+=__I.T_trim(calID.innerText);
                var str = __I.T_trim(calID.innerText);
                _('getCalVal').innerText += str.replace(__I.T_trim(calID.innerText), "*");
               if(this.pointer == 4){
                this.pointer = 0;
                    _('getCalVal').innerText = "";
                    _('getTvlue').value = "";
                //    alert(getTvlue); 
                if(getTvlue == 1111){
                    putme.allAnimations.exitContainer('exitsubPinPg','exitLogPinpage');
                }
               }
            },
            calclear:function(){
                _('getCalVal').innerText = "";
            },
        },
  }    
};
  



  document.addEventListener("DOMContentLoaded",function(e){

});
//javascript:window.open(window.clickTag)
//transform: scale(1); transform-origin: 0px 0px 0px;
//   function removeFadeOut(el) {
//       el.classList.remove('visible');
//       el.classList.add('hidden');
//   }