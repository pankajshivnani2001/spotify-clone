var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentSongIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;


$(window).scroll(function() {
	hideOptionsMenu();
});

$(document).click(function(click) {

	var clickTarget = $(click.target);

	// if(clickTarget is not on the optionsMenu items && clickTarget is not on three dots button)
	//		hideOptionsMenu();

	if(!clickTarget.hasClass("item") && !clickTarget.hasClass("options"))
		hideOptionsMenu();

});


$(document).on("change", "select.playlist", function() {
	var select = $(this);
	var playlistId = $(this).val(); //the value attribute for the select option that was chosen.
	var songId = $(this).prev(".songId").val(); //getting the songId from the hidden input just above the <select>

	$.post("http://localhost/slotify/includes/handlers/ajax/addSongInPlaylist.php", {playlistId : playlistId, songId : songId, username : userLoggedIn})
	.done(function(response) {
		hideOptionsMenu();
		select.val("");

		if(response != "")
		{
			alert(response);
		}
	});

});

$(document).on("change", "select.filterListSelect", function() {
		var select = $(this);

		var selectedOption = select.val();

		if(selectedOption == "Most Played")
		{
			openPage("browse.php?sortBy=1");
		}

		else if(selectedOption == "Least Played")
		{
			openPage("browse.php?sortBy=2");
		}

		else if(selectedOption == "Longest Duration")
		{
			openPage("browse.php?sortBy=3");
		}

		else if(selectedOption == "Shortest Duration")
		{
			openPage("browse.php?sortBy=4");
		}

		

});



//function to dynamically change the main Content without altering the navbar or nowPlayingContainer.
//We will also replace all <a> tags and use onclick with the <span>
function openPage(url) {

	if(timer != null){
		clearTimeout(timer);
	}

	if(url.indexOf("?") == -1) {
		url += "?";
	}

	var encoded_url = encodeURI(url + "&userLoggedIn=" + userLoggedIn);

	$("#mainContent").load(encoded_url);
	$("body").scrollTop(0);//scroll to top whenever we load a page
	history.pushState(null, null, url); //to make the url update in the browser url 
}

function openPaymentPage(url) {

	window.open(url, "_blank");
}



//function for the play button on the artistPage
function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}


function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60);
	var seconds = time - (minutes*60);

	var extraZero = seconds < 10 ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
	//html audio element has duration and currentTime which can be used to set our current time and remaining time 
	//in the progress bar
	$(".progressTime.current").text(formatTime(audio.currentTime));

	var remainingTime = formatTime(audio.duration - audio.currentTime);
	$(".progressTime.remaining").text((remainingTime));

	//setting the progress bar width percentage
	var widthPercent = (audio.currentTime / audio.duration) * 100;
	$(".playBackBar .progress").css("width", widthPercent+"%");
}

//audio class
function Audio() {
	this.currentlyPlaying;
	this.audio = document.createElement('audio'); //create an element of type 'audio' in our document


	//Adding an event listener to update the remaining time in the progress bar.

	//the event listener will listen for the "canplay" event and perform the defined function.
	this.audio.addEventListener('canplay', function() {

		var duration = formatTime(this.duration-this.currentTime); //'this' refers to the object that the event was called for, audio
		$(".progressTime.remaining").text(duration); 
		playSong();
	});

	this.audio.addEventListener('timeupdate', function() {
		if(this.duration) {
			updateTimeProgressBar(this);
		}
	});

	// go to the next song when the current song ends
	this.audio.addEventListener('ended', function() {
		nextSong();
	});	


	//a function to give the path of the song to the audio element.
	this.setTrack = function(songJson) {
		this.currentlyPlaying = songJson;
		this.audio.src = songJson.path;
	} 

	this.play = function() {
		this.audio.play();
	}

	this.pause = function() {
		this.audio.pause();
	}

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}

	this.setVolume = function(volume) {
		this.audio.volume = volume;
		$(".volumeBar .progress").css("width", (volume*100)+"%");
	}
}



function createPlaylist() {
	console.log(userLoggedIn);
	var playlistName = prompt("Enter Playlist Name");

	if(playlistName != null) {
		$.post("includes/handlers/ajax/createPlaylist.php", { playlistName : playlistName, username : userLoggedIn })
		.done(function(response) {	

			if(response == "False")
			{
				alert("Your Current Plan Does Not Support Any More Playlists. Please Upgrade...")

			}
			openPage("yourMusic.php")

		});
	}
}

function deletePlaylist(playlistId) {

	var sure = confirm("Are You sure you want to delete this playlist?");
	if(sure)
	{
		$.post("includes/handlers/ajax/deletePlaylist.php", {playlistId : playlistId});
		openPage("yourMusic.php");
	}
	
}

function showOptionsMenu(button) {

	var songId = $(button).prev(".songId").val(); //getting songId from the tracklist hidden input part

	$(".optionsMenu").find(".songId").val(songId); //setting songId for the options menu hidden input

	var optionsMenu = $(".optionsMenu");
	var optionsMenuWidth = optionsMenu.width();

	var scrollTop = $(window).scrollTop(); //$(selector).scrollTop() - Return vertical scrollbar position
	var elementOffset = $(button).offset().top;

	var top = elementOffset - scrollTop;
	var left = $(button).position().left - optionsMenuWidth;

	optionsMenu.css({"top" : top + "px", "left" : left + "px", "display" : "inline"});
}


function hideOptionsMenu() {
	var menu = $(".optionsMenu");
	menu.css({"display" : "none"});
}


function deleteFromPlaylist(playlistId) {
	var songId = $(".optionsMenu").find(".songId").val();
	$.post("includes/handlers/ajax/deleteFromPlaylist.php", {songId : songId, playlistId : playlistId});
	openPage("playlist.php?id="+playlistId);
}


function logout() {
	$.post("includes/handlers/ajax/logout.php", function() {
		location.reload();
	})
}

function updateEmail() {
	var email = $(".email").val();

	$.post("includes/handlers/ajax/updateEmail.php", { email : email, userLoggedIn : userLoggedIn})
	.done(function(response) {//response is what we will get if we echo something in the updateEmail.php file
		$(".emailMessage").text(response);
	})
}

function updatePassword() {
	var username = userLoggedIn;
	var currentPw = $("[name = 'currentPw']").val();
	var newPw = $("[name = 'newPw']").val();
	var confirmPw = $("[name = 'confirmPw']").val()

	$.post("includes/handlers/ajax/updatePassword.php", { username : username, currentPw : currentPw, newPw : newPw, confirmPw : confirmPw })
	.done(function(response) {
		$(".passwordMessage").text(response);
		$("[name = 'currentPw']").val("");
		$("[name = 'newPw']").val("");
		$("[name = 'confirmPw']").val("");
	})
}

function upgradePlan(planType) {
	$.post("includes/handlers/ajax/upgradePlan.php", {planType : planType, username : userLoggedIn})
	.done(function(response) {
		//openPage('upgradePlan.php');
		$(".currentPlan").text(response);
	})
}



