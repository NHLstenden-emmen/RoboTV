<?php 

$this->Set("extraCSS", '<link rel="stylesheet" href="'.$this->Get("assetsFolder").'/css/page/livestream.css">');
$this->Set("extraJS", '<script src="'.$this->Get("assetsFolder").'/js/page/livestream.js"></script>
                        <script src="'.$this->Get("assetsFolder").'/js/live/chat.js"></script>
                        <script>launchLiveChat('.$user->id.')</script>');

?>