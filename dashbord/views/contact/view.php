<?php
require_once('scripts/contactManager.php');

$contactManager = new ContactManager($conn);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $contact = $contactManager->getContactById($id);
}

?>

<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-4">View Contact</h3>
    </div>
    <div class="col-sm-6 text-end">
        <a href="dashboard.php?page=contact-list" class="btn btn-success">Contacts List</a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <h1><?= isset($contact['message']) ? $contact['message'] : ''; ?></h1>
        <p><b>Email: </b><?= isset($contact['email']) ? $contact['email'] : ''; ?></p>
        <p><b>Phone Number: </b><?= isset($contact['phoneNumber']) ? $contact['phoneNumber'] : ''; ?></p>
        <p><b>Created At: </b><?= isset($contact['created_at']) ? $contact['created_at'] : ''; ?></p>
    </div>
</div>
