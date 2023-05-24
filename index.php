<?php 
require "data.php";

function getInvoiceNumber($length = 5){
    $letters = range('A','Z');
    $number = [];

    for($i=0; $i< $length; $i++){
        array_push($number,$letters[rand(0,count($letters) -1)]);
    }
    return implode($number);
}

// add a new invoice
if(isset($_POST['status'])){
    array_push($invoices,
    ['number' => getInvoiceNumber(),
    'amount' => $_POST['amount'],
    'status' => $_POST['status'],
    'client' => $_POST['clientName'],
    'email'  => $_POST['clientEmail']]
);
}

// update invoices
$_SESSION['invoices'] = $invoices;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<style>
    .table tbody tr{
        padding: 10px 0 ;
    }
    .pending{
        background-color:#b3ecb36b;
        border-radius: 6px;
    }
    .paid{
        background-color:#fff7aa94;
        border-radius: 6px;
    }
    .draft{
        background-color:#d3d3d3b5;
        border-radius: 6px;
    }
    a{
        text-decoration: none;
    }
</style>
</head>
<body>
    <div class="container">
    <h1>Invoice Manager</h1>
    <?php require 'result.php' ?>
</div>
</body>

</html>