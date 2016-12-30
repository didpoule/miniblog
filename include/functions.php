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