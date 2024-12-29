<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'contact.php';

    //  Delet
    if(isset($_GET['delete'])) {
        $contact = new Contact( $_GET['delete']);
        $contact->delete();
        header('Location: index.php');
    }

    //  Updat
    if(isset($_POST['update'])) {
        $contact = new Contact(
            $_POST['id'], 
            $_POST['lastname'],
            $_POST['firstname'], 
            $_POST['email'], 
            $_POST['phone']
        );
        $contact->update();
        header('Location: index.php');
    }

    //  Add
    if(isset($_POST['add'])) {
        $contact = new Contact(
            null,
            $_POST['lastname'],
            $_POST['firstname'],
            $_POST['email'],
            $_POST['phone']
        );
        $contact->save();
        header('Location: index.php');
    }

    // Get countact
    $editContact = null;
    if(isset($_GET['edit'])) {
        $editContact = Contact::getById($_GET['edit']);
    }
    ?>

    <div class="container mt-4">
        <form method="POST">
            <?php if($editContact): ?>
                <h2>Edit Contact</h2>
                <input type="hidden" name="id" value="<?= $editContact['id'] ?>">
            <?php else: ?>
                <h2>Add Contact</h2>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-3"><input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?= $editContact['firstname'] ?? '' ?>"></div>
                <div class="col-md-3"><input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?= $editContact['lastname'] ?? '' ?>"></div>
                <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="Email" value="<?= $editContact['email'] ?? '' ?>"></div>
                <div class="col-md-2"><input type="tel" name="phone" class="form-control" placeholder="Phone" value="<?= $editContact['phone'] ?? '' ?>"></div>
                <div class="col-md-1">
                    <?php if($editContact): ?>
                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                    <?php else: ?>
                        <button type="submit" name="add" class="btn btn-primary">Add</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <input type="search" class="form-control w-25 my-4" placeholder="Search...">

        <div class="contacts-list">
            <?php
            $contacts = Contact::getAll();
            foreach($contacts as $contact): ?>
                <div class="card mb-2">
                    <div class="card-body">
                        <h5><?= $contact['firstname'] . ' ' . $contact['lastname'] ?></h5>
                        <p>Email: <?= $contact['email'] ?> | Phone: <?= $contact['phone'] ?></p>
                        <a href="?edit=<?= $contact['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?delete=<?= $contact['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>