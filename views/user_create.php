<form method="post" action="/user/account/create">
    <?php echo $this->error;?><br />
    <label>Username</label> <input type="text" name="username" value="" /><br />
    <label>Email</label> <input type="text" name="email" value="" /><br />
    <label>Password</label> <input type="password" name="password" value="" /><br />
    <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
    <input type="submit" name="create" value="Create User" />
</form>
