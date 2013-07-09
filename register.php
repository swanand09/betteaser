<?php 
    //session_start();
        
    require '\include\top_links.php';
    include 'utility\ClassCountry.php';
    include '\utility\ClassClient.php';
    
    
    if ($_SESSION['status'] == 'authorized'){
        header("location: racebook/index.php");
    }
    
    
    $i=0;
    $countryList=getCountryList();
    
    $yr=create_year_dropdown();
    $dat=create_date();
    $qlist=getQuestionList();
    
//    if(!isset($_SESSION['clientId'])){  
//        $_SESSION['clientId']=0;
//    }
//
//    echo $_SESSION['clientId'];
    

    
    $countryName.="<OPTION VALUE='-1'>Select your Country</option>";
    $phoneCode.="<OPTION VALUE='-1'>--</option>";
    $currCode.="<OPTION VALUE='-1'>--</option>";
    
    while ($i<sizeof($countryList)){
        $id=$countryList[$i][0];
  	$countryname=$countryList[$i][1];
  	$curr=$countryList[$i][2];
  	$phcode=$countryList[$i][3];
        
        $countryName.="<OPTION VALUE=\"$id\">".$countryname.'</option>';
        $phoneCode.="<OPTION VALUE=\"$id\">".$phcode.'</option>';
        $currCode.="<OPTION VALUE=\"$id\">".$curr.'</option>';
        
        $i++;
    }
    
    $i=0;
    
    while ($i<sizeof($qlist)){
        $quesList.="<OPTION VALUE=".$qlist[$i][0].">".$qlist[$i][1].'</option>';
        $i++; 
    }
    //echo $_SERVER['REMOTE_ADDR'];
    
?>

