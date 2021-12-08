//$(".menu #"+a).addClass("active");
function DownloadSection(id)
{
	if(id == "body"){
		//Remove & add class
		$('#body_2').removeClass('active');
		$('#files_2').removeClass('active');
		$('#poster_2').removeClass('active');
		
		$('#body_2').addClass('active');
		
		if(document.getElementById("body").style.display == "none")
			document.getElementById("body").style.display = "block";
		
		if(document.getElementById("poster").style.display == "block")
			document.getElementById("poster").style.display = "none";
		
		if(document.getElementById("files").style.display == "block")
			document.getElementById("files").style.display = "none";
			
		//Add Class
		
	}
	
	if(id == "poster"){
		
		//Remove & add class
		$('#body_2').removeClass('active');
		$('#files_2').removeClass('active');
		$('#poster_2').removeClass('active');
		
		$('#poster_2').addClass('active');
	
		if(document.getElementById("poster").style.display == "none")
			document.getElementById("poster").style.display = "block";
		
		if(document.getElementById("body").style.display == "block")
			document.getElementById("body").style.display = "none";
			
		if(document.getElementById("files").style.display == "block")
			document.getElementById("files").style.display = "none";
		
		
	}
	
	if(id == "files"){
		
		//Remove & add class
		$('#body_2').removeClass('active');
		$('#files_2').removeClass('active');
		$('#poster_2').removeClass('active');
		
		$('#files_2').addClass('active');
		
		if(document.getElementById("files").style.display == "none")
			document.getElementById("files").style.display = "block";
		
		if(document.getElementById("body").style.display == "block")
			document.getElementById("body").style.display = "none";
		
		if(document.getElementById("poster").style.display == "block")
			document.getElementById("poster").style.display = "none";
	}
}