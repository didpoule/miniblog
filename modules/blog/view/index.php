<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Mon blog</title>
    <link href="include/style.css" rel="stylesheet"/>
</head>

<body>
    <div id ="corps_page">
        <?php
        include 'header.php';
        include 'billet.php';
        ?>
        <div class = "page_select">
            <nav>
                <p>Pages: <?php
                    for($i = 0; $i < $nbPages; $i++) {
                        echo '<ul><a href ="?page=' . $i . '">' . $i . '</a>/</ul>';
                    }
                    ?></p>
            </nav>
        </div>
    </div>
</body>
</html>