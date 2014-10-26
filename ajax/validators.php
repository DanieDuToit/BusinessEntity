<?php 
    $fieldIdName = 'aDouble';
    $precision = 3;
    $fieldValue = 0;
    $fieldValue = number_format($fieldValue, $precision);
    $retVal = "<input type=text id=$fieldIdName name=$fieldIdName
             onKeyUp=\"\$().fieldValidatorDouble(event, '$fieldIdName', '$precision');\" 
             value=\"".$fieldValue."\" $setFooterText />";
    $fieldIdName1 = 'aMoney';
    $fieldValue1 = 0;
    $fieldValue1 = number_format($fieldValue1, 2);
    $retVal1 = "<input type=text id=$fieldIdName1 name=$fieldIdName1
             onKeyUp=\"\$().fieldValidatorMoney(event, '$fieldIdName1');\" 
             value=\"".$fieldValue1."\" $setFooterText />";
    $fieldIdName2 = 'aInteger';
    $fieldValue2 = 0;
    $retVal2 = "<input type=text id=$fieldIdName2 name=$fieldIdName2
             onKeyUp=\"\$().fieldValidatorInteger(event, '$fieldIdName2');\" 
             value=\"".$fieldValue2."\" $setFooterText />";
    $fieldIdName3 = 'aPattern';
    $fieldValue3 = "";
    $retVal3 = "<input type=text id=$fieldIdName3 name=$fieldIdName3
             onKeyUp=\"\$().fieldValidatorPattern(event, '$fieldIdName3');\" 
             value=\"".$fieldValue3."\" $setFooterText />";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Validators Javascript</title>
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" src="fieldValidators.js"></script>
        <script type="text/javascript" src="inputClear.js"></script>
    </head>
    <body>
        <div>
            <table>
                <tbody>
                    <tr>
                        <td>Give Double:</td>
                        <td>
                            <?php echo $retVal ?>
                        </td>
                        <td id="<?php echo $fieldIdName ?>Error"></td>
                    </tr>
                    <tr>
                        <td>Give Money:</td>
                        <td>
                            <?php echo $retVal1 ?>
                        </td>
                        <td id="<?php echo $fieldIdName1 ?>Error"></td>
                    </tr>
                    <tr>
                        <td>Give Integer:</td>
                        <td>
                            <?php echo $retVal2 ?>
                        </td>
                        <td id="<?php echo $fieldIdName2 ?>Error"></td>
                    </tr>
                    <tr>
                        <td>Give Pattern:</td>
                        <td>
                            <?php echo $retVal3 ?>
                        </td>
                        <td id="<?php echo $fieldIdName3 ?>Pattern"></td>
                    </tr>
                    <tr>
                        <td>Give Double:</td>
                        <td>
                            <input type="text" id="fieldName" onKeyUp="$().fieldValidatorDouble(event, 'fieldName', 5);" />
                        </td>
                    </tr>
                    <tr>
                        <td id="keys"></td>
                        <td><button id="clear">Clear</button></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
