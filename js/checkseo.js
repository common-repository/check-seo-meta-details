$(document).ready(function(){
	
	//meta title bg color - length
	$("#metatitle").keyup(function(){
		var title=$("#metatitle").val();
        if(title.length < 60) {
			$("#metatitle").css("background-color", "#ff9693");
			$( "div.t-length" ).text( "Input Length : " + title.length );
		}
		else if(title.length <= 72 && title.length >= 60) {
			$("#metatitle").css("background-color", "#c9ffac");
			$( "div.t-length" ).text( "Input Length : " + title.length );
		}
		else if(title.length > 72 ) {
			$("#metatitle").css("background-color", "#ff9693");
			$( "div.t-length" ).text( "Input Length : " + title.length );
		}
		
	});
	
	//mete desc bg color - length
	$("#wpmetadescription").keyup(function(){
		var title=$("#wpmetadescription").val();
        if(title.length < 120) {
			$("#wpmetadescription").css("background-color", "#ff9693");
			$( "div.des-length" ).text( "Input Length : " + title.length );
		}
		else if(title.length <= 160 && title.length >= 120) {
			$("#wpmetadescription").css("background-color", "#c9ffac");
			$( "div.des-length" ).text( "Input Length : " + title.length );
		}
		else if(title.length > 160 ) {
			$("#wpmetadescription").css("background-color", "#ff9693");
			$( "div.des-length" ).text( "Input Length : " + title.length );
		}
		
	});
	
	    
});