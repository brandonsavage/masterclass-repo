<a class="headline" href="<?php echo $this->story['url'];?>"><?php echo $this->story['headline'];?></a><br />
<span class="details"><?php echo $this->story['created_by'];?> | <?php echo $this->story['comment_count'];?> Comments | <?php echo date('n/j/Y g:i a', strtotime($this->story['created_on']));?></span>
<?php if (isset($_SESSION['AUTHENTICATED'])) :?>
<form method="post" action="/comment/create">
    <input type="hidden" name="story_id" value="<?php echo $this->story['id'];?>" />
    <textarea cols="60" rows="6" name="comment"></textarea><br />
    <input type="submit" name="submit" value="Submit Comment" />
</form>
<?php endif;?>
<br><br>
<?php foreach ($this->comments as $comment) :?>
<div class="comment">
    <span class="comment_details"><?php echo $comment['created_by'];?> | <?php echo date('n/j/Y g:i a', strtotime($comment['created_on']));?></span>
    <?php echo $comment['comment'];?>
</div>
<?php endforeach;?>
