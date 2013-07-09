/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
   
    $('#wforecast').weatherfeed(['MPXX0004']);
    
    if ($('#mauTime .time').length>0){ 
        $('#mauTime .time').remove();
    }
    var offset = 4;   
    if (offset == ''){ 
        return;
    }
    $('#pitch').append('<b>Pitch: </b>'+$('#penetro').text()+'<b>&nbsp;&nbsp;False Rail: </b>'+$('#falserail').text());
    
    $('#mauTime').append('<div class="time"></div>');
            
           var options = {
            format:'<span class=\"dt\">%A, %d %B %I:%M:%S %P</span>',
            timeNotation: '12h',
            am_pm: true,
            fontSize: '11px',
            foreground: 'black',
            background: '#fff',
            utc:true,
            utc_offset: offset
          }
             
          $('#mauTime .time').jclock(options);
          
          //var url = window.location.pathname;
          var mId=$(location).attr('href').match(/bet=([0-9]+)/)[1];
          
          //alert(mId);
          fetchBettingProg(mId);

                 
          function fetchBettingProg(mId){
                var action;

                    action='fetchBettingProg';
                    
                    i=0;
                    
                    $.ajax({
                            url:'bet.php',
                            type:'POST',
                            cache: false,
                            data:'mid='+mId+'&action='+action,
                            success:function(data){
                                    if(data=='No Info'){
                                          $(location).attr('href','index.php');
                                      }
                                      
                                    $('#raceDetails').append(data);
                                    var newHeight=$('#raceDetails').height()+50;
                                    
                                    if(newHeight <= 726){
                                        $('#rbook-rightcontainer').css({'min-height':'726px'});
                                    }else{
                                        $('#rbook-rightcontainer').css({'min-height':newHeight+'px'});
                                    }
                                    looptable();
                                    
                           },
                           error:function(xhr, textStatus, error){
                               alert('XHR: '+ xhr +' textStatus: '+textStatus+' Error: '+error);
                           }
                        });
//                      
                
            }
            
            
            
            $("#tblMeeting tr").click(function() {
                var mId=$(location).attr('href').match(/bet=([0-9]+)/)[1];
                var meetingId = $(this).find("td").eq(2).text();
                var curr = $(this).find("td").eq(1).text();
                
                var url = "betnow.php?bet="+meetingId;    
                if((meetingId!=mId)&&(curr==1)){
                    $(location).attr('href',url);
                }
            });
            
            hLightNSelect();
            
            $('#bWin').click(function(){
               $('#winPanel').css('display','block');
               $('#placePanel').css('display','none');
            });
            $('#bPlace').click(function(){
               $('#winPanel').css('display','none');
               $('#placePanel').css('display','block');
            });
            
            $('input[name=betType]').change(function(){
                if($('input[name=betType]:checked', '#betPanel-frm').val()=='win'){
                    $('div[id^=sel-wOd]').each(function(){
                          $(this).css('display','block');
                    });
                    $('div[id^=sel-pOd]').each(function(){
                          $(this).css('display','none');
                    });
                }
                
                if($('input[name=betType]:checked', '#betPanel-frm').val()=='place'){
                    $('div[id^=sel-wOd]').each(function(){
                          $(this).css('display','none');
                    });
                    
                    $('div[id^=sel-pOd]').each(function(){
                          $(this).css('display','block');
                    });
                }
                $('div[id^=sel-hAmt]').each(function(){
                          if(($(this).text()<5)&&($(this).text()!='')){
                              var tId=$(this).attr('id').split('sel-hAmt')[1];
                              //alert(tId[1]);
                              var exRid=$('#sel'+tId).text().split('h')[0];
                              var rId=exRid.split('r')[1];
                              //alert(rId);
                              
                              
                              $('#selRace'+tId).css('display','none');
                               $('#sel'+tId).text('');$('#sel-Hname'+tId).text('');
                               $('#sel-wOd'+tId).text('');
                               $('#sel-pOd'+tId).text('');
                               
                               $('table[class=betprogCard'+rId+'] tr[class=rner]').each(function(){
                                   if($(this).index()%2){
                                        $(this).css({'background-color': '#eee', 'color': '#000'});
                                    }else{
                                        $(this).css({'background-color': '#fff', 'color': '#000'});
                                    }
                               });
                              
                          }
                    });
                    ppOut();
            });
            
            $('#btnBetnow').attr('disabled', false);
            
             $("#txtBetAmt").blur(function () {
                 if($("#txtBetAmt").text()==''){
                     $('#ppOut').text('');
                 }
                    ppOut();
            });
            
            
            $('#btnBetConfirm').each(function() {
                this.submitting = false;

            });
            
            $('#btnBetConfirm').click(function() {
                if(!this.submitting)
                {
                    
                    this.submitting = true;
                    var self = this; var j=0; var z=0; var od=new Array(); selJson='{'; odJson='{';
                    curr=$('#curr').text();
                    if($('#promoCode').length){
                        fbpc=$('#pcode').text();
                        
                    }else{
                        fbpc='';
                    }
                    action='confirmBet';cl=$('#cClient').text();bAmt=$('#cBetAmt').val();bType=$('#cBetType').val();
                    bLeg=$('#cSelLeg').val();bPO=(($('#lblPO').text()).split(' '+$('#curr').text())[0]).split('Payout: ')[1];
                    if($('input[name=cBetReplace]').is(':checked')){
                        rep=1;
                    }else{
                        rep=0;
                    }
                    
                    
                    $('input[id^=cSel-]').each(function(){
                        if($(this).val()!=''){
                            if(j!=0){
                               selJson+=',';
                            }
                            sel[j]=$(this).val();
                            selJson+='"'+j+'":"'+sel[j]+'"';
                            j++;
                        }
                    });
                    selJson+='}';
                    
                    
                    $('input[name^=cOdd-]').each(function(){
                        if($(this).val()!=''){
                            if(z!=0){
                               odJson+=',';
                            }
                            od[z]=$(this).val();
                            odJson+='"'+z+'":"'+od[z]+'"';
                            z++;
                        }
                    });
                    odJson+='}';
                   
                   
                    $.ajax({
                        url:'bet.php',
                        type:'POST',
                        cache: false,
                        data:'action='+action+'&sel='+selJson+'&odd='+odJson+'&bAmt='+bAmt+'&bType='+bType+'&bLeg='+bLeg+'&bPO='+bPO+'&cl='+cl+'&rep='+rep+'&curr='+curr+'&fbCode='+fbpc,
                         success: function(result) {
                             self.submitting = false;
                             $('input[id^=cSel-]').each(function(){
                                if($(this).val()!=''){
                                    $(this).val('');
                                }
                            });
                            $('input[name^=cOdd-]').each(function(){
                                if($(this).val()!=''){
                                    $(this).val('');
                                }
                            });
                            
                             //Display Confirmation Message
                             $('#confirmBet').css('display','none');
                             $('#cMsg').text('');
                             $('#cMsg').html(result);
                             $('#confirmMessage').css('display','block');
                             $('#btnBetnow').attr('disabled', true);
                         },
                         error:  function() {
                             self.submitting = false;
                         }
                    });
                }
                
                return false;
            });
            
            $('#confirmMsgClose').click(function(){
               location.reload(); 
            });
            
});



