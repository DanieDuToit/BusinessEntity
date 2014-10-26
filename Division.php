<?php
	/**
	 * Created by PhpStorm.
	 * User: Danie
	 * Date: 2014/10/21
	 * Time: 09:30 PM
	 */

	if (isset($_POST['Return'])) {
		header("Location: DivisionDisplayGrid.php");
	}
	global $record;
	global $action;
	global $businessEntityRecords;
	global $parentName;
	global $selectList;

	include "Header.inc.php";

	$action = '';
    $recordBase = BaseBusinessEntity::$BusinessEntity;
	$dbBaseClass = new BaseDB();
    // Get the BusinessEntity records
    $businessEntityRecords = $dbBaseClass->getFieldsForAll("BusinessEntity", array('Id', 'Name'), "WHERE BusinessLevelId = 1");

    $selectList = '';

	if (!isset($_POST['Create'])) {
		if (isset($_GET['id']) === false || isset($_GET['action']) === false) {
			header("Location: DivisionDisplayGrid.php");
		}
		$id = (int)$_GET['id'];
		$action = $_GET['action'];
		sanitizeString($id);
		$prep = $dbBaseClass->getFieldsForAll("BusinessEntity", array('BusinessEntityParentId'), "WHERE id = $id");
		$rec = sqlsrv_fetch_array($prep, SQLSRV_FETCH_ASSOC);
        $businessEntityParentId = $rec['BusinessEntityParentId'];
		$prep = $dbBaseClass->getFieldsForAll("BusinessEntity", array('Name'), "WHERE id = {$rec['BusinessEntityParentId']}");
		if ($prep == false) {
			echo '<script language="JavaScript">';
			echo 'alert("This division does not have a related company.")';
			echo '</script>';
//			header("Location: DivisionDisplayGrid.php");
		}
		$rec = sqlsrv_fetch_array($prep, SQLSRV_FETCH_ASSOC);
		$parentName = $rec['Name'];
        while ($businessEntity = sqlsrv_fetch_array($businessEntityRecords, SQLSRV_FETCH_ASSOC)) {
            if ($businessEntity['Id'] == $businessEntityParentId) {
                $selectList .= "<option selected=\"selected\" value='{$businessEntity['Id']}'>{$businessEntity['Name']}</option>";
            } else {
                $selectList .= "<option value='{$businessEntity['Id']}'>{$businessEntity['Name']}</option>";
            }
        }
	} else {
		while ($businessEntity = sqlsrv_fetch_array($businessEntityRecords, SQLSRV_FETCH_ASSOC)) {
			$selectList .= "<option value='{$businessEntity['Id']}'>{$businessEntity['Name']}</option>";
		}
		$action = 'c';
		$id = -1;
	}
	sanitizeString($action);

	// Set up DB connection
	$dbBaseClass = new BaseDB();
	if (Database::getConnection() === false) {
		die("ERROR: Could not connect. " . printf('%s', dbGetErrorMsg()));
	}

	// An existing record is expected when the action is not "Create"
	if ($action != 'c') {
		// Read the record
		$records = $dbBaseClass->getAllByFieldName('BusinessEntity', 'id', $id);

		if ($records === false) {
			die(dbGetErrorMsg());
		}

		// Get the specific record
		$record = sqlsrv_fetch_array($records, SQLSRV_FETCH_ASSOC);
		$businessLevelId = $record['BusinessLevelId']['Value'];
	}
	$recordBase = BaseBusinessEntity::$BusinessEntity;

	function echoField($fieldIdName, $hidden = false)
	{
		global $action;
		global $record;
		global $recordBase;
		$fieldParams = initializeFieldParametersArray($fieldIdName, $recordBase);
		if ($action == 'r' || $action == 'd') {
			$fieldParams[FieldParameters::disabled_par] = 'Disabled';
		}
    if ($hidden) {
        echo "<input type=\"hidden\" value=\"$record[$fieldIdName]\" id=\"$fieldIdName\"  name=\"$fieldIdName\">";
    } else {
        $inputField = (string)drawInputField($fieldIdName, $recordBase[$fieldIdName]['Type'], $record[$fieldIdName],
            $fieldParams, $recordBase[$fieldIdName]['FriendlyName'], $recordBase[$fieldIdName]['Helptext']);
        $str = (string)$recordBase[$fieldIdName]['FriendlyName'];
        if ($str == "") $str = $fieldIdName;
        echo "<td class=\"fieldName\"><b>$str</ b></td>";
        echo("<td>$inputField</td>");
    }
	}

?>
<body>
<?php
	if ($action == 'c') {
		$val = 'Insert';
	} elseif ($action == 'u') {
		$val = 'Update';
	} elseif ($action == 'd') {
		$val = 'Remove';
	} else {
		$val = 'Display';
	}
	echo sprintf('<div class="heading"><h2>%s a Division</h2></div>', $val);
?>
<form action="DivisionAction.php" method="post">
	<input type="hidden" value="<?php echo $id ?>" id="id" name="id">
	<table width="200" border="0" cellspacing="2px" cellpadding="2px">
		<tbody>
		<tr>
			<?php echoField("Name") ?>
		</tr>
		<tr>
			<?php echoField("BusinessEntityCode", true) ?>
		</tr>
		<tr>
			<?php echoField("BusinessEntityDescription") ?>
		</tr>
		<tr>
			<?php echoField("Active") ?>
		</tr>
		<tr>
			<?php echoField("BusinessEntityShortName") ?>
		</tr>
		<tr>
			<td class=\"fieldName\"><b>Companies</b></td>
			<?php if ($action == 'r' || $action == 'd') echo "<td>$parentName</td>";
			else {
				echo "<td>";
				echo "<label for='BusinessEntityParentId'></label><select id='BusinessEntityParentId' name='BusinessEntityParentId'>
					<option selected='selected' value=''></option>";
				echo $selectList;
				echo "</select>";
				echo "<td>";
			}
			?>
		</tr>
		</tbody>
	</table>
	<div>
		<?php
			if ($action == 'c') {
				echo (string)drawSubmitButton("Create", "Create");
			}
			if ($action == 'u') {
				echo (string)drawSubmitButton("Update", "Update");
			}
			if ($action == 'd') {
				echo (string)drawSubmitButton("Delete", "Delete");
			}
		?>
		<form action="Division.php" method="post">
			<?php
				echo (string)(drawSubmitButton("Return", "Return"));
			?>
		</form>
	</div>
</form>
<script src="JavaScripts/jquery-2.0.2.js"