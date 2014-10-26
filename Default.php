<?php
    // Start the session
    session_start();
?>
<?php
    include "Header.inc.php";

    $menu = array(
        'company' => array('text' => 'Company', 'url' => 'CompanyDisplayGrid.php'),
        'division' => array('text' => 'Division', 'url' => 'DivisionDisplayGrid.php'),
        'Branch' => array('text' => 'Branch', 'url' => 'BranchDisplayGrid.php'),
        'BusinessLevel' => array('text' => 'BusinessLevel', 'url' => 'BusinessLevelDisplayGrid.php')
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