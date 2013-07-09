/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    $('#btnCreateMeeting').click(function(){toggleCreate();return false;});
    $('#closeCreate').click(function(){toggleCreate();return false;});
    $('#closeEdit').click(function(){toggleEdit();return false;});

    $('.editMeeting').click(function(){ 
        if ($('#createMeeting:visible').length > 0){
                $('#createMeeting').css('display','none');
            }
        $('#editMeeting').css('display','block');
        
        var rowId=$(this).attr('href').match(/id=([0-9]+)/)[1];
        $('#eId').val(rowId);
        fillData('#'+rowId);
        return false; 
    });

    $('#mdate').datepicker({dateFormat: "dd/mm/yy"});
    $('#edate').datepicker({dateFormat: "dd/mm/yy"});
    
    $('#saveMeeting').click(function(){
        
        var btn=$('#saveMeeting').attr("value");
        var mname=$('#mname').val();
        var mdate=$('#mdate').val();
        var mcomment=$('#mcomment').val();
        var mstatus=$('#mstatus option:selected').text();
        
        //alert(chkDisplay);
        
        $.ajax({
            url:'meetingMgmt.php',
            type:'POST',
            data:'mname='+mname+'&mdate='+mdate+'&mstatus='+mstatus+'&btn='+btn+'&mcomment='+mcomment,
            success:function(){
                $(location).attr('href','index.php');
                
            }
        }); 
        
        //alert('save meeting');
        return false;
    });
    
    $('#saveTraining').click(function(){
        tdate=$('#mdate').val();
        trainingData=$('#trainingData').val();
        btn=$('#saveTraining').attr("value");
        
        $.ajax({
            url:'meetingMgmt.php',
            type:'POST',
            data:'tdate='+tdate+'&trainingData='+trainingData+'&btn='+btn,
            success:function(rez){
                if(rez==''){
                    alert('Training saved');
                }else{
                    alert(rez);
                }
                
                
            }
        });
        
        return false;
    });
    
    $('#saveEditMeeting').click(function(){
        var eId=$('#eId').val();
        var ename=$('#ename').val();
        var edate=$('#edate').val();
        var ecomment=$('#ecomment').val();
        var epitch=$('#epitch').val();
        var efalserail=$('#efalserail').val();
        var estatus=$('#estatus option:selected').text();
        var btn=$('#saveEditMeeting').attr("value");
        var chkDisplay='';
        var chkCurr='';
        if($('#eDisplay').attr('checked')=='checked'){
            chkDisplay="1";
        }else{
            chkDisplay="0";
        }
        if($('#eCurrent').attr('checked')=='checked'){
            chkCurr="1";
        }else{
            chkCurr="0";
        }
        //alert(eId+' '+ename+' '+edate+' '+estatus+' '+btn+' '+ecomment+' '+epitch+' '+efalserail+' '+chkDisplay);
        
        
        $.ajax({
            url:'meetingMgmt.php',
            type:'POST',
            data:'eid='+eId+'&ename='+ename+'&edate='+edate+'&estatus='+estatus+'&btn='+btn+'&ecomment='+ecomment+'&epitch='+epitch+'&efalserail='+efalserail+'&chkDisplay='+chkDisplay+'&chkCurrent='+chkCurr,
            success:function(){
                $(location).attr('href','index.php');
//                $('.msgStatus .hl').remove();
//                $('.msgStatus').append(result);
//                $('.msgStatus').css('display', 'block');
            }
        }); 
        
        return false;
    });
    
    $('#example').dataTable();
    
    

});

function toggleCreate(){
    if ($('#createMeeting:visible').length > 0){
            $('#createMeeting').css('display','none');
            $('#frmNewMeeting')[0].reset();
        }else{
            if ($('#editMeeting:visible').length > 0){
                $('#editMeeting').css('display','none');
            }
            $('#createMeeting').css('display','block');
            $('.msgStatus').css('display','none');
        }
}
function toggleEdit(){
    if ($('#editMeeting:visible').length > 0){
            $('#editMeeting').css('display','none');
            
        }else{
            
            $('#editMeeting').css('display','block');
            
        }
}

function fillData(id){
   
    $(id).each(function() {
        //var td2 = $(this).find("td").eq(3).text();   
        
        $('#ename').val($(this).find("td").eq(1).text());
        $('#edate').val($(this).find("td").eq(2).text());
        $("#estatus option[value=" + $(this).find("td").eq(4).text() +"]").attr("selected","selected") ;
        $('#ecomment').val($(this).find("td").eq(5).text());
        $('#epitch').val($(this).find("td").eq(6).text());
        $('#efalserail').val($(this).find("td").eq(7).text());
        var chkVal=$(this).find("td").eq(8).text();
        var chkCurr=$(this).find("td").eq(9).text();
        if(chkVal==1){
            $('#eDisplay').attr('checked',true);
            $('#eDisplay').val('1');
        }else{
            $('#eDisplay').attr('checked',false);
            $('#eDisplay').val('0');
        }
        if(chkCurr==1){
            $('#eCurrent').attr('checked',true);
            $('#eCurrent').val('1');
        }else{
            $('#eCurrent').attr('checked',false);
            $('#eCurrent').val('0');
        }
        
        //alert(td2);
    });
}


