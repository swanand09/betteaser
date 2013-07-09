/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


 
$(function(){
 
    $('#btnBetnow').click(function(e) {
                $('#confirmMessage').css('display','none');
                var id = '#dialog';
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
	
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(125);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		//Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		//transition effect
		$(id).fadeIn(250); 
                
                //return false;
                
                if(($('#ppOut').text()!='')&&($('#txtBetAmt').val() !='0')){
                    var hNameDist='';var j;
                    $('#confirmBet').css('display','block');
                    $('#noBet').css('display','none');
                    $('#lblBetAmt').html('<b>Stake: </b>'+$('#txtBetAmt').val()+' '+$('#curr').text());
                    $('#lblPO').html('<b>Payout: </b>'+$('#ppOut').text());
                    
                    if($('input[name=betReplace]').is(':checked')){
                        $("input[name=cBetReplace]").attr('checked', true);
                    }else{
                        $("input[name=cBetReplace]").attr('checked', false);
                    }

                    
                    
                    if($('input[name=betType]:checked', '#betPanel-frm').val()=='win'){
                        //alert(amt+' Win');
                        
                        $('#lblBetType').html('<b>Bet Type: </b>Win');
                        $('#cBetType').val('w');
                        i=1;j=0;
                        $('div[id^=sel-wOd]').each(function(){
                            if($(this).text()!=''){
                                ra=$('#selRace'+i).text();
                                hName=$('#sel-Hname'+i).text();
                                
                                $('#cOdd-'+i).val($(this).text());
                                $('#cSel-'+i).val($('#sel'+i).text());
                                hNameDist += "<div class='lblSelect'><b>"+ra+'</b><br/><div class=lblHname>'+hName+'</div>'+$(this).text()+"</div>";
                                j++;
                            }
                            i++;
                        });
                        $('#lblSel').html(hNameDist+'<br/>');
                        $('#cSelLeg').val(j);
                    }
                    if($('input[name=betType]:checked', '#betPanel-frm').val()=='place'){
                        //alert(amt+' Place');
                        $('#lblBetType').html('<b>Bet Type: </b>Place');
                        $('#cBetType').val('p');
                        i=1;j=0;
                        $('div[id^=sel-pOd]').each(function(){
                            if($(this).text()!=''){
                                ra=$('#selRace'+i).text();
                                hName=$('#sel-Hname'+i).text();
                                $('#cOdd-'+i).val($(this).text());
                                $('#cSel-'+i).val($('#sel'+i).text());
                                hNameDist += "<div class='lblSelect'><b>"+ra+'</b><br/><div class=lblHname>'+hName+'</div>'+$(this).text()+"</div>";
                                j++;
                            }
                            i++;
                        });
                        $('#lblSel').html(hNameDist+'<br/>');
                        $('#cSelLeg').val(j);
                    }
                    
                    $('#cBetAmt').val($('#txtBetAmt').val());
                    
                    $('#cPOut').val($('#ppOut').text().split($('#curr').text())[0]);
                    
                }else{
                    $('#confirmBet').css('display','none');
                    $('#noBet').css('display','block');
                }
                
        });
        
	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
                //document.location.href='index.php';
                $('#txtBetAmt').focus();
	});
	
	//if mask is clicked
//	$('#mask').click(function () {
//		$(this).hide();
//		$('.window').hide();
//                document.location.href='index.php';
//	});

$(window).resize(function () {
  
        var box = $('#boxes .window');
  
        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
       
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
                
        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();
  
        //Set the popup window to center
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2);
  
});

    $('#cBetReplace').change(function(){
        if($('input[name=cBetReplace]').is(':checked')){
            $("input[name=betReplace]").attr('checked', true);
        }else{
            $("input[name=betReplace]").attr('checked', false);
        }
    });
    
});
 