
 $('body').keydown(function(event){
	if (event.which == 37) //左鍵的代碼
		$(".left").click();
	if (event.which == 39)  //右鍵的代碼
		$(".right").click();
});


 $('body').bind('mousewheel', function(e){
     if(e.originalEvent.wheelDelta < 0) //scroll down         
         $(".right").click();
     else //scroll up
         $(".left").click();
     //prevent page fom scrolling
     return false;
 });