function tabSwitch(rnum, totRace, rId){
    $('#rId').text(rId); 
    
    for(var i=1; i<totRace+1; i++){
        document.getElementById('hform_'+i).style.display='none';
        document.getElementById('form_'+i).className = '';
    }
    document.getElementById('hform_'+rnum).style.display='block';
    document.getElementById('form_'+rnum).className = 'active';
    
    var newHeight=$('#raceDetails').height()+400;
    
    if(newHeight <= 726){
        $('#rbook-rightcontainer').css({
            'min-height':'726px'
        });
    }else{
        $('#rbook-rightcontainer').css({
            'min-height':newHeight+'px'
            });
    }
}

function hLightNSelect(){
        $('table[class^=betprogCard] tr[class=rner]').live('click', function() {
                //alert($('table[class^=betprogCard]').attr("class").split('betprogCard')[1]);
                
                var Horse;
                var raceId;var flagBar=0;var hAmt=0;var flagHlight=0;var flSel=0;
                
                
                raceId=$('#rId').text();
                //$(this).css('background-color', '#96CB57');
                
                //Get Row Index Clicked
                //alert('You clicked row '+ ($(this).index()) );
                
//                var t=0;
//                 $('table[class=betprogCard'+raceId+'] tr[id=rn]').each(function(){
//                    var backgroundColor = $(this).css('background-color');
//                    if(backgroundColor == 'rgb(61, 137, 1)'){
//                        t=t+1;
//                        alert(t);
//                    }
//                });
                //alert(t);
                
                var i=0;var selRow;
                $('table[class=betprogCard'+raceId+'] tr[class=rner]').each(function(){
                
                    var backgroundColor = $(this).css('background-color');
                    if(backgroundColor == 'rgb(61, 137, 1)'){
                        selRow=i+1;
                       // alert(selRow);
                    }
                    
                    
                    
                     if(i%2){
                         $(this).css({'background-color': '#fff', 'color': '#000'});
                         
//                         $(this).hover( function(){
//                                $(this).css({'background-color': '#BAEB94', 'color': '#000'});
//                            },
//                            function(){
//                                $(this).css({'background-color': '#fff', 'color': '#000'});
//                        });
                        
                    }else{
                         $(this).css({'background-color': '#eee', 'color': '#000'});
                         
                     }
                     i++;
                 
                });
                
               Horse=$(this).find("td").eq(0).text();
               Hname=$(this).find("td").eq(1).text();
               wOdds=$(this).find("td").eq(8).text();
               pOdds=$(this).find("td").eq(9).text();
               //alert(Horse);
                //alert($(this).index());
                if(selRow==$(this).index()){
                    if($(this).index()%2){
                        $(this).css({'background-color': '#eee', 'color': '#000'});
                    }else{
                        $(this).css({'background-color': '#fff', 'color': '#000'});
                    }
                }else{
                    $(this).css({'background-color': '#3D8901', 'color': '#eee'});
                    
                }
               
               
               $('table[class=betprogCard'+raceId+'] tr[class=rner]').each(function(){
                   if($(this).find("td").eq(8).text()=='-'){
                       flagBar=1;
                       return false;
                   }
               })
               
               $('table[class=betprogCard'+raceId+'] tr[class=rner]').each(function(){
                               hAmt+=1;
               })
               
               if((($('input[name=betType]:checked', '#betPanel-frm').val()=='place')&&(hAmt>4)) || ($('input[name=betType]:checked', '#betPanel-frm').val()=='win')){
                   flagHlight=1;
               }
           
               
               if(($('.rEor'+raceId).html()=='<b>Ended:&nbsp;</b>No')&&(flagBar!=1)&&(flagHlight==1)){
                   backgroundColor = $(this).css('background-color');
                   $('#sel-hAmt'+raceId).text(hAmt);
                   
                   if(backgroundColor == 'rgb(61, 137, 1)'){
                        
                        if($('input[name=betType]:checked', '#betPanel-frm').val()=='win'){
                            $('#sel'+raceId).text('r'+raceId+'h'+Horse);
                            $('#sel-Hname'+raceId).text(Hname);
                            $('#selRace'+raceId).css('display','block');
                            
                            $('#sel-wOd'+raceId).text(wOdds);
                            $('#sel-pOd'+raceId).text(pOdds);
                            $('#sel-wOd'+raceId).css('display','block');
                            $('#sel-pOd'+raceId).css('display','none');
                        }
                        if($('input[name=betType]:checked', '#betPanel-frm').val()=='place'){
                            //if($('sel-hAmt'+raceId).text() > 4){
                                $('#sel'+raceId).text('r'+raceId+'h'+Horse);
                                $('#sel-Hname'+raceId).text(Hname);
                                $('#selRace'+raceId).css('display','block');
                                $('#sel-wOd'+raceId).text(wOdds);
                                $('#sel-pOd'+raceId).text(pOdds);
                                $('#sel-wOd'+raceId).css('display','none');
                                $('#sel-pOd'+raceId).css('display','block');
                          //  }
                            
                        }
                        
                   }else{
                       $('#selRace'+raceId).css('display','none');
                       $('#sel'+raceId).text('');$('#sel-Hname'+raceId).text('');
                       $('#sel-wOd'+raceId).text('');
                       $('#sel-pOd'+raceId).text('');
                   }
                  // ppOut();
               }else{
                   if($(this).index()%2){
                        $(this).css({'background-color': '#eee', 'color': '#000'});
                    }else{
                        $(this).css({'background-color': '#fff', 'color': '#000'});
                    }
                    
               }
               ppOut();
               
              // alert(Horse+', '+raceId);
               //Loop in table to get all vals
//                   $(this).find('tr').each(function(){
//                      var texto = $(this).text();
//                      alert(texto);
//                });
         });
         
}

