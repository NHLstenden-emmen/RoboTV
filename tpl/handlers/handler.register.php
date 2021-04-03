<?php
//Kijk of knop ingedrukt is

$user->Redirect(true);
$this->Set("regError", "");
$this->Set("pageTitle", $this->Get("LOGIN_REGISTREREN"));
$this->Set("extraCSS", '<link rel="stylesheet" href="'.$this->Get("assetsFolder").'/css/page/register.css">');

if(isset($_POST['regSubmit']))
{  
    if(isset($_POST['voorNaam']))
    {    
        if(isset($_POST['achterNaam']))
        {
            if(isset($_POST['regEmail']))
            {
                if(isset($_POST['regPass1']))
                {
                    if(isset($_POST['regPass2']))
                    {
                        $voorNaam = $_POST['voorNaam'];
                        $achterNaam = $_POST['achterNaam'];
                        $regEmail = strtolower($_POST['regEmail']);
                        $regPass1 = $_POST['regPass1'];
                        $regPass2 = $_POST['regPass2'];
						$verificationKey = $user->generateVerificationKey();

                        $regAntwoord = $user->Register($voorNaam, $achterNaam, $regEmail, $regPass1, $regPass2, $verificationKey);
                                                
                        if($regAntwoord == 1)
                        {
                            $this->Set("regError", $this->Get("GEBRUIKER_BESTAAT"));
                        }
                        else if($regAntwoord == 2)
                        {
                            $this->Set("regError", $this->Get("WACHTWOORD_NIETOVEREEN"));
                        }
                        else if($regAntwoord == 3)
                        {
                            $this->Set("regError", $this->Get("GELDIGE_MAIL"));
                        }
                        else if($regAntwoord == 4)
                        {
							$verificationLink = "http://robotv.serverict.nl/login?verificationKey=".$verificationKey;
							$message = 'Hello '.$voorNaam.' '.$achterNaam.',<br><br>';
							$message .= 'Please activate your account by pressing this link: <a href="'.$verificationLink.'">Verify me!</a><br><br>';
							$message .= 'Greetings from the <br><a style="color: black;" href="https://youtu.be/dQw4w9WgXcQ">RoboTV Team</a>';
							if($mailer->send($regEmail, 'Verification RoboTV', $message, $username = '')){
								$core->Redirect("/?check=verifyaccount");
							} else {
								$core->Redirect("register");
							}
                        }
                    }
                }
            }
        }
    }
}

?>