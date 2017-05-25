<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saldo extends MY_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model("Table_Saldo", "m_saldo");
    }

	public function index()
	{
		if($this->_check_func($this)){
			$m = $this->method;
			$this->$m();
		}else{
			$this->_api(JSON_ERROR, "tidak ada method ".$this->method." di class record");
		}
	}


public function tambah_saldo()
    {
        $data = array(
            'id_transaksi_saldo'    => $this->post('id_transaksi_saldo'),
            'jumlah_saldo'          => $this->post('jumlah_saldo'),
            'tanggal'               => $this->post('tanggal'),
            'id_customer'           => $this->post('id_customer')
            );
        
            $insert = $this->m_saldo->insert($data);
            if ($insert) {
                $this->_api(JSON_SUCCESS, "Success Registration", $data);
            } else {
                $this->_api(JSON_ERROR, "Failed Registration");
            }
    }

public function getHistorySaldo()
{
    $saldo_code =   $this->post('id_customer');
        if ($saldo_code != "") {
            $saldo = $this->m_saldo->get($saldo_code);
        }else{
            $saldo = $this->m_saldo->get();
        }
        $res = array();
        foreach ($saldo as $key) {
            $res[] = array( 
                "id_transaksi_saldo"   => $key->id_transaksi_saldo,
                'jumlah_saldo'         => $key->jumlah_saldo,
                'tanggal'              => $key->tanggal,
                'id_customer'          => $key->id_customer,
                'status'          => $key->status
            );
        }
        $this->_api(JSON_SUCCESS, "Success Get Data saldo", $res);
    }

}

/* End of file olahraga.php */
/* Location: ./application/controllers/olahraga.php */