<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this    yii\web\View */
/* @var $gallery app\models\Gallery */

$this->title =  'Галерея '.Yii::$app->user->identity->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-index">

    <?php if ($gallery): ?>

    <?php if ($gallery->userId == Yii::$app->user->id): ?>
    <p>
        <?= Html::a('Добавить фото', ['/photo/create-update'], ['class' => 'btn btn-success']) ?>
    </p>  
    <?php endif ?>
    
    <h4>
        <?= $gallery->name ?>

        <?php if ($gallery->userId == Yii::$app->user->id): ?>
        <?= Html::a('<span class=" glyphicon glyphicon-pencil"></span>', ['create-update', 'id' => $gallery->id]) ?>
        <?= Html::a('<span class=" glyphicon glyphicon-trash"></span>', ['delete', 'id' => $gallery->id], [
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить галерею?',
                'method'  => 'post',
            ],
        ]) ?>
        <?php endif ?>
    <h4>

    <div class="row">
        <?php foreach ($gallery->photos as $key => $photo): ?>
        <div class="photo-item col-lg-3">
            <div class="title">
                <?= $photo->name ?>

                <?php if ($gallery->userId == Yii::$app->user->id): ?>
                <?= Html::a('<span class=" glyphicon glyphicon-pencil"></span>', ['/photo/create-update', 'id' => $photo->id]) ?>
                <?= Html::a('<span class=" glyphicon glyphicon-trash"></span>', ['/photo/delete', 'id' => $photo->id], [
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить фото?',
                        'method'  => 'post',
                    ],
                ]) ?>
                <?php endif ?>
            </div>
            <div class="image">
                <img src="<?= $photo->filePath ?>">
            </div>

            <div>
                <?= $photo->description ?>
            </div>
        </div>
        <?php if (($key + 1)%4 == 0): ?>
        </div>
        <div class="row">
        <?php endif ?>
        <?php endforeach ?>
    </div>
    <?php else: ?>
    <p>
        <?= Html::a('Создать галерею', ['create-update'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif ?>
</div>
