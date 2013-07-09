/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


 
$(function(){
 
    //var modVal=$('#newClient').val();
    //var modVal=1;
    //showChangeOdds(modVal);

	//if close button is clicked
	$('.window .close').click(function (e) {
		//Cancel the link behavior
		e.preventDefault();
		
		$('#mask').hide();
		$('.window').hide();
                //document.location.href='index.php';
	});		
	
	//if mask is clicked
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
               // document.location.href='index.php';
	});
        
        
        //movable
        $("#dialog").on('mousedown', function() {
            $(this).addClass('movable');
            startMove();
        }).on('mouseup', function() {
            $(this).removeClass('movable');
            endMove();
        });
        
});

function endMove() {
    $(this).removeClass('movable');
    
}

function startMove() {
    $('.movable').on('mousemove', function(event) {
        var thisX = event.pageX - $(this).width() / 2,
            thisY = event.pageY - $(this).height() / 2;

        $('.movable').offset({
            left: thisX,
            top: thisY
        });
        document.getSelection().removeAllRanges();
    });
    
}

function showChangeOdds(modVal){
    if (modVal==1){
            
            var id = '#dialog';
	
		//Get the screen height and width
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
                
		//Set heigth and width to mask to fill up the whole screen
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		
		//transition effect		
		$('#mask').fadeIn(10);	
		$('#mask').fadeTo("fast",0.3);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
                
                
                //Set the popup window to center
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
                
                
                var offset = $(document).scrollTop();
                viewportHeight = $(window).height();
                $(id).css('top',  (offset  + (viewportHeight/2)) - ($(id).outerHeight()/2));
                
	
		//transition effect
		$(id).fadeIn(10); 
                
        }
}