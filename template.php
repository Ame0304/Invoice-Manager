
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
</head>
<body class="bg-dark">
    <ul class="nav bg-dark mb-3">
        <li class="nav-item">
            <a class="nav-link text-light fw-bold" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light fw-bold" href="draft.php">Draft</a>
        </li>
        <li class="nav-item">
         <a class="nav-link text-light fw-bold" href="pending.php">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light fw-bold" href="paid.php">Paid</a>
        </li>
    </ul>
    <table class="table table-dark table-hover table-borderless">
        <thead>
            <tr><th>Number</th><th>Amount</th><th>Status</th><th>Client</th><th>Email</th></tr>
        </thead>
        <tbody>
            <?php foreach ($availableInvoices as $invoice) : ?>
                <tr>
                    <td><?php echo $invoice['number'];?></td>
                    <td><?php echo $invoice['amount'];?></td>
                    <td><?php echo $invoice['status'];?></td>
                    <td><?php echo $invoice['client'];?></td>
                    <td><?php echo $invoice['email'];?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>