function getServerTimeStamp(){
                action='getTimestamp';
                
                $.ajax({
                            url:'bet.php',
                            type:'POST',
                            cache: false,
                            data:'action='+action,
                            success:function(data){
                                $('#lastUpdate').html('<b>Last Update:&nbsp;</b>'+data);
                            }
                });
            }

function looptable(){
                //alert($('#rId').text());
                
                $('table[class^=betprogCard]').each(function() {
                    
                    var raceId=$(this).attr("class").split('betprogCard')[1];
                    
                    action='checkEoR';
                    $.ajax({
                            url:'bet.php',
                            type:'POST',
                            cache: false,
                            data:'rid='+raceId+'&action='+action,
                            success:function(data){
                                if(data=='1'){
                                    $('.rEor'+raceId).html('<b>Ended:&nbsp;</b>Yes');
                                    $('table[class=betprogCard'+raceId+']').find("td[class='wodd']").each(function(){
                                        $(this).text('-');
                                    });
                                    
                                    $('table[class=betprogCard'+raceId+']').find("td[class='podd']").each(function(){
                                        $(this).text('-');
                                    });
                                }else{
                                    $('.rEor'+raceId).html('<b>Ended:&nbsp;</b>No');
                                    action='getWebOdds';
                                    $.ajax({
                                            url:'bet.php',
                                            type:'POST',
                                            dataType: 'json',
                                            cache: false,
                                            data:'rid='+raceId+'&action='+action,
                                            success:function(data){
                                                
                                                if(data==null){
                                                    $('table[class=betprogCard'+raceId+']').find("td[class='wodd']").each(function(){
                                                        $(this).text('-');
                                                    });

                                                    $('table[class=betprogCard'+raceId+']').find("td[class='podd']").each(function(){
                                                        $(this).text('-');
                                                    });
                                                }else{
                                                    $.each(data, function(index) {
                                                        $('table[class=betprogCard'+raceId+']').find("td[class='wodd']").eq(index-1).html(data[index]);
                                                        
                                                        if(data[index]!=0){
                                                            $('table[class=betprogCard'+raceId+']').find("td[class='podd']").eq(index-1).html(pl(((data[index]-100)/6)+100));
                                                        }else{
                                                            $('table[class=betprogCard'+raceId+']').find("td[class='podd']").eq(index-1).html(0);
                                                        }
                                                        
                                                    });
                                                    refreshSelOdds();
                                                }
                                                
                                           }
                                        });
                                }
                                
                            }
                        });
                    
                    
//            $(this).find("td[class='podd']").each(function(){
//                $(this).text('p');
//            }); 
                    });
                    getServerTimeStamp();
                    
            }
            
            window.setInterval(function() {
                looptable();
            }, 60000);

            
