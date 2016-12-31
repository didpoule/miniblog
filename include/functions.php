<?php
function calc_nbPages($nbElement, $nbElementPage)
{
    $nbPages = $nbElement / $nbElementPage;
    $nbPages= ceil($nbPages);
    return $nbPages;
}

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

function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
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