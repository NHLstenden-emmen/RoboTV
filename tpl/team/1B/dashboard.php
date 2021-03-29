<div id="dashboard">
	<div class="liveFeed neonBlock1B">
		<h1>liveFeed</h1>
	</div>
	<div class="startGame neonBlock1B">
		<h1>start the games</h1>
		<div id="startButton">
			<div class="bigStart">
				<button onclick="Startup()">Start The Robot</button>
				<div class="icon">
					<!-- <i class="fas fa-times"></i> -->
					<i class="fas fa-skull-crossbones"></i>
				</div>
			</div>
		</div>
		<div id="panicButton">
			<div class="bigStop">
				<button onclick="stop()">PANIC BUTTON</button>
				<div class="icon">
					<!-- <i class="fas fa-times"></i> -->
					<i class="fas fa-skull-crossbones"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="console neonBlock1B">
		<h1>console</h1>
	</div>
</div>

<script>
function Startup() {
	$(document).ready(function() {
		$.post("/tpl/team/1B/sendData.php", {
			'action': 'Startup'
		});
		var timestamp = '[' + Date.now() + '] ';
		console.log(timestamp + 'Startup');
	});
}
function stop() {
	$(document).ready(function() {
		$.post("/tpl/team/1B/sendData.php", {
			'action': 'STOP'
		});
		var timestamp = '[' + Date.now() + '] ';
		console.log(timestamp + 'STOP');
	});
}

</script>