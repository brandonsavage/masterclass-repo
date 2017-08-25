
<?php $details = $this->details; ?>

<label>Username:</label><?= $details['username']; ?><br />
<label>Email:</label><?= $details['email']; ?><br />

<form method="post" action="/user/account/save">
    <?= $this->error; ?><br />
    <label>Password</label> <input type="password" name="password" value="" /><br />
    <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
    <input type="submit" name="updatepw" value="Create User" />
</form>