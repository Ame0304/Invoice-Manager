<?php 
require "data.php";
function filterPaid($invoice){
    return  $invoice['status']==='paid';
}
$availableInvoices = array_filter($invoices,'filterPaid');
require "template.php";
?>
