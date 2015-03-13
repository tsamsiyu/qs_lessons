<?php foreach($model as $row): ?>
    <div class="list">
        <?php echo "<p> <b>Название</b>: ".$row['name']."</p>"; ?>
        <?php echo "<p> <b>Цена</b>: ".$row['price']."</p>"; ?>
        <?php echo "<p> <b>Дата</b>: ".$row['date']."</p>"; ?>
        <?php echo "<p> <b>Описание</b>: ".$row['description']."</p>"; ?>
        <a href="?r=item/task4&update=<?= $row['id'] ?>">Update</a>
        <a href="#">Delete</a>
    </div>
<?php endforeach; ?>
<div class="clear"></div>