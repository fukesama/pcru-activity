Yii2: jQuery.stickyFooter
=============================
Widget for [jQuery.stickyFooter](https://github.com/miWebb/jQuery.stickyFooter) script

Installation
-----------------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist pavlinter/yii2-sticky-footer "dev-master"
```

or add

```
"pavlinter/yii2-sticky-footer": "dev-master"
```

to the require section of your `composer.json` file.

Usage
------------------------
```php
<?php \pavlinter\stickyFooter\StickyFooter::begin(['id' => 'myFooter','contentSelector' => "#wrapper"]) ?>
    <div id="footer">
        footer
    </div>
<?php \pavlinter\stickyFooter\StickyFooter::end() ?>
```