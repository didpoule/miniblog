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