
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Manager</title>
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
        <form method="post" action="index.php">
            <div class="mb-3">
                <label for="clientName" class="form-label">Client Name</label>
                <input type="text" class="form-control" name="clientName" placeholder="Your Name">
            </div>
            <div class="mb-3">
                <label for="clientEmail" class="form-label">Client Email</label>
                <input type="email" class="form-control" name="clientEmail" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Invoice Amount</label>
                <input type="number" class="form-control" name="amount" placeholder="Amount">
            </div>
            <div class="mb-3">
            <label for="status" class="form-label">Invoice Status</label>
            <select class="form-select" name="status">
                <option selected value="">Select a Status</option>
                <option value="draft">Draft</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
            </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>