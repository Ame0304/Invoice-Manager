<?php
require "data.php";
require "functions.php";

$invoice = [];

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $invoice = sanitize($_POST);
    $errors = validate($invoice);

    if(count($errors) === 0){
        addInvoice($invoice);
        header("Location: index.php"); 
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
                <input type="text" class="form-control" name="client" placeholder="Your Name" value="<?php echo $invoice['client'] ?? ''; ?>" required>
                <?php if(isset($errors['client'])):?>
                <div class="alert alert-primary mt-3" role="alert"><?php echo $errors['client'];?></div>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="clientEmail" class="form-label fw-bold text-primary">Client Email</label>
                <input type="email" class="form-control" name="email" placeholder="name@example.com" value="<?php echo $invoice['email'] ?? ''; ?>" required>
                <?php if(isset($errors['email'])):?>
                <div class="alert alert-primary mt-3" role="alert"><?php echo $errors['email'];?></div>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label fw-bold text-primary">Invoice Amount</label>
                <input type="number" class="form-control" name="amount" placeholder="Amount" value="<?php echo $invoice['amount'] ?? ''; ?>" required >
                <?php if(isset($errors['amount'])):?>
                <div class="alert alert-primary mt-3" role="alert"><?php echo $errors['amount'];?></div>
                <?php endif ?>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label fw-bold text-primary">Invoice Status</label>
                <select class="form-select" name="status" required>
                    <option value="">Select a Status</option>
                    <?php for($i = 0;$i < count($statuses); $i++) : ?>
                    <option value="<?php echo $statuses[$i]; ?>" 
                    <?php if(isset($invoice['status']) && $statuses[$i] === $invoice['status']): ?>
                        selected
                    <?php endif; ?>
                    >
                    <?php echo $statuses[$i]; ?>
                    </option>
                    <?php endfor; ?>
                </select>
                <?php if(isset($errors['status'])):?>
                <div class="alert alert-primary mt-3" role="alert"><?php echo $errors['status'];?></div>
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