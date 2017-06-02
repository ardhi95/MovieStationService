<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_Ticket extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = "pembelian_tiket";
        $this->pri_index = "id_pembelian";
        $this->format_pk = "";
	}

}

/* End of file Table_Makanan.php */
/* Location: ./application/models/Table_Makanan.php */