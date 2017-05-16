<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_Customer extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = "customer";
        $this->pri_index = "id_customer";
        $this->format_pk = "";
	}

}

/* End of file Table_Makanan.php */
/* Location: ./application/models/Table_Makanan.php */