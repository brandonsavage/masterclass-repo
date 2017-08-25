<form method="post" action="/user/login/check">
    <p></p><?= $this->error; ?></p>

    <label>Username</label> <input type="text" name="user" value="" />
    <label>Password</label> <input type="password" name="pass" value="" />
    <input type="submit" name="login" value="Log In" />
</form>
