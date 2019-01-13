<?php include_once '_header.php'; ?>
<h1>Login: </h1>
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
        <button type="submit" name="submit" form="myform" class="btn btn-dark">Login</button>
    </form>
</div>
<?php include_once '_footer.php'; ?>

