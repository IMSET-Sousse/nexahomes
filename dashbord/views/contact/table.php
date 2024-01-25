<?php
require_once('scripts/contactManager.php');

$contactManager = new ContactManager($conn);
$contacts = $contactManager->getContacts();
$contactCount = count($contacts);
?>

<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-4">Contacts List</h3>
    </div>
    <div class="col-sm-6 text-end">
        <p>Total Contacts: <?= $contactCount; ?></p>
    </div>
</div>

<div class="table-responsive-sm">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Message</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Created At</th>
                <th colspan="3" class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($contacts)) {
                $sn = 1;
                foreach ($contacts as $contact) {
            ?>
                    <tr>
                        <td><?= $sn; ?></td>
                        <td><?= $contact['message']; ?></td>
                        <td><?= $contact['email']; ?></td>
                        <td><?= $contact['phoneNumber']; ?></td>
                        <td><?= $contact['created_at']; ?></td>

                        <td class="text-center">
                            <a href="dashboard.php?page=contact-info&id=<?= $contact['id']; ?>" class="text-success">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>

                    </tr>
            <?php
                    $sn++;
                }
            } else {
            ?>
                <tr>
                    <td colspan="6">No contacts found</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
