<?php
require "data.php";

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $errors = [];
    $previousData = [];
    $valid = true;

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

    function getInvoiceNumber($length = 5){
        $letters = range('A','Z');
        $number = [];
    
        for($i=0; $i< $length; $i++){
            array_push($number,$letters[rand(0,count($letters) -1)]);
        }
        return implode($number);
    }

    if($valid){
        $_SESSION['newInvoice']=[
            'number' => getInvoiceNumber(),
            'amount' => $amount,
            'status' => $status,
            'client' => $client,
            'email'  => $email
        ];

        header("Location: index.php"); 
    }else{
        $previousData['amount'] = $amount;
        $previousData['status'] = $status;
        $previousData['client'] = $client;
        $previousData['email'] = $email;
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
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h1>Invoice Manager</h1>
        <div class="d-flex flex-row justify-content-between mb-3">
            <p>Create a new invoice.</p>
            <a href="index.php">< Back</a>
        </div>
        <div class="form">
        <form method="post">
            <div class="mb-3">
                <label for="clientName" class="form-label fw-bold text-primary">Client Name</label>
                <input type="text" class="form-control" name="clientName" placeholder="Your Name" value="<?php echo isset($previousData['client'])? $previousData['client'] :"" ?>" required>
                <?php if(isset($errors['name_error'])):?>
                <div class="alert alert-primary mt-3" role="alert"><?php echo $errors['name_error'];?></div>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="clientEmail" class="form-label fw-bold text-primary">Client Email</label>
                <input type="email" class="form-control" name="clientEmail" placeholder="name@example.com" value="<?php echo isset($previousData['email'])? $previousData['email'] :"" ?>" required>
                <?php if(isset($errors['email_error'])):?>
                <div class="alert alert-primary mt-3" role="alert"><?php echo $errors['email_error'];?></div>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label fw-bold text-primary">Invoice Amount</label>
                <input type="number" class="form-control" name="amount" placeholder="Amount" value="<?php echo isset($previousData['amount'])? $previousData['amount'] :"" ?>" required >
                <?php if(isset($errors['amount_error'])):?>
                <div class="alert alert-primary mt-3" role="alert"><?php echo $errors['amount_error'];?></div>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label fw-bold text-primary">Invoice Status</label>
                <select class="form-select" name="status" required>
                    <option value="">Select a Status</option>
                    <?php for($i = 1;$i < count($statuses); $i++) : ?>
                    <option value="<?php echo $statuses[$i]; ?>" 
                    <?php if($statuses[$i] === (isset($previousData['status']) ? $previousData['status'] : "")): ?>
                        selected
                    <?php endif; ?>
                    >
                    <?php echo $statuses[$i]; ?>
                    </option>
                    <?php endfor; ?>
                </select>
                <?php if(isset($errors['status_error'])):?>
                <div class="alert alert-primary mt-3" role="alert"><?php echo $errors['status_error'];?></div>
                <?php endif ?>
            </div>
            <div class="text-center">
            <button type="submit" class="btn btn-outline-primary">Submit</button>
            </div>
        </form>
        </div>
    </div>
</body>
</html>