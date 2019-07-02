<?php
/**
 * @copyright Copyright (c) 2018 Akaranan Naree
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace karatae99\datepicker;

/**
 * DatePickerTrait holds common attributes
 *
 * @author Akaranan Naree
 * @package karatae99\datepicker
 */
trait DatePickerTrait
{
    /**
     * @var string the language to use
     */
    public $language;
    /**
     * @var array the options for the Bootstrap DatePicker plugin.
     * Please refer to the Bootstrap DatePicker plugin Web page for possible options.
     * @see http://bootstrap-datepicker.readthedocs.org/en/release/options.html
     */
    public $clientOptions = [];
    /**
     * @var array the event handlers for the underlying Bootstrap DatePicker plugin.
     * Please refer to the [DatePicker](http://bootstrap-datepicker.readthedocs.org/en/release/events.html) plugin
     * Web page for possible events.
     */
    public $clientEvents = [];
    /**
     * @var string the size of the input ('lg', 'md', 'sm', 'xs')
     */
    public $size;
    /**
     * @var array HTML attributes to render on the container
     */
    public $containerOptions = [];
}
