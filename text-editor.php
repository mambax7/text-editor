<?php
/**
 * Adapted text-editor wysiwyg editor
 *
 * @copyright         The XOOPS project http://www.xoops.org/
 * @license           http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package           core
 * @subpackage        xoopseditor
 * @since             2.5.9
 * @author            XOOPS Development Team
 */

xoops_load('XoopsEditor');

/**
 * Constructor
 *
 * @param        string $caption Caption
 * @param        string $name    "name" attribute
 * @param        string $value   Initial text
 * @param        string $width   iframe width
 * @param        string $height  iframe height
 * @param        array  $options Toolbar Options
 */
class XoopsFormTextEditor extends XoopsEditor
{
    public $language = _LANGCODE;
    public $width;
    public $height;
    public $editor;

    // PHP 5 Constructor
    public function __construct($configs)
    {
        $current_path = __FILE__;
        if (DIRECTORY_SEPARATOR != "/") {
            $current_path = str_replace(strpos($current_path, "\\\\", 2) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
        }
        $this->rootPath = "/class/xoopseditor/text-editor";
        parent::__construct($configs);
        //$this->XoopsFormTextArea($configs['caption'], $configs['name'], $configs['value']);
        $this->width  = $configs['width'];
        $this->height = $configs['height'];
    }

    public function getName($encode = true)
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    /**
     * get textarea width
     *
     * @return  string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * get textarea height
     *
     * @return  string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * get language
     *
     * @return  string
     */
    public function getLanguage()
    {
        return str_replace('_', '-', strtolower($this->language));
    }

    /**
     * set language
     *
     * @return  null
     */
    public function setLanguage($lang = 'en')
    {
        $this->language = $lang;
    }

    /**
     * Get initial content
     *
     * @param        bool $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compat
     * @return        string
     */
    public function getValue($encode = false)
    {
        return strtr(htmlspecialchars_decode($this->_value), array("\n" => '<br>', "\r\n" => '<br>'));
    }

    /**
     * Renders the Javascript function needed for client-side for validation
     *
     * @return    string
     */
    public function renderValidationJS()
    {
        if ($this->isRequired() && $eltname = $this->getName()) {
            $eltcaption = $this->getCaption();
            $eltmsg     = empty($eltcaption) ? sprintf(_FORM_ENTER, $eltname) : sprintf(_FORM_ENTER, $eltcaption);
            $eltmsg     = str_replace('"', '\"', stripslashes($eltmsg));
            $ret        = "\n";
            $ret        .= "if ( myform.{$eltname}.value == '' || myform.{$eltname}.value == '<br>' )";
            $ret        .= "{ window.alert(\"{$eltmsg}\"); myform.{$eltname}.focus(); return false; }";

            return $ret;
        }

        return '';
    }

    /**
     * prepare HTML for output
     *
     * @return  string HTML
     */
    public function render()
    {
        static $isJsLoaded = false;
        $ret = "\n";
        if (!$isJsLoaded) {
            $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/class/xoopseditor/text-editor/text-editor/text-editor/ui/ui.min.css');
            $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/class/xoopseditor/text-editor/text-editor/text-editor/ui/ui.i.min.css');
            $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/class/xoopseditor/text-editor/text-editor/text-editor/ui/ui/ui.fam-fam-fam.css');
            $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/class/xoopseditor/text-editor/text-editor/text-editor/ui/ui/ui.i.fam-fam-fam.css');

            $GLOBALS['xoTheme']->addScript(XOOPS_URL . '/class/xoopseditor/text-editor/text-editor/text-editor.js');
            $GLOBALS['xoTheme']->addScript(XOOPS_URL . '/class/xoopseditor/text-editor/text-editor/text-editor/ui/ui.min.js');
            $GLOBALS['xoTheme']->addScript(XOOPS_URL . '/class/xoopseditor/text-editor/text-editor/text-editor/ui/html/html.min.js');
            $GLOBALS['xoTheme']->addScript(XOOPS_URL . '/class/xoopseditor/text-editor/text-editor/text-editor/ui/markdown/markdown.min.js');
        }

        $ret .= "   <p><textarea></textarea></p>
    <script>
    var editor = TE.ui.Markdown(document.querySelector('textarea'));
    </script>
    </p>\n";

        return $ret;
    }
}
