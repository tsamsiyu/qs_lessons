 <!DOCTYPE html>
 <html>
 <head>
     <meta charset="utf-8">
     <title><?php echo TITTLE ?></title>
     <link rel="stylesheet" href="http://htmlbook.ru/lion.css">
     <link rel="stylesheet" href="http://dev53.quartsoft.com/tsamsiyu/lessons2/view/default_template/css/style.css">
<!--    <link rel="stylesheet" type="text/css" href="--><?php //echo CSS.'style.css'?><!--" >  error -->
     <!--[if lt IE 9]>
     <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
     <![endif]-->
 </head>

 <body>

 <div class="wrap">
     <header>
     <?php include($header); ?>
     </header>
     <?php include($menu); ?>
    <div class="clear"></div>
     <div class="wrap_content">
        <?php include($content); ?>
     </div>
     <footer>
     <?php include($footer); ?>
     </footer>
 </div>
 </body>

 </html>