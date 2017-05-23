<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_Movie extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		$this->table = "movie_new";
        $this->pri_index = "imdbID";
        $this->format_pk = "";
	}

}

/* End of file Table_Makanan.php */
/* Location: ./application/models/Table_Makanan.php */