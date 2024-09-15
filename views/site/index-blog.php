<?php

use yii\bootstrap5\Html;

?>

<?php if (Yii::$app->user->isGuest): ?>
    Ввойдите пожалуйста в систему
<?php else: ?>
    <div class="my-2"><?= Html::a('посмотреть работы в 2023 которые раньше плана', 'site/first', ['class' => 'btn btn-success']) ?></div>
    <div class="my-2"><?= Html::a('Посмотреть работы Петрова весной', 'site/second', ['class' => 'btn btn-success']) ?></div>
    <div class="my-2"><?= Html::a('Посмотреть Работников с наибольшем кол-во раьот', 'site/third', ['class' => 'btn btn-success']) ?></div>
    <div class="my-2"><?= Html::a('Посмотреть Работников проекта луна', 'site/fourth', ['class' => 'btn btn-success']) ?></div>

    <div class="my-5">

    <div class="my-3"><?= Html::a('Управление польщователями', 'user/', ['class' => 'btn btn-success']) ?></div>
    <div class="my-3"><?= Html::a('Управление работниками', 'worker/', ['class' => 'btn btn-success']) ?></div>
    <div class="my-3"><?= Html::a('Управление работами', 'job/', ['class' => 'btn btn-success']) ?></div>
    <div class="my-3"><?= Html::a('Управление задачами', 'task/', ['class' => 'btn btn-success']) ?></div>


    </div>


<?php endif ?>