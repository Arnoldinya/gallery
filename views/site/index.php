<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $galleries app\models\Gallery */

$this->title = 'Галереи';
?>
<div class="site-index">
    <?php if (!Yii::$app->user->identity->gallery): ?>
    <div class="">
        <p class="lead">
            У вас не создана галерея.
            <a class="btn btn-sm btn-success" href="<?= Url::to(['gallery/create-update']) ?>">
                Создать
            </a>
        </p>
    </div>
    <?php endif ?>
    <div class="body-content">
        <div class="row">
            <?php foreach ($galleries as $gallery): ?>
            <?php if ($gallery->getPhotos(4)): ?>
            <div class="col-lg-12 gallery-item">
                <h2>
                    <a href="<?= Url::to(['gallery/index', 'id' => $gallery->id]) ?>">
                        <?= $gallery->name ?>
                    </a>
                </h2>

                <h5>
                    Создатель <?= $gallery->user->name ?>
                </h5>

                <?php foreach ($gallery->getPhotos(4) as $photo): ?>
                <div class="photo-item col-lg-3">
                    <div class="title">
                        <?= $photo->name ?>
                    </div>
                    <div class="image">
                        <img src="<?= $photo->filePath ?>">
                    </div>

                    <div>
                        <?= $photo->description ?>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            <?php endif ?>
            <?php endforeach ?>
        </div>

    </div>
</div>
