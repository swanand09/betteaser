/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
   $('#example').find('tr').click( function(){
      var horse = $(this).find('td').eq(2).text();
      var show = $(this).find('td').eq(8).text();
      var id = $(this).find('td').eq(0).text();
      $('#covId').val(id);
      
      
      $('#cHname').text(horse);
      if (show==1) {
        $('#eShow').attr('checked', true);
      }else{
        $('#eShow').attr('checked', false);
      }
      
      $('#editMeeting').css('display','block');
    });
   
   $('#closeEdit').click(function(){
      $('#editMeeting').css('display','none');
      return false; 
   });
   
   $('#savCovBets').click(function(){
       covId= $('#covId').val();
      
      if($('#eShow').attr('checked')=='checked'){
          upShow=1;
          
      }else{
          upShow=0;
          
      }
      action='changeCovSts';
      $.ajax({
            url:'monitor.php',
            type:'POST',
            data:'action='+action+'&upShow='+upShow+'&cId='+covId,
            success:function(){
                $(location).attr('href','coveredbets.php');

            }
        });
      
      return false;
   });
   
});