function pl(pOdd) {
    if (pOdd % 5 > 0) {
        pOdd = pOdd + (5 - (pOdd % 5));
    }
    pOdd = Math.floor(pOdd);
    return pOdd;
}

function ppOut(){
    var pO;var Od;var fl=0;var currBal;
    $('#limPO').css('display', 'none');
    
    if ($('#txtBetAmt').val()!='') {
        amt=$('#txtBetAmt').val();
        currBal=$('#yrBal').text().split('Current Balance: ')[1];
        currBal=currBal.split($('#curr').text())[0];
        
        
        
        if((parseFloat(amt)) > (parseFloat(currBal))){
            //alert('Amt: '+amt+' currBal: '+currBal);
            $('#lessFund').css('display','block');
            $('#betPanel-frm').valid();
        }else{
            $('#lessFund').css('display','none');
        }
        
        if((parseFloat(amt)) == 0){
            //alert('Amt: '+amt+' currBal: '+currBal);
            $('#betPanel-frm').valid();
        }
        
        if(amt == parseFloat(amt)){
            pO=amt;
            if($('input[name=betType]:checked', '#betPanel-frm').val()=='win'){
                //alert(amt+' Win');
        
                $('div[id^=sel-wOd]').each(function(){
                    if($(this).text()!=''){
                        Od=parseInt($(this).text(),10);
                        pO=pO*(Od/100);
                        fl=1;
                    }
                });
            }
            if($('input[name=betType]:checked', '#betPanel-frm').val()=='place'){
                //alert(amt+' Place');
                $('div[id^=sel-pOd]').each(function(){
                    if($(this).text()!=''){
                        Od=parseInt($(this).text(),10);
                        pO=pO*(Od/100);
                        fl=1;
                    }
            
                });
            }
        }
        if(fl==1){
            if(pO == parseFloat(pO).toFixed(2)){
                $('#ppOut').text(pO+' '+$('#curr').text());
            }else{
               $('#ppOut').text(pO.toFixed(2)+' '+$('#curr').text());
            }
            
        }else{
            $('#ppOut').text('');
        }
        
        
        if(($('#ppOut').text()!='')&&(parseFloat(pO) > 2000)){
            pOutLim(parseFloat(pO),amt);
            $('#limPO').css('display', 'block');
        }
        
        
    }
    
}

