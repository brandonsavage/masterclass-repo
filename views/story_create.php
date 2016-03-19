<form method="post" action="/story/create/save">
    <?php echo $this->error;?><br />

    <label>Headline:</label> <input type="text" name="headline" value="" /> <br />
    <label>URL:</label> <input type="text" name="url" value="" /><br />
    <input type="submit" name="create" value="Create" />
</form>
