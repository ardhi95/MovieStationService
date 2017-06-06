<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model("Table_Customer", "m_cust");
    }

	public function index()
	{
		if($this->_check_func($this)){
			$m = $this->method;
			$this->$m();
		}else{
			$this->_api(JSON_ERROR, "No Method ".$this->method." in Class Customer");
		}
	}

	public function get_customer()
	{
		$cust_code =   $this->post('id_customer');
		/*if ($cust_code != "") {
            $cstmr = $this->m_cust->get($cust_code);
        }else{
            $cstmr = $this->m_cust->get();
        }*/
        /*$id= "CTM002";*/
        $cstmr = $this->m_cust->get($cust_code);
        $res = array();
        foreach ($cstmr as $key) {
            $res[] = array( 
                "id_customer"       => $key->id_customer,
                "email"             => $key->email,
                "nama"              => $key->nama,
                "no_hp"             => $key->no_hp,
                "saldo"             => $key->saldo,
                "foto"              => $key->foto
            );
        }        
        $this->_api(JSON_SUCCESS, "Success Get Data Customer", $res);
	}


public function update_akun()
    {
        $id_customer =   $this->post('id_customer');
        if ($id_customer) {

        $data = array(
            'no_hp'    => $this->post('no_hp')
        );

            if ($data != NULL) {
                $update = $this->m_cust->update($data, $id_customer);
                if ($update) {
                    $this->_api(JSON_SUCCESS, "Success Update");
                } else {
                    $this->_api(JSON_ERROR, "Failed Update 1, check your input data");
                }
            } else {
                $this->_api(JSON_ERROR, "Failed Update 2, because data null");
                }
           } else {
        $this->_api(JSON_ERROR, "Failed Update 3, in where clause");
       }
    }

    

    public function register()
    {
        // $id_customer = "101815372665836078347";
        $id_customer = $this->post('id_customer');
        // $password = "ardhi";
        if ($id_customer != "") {
            $data = array(
                "id_customer"=>$id_customer
            );
            $cutmr = $this->m_cust->get($data);
            if (!$cutmr) {
                $data = array(
                    'id_customer'       => $this->post('id_customer'),
                    'email'             => $this->post('email'),
                    'nama'              => $this->post('nama'),
                    'foto'              => $this->post('foto')
                );
                $users = $this->m_cust->get($data);
            }
        }
        if ($cutmr) {
            $this->_api(JSON_SUCCESS, "Success Login", $cutmr);
        }else{
            $data = array(
            'id_customer'       => $this->post('id_customer'),
            'email'             => $this->post('email'),
            'nama'              => $this->post('nama'),
            'foto'              => $this->post('foto')
            );
        
            $insert = $this->m_cust->insert($data);
            if ($insert) {
                $this->_api(JSON_SUCCESS, "Success Registration", $data);
            } else {
                $this->_api(JSON_ERROR, "Failed Registration");
            }
        }



        /*$data = array(
            'id_customer'       => $this->post('id_customer'),
            'email'             => $this->post('email'),
            'nama'              => $this->post('nama'),
            'foto'              => $this->post('foto')
        );
        
            $insert = $this->m_cust->insert($data);
            if ($insert) {
                $this->_api(JSON_SUCCESS, "Success Registration", $data);
            } else {
                $this->_api(JSON_ERROR, "Failed Registration");
            }*/
    }
}


/* End of file Makanan.php */
/* Location: ./application/controllers/Makanan.php */