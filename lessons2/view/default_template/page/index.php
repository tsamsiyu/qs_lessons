<h1 style="text-align:center;">This is the HOME page.</h1>

<?php //echo "<br>".App::getInstance('UrlManager')->getUrl(); ?>

<?php //echo "<br>Existing databases:";Trivia::pr(PDO::getAvailableDrivers()); ?>

<div>
    <h2>DataBase Task:</h2>
        <ul style="float:left; width: 300px;">
            <li><a href="?r=item/task1">findAll from Item</a></li>
            <li><a href="?r=category/task1">findAll from Category</a></li>
            <li><a href="?r=item/task2&item_pk='1,4,3,5,15,155,0'">findByPk from Item</a></li>
            <li><a href="?r=category/task2&category_pk='1,4,3,10'">findByPk from Category</a></li>
            <li><a href="?r=item/task5&name='kx 4403, sh101'">findBy{name} from Item</a></li>
            <li><a href="?r=category/task5&name='lg, sony'">findBy{name} from Category</a></li>
            <li><a href="?r=item/task3">Create Item</a></li>
            <li><a href="?r=category/task3">Create Category</a></li>
            <li><a href="?r=item/task4">List Item</a></li>
            <li><a href="?r=category/task4">List Category</a></li>
        </ul>

        <ul style="float:left">
            <li><a href="?r=query/task1&var=1500">Task 7.1</a></li>
            <li><a href="?r=query/task2&var=1500">Task 7.2</a></li>
            <li><a href="?r=query/task3&str='r'">Task 7.3</a></li>
            <li><a href="?r=query/task4">Task 7.4</a></li>
            <li><a href="?r=query/task5">Task 7.5</a></li>
            <li><a href="?r=query/task6">Task 7.6</a></li>
            <li><a href="?r=query/task7">Task 7.7</a></li>
            <li><a href="?r=query/task8">Task 7.8</a></li>
            <li><a href="?r=query/task9">Task 7.9</a></li>
        </ul>
    <div class="clear"></div>
</div>

<?php if($model): ?>
<div class="quote" style="width:800px;">
<?php echo "<h4>".$tittle."</h4>"; ?>
<?php if($query): ?>
<?php
    echo "Запрос: ";
    Trivia::pr($query);
?>
<?php endif; ?>
<?php Trivia::pr($model); ?>
</div>
<?php endif; ?>

<!--<div class="quote">-->
<!--    <p><b>ON_MANY : Каждый Item имеет множество Category</b></p>-->
    <?php
// $query = "SELECT i.name, c.name FROM ".Item::getTableName()." i "." INNER JOIN ".Category::getTableName()." c ON i.category_id = c.id";
        $item = new Item();

        $c_id = 1;
        $i_id = 1;

//        $model = $item->findAll("SELECT * FROM tr_item as i INNER JOIN tr_category as c ON tr_category.id = tr_item.category_id");
            $model = $item->findAll("SELECT i.*, c.name as category_name FROM tr_item as i, tr_category as c WHERE i.category_id = c.id");
//        Trivia::pr($model);
    ?>
<!--</div>-->

<!--<div class="quote">-->
<!--    <p><b>TO_MANY : Каждой Category принадлежит множество Item</b></p>-->
    <?php
    // $query = "SELECT i.name, c.name FROM ".Item::getTableName()." i "." INNER JOIN ".Category::getTableName()." c ON i.category_id = c.id";
    $category = new Category();

    $c_id = 1;
    $i_id = 1;

    $model = $category->findAll("SELECT c.*, i.name as item_name FROM tr_category as c, tr_item as i WHERE i.category_id = c.id");
//    Trivia::pr($model);
    ?>
<!--</div>-->

<!--<div class="quote">-->
<!--    <p><b>ON_ONE : Каждому Item принадлежит лишь одна Category</b></p>-->
    <?php
    // $query = "SELECT i.name, c.name FROM ".Item::getTableName()." i "." INNER JOIN ".Category::getTableName()." c ON i.category_id = c.id";
    $item = new Item();

    $c_id = 1;
    $i_id = 1;

/*
 * if(категория уже присвоена){
 * ошибка
 * }else{
 *
 * }
 */

    $model = $item->findAll("SELECT i.*, c.name as category_name FROM tr_item as i, tr_category as c WHERE i.category_id = c.id");
//    Trivia::pr($model);
    ?>
<!--</div>-->
