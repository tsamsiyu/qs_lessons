<!--<script>-->
<!--    window.onload = function(){-->
<!--        document.forms['item-form'].elements['item_form'].onclick = function(event) {-->
<!--            -->
<!--        }-->
<!--    }-->
<!--</script>-->
<?php //Trivia::pr($category); ?>
<fieldset>
    <legend>Create Item</legend>
    <?php $urlForm =  App::getInstance('UrlManager')->getUrl() ?>
    <form action="<?php echo $urlForm; ?>" name="item-form" method="POST">
        <label for="item_name">Name item</label>
        <input type="text" name="item_name" id="item_name" value="<?php if($item['name']) echo $item['name']; ?>" required/>
        <br/>
        <label for="item_price">Price item</label>
        <input type="text" name="item_price" id="item_price" value="<?php if($item['price']) echo $item['price']; ?>" required/>
        <br/>
        <label for="item_date">Date item</label>
        <input type="date" name="item_date" id="item_date" value="<?php if($item['date']) echo $item['date']; ?>" required/>
        <br/>
        <label for="item_description">Description item</label>
        <input type="text" name="item_description" id="item_description" value="<?php if($item['description']) echo $item['description']; ?>" required/>
        <br/>
        <label for="item_category">Category item</label>
        <?php //$category =  ?>
        <select name="item_category" id="item_category">
            <?php
            foreach($category as $row){
                echo "<option value=".$row['id'];
                if($item['category_id'] ==  $row['id']){
                    echo " selected ";
                }
                echo ">";
                echo $row['name'];
            }
            ?>
        </select>
        <br/>
        <input type="hidden" name="item_id" value="<?php if($item['id']) echo $item['id']; ?>">
        <input type="submit" name="item_submit" value="Create"/>
    </form>
</fieldset>