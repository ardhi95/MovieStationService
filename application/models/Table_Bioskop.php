<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_Bioskop extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = "bioskop";
        $this->pri_index = "id_bioskop";
        $this->format_pk = "";
	}

}

/* End of file Table_Makanan.php */
/* Location: ./application/models/Table_Makanan.php */