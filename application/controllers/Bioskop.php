<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bioskop extends MY_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model("Table_Bioskop", "m_bioskop");
    }

	public function index()
	{
		if($this->_check_func($this)){
			$m = $this->method;
			$this->$m();
		}else{
			$this->_api(JSON_ERROR, "No Method ".$this->method." in Class olahraga");
		}
	}

	public function getBioskop()
    {
        $movie_code =   $this->post('id_bioskop');
        /*$movie_code = "BS001";*/
        $bioskop = $this->m_bioskop->get_bioskop();
        $res = array();
        foreach ($bioskop->result() as $key) {
            $res[] = array( 
                "id_bioskop"    => $key->id_bioskop,
                "nama_bioskop"  => $key->nama_bioskop,
                'alamat'        => $key->alamat,
                'picture_url'   => $key->picture_url
                );
        }
        $this->_api(JSON_SUCCESS, "Success Get Data saldo", $res);    }
}

/* End of file olahraga.php */
/* Location: ./application/controllers/olahraga.php */