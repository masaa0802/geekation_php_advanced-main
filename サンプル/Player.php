<?php
require_once(ROOT_PATH .'Models/Db.php');

class Player extends Db {
    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }
    /**
     * playersテーブルからすべてデータを取得（20件ごと）
     */
    public function findAll($page = 0):Array {
        $sql = 'SELECT';
        $sql .= ' players.id,';
        $sql .= ' players.uniform_num,';
        $sql .= ' players.position,';
        $sql .= ' players.name as player_name,';
        $sql .= ' players.club,';
        $sql .= ' players.birth,';
        $sql .= ' players.height,';
        $sql .= ' players.weight,';
        $sql .= ' countries.name as country_name';
        $sql .= ' FROM players';
        $sql .= ' JOIN countries ON players.country_id = countries.id';
        $sql .= ' WHERE players.del_flg = 0';
        $sql .= ' LIMIT 20 OFFSET '.(20 * $page);
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * playersテーブルから全データ数を取得
     *
     * @return Int $count 全選手の件数
     */
    public function countAll():Int {
        $sql = 'SELECT count(*) as count FROM players';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }
}