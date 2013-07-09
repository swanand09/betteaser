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
          
          $("#report tr:odd").addClass("odd");
            $("#report tr:not(.odd)").hide();
            $("#report tr:first-child").show();
            
            $("#report tr.odd").click(function(){
                $(this).next("tr").toggle();
            });
                        
            $('#expand').click(function(){
                //alert("hello");
                if ($('#expand').text()=='Expand All'){
                    $('#expand').text('Collapse All');
                    $('.moreInfo').each(function(){
                        $('.moreInfo').hide();
                        $('.moreInfo').toggle();
                        var newHeight=$('#report').height()+30;
                        $('#rbook-rightcontainer').css({'min-height':newHeight+'px'});
                    });
                }else{
                    $('#expand').text('Expand All');
                    $('.moreInfo').each(function(){
                        $('.moreInfo').show();
                        $('.moreInfo').toggle();
                        $('#rbook-rightcontainer').css({'min-height':'726px'});
                    });
                }
                
                
                return false;
            });
            
            fetchRaceDetails($('#tblMeeting tr[id=mting1]').find("td").eq(2).text(),$(this).find("td").eq(4).text());
            
            $("#tblMeeting tr").click(function() {
                var i=0;j=1;
                $('#tblMeeting tr').each(function(){
                   i++;
                });
                i=i/2;
                
                if($(this).find("td").eq(1).text()!=0){
                    while(j<=i){
                        $('#tblMeeting tr[id=mting'+j+']').css('background-color', '#fff');
                        if($('#tblMeeting tr[id=mting'+j+']').find("td").eq(1).text()==1){
                            $('#tblMeeting tr[id=mting'+j+']').css('background-color', '#fff');
                        }

                        j++;
                    }
                    $(this).css('background-color','#CEFFB6');
                    var meetingId = $(this).find("td").eq(2).text();
                    var menuSel=$(this).find("td").eq(4).text();
                    var action;
                    
                    if((menuSel=='upcoming')||(menuSel=='nomination')){
                        action='getNomination';
                    }else if(menuSel=='racecard'){
                        action='getRacecard';
                    }else if(menuSel=='result'){
                        action='getResult';
                    }else{
                        action='getNomination';
                    }
                    
                    i=0;
                    
                    if(meetingId!=$('.mId:first').text()){
                        $.ajax({
                            url:'race.php',
                            type:'POST',
//                            dataType: 'json',
                            cache: false,
                            data:'mid='+meetingId+'&action='+action,
                            success:function(data){
//                                while(i<data.length){
//                                    alert(data[i]['_rnum']+' '+data[i]['_rname']);
//                                    i++;
//                                }
                                    $('#raceDetails').text(" ");
                                    $('#raceDetails').append(data);
                                    var newHeight=$('#raceDetails').height()+50;
                                    if(newHeight <= 726){
                                        $('#rbook-rightcontainer').css({'min-height':'726px'});
                                    }else{
                                        $('#rbook-rightcontainer').css({'min-height':newHeight+'px'});
                                    }
                                    

                           }
                        });
                    }
                    
                     
                }
                
            });
            
            function fetchRaceDetails(meetingId,menuSel){
                var action;
                    
                    if((menuSel=='upcoming')||(menuSel=='nomination')){
                        action='getNomination';
                    }else if(menuSel=='racecard'){
                        action='getRacecard';
                    }else if(menuSel=='result'){
                        action='getResult';
                    }else{
                        action='getNomination';
                    }
                    i=0;
                    
                    $.ajax({
                            url:'race.php',
                            type:'POST',
                            //dataType: 'json',
                            cache: false,
                            data:'mid='+meetingId+'&action='+action,
                            success:function(data){
//                                while(i<data.length){
//                                    alert(data[i]['_rnum']+' '+data[i]['_rname']);
//                                    i++;
//                                 }
                                    $('#raceDetails').append(data);
                                    var newHeight=$('#raceDetails').height()+50;
                                    if(newHeight <= 726){
                                        $('#rbook-rightcontainer').css({'min-height':'726px'});
                                    }else{
                                        $('#rbook-rightcontainer').css({'min-height':newHeight+'px'});
                                    }
                           }
                        });
                    
            }
            
            
            function rgb2hex(rgb){
             rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
             return "#" +
              ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
              ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
              ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
            }
            
            $('.rdet').click(function(){
               alert('Clicked');
            });
          

});

function tabSwitch(rnum, totRace){
    
    for(var i=1; i<totRace+1; i++){
        document.getElementById('hform_'+i).style.display='none';
        document.getElementById('form_'+i).className = '';
    }
    document.getElementById('hform_'+rnum).style.display='block';
    document.getElementById('form_'+rnum).className = 'active';
    
    var newHeight=$('#raceDetails').height()+50;
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

