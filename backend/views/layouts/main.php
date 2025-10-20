<?php
/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\web\UrlManager;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\models\Contact;
use backend\models\Buyer;
use backend\models\Language;
AppAsset::register($this);
$this->title = 'Quản trị hệ thống website';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    <base href="<?= Url::base(true) ?>/" target="_self" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody();
$cont = Contact::getContact();
    /*
     * Id action hiện tại có trong mảng $have_submenu thì menu cha có menu con
     * Thêm class translate-x để hiển thị menu con ngay khi click vào button có class show_menu
     */
    $have_submenu = ['product','cat','brand'.'property-value','property','buyer','news','cat-news','album','pictures','video','configure','contact','seo','tab','roles','task','partner','menu','booking'];
    $tasks = $this->params['task_allowed'];
    $func_allowed = array_keys($tasks);
    ?>
    <!-- Begin sidebar -->
    <div class="vn-sidebar <?=(in_array($this->context->id, $have_submenu)) ? 'translate-x' : ''; ?>">
        <div class="box-sidebar">
            <div class="row no-gutters">
                <div class="col-9 logo_menu"><a href=""><img src="images/logo-vinaweb.png" alt="vinaweb"></a></div>
                <div class="col-3 view_menu"><a href="<?= isset($_SERVER["HTTPS"]) ? 'https' : 'http' ?>://<?=$_SERVER['SERVER_NAME']; ?><?= Yii::$app->params['basePath'] ?>" target="_blank" title="Xem website"><i class="fa fa-eye"></i></a></div>
                <div class="col-12 langs">
                    <?php
                    $lang = Language::getLanguage();
                    if (!empty($lang) && count($lang) > 1) {
                        foreach ($lang as $row) {
                            ?><a class="flag<?= (Yii::$app->language == $row->code) ? " active" : ""; ?>" href="<?=Url::to(['site/change-lang', 'code' => $row->code]); ?>"><img src="<?=Yii::$app->urlManagerFrontend->baseUrl.'/'.$row->path; ?>" alt="<?=$row->name; ?>" /></a><?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="vn-menu" style="display:none;">
                <ul>
                    <li <?=($this->context->id == "site")?'class="active"':''; ?>>
                        <a href="<?=Yii::$app->homeUrl; ?>"><i class="fas fa-columns"></i> Quản lý chung</a>
                    </li>
                    <li style="display:none;" <?=(in_array($this->context->id, ['product','cat','brand','place','property','property-value','buyer', 'temp-product']))?' class="active"':''; ?>>
                        <a class="has_sub" href="<?=Url::to(['product/index']); ?>"><i class="fas fa-th-large"></i> Sản phẩm</a>
                        <ul>
                            <!-- tag li có class back chỉ hiển thị trong mobile và click vào để trỏ về menu chính -->
                            <li class="back d-md-none"><span>Sản phẩm</span></li>
                            <li <?=(in_array($this->context->id, ["product", "temp-product"]))?'class="active"':''; ?>>
                                <a href="<?=Url::to(['product/index']); ?>">Quản lý sản phẩm</a>
                            </li>
                            <li <?=($this->context->id == "cat")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['cat/index']); ?>">Danh mục</a>
                            </li>
                            <li <?=($this->context->id == "place")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['place/index']); ?>">Địa điểm</a>
                            </li>
                            <li <?=($this->context->id == "brand")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['brand/index']); ?>">Tiện ích</a>
                            </li>
                            <li <?=($this->context->id == "property")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['property/index']); ?>">Thông số</a>
                            </li>
                            <li <?=($this->context->id == "buyer")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['buyer/index']); ?>">Quản lý đơn hàng (<?=Buyer::countBill(); ?>)</a>
                            </li>
                            <li <?=($this->context->id == "booking")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['booking/index']); ?>">Đặt phòng</a>
                            </li>
                        </ul>
                    </li>
                    <li <?=(in_array($this->context->id, ['profile','cat-profile']))?' class="active"':''; ?>>
                        <a class="has_sub" href="<?=Url::to(['profile/index']); ?>"><i class="fas fa-anchor"></i> Thuyền viên</a>
                        <ul>
                            <!-- tag li có class back chỉ hiển thị trong mobile và click vào để trỏ về menu chính -->
                            <li class="back d-md-none"><span>Thuyền viên</span></li>
                            <li <?=($this->context->id == "profile")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['profile/index']); ?>">Thuyền viên</a>
                            </li>
                            <li <?=($this->context->id == "cat-news")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['cat-profile/index']); ?>">Vị trí</a>
                            </li>
                        </ul>
                    </li>
                    <li <?=(in_array($this->context->id, ['supporter','cat-doctor']))?' class="active"':''; ?>>
                        <a class="has_sub" href="<?=Url::to(['supporter/index']); ?>"><i class="fa fa-table"></i></i> Bác sĩ</a>
                        <ul>
                            <!-- tag li có class back chỉ hiển thị trong mobile và click vào để trỏ về menu chính -->
                            <li class="back d-md-none"><span>Bác sĩ</span></li>
                            <li <?=($this->context->id == "supporter")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['supporter/index']); ?>">Bác sĩ</a>
                            </li>
                            <li <?=($this->context->id == "cat-doctor")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['cat-doctor/index']); ?>">Chuyên khoa</a>
                            </li>
                        </ul>
                    </li>
                    <li <?=(in_array($this->context->id, ['news','cat-news']))?' class="active"':''; ?>>
                        <a class="has_sub" href="<?=Url::to(['news/index']); ?>"><i class="far fa-file-alt"></i> Bài viết</a>
                        <ul>
                            <!-- tag li có class back chỉ hiển thị trong mobile và click vào để trỏ về menu chính -->
                            <li class="back d-md-none"><span>Bài viết</span></li>
                            <li <?=($this->context->id == "news")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['news/index']); ?>">Bài viết</a>
                            </li>
                            <li <?=($this->context->id == "cat-news")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['cat-news/index']); ?>">Danh mục</a>
                            </li>
                        </ul>
                    </li>
                    <li <?=($this->context->id == "page")?'class="active"':''; ?>>
                        <a href="<?=Url::to(['page/index']); ?>"><i class="fas fa-columns"></i> Trang</a>
                    </li>                    
                    <li <?=($this->context->id == "contact-customer")?'class="active"':''; ?>>
                        <a href="<?=Url::to(['contact-customer/index']); ?>"><i class="fas fa-envelope"></i> Khách hàng liên hệ</a>
                    </li>
                    <li <?=(in_array($this->context->id, ['album','pictures','video']))?' class="active"':''; ?>>
                        <a class="has_sub" href="<?=Url::to(['album/index']); ?>"><i class="far fa-images"></i> Thư viện</a>
                        <ul>
                            <!-- tag li có class back chỉ hiển thị trong mobile và click vào để trỏ về menu chính -->
                            <li class="back d-md-none"><span>Thư viện</span></li>
                            <li <?=($this->context->id == "album")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['album/index']); ?>">Album ảnh</a>
                            </li>
                            <li <?=($this->context->id == "video")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['video/index']); ?>">Video</a>
                            </li>
                        </ul>
                    </li>
                    <li <?=(in_array($this->context->id, ['office','city']))?' class="active"':''; ?>>
                        <a class="has_sub" href="<?=Url::to(['office/index']); ?>"><i class="far fa-building"></i></i> Đại lý</a>
                        <ul>
                            <!-- tag li có class back chỉ hiển thị trong mobile và click vào để trỏ về menu chính -->
                            <li class="back d-md-none"><span>Đại lý</span></li>
                            <li <?=($this->context->id == "office")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['office/index']); ?>">Đại lý</a>
                            </li>
                            <li <?=($this->context->id == "city")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['city/index']); ?>">Thành phố</a>
                            </li>
                        </ul>
                    </li>
                    <li <?=(in_array($this->context->id, ['partner','menu','language']) || ($this->context->id == "configure" && $this->context->action->id == "update-css") || ($this->context->id == "configure" && $this->context->action->id == "update-js"))?' class="active"':''; ?>>
                        <a class="has_sub" href="<?=Url::to(['news/index']); ?>"><i class="far fa-image"></i> Quản lý giao diện</a>
                        <ul>
                            <!-- tag li có class back chỉ hiển thị trong mobile và click vào để trỏ về menu chính -->
                            <li class="back d-md-none"><span>Quản lý giao diện</span></li>
                            <li <?=($this->context->id == "partner")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['partner/index']); ?>">Banner / Liên kết</a>
                            </li>
                            <li <?=($this->context->id == "menu")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['menu/index']); ?>">Quản lý menu</a>
                            </li>
                            <li <?=($this->context->id == "language")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['language/index']); ?>">Ngôn ngữ</a>
                            </li>
                            <li <?=($this->context->id == "configure" && $this->context->action->id == "update-css")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['configure/update-css']); ?>">Thay đổi style giao diện</a>
                            </li>
                            <li <?=($this->context->id == "configure" && $this->context->action->id == "update-js")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['configure/update-js']); ?>">Cấu hình javascript</a>
                            </li>
                        </ul>
                    </li>
                    <li <?=($this->context->id == "comment")?'class="active"':''; ?>>
                        <a href="<?=Url::to(['comment/index']); ?>"><i class="far fa-comments"></i> Khách hàng nói</a>
                    </li>
                    <li <?=(in_array($this->context->id, ['configure','contact','seo','tab','message']) && $this->context->action->id != "update-css" && $this->context->action->id != "update-js")?' class="active"':''; ?>>
                        <a class="has_sub" href="<?=Url::to(['contact/index']); ?>"><i class="fas fa-cogs"></i> Cấu hình</a>
                        <ul>
                            <!-- tag li có class back chỉ hiển thị trong mobile và click vào để trỏ về menu chính -->
                            <li class="back d-md-none"><span>Cấu hình</span></li>
                            <li <?=($this->context->id == "contact")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['contact/index']); ?>">Cấu hình liên hệ</a>
                            </li>
                            <li <?=($this->context->id == "configure" && $this->context->action->id == "update")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['configure/index']); ?>">Cấu hình website</a>
                            </li>
                            <li <?=($this->context->id == "seo")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['seo/index']); ?>">Cấu hình SEO</a>
                            </li>
                            <li <?=($this->context->id == "tab")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['tab/index']); ?>">Cấu hình tab ngắn</a>
                            </li>
                            <li <?=($this->context->id == "message")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['message/index']); ?>">Mẫu email & thông báo</a>
                            </li>
                        </ul>
                    </li>
                    <li <?=(in_array($this->context->id, ['roles','task']))?' class="active"':''; ?>>
                        <a class="has_sub" href="<?=Url::to(['roles/index']); ?>"><i class="fas fa-users"></i> Phân quyền</a>
                        <ul>
                            <!-- tag li có class back chỉ hiển thị trong mobile và click vào để trỏ về menu chính -->
                            <li class="back d-md-none"><span>Phân quyền</span></li>
                            <li <?=($this->context->id == "roles")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['roles/index']); ?>">Vai trò</a>
                            </li>
                            <li <?=($this->context->id == "task")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['task/index']); ?>">Quyền</a>
                            </li>
                        </ul>
                    </li>
                    <li <?=($this->context->id == "user")?'class="active"':''; ?>>
                        <a href="<?=Url::to(['user/index']); ?>"><i class="far fa-user-circle"></i> Quản lý tài khoản</a>
                    </li>
                    <li <?=(in_array($this->context->id, ['province','district','ward']))?' class="active"':''; ?>>
                        <a class="has_sub" href="<?=Url::to(['province/index']); ?>"><i class="far fa-file-alt"></i> Địa giới hành chính</a>
                        <ul>
                            <li class="back d-md-none"><span>Địa giới hành chính</span></li>
                            <li <?=($this->context->id == "province")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['province/index']); ?>">Tỉnh / Thành phố</a>
                            </li>
                            <li <?=($this->context->id == "district")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['district/index']); ?>">Quận Huyện</a>
                            </li>
                            <li <?=($this->context->id == "ward")?'class="active"':''; ?>>
                                <a href="<?=Url::to(['ward/index']); ?>">Phường Xã</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <?php
                if (!Yii::$app->user->isGuest) {
                    $current_user = Yii::$app->user->identity;
                    ?>
                    <div class="current_user">
                        <div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <dl>
                                <dt><img src="images/user.png" alt="<?=$current_user->fullname; ?>"></dt>
                                <dd>
                                  <p><?=$current_user->fullname; ?></p>
                                  <p>Quản lý tài khoản</p>
                                </dd>
                            </dl>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="//<?=$_SERVER['SERVER_NAME']; ?>" target="_blank">Xem website</a>
                            <a class="dropdown-item" href="#">Hướng dẫn sử dụng</a>
                            <a class="dropdown-item" href="<?=Url::to(['user/update-info']); ?>">Thông tin tài khoản</a>
                            <a class="dropdown-item" href="<?=Url::to(['user/change-password']); ?>">Đổi mật khẩu</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" style="font-weight: bold; color: #e00;" href="<?=Url::to(['site/logout']); ?>">Đăng xuất</a>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!-- End sidebar_vina -->
    <!-- Begin vn-main -->
    <div class="vn-main">
        <header class="d-md-none">
            <a href="<?=Yii::$app->homeUrl; ?>">
                <i class="fas fa-columns"></i> <span>Hệ thống quản trị</span>
            </a>
        </header>
        <!-- Begin vn-nav -->
        <div class="vn-nav">
            <div class="row no-gutters">
                <div class="col-sm-6">
                    <?= Breadcrumbs::widget([
                        'homeLink' => false,
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <?php
                    if (!empty($this->params['vn-navbar'])) {
                        foreach ($this->params['vn-navbar'] as $row) {
                            echo $row;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- End vn-nav -->
        <!-- Begin vn-content -->
        <div class="vn-content">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
        <!-- End vn-content -->
        <!-- Begin footer -->
        <footer>
            <div>
                <p>Copyright © 2019 - Thiết kế website và phát triển bởi Vinaweb - <a href="#">Google Partner</a> -
                <a href="#" class="google"><i class="fab fa-google-plus-square"></i></a>
                <a href="#" class="face"><i class="fab fa-facebook-square"></i></a>
                </p>
            </div>
        </footer>
        <!-- End footer -->
    </div>
    <!-- End vn-main -->
    <a href="#" class="show_menu d-md-none"><span></span></a>
<script>
    FontAwesomeConfig = { searchPseudoElements: true };
    $(document).ready(function() {
      let task_allowed = '<?= implode(',', $func_allowed) ?>';
      let task_arr = task_allowed.split(',');
      $('.vn-menu a').hide();
      $('.vn-menu').show();
      $('.vn-menu ul li:first-child a').show();
      $('.current_user a').show();
      for (t in task_arr) {
          //cho riêng thông số
          let url1 = '<?=Url::base() ?>/' + task_arr[t] + '/index?property=4';
          $('.vn-menu a[href="' + url1 + '"]').show();
        let url = '<?=Url::base() ?>/' + task_arr[t] + '/index';
        $('.vn-menu a[href="' + url + '"]').show();
        if (task_arr[t] == 'configure') {
          let url = '<?=Url::base() ?>/' + task_arr[t] + '/';
          $('.vn-menu a[href="' + url + 'update-css"]').show();
          $('.vn-menu a[href="' + url + 'update-js"]').show();
          console.log($('.vn-menu a[href="' + url + 'update-js"]'));
        }
      }
    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
