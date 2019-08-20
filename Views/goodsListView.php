<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>売上管理システム</title>
    <link rel="stylesheet" type="text/css" href="/MVC/public/css/style.css"/>
    <script type="text/javascript">
        function CheckDelete() {
            return confirm("削除してもよろしいですか？");
        }
    </script>
</head>
<body>
<div id="menu">
    <ul>
        <li><a href="salesinfo.php">売上情報</a></li>
        <li><a href="salesinfoEntry.php">伝票の新規作成</a></li>
        <li><a href="bill.php">請求書</a></li>
        <li><a href="customer.php">顧客マスタ</a></li>
        <li><a href="goods.php">商品マスタ</a></li>
    </ul>
</div>
<h1>商品マスター</h1>

<!-- 商品登録 -->
<div id="entry">
    <form action="" method="post">
        <h2>新規登録</h2>
        <label><span class="entrylabel">ID</span><input type='text' name='GoodsID' size="10"></label>
        <label><span class="entrylabel">商品名</span><input type='text' name='GoodsName' size="30"></label>
        <label><span class="entrylabel">単価</span><input type='text' name='Price' size="10"></label>
        <input type='submit' name='submitEntry' value=' 　新規登録　 '>
    </form>
</div>

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

<!-- Search for Goods -->
<div>
    <form method="get">
        <label for="name">商品名検索</label>
        <input name="name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '' ?>">
        <button type="submit" name="search">検索</button>
    </form>
</div>

<!-- 一覧 -->
<div>
    <!-- Total number of goods -->
    <h4>Total: <?php echo $totalNumber;
//    var_dump($totalNumber);die;?>
    </h4>

    <!-- Goods table -->
    <table class='recordList' id='goodsTable'>
        <tr>
            <th><a href="?column=GoodsID&sort=<?php $this->sortLink ?>&page=<?php $_GET['page'] ?>">ID</a></th>
<!--            --><?php //var_dump($this->sortLink);die; ?>
            <th><a href="?column=GoodsName&sort=<?php $this->sortLink ?>&page=<?php $_GET['page'] ?>">商品名</a></th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach ($rows = $goods->fetchAll(PDO::FETCH_ASSOC) as $row):
//            var_dump($goods);die;
            ?>
            <tr>
                <td><?php echo $row['GoodsID'] ?></td>
                <td><?php echo $row['GoodsName'] ?></td>
                <td><?php echo $row['Price'] ?></td>
                <td>
                    <a href="/MVC/public/goods/edit.php?GoodsID=<?php echo $row['GoodsID']?>">
                        <button>更新</button>
                    </a>
                </td>
                <td>
                    <form method='post' action=''>
                        <input type='hidden' name='id' id='DeleteId' value='<?php echo $row['GoodsID'] ?>'>
                        <input type='submit' name='delete' id='delete' value='削除' onClick='return CheckDelete()'>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Paging -->
    <div>
        <?php for ($i = 1; $i <= $this->pageNumber; $i++):?>
            <a href='/MVC/public/goods/index.php?sort=<?php $this->sortLink?>&page=<?php $d ?>'><?php $d ?>ページへ</a><br />
        <?php endfor;?>
    </div>
    <?php echo $searchedList;?>
</body>
</html>