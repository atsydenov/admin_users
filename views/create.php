<?php include_once '_header.php'; ?>
<h1>Creating a new user: </h1>
<div class="pt-2">
    <?php if (isset($errors) && is_array($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach ($errors as $error): ?>
                <?= $error ?><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="#" method="post" id="myform">
        <div class="form-group">
            <label for="login">Login</label>
            <input type="text" name="login" class="form-control" id="login" placeholder="Enter login" form="myform" value="<?= $user->login ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" value="<?= $user->password ?>" form="myform">
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Enter first name" form="myform" value="<?= $user->first_name ?>">
        </div>
        <div class="form-group">
            <label for="second_name">First Name</label>
            <input type="text" name="second_name" class="form-control" id="second_name" placeholder="Enter second name" form="myform" value="<?= $user->second_name ?>">
        </div>
        <div class="form-group">
            <label for="sex">Sex</label>
            <select class="form-control" id="sex" name="sex">
                <option value="male" <?php if ($user->sex == 'male'): ?> selected="selected" <?php endif;?>>male</option>
                <option value="female" <?php if ($user->sex == 'female'): ?> selected="selected" <?php endif;?>>female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of birth</label>
            <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" value="<?php echo $user->date_of_birth ?>" form="myform">
        </div>
        <button type="submit" name="submit" form="myform" class="btn btn-dark">Save</button>
        <a href="<?= $backPath ?>"><button type="button" class="btn btn-dark">Back</button></a>
    </form>
</div>
<?php include_once '_footer.php'; ?>

