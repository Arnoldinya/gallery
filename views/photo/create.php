<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this  yii\web\View */
/* @var $photo app\models\Photo */
/* @var $form  yii\bootstrap\ActiveForm */

$this->title =  ($photo->isNewRecord ? 'Добавить' : 'Редактировать').' фото';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'gallery-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($photo, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($photo, 'description')->textarea(['rows' => 6]) ?>

    <?php if ($photo->filePath): ?>
   	<div class="form-group">
    	<div class="col-lg-offset-1 photo-item col-lg-3">
	        <div class="image">
	            <img src="<?= $photo->filePath ?>">
	        </div>
    	</div>
    	<?= $form->field($photo, 'filePath')->hiddenInput()->label(false) ?>
    </div>    	
    <?php endif ?>

    <?= $form->field($photo, 'file')->fileInput() ?>

    <div class="form-group">
    	<div class="col-lg-offset-1 col-lg-11">
        	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    	</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
