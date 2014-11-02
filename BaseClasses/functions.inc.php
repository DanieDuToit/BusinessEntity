<?php
    //$disabled = "";
    //include_once "Includes/MabeEnum/Enum";
    /**
     * Returns the passed Request variable value, or the passed default if the Request is not set.
     *
     * @param text $paramName
     * @param text $defaultValue
     * @return text
     */
    //	function getRequestVariable($paramName, $defaultValue = null)
    //	{
    //		$paramName = (string)$paramName;
    //		if (isset($_REQUEST[$paramName])) {
    //			return $_REQUEST[$paramName];
    //		} else {
    //			return $defaultValue;
    //		}
    //	}//getRequestVariable()

    /**
     * Returns the passed Session variable value, or null if the Session variable is not set.
     *
     * @param  string $settingName
     * @return string
     */
    //	function getSessionApplicationVariable($variableName, $defaultValue = null)
    //	{
    //		if (isset($_SESSION[ApplicationSettings::$applicationPrefix . "_" . $variableName])) {
    //			return $_SESSION[ApplicationSettings::$applicationPrefix . "_" . $variableName];
    //		}
    //		return $defaultValue;
    //	}

    /**
     * Sets a Application $_SESSION variable.
     *
     * @param string $variableName
     * @param string $value
     */
    //	function setSessionApplicationVariable($variableName, $value)
    //	{
    //		$_SESSION[ApplicationSettings::$applicationPrefix . "_" . $variableName] = $value;
    //	}

    /**
     * Unsets a Application $_SESSION variable.
     *
     * @param string $variableName
     */
    //	function unsetSessionApplicationVariable($variableName)
    //	{
    //		unset($_SESSION[ApplicationSettings::$applicationPrefix . $variableName]);
    //	}

    /**
     * Draws a standard link
     * @param text $action
     * @param text $displayText
     * @param text $class
     * @param text $onClick
     * @return string
     */
    //	function drawLink($action, $displayText, $class = null, $onClick = null)
    //	{
    //		if ($onClick) {
    //			$onClick = "onClick=\"return " . (string)$onClick . "\"";
    //		}
    //		if ($class == null) {
    //			$retVal = "<a href=\"default_old.php?action=" . (string)$action . "\" (string)$onClick >" . (string)$displayText . "</a>";
    //		} else {
    //			$retVal = "<a class=\"" . (string)$class . "\" href=\"default_old.php?action=" . (string)$action . "\" $onClick >" . (string)$displayText . "</a>";
    //		}
    //		return $retVal;
    //	}//drawLink()

    /**
     * Return the html for standard input fields based on the passed parameters
     * @param text    $fieldIdName
     * @param text    $fieldType
     * @param text    $fieldValue
     * @param array   $fieldParams : [0]=width/maxlength value, [1]=onKeyUp, [2]=onBlur, [3]=
     * @param text    $helpText
     * @param boolean $isMandatory
     * @param text    $class
     * @return html
     */
    function drawInputField($fieldIdName, $fieldType, $fieldValue, $fieldParams, $friendlyName = null, $helpText = null, $isMandatory = null, $class = null)
    {
        global $disabled;
        $fieldIdName = (string)$fieldIdName;
        $fieldType   = (string)$fieldType;
        $fieldValue  = (string)$fieldValue;
        if (!$fieldParams) {
            $fieldParams = array();
        }
        if (!$helpText || $helpText == '') {
            if (!$friendlyName && $friendlyName != '') {
                $helpText = $fieldIdName;
            } else {
                $helpText = $friendlyName;
            }
        }

        if ($isMandatory == "1") {
            $mandatoryFlag = "<span class=mandatoryStar>*</span>";
            $class .= "mandatoryField";
        } else {
            $mandatoryFlag = "";
        }

        if (isset($fieldParams[FieldParameters::disabled_par])) {
            if ($fieldParams[FieldParameters::disabled_par] == "Disabled") {
                $disabled = " disabled";
            }
        }

        //Error Div: shows validation errors
        $errorDiv = "<span id=" . $fieldIdName . "Error name=" . $fieldIdName . "Error class=ErrorDiv></span>";

        //Going to transform the title with jQuery into a pretty popup
        $setHelpText = 'title="' . $helpText . '"';

        $retVal = "";
        switch ($fieldType) {
            case "text":
                //0 - Width
                //1 - OnKeyUp
                //2 - OnBlur
                //3 - OnDoubleClick
                if ($fieldParams[FieldParameters::width_par]) {
                    $width     = ($fieldParams[FieldParameters::width_par]) . "px";
                    $maxLength = $fieldParams[FieldParameters::maxlength_par];
                } else {
                    $width     = "250px";
                    $maxLength = "50";
                }
                $onKeyUp       = "";
                $onBlur        = "";
                $onDoubleClick = "";
                if (isset($fieldParams[FieldParameters::onKeyUp_par])) {
                    $onKeyUp = 'onKeyUp=' . $fieldParams[FieldParameters::onKeyUp_par] . '"';
                }
                if (isset($fieldParams[FieldParameters::onBlur_par])) {
                    $onBlur = 'onBlur=' . $fieldParams[FieldParameters::onBlur_par] . '"';
                }
                if (isset($fieldParams[FieldParameters::onDblClick_par])) {
                    $onDoubleClick = 'onDblClick="' . $fieldParams[FieldParameters::onDblClick_par] . '"';
                }
                //				$disabled = "";
                //				if (isset($fieldParams[FieldParameters::disabled_par])) {
                //					if ($fieldParams[FieldParameters::disabled_par] == "Disabled") {
                //						$disabled = " disabled";
                //					}
                //				}
                $retVal = "<input type=text id=$fieldIdName name=$fieldIdName style=\"width:$width\"
                          maxlength=\"$maxLength\" value=\"" . $fieldValue . "\" title=\"$helpText\"
                          " . $onKeyUp . $onBlur . $onDoubleClick . $disabled . "

                          class=\"helpText $class\" />";
                $retVal .= $mandatoryFlag;
                break;

            case "double":
            case "decimal":
                //				$disabled = "";
                //				if (isset($fieldParams[FieldParameters::disabled_par])) {
                //					if ($fieldParams[FieldParameters::disabled_par] == "Disabled") {
                //						$disabled = " disabled";
                //					}
                //				}
                $precision = isset($fieldParams[FieldParameters::precision_par]) ? $fieldParams[FieldParameters::precision_par] : 2;
                if ($fieldValue == null || $fieldValue == '') {
                    $fieldValue = '';
                } else {
                    $fieldValue = number_format($fieldValue, $precision);
                }
                $retVal = "<input type=text id=$fieldIdName name=$fieldIdName align=right
                          onKeyUp=\"$().fieldValidatorDouble(event, '$fieldIdName', '$precision');\" 
                          value=\"" . $fieldValue . "\"
                          $setHelpText . $disabled .
                          onChange=\"editFormStateChange(this)\" 
                          class=\"helpText $class\" />";
                $retVal .= $mandatoryFlag;
                $retVal .= $errorDiv;
                break;

            case "int":
                //0 - Width
                //1 - extra OnKeyUp
                if (isset($fieldParams[FieldParameters::width_par])) {
                    $width = $fieldParams[FieldParameters::width_par] . "px";
                } else {
                    $width = "250px";
                }
                $onKeyUp = "$().fieldValidatorInteger(event, '$fieldIdName', true); ";
                if (isset($fieldParams[FieldParameters::onKeyUp_par])) {
                    $onKeyUp .= $fieldParams[FieldParameters::onKeyUp_par];
                }
                if (isset($fieldParams[FieldParameters::class_par])) {
                    $class .= ' ' . $fieldParams[FieldParameters::class_par];
                }
                $retVal = "<input type=text id=$fieldIdName name=$fieldIdName align=right style=\"width:$width\"
                          onKeyUp=\"$onKeyUp\" 
                          value=\"" . $fieldValue . "\" $setHelpText . $disabled
                          onChange=\"editFormStateChange(this)\" 
                          class=\"helpText $class\"  />";
                $retVal .= $mandatoryFlag;
                $retVal .= $errorDiv;
                break;

            case "routine":
                if ($fieldParams[FieldParameters::width_par]) {
                    $width = $fieldParams[FieldParameters::width_par] . "px";
                } else {
                    $width = "250px";
                }
                $retVal = "<input type=text id=$fieldIdName name=$fieldIdName align=right
                          onKeyUp=\"$().fieldValidatorPattern(event, '$fieldIdName');\" 
                          value=\"" . $fieldValue . "\" $setHelpText
                          onChange=\"editFormStateChange(this)\" 
                          style=\"width:$width\" 
                          class=\"helpText $class\" />";
                $retVal .= $mandatoryFlag;
                $retVal .= "<span id=" . $fieldIdName . "Pattern name=" . $fieldIdName . "Pattern class=ErrorDiv></span>";
                break;

            case "money":
                if ($fieldParams[FieldParameters::width_par]) {
                    $width = $fieldParams[FieldParameters::width_par] . "px";
                } else {
                    $width = "250px";
                }
                $fieldValue = number_format($fieldValue, 2, ".", "");
                $retVal     = "<input type=text id=$fieldIdName name=$fieldIdName align=right style=\"width:$width\"
                          onKeyUp=\"$().fieldValidatorMoney(event, '$fieldIdName');\" 
                          value=\"" . $fieldValue . "\" $setHelpText
                          onChange=\"editFormStateChange(this)\"
                          class=\"helpText $class\"/ >";
                $retVal .= $mandatoryFlag;
                $retVal .= $errorDiv;
                break;

            case "textarea":
                $cols      = $fieldParams[FieldParameters::cols_par];
                $rows      = $fieldParams[FieldParameters::rows_par];
                $maxLength = $fieldParams[FieldParameters::maxlength_par];
                $retVal    = "<textarea id=$fieldIdName name=$fieldIdName cols=$cols rows=$rows maxlength=$maxLength
                             class=\"helpText $class\" >" . $fieldValue . "</textarea>";
                $retVal .= $mandatoryFlag;
                break;
            case "password":
                if ($fieldParams[FieldParameters::width_par]) {
                    $width = $fieldParams[FieldParameters::width_par] . "px";
                } else {
                    $width = "250px";
                }
                $retVal = "<input type=password id=$fieldIdName name=$fieldIdName
                          style=\"width:$width\" 
                          value=\"" . $fieldValue . "\"
                          $setHelpText
                          class=\"helpText $class\" />";
                $retVal .= $mandatoryFlag;
                break;

            case "checkbox":
                $checked = $fieldValue ? "checked" : "";
                if (isset($fieldParams[FieldParameters::onClick_par])) {
                    $onClick = "onClick=\"" . $fieldParams[FieldParameters::onClick_par] . "\"";
                } else {
                    $onClick = "";
                }
                $retVal .= "<input type='checkbox' id=$fieldIdName name=$fieldIdName
                           value=\"" . $fieldIdName . "\"
                           $checked
                           $setHelpText
                           $onClick
                           $disabled
                           onChange=\"editFormStateChange(this)\"
                           class=\"helpText $class\" />";
                $retVal .= $mandatoryFlag;
                break;

            case "date":
                if (isset($fieldParams[FieldParameters::onBlur_par])) {
                    $onBlur = "onBlur = \"" . $fieldParams[FieldParameters::onBlur_par] . "\";";
                } else {
                    $onBlur = "";
                }

                $retVal = "<input type=text id=$fieldIdName name=$fieldIdName
                          class=\"baseDate helpText $class\" 
                          value=\"" . $fieldValue . "\"
                          $onBlur 
                          $setHelpText 
                          onChange=\"editFormStateChange(this)\"  />";
                $retVal .= $mandatoryFlag;
                break;

            case "lookup":
                $retVal = "<input type=text id=$fieldIdName name=$fieldIdName style=\"width:200\" value=\"" . $fieldValue . "\" $setHelpText class=\"helpText $class\" >
                   <input type=button id=" . $fieldIdName . "LOV name=" . $fieldIdName . "LOV value=\"...\" onClick=\"showLookupBox('$fieldIdName');\" onChange=\"editFormStateChange(this)\" class=\"button helpText\" />";
                $retVal .= $mandatoryFlag;
                break;

            case "radioItem":
                //0 - Group name
                //1 - OnClick
                //2 - Submit page on click?
                $groupIdName = $fieldParams[FieldParameters::groupIdName_par];
                $onClick     = $fieldParams[FieldParameters::onClick_par];
                $autoRefresh = $fieldParams[FieldParameters::autoRefresh_par] == "True" ? "submit();" : "";
                $checked     = $groupIdName . "_" . $fieldValue == $fieldIdName ? "checked=\"checked\"" : "";
                $retVal      = "<input type=radio id=$groupIdName name=$groupIdName value=\"" . $fieldIdName . "\" $checked
                          onClick=\"" . $onClick . "; $autoRefresh \"
                          onChange=\"editFormStateChange(this);\" 
                          $setHelpText 
                          class=\"helpText $class\" />";
                break;

            case "radio":
                //0 - List of options
                //1 - OnClick
                $radioOptions = explode("|", $fieldParams[FieldParameters::radioOptions_par]);
                for ($i = 0; $i < count($radioOptions); $i += 2) {
                    $valueText   = $radioOptions[$i];
                    $displayText = $radioOptions[($i + 1)];
                    $checked     = $fieldValue == $valueText ? "checked=\"checked\"" : "";
                    $onClick     = isset($fieldParams[FieldParameters::onClick_par]) ? $fieldParams[FieldParameters::onClick_par] : "";
                    $retVal .= "<input type=radio id=$fieldIdName name=$fieldIdName value=\"" . $valueText . "\"
                         $checked 
                         onClick=\"" . $onClick . ";\"
                         onChange=\"editFormStateChange(this)\" 
                         $setHelpText
                         class=\"helpText $class\"/> " . $displayText . "  ";
                }
                $retVal .= $mandatoryFlag;
                break;

            case "dropdown":
                //0 - First value null
                //1 - Submit form on change
                //2 - Associative array of value/display pairs
                //3 - OnChange javascript
                //4 - css class list
                //5 - convert to select2?
                if (isset($fieldParams[FieldParameters::onchange_par])) {
                    $extraOnChange = $fieldParams[FieldParameters::onchange_par] . "; ";
                } else {
                    $extraOnChange = " ";
                }
                if (isset($fieldParams[FieldParameters::class_par])) {
                    $class = "class=\" " . $fieldParams[FieldParameters::class_par] . " " . $class;
                } else {
                    $class = "class=\" $class ";
                }
                if (isset($fieldParams[FieldParameters::isSelect2DropDown_par])) {
                    if ($fieldParams[FieldParameters::isSelect2DropDown_par] == "False") {
                        //Not an select2 dropdown
                    } else {
                        $class .= " select2 ";
                    }
                }
                $class .= " \"";

                $autoRefresh = $fieldParams[FieldParameters::autoRefresh_par] == "True" ? "submit();" : "";
                $retVal .= "<div class=\"helpText\" $setHelpText ><select id=$fieldIdName name=$fieldIdName $class onChange=\"" . $extraOnChange . $autoRefresh . "\" >";
                if ($fieldParams[FieldParameters::value_par] <> "False") {
                    $retVal .= "<option value=\"" . $fieldParams[FieldParameters::value_par] . "\">" . $fieldParams[FieldParameters::value_par] . "</option>";
                }
                $dropDownValues = $fieldParams[FieldParameters::dropDownValues_par];
                foreach ($dropDownValues as $col => $val) {
                    if (trim($fieldValue) == trim($col)) {
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }
                    $retVal .= "<option value=" . $col . " $selected>" . $val . "</option>";
                }
                $retVal .= "</select></div>";
                $retVal .= $mandatoryFlag;
                break;

            //			case "select":
            //				//0 - ObjectName
            //				//1 - First option blank
            //				//2 - Form Submit on change
            //				//3 - Extra Onchange
            //				//4 - Filter Column
            //				//5 - Filter Value
            //				//6 - Width
            //				//7 - Class
            //				//8 - Make select2
            //				if (isset($fieldParams[FieldParameters::onchange_par])) {
            //					$extraOnChange = $fieldParams[FieldParameters::onchange_par];
            //				} else {
            //					$extraOnChange = "";
            //				}
            //				$autoRefresh = $fieldParams[FieldParameters::autoRefresh_par] == "True" ? "onChange=\"editFormStateChange(this); " . $extraOnChange . "; submit();\"" : "onChange=\"editFormStateChange(this); " . $extraOnChange . ";\" ";
            //				if (isset($fieldParams[FieldParameters::width_par])) {
            //					$width = "style=\"width: " . $fieldParams[FieldParameters::width_par] . "px;\"";
            //				} else {
            //					$width = "";
            //				}
            //				$param7 = isset($fieldParams[FieldParameters::isSelect2DropDown_par]) ? $fieldParams[FieldParameters::isSelect2DropDown_par] : '';
            //				if ($param7 === "True") {
            //					$select2 = "select2";
            //				} else {
            //					$select2 = "";
            //				}
            //				if (isset($fieldParams[FieldParameters::isSelect2DropDown_par])) {
            //					$class = "class=\"" . $select2 . " " . $fieldParams[7] . " $class\"";
            //				} else {
            //					$class = "class=\"" . $select2 . " $class\"";
            //				}
            //				//Don't put an empty <option> unless the calling function wants it
            //				$retVal .= "<div class=\"helpText\" $setHelpText><select id=$fieldIdName name=$fieldIdName $autoRefresh $width $class>";
            //				if ($fieldParams[FieldParameters::value_par] <> "False") {
            //					if ($fieldValue == $fieldParams[FieldParameters::value_par]) {
            //						$selected = "selected";
            //					} else {
            //						$selected = "";
            //					}
            //					$retVal .= "<option value=\"" . $fieldParams[FieldParameters::value_par] . "\" $selected>" . $fieldParams[FieldParameters::value_par] . "</option>";
            //				}
            //
            //				$selectObject = new $fieldParams[0];
            //				if (isset($fieldParams[4])) {
            //					$select = $selectObject->getSelectSelect($fieldParams[4], $fieldParams[5]);
            //				} else {
            //					$select = $selectObject->getSelectSelect();
            //				}
            //				$result = dbQuery($select);
            //				if ($result) {
            //					while ($arow = dbFetchArray($result)) {
            //						if ($fieldValue == $arow["Id"]) {
            //							$selected = "selected";
            //						} else {
            //							$selected = "";
            //						}
            //						$retVal .= "<option value=" . $arow["Id"] . " $selected>" . $arow["Name"] . "</option>";
            //					}
            //				} else {
            //					$retVal .= "<option>ERROR" . dbGetErrorMsg() . "</option>";
            //				}
            //				$retVal .= "</select></div>";
            //				$retVal .= $mandatoryFlag;
            //				break;

            case "time":
                //0 - OnChange()
                //1 - Disabled
                if (isset($fieldParams[FieldParameters::onchange_par])) {
                    $onChange = "editFormStateChange(this); " . $fieldParams[FieldParameters::onchange_par];
                } else {
                    $onChange = "editFormStateChange(this); ";
                }
                $disabled = "";
                if (isset($fieldParams[FieldParameters::disabled_par])) {
                    if ($fieldParams[FieldParameters::disabled_par] == "Disabled") {
                        $disabled = "disabled";
                    }
                }
                $retVal      = "<input type=hidden id=$fieldIdName name=$fieldIdName value=\"" . $fieldValue . "\" class=\"" . $class . "\"/>";
                $hours       = floor($fieldValue / 60);
                $minutes     = $fieldValue - ($hours * 60);
                $selectHours = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23);
                $retVal .= "<select id=" . $fieldIdName . "Hours name=" . $fieldIdName . "Hours onChange=\"updateHiddenMinutes('$fieldIdName'); $onChange\" $disabled >";
                foreach ($selectHours as $col) {
                    $selected = $hours == $col ? "selected" : "";
                    $retVal .= "<option value=$col $selected>$col</option>";
                }
                $retVal .= "</select>";
                $retVal .= "&nbsp;:&nbsp;";
                $selectMinutes = array(0, 15, 30, 45);
                $retVal .= "<select id=" . $fieldIdName . "Minutes name=" . $fieldIdName . "Minutes
                            onChange=\"updateHiddenMinutes('$fieldIdName'); $onChange\" 
                            $disabled
                            class=\"helpText\" >";
                foreach ($selectMinutes as $col) {
                    $selected = $minutes == $col ? "selected" : "";
                    $retVal .= "<option value=$col $selected>$col</option>";
                }
                $retVal .= "</select>";
                $retVal .= $mandatoryFlag;
                break;

            default:
                $retVal = "Unknown type:" . $fieldType . " - " . $fieldValue;
        }
        return $retVal;
    }//drawInputField()

    /**
     * Draws a hidden input. If $show==true then the field will be show with it's id/name as the lable for debugging
     * @param text    $fieldIdName
     * @param text    $fieldValue
     * @param boolean $show
     * @return html
     */
    function drawHiddenField($fieldIdName, $fieldValue, $show = false)
    {
        $fieldIdName = (string)$fieldIdName;
        $fieldValue  = (string)$fieldValue;
        $retVal      = "";
        $type        = $show ? "text" : "hidden";
        if ($show) {
            $retVal .= $fieldIdName . ":";
        }
        $retVal .= "<input type=$type id=$fieldIdName name=$fieldIdName value=\"" . $fieldValue . "\">";
        return $retVal;
    }//drawHiddenField()

    /**
     * Convert the radio params of ApplicationObjectField into an array
     * Turn  1|Daily|2|Weekly|3|Monthly into array(1=>Daily, 2=>Weekly....
     * @param text $paramString
     * @return array
     */
    function radioParamStringToArray($paramString)
    {
        $retArray   = array();
        $paramArray = explode("|", $paramString);
        $isKey      = true;
        $lastKey    = "";
        foreach ($paramArray as $col) {
            if ($isKey) {
                $isKey          = false;
                $retArray[$col] = "";
                $lastKey        = $col;
            } else {
                $isKey              = true;
                $retArray[$lastKey] = $col;
                $lastKey            = "";
            }
        }
        return $retArray;
    }//radioParamStringToArray()

    /**
     * Draws the <td> of for an overview row
     * Formatting, decoding and alignment based on $fieldType
     * @param text  $fieldValue
     * @param text  $fieldType
     * @param array $fieldParams
     * @return html
     */
    function drawOverviewField($fieldValue, $fieldType, $fieldParams = array())
    {
        $fieldType  = (string)$fieldType;
        $fieldValue = (string)$fieldValue;
        $td         = "<td>";
        switch ($fieldType) {
            case "text":
            case "dropdown":
            case "routine":
                $retVal = $fieldValue;
                break;

            case "checkbox":
                $td      = "<td align=center>";
                $checked = $fieldValue ? "checked" : "";
                $retVal  = "<input type=checkbox " . $checked . " disabled />";
                break;

            case "radio":
                $td          = "<td align=center>";
                $valuesArray = radioParamStringToArray($fieldParams[0]);
                $retVal      = $valuesArray[$fieldValue];
                break;

            case "double":
            case "decimal":
                $td        = "<td  align=right>";
                $precision = isset($fieldParams[0]) ? $fieldParams[0] : 2;
                $retVal    = number_format($fieldValue, $precision);
                break;

            case "int":
                $td     = "<td align=right>";
                $retVal = $fieldValue;
                break;

            case "date":
                $retVal = substr($fieldValue, 0, 10);
                break;

            case "datetime":
                $retVal = substr($fieldValue, 0, 19);
                break;

            case "money":
                $td     = "<td  align=right>";
                $retVal = "R" . number_format($fieldValue, 2);
                break;

            //			case "select":
            //				$objectName = $fieldParams[0];
            //				$object = new $objectName($fieldValue);
            //				$sql = $object->getDecodeSelect();
            //				$result = dbQuery($sql);
            //				if ($result) {
            //					$arow = dbFetchArray($result);
            //					$retVal = $arow["Name"];
            //				}
            //				break;

            case "time":
                $td    = "<td align=center>";
                $units = $fieldParams[0];
                if ($units == "hours") {
                    $hours   = str_pad($fieldValue, 2, "0", STR_PAD_LEFT);
                    $minutes = "00";
                } else {
                    $hours   = floor($fieldValue / 60);
                    $hours   = str_pad($hours, 2, "0", STR_PAD_LEFT);
                    $minutes = $fieldValue - ($hours * 60);
                    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);
                }
                $retVal = $hours . ":" . $minutes;
                break;

            default:
                $retVal = "unknown type: " . $fieldType . " - " . $fieldValue;
                break;
        }//switch
        if ($retVal == "") {
            $retVal = "&nbsp;";
        }
        return $td . $retVal . "</td>";
    }//drawOverviewField()

    /**
     * Format and decode object field based on type
     * @param text $fieldValue
     * @param text $fieldParams
     * @return text
     */
    function drawObjectField($fieldValue, $fieldParams)
    {
        $fieldType = $fieldParams[4];
        switch ($fieldType) {
            case "text":
                $retVal = $fieldValue;
                break;
            case "date":
                $retVal = substr($fieldValue, 0, 10);
                break;
            case "int":
            case "radio":
                $retVal = $fieldValue;
                break;
            case "checkbox":
                $retVal  = "<input type=checkbox ";
                $checked = $fieldValue ? "checked" : "";
                $retVal .= $checked . " disabled />";
                break;
            //			case "select":
            //				$objectName = $fieldParams[6];
            //				$retVal = decodeObjectId($objectName, $fieldValue);
            //				break;
            case "money":
                $retVal = "R" . number_format((double)$fieldValue, 2);
                break;
            default:
                $retVal = $fieldValue;
                break;
        }
        return $retVal;
    }//drawObjectField()

    /**
     * Draws a standard submit button
     * @param text   $btnIdName
     * @param text   $btnText
     * @param string $onClick
     * @param string $class
     * @return hyml
     */
    function drawSubmitButton($btnIdName, $btnText, $onClick = "", $class = "button")
    {
        $btnIdName = (string)$btnIdName;
        $btnText   = (string)$btnText;
        $retVal    = "<input type=submit id=\"$btnIdName\" name=\"$btnIdName\" class=\"" . $class . "\" value=\"" . $btnText . "\" onClick=\"" . $onClick . "\" >";
        return $retVal;
    }//drawSubmitButton()

    /**
     * Draws a standard button
     * @param text   $btnIdName
     * @param text   $btnText
     * @param text   $target
     * @param text   $onClick
     * @param string $class
     * @return html
     */
    function drawButton($btnIdName, $btnText, $target = null, $onClick = null, $class = "button")
    {
        $onClick   = (string)$onClick;
        $btnIdName = (string)$btnIdName;
        $btnText   = (string)$btnText;
        if ($target) {
            $target = "window.location='default_old.php?action=$target'";
        }
        if ($onClick) {
            if ($target) {
                $onClick = "onClick=\"if(" . $onClick . "){" . $target . "}else{return false;}\"";
            } else {
                $onClick = "onClick=\"" . $onClick . "\"";
            }
        } else {
            $onClick = "onClick=\"" . $onClick . "; " . $target . "\"";
        }

        $retVal = "<input type=button id=$btnIdName name=$btnIdName value=\"$btnText\" class=\"" . $class . "\" $onClick />";
        return $retVal;
    }//drawButton()

    /**
     * Returns the javascript to redirect the browser to the passed page
     * @param text $target
     * @return text
     */
    function pageRedirect()
    {
        return "<script>window.location='default_old.php'</script>";
    }//pageRedirect()

    /**
     * Format the passed value for sql based on the passed type
     * Adds single quotes where needed
     * @param text $fieldValue :
     * @param text $fieldType
     * @return : changed field value
     */
    function formatForSql($fieldValue, $fieldType, $fieldParameters = array())
    {
        $fieldValue = (string)$fieldValue;
        $fieldType  = (string)$fieldType;
        $retVal     = '';
        switch ($fieldType) {
            case null:
                break;
            case "checkbox":
                if ($fieldValue == "Active" || $fieldValue == 1) {
                    $retVal = "1";
                } else {
                    $retVal = "0";
                }
                break;
            case "bit":
                if ($fieldValue && !(strtoupper($fieldValue) == "FALSE") && !($fieldValue == "0")) {
                    $retVal = "1";
                } else {
                    $retVal = "0";
                }
                break;
            case "select":
            case "int":
            case "money":
            case "numeric":
                if (array_key_exists(FieldParameters::nullIfZero_par, $fieldParameters) && $fieldValue == null) {
                    $retVal = "null";
                } elseif ($fieldValue === 0) {
                    $retVal = "0";
                } elseif ($fieldValue === "0") {
                    $retVal = "0";
                } elseif ($fieldValue == " ") { //empty <select>s have " " for thier value
                    $retVal = "null";
                } elseif ($fieldValue) {
                    $retVal = $fieldValue;
                } else {
                    $retVal = "null";
                }
                break;
            case "date":
            case "datetime":
                if ($fieldValue == "") {
                    $retVal = "null";
                } else {
                    $retVal = "'" . $fieldValue . "'";
                }
                break;
            case "password":
                $retVal = "'" . md5($fieldValue) . "'";
                break;
            case "boolean":
                if ($fieldValue) {
                    $retVal = "True";
                } else {
                    $retVal = "False";
                }
                break;
            default:
                //				$retVal = "'" . str_replace("'", "''", htmlentities($fieldValue)) . "'";
                $retVal = $fieldValue;
        }
        return $retVal;
    }//formatForSql()

    /**
     * Returns a standard error div
     * @param text $errorMessage
     * @param int  $errorSeverity
     * @return hyml
     */
    function echoErrorMessage($errorMessage, $errorSeverity = 0)
    {
        $errorMessage = (string)$errorMessage;
        switch ($errorSeverity) {
            case "1":
                $class = "errorMessage1";
                break;
            case "2":
                $class = "errorMessage2";
                break;
            default:
                $class = "errorMessage";
                break;
        }
        $retVal = "<div class=$class>";
        $retVal .= $errorMessage;
        $retVal .= "</div>";
        return $retVal;
    }//echoErrorMessage()

    /**
     * Returns the name field of the passed $objectId
     * @param text $objectName
     * @param int  $objectId
     * @return text
     */
    //	function decodeObjectId($objectName, $objectId)
    //	{
    //		$retVal = "";
    //		$decodeObject = new $objectName($objectId);
    //		$sql = $decodeObject->getDecodeSelect();
    //		$result = dbQuery($sql);
    //		if ($result) {
    //			$arow = dbFetchArray($result);
    //			$retVal = $arow["Name"];
    //		}
    //		return $retVal;
    //	}//decodeObjectId()

    /**
     * Returns the passed array into a comme seperated list of column names to a sql select
     * @param array $columns
     * @return type
     */
    function columnList($columns)
    {
        $retVal = "";
        foreach ($columns as $col => $val) {
            $retVal .= $col . ", ";
        }
        $retVal = substr($retVal, 0, -2);
        return $retVal;
    }//columnList()

    /**
     * Returns an array of the columns that need to be included on the calling page
     * @param text $objectName
     * @param text $callingPage
     * @return array
     */
    //	function createColumnArray($objectName, $callingPage)
    //	{
    //		$retVal = array();
    //		$sql = "select aof.FieldName, aof.DisplayText, aof.MinLength, aof.MaxLength, aof.DataType,
    //                   aof.DiplayType, aof.IsMandatory, aof.Params, aof.OnOverview, aof.OnEdit, aof.ToolTip
    //            from ApplicationObjectField aof
    //            where aof.ObjectName = '$objectName' ";
    //		switch ($callingPage) {
    //			case "edit":
    //			case "new":
    //				$sql .= "and aof.OnEdit = 1 ";
    //				break;
    //			case "overview":
    //				$sql .= "and aof.OnOverview = 1 ";
    //				break;
    //		}
    //		$sql .= "order by aof.ColumnId";
    //		$result = dbQuery($sql);
    //		if ($result) {
    //			while ($arow = dbFetchArray($result)) {
    //				$retVal[$arow["FieldName"]] = array($arow["DisplayText"], $arow["MinLength"], $arow["MaxLength"], $arow["DataType"], $arow["DiplayType"],
    //					$arow["IsMandatory"], $arow["Params"], $arow["OnOverview"], $arow["OnEdit"], $arow["ToolTip"]);
    //			}
    //		}
    //
    //		return $retVal;
    //	}//createColumnArray()

    /**
     * Returns an array of the fileds needed on the edit page of the passed object
     * @param text $objectName
     * @return array
     */
    //	function getObjectEditFields($objectName)
    //	{
    //		$retArray = array();
    //		$sql = "select aof.FieldName, aof.DataType
    //            from ApplicationObjectField aof
    //            where aof.ObjectName = '$objectName'
    //            and aof.OnEdit = 1
    //            and aof.DiplayType <> 'key'
    //            order by aof.ColumnId
    //            ";
    //		$result = dbQuery($sql);
    //		if ($result) {
    //			while ($arow = dbFetchArray($result)) {
    //				$fieldName = $arow["FieldName"];
    //				$dataType = $arow["DataType"];
    //				$retArray[$fieldName] = $dataType;
    //			}
    //		} else {
    //
    //		}
    //		return $retArray;
    //	}//getObjectEditFields()

    /**
     * Format the passed $paramValue for use as a sql stored procedure based on $paramType
     * @param text $paramValue
     * @param text $paramType
     * @return text
     */
    function formatParameter($paramValue, $paramType)
    {
        switch ($paramType) {
            case "checkbox":
                if (($paramValue == "on") || ($paramValue == "1") || ($paramValue == 1)) {
                    $retVal = "1";
                } elseif ($paramValue == "0") {
                    $retVal = "0";
                } else {
                    $retVal = "null";
                }
                break;
            case "date":
            case "datetime":
            case "radio":
            case "text":
                if ($paramValue) {
                    $retVal = "'" . str_replace("'", "''", $paramValue) . "'";
                } else {
                    $retVal = "null";
                }
                break;
            case "double":
            case "decimal":
            case "int":
            case "key":
            case "money":
            case "select":
            case "time":
            case "dropdown":
                //Get around 0 being seen as false
                if ($paramValue == "0") {
                    $retVal = 0;
                } else {
                    if ($paramValue) {
                        $retVal = $paramValue;
                    } else {
                        $retVal = "null";
                    }
                }
                break;
            default:
                $retVal = "'" . str_replace("'", "''", $paramValue) . "'";
        }//switch

        return $retVal;
    }//formatParameter()

    /**
     * Returns the SecurityObjectName of the passed SecurityObjectId
     * @param int $securityObjectId
     * @return text
     */
    //	function getSecurityObjectNameById($securityObjectId)
    //	{
    //		$securityObjectName = "";
    //		$sql = "SELECT SecurityObjectName FROM SecurityObject WHERE SecurityObjectId = '" . $securityObjectId . "'";
    //		$result = dbQuery($sql);
    //		if ($result) {
    //			$arow = dbFetchArray($result);
    //			$securityObjectName = $arow["SecurityObjectName"];
    //		}
    //		return $securityObjectName;
    //	}//getSecurityObjectNameById()

    /**
     * Returns an array for drawInputField-dropdown to show a list of years from $yearsBefore to $yearsAfter
     * @param int $yearsAfter
     * @param int $yearsBefore
     * @return array
     */
    function getDropDownYearArray($yearsAfter = 2, $yearsBefore = 2)
    {
        $retVal    = array();
        $startYear = date("Y") - $yearsBefore;
        $endYear   = date("Y") + $yearsAfter;
        for ($i = $startYear; $i <= $endYear; $i++) {
            $retVal[$i] = $i;
        }
        return $retVal;
    }//getDropDownYearArray()

    /**
     * Generates an array of month number/name pairs
     * @return array
     */
    function getDropDownMonthArray()
    {
        $retVal = array();
        for ($i = 1; $i <= 12; $i++) {
            $retVal[$i] = date("F", mktime(0, 0, 0, $i, 10));
        }
        return $retVal;
    }//getDropDownMonthArray()

    /**
     * Returns an array for drawInputField-dropdown to show a list of months from $monthsBefore to $monthsAfter
     * @param int $monthsBefore
     * @param int $monthsAfter
     * @return array
     */
    function getDropDownYearMonthArray($monthsBefore = 12, $monthsAfter = 4)
    {
        $retVal          = array();
        $currentDateTime = mktime(0, 0, 0, date("m"), 1, date("Y"));
        $currentDate     = date("Y-m-d", $currentDateTime);
        $startDateTime   = strtotime($currentDate . " -" . $monthsBefore . " month");
        $startDate       = date("Y-m-d", $startDateTime);

        $totalMonths     = $monthsBefore + 1 + $monthsAfter;
        $currentDateTime = $startDateTime;
        $currentDate     = $startDate;
        for ($i = 0; $i < $totalMonths; $i++) {
            $dropdownValue          = substr($currentDate, 0, 7);
            $displayDate            = date("F", $currentDateTime);
            $retVal[$dropdownValue] = $dropdownValue . " " . $displayDate;
            $currentDateTime        = strtotime($currentDate . " +1 month");
            $currentDate            = date("Y-m-d", $currentDateTime);
        }
        return $retVal;
    }//getDropDownYearMonthArray()

    /**
     * Recursivly print out array values in a user friendly format
     * @param      array /text $toPrint
     * @param text $spacer
     * @return html
     */
    //	function printArrayRecurse($toPrint, $spacer)
    //	{
    //		$retVal = "";
    //		if (is_array($toPrint)) {
    //			$retVal .= "Array(" . count($toPrint) . ")";
    //			foreach ($toPrint as $col => $val) {
    //				$spaces = $spacer + 4;
    //				$retVal .= "<br />" . printSpaces($spaces, "&nbsp;") . " " . $col . " => " . printArrayRecurse($val, $spaces) . "";
    //			}
    //		} else {
    //			$retVal = $toPrint;
    //		}
    //		return $retVal;
    //	}//printArrayRecurse()

    /**
     * Print out an array in a user friendly format
     * @param         array /text $toPrint
     * @param boolean $echo
     * @return html
     */
    //	function printArray($toPrint, $echo = false)
    //	{
    //		$retVal = "";
    //		if (is_array($toPrint)) {
    //			foreach ($toPrint as $col => $val) {
    //				$retVal .= "<br />" . $col . " => " . printArrayRecurse($val, count($col));
    //			}
    //		} else {
    //			$retVal = $toPrint;
    //		}
    //		if ($echo) {
    //			echo "<br />" . $retVal;
    //		} else {
    //			return $retVal;
    //		}
    //	}//printArray()

    /**
     * This routine returns the php data type given the SQL data type.
     *
     * @author Robert Steyn
     * @param  String $sqlType
     * @return String $phpDataType
     */
    function getPhpDataType($sqlType)
    {
        switch ($sqlType) {
            case "bigint":
            case "int":
                $phpDataType = "Integer";
                break;
            case "varchar":
                $phpDataType = "String";
                break;
            case "bit":
                $phpDataType = "Boolean";
                break;
            case "datetime":
                $phpDataType = "datetime";
                break;
            default:
                $phpDataType = $sqlType;
                break;
        }
        return $phpDataType;
    }

    /**
     * @param $phoneNumber : Value to be evaluated
     * @return string :
     */
    function isValidPhoneNumber($phoneNumber)
    {
        $phoneNumber = str_replace("'", "", $phoneNumber);
        if (preg_match('/\(?\b[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}\b/', $phoneNumber)) {
            return '';
        }
        return 'Invalid phone number';
    }

    /**
     * @param $emailAddress : Value to be evaluated
     * @return string : Empty if valid, else Error message
     *
     * pharaoh@egyptian.museum - Invalid
     * john.doe+regexbuddy@gmail.com - Valid
     * O'Dell"@ireland.com - Invalid
     * john@aol...com - Invalid
     * president@whitehouse.gov - Valid
     */
    function isValidEmail($emailAddress)
    {
        $emailAddress = str_replace("'", "", $emailAddress);
        if (preg_match('/\b[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,4}\b/i', $emailAddress)) {
            return '';
        }
        return 'Invalid e-mail address';
    }

    /**
     * @param $coordinate : Value to be evaluated
     * @return string : Empty if valid, else Error message
     *
     * 12.345 - Invalid
     * 1,234.45 - Invalid
     * 1234567890 - Invalid
     * +12.34 - Invalid
     * 1234.4556 - valid
     */
    function isValidCoordinate($coordinate)
    {
        $coordinate = str_replace("'", "", $coordinate);
        if (preg_match('/^[-]?[0-9]*[.]{0,1}[0-9]{4}/', $coordinate)) {
            return '';
        }
        return 'Invalid coordinate';
    }

    /**
     * @param $number : String to be evaluated to contain only digits
     * @return string : Empty if valid else error message
     *
     * 1234.45 - Invalid
     * +12.34 - Invalid
     * 1234567890 - Valid
     */
    function isDigitOnly($number)
    {
        $number = str_replace("'", "", $number);
        if (preg_match('/^\d+$/', $number)) {
            return '';
        }
        return 'Invalid contents - Digits only';
    }

    /**
     * @param $array : The FieldParameters array
     * @param $fieldName : The lookup field name
     * @param $recordBase : The Record's Base Array that contains the meta data
     * @internal param $FieldName : The lookup field name
     */
    function initializeFieldParametersArray($fieldName, $recordBase)
    {
        $array     = array();
        $fieldMeta = $recordBase[$fieldName]['Meta'];
        for ($i = 0; $i < FieldParameters::arraySize; $i++) {
            $t = array_key_exists($i, $fieldMeta);
            if ($t) {
                $array[$i] = $fieldMeta[$i];
            } else {
                $array[$i] = null;
            }
        }
        return $array;
    }

    function sanitizeString($var)
    {
        $var = stripslashes($var);
        $var = htmlentities($var);
        $var = strip_tags($var);
        return $var;
    }

    //class FieldParameters extends \MabeEnum\Enum {
    //	const arraySize = 23; // NB NB - Keep this up to date if you add to this class
    //
    //	const width_par = 0;
    //	const maxlength_par = 1;
    //	const onKeyUp_par = 2;
    //	const onBlur_par = 3;
    //	const onDblClick_par = 4;
    //	const cols_par = 5;
    //	const rows_par = 6;
    //	const precision_par = 7;
    //	const class_par = 8;
    //	const groupIdName_par = 9;
    //	const onClick_par = 10;
    //	const autoRefresh_par = 11;
    //	const checked_par = 12;
    //	const isSelect2DropDown_par = 13;
    //	const dropDownValues_par = 14;
    //	const selected_par = 15;
    //	const radioOptions_par = 16;
    //	const onchange_par = 17;
    //	const value_par = 18;
    //	const disabled_par = 19;
    //	const required_par = 20;
    //	const placeholder_par = 22;
    //}

    abstract class FieldParameters
    {
        const arraySize = 24; // NB NB - Keep this up to date if you add to this class

        const width_par = 0;
        const maxlength_par = 1;
        const onKeyUp_par = 2;
        const onBlur_par = 3;
        const onDblClick_par = 4;
        const cols_par = 5;
        const rows_par = 6;
        const precision_par = 7;
        const class_par = 8;
        const groupIdName_par = 9;
        const onClick_par = 10;
        const autoRefresh_par = 11;
        const checked_par = 12;
        const isSelect2DropDown_par = 13;
        const dropDownValues_par = 14;
        const selected_par = 15;
        const radioOptions_par = 16;
        const onchange_par = 17;
        const value_par = 18;
        const disabled_par = 19;
        const required_par = 20;
        const placeholder_par = 22;
        const nullIfZero_par = 23;
    }

    /**
     * This function returns a recordBase array that was populated with the related values from the postArray
     *
     * @param $postArray : An array with key/value pairs - normally from $_POST
     * @param $recordBase : A Record class that relates to the postArray
     */
    function PopulateRecord($postArray, $recordBase)
    {
        foreach ($postArray as $key => $value) {
            if (array_key_exists($key, $recordBase)) {
                $recordBase[$key]['Value'] = formatForSql($value, $recordBase[$key]['Type']);
            }
        }
        return $recordBase;
    }

    function ValidateRecord(&$record)
    {
        $errorList = array();
        foreach ($record as $field) {
            //			if ($field == 'null') {
            //				break;
            //			}
            // Is field required?
            $required = false;
            if (isset($field['Meta'])) {
                $required = array_key_exists(FieldParameters::required_par, $field['Meta']);
            }
            if ($required) {
                if ($field['Value'] == null) {
                    array_push($errorList, $field['FriendlyName'] . " must have a value");
                }
            }
            if ($required || $field['Value'] != null) {
                if (!$required && str_replace("'", "", $field['Value']) == "") {
                    continue;
                }

                // Must field be checked for syntax errors?
                if (isset($field['CheckValidFormat'])) {
                    $syntaxCheck = $field['CheckValidFormat'];
                    if ($syntaxCheck) {
                        // Run the specified function for syntax checking
                        $result = call_user_func($syntaxCheck, $field['Value']);
                        if ($result != null) {
                            array_push($errorList, $result);
                        }
                    }
                }
            }
            if (!(isset($field['Value']) && isset($field['Type']) && isset($field['Meta']))) {
                continue;
            }
            $val                                  = formatForSql($field['Value'], $field['Type'], $field['Meta']);
            $record[$field['FieldName']]['Value'] = $val;
        }
        return $errorList;
    }

    /**
     * Returns the last error returned by sql_srv.
     *
     * @return text: Returns error and/or warning information about the last operation.
     */
    function dbGetErrorMsg()
    {
        $retVal = sqlsrv_errors();
        $retVal = $retVal[0]["message"];
        $retVal = preg_replace('/\[Microsoft]\[SQL Server Native Client [0-9]+.[0-9]+](\[SQL Server\])?/', '', $retVal);
        return $retVal;
    }//dbGetErrorMsg()

    function buildPostForDebug($post)
    {
        $string = '';
        foreach ($post as $key => $value) {
            $string .= $key . '=' . $value . '&';
        }
        return rtrim($string, "&");
    }
