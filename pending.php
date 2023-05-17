<?php 
require "data.php";
function filterPending($invoice){
    return  $invoice['status']==='pending';
}
$availableInvoices = array_filter($invoices,'filterPending');
require "template.php";
?>
