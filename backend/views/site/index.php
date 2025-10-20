<?php
use backend\models\Contact;
use backend\models\Product;
use backend\models\News;
use backend\models\Buyer;
use backend\models\Page;
use backend\models\ContactCustomer;
use yii\helpers\Url;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = ['label' => 'Trang chủ', 'url' => Yii::$app->homeUrl];
$this->params['breadcrumbs'][] = $this->title;

$cont = Contact::getContact();
?>
<div>
    <div class="white_bg item_dashbroad px-4 py-3">
        <div class="welcome_dashbroad mb-3 row justify-content-between">
            <h3 class="col-md-8">Thống kê lượt truy cập website</h3>
            <div class="col-md-4 d-flex align-items-center">
                <span class="mr-2">Ngày:</span> <input type="textbox" id="datepicker" class="form-control form-control-sm w-200" placeholder="Chọn ngày" />
            </div>
        </div>

        <div>
            <canvas id="myChart" width="100%" height="260"></canvas>
            <div class="loading text-center">Đang cập nhật...</div>
        </div>

    </div>

    <div class="white_bg item_dashbroad">
        <div class="top_dashbroad">
            <div class="row no-gutters">
                <div class="col-12 welcome_dashbroad">
                    <h3>Chào mừng bạn đã đăng nhập hệ thống website <a href="//<?= $_SERVER['SERVER_NAME']; ?>" target="_blank"><?= $_SERVER['SERVER_NAME']; ?></a></h3>
                    <p>Dưới đây là 1 số liên kết nhanh:</p>
                </div>
                <div class="col-12 col-md-4 sub_dashbroad">
                    <p>Bắt đầu</p>
                    <div class="first_sub_dashbroad">
                        <a href="<?=Url::to(["configure/index"]); ?>" class="btn btn-warning">Cấu hình website</a>
                        <p>hoặc <a href="<?=Url::to(["contact/index"]); ?>">Cấu hình liên hệ</a></p>
                    </div>
                </div>
                <div class="col-12 col-md-4  sub_dashbroad">
                    <p>Bước tiếp theo</p>
                    <ul>
<!--                        <li><a class="icon1" href="--><?//=Url::to(["product/create"]); ?><!--">Thêm mới sản phẩm</a></li>-->
                        <li><a class="icon2" href="<?=Url::to(["news/create"]); ?>">Thêm mới tin tức</a></li>
                        <li><a class="icon3" href="//<?=$_SERVER['SERVER_NAME']; ?>" target="_blank">Xem website</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-4  sub_dashbroad">
                    <p>Liên kết khác</p>
                    <ul>
<!--                        <li><a class="icon4" href="--><?//=Url::to(["cat/create"]); ?><!--">Thêm mới danh mục</a></li>-->
                        <li><a class="icon5" href="<?=Url::to(["page/create"]); ?>">Thêm trang giới thiệu</a></li>
                        <li><a class="icon6" href="<?=Url::to(["menu/index"]); ?>">Cấu hình menu</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6">
        <div class="white_bg item_dashbroad">
            <p><a href="#">Thống kê</a></p>
            <div class="row no-gutters bill_dashbroad">
<!--                <div class="col-6">-->
<!--                    <a href="--><?//=Url::to(["product/index"]); ?><!--" style="padding-left: 25px"><span><i class="fas fa-th-large"></i> --><?//=Product::countProduct(); ?><!--</span> sản phẩm</a>-->
<!--                </div>-->
                <div class="col-6">
                    <a href="<?=Url::to(["news/index"]); ?>" style="padding-left: 25px"><span><i class="fas fa-file-alt"></i> <?=News::countNews(); ?></span> tin tức</a>
                </div>
