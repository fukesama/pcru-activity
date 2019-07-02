Bootstrap DatePicker Thai Buddhist-Era (B.E.) Widget for Yii2
====================================

[![License](https://poser.pugx.org/karatae99/yii2-date-picker-thai-widget/license)](https://packagist.org/packages/karatae99/yii2-date-picker-thai-widget)
[![Total Downloads](https://poser.pugx.org/karatae99/yii2-date-picker-thai-widget/downloads)](https://packagist.org/packages/karatae99/yii2-date-picker-thai-widget)

This is thai buddhist calendar datepicker of Yii2 extension. modified from (https://github.com/2amigos/yii2-date-picker-widget)

Renders a [Bootstrap DatePicker plugin](http://bootstrapformhelpers.com/datepicker/).

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require karatae99/yii2-date-picker-thai-widget "~1.0"
```
or add

```json
"karatae99/yii2-date-picker-thai-widget" : "~1.0"
```

to the require section of your application's `composer.json` file.

Usage
-----

**DatePicker**

This widget renders a Bootstrap DatePicker input control. Best suitable for model with date string attribute.

***Example of use with a form***  
There are two ways of using it, with an `ActiveForm` instance or as a widget setting up its `model` and `attribute`.

```php
<?php

use karatae99\datepicker\DatePicker;

// as a widget
?>

<?= DatePicker::widget([
    'model' => $model,
    'attribute' => 'date',
    'template' => '{addon}{input}',
	'language' => 'th', // Thai B.E.
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy'
        ]
]);?>

<?php 
// with an ActiveForm instance 
?>
<?= $form->field($model, 'date')->widget(
    DatePicker::className(), [
        // inline too, not bad
        'inline' => true, 
        // modify template for custom rendering
        'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
	'language' => 'th', // Thai B.E.
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy'
        ]
]);?>
```  
***Example of use without a model***

```php
<?php
use karatae99\datepicker\DatePicker;
?>
<?= DatePicker::widget([
    'name' => 'Test',
    'value' => '20/03/2561',
    'template' => '{addon}{input}',
	'language' => 'th', // Thai B.E.
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd/mm/yyyy'
        ]
]);?>
```


Further Information
-------------------
Please, check the [Bootstrap DatePicker site](http://bootstrap-datepicker.readthedocs.io/en/latest/) documentation for further information about its configuration options. 


License
-------
The BSD License (BSD). Please see [License File](LICENSE.md) for more information.
