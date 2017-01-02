<?php

// Retourne nombre de pages
function calc_nbPages($nbElement, $nbElementPage)
{
    $nbPages = $nbElement / $nbElementPage;
    $nbPages= ceil($nbPages);
    return $nbPages;
}

// Définit les paramètres OFFSET et LIMIT pour pagination
function donnees_page($page, $nbPages, $nbElementPage)
{
    $page = htmlspecialchars($page);
    $offset = 0;
    $i = 0;
    if ($page < 0) {
        $page = 0;
    } elseif ($page >= $nbPages) {
        $page = $nbPages - 1;
    }
    while ($i < $page) {
        $offset += $nbElementPage;
        $i++;
    }
    return $offset;
}

// Vérification de la validité de l'adresse mail, retourne NULL si invalide
function verifEmail($email)
{
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $email = NULL;
    }
    return $email;
}

// Récupération du gravatar grâce à l'email, renvoie un avatar par défaut si non existant
function get_gravatar( $email, $s = 50, $d = 'mm', $r = 'g', $img = true, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

// Fonctions de cryptage pour mots de passes. Sources www.stackoverflow.com

function encrypt($pure_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
}

function decrypt($encrypted_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}

// Vérification du mot de passe pour la connexion
function controleLogin($user, $login, $password)
{
    $resultat = false;

    if(empty($login) || empty($password))
    {
        return false;
    }
    else
    {
        $key = $login . $password;
        $password = encrypt($password, $key);
    }

    if($login == $user['login'] && $password == $user['password'])
    {
        $resultat = true;
    }
    return $resultat;
}

function dateFr($date)
{
    $dateFr = new DateTime($date);
    $dateFr = $dateFr->format('d/m/Y à H:i:s');

    return $dateFr;
}