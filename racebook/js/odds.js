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
          var mId=$(location).attr('href').match(/odd=([0-9]+)/)[1];
          
          //alert(meetingId);
          fetchHorseTable(mId);
          
           
          function fetchHorseTable(mId){
                    var action;
                    action='getOddsTable';
                    i=0;
                    
                    $.ajax({
                            url:'oddstable.php',
                            type:'POST',
                            cache: false,
                            data:'mid='+mId+'&action='+action,
                            success:function(data){
                                    if(data=='No Info'){
                                          $(location).attr('href','index.php');
                                      }
                                    $('#raceDetails').append(data);
                                    var newHeight=$('#raceDetails').height()+50;
                                    
                                    newHeight=320*3;
                                    
                                    if(newHeight <= 726){
                                        $('#rbook-rightcontainer').css({'min-height':'726px'});
                                    }else{
                                        $('#rbook-rightcontainer').css({'min-height':newHeight+'px'});
                                    }
                                    looptable();
                           }
                        });
                        
                    
            }
            
            function getServerTimeStamp(){
                action='getTimestamp';
                
                $.ajax({
                            url:'oddstable.php',
                            type:'POST',
                            cache: false,
                            data:'action='+action,
                            success:function(data){
                                $('#lastUpdate').html('<b>Last Update:&nbsp;</b>'+data);
                            }
                });
            }
            
            function looptable(){
               
                $(".raceTable").find('table[class^=oddsTable]').each(function() {
                    
                    var raceId=$(this).attr("class").split('oddsTable')[1];
                    //check ended of race
                    action='checkEoR';
                    $.ajax({
                            url:'oddstable.php',
                            type:'POST',
                            cache: false,
                            data:'rid='+raceId+'&action='+action,
                            success:function(data){
                                //alert(data);
                                if(data=='1'){
                                    $('.rEor'+raceId).html('<b>Ended:&nbsp;</b>Yes');
                                    
                                    $('table[class=oddsTable'+raceId+']').find("td[class='wodd']").each(function(){
                                        $(this).text('-');
                                    });
                                    
                                    $('table[class=oddsTable'+raceId+']').find("td[class='podd']").each(function(){
                                        $(this).text('-');
                                    });
                                    
                                }else{
                                    //alert('xx');
                                    $('.rEor'+raceId).html('<b>Ended:&nbsp;</b>No');
                                    action='getWebOdds';
                    
                                    $.ajax({
                                            url:'oddstable.php',
                                            type:'POST',
                                            dataType: 'json',
                                            cache: false,
                                            data:'rid='+raceId+'&action='+action,
                                            success:function(data){
                                                
                                                if(data==null){
                                                    $('table[class=oddsTable'+raceId+']').find("td[class='wodd']").each(function(){
                                                        $(this).text('-');
                                                    });

                                                    $('table[class=oddsTable'+raceId+']').find("td[class='podd']").each(function(){
                                                        $(this).text('-');
                                                    });
                                                }else{
                                                    $.each(data, function(index) {
                                                        $('table[class=oddsTable'+raceId+']').find("td[class='wodd']").eq(index-1).html(data[index]);
                                                        if(data[index]!=0){
                                                            $('table[class=oddsTable'+raceId+']').find("td[class='podd']").eq(index-1).html(pl(((data[index]-100)/6)+100));
                                                        }else{
                                                            $('table[class=oddsTable'+raceId+']').find("td[class='podd']").eq(index-1).html(0);
                                                        }
                                                    });
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
            
            
            $("#tblMeeting tr").click(function() {
                var mId=$(location).attr('href').match(/odd=([0-9]+)/)[1];
                var meetingId = $(this).find("td").eq(2).text();
                var curr = $(this).find("td").eq(1).text();
                    
                var url = "odds.php?odd="+meetingId;    
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

function goUp(){
    $('html, body').animate({scrollTop: 0}, 0);
}

function pl(pOdd) {
    //echo $o."---";

    if (pOdd % 5 > 0) {
        pOdd = pOdd + (5 - (pOdd % 5));
    }
    //echo $o."<br>";
    pOdd = Math.floor(pOdd);
    return pOdd;
}