<?php

    function selectbox($arr)
    {
        echo "<option>Select</option>";
        $i = 0;
        foreach ($arr as $v) {
            $i += 1;
            echo "<option value=" . $i . ">$v</option>";
        }
    }

    switch ($_GET['company']) {
        case 1:
            $companies = array("Apples", "Bananans", "Pineapples");
            break;
        case "3":
            $companies = array("Sour Worms", "Wilsons Toffee", "Bar One");
            break;
        case 2:
            $companies = array("Potato", "Carrot", "Cabbage");
            break;
        default:
            break;
    }
    selectbox($companies);