<!--                <div class="col-6">-->
<!--                    <a href="--><?//=Url::to(["buyer/index"]); ?><!--" style="padding-left: 25px"><span><i class="fas fa-copy"></i> --><?//= Buyer::countBill(); ?><!--</span> đơn hàng</a>-->
<!--                </div>-->
                <div class="col-6">
                    <a href="<?=Url::to(["page/index"]); ?>" style="padding-left: 25px"><span><i class="fas fa-columns"></i> <?= Page::countPage(); ?></span> trang nội dung</a>
                </div>
                <!--<div class="col-6">
                    <a href="<?=Url::to(["product/index"]); ?>" class="product"><span> <?=Product::countProduct(); ?></span> sản phẩm</a>
                </div>
                <div class="col-6">
                    <a href="<?=Url::to(["news/index"]); ?>" class="news"><span><?=News::countNews(); ?></span> tin tức</a>
                </div>
                <div class="col-6">
                    <a href="<?=Url::to(["buyer/index"]); ?>" class="bill"><span><?= Buyer::countBill(); ?></span> đơn hàng</a>
                </div>
                <div class="col-6">
                    <a href="<?=Url::to(["page/index"]); ?>" class="page"><span><?= Page::countPage(); ?></span> trang nội dung</a>
                </div>-->
            </div>
        </div>

        <div class="white_bg item_dashbroad">
            <p><a href="#">Tin tức mới nhất</a></p>
            <div class="latest_dashbroad">
                <?php
                $latest_news = News::getLatestFive();
                if (!empty($latest_news)) {
                    ?><ul><?php
                    foreach ($latest_news as $row) {
                        ?>
                        <li>
                            <div class="row no-gutters">
                                <div class="col-3 col-sm-2">
                                    <img src="<?=Yii::$app->urlManagerFrontend->baseUrl.'/'.$row->path; ?>" alt="<?=$row->title; ?>">
                                </div>
                                <div class="col-9 col-sm-7">
                                    <a href="<?=Url::to(["news/update", "id" => $row->id]); ?>"><?=$row->title; ?></a>
                                </div>
                                <div class="d-none d-sm-block col-3 text-right"><?=date('d/m/Y H:i', strtotime($row->created_at)); ?></div>
                            </div>
                        </li>
                        <?php
                    }
                    ?></ul><?php
                } else {
                    ?><p style="padding: 15px 10px; font-weight: 600; text-align: center;">Chưa có tin tức nào được nhập!</p><?php
                }
                ?>
            </div>
        </div>
        <div class="white_bg item_dashbroad d-none">
            <p><a href="#">Sản phẩm mới nhất</a></p>
            <div class="latest_dashbroad">
                <?php
                $latest_five = Product::getLatestFive();
                if (!empty($latest_five)) {
                    ?><ul><?php
                    foreach ($latest_five as $row) {
                        ?>
                        <li>
                            <div class="row no-gutters">
                                <div class="col-3 col-sm-2">
                                    <img src="<?=Yii::$app->urlManagerFrontend->baseUrl.'/'.$row->path; ?>" alt="<?=$row->name; ?>">
                                </div>
                                <div class="col-9 col-sm-7">
                                    <a href="<?=Url::to(["product/update", "id" => $row->id]); ?>"><?=$row->name; ?></a>
                                </div>
                                <div class="d-none d-sm-block col-3 text-right"><?=date('d/m/Y H:i', strtotime($row->created_at)); ?></div>
                            </div>
                        </li>
                        <?php
                    }
                    ?></ul><?php
                } else {
                    ?><p style="padding: 15px 10px; font-weight: 600; text-align: center;">Chưa có sản phẩm nào được nhập!</p><?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="white_bg item_dashbroad">
            <p><a href="#">Liên hệ từ khách hàng</a></p>
            <div class="contact_dashbroad">
                <?php
                $latest_contact = ContactCustomer::getLatestFive();
                if (!empty($latest_contact)) {
                    ?>
                    <ul>
                        <?php
                        foreach ($latest_contact as $row) {
                            ?>
                            <li>
                                <div class="row no-gutters">
                                    <div class="col-4">
                                        <a><img src="images/man.png" height="24" alt="<?= $row->name; ?>"> <?= $row->name; ?></a>
                                    </div>
                                    <div class="col-3"><?= $row->mobile; ?></div>
                                    <div class="col-5"><?= $row->email; ?></div>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php
                } else {
                    ?><p style="padding: 15px 10px; font-weight: 600; text-align: center;">Không có liên hệ nào từ khách hàng!</p><?php
                }
                ?>
            </div>
        </div>

        <div class="white_bg item_dashbroad">
            <p><a href="#">Trang mới nhất</a></p>
            <div class="latest_dashbroad">
                <?php
                $latest_news = Page::getLatestFive();
                if (!empty($latest_news)) {
                    ?><ul><?php
                    foreach ($latest_news as $row) {
                        ?>
                        <li>
                            <div class="row no-gutters">
                                <div class="col-9 col-sm-7">
                                    <a href="<?=Url::to(["news/update", "id" => $row->id]); ?>"><?=$row->title; ?></a>
                                </div>
                                <div class="d-none d-sm-block col-3 text-right"><?=date('d/m/Y H:i', strtotime($row->created_at)); ?></div>
                            </div>
                        </li>
                        <?php
                    }
                    ?></ul><?php
                } else {
                    ?><p style="padding: 15px 10px; font-weight: 600; text-align: center;">Chưa có tin tức nào được nhập!</p><?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>


    window.onload = function() {
        const ctx = document.getElementById('myChart');
    
        let myChart;

        const showChart = (startDate, endDate) => {
            $.ajax({
                url: '<?=Url::to(["site/get-chart"]); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                beforeSend: function() {
                    $('.loading').show();
                    $('#myChart').hide();
                },
                success: function(data) {
                    $('.loading').hide();
                    $('#myChart').show();

                    if (typeof myChart !== 'undefined')
                        myChart.destroy();

                    myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.map(function(item) {
                                return item.day;
                            }),
                            datasets: [{
                                label: 'Lượt truy cập',
                                fill: true,
                                data: data.map(function(item) {
                                    return item.visitor;
                                }),
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1,
                                tension: .5
                            },
                            {
                                label: 'Số người',
                                data: data.map(function(item) {
                                    return item.uniquevisitor;
                                }),
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                tension: .5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: 'Ngày'
                                    }
                                },

                                y: {
                                    beginAtZero: true
                                }
                            }
                            
                        }
                    });
                }
            });
        }


        new Litepicker({
            element: document.getElementById('datepicker'),
            singleMode: false,
            tooltipText: {
                one: 'ngày',
                other: 'ngày'
            },
            tooltipNumber: (totalDays) => {
                return totalDays - 1;
            },
            format: 'DD/MM/YYYY',
            endDate: '<?= date('Y-m-d') ?>',
            startDate: '<?= date('Y-m-d', time() - 7 * 86400) ?>',

            setup:  (picker) => {
                picker.on('selected', (date1, date2) => {
                    showChart(formatDate(date1.dateInstance), formatDate(date2.dateInstance));
                });

                showChart(formatDate(picker.getStartDate().dateInstance), formatDate(picker.getEndDate().dateInstance));
            }
        });

        
    }

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }

</script>