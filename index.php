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

if (isset($_POST['status'])) {
    $errors = [];
    $valid = true; // Add a variable to track overall validity

    // validate invoice amount
    $amount = $_POST['amount'];
    if (!filter_var($amount, FILTER_VALIDATE_INT)) {
        $errors['amount_error'] = "Amount must be an integer";
        $valid = false;
    }

    // validate client name
    $client = $_POST['clientName'];
    if (!preg_match('/^[a-zA-Z\s]+$/', $client)) {
        $errors['name_error'] = 'Client name must contain letters and spaces only';
        $valid = false;
    } else if (strlen($client) > 255) {
        $errors['name_error'] = 'Client name cannot be more than 255 characters.';
        $valid = false;
    }

    // validate client email
    $email = $_POST['clientEmail'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email_error'] = 'A valid email address must be provided.';
        $valid = false;
    }

    // validate invoice status
    $status = $_POST['status'];
    if ($status != 'draft' && $status != 'pending' && $status != 'paid') {
        $errors['status_error'] = 'The status must be either draft, pending, or paid.';
        $valid = false;
    }

    if ($valid) { 
        unset($_SESSION['previousData']);
        // add a new invoice
        array_push($invoices, [
            'number' => getInvoiceNumber(),
            'amount' => $amount,
            'status' => $status,
            'client' => $client,
            'email'  => $email
        ]);

        // update invoices
        $_SESSION['invoices'] = $invoices;
        
        header("Location: index.php"); 
        exit;
    } else {
        $errorString = http_build_query($errors);
        // $previousData = [           
        // 'amount' => $amount,
        // 'status' => $status,
        // 'client' => $client,
        // 'email'  => $email];
        
        // $_SESSION['previousData'] = $previousData;
        header("Location: add.php?" . $errorString);
        exit;
    }
}
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
    .btn-status{
        background-color: transparent;
        border-radius: 5px;
        width: 70%;
    }

    .pending{
        color:#ffc384;
        border-color: #ffc384;
    }

    .pending:hover{
        background-color:#ffc384;
        color:white;
    }

    .paid{
        
        color: #93f093;
        border-color: #93f093;
    }

    .paid:hover{
        background-color:#93f093;
        color:white;
    }

    .draft{
        
        color: grey;
        border-color: grey;
        
    }

    .draft:hover{
        background-color:grey;
        color:white;
    }

    a{
        text-decoration: none;
    }

    tr{
        line-height: 35px;
    }

    th,td{
        text-align: center;
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