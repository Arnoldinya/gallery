<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this    yii\web\View */
/* @var $gallery app\models\Gallery */
/* @var $form    yii\bootstrap\ActiveForm */

$this->title =  ($gallery->isNewRecord ? 'Добавить' : 'Редактировать').' галерею';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'gallery-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($gallery, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
    	<div class="col-lg-offset-1 col-lg-11">
        	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    	</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
