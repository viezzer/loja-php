<?php
interface UserDao {

    public function insert($usuario);
    public function remove($usuario);
    public function removeById($id);
    public function update(&$usuario);
    public function getById($id);
    public function getByLogin($login);
    public function getAll($search_id, $search_name, $limit, $offset);
    public function countAll($search_id, $search_name);
}
?>