<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	public $table = "";
    public $pri_index = "";
    public $format_pk = "";

    public function __construct()
    {
        parent::__construct();
    }

    public function get_object($condition = NULL, $select = NULL)
    {
        if ($select !== NULL) {
            $this->db->select($select);
        }
        
        if ($condition !== NULL) {
            if (is_array($condition)) {
                $this->db->where($condition);
            } else {
                $this->db->where($this->pri_index, $condition);
            }
        }
        $result = $this->db->get($this->table);
        return $result;
    }
    public function get($condition = NULL, $select = NULL){
        $result = $this->get_object($condition, $select)->result();
        return $result;
    }

    public function getTicket($condition)
    {
        $this->db->from('pembelian_tiket');
        $this->db->where('id_customer',$condition);
        $this->db->ORDER_BY('tgl_beli','DESC');
        $result = $this->db->get();
       return $result;
    }

    public function get_bioskop()
    {
        /*$query = ("SELECT bioskop.nama_bioskop, bioskop.alamat, manager_register.picture_url FROM bioskop INNER JOIN manager_register ON bioskop.id_manager = manager_register.id");*/
        $this->db->select('bioskop.id_bioskop, bioskop.nama_bioskop, bioskop.alamat, manager_register.picture_url');
        $this->db->from($this->table);
        $this->db->join('manager_register', 'bioskop.id_manager = manager_register.id');
        /*$this->db->where($this->pri_index, $condition);*/
        $result = $this->db->get();
        return $result;
    }

    public function getJadwal($condition, $condition2)
    {
        $query = 'SELECT id_jadwal, id_bioskop ,id_movie, jam, type_theater, kuota,tgl_mulai, tgl_selesai, harga FROM jadwal WHERE id_bioskop = '.'"'.$condition.'"'.' AND id_movie = '.'"'.$condition2.'"'.'';
        $result = $this->db->query($query);
        return $result;
    }

    public function get_movie_tic($condition)
    {
        $this->db->select('COUNT(jadwal.id_movie),jadwal.id_bioskop,jadwal.harga,jadwal.id_movie,jadwal.id_jadwal,movie_new.Poster, movie_new.Title, jadwal.jam, jadwal.type_theater, jadwal.kuota, jadwal.tgl_mulai, jadwal.tgl_selesai' );
        $this->db->from('jadwal');
        $this->db->JOIN('movie_new','movie_new ON jadwal.id_movie = movie_new.id_movie');
        $this->db->where('jadwal.id_bioskop', $condition);

        $this->db->group_by('jadwal.id_movie');
        // $this->db->Groub_BY('nama_film');
        // $this->db->
        $result = $this->db->get();
        return $result;
    }

    public function checkTikeKursi($condition)
    {
        $this->db->SELECT('id_kursi');
        $this->db->FROM($this->table);
        $this->db->WHERE('id_jadwal', $condition);
        $result = $this->db->get();
        return $result;
    }

    public function insert($data){
        $result = $this->db->insert($this->table, $data);
        return $result;
    }
    public function update($data, $condition){
        if (is_array($condition)) {
            $this->db->where($condition);
        } else {
            $this->db->where($this->pri_index, $condition);
        }
        $result = $this->db->update($this->table, $data);
        return $result;
    }
    public function delete($condition){
        if (is_array($condition)) {
            $this->db->where($condition);
        } else {
            $this->db->where($this->pri_index, $condition);
        }
        $result = $this->db->delete($this->table);
        return $result;
    }

}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */