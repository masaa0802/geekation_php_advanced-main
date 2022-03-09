<?php
require_once(ROOT_PATH .'Models/Player.php');

class PlayerController {
    private $request;   // リクエストパラメータ(GET,POST)
    private $Player;    // Playerモデル

    public function __construct() {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;

        // モデルオブジェクトの生成
        $this->Player = new Player();
        // 別モデルと連携
        $dbh = $this->Player->get_db_handler();
    }

    public function index() {
        $page = 0;
        if(isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }

        $players = $this->Player->findAll($page);
        $players_count = $this->Player->countAll();
        $params = [
            'players' => $players,
            'pages' => $players_count / 20,
            'page' => $page // ページ番号
        ];
        return $params;
    }
}