<?php //Process Registration
    $flagErr=0;$newClientFlag=0;
    $errString='<h3>ERROR NOTIFICATION</h3><p>Please review the following:</p>';
    
    if (isset($_POST['createAcc'])){
        $pTitle=$_POST['title'];
        $pFname=$_POST['fname'];
        $pSname=$_POST['sname'];
        
        $modFname=$pFname;
        $modSname=$pSname;
        
        $pGender=$_POST['gender'];
        $pCountry=$_POST['country'];
        $pCountry=getCountryName($pCountry);
        $pAddress1=$_POST['address1'];
        $pAddress2=$_POST['address2'];
        
        if(trim($pAddress2)!=''){
            $qAddress=trim($pAddress1).', '.trim($pAddress2);
        }else{
            $qAddress=trim($pAddress1);
        }
        
        
        $pTown=$_POST['town'];
        $pPostcode=$_POST['postcode'];
        $pDD=$_POST['dd'];
        $pMM=$_POST['mm'];
        $pYY=$_POST['yyyy'];
        
        
        $pEmail=strtolower($_POST['email']);
        $pPhcode=$_POST['countryCode'];
        $pMobile=$_POST['mobile'];
        $pUname=strtolower($_POST['username']);
        $pPass=$_POST['pass'];
        $pCpass=$_POST['cpass'];
        $pQues=$_POST['question'];
        $pAns=$_POST['answer'];
        $pCurr=$_POST['betCurr'];
        $pPromoCode=trim($_POST['promocode']);
        if($_POST['chkNews']==1){
            $pMailPromo=$_POST['chkNews']; //1 mail, 0 do not mail
        }else{
            $pMailPromo=0;
        }
        if($_POST['chkTerms']==1){
            $pAccTerms=$_POST['chkTerms'];
        }else{
            $pAccTerms=0;
            $flagErr=1;
            $errString.='<p>Please accept our Terms & Conditions.</p>';
        }
        if ( !preg_match("/^[À-ÿA-Za-z\\-\\., \']{3,20}+$/", $pFname) ) {
            $flagErr=1;
            $errString.='<p>Field first name contain errors.</p>';
        }
        if ( !preg_match("/^[À-ÿA-Za-z\\-\\., \']{3,20}+$/", $pSname) ) {
            $flagErr=1;
            $errString.='<p>Field surname contain errors.</p>';
        }
        if ( strlen($qAddress) < 3 ) {
            $flagErr=1;
            $errString.='<p>Field address contain errors.</p>';
        }
        if ( strlen(trim($pTown)) < 2 ) {
            $flagErr=1;
            $errString.='<p>Field town contain errors.</p>';
        }
        if (( strlen(trim($pPostcode)) < 3 ) && (trim($pPostcode!=''))){
            $flagErr=1;
            $errString.='<p>Field postcode contain errors.</p>';
        }
        if ( !filter_var($pEmail,FILTER_VALIDATE_EMAIL) ) {
            $flagErr=1;
            $errString.='<p>You have entered an invalid email address.</p>';
        }else{
            if(Client::checkClientEmail($pEmail)){
                $flagErr=1;
                $errString.='<p>You are allowed to use one account per customer. Please sign in or use the forget password facility if you forgot yours.</p>';
            }
        }
        if ((trim($pPhcode)=='')&&(trim($pCurr)=='')){
            $flagErr=1;
            $errString.='<p>Please select your country of residence.</p>';
        }
        if (( !preg_match("/^[0-9]{5,15}+$/", $pMobile) ) && (trim($pMobile!='')) ) {
            $flagErr=1;
            $errString.='<p>The phone number contain errors.</p>';
        }
        if ( strlen(trim($pPass)) < 7 ) {
            $flagErr=1;
            $errString.='<p>Please enter a valid password.</p>';
        }
        if (trim($pPass)!=trim($pCpass)) {
            $flagErr=1;
            $errString.='<p>Confirm password does not match with password.</p>';
        }
        if ( strlen(trim($pAns)) < 3 ) {
            $flagErr=1;
            $errString.='<p>Please enter a valid answer.</p>';
        }
        if ( strlen(trim($pUname)) < 5 ) {
            $flagErr=1;
            $errString.='<p>Please enter a valid username.</p>';
        }else{
            $username = trim(strtolower($pUname));
            $username = mysql_escape_string($username);

            if(Client::checkClientUsn($username)){
                $flagErr=1;
                $errString.='<p>Username already exist. Please choose another one.</p>';
            }
        }
        if((strlen($pPromoCode) < 3)&&($pPromoCode!='')){
            $flagErr=1;
            $errString.='<p>You have entered an invalid promotion code.</p>';
        }
        

        //if accept agreement --> insert in db

        if(($pDD!=-1)&&($pMM!=-1)&&($pYY!=-1)){
            if(checkdate($pMM, $pDD, $pYY)){
                if(!((intval($pYY) < (intval(date("Y") - 19)))||(intval($pYY) == (intval(date("Y")) - 18) &&
                    (intval($pMM) < intval(date("m")))) || (intval($pYY) == (intval(date("Y")) - 18) &&
                    (intval($pMM) ==  intval(date("m"))) && (intval($pDD) <= intval(date("d")))))){
                    $flagErr=1;
                    $errString.='<p>You must be at least 18 years old to register. Come back when you have the right age.</p>';
                }else{
                    $pDob=$pDD.'/'.$pMM.'/'.$pYY;
                }        
            }else{
                $flagErr=1;
                $errString.='<p>You have entered an invalid date.</p>';
            }    
        }else{
            $flagErr=1;
            $errString.='<p>You have chosen an invalid date.</p>';
        }

        if ($flagErr==1){
            $echoError=$errString;
            
        }
        if ($flagErr==0){
            //create new Client, if successful go to step2
            
            $cust = new Client();

            $cust->set_title($pTitle);
            $cust->set_fname(mysql_escape_string($pFname));
            $cust->set_sname(mysql_escape_string($pSname));
            $cust->set_gender($pGender);
            $cust->set_address(mysql_escape_string($qAddress));
            $cust->set_country($pCountry);
            $cust->set_town(mysql_escape_string($pTown));
            $cust->set_postcode(mysql_escape_string($pPostcode));
            $cust->set_dob($pDob);
            $cust->set_email(mysql_escape_string($pEmail));
            $cust->set_ccode($pPhcode);
            $cust->set_mobile(mysql_escape_string($pMobile));
            $cust->set_username(mysql_escape_string(strtolower($pUname)));
            $cust->set_password(sha1(mysql_escape_string($pPass)));
            $cust->set_refQuestion(mysql_escape_string($pQues));
            $cust->set_answer(mysql_escape_string($pAns));
            $cust->set_curr(mysql_escape_string($pCurr));
            $cust->set_promoCode(mysql_escape_string($pPromoCode));
            $cust->set_acceptNews($pMailPromo);
            $cust->set_above18($pAccTerms);
            $cust->set_hash(md5(rand(0, 1000)));

            //$_SESSION['clientId'] = 
            $cl_id=$cust->createClient();
            
            
            //Send activation email
            $cust->sendActivationMail($cl_id);
            
            
            $newClientFlag = 1;

            $pFname = '';
            $pSname = '';
            $pAddress1 = '';
            $pAddress2 = '';
            $pTown = '';
            $pPostcode = '';
            $pEmail = '';
            $pPhcode = '';
            $pMobile = '';
            $pUname = '';
            $pPass = '';
            $pCpass = '';
            $pAns = '';
            $pCurr = '';
            $pPromoCode = '';
    }
    
    
}
    
    
    
    
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to BetTeaser</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/reset.css"/>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/JWslider.css"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="js/jQuery.JWslider.js"></script>
        <script src="js/regform.js"></script>
        <script src="js/regform-modal.js"></script>
        
    </head>
    <body>
        <div id="header-stretch">
             <div id="header" class="container">
                 <?php echo $hdrlogo; ?>
                 <?php echo $hdrlinks; ?>
             </div><!-- header -->
        </div><!-- header stretch -->
        <div id="menu-stretch">
            <div id="menu" class="container">
                 <?php echo $toplinks; ?>
            </div>
        </div><!-- Menu stretch-->
        <div id="slider-stretch">
             <div id="slider" class="container">
                    <div id="slidebanner-right">
                        <img src="images/slide/1.jpg" width="710" height="300" /></li>
                    </div>
                     <div id="slidebanner-left">
                         
                     </div>

             </div><!-- Slider -->
        </div><!-- Slider Stretch -->
        <div id="main-container" class="container">
            <div id="register-container">
                
                <!-- Start Test Modal -->
                <div id="boxes">
                    <div style="top: 199.5px; left: 551.5px; display: none;" id="dialog" class="window">
                        <h2>Welcome <?php echo $modFname.' '.$modSname; ?></h2>
                        <p>Thank-you for creating an account with us. Please verify your account by clicking the activation link that has been sent to your email.</p>
                        <a href="#" class="close">CLOSE</a>
                    </div>
                    <!-- Mask to cover the whole screen -->
                    <div style="width: 1478px; height: 602px; display: none; opacity: 0.8;" id="mask"></div>
                </div>
                <!-- End Test Modal -->
                
                <div id="notice" class="register">
                    <h3>NOTICE</h3>
                    <p>The information below is required in order to authenticate our future customers. Rest assured that your information are safe and secure with us.<br/>You are not allowed to register if you are under 18 years old.</p>
                        <p><span id="required">*</span>Fields marked with an asterisk must be filled.</p>
                        <span id="errNotif"><?php echo $echoError ?></span>
                </div>
                <div id="registration" class="register">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off" id="frmRegistration" name="regForm">
                        <fieldset id="personalInfo">
                        <legend>Personal Information</legend>
                        <ol>
                            <li>
                                <input type="hidden" name="newClient" id="newClient" value="<?php echo $newClientFlag; ?>"/>
                                <label for="title">Title<span id="required">*</span></label>
                                <select name="title"  id="title" autofocus>
                                    <option value = "Mr">Mr</option>
                                    <option value = "Mrs">Mrs</option>
                                </select>
                            </li>
                            <li>
                                <label for="fname">First name<span id="required">*</span></label>
                                <input id="fname" name=fname type=text placeholder="" pattern="[a-zA-ZÀ-ÿ ]{3,25}" value="<?php echo $pFname; ?>" required ></input>
                                <span class="form_hint">Please enter your first name.</span>
                            </li>
                            <li>
                                <label for=Sname>Surname<span id="required">*</span></label>
                                <input id="sname" name=sname type=text placeholder="" pattern="[a-zA-ZÀ-ÿ ]{3,25}" value="<?php echo $pSname; ?>" required ></input>
                                <span class="form_hint">Please enter your surname.</span>
                            </li>
                        
                            <li>
                                <label for=gender>Gender<span id="required">*</span></label>
                                <input id=male name=gender type=radio value="Male"  checked = "checked">
                                <label for=male>Male</label>
                                <input id=female name=gender value="Female" type=radio>
                                <label for=female>Female</label>
                            </li>
                            <li>
                                <label for=country>Country of residence<span id="required">*</span></label>
                                <select id = "country" name="country" onChange="changeField(this, document.getElementById('curren'), document.getElementById('ph'))" required >
                                   <?php echo $countryName ?>
                                 </select>
                                <div id="ctrMsg"></div>
                            </li>
                            <li>
                                <label for=address>Address<span id="required">*</span></label>
                                <input id=address1 name=address1 pattern="[a-zA-ZÀ-ÿ0-9 ]{3,30}" type=text placeholder="" value="<?php echo $pAddress1; ?>" required ></input>
                                <span class="form_hint">Please enter your residential address.</span>
                            </li>
                            <li>
                                <label for=address2>&nbsp;</label>
                                <input id=address2 name=address2 pattern="[a-zA-ZÀ-ÿ0-9 ]{3,30}"  type=text placeholder="" value="<?php echo $pAddress2; ?>"></input>
                                <span class="form_hint">Please enter your residential address.</span>
                            </li>
                            <li>
                                <label for=town>Town / City<span id="required">*</span></label>
                                <input id=town name=town type=text pattern="[a-zA-ZÀ-ÿ ]{3,30}" placeholder="" required value="<?php echo $pTown; ?>" ></input>
                                <span class="form_hint">Please enter your city or town.</span>
                            </li>
                            <li>
                                <label for=postcode>Postcode</label>
                                <input id=postcode name=postcode type=text placeholder="" pattern="[a-zA-Z0-9 ]{2,9}" value="<?php echo $pPostcode; ?>" ></input>
                                <span class="form_hint">Please enter your postcode.</span>
                            </li>
                            <li>
                                <label for=dob>Date of Birth<span id="dob">[DD-MM-YYYY]</span><span id="required">*</span></label>
                                 <select name="dd" id = "dd" onChange="validateDate(this, document.getElementById('mm'), document.getElementById('yyyy'))" >
                                   <?php echo $dat; ?>
                                 </select>
                                 <select name="mm" id = "mm" onChange="validateDate(document.getElementById('dd'), this, document.getElementById('yyyy'))" >
                                   <option value = "-1">MM</option>
                                   <option value = "01">Jan</option>
                                   <option value = "02">Feb</option>
                                   <option value = "03">Mar</option>
                                   <option value = "04">Apr</option>
                                   <option value = "05">May</option>
                                   <option value = "06">Jun</option>
                                   <option value = "07">Jul</option>
                                   <option value = "08">Aug</option>
                                   <option value = "09">Sep</option>
                                   <option value = "10">Oct</option>
                                   <option value = "11">Nov</option>
                                   <option value = "12">Dec</option>
                                 </select>
                                 <select name="yyyy" id = "yyyy"onChange="validateDate(document.getElementById('dd'), document.getElementById('mm'), this)">
                                   <?php echo $yr; ?>
                                 </select>
                                <div id="dateMsg"></div>
                            </li>
                            <li>
                                <label for=email>Email<span id="required">*</span></label>
                                <input id=email name=email type=text placeholder="" pattern="^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$" value="<?php echo $pEmail; ?>" required ></input>
                                <span id="emailMsg" class="form_hint">Please enter your email address. An activation code will be sent to complete registration.</span>
                            </li>
                            <li>
                                <label for=mobile>Mobile</label>
                                <input id="countryCode" name="countryCode" type="text" value="<?php echo $pPhcode; ?>" readonly="readonly"></input>
                                <input id=mobile name=mobile type=text placeholder="" value="<?php echo $pMobile; ?>" pattern="[0-9]{6,15}" ></input>
                                <span class="form_hint">Please enter your mobile number.</span>
                            </li>
                        </ol>
                        </fieldset>
                        <div id="controls">
                            <select id = "ph" >
                                   <?php echo $phoneCode ?>
                            </select>
                            <select id = "curren" >
                                   <?php echo $currCode ?>
                            </select>
                        </div>
                        <hr/>
                        <fieldset id="accInfo">
                        <legend>Account Information</legend>
                        <ol>
                            <li>
                                <label for=username>Username<span id="required">*</span></label>
                                <input id=username name=username type=text placeholder="" value="<?php echo $pUname; ?>" pattern="^[a-zA-ZÀ-ÿ][a-zA-ZÀ-ÿ0-9.]{5,20}$" required ></input>
                                <span id="usnMsg" class="form_hint">Enter your desired username. It must be at least 6 characters.</span>
                            </li>
                            <li>
                                <label for=pass>Password<span id="required">*</span></label>
                                <?php //(?=^.{7,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$ ?>
                                <input id=pass name=pass type=password value="<?php echo $pPass; ?>" pattern="\w{7,}" placeholder="" required ></input>
                                <span class="form_hint">Enter your desired password for signing in. We recommend password should contain at least 7 characters and a combination of [A-Z], [a-z] and numbers</span>
                            </li>
                            <li>
                                <label for=cpass>Confirm Password<span id="required">*</span></label>
                                <input id=cpass name=cpass type=password placeholder="" value="<?php echo $pCpass; ?>" required 
                                       onfocus="validatePass(document.getElementById('pass'), this);" 
                                       oninput="validatePass(document.getElementById('pass'), this);"
                                       onblur="validatePass(document.getElementById('pass'), this);"></input>
                                <span class="form_hint">Please re-enter your password. It must be exactly the same as the previous field.</span>
                            </li>
                            <li>
                                <label for=question>Question<span id="required">*</span></label>
                                 <select id = "question" name="question">
                                   <?php echo $quesList; ?>
                                 </select>
                            </li>
                            <li>
                                <label for="answer">Answer<span id="required">*</span></label>
                                <input id="answer" value="<?php echo $pAns; ?>" name="answer" type=text placeholder="" required pattern="[a-zA-ZÀ-ÿ ]{3,20}" ></input>
                                <span class="form_hint">Please answer the above question. This information will be used to reset your password if you forget it.</span>
                            </li>
                            <li>
                                <label for=curr>Betting Currency<span id="required">*</span></label>
                                 <input id="betCurr" name="betCurr" value="<?php echo $pCurr; ?>" type="text" readonly="readonly" required></input>
                                 <span class="form_hint">Please select your country of residence.</span>
                            </li>
                        </ol>
                        </fieldset>
                        <hr/>
                        <fieldset id="promotions">
                        <legend>Promotions</legend>
                        <ol>
                            <li>
                                <label for=promocode>Promotion Code</label>
                                <input id=promocode name=promocode type=text placeholder="" value="<?php echo $pPromoCode; ?>" ></input>
                                <span class="form_hint">Please enter your promotion code.</span>
                            </li>
                            <li>
                                 <input type = "checkbox"
                                     id = "chkNews" name="chkNews"
                                     value = "1" checked = "checked"/>
                                 <label for = "chkNews">Please send me mail alerts concerning horse racing news, race status, horse withdrawals and product promotions.</label>
                            </li>
                        </ol>
                        </fieldset>
                        <hr/>
                        <fieldset>
                        <legend></legend>
                        <ol>
                            <li>
                                <input type = "checkbox" name="chkTerms"
                                     id = "chkTerms"
                                     value = "1" />
                                 <label for = "chkTerms">I confirm that I am at least 18 years old and have read BetTeaser's <a href="rules.php" target="_blank">Terms and Conditions</a></label>
                            </li>
                            
                        </ol>
                        </fieldset>
                        <fieldset>
                            <span id="msg">Please tick the above check box and ensure that the registration form has been filled correctly.</span><br/><br/>
                            <button type=submit name="createAcc" id="createAcc">Create Account</button>
                        </fieldset>
                    </form>
                </div>
                <div id="regRight">
                        
                </div>
            </div><!-- features -->
            
            <img src="images/paymethods.gif" alt="payment"/>
        </div><!-- main container -->

        
        <div id="footer-stretch">
            <div id="footer" class="container">
               <?php echo $footerText; ?>
            </div><!-- footer -->
        </div><!-- footer-stretch -->
    </body>
</html>