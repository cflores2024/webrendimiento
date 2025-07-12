$(function(){
	
	var note = $('#note'),
		ts = new Date(2025, 7, 7),
		newYear = true;
	
	if((new Date()) > ts){
		// The new year is here! Count towards something else.
		// Notice the *1000 at the end - time must be in milliseconds
		ts = (new Date()).getTime() + 15*24*60*60*1000;
		newYear = false;
	}
		
	$('#countdown').countdown({
		timestamp	: ts,
		callback	: function(days, hours, minutes, seconds){
			
			var message = "";
			
			message += days + " dias" + ( days==1 ? '':'s' ) + ", ";
			//message += hours + " horas" + ( hours==1 ? '':'s' ) + ", ";
			message += minutes + " minutos" + ( minutes==1 ? '':'s' ) + " and ";
			//message += seconds + " segundos" + ( seconds==1 ? '':'s' ) + " <br />";
			
			if(newYear){
				message += "left until the new year!";
			}
			else {
				message += "left to 10 days from now!";
			}
			
			note.html(message);
		}
	});
	
});