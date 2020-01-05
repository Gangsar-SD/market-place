<?php
defined('BASEPATH') or exit('No direct script access allowed');

class  Menu_model extends CI_Model
{

    public function getSubMenu()
    {

        $query = "SELECT `user_sub_menu`.*,`user_menu`.`menu`
        FROM `user_sub_menu` JOIN `user_menu`
        ON `user_sub_menu`.`menu_id`=`user_menu`.`id`
        ";

        return $this->db->query($query)->result_array();
    }

    public function deleteDataById($table, $id)
    {

        $this->db->delete($table, ['id' => $id]);
    }

    public function getInventory($id_user)
    {

        $query = "SELECT `inventory`.`id`as `id` , `item`, `harga`,`deskripsi`,`kategori`,`email`,`inventory`.`image` FROM `inventory`
        JOIN `list_kategori` ON `id_kategori` = `list_kategori`.`id`
        JOIN `user` ON `user`.`id`=`inventory`.`id_user`
        WHERE `id_user`=$id_user ORDER BY  `inventory`.`id` ";

        return $this->db->query($query)->result_array();
    }
    public function getInventoryByID($id_item)
    {

        $query = "SELECT `inventory`.`id`as `id` , `item`, `harga`,`deskripsi`,`kategori`,`email`,`inventory`.`image` FROM `inventory`
        JOIN `list_kategori` ON `id_kategori` = `list_kategori`.`id`
        JOIN `user` ON `user`.`id`=`inventory`.`id_user`
        WHERE `inventory`.`id`=$id_item ORDER BY  `inventory`.`id` ";

        return $this->db->query($query)->row_array();
    }

    public function getMarketItem($start, $limit)
    {
        $query = "SELECT `inventory`.`id`as `id` , `item`, `harga`,`deskripsi`,`kategori`,`email`,`inventory`.`image` FROM `inventory`
        JOIN `list_kategori` ON `id_kategori` = `list_kategori`.`id`
        JOIN `user` ON `user`.`id`=`inventory`.`id_user`
        ORDER BY `inventory`.`id` LIMIT $start,$limit
        ";
        return $this->db->query($query)->result_array();
    }

    public function getMarketItemByCategory($id_category, $start, $limit)
    {
        $query = "SELECT `inventory`.`id`as `id` , `item`, `harga`,`deskripsi`,`kategori`,`email`,`inventory`.`image` FROM `inventory`
        JOIN `list_kategori` ON `id_kategori` = `list_kategori`.`id`
        JOIN `user` ON `user`.`id`=`inventory`.`id_user`
        WHERE `id_kategori`= $id_category
        ORDER BY `inventory`.`id` LIMIT $start,$limit
        ";
        return $this->db->query($query)->result_array();
    }

    public function getCountItem()
    {
        return $this->db->get('inventory')->num_rows();
    }
    public function getCountItemByUserId($id)
    {
        return $this->db->get_where('inventory', ['id_user' => $id])->num_rows();
    }

    public function getCountItemByCategory($id_kategori)
    {
        return $this->db->get_where('inventory', ['id_kategori' => $id_kategori])->num_rows();
    }
}
