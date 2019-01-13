<?php include_once '_header.php'; ?>
<?php if ($createdUser): ?>
    <div class="alert alert-success mt-3" role="alert">
        User successful created.
    </div>
<?php endif; ?>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">
                <a href="/user/sort=<?= $sortParams['sortLogin'] ?>/page=<?= $page ?>">
                    Login
                    <?php if ($sort == 'login'): ?>
                        <i class="fa fa-arrow-up"></i>
                    <?php endif; ?>
                    <?php if ($sort == '-login'): ?>
                        <i class="fa fa-arrow-down"></i>
                    <?php endif; ?>
                </a>
            </th>
            <th scope="col">
                <a href="/user/sort=<?= $sortParams['sortDateOfBirth'] ?>/page=<?= $page ?>">
                    Date of birth
                    <?php if ($sort == 'date_of_birth'): ?>
                        <i class="fa fa-arrow-up"></i>
                    <?php endif; ?>
                    <?php if ($sort == '-date_of_birth'): ?>
                        <i class="fa fa-arrow-down"></i>
                    <?php endif; ?>
                </a>
            </th>
            <th scope="col">
                <a href="/user/sort=<?= $sortParams['sortUpdatedAt'] ?>/page=<?= $page ?>">
                    Updated
                    <?php if ($sort == 'updated_at'): ?>
                        <i class="fa fa-arrow-up"></i>
                    <?php endif; ?>
                    <?php if ($sort == '-updated_at'): ?>
                        <i class="fa fa-arrow-down"></i>
                    <?php endif; ?>
                </a>
            </th>
            <th scope="col">
                <a href="/user/sort=<?= $sortParams['sortCreatedAt'] ?>/page=<?= $page ?>">
                    Created
                    <?php if ($sort == 'created_at'): ?>
                        <i class="fa fa-arrow-up"></i>
                    <?php endif; ?>
                    <?php if ($sort == '-created_at'): ?>
                        <i class="fa fa-arrow-down"></i>
                    <?php endif; ?>
                </a>
            </th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userList as $key => $user): ?>
            <tr>
                <th scope="row"><?= $key + $offset + 1 ?></th>
                <td><?= $user['login'] ?></td>
                <td><?= $user['date_of_birth'] ?></td>
                <td><?= $user['updated_at'] ?></td>
                <td><?= $user['created_at'] ?></td>
                <td>
                    <a href="/user/<?= $user['id'] ?>"><i class="fa fa-eye" style="color:black;" aria-hidden="true"></i></a>
                    <a href="/user/update/<?= $user['id'] ?>"><i class="fa fa-pencil" style="color:black;" aria-hidden="true"></i></a>
                    <a href="/user/delete/<?= $user['id'] ?>" class="delete-user"><i class="fa fa-trash" style="color:black;" aria-hidden="true"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $pagination->get() ?>

<a href="/user/create"><button type="button" class="btn btn-dark">Create user</button></a>
<a href="/user/logout" class="float-sm-right"><button type="button" class="btn btn-dark">Logout</button></a>
<?php include_once '_footer.php'; ?>