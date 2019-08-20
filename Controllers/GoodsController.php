<?php

/**
 * Class GoodsController
 */
Class GoodsController
{

    /**
     * @var goodsModel
     */
    private $goodsModel;

    /**
     * @var array
     */
    private $errorMsgs = [];

    private $sortLink;
    private $sortKs;
    private $nowPage;

    public function __construct()
    {
        $this->goodsModel = new goodsModel();
        $this->sortLink = $this->goodsModel->setSelectGoods();
//        var_dump($this->sortLink);die;
        $this->nowPage = $_GET['page'];
//        var_dump($this->nowPage);die;
    }

    /**
     * 商品編集ページ表示
     */
    public function renderEditPage()
    {

        // 1レコード取得
        $oneRecord = $this->goodsModel->getRow($_GET['GoodsID']);
        // 更新ボタンが押されたら
        if(isset($_POST['submitUpdate'])) {
            $this->errorMsgs = $this->goodsModel->validate();
            if(count($this->errorMsgs) === 0) {
                $this->goodsModel->setUpdateGoods();
            }
        }

        include __DIR__ . '/../Views/goodsEditView.php';
    }

    /**
     * 一覧ページ表示
     */
    public function renderListPage()
    {
//        $this->goodsModel->getPage();
        $this->goodsModel->setSelectGoods();
        // LIMIT, OFFSET
        if (!isset($_GET['page'])) {
//            var_dump($_GET['page']);die;
            $_GET['page'] = 1;
        }

        // 新規登録ボタンが押されたら
        if (isset($_POST['submitEntry'])) {
            $this->errorMsgs = $this->goodsModel->validate();
            if (count($this->errorMsgs) === 0) {
                $this->goodsModel->insertGoods();
            }
        }

        if(isset($_GET['name'])){
            $goods = $this->getSearchedGoods();
        } else {
            $goods       = $this->goodsModel->getList();
        }

        $this->deleteGoods();
        $getPageNumber = $this->paging();
        $this->pushedPage($getPageNumber);

        $totalNumber = $this->goodsModel->getTotalNumber();

        require __DIR__ . '/../Views/goodsListView.php';
    }

    /**
     * paging
     */
    public function paging()
    {

        $totalNumber = $this->goodsModel->getTotalNumber();
        $pageNumber = ceil($totalNumber / 5); // 総件数÷1ページに表示する件数 を切り上げたものが総ページ
        return $pageNumber;
    }

    public function pushedPage($getPageNumber)
    {
        if (!empty($_GET['sort'])){
            $_GET['sort']  = 'asc';
        }
        for ($i = 1; $i <= $getPageNumber; $i++) {
            printf("<a href='/MVC/public/goods/index.php?sort=%s&page=%d'>%dページへ</a><br />\n", $_POST['sort'], $i, $i);
        }
    }


    /**
     * 商品削除
     */
    public function deleteGoods()
    {
        //削除処理
        if (isset($_POST['delete'])) {
            $this->goodsModel->setDeleteGoods($_POST['id']);
        }
        return;
    }

    /**
     * 検索フォーム受け取り
     */

    public function getSearchedGoods()
    {
        if(isset($_GET['name'])){
            $searched = $this->goodsModel->search($_GET['name']);
            return $searched;
        }
    }
}