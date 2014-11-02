<!doctype html>
<html>
<head>
    <style>
        .navbar {
            display block;
            background-color: #333;
            font-family: Verdana;
            padding: 0.5em;
        }

        .navbar a {
            background-color: #999;
            color: #fff;
            padding: 0.2em;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #666;
            padding: 0.5em 0.2em 0.5em 0.2em
        }
    </style>
</head>
<body>
<?php

    $menu = array(
        'company'  => array('text' => 'Company', 'url' => 'CompanyDisplayGrid.php'),
        'level'    => array('text' => 'Level', 'url' => ' '),
        'division' => array('text' => 'Division', 'url' => ' '),
        'Branch'   => array('text' => 'Branch', 'url' => 'BranchDisplayGrid.php')
    );

    class Navigation
    {

        public static function GenerateMenu($items)
        {

            $html = "<nav class='navbar'>\n";
            foreach ($items as $item) {
                $html .= "<a href='{$item['url']}'>{$item['text']}</a>&nbsp;&nbsp; ";
            }
            $html .= "<nav>\n";

            return $html;
        }

    }

    echo Navigation::GenerateMenu($menu);

?>
</body>
</html>