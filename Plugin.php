<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * Adminer for Typecho Blog Platform
 *
 * @package Adminer
 * @author kokororin
 * @version 1.0
 * @link https://kotori.love
 */
class Adminer_Plugin implements Typecho_Plugin_Interface
{
    public static $panel = 'Adminer/page/console.php';

    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('admin/footer.php')->end = array(__CLASS__, 'adminFooter');
        Helper::addPanel(1, self::$panel, 'Adminer', 'Adminer', 'administrator');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
    {
        Helper::removePanel(1, self::$panel);
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {}

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {}

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     */
    public static function render()
    {
        echo '<span class="message success">'
        . htmlspecialchars(Typecho_Widget::widget('Widget_Options')->plugin('HelloWorld')->word)
            . '</span>';
    }

    public static function adminFooter()
    {
        $url = $_SERVER['PHP_SELF'];
        $filename = substr($url, strrpos($url, '/') + 1);
        echo '<script>
$("#typecho-nav-list ul.child li a:contains(\'Adminer\')").attr("target", "_blank");
</script>';
        if ($filename == 'index.php') {
            echo '<script>
  $("#start-link").append("<li><a target=\"_blank\" href=\"';
            Helper::options()->adminUrl('extending.php?panel=' . Adminer_Plugin::$panel);
            echo '\">Adminer</a></li>");
</script>';
        }
    }
}
