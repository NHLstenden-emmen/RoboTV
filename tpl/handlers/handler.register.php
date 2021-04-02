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

                        $regAntwoord = $user->Register($voorNaam, $achterNaam, $regEmail, $regPass1, $regPass2);
                                                
                        if($regAntwoord == 1)
                        {
                            $this->Set("regError", $this->Get("GEBRUIKERBEHEER_BESTAAT"));
                        }
                
                        else if($regAntwoord == 2)
                        {
                            $this->Set("regError", $this->Get("GEBRUIKERBEHEER_WACHTWOORDEN_OVEREEN"));
                        }
                        else if($regAntwoord == 3)
                        {
                            $this->Set("regError", $this->Get("GEBRUIKERBEHEER_INVOEGEN_VERKEERDE_EMAIL"));
                        }
                        else 
                        {
                            $loginAntwoord = $user->Login($regEmail, $regPass2);
                            $core->Redirect(Config::$loginStartpage);
                        }
                    }
                }
            }
        }
    }
}

?>