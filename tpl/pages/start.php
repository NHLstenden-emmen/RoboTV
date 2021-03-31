<div class="container">

	<div class="row">
	
		<div class="col-md-12 col-lg-3 main">
		<h1 class="title">{HOME_TITLE}</h1>
		<p class="intro">{HOME_INTRO}</p>
		<a href="teams" class="button">{HOME_BUTTON}</a>
		</div>
		
		<div class="col-md-12 col-lg-9 main">
			<img onmouseover="hover(this);" onmouseout="unhover(this);" id="ESP" class="img zoom" src="{assetsFolder}/images/arduino_0.png" alt="Arduino/ESP32 schematische weergave">
		</div>
	</div>
</div>


<script>

function hover(element) {
	element.setAttribute('src', '{assetsFolder}/images/arduino_1.png');
}

function unhover(element) {
  element.setAttribute('src', '{assetsFolder}/images/arduino_0.png');
}

</script>