function pOutLim(pO,amt){
    var LIM=1500;
    var pODiv=pO;var i=11;j=1;
    
    
    while(pODiv > LIM){
        j=i/10;
        pODiv=pO/j;
        newAmt=parseFloat(amt/j).toFixed(2);
        i++;
    }
    //if (j)
    //newAmt=parseFloat(amt/j).toFixed(2);
    
    //alert('j: '+j+' poDiv: '+pODiv+' newAmt: '+newAmt);
    
    if(newAmt == parseFloat(newAmt)){
            pO=parseFloat(newAmt).toFixed(2);
            if($('input[name=betType]:checked', '#betPanel-frm').val()=='win'){
                $('div[id^=sel-wOd]').each(function(){
                    if($(this).text()!=''){
                        Od=parseInt($(this).text(),10);
                        pO=pO*(Od/100);
                        fl=1;
                    }
                });
            }
            if($('input[name=betType]:checked', '#betPanel-frm').val()=='place'){
                $('div[id^=sel-pOd]').each(function(){
                    if($(this).text()!=''){
                        Od=parseInt($(this).text(),10);
                        pO=pO*(Od/100);
                        fl=1;
                    }
            
                });
            }
    }
    
    if(pO == parseFloat(pO).toFixed(2)){
        if((pO!=0) || (pO!=0.00)){
            $('#ppOut').text(pO+' '+$('#curr').text());
        }else{
            $('#ppOut').text('');
        }
    }else{
        if((pO!=0) || (pO!=0.00)){
            $('#ppOut').text(pO.toFixed(2)+' '+$('#curr').text());
        }else{
            $('#ppOut').text('');
        }
    }
    
    if(newAmt == parseFloat(newAmt).toFixed(2)){
        $('#txtBetAmt').val(newAmt);
    }else{
        $('#txtBetAmt').val(newAmt.toFixed(2));
    }
    
}

