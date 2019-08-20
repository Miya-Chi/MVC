<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>商品編集 | 売上管理システム</title>
    <link rel="stylesheet" type="text/css" href="/MVC/public/css/style.css"/>
</head>
<body>
<div id="menu">
    <ul>
        <li><a href="salesinfo.php">売上情報</a></li>
        <li><a href="salesinfoEntry.php">伝票の新規作成</a></li>
        <li><a href="bill.php">請求書</a></li>
        <li><a href="customer.php">顧客マスタ</a></li>
        <li><a href="../goods/index.php">商品マスタ</a></li>
    </ul>
</div>
<h1>商品マスター編集</h1>

<!-- 入力チェックエラーメッセージ -->
<div style="color: red;">
    <?php
    if (!empty($this->errorMsgs)) {
        $m = "";
        foreach ($this->errorMsgs as $errorMsg) {
            $m = $m . $errorMsg;
        }
        echo $m;
    }
    ?>
</div>

<!-- 更新 -->
<div id="update">
    <form action="" method="post">
        <h2>更新</h2>
        <p>GoodsID: <?php echo $oneRecord['GoodsID']; ?></p>

        <input type="hidden" name="GoodsID" value="<?php echo $oneRecord['GoodsID']; ?>"/>
        <label>
            <span class="entrylabel">商品名</span>
            <input type='text' name='GoodsName' size="30" value="<?php echo $oneRecord['GoodsName']; if( !empty($_POST['GoodsName']) ){ echo $_POST['GoodsName']; }  ?>">
        </label>
        <label>
            <span class="entrylabel">単価</span>
            <input type='text' name='Price' size="10" value="<?php echo $oneRecord['Price']; if( !empty($_POST['Price']) ){ echo $_POST['Price']; } ?>">
        </label>
        <input type='submit' name='submitUpdate' value=' 　更新　 '>
    </form>
</div>

</body>
</html>