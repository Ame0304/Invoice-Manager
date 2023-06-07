<?php 

function sanitize($data) {
    return array_map(function ($value) {
      return htmlspecialchars(stripslashes(trim($value)));
    }, $data);
}

function validate($invoice){
    $errors = [];
    $fields = ['client','amount','email','status'];
    global $statuses;

    foreach($fields as $field){
        switch($field){
            case 'client':
                if(empty($invoice[$field])){
                    $errors[$field] = 'Client name is required.';
                }
                else if (!preg_match('/^[a-zA-Z\s]+$/', $invoice[$field])) {
                    $errors[$field] = 'Client name must contain letters and spaces only.';      
                    
                } else if (strlen($invoice[$field]) > 255) {
                    $errors[$field] = 'Client name cannot be more than 255 characters.';      
                    
                }
                break;
            case 'amount':
                if(empty($invoice[$field])){
                    $errors[$field] = "Amount is required.";
                }
                else if (!filter_var($invoice[$field], FILTER_VALIDATE_INT)) {
                    $errors[$field] = "Amount must be an integer.";
                }
                break;
            case 'email':
                if(empty($invoice[$field])){
                    $errors[$field] = "Email is required.";
                }
                else if (!filter_var($invoice[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = 'A valid email address must be provided.';
                }
                break;
            case 'status':
                if(empty($invoice[$field])){
                    $errors[$field] = 'Status is required.';
                }
                else if ($invoice[$field] != 'draft' && $invoice[$field] != 'pending' && $invoice[$field] != 'paid') {
                    $errors[$field] = 'The status must be either draft, pending, or paid.';
                }
        }
    }

    return $errors;
}

function getInvoiceNumber($length = 5){
    $letters = range('A','Z');
    $number = [];

    for($i=0; $i< $length; $i++){
        array_push($number,$letters[rand(0,count($letters) -1)]);
    }
    return implode($number);
}

function getAllInvoices(){
    global $db;
    $sql = "SELECT number,client,email,amount,status FROM invoices
    JOIN statuses ON invoices.status_id = statuses.id";
    $result = $db->query($sql);
    $invoices = $result->fetchAll();

    return $invoices;
}

function getInvoices($status){
    global $db;
    $sql = "SELECT number,client,email,amount,status FROM invoices
            JOIN statuses ON invoices.status_id = statuses.id
            WHERE status = :status";
    $result = $db->prepare($sql);
    $result->execute([':status' => $status]);
    $invoices = $result->fetchAll();

    return $invoices;

}

function getInvoice($number){
    global $db;
    $sql = "SELECT number,client,email,amount,status FROM invoices
            JOIN statuses ON invoices.status_id = statuses.id
            WHERE number = :number";
    $result = $db->prepare($sql);
    $result->execute([':number' => $number]);
    $invoice = $result->fetch();

    return $invoice;
}

function addInvoice($invoice){
    global $db, $statuses;

    $status_id = array_search($invoice['status'],$statuses) +1 ;

    $sql = "INSERT INTO invoices (number, amount, status_id, client, email)
            VALUES(:number, :amount, :status_id, :client, :email)";
    $result = $db->prepare($sql);
    $result->execute([':number' => getInvoiceNumber(),
                      ':amount' => $invoice['amount'],
                      ':status_id' => $status_id,
                      ':client' => $invoice['client'],
                      ':email' => $invoice['email']]);
}

function updateInvoice($invoice){
    global $db, $statuses;
    $status_id = array_search($invoice['status'],$statuses) +1 ;
    $sql = "UPDATE invoices
            SET client = :client, email = :email, status_id = :status_id
            WHERE number = :number";
    $result = $db->prepare($sql);
    $result->execute([':number' => $invoice['number'],
                    ':client' => $invoice['client'],
                    ':email' => $invoice['email'],
                    ':status_id' => $status_id]);
}

function deleteInvoice($number){
    global $db;
    $sql = "DELETE FROM invoices
            WHERE number = :number";
    $result = $db->prepare($sql);
    $result->execute([':number' => $number]);
}

?>