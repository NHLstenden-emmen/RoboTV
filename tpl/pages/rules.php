<div class="container">
    <div id="gameRules">
        <h1 class="title">{RULES_TITLE}</h1>
        <br>
        <div class="row">

            <!-- Race -->
            <div class="col-sm-12 gameBlock" id="race" data-aos="fade-up">
                <div class="row">
                    <div class="col-sm-6 gamePhoto photoLeft">
                        <h2 class="gameTitle titleLeft">Race</h2>
                        <img src="{assetsFolder}/images/team/1A/logo.png" title="Team A" alt="Team A">
                    </div>
                    <div class="col-sm-6 neonBorder gameDescription">
                        {GAMERULES_HEADING}
                        {RULES_RACE}
                        <h5>Scores</h5>
						{RULES_TABLE}
                    </div>
                </div>
            </div>

            <!-- Maze -->
            <div class="col-sm-12 gameBlock" id="maze" data-aos="fade-up">
                <div class="row">
                    <div class="col-sm-6 neonBorder gameDescription">
                        {GAMERULES_HEADING}
                        {RULES_MAZE}
                        <h5>Scores:</h5>
                        {RULES_TABLE}
                    </div>
                    <div class="col-sm-6 gamePhoto photoRight">
                        {RULES_MAZETITLE}
                        <img src="{assetsFolder}/images/team/1A/logo.png" title="Team A" alt="Team A">
                    </div>
                </div>
            </div>

            <!-- Rock, Paper, Scissors -->
            <div class="col-sm-12 gameBlock" id="RPS" data-aos="fade-up">
                <div class="row">
                    <div class="col-sm-6 gamePhoto">
                        {RULES_RPSTITLE}
                        <img src="{assetsFolder}/images/team/1A/logo.png" title="Team A" alt="Team A">
                    </div>
                    <div class="col-sm-6 neonBorder gameDescription">
                        {GAMERULES_HEADING}
                        {RULES_RPS}
                        <h5>Scores:</h5>
                        {RULES_TABLE}
                    </div>
                </div>
            </div>

            <!-- Drawing -->
            <div class="col-sm-12 gameBlock" id="drawing" data-aos="fade-up">
                <div class="row">
                    <div class="col-sm-6 neonBorder gameDescription">
                        {GAMERULES_HEADING}
                        {RULES_DRAWING}
                        <h5>Scores:</h5>
                        {RULES_MAZETABLE}
                    </div>
                    <div class="col-sm-6 gamePhoto photoRight">
                        {RULES_DRAWINGTITLE}
                        <img src="{assetsFolder}/images/team/1A/logo.png" title="Team A" alt="Team A">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>