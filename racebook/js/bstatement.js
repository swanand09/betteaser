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
          
          
            $("#tblMeeting tr").hover(
            function() {
                var curr = $(this).find("td").eq(1).text();
                if(curr==1){
                    $(this).css('background-color', '#CEFFB6');
                }
            },
            function() {
                var curr = $(this).find("td").eq(1).text();
                if(curr==1){
                    $(this).css('background-color', '#fff');
                }
            }
        
            );
            
            
            $("#tblMeeting tr").click(function() {
                //var mId=$(location).attr('href').match(/bet=([0-9]+)/)[1];
                var meetingId = $(this).find("td").eq(2).text();
                var curr = $(this).find("td").eq(1).text();
                var mSts = $(this).find("td").eq(4).text();
                
                var url;
                if(curr==1){
                    if(mSts=='racecard'){
                        url= "racecard.php?rcard="+meetingId;
                        $(location).attr('href',url);
                    }else if(mSts=='nomination'){
                        url= "nomination.php?nomi="+meetingId;
                        $(location).attr('href',url);
                    }else{
                        url= "index.php";
                        $(location).attr('href',url);
                    }
                }
            });
            
            headingName();
            $('.viewRacecard').click(function(){
                selLnk();
                $(this).attr("id", "sel");
                selTex=$(this).text();
                if(selTex=='All Bets'){
                    $('#pBets').css('display','none');
                    $('#rplBets').css('display','none');
                    $('#rfnBets').css('display','none');
                    $('#wonBets').css('display','none');
                    $('#lostBets').css('display','none');
                    $('#allBets').css('display','block');
                    
                }else if(selTex=='Pending Bets'){
                    $('#pBets').css('display','block');
                    $('#allBets').css('display','none');
                    $('#rplBets').css('display','none');
                    $('#rfnBets').css('display','none');
                    $('#wonBets').css('display','none');
                    $('#lostBets').css('display','none');
                }else if(selTex=='Replaced Bets'){
                    $('#pBets').css('display','none');
                    $('#allBets').css('display','none');
                    $('#rplBets').css('display','block');
                    $('#rfnBets').css('display','none');
                    $('#wonBets').css('display','none');
                    $('#lostBets').css('display','none');
                }else if(selTex=='Refund Bets'){
                    $('#pBets').css('display','none');
                    $('#allBets').css('display','none');
                    $('#rplBets').css('display','none');
                    $('#rfnBets').css('display','block');
                    $('#wonBets').css('display','none');
                    $('#lostBets').css('display','none');
                }else if(selTex=='Won'){
                    $('#pBets').css('display','none');
                    $('#allBets').css('display','none');
                    $('#rplBets').css('display','none');
                    $('#rfnBets').css('display','none');
                    $('#wonBets').css('display','block');
                    $('#lostBets').css('display','none');
                }else if(selTex=='Lost'){
                    $('#pBets').css('display','none');
                    $('#allBets').css('display','none');
                    $('#rplBets').css('display','none');
                    $('#rfnBets').css('display','none');
                    $('#wonBets').css('display','none');
                    $('#lostBets').css('display','block');
                }else{
                    
                }
                
                return false;
            })
            
           $('table[id^=tblAllBets]').dataTable({
               "aLengthMenu": [[5, 10, 15], [5, 10, 15]],
               iDisplayLength: 15,
                bJQueryUI: true,
                sPaginationType: "full_numbers"
           });
           
           var newHeight=$('#tblAllBets-a').height()+190;
           
            if(newHeight <= 726){
                $('#rbook-rightcontainer').css({
                    'min-height':'726px'
                });
            }else{
                $('#rbook-rightcontainer').css({
                    'min-height':newHeight+'px'
                    });
            }
            
});

function headingName(){
    mHdr="MEETING ";
    i=0;
    $("#tblMeeting tr").each(function(){
        curr = $(this).find("td").eq(1).text();
        mNo = $(this).find("td").eq(0).text();
        if(curr==1){
            if (i==0){
                mHdr+=mNo.split('M')[1]+" ";
            }else{
                mHdr+="& "+mNo.split('M')[1]+" ";
            }
            i++;
        }
    });
    $('#mtingName').text(mHdr);
}
function selLnk(){
    $('#meetingDetails a').each(function(){
       if($(this).attr("id")=='sel'){
           $(this).attr("id", "");
       }
    });
}