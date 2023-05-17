<?php 
require "data.php";
function filterDraft($invoice){
    return  $invoice['status']==='draft';
}
$availableInvoices = array_filter($invoices,'filterDraft');
require "template.php";
?>
