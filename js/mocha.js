$(document).ready(function() 
{	 
	var index = 0;
	var images = $("#slidebanner-right img");
	var thumbs = $("#slidebanner-left img");
	var imgHeight = 100;
	$(thumbs).slice(0,3).clone().appendTo("#slidebanner-left");
        
        
        
	for (i=0; i<thumbs.length; i++)
	{
		$(thumbs[i]).addClass("thumb-"+i);
		$(images[i]).addClass("image-"+i);
	}
	
	show(index);
	setInterval(sift, 9000);
	$("#next").click(function(){
            sift();
            return false;
        });
        
	function sift()
	{
		if (index<(thumbs.length-1)){index+=1 ; }
		else {index=0}
		show (index);
	}
	
	function show(num)
	{
		
		$(images).fadeOut(0);
                $(".image-"+num).stop().fadeIn(0);
                
                if(num>1){
                    num=num-1;
                }
                var scrollPos = (num)*imgHeight;
		$("#slidebanner-left").stop().animate({scrollTop: scrollPos}, 400);		
		//console.log(scrollPos, "img.image-"+num);
	}
        

});