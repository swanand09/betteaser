/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    window.formFlag=0;
    window.countryFlag=0;
    
    
    var btn = $('#createAcc');
    btn.attr('disabled', 'disabled');
    $('#msg').show();
    
    $('#chkTerms').change(function(e){
       if ((this.checked)&&(window.formFlag==1)&&(window.countryFlag==1)){
           btn.removeAttr('disabled');
           $('#msg').hide();
           
           //if($('#country').options){
           //     $('#betCurr').setCustomValidity('C')
           //}
           if($("#country :selected").text()=='Select your Country'){
               //alert('Good');
               //$("#country").setCustomValidity('Select your country of residence.')
           }
           
            
       }else{
           btn.attr('disabled', 'disabled');
           $('#msg').show();
       }
    });
    
    $('#createAcc').click(function(){
        var accept = $('input:checkbox[name=chkTerms]:checked').val()
        if(accept==1){
           var title=$('#title').val();
           var fname=$('#fname').val();
           var sname=$('#sname').val();
           var gender = $('input:radio[name=gender]:checked').val();
           var country = document.getElementById('country').options[document.getElementById('country').selectedIndex].text
           var address1=$('#address1').val();
           var address2=$('#address2').val();
           var address=''
           if($.trim(address2)!=''){
               address=address1+' '+address2;
           }else{
               address=address1;
           }

           //alert(title);

           var town=$('#town').val();
           var postcode=$('#postcode').val();
           var dat=document.getElementById('dd').options[document.getElementById('dd').selectedIndex].text;
           var mon=document.getElementById('mm').options[document.getElementById('mm').selectedIndex].text;
           var yr=document.getElementById('yyyy').options[document.getElementById('yyyy').selectedIndex].text;
           var dob=dat+'/'+mon+'/'+yr;
           var email=$('#email').val();
           var counCode=$('#countryCode').val();
           var mobile=$('#mobile').val();
           var username=$('#username').val();
           var pass=$('#pass').val();
           var cpass=$('#cpass').val();
           var quesId=document.getElementById('question').options[document.getElementById('question').selectedIndex].value;
           var answer=$('#answer').val();
           var currency=$('#betCurr').val();
           var promoCode=$('#promocode').val();
           var mailPromo = $('input:checkbox[name=chkNews]:checked').val();
           if(mailPromo!=1){
               mailPromo=0;
           }
        }else{
            btn.attr('disabled', 'disabled');
            $('#msg').show();
        }
        

       //return false;
    });
    

    $('#username').keyup(username_check);
    
    $('#rPass').click(function(){
        
        $('#errStep1').css('display','none');
        
        inputVal = jQuery.trim($('#rUname').val());
        if(inputVal==''){
            inputVal = jQuery.trim($('#rEmail').val());
            if(inputVal==''){
                //alert('plz fill one of the above field.');
                $('#errStep1').text('Please fill one of the above fields to start processing your request.');
                $('#errStep1').css('display','block');
            }else{
                //call next step
                //alert('validating email'+inputVal);
                getSeqQues('email', inputVal);
            }
        }else{
            //call next step
            //alert('validating uname'+inputVal);
            getSeqQues('uname', inputVal);
        }
        
        //showStep(seqQues);
        
        return false; 
    });
    
    $('#rAnsSubmit').click(function(){
        iStep1 = jQuery.trim($('#rUname').val());
        if(iStep1==''){
            iStep1 = jQuery.trim($('#rEmail').val());
            if(iStep1!=''){
                field='mail';
            }
        }else{
            field='uname';
        }
        
        
        inputVal = jQuery.trim($('#rAnswer').val());
        if(inputVal==''){
            $('#errStep2').text('Please answer the above question to start processing your request.');
            $('#errStep2').css('display','block');
        }else{
            checkAnswer(inputVal, field, iStep1);
        }
        
       
       return false; 
    });
    
           
});

function getSeqQues(field, valu){
    var action;

    action='getSeqQuestion';
    $.ajax({
        url:'fgetpass.php',
        type:'POST',
        cache: false,
        data:'field='+field+'&val='+valu+'&action='+action,
        success:function(data){
            if(data==''){
                $('#errStep1').text('Information entered does not match our records.');
                $('#errStep1').css('display','block');
            }else{
                showStep(seqQues);
                $('#seqQ').text(data+'?');
            }
            
                                    
        }
    });
}

function checkAnswer(ans, field, valu){
    var action;

    action='getAnswer';
    $.ajax({
        url:'fgetpass.php',
        type:'POST',
        cache: false,
        data:'ans='+ans+'&field='+field+'&valu='+valu+'&action='+action,
        success:function(data){
            if(data==''){
                $('#errStep2').text('The answer does not match the information you have put when registering.');
                $('#errStep2').css('display','block');
            }else{
                $('#msgStep3').text(data);
                showStep(step3);
                
            }
        }
    });
}

function showStep(id){
    $('#registration').css('display','none');
    $('#seqQues').css('display','none');
    $('#step3').css('display','none');
    $(id).css('display','block');
    
}

