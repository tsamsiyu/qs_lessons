<?php foreach($model as $row): ?>
    <div class="list">
        <?php echo "<p> <b>Название</b>: ".$row['name']."</p>"; ?>
        <a href="?r=category/task4&update=<?= $row['id'] ?>">Update</a>
        <a href="#">Delete</a>
    </div>
<?php endforeach; ?>
<div class="clear"></div>