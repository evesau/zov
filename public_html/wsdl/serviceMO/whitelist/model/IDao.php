<?php
interface IDao{

    public function insert($a);
    public function update($a);
    public function delete($a);
    public function queryOne($a);
    public function queryAll($a);
}
?>
