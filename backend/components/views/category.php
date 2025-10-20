<?php
use yii\helpers\Html;
use yii\helpers\Url;
$context = $this->context;
$checkBox = (!empty($context->checkBox)) ? $context->checkBox : [];
?>
<div class="item_menu" data-sort="<?=Url::to([$context->actionSort]); ?>">
    <div class="title_item_menu row no-gutters">
        <div class="col-6 col-md-<?= 11 - count($checkBox); ?> text-left">
            <strong><?=$context->name; ?></strong> <a href="#" class="hide_submenu">[Chỉ mục cha]</a>
            <?php
            if (!empty($context->moreLink)) {
                foreach ($context->moreLink as $row) {
                    ?><a href="<?=$row['url']; ?>">[<?=$row['label']; ?>]</a><?php
                }
            }
            ?>
        </div>
        <?php
        if (!empty($checkBox)) {
            foreach ($checkBox as $key => $val) {
                ?><div class="col-3 col-md-1"><?= $val; ?></div><?php
            }
        }
        ?>
        <div class="col-3 col-md-1">Xóa</div>
    </div>
    <div class="menu_list">
        <ol>
            <?php
            if (!empty($context->data))
            {
                foreach ($context->data as $row) {
                    ?>
                    <li data-key="<?=$row->id; ?>">
                        <div class="row no-gutters">
                            <div class="col-1">
                                <span class="move">::</span>
                            </div>
                            <div class="col-<?= 10 - count($checkBox); ?>">
                                <a href="<?=Url::to([$context->actionUpdate, "id" => $row->id]); ?>"><?=$row->name; ?></a>
                            </div>
                            <?php
                            if (!empty($checkBox)) {
                                foreach ($checkBox as $key => $val) {
                                    ?>
                                    <div class="col-1">
                                        <p><?=Html::checkbox($key.'_chb', $row->$key?1:0, ["data-attr" => $key, "class" => "cajax"]); ?></p>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="col-1">
                                <p><?=Html::a('<i class="far fa-trash-alt"></i>', Url::to([$context->actionDelete, "id" => $row->id]), ["class" => "delete_item_menu"]); ?></p>
                            </div>
                        </div>
                        <?php
                        $submenu = $row->getSubAdmin();
                        if (!empty($submenu)) {
                            ?>
                            <ol>
                                <?php
                                foreach ($submenu as $item) {
                                    ?>
                                    <li data-key="<?=$item->id; ?>">
                                        <div class="row no-gutters">
                                            <div class="col-1">
                                                <span class="move">::</span>
                                            </div>
                                            <div class="col-<?= 10 - count($checkBox); ?>">
                                                <a href="<?=Url::to([$context->actionUpdate, "id" => $item->id]); ?>"><?=$item->name; ?></a>
                                            </div>
                                            <?php
                                            if (!empty($checkBox)) {
                                                foreach ($checkBox as $key => $val) {
                                                    ?>
                                                    <div class="col-1">
                                                        <p><?=Html::checkbox($key.'_chb', $item->$key?1:0, ["data-attr" => $key, "class" => "cajax"]); ?></p>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <div class="col-1">
                                                <p><?=Html::a('<i class="far fa-trash-alt"></i>', Url::to([$context->actionDelete, "id" => $item->id]), ["class" => "delete_item_menu"]); ?></p>
                                            </div>
                                        </div>
                                        <?php
                                        $submenu1 = $item->getSubAdmin();
                                        if (!empty($submenu1)) {
                                            ?>
                                            <ol>
                                                <?php
                                                foreach ($submenu1 as $item1) {
                                                    ?>
                                                    <li data-key="<?=$item1->id; ?>">
                                                        <div class="row no-gutters">
                                                            <div class="col-1">
                                                                <span class="move">::</span>
                                                            </div>
                                                            <div class="col-<?= 10 - count($checkBox); ?>">
                                                                <a href="<?=Url::to([$context->actionUpdate, "id" => $item1->id]); ?>"><?=$item1->name; ?></a>
                                                            </div>
                                                            <?php
                                                            if (!empty($checkBox)) {
                                                                foreach ($checkBox as $key => $val) {
                                                                    ?>
                                                                    <div class="col-1">
                                                                        <p><?=Html::checkbox($key.'_chb', $item1->$key?1:0, ["data-attr" => $key, "class" => "cajax"]); ?></p>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                            <div class="col-1">
                                                                <p><?=Html::a('<i class="far fa-trash-alt"></i>', Url::to([$context->actionDelete, "id" => $item1->id]), ["class" => "delete_item_menu"]); ?></p>
                                                            </div>
                                                        </div>
                                                        <?php
//                                                        cấp 4
                                                        $submenu2 = $item1->getSubAdmin();
                                                        if (!empty($submenu2)) {
                                                            ?>
                                                            <ol>
                                                                <?php
                                                                foreach ($submenu2 as $item2) {
                                                                    ?>
                                                                    <li data-key="<?=$item2->id; ?>">
                                                                        <div class="row no-gutters">
                                                                            <div class="col-1">
                                                                                <span class="move">::</span>
                                                                            </div>
                                                                            <div class="col-<?= 10 - count($checkBox); ?>">
                                                                                <a href="<?=Url::to([$context->actionUpdate, "id" => $item2->id]); ?>"><?=$item2->name; ?></a>
                                                                            </div>
                                                                            <?php
                                                                            if (!empty($checkBox)) {
                                                                                foreach ($checkBox as $key => $val) {
                                                                                    ?>
                                                                                    <div class="col-1">
                                                                                        <p><?=Html::checkbox($key.'_chb', $item2->$key?1:0, ["data-attr" => $key, "class" => "cajax"]); ?></p>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <div class="col-1">
                                                                                <p><?=Html::a('<i class="far fa-trash-alt"></i>', Url::to([$context->actionDelete, "id" => $item2->id]), ["class" => "delete_item_menu"]); ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </ol>
                                                            <?php
                                                        }
                                                        ?>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ol>
                                            <?php
                                        }
                                        ?>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ol>
                            <?php
                        }
                        ?>
                    </li>
                    <?php
                }
            }
            ?>
        </ol>
    </div>
</div>
