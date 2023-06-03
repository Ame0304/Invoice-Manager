<?php 
    require "data.php"; 
    if(isset($_GET['number'])){
        $invoice = current(array_filter($invoices,function($invoice){
            return  $invoice['number']==$_GET['number'];
        }));
        if (!$invoice) {
            // go back to index.php
            header("Location: index.php");}
    }
    
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $valid = true;

        // validate client name
        $client = $_POST['client_name'];
        if(!preg_match('/^[a-zA-Z\s]+$/',$client)){
            $nameError = 'Client name must contain letters and spaces only';
            $valid = false;
        }
        else if(strlen($client)>255){
            $nameError = 'Client name cannot be more than 255 characters.';
            $valid = false;
        }
        
        // validate client email
        $email = $_POST['client_email'];
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $emailError = 'A valid email address must be provided.';
            $valid = false;
        }
        
        // validate invoice status
        $status = $_POST['invoice_status'];
        if($status != 'draft' && $status != 'pending' && $status != 'paid'){
            $statusError = 'The status must be either draft, pending or paid.';
            $valid = false;
        }

        if($valid){
        $newInvoice = [
            'number' => $_POST['invoice_number'],
            'amount' => $_POST['invoice_amount'],
            'status' => $status,
            'client' => $client,
            'email'  => $email,
        ];

        $invoices = array_map(function($invoice) use ($newInvoice){
            if($invoice['number'] == $newInvoice['number']){
              return $newInvoice;
            }
            return $invoice;
          }, $invoices);

        $_SESSION['invoices'] = $invoices;
        header("Location: index.php");}
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
    .container{
        display: grid;
    }
    .form{
        justify-self: center;
        display: grid;
        grid-gap: 1rem;
        align-content: center;
        width: 100%;
        max-width: 600px;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        padding: 20px;
    }
    .button{
        justify-self: center;
    }
</style>
</head>
<body>
    <div class="container">
    <h1 >Invoice Manager</h1>
    <p>Update this invoice.</p>
    <div class="form mt-5">
        <form method="post">
            <input type="hidden" name="invoice_number" value="<?php echo $invoice['number'] ?>" />
            <input type="hidden" name="invoice_amount" value="<?php echo $invoice['amount'] ?>" />
            <div class="mb-3">
                <label for="client_name" class="form-label fw-bold text-primary">Client Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="client_name" 
                    placeholder="Client Name" 
                    required 
                    value="<?php echo ($invoice['client']); ?>">
                    <?php if(isset($nameError)):?>
                    <div class="alert alert-primary mt-3" role="alert"><?php echo $nameError;?></div>
                    <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="client_email" class="form-label fw-bold text-primary">Client Email</label>
                <input 
                    type="text" 
                    class="form-control" 
                    name="client_email" 
                    placeholder="Client Email" 
                    required 
                    value="<?php echo ($invoice['email']); ?>">
                    <?php if(isset($emailError)):?>
                    <div class="alert alert-primary mt-3" role="alert"><?php echo $emailError;?></div>
                    <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="invoice_status" class="form-label fw-bold text-primary">Invoice Status</label>
                <select class="form-select" name="invoice_status" required>
                    <option value="">Select a status</option>
                    <?php for($i = 1;$i<count($statuses);$i++) : ?>
                    <option value="<?php echo $statuses[$i]; ?>"
                    <?php if($statuses[$i] === $invoice['status']): ?>selected<?php endif; ?>
                    >
                    <?php echo $statuses[$i]; ?>
                    </option>
                    <?php endfor; ?>
                    </select>
                    <?php if(isset($statusError)):?>
                    <div class="alert alert-primary mt-3" role="alert"><?php echo $statusError;?></div>
                    <?php endif ?>
            </div>
            <div class="container text-center">
            <button type="submit" class="button btn btn-outline-primary">Update</button>
            </div>
        </form>
    </div>
    </div>
</body>

</html>