/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    $('#rules ul > li').mouseover(function(){
        if($(this).hasClass('hlight')){
            //alert('good');
        }else{
            //alert('hlight');
        }
    });
    $('#rules ul > li').hover(function(){
        if($(this).css('background-color') != 'rgb(206, 255, 182)') {
            $(this).css('background-color','#E5FFF1');
        }
    }, function(){
        if($(this).css('background-color') != 'rgb(206, 255, 182)') {
            $(this).css('background-color','#fff');
        }
    });

    
    $('#rules ul > li').click(function(){
        $('#rules ul > li:eq(0)').css('background-color','#fff');
        $('#rules ul > li:eq(1)').css('background-color','#fff');
        $('#rules ul > li:eq(2)').css('background-color','#fff');
        if($(this).index()==0){
                $('#rulesNcond').css('display','block');
                $('#bettingRules').css('display','none');
                $('#privacyPolicy').css('display','none');
                $(this).css('background-color','#CEFFB6');
                
            }
            if($(this).index()==1){
                $('#rulesNcond').css('display','none');
                $('#bettingRules').css('display','block');
                $('#privacyPolicy').css('display','none');
                $('#rules ul > li').removeClass('hlight');
                $(this).css('background-color','#CEFFB6');
            }
            if($(this).index()==2){
                $('#rulesNcond').css('display','none');
                $('#bettingRules').css('display','none');
                $('#privacyPolicy').css('display','block');
                $('#rules ul > li').removeClass('hlight');
                $(this).css('background-color','#CEFFB6');
                
            }
        
    });
    
    
});
