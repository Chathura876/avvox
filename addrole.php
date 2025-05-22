<?php require_once "common/header.php" ?>
<?php
$permissions = array("admin");

if (!(in_array($_SESSION['usertype'], $permissions))) {
    header("Location: index.php");
}

?>
<?php require_once "common/nav.php" ?>

<?php

if (isset($_GET["role_id"])) {
    $roleId = $_GET["role_id"];
    $titlestring = "Manage Permissions";

    $query = "SELECT *
    from roles_permissions rp
        inner join roles r on rp.role_id = r.role_id
        inner join permissions p on rp.perm_id = p.perm_id group by rp.role_id";

    if ($result = $mysqli->query($query)) {
        $order = $result->fetch_object();
    }

?>

    <form method="post" id="udaraform" action="process/addpermission.inc.php">

        <input type='hidden' id='role_id' name='role_id' value='<?php echo $_GET["role_id"] ?>' />

        <div class="row">
            <div class="col-12">
                <h5><?php echo $titlestring ?></h5>
            </div>
        </div>

        <div class="form-group col-md-8 col-12">
            <?php

            $query = "SELECT *
                from permissions";

            $queryNew = "SELECT DISTINCT perm_type FROM permissions";
            $resultNew = $mysqli->query($queryNew);
            if ($result = $mysqli->query($query)) {
                $query1 = "SELECT * FROM roles_permissions WHERE role_id =$roleId";
                $result1 = $mysqli->query($query1);
            ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Permission Type</th>
                            <th>Permission Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>
                                <input type="checkbox" name="select-all" id="select-all" /> Select All<br />
                            </td>
                        </tr>
                        <?php while ($permissionType = $resultNew->fetch_object()) {
                            $item = $permissionType->perm_type;
                        ?>
                            <tr>
                                <td><label> &nbsp;<?php echo "$item"; ?></label>&nbsp;<input type="checkbox" id='<?php echo "$item"; ?>' /><br /></td>
                                <td>
                                    <table class="table">
                                        <?php
                                        $query2 = "SELECT * from permissions WHERE perm_type='$item'";
                                        $result2 = $mysqli->query($query2);
                                        while ($permission = $result2->fetch_object()) {
                                            $checked = '';
                                            $perm = $result1->fetch_object();
                                        ?>
                                            <tr>
                                                <td><input type='checkbox' class='<?php echo $item; ?>' id='perm_id' name='perm_id[]' value='<?php echo $permission->perm_id; ?>' <?php echo ($perm->perm_id == $permission->perm_id) ? 'checked' : ''; ?> /></td>
                                                <td><label><?php echo "$permission->perm_desc"; ?></label></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>


                            </tr>


                            <!-- //echo "<option value='$permission->id'>$permission->perm_desc</option>"; -->
                    <?php

                        }
                    }
                    ?>
                    </tbody>
                </table>

                <button class="btn btn-primary" id="submit" name="submit" type="submit">Save</button>
    </form>
    </div>


<?php } ?>

<script>
    // Listen for click on toggle checkbox
    $('#select-all').click(function(event) {
        if (this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function() {
                this.checked = false;
            });
        }
    });


    $.fn.checkboxMaster = function(list) {

        return this.on('click', function() {
            $(list).prop('checked', $(this).prop('checked'));
        });

    }

    $('#Orders').checkboxMaster('input[class=Orders]');
    $('#Job').checkboxMaster('input[class=Job]');
    $('#Reports').checkboxMaster('input[class=Reports]');
    $('#Products').checkboxMaster('input[class=Products]');
    $('#People').checkboxMaster('input[class=People]');
    $('#Details').checkboxMaster('input[class=Details]');
</script>