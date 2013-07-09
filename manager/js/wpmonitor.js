/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
  $('table[class^=raceTable] tr').not(':first').hover(
  function () {
      if(($(this).find("td").eq(1).text().indexOf('Race')!=0)&&($(this).find("td").eq(1).text().indexOf('--')!=0)){
          $(this).css("background","#A9DAFF");
      }
    
  }, 
  function () {
    $(this).css("background","");
  }); 
  
  $('table[class^=raceTable] tr').not(':first').click(function() {
      if(($(this).find("td").eq(1).text().indexOf('Race')!=0)&&($(this).find("td").eq(1).text().indexOf('--')!=0)){
          $('#txtNewOdds').val('');
          $('#txtBAmt').val('');
          $('#txtBOdds').val('');
          
          showChangeOdds(1);
          $('#hname').text('');
          $('#hname').append($(this).find("td").eq(2).text()+': '+$(this).find("td").eq(1).text()+'['+$(this).find("td").eq(8).text()+']');
          $('#txtrefHorse').val($(this).find("td").eq(3).text());
          $('#txtrefRace').val($(this).find("td").eq(4).text());
          
          $('#currHnb').val($(this).find("td").eq(9).text());
          //alert($(this).find("td").eq(1).text());
      }
        
    });
    
    $('#btnSaveOdd').click(function(){
       refH=$('#txtrefHorse').val();
       refR=$('#txtrefRace').val();
       newOdd=$('#txtNewOdds').val();
       action='changeOdds';
       //alert('RefH: '+refH+' New Odds: '+newOdd);
       
       currUrl=$(location).attr('href');
       
       
       $.ajax({
            url:'monitor.php',
            type:'POST',
            cache: false,
            data:'refH='+refH+'&newOdd='+newOdd+'&refR='+refR+'&action='+action,
            success:function(data){
                if(data=='changed'){
                    $(location).attr('href',currUrl);
                }else{
                    alert(data);
                }
                                      
                                    
                                    
            }
        });
       
       return false;
    });
    
    $('.addNb').click(function(){
       
       addNb=$(this).text();
       refH=$('#txtrefHorse').val();
       refR=$('#txtrefRace').val();
       hnB=$('#currHnb').val();
       nNb=parseInt(addNb,10)+parseInt(hnB,10);
       action='addNb';
       
       currUrl=$(location).attr('href');
       
       $.ajax({
            url:'monitor.php',
            type:'POST',
            cache: false,
            data:'refH='+refH+'&newNb='+nNb+'&refR='+refR+'&action='+action,
            success:function(data){
                if(data=='changed'){
                    $(location).attr('href',currUrl);
                }else{
                    alert(data);
                }
            }
        });
       
       return false;
    });
    
    $('.remNb').click(function(){
       
       remNb=$(this).text();
       refH=$('#txtrefHorse').val();
       refR=$('#txtrefRace').val();
       hnB=$('#currHnb').val();
       nNb=parseInt(hnB,10)-parseInt(remNb,10);
       action='remNb';
       
       currUrl=$(location).attr('href');
       
       $.ajax({
            url:'monitor.php',
            type:'POST',
            cache: false,
            data:'refH='+refH+'&newNb='+nNb+'&refR='+refR+'&action='+action,
            success:function(data){
                if(data=='changed'){
                    $(location).attr('href',currUrl);
                }else{
                    alert(data);
                }
            }
        });
       
       return false;
    });
  
   $('#btnSaveCover').click(function(){
      refH=$('#txtrefHorse').val();
       refR=$('#txtrefRace').val();
       amt=$('#txtBAmt').val();
       bOdd=$('#txtBOdds').val();
      action='addCover';
      
      currUrl=$(location).attr('href');
      
      if((amt!='')&&(bOdd!='')){
          po=((parseInt(amt,10)/1.1)*(parseInt(bOdd,10)/100)).toFixed();
          
          $.ajax({
            url:'monitor.php',
            type:'POST',
            cache: false,
            data:'refH='+refH+'&refR='+refR+'&amt='+amt+'&bOdd='+bOdd+'&po='+po+'&action='+action,
            success:function(data){
                if(data=='changed'){
                    $(location).attr('href',currUrl);
                }else{
                    alert(data);
                }
            }
        });
          
          //alert('RefR: '+refR+' RefH: '+refH+' Amount: '+amt+' Odds: '+bOdd+' PO: '+po);
      }
      
      return false;
   });
   

   
});

function getOdds(){
    $(".raceTableC").find('table[class^=raceTable]').each(function() {
        var raceId=$(this).attr("class").split('raceTable')[1];
        //alert(raceId);
    
    });
    
}

function populateOdds(raceId){
    action='getMonitorOdds';
        $.ajax({
            url:'monitor.php',
            type:'POST',
            dataType: 'json',
            cache: false,
            data:'rid='+raceId+'&action='+action,
            success:function(data){
                                                
                if(data==null){
                    $('table[class=raceTable'+raceId+']').find("td[class='odd']").each(function(){
                        $(this).text('-');
                    });

                }else{
                    totOdds=0;i=0;
                    $.each(data, function(index) {
                        $('table[class=raceTable'+raceId+']').find("td[class='odd']").eq(i).html(data[index]);
                        totOdds+=50000/parseFloat(data[index]);
                        i++;
                    });
                    $('table[class=raceTable'+raceId+']').find("td[class='totOdds']").eq(0).html(Math.round(totOdds));
                }
                                                
            }
        });
}
