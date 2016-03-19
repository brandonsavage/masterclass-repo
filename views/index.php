<ol>
    <?php foreach ($this->stories as $story): ?>
    <li>
        <a class="headline" href="<?php echo $story['url'];?>"><?php echo $story['headline'];?></a><br />
        <span class="details"><?php echo $story['created_by'];?> | <a href="/story?id=<?php echo $story['id'];?>"><?php echo $story['count'];?> Comments</a> | <?php echo date('n/j/Y g:i a', strtotime($story['created_on']));?></span>
    </li>
    <?php endforeach;?>
</ol>
