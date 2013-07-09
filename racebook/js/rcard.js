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
          var mId=$(location).attr('href').match(/rcard=([0-9]+)/)[1];
          
          //alert(meetingId);
          fetchRacecard(mId);
                 
          function fetchRacecard(mId){
                var action;

                    action='getRacecard';
                    i=0;
                    
                    $.ajax({
                            url:'race.php',
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
                           }
                        });
                    
            }
            
            $("#tblMeeting tr").click(function() {
                var mId=$(location).attr('href').match(/rcard=([0-9]+)/)[1];
                var meetingId = $(this).find("td").eq(2).text();
                var curr = $(this).find("td").eq(1).text();
                
                var url = "racecard.php?rcard="+meetingId;    
                if((meetingId!=mId)&&(curr==1)){
                    $(location).attr('href',url);
                }
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