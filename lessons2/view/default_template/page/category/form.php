
<fieldset>
    <legend>Create Category</legend>
    <?php $urlForm =  App::getInstance('UrlManager')->getUrl() ?>
    <form action="<?php echo $urlForm; ?>" name="category-form" method="POST">
        <label for="category_name">Name item</label>
        <input type="text" name="category_name" id="category_name" value="<?php if($category['name']) echo $category['name']; ?>" required/>
        <br/>
        <input type="hidden" name="category_id" value="<?php if($category['id']) echo $category['id']; ?>">
        <input type="submit" name="category_submit" value="Create"/>
    </form>
</fieldset>