function username_check(){
    var username=$('#username').val();
    
    if(username==""){
        $('#username').css({
                'border':'1px solid #aaa',
                'box-shadow': '0px 0px 3px #ccc',
                'background': '#fff'
           });
    }else if(username.length > 5){
        jQuery.ajax({
           type: "POST",
           url: "checkUsn.php",
           data: 'username='+ username,
           cache: false,
           success: function(response){
        if(response == 1){
           $('#username').css({
                border: '1px #C33 solid',
                background: '#fff url("images/forms/invalid.png") no-repeat 98% center'
           });
           document.getElementById('username').setCustomValidity('Username is unavailable, please choose another one.');
           $('#usnMsg').text("Username is unavailable, please choose another one.");
        }else{
           $('#username').css({
               border: '1px #090 solid',
               background: '#fff url("images/forms/valid.png") no-repeat 98% center'
           });
           document.getElementById('username').setCustomValidity('');
           
        }

    }
        });
        
    }else{
        $('#username').css({
            border: '1px #C33 solid',
            background: '#fff url("images/forms/invalid.png") no-repeat 98% center'
        });
        //$('#username').css('background', '#fff url(../images/forms/invalid.png) no-repeat 98% center');
           document.getElementById('username').setCustomValidity('Enter your desired username. It must be at least 6 characters.');
           $('#usnMsg').text("Enter your desired username. It must be at least 6 characters.");
    }
}

function validatePass(p1, p2) {
    if (p1.value != p2.value || p1.value == '' || p2.value == '') {
        p2.setCustomValidity('Confirm password not matching.');
        /*$('#createAcc').attr('disabled', 'disabled');
        $('#msg').show();
        window.formFlag=0; */
    } else {
        p2.setCustomValidity('');
        /* $('#createAcc').removeAttr('disabled');
        $('#msg').hide();
        window.formFlag=1; */
    }
}

function changeField(country, curr, ph)
{
    var index = country.options[country.selectedIndex].value;
    
    //alert(index);
    if (index<1){
        $('#ctrMsg').text("Please select your country of residence.");
        $('#ctrMsg').css("display","inline");
        $('#createAcc').attr('disabled', 'disabled');
        document.getElementById('betCurr').value="";
        document.getElementById('countryCode').value="";
        $('#msg').show();
        window.countryFlag=0
    }else{
        curr.selectedIndex=index;
        ph.selectedIndex=index;

        document.getElementById('countryCode').value='+'+ph.options[ph.selectedIndex].text;
        document.getElementById('betCurr').value=curr.options[curr.selectedIndex].text;

            
        $('#ctrMsg').css("display","none");
        $('#createAcc').removeAttr('disabled');
        $('#msg').hide();
        window.countryFlag=1
    }
    

}

function validateDate(dd, mm, yy){
    var dat=dd.options[dd.selectedIndex].text
    var mon=mm.options[mm.selectedIndex].value
    var yer=yy.options[yy.selectedIndex].text
    var age=18;
    
    
    
    if((dat != 'DD')&&(mon != '-1')&&(yer != 'YYYY')){
        
        
        //$('#dateMsg').text("Validate...");
        //$('#dateMsg').css("display","inline");
        
        if(isDate(mon+'/'+dat+'/'+yer)){
            var mydate = new Date();
            mydate.setFullYear(yer, mon-1, dat);

            var currdate = new Date();
            currdate.setFullYear(currdate.getFullYear() - age);
            document.getElementById("chkTerms").checked = false;
            
            if ((currdate - mydate) < 0){
                $('#dateMsg').text("You are not eligible. Come back when you have the right age.");
                $('#dateMsg').css("display","inline");
                $('#createAcc').attr('disabled', 'disabled');
                
                $('#msg').show();
                window.formFlag=0;
            }else{
                $('#dateMsg').css("display","none");
                //$('#createAcc').removeAttr('disabled');
                //$('#msg').hide();
                window.formFlag=1;
            }
        }else{
                $('#dateMsg').text("You have chosen an invalid date.");
                $('#dateMsg').css("display","inline");
                $('#createAcc').attr('disabled', 'disabled');
                document.getElementById("chkTerms").checked = false;
                $('#msg').show();
                window.formFlag=0;
                
        }
        
    }else{
        $('#dateMsg').text("Please fill your date of birth.");
        $('#dateMsg').css("display","inline");
        $('#createAcc').attr('disabled', 'disabled');
        $('#msg').show();
        window.formFlag=0;
    }
    
}

function isDate(txtDate)
    {
        var currVal = txtDate;
        if(currVal == '')
            return false;

        var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
        var dtArray = currVal.match(rxDatePattern); // is format OK?

        if (dtArray == null)
            return false;

        //Checks for mm/dd/yyyy format.
        dtMonth = dtArray[1];
        dtDay= dtArray[3];
        dtYear = dtArray[5];        

        if (dtMonth < 1 || dtMonth > 12)
            return false;
        else if (dtDay < 1 || dtDay> 31)
            return false;
        else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
            return false;
        else if (dtMonth == 2)
        {
            var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
            if (dtDay> 29 || (dtDay ==29 && !isleap))
                    return false;
        }
        return true;
    }
    