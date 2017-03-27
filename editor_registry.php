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

return $config = array(
    "name"   => "text-editor",
    "class"  => "XoopsFormTextEditor",
    "file"   => XOOPS_ROOT_PATH . "/class/xoopseditor/text-editor/text-editor.php",
    "title"  => _XOOPS_EDITOR_MACHE,
    "order"  => 13,
    "nohtml" => 0
);
