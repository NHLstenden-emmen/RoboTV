// Set the date we're counting down to
var countDownDate = new Date("Apr 2, 2021 16:57:00").getTime();

// Update the count down every 1 second
var x = setInterval(function () {
	// Get today's date and time
	var now = new Date().getTime();

	// Find the distance between now and the count down date
	var distance = countDownDate - now;

	// Time calculations for days, hours, minutes and seconds
	var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	var seconds = Math.floor((distance % (1000 * 60)) / 1000);

	// Output the result in an element with id="countdown"
	document.getElementById("countdowndays").innerHTML = days + "d ";

	document.getElementById("countdownhours").innerHTML = hours + "h ";

	document.getElementById("countdownminutes").innerHTML = minutes + "m ";

	document.getElementById("countdownseconds").innerHTML = seconds + "s ";

	// If the count down is over, write some text
	if (distance < 0) {
		clearInterval(x);
		document.querySelector(".countdowncontainer").style.opacity = "0";
	} else {
		document.querySelector(".countdowncontainer").style.opacity = "1";
	}
}, 1000);
