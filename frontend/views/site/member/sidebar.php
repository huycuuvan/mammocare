<?php
use yii\helpers\Url;
use backend\components\MyExt;

$info = $this->params['info'];

$memberActions = [
  'member-information' => Yii::t('app', 'member-information'),
  'member-change-password' => Yii::t('app', 'member-change-password'),
  'logout' => Yii::t('app', 'logout')
];
?>

<div class="sidebar-container">

  <div class="widget-box widget-member">
    <h6 class="widget-title"><?= Yii::t('app', 'member-panel') ?></h6>

    <div class="menu-list">
      <ul class="list-group">
        <?php foreach ($memberActions as $key => $value): ?>
        <li class="list-group-item <?= Yii::$app->controller->action->id == $key ? 'active' : '' ?>">
          <a href="<?= Url::toRoute('site/' . $key) ?>"><?= $value ?></a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

</div>
