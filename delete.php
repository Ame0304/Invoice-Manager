<?php
    require "data.php";
    if(isset($_POST['invoice_number'])){
        $index = array_key_first(array_filter($invoices,function($invoice){
            return $invoice['number'] == $_POST['invoice_number'];
        }));

        unset($_SESSION['invoices'][$index]);
    }

    header("Location: index.php");
?>