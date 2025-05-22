<?php
    function check($id)
    {
        return in_array($id, $_SESSION['permissions']);
    }
?>