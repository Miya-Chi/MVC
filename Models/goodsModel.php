<?php

$db = new DB();
Class goodsModel extends DB
{
//    public $column;
    public $sortButton;
    public $sortLink;
    public $limit;

    const column = 'GoodsID';
    const sortButton = 'ASC';
    const sortLink = 'ASC';
    const limit = 5;
    public function __construct(){

    }

    public function setSelectGoods()
    {
        {
//            $this->column = self::column;
            $this->sortButton = self::sortButton;
            $this->sortLink = self::sortLink;
            $this->limit = self::limit;

            //column別ソート
            switch ($_GET['column']) {
                case "GoodsID":
                    $columnID = 'GoodsID';
                    $this->column = $columnID;
                    break;
                case "GoodsName":
                    $columnName = 'GoodsName';
                    $this->column = $columnName;
                    break;
            }
            // Sort
            switch ($_GET['sort']) {
                case "ASC":
                    $aOrDButton = 'ASC';
                    $this->sortButton = $aOrDButton;
                    $aOrDLink = 'DESC';
                    $this->sortLink = $aOrDLink;
                    break;
                case "DESC":
                    $aOrDButton = 'DESC';
                    $this->sortButton = $aOrDButton;
                    $aOrDLink = 'ASC';
                    $this->sortLink = $aOrDLink;
                    break;
            }
        }
    }

    public function showPage()
    {
        $this->setSelectGoods();
        // LIMIT, OFFSET
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        $offset = (intval($_GET['page']) - 1) * self::limit;
//                var_dump($_GET['page']);die;
    }

//    public function sortSort()
//    {
//        $this->setSelectGoods();
//        $sortB = "";
//        $sortL = "";
//        $array = array("$sortB" =>  "$this->sortButton", "$sortL" => "$this->sortLink" );
//        return $array;
//    }


//    /**
//     * ページ番号取得
//     */
//    public function getPage()
//    {
//        $this->setSelectGoods();
//        // LIMIT, OFFSET
//        if (!isset($_GET['page'])) {
//            $_GET['page'] = 1;
//        }
//        $offset = (intval($_GET['page']) - 1) * self::limit;
////                var_dump($_GET['page']);die;
//        return $offset;
//    }

    /**
     * １レコード取得
     */
    public function getRow($GoodsID)
    {
        $sql = "SELECT * FROM goods WHERE GoodsID=?";
        $array = array($GoodsID);
        $res = parent::executeSQL($sql, $array);
        $rows = $res->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }

    /**
     * Goods一覧取得
     * @return string
     */
    public function getList()
    {
        $this->setSelectGoods();
        // LIMIT, OFFSET
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        $offset = (intval($_GET['page']) - 1) * self::limit;
//                var_dump($_GET['page']);die;

//        $this->getPage();
        // Execute SQL.
        $sql = "SELECT * FROM goods ORDER BY {$this->column} {$this->sortButton} LIMIT {$this->limit}";
        $res = parent::executeSQL($sql, null);
        return $res;

    }

    /**
     * Get total number of goods.
     */
    public function getTotalNumber()
    {
        $sql = "SELECT COUNT(*) as total FROM goods";
        $res = parent::executeSQL($sql, null);
        $results = $res->fetchAll(PDO::FETCH_ASSOC);
        return $results[0]['total'];
    }

    /**
     * @return array
     */
    public function validate()
    {
        // 配列
        $errorMessages = array("IDの入力は必須です。", "商品名の入力は必須です。", "単価は半角数字で入力してください");
        $returnError = [];

        if ($_POST['GoodsID'] == null || strcmp($_POST['GoodsID'], "") == 0) {
            array_push($returnError, $errorMessages[0]);
        }
        if ($_POST['GoodsName'] == null || strcmp($_POST['GoodsName'], "") == 0) {
            array_push($returnError, $errorMessages[1]);
        }
        if (!preg_match("/^[0-9]+$/", $_POST['Price'])) {
            # 半角数字以外が含まれていた場合、false
            array_push($returnError, $errorMessages[2]);
        }

        return $returnError;
    }

    /**
     * Insert
     */
    public function insertGoods()
    {
        $sql = "INSERT INTO goods VALUES(?,?,?)";
        $array = array($_POST['GoodsID'], $_POST['GoodsName'], $_POST['Price']);
        parent:: executeSQL($sql, $array);
    }

    /**
     * @return bool
     */
    public function setUpdateGoods()
    {
        try{
            $sql = "UPDATE goods SET GoodsName=?, Price=? WHERE GoodsID=?";
            //array関数の引数の順番に注意する
            $array = array($_POST['GoodsName'], $_POST['Price'], $_POST['GoodsID']);

            parent::executeSQL($sql, $array);
        } catch ( Exception $e ) {
            return false;
            // 後続処理は中断
        }
    }

    public function GoodsNameForUpdate($GoodsID)
    {
        return $this->FieldValueForUpdate($GoodsID, "GoodsName");
    }

    public function PriceForUpdate($GoodsID)
    {
        return $this->FieldValueForUpdate($GoodsID, "Price");
    }

    private function FieldValueForUpdate($GoodsID, $field)
    {
        //private関数　上の2つの関数で使用している
        $sql = "SELECT {$field} FROM goods WHERE GoodsID=?";
        $array = array($GoodsID);
        $res = parent::executeSQL($sql, $array);
        $rows = $res->fetch(PDO::FETCH_NUM);
        return $rows[0];
    }

    public function setDeleteGoods($GoodsID)
    {
        $sql = "DELETE FROM goods WHERE GoodsID=?";
        $array = array($GoodsID);
        parent::executeSQL($sql, $array);
    }

    /**
     * 検索
     */

    public function search()
    {
        $name = $_GET['name'];
        $sql = "SELECT * FROM goods WHERE GoodsName LIKE '%{$name}%'";
        $res = parent::executeSQL($sql, null);
        return $res;
    }


}