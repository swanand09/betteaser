/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
    
    if($('#EoR').is(':checked')){
        $('#frmAccept').css('display', 'none');
        $('#tblRunningHorse td:nth-child(2)').show();
        $('#tblRunningHorse td:nth-child(3)').show();
        $('input[name^="txtOdds"]').attr('readonly', true);
        //$('.rezRank').css('display', 'block');
    }else{
        $('#frmAccept').css('display', 'block');
        $('#tblRunningHorse td:nth-child(2)').hide();
        $('#tblRunningHorse td:nth-child(3)').hide();
        $('input[name^="txtOdds"]').attr('readonly', false);
        //$('.rezRank').css('display', 'none');
    }

    
    $('#saveAccept').click(function(){
        var chkAccept=$('#acceptBets').is(':checked');
        var acceptBet=0;
        if(chkAccept){
            acceptBet=1;
        }
       var action='checkAcceptBet';
       var rId=$(location).attr('href').match(/id=([0-9]+)/)[1];
       
       $.ajax({
            url:'rstatusMgmt.php',
            type: 'POST',
            data:'rId='+rId+'&action='+action+'&accept='+acceptBet,
            success:function(){
                alert('Information Saved');
            }
        });
       return false;
    });
    
    $('#saveEoR').click(function(){
        var chkEoR=$('#EoR').is(':checked');
        var eor=0;
        if(chkEoR){
            eor=1;
        }
        var action='checkEoR';
        var rId=$(location).attr('href').match(/id=([0-9]+)/)[1];

       $.ajax({
            url:'rstatusMgmt.php',
            type: 'POST',
            data:'rId='+rId+'&action='+action+'&eorStatus='+eor,
            success:function(){
                if(eor){
                    $('#frmAccept').css('display', 'none');
                    //$('.rezRank').css('display', 'block');
                }else{
                    $('#frmAccept').css('display', 'block');
                    //$('.rezRank').css('display', 'none');
                    
                }
                if(chkEoR){
                    $('#tblRunningHorse td:nth-child(2)').show();
                    $('#tblRunningHorse td:nth-child(3)').show();
                    $('input[name^="txtOdds"]').attr('readonly', true);
                }else{
                    $('#tblRunningHorse td:nth-child(2)').hide();
                    $('#tblRunningHorse td:nth-child(3)').hide();
                    $('input[name^="txtOdds"]').attr('readonly', false);
                }
            }
        });
       return false;
    });
    
    $('#saveRunHorse').click(function(){
        var raceId=$(location).attr('href').match(/id=([0-9]+)/)[1];
        var action;
       if($('#tblRunningHorse td:nth-child(3)').is(":visible")){
           //alert('Save place and rank');
           action='saveRaceRez';
           $("#tblRunningHorse tr").each(function() {
                hnum=$(this).find("td").eq(0).text();
                nbsp=$(this).find("td").eq(0).html();
                
                if ((isNaN(hnum / 1) == false)&&(nbsp!='&nbsp;')) {
                    var place=$('#txtPlace'+hnum).val();
                    var rank=$('#selRez'+hnum+' option:selected').val();
                    
                    //alert('Place: '+place+' Rank: '+rank);
                    $.ajax({
                    url:'rstatusMgmt.php',
                    type: 'POST',
                    data:'rId='+raceId+'&action='+action+'&place='+place+'&rank='+rank+'&hnum='+hnum,
                    success:function(){
                       
                    }
                });
                }

           });
           
           
       }else{
           
           action='saveRaceOdds';
           var avgOdds=0;

           $("#tblRunningHorse tr").each(function() {
               hnum=$(this).find("td").eq(0).text();
               nbsp=$(this).find("td").eq(0).html();
             if ((isNaN(hnum / 1) == false)&&(nbsp!='&nbsp;')) {
               var odds=$('#txtOdds'+hnum).val();
               avgOdds+=50000/odds;
               $.ajax({
                    url:'rstatusMgmt.php',
                    type: 'POST',
                    data:'rId='+raceId+'&action='+action+'&odds='+odds+'&hnum='+hnum,
                    success:function(){
                       
                    }
                });
                 
             }
              
            });
            $('.oddsAvg').text(Math.floor(avgOdds));

       }
       
       return false;
    });
    
    $('.oddsAvg').text($('#tmpOddsAvg').text());

});