function refreshSelOdds(){
    
    var cur = $('#curr').text();var hNameDist='';
    if($('input[name=betType]:checked', '#betPanel-frm').val()=='win'){
        i=1;
        j=1;
        $('div[id^=sel-wOd]').each(function(){
                            
            if($(this).text()!=''){
                ra=$('#selRace'+i).text();
                hName=$('#sel-Hname'+i).text();
                rId=$('#sel'+i).text().split('h')[0];
                rId=rId.split('r')[1];
                                
                hId=$('#sel'+i).text().split('h')[1];
                                
                                
                $('table[class=betprogCard'+rId+'] tr[class=rner]').each(function(){
                    if(hName == $(this).find("td").eq(1).text()){
                        //alert($('#sel-wOd'+i).text());
                        $('#sel-wOd'+i).text($(this).find("td").eq(8).text());
                        $('#sel-pOd'+i).text($(this).find("td").eq(9).text());
                        $('#cOdd-'+i).val($(this).find("td").eq(8).text());
                        $('#cBetAmt').val($('#txtBetAmt').val());
                        $('#cPOut').val($('#ppOut').text().split(cur)[0]);
                        //$('#cPOut').val($('#ppOut').text());
                        $('#lblBetAmt').html('<b>Stake: </b>'+$('#txtBetAmt').val()+' '+$('#curr').text());
                        $('#lblPO').html('<b>Payout: </b>'+$('#ppOut').text());
                    }
                    j++;
                                                        
                });
                  hNameDist += "<div class='lblSelect'><b>"+ra+'</b><br/><div class=lblHname>'+hName+'</div>'+$(this).text()+"</div>";              
            }
            i++;
        });
        
        $('#lblSel').html(hNameDist+'<br/>');
    }
    if($('input[name=betType]:checked', '#betPanel-frm').val()=='place'){
        i=1;
        j=1;
        $('div[id^=sel-pOd]').each(function(){
            if($(this).text()!=''){
                ra=$('#selRace'+i).text();
                hName=$('#sel-Hname'+i).text();
                rId=$('#sel'+i).text().split('h')[0];
                rId=rId.split('r')[1];
                                
                hId=$('#sel'+i).text().split('h')[1];
                                
                                
                $('table[class=betprogCard'+rId+'] tr[class=rner]').each(function(){
                    if(hName == $(this).find("td").eq(1).text()){
                        //alert();
                        $('#sel-wOd'+i).text($(this).find("td").eq(8).text());
                        $('#sel-pOd'+i).text($(this).find("td").eq(9).text());
                        $('#cOdd-'+i).val($(this).find("td").eq(9).text());
                        $('#cBetAmt').val($('#txtBetAmt').val());
                        $('#cPOut').val($('#ppOut').text().split(cur)[0]);
                        
                        $('#lblBetAmt').html('<b>Stake: </b>'+$('#txtBetAmt').val()+' '+$('#curr').text());
                        $('#lblPO').html('<b>Payout: </b>'+$('#ppOut').text());
                    }
                    j++;
                                                        
                });
                hNameDist += "<div class='lblSelect'><b>"+ra+'</b><br/><div class=lblHname>'+hName+'</div>'+$(this).text()+"</div>";                              
            }
            i++;
        });
        $('#lblSel').html(hNameDist+'<br/>');
    }
    ppOut();
}
