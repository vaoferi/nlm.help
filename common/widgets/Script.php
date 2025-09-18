<?php
/**
 * <?php Script::begin(); ?>
 * <script>
 *
 * console.log('Product form: $(document).ready()');
 *
 * </script>
 * <?php Script::end(); ?>

 */

namespace common\widgets;


use yii\base\Widget;
use yii\web\View;

class Script extends Widget
{
    /** @var string Script position, used in registerJs() function */
    public $position = View::POS_READY;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        ob_start();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $script = ob_get_clean();
        $script = preg_replace('|^\s*<script>|ui', '', $script);
        $script = preg_replace('|</script>\s*$|ui', '', $script);
        $this->getView()->registerJs($script, $this->position);
    }
}