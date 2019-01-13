<?php include_once '_header.php'; ?>
<h1>Viewing user: <?= $user->login ?></h1>
<div class="pt-2">
    <table class="table">
        <tbody>
            <tr>
                <th scope="row">ID</th>
                <td scope="row"><?= $user->id ?></td>
            </tr>
            <tr>
                <th scope="row">Login</th>
                <td scope="row"><?= $user->login ?></td>
            </tr>
            <tr>
                <th scope="row">Role</th>
                <td scope="row"><?= $user->role ?></td>
            </tr>
            <tr>
                <th scope="row">First Name</th>
                <td scope="row"><?= $user->first_name ?></td>
            </tr>
            <tr>
                <th scope="row">Second Name</th>
                <td scope="row"><?= $user->second_name ?></td>
            </tr>
            <tr>
                <th scope="row">Sex</th>
                <td scope="row"><?= $user->sex ?></td>
            </tr>
            <tr>
                <th scope="row">Date of birth</th>
                <td scope="row"><?= $user->date_of_birth ?></td>
            </tr>
            <tr>
                <th scope="row">Created At</th>
                <td scope="row"><?= $user->created_at ?></td>
            </tr>
            <tr>
                <th scope="row">Updated At</th>
                <td scope="row"><?= $user->updated_at ?></td>
            </tr>
        </tbody>
    </table>
    <a href="<?= $backPath ?>"><button type="button" class="btn btn-dark">Back</button></a>
</div>
<?php include_once '_footer.php'; ?>