<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Mon blog</title>
    <link href="modules/blog/view/style.css" rel="stylesheet"/>
</head>

<body>
<div id="corps_page">
    <?php
    include 'header.php';
    if(!$errmsg)
    {
        include 'billet.php';
    }
    else
    {
        echo getErrMsg($errmsg);
    }

    if ($nbPages > 1) 
    {
        pageSelector($nbPages);
    }

    include 'footer.php';
    ?>
</div>
</body>
</html>
