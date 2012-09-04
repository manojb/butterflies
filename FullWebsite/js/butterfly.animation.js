$(function(){
var  totalAnimationDuration = 11000;
	$('#animation-stage').fadeOut(totalAnimationDuration);		   
	animateBackground('butterfly1',3, 150, gAniInstance1);
	animateBackground('butterfly2',3, 150, gAniInstance2);	
	
	window.butterflyRunloop = jQuery.runloop();
	  butterflyRunloop.addKey('5%', function(){
		$("#butterfly1, #butterfly2").animate( {top: "290px", opacity: '0.8' }, { duration:3000, queue:false });
		//$("#butterfly3").animate( {top: "-=345px", opacity: '.8' }, { duration:2000, queue:false } );

	  });
	  butterflyRunloop.addMap({
	   '30%' : function(){rotation();},
	   '45%' : function(){curve2();},
	   '60%' : function(){curve11();}
	   //'55%' : function(){curve3();}
	  });
	  butterflyRunloop.play(totalAnimationDuration);
	  
});

var rotation = function (){
   $("#butterfly1").rotate({
      angle:0, 
      animateTo:-20,
      //easing: $.easing.easeOut
	  duration: 3000
   });
   $("#butterfly2").rotate({
      angle:0, 
      animateTo:25,
      //easing: $.easing.easeOut
	  duration: 3000
   });
  //$("#butterfly1").animate( {top: "150px", left: "220px", opacity: '1' }, { duration:2000, queue:false } );
  curve1();
  //console.log('2');
}





function curve1(){
 $('#butterfly1').animate({top: "120px", left: "180px", opacity: 0.4}, {
          duration: 3000, 
          specialEasing: {top: 'easeOutQuad', left: 'easeInQuad', opacity: 'linear'}
		  
          });
 
 $('#butterfly2').animate({top: "120px", left: "320px", opacity: 0.4}, {
          duration: 3000, 
          specialEasing: {top: 'easeOutQuad', left: 'easeInQuad', opacity: 'linear'}
		  
          });
}

function curve2(){
 $('#butterfly1').animate({top: "50px", left: "80px", opacity: 0}, {
          duration: 2000, 
          specialEasing: {top: 'easeOutQuad', left: 'easeInQuad', opacity: 'linear'},
		  complete: function() {
            $(this).hide();
          }
          });
 
 $("#butterfly1").rotate({
      angle:-20, 
      animateTo:-40,
     duration: 3000
   });
// Butterfly 2 
 $('#butterfly2').animate({top: "50px", left: "490px", opacity: 0}, {
          duration: 2000, 
          specialEasing: {top: 'easeOutQuad', left: 'easeInQuad', opacity: 'linear'},
		  complete: function() {
            $(this).hide();
          }
          });
 $("#butterfly2").rotate({
      angle:25, 
      animateTo:40,
     duration: 3000
   });
}

var gAniInstance1,gAniInstance2;
function animateBackground(objId,fps,frameDuration,aniIns){
var $obj = $('#'+objId);
var objWidth = $obj.width();
var currentIteration = 0; 
aniIns = window.setInterval(function(){
	if(currentIteration < fps){
		$obj.css('background-position','-'+(currentIteration*objWidth)+ 'px 0px');
		currentIteration++;
		
	}
	else{
		currentIteration = 0;
		$obj.css('background-position','-'+(currentIteration*objWidth)+ 'px 0px');
		currentIteration = 1;
		
	}
	},frameDuration);
}
function stopAnimation(aniIns){
	window.clearInterval(gAniInstance1);
}
