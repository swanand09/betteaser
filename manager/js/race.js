/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){

    $('#btnCreateRace').click(function(){toggleCreate();return false;});
    $('#closeCreate').click(function(){toggleCreate();return false;});
    $('#closeEdit').click(function(){toggleEdit();return false;});

    $('.editRace').click(function(){
        if ($('#createRace:visible').length > 0){
                $('#createRace').css('display','none');
            }
        $('#editRace').css('display','block');
        $('#listhorse').css('display','none');
        $('#editHorse').css('display','none');
        $('#webInfo').css('display','none');
        $('#importHorseWeight').css('display','none');
        $('#importNomi').css('display','none');

        var rowId=$(this).attr('href').match(/id=([0-9]+)/)[1];
        $('#rId').val(rowId);
        fillData('#'+rowId);
        return false;
    });

    $('#saveRaces').click(function(){

        //alert('good');
        //var 
        var btn=$('#saveRaces').attr("value");
        var rnum=$('#rnum').val();
        var rname=$('#c_rname').val();
        var rtime=$('#rtime').val();
        var rdist=$('#rdist').val();
        var rating=$('#rating').val();
        var meetId=$('#mId').val();
        
        

        $.ajax({
           url:'raceMgmt.php',
           type: 'POST',
           data:'rnum='+rnum+'&rname='+rname+'&rtime='+rtime+'&rdist='+rdist+'&rating='+rating+'&btn='+btn+'&mId='+meetId,
           success:function(result){
               $(location).attr('href','manage.php?id='+meetId);
           }
        });


        return false;
    });

    $('#eRace').click(function(){
        var mId=$('#mId').val();
        var btn=$('#eRace').attr("value");
        var rId=$('#rId').val();
        var ernum=$('#ernum').val();
        var ername=$('#ername').val();
        var ertime=$('#ertime').val();
        var erdist=$('#erdist').val();
        var erating=$('#erating').val();
        var wstatus=$('#wstatus option:selected').text();
        var rstatus;

        //alert(btn+' '+rId+' '+ernum+' '+ername+' '+ertime+' '+erdist+' '+erating+' '+wstatus);
        
        var rstatVal=$('#rstatus').val();
        
        if(rstatVal=='NO'){
            rstatus=0;
        }else{
            rstatVal=rstatVal.split('S');
            rstatus=rstatVal[1];
        }
       // alert(rstatus);

        $.ajax({
           url:'raceMgmt.php',
           type: 'POST',
           data:'rId='+rId+'&ernum='+ernum+'&ername='+ername+'&ertime='+ertime+'&erdist='+erdist+'&erating='+erating+'&btn='+btn+'&wstatus='+wstatus+'&rstatus='+rstatus,
           success:function(result){
               $(location).attr('href','manage.php?id='+mId);

           }
        });


        return false;
    });

    $('.rHorse').click(function(){
       var rowId=$(this).attr('href').match(/id=([0-9]+)/)[1];
        var raceNum =$('#'+rowId).find("td").eq(0).text();
        var raceTime =$('#'+rowId).find("td").eq(1).text();
        var raceName =$('#'+rowId).find("td").eq(2).text();
        var action='getHorseList';
        $('#editRace').css('display','none');
        $('#listhorse').css('display','block');
        $('#editHorse').css('display','none');
        $('#webInfo').css('display','none');
        $('#importHorseWeight').css('display','none');

        $('.divTitle .det').remove();
        $('.divTitle').append("<h3 class='det'>Horse Management for Race "+raceNum+"["+raceTime+"] - "+raceName+"</h3>");

        $('#addHorses').attr("href","manage.php?raceid="+rowId);

        //call ajax function
        $.ajax({
           url:'raceMgmt.php',
           type: 'POST',
           data:'rId='+rowId+'&action='+action,
           success:function(result){
               //$(location).attr('href','manage.php?id='+mId);
               $('#horseList .hl').remove();
               $('#horseList').append(result);
//               $('.msgStatus').css('display','block');
           }
        });

        //alert(rowId);

        return false;
    });

    $('#closeHorse').click(function(){
        toggleDiv('#listhorse');
        $('#editHorse').css('display','none');
        return false;
    });

    $('#addHorses').click(function(){
        var raceId=$(this).attr('href').match(/id=([0-9]+)/)[1];

        //Display Div and Text area
        toggleDiv('#importHorse');
        //alert('Race Id: '+raceId);
        return false;
    });
    


    $('#closeImportHorse').click(function(){
        toggleDiv('#importHorse');
        $("#frmImportHorse")[0].reset();
        return false;
    });

    $('#sIHorse').click(function(){
        var currUrl=$(location).attr('href');
        var action='importHorses';
        var iH_raceId=$('#addHorses').attr('href').match(/id=([0-9]+)/)[1];
        var tArea= $('#horseData').val();

        if((tArea)&&(iH_raceId)){
            //alert(tArea);
            $.ajax({
               url:'raceMgmt.php',
               type: 'POST',
               data:'rId='+iH_raceId+'&action='+action+'&hdata='+tArea,
               success:function(){
                   $(location).attr('href',currUrl);
                   //alert(result);
               }
            });

        }

        return false;
    });

    $('.editHorses').live('click',function(){
      var horseRecId=$(this).attr('href').match(/id=([0-9]+)/)[1];
      var str=$('#h'+horseRecId).find("td").eq(2).text();
      $('#editHorse').css('display', 'block');
      
      
      $('#hId').val(horseRecId);
      $('#hNum').val($('#h'+horseRecId).find("td").eq(0).text());
      $('#hNam').val($('#h'+horseRecId).find("td").eq(1).text());
      $('#hMgWeight').val($('#h'+horseRecId).find("td").eq(3).text());
      $('#hPerf').val($('#h'+horseRecId).find("td").eq(5).text());
      $('#hAge').val($('#h'+horseRecId).find("td").eq(6).text());
      $('#hEquip').val($('#h'+horseRecId).find("td").eq(7).text());
      $('#hWei').val($('#h'+horseRecId).find("td").eq(8).text());
      $('#hDraw').val($('#h'+horseRecId).find("td").eq(9).text());
      $('#hTfactor').val($('#h'+horseRecId).find("td").eq(10).text());
      //$('#hType').val($('#h'+horseRecId).find("td").eq(11).text());
      $('#editHorse_rId').val($('#h'+horseRecId).find("td").eq(12).text());
      $('#wopRate').val($('#h'+horseRecId).find("td").eq(14).text());
      $('#hCommentEn').val($('#h'+horseRecId).find("td").eq(15).text());
      $('#hCommentFr').val($('#h'+horseRecId).find("td").eq(16).text());
      $('#hTNote').val($('#h'+horseRecId).find("td").eq(17).text());
      $('#hFormNote').val($('#h'+horseRecId).find("td").eq(18).text());
      $('#hOwners').val($('#h'+horseRecId).find("td").eq(19).text());
      var tShot=$('#h'+horseRecId).find("td").eq(20).text();
      var sBox=$('#h'+horseRecId).find("td").eq(21).text();
      $('#hCasak').val($('#h'+horseRecId).find("td").eq(22).text());
      
      if(tShot==1){
            $('#hTrainShot').attr('checked',true);
            $('#hTrainShot').val('1');
        }else{
            $('#hTrainShot').attr('checked',false);
            $('#hTrainShot').val('0');
        }
      if(sBox==1){
            $('#hSelBox').attr('checked',true);
            $('#hSelBox').val('1');
        }else{
            $('#hSelBox').attr('checked',false);
            $('#hSelBox').val('0');
        }
      
      $("#hType option[value=" + $('#h'+horseRecId).find("td").eq(13).text() +"]").attr("selected","selected") ;
      if($('#hType option:selected').text()=='WoP'){
          $('#wopRate').css('display','inline');
      }else{
          $('#wopRate').css('display','none');
      }
      
      var jocSt=$('#h'+horseRecId).find("td").eq(4).text();
      substr=jocSt.split('|');
      var joc=substr[0];
      var stab=substr[1];

      var action="popJoc";
      
        $.ajax({
            url:'raceMgmt.php',
            type: 'POST',
            data:'action='+action+'&joc='+joc,
            success:function(result){
               $('#hJockey .hl').remove();
               $('#hJockey').append(result);
            }
        });
        
        action="popStab";
        $.ajax({
            url:'raceMgmt.php',
            type: 'POST',
            data:'action='+action+'&stab='+stab,
            success:function(result){
               $('#hStable .hl').remove();
               $('#hStable').append(result);
                //alert(result);
            }
        });
        
        var n='';var x='';var e='';var d='';var s='';
        var m='';var c='';var l='';var P='';var Y='';
                
        for(var i=0; i<str.length;i++){
            if(str.charAt(i)=='n'){
                n+='n';
            }else if(str.charAt(i)=='x'){
                x+='x';
            }else if(str.charAt(i)=='e'){
                e+='e';
            }else if(str.charAt(i)=='d'){
                d+='d';
            }else if(str.charAt(i)=='s'){
                s+='s';
            }else if(str.charAt(i)=='m'){
                m+='m';
            }else if(str.charAt(i)=='c'){
                c+='c';
            }else if(str.charAt(i)=='l'){
                l+='l';
            }else if(str.charAt(i)=='Y'){
                Y+='Y';
            }else if(str.charAt(i)=='P'){
                P+='P';
            }
        }
        $('#chanceN').val(n);$('#chanceX').val(x);$('#chanceE').val(e);$('#chanceD').val(d);
        $('#chanceS').val(s);$('#chanceM').val(m);$('#chanceC').val(c);$('#chanceL').val(l);
        $('#chanceY').val(Y);$('#chanceP').val(P);

      return false;
    });


    $('#closeEditHorse').click(function(){
       $('#editHorse').css('display', 'none');
       return false;
    });
    
    $('#hType').change(function(){
       if ($('#hType option:selected').text()=='WoP'){
           $('#wopRate').css('display','inline');
       }else{
           $('#wopRate').css('display','none');
           $('#wopRate').val('0');
       }
    });
    
    $('#saveHorseRec').click(function(){
        var hId=$('#hId').val();
        var hNum=$('#hNum').val();
        var hNam=$('#hNam').val();
        var pChances=$('#chanceN').val()+$('#chanceX').val()+$('#chanceE').val()+$('#chanceD').val()+$('#chanceS').val()+$('#chanceM').val()+$('#chanceC').val()+$('#chanceL').val()+$('#chanceY').val()+$('#chanceP').val();
        var hWeight=$('#hMgWeight').val();
        var stab=$('#hStable option:selected').val();
        var jocK=$('#hJockey option:selected').text();
        var jocCode=$('#hJockey option:selected').val();
        var hPerf=$('#hPerf').val();
        var hAge=$('#hAge').val();
        var hEquip=$('#hEquip').val();
        var wei=$('#hWei').val();
        var hDraw=$('#hDraw').val();
        var hTfactor=$('#hTfactor').val();
        var hWopRate=$('#wopRate').val();
        var hType=$('#hType option:selected').val();
        var rowId=$('#editHorse_rId').val();
        var webChances=$('#chanceX').val(); //Chances displayed on web
        var hCommentEn=$('#hCommentEn').val();
        var hCommentFr=$('#hCommentFr').val();
        var hTNote=$('#hTNote').val();
        var hFormNote=$('#hFormNote').val();
        var hOwners=$('#hOwners').val();
        var hCasak=$('#hCasak').val();
        if($('#hTrainShot').attr('checked')=='checked'){
            chkTrainShot="1";
        }else{
            chkTrainShot="0";
        }
        if($('#hSelBox').attr('checked')=='checked'){
            hSelBox="1";
        }else{
            hSelBox="0";
        }
        
        action="saveEditHorse";
        $.ajax({
            url:'raceMgmt.php',
            type: 'POST',
            data:'rId='+rowId+'&action='+action+'&hId='+hId+'&hNum='+hNum+'&hNam='+hNam+'&pChances='
                +pChances+'&hWeight='+hWeight+'&stab='+stab+'&jocK='+jocK+'&hPerf='+hPerf+'&hAge='+hAge+
                '&hEquip='+hEquip+'&wei='+wei+'&hDraw='+hDraw+'&hTfactor='+hTfactor+'&hType='+hType+
                '&jocCode='+jocCode+'&hWopRate='+hWopRate+'&webChances='+webChances+'&hCommentEn='
                +hCommentEn+'&hCommentFr='+hCommentFr+'&hTNote='+hTNote+'&hFormNote='+hFormNote+'&hOwners='
                +encodeURIComponent(hOwners)+'&chkTrainShot='+chkTrainShot+'&hSelBox='+hSelBox+'&hCasak='+hCasak,
            success:function(){
                var action='getHorseList';
                
                $.ajax({
                   url:'raceMgmt.php',
                   type: 'POST',
                   data:'rId='+rowId+'&action='+action,
                   success:function(result){
                       $('#horseList .hl').remove();
                       $('#horseList').append(result);
                       $('#editHorse').css('display','none');
                   }
                });
            }
        });
        
        if(hType==11){
            action="changeRaceStatus";
            $.ajax({
               url:'raceMgmt.php',
               type:'POST',
               data:'rId='+rowId+'&action='+action,
               success:function(){
                var currUrl=$(location).attr('href');
                $(location).attr('href',currUrl);
            }
            });
        }
        
        
        
        return false;
        
    });
    
    $('#addHWeight').click(function(){

        $('#importHorseWeight').css('display','block');
        return false;
    });
    
    $('#addNomination').click(function(){

        $('#importNomi').css('display','block');
        return false;
    });
    

    $('#closeImportHorseWeight').click(function(){
        $('#importHorseWeight').css('display','none');
        return false;
    });
    
    $('#closeImportNomi').click(function(){
        $('#importNomi').css('display','none');
        return false;
    });
    
    $('#sINomi').click(function(){
        var currUrl=$(location).attr('href');
        var action='importNomination';
        var iH_raceId=$('#addHorses').attr('href').match(/id=([0-9]+)/)[1];
        var tAreaWeight= $('#horseNomi').val();
        
//        alert('Action: '+action+' <br/>Id-Race: '+iH_raceId+' <br/>AreaVal: '+tAreaWeight+' <br/>CurrUrl: '+currUrl);
        $.ajax({
            url:'raceMgmt.php',
            type: 'POST',
            data:'rId='+iH_raceId+'&action='+action+'&hNomi='+tAreaWeight,
            success:function(){
                $(location).attr('href',currUrl);
                //alert(data);
            }
        });
        
        return false;
    });
    
    
    $('#sIHorseWeight').click(function(){
        var currUrl=$(location).attr('href');
        var action='importHorsesWeight';
        var iH_raceId=$('#addHorses').attr('href').match(/id=([0-9]+)/)[1];
        var tAreaWeight= $('#weightData').val();
        var radValue=$("input[name='hWnT']:checked").val();
        
        $.ajax({
            url:'raceMgmt.php',
            type: 'POST',
            data:'rId='+iH_raceId+'&action='+action+'&hWeight='+encodeURIComponent(tAreaWeight)+'&radVal='+radValue,
            success:function(){
                $(location).attr('href',currUrl);
                //alert(data);
            }
        });
        
        //alert('Race Id: ' + iH_raceId + ' Text Area: '+ tAreaWeight+ ' Rad Val: '+radValue+ ' Action: '+action);
        
        return false;
    });
    
    $('.editWebInfo').click(function(){
       $('#editRace').css('display','none');
        $('#listhorse').css('display','none');
        $('#editHorse').css('display','none');
        $('#webInfo').css('display','block');
        $('#importHorseWeight').css('display','none');
        $('#importNomi').css('display','none');
        
        var raceId=$(this).attr('href').match(/id=([0-9]+)/)[1];
        $('#webInfo_rId').val(raceId);
        action="getWebInfo";
        
        //fetch race info
        $.ajax({
            url:'raceMgmt.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data:'rId='+raceId+'&action='+action,
            success:function(data){
                $('#prize').val(data.prize);
                $('#aTitle_en').val(data.enTitle);
                $('#aText_en').val(data.enText);
                $('#aTitle_fr').val(data.frTitle);
                $('#aText_fr').val(data.frText);
                $('#cGears').val(data.cGears);
                $('#sRep').val(data.sReport);
                
            }
        });
       
       return false;
    });
    
    $('#saveWebInfo').click(function(){
        var currUrl=$(location).attr('href');
        
        var action="saveWebInfo";
        var raceId=$('#webInfo_rId').val();
       var prize=$('#prize').val();
       var enTitle=$('#aTitle_en').val();
       var enText=$('#aText_en').val();
       var frTitle=$('#aTitle_fr').val();
       var frText=$('#aText_fr').val();
       var cGears=$('#cGears').val();
       var sReport=$('#sRep').val();
       
       
       $.ajax({
            url:'raceMgmt.php',
            type: 'POST',
            data:'rId='+raceId+'&action='+action+'&prize='+prize+'&enTitle='+enTitle+'&enText='+enText+'&frTitle='+frTitle+'&frText='+frText+'&cGears='+cGears+'&sReport='+sReport,
            success:function(){
                $(location).attr('href',currUrl);
            }
        });
       
       return false;
    });
    
    $('#closeWebInfo').click(function(){
        $('#webInfo').css('display','none');
        return false;
    });


});

function toggleCreate(){
    if ($('#createRace:visible').length > 0){
            $('#createRace').css('display','none');
            $('#frmNewRace')[0].reset();
        }else{
            if ($('#editRace:visible').length > 0){
                $('#editRace').css('display','none');
            }
            $('#createRace').css('display','block');
            $('.msgStatus').css('display','none');
        }
}
function toggleEdit(){
    if ($('#editRace:visible').length > 0){
            $('#editRace').css('display','none');

        }else{

            $('#editRace').css('display','block');

        }
}

function toggleDiv(divname){
    if ($(divname+':visible').length > 0){
       $(divname).css('display','none');

        }else{

            $(divname).css('display','block');

        }
}

function fillData(id){

    $(id).each(function() {
        //var td2 = $(this).find("td").eq(3).text();

        $('#ernum').val($(this).find("td").eq(0).text());
        $('#ertime').val($(this).find("td").eq(1).text());
        $('#ername').val($(this).find("td").eq(2).text());
        $('#erdist').val($(this).find("td").eq(3).text());
        $('#erating').val($(this).find("td").eq(4).text());
        $('#rstatus').val($(this).find("td").eq(6).text());
        $("#wstatus option[value=" + $(this).find("td").eq(5).text() +"]").attr("selected","selected") ;
        //alert(td2);
    });
    
}


