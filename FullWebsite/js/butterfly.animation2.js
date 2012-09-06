		var totalAnimationDuration = 15000;
		var r1 = 1;
		var r2 = 1;
		var r3 = 1;
        var objTop, objLeft;
		
		var topOffset = 2;
		var leftOffset1  = 2;
		var leftOffset3 = 1;

		
		
        function startAnimation(objId) {
			$obj=$('#'+objId);
			var obj = document.getElementById(objId);
			obj.style.position = "absolute";
			//var position = $obj.position();
			//objTop = position.top;
			//objLeft = position.left;
			objTop = obj.style.top;
			objLeft = obj.style.left;
			
			var classNameSuffix = objId.charAt(objId.length-1);

			            
            if (parseInt(objTop) > 400) {
                obj.style.top = (parseInt(objTop) - topOffset) + "px";
            }
            else if (parseInt(objTop) > 340) 
			{
				switch (classNameSuffix)
				{
				    case '1':
				        //$obj.attr("class","rotate" + classNameSuffix + "_" + r1);
				        obj.style.left = (parseInt(objLeft) - leftOffset1) + "px";
				        //if(r1<5) r1++;
				        if (r1 == 1) rotate_B1();
				        r1++;
				        break;
					case '2':
						//$obj.attr("class","rotate" + classNameSuffix + "_" + r2);
						obj.style.left = (parseInt(objLeft) + leftOffset1) + "px";
						//if(r2<5) r2++;
						if (r2 == 1) rotate_B2();
						r2++;
					break;
	                case '3':
	                    //$obj.attr("class","rotate" + classNameSuffix + "_" + r3);
	                    obj.style.left = (parseInt(objLeft) - leftOffset3) + "px";
	                    if (r3 == 1) {
	                        obj.style.display = "block";
	                        $obj.fadeOut(7500);
	                        rotate_B3();
	                    }
	                    r3++;

	                    //if(r3<5) r3++;
	                    break;
				}

				
                obj.style.top = (parseInt(objTop) - topOffset) + "px";
            }
            else 
			{
                obj.style.top = (parseInt(objTop) - topOffset) + "px";
				
                switch (classNameSuffix)
				{
					case '1':
						obj.style.left = (parseInt(objLeft) - leftOffset1) + "px";
					break;
					case '2':
						obj.style.left = (parseInt(objLeft) + leftOffset1) + "px";
					break;
					case '3':
						obj.style.left = (parseInt(objLeft) - leftOffset3) + "px";
					break;
				}
				
            }
        }
        
		
		var int=self.setInterval(function(){
			startAnimation('butterfly1');
			startAnimation('butterfly2');
			startAnimation('butterfly3');
		}, 50);
		
		// butterfly falpping wings 
	var gAniInstance = new Array();
	function animateBackground(objId,fps,frameDuration,aniIns){
		var $obj = $('#'+objId);
		var objWidth = $obj.width();
		var currentIteration = 0; 
		gAniInstance[aniIns] = window.setInterval(function(){
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
	
	animateBackground('butterfly1',3, 150, 0);
	animateBackground('butterfly2',3, 150, 1);
	animateBackground('butterfly3',3, 150, 2);

	$(function(){
		$("#butterfly2").fadeOut(totalAnimationDuration-1000);
		$("#animation-stage, #butterfly1").fadeOut(totalAnimationDuration,function(){
		stop();
		});
		
	});
	
	function stop(){
		window.clearInterval(int);
		window.clearInterval(gAniInstance[0]);
		window.clearInterval(gAniInstance[1]);
		window.clearInterval(gAniInstance[2]);
}


function rotate_B1() {

    $("#butterfly1").rotate({
        angle: 0,
        animateTo: -45,
        //easing: $.easing.easeOut
        duration: 3000
    });
}

function rotate_B2() {

    $("#butterfly2").rotate({
        angle: 0,
        animateTo: 35,
        //easing: $.easing.easeOut
        duration: 3000
    });
}

function rotate_B3() {

    $("#butterfly3").rotate({
        angle: 0,
        animateTo: -10,
        //easing: $.easing.easeOut
        duration: 2000
    });
}