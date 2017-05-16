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
        $id= "CTM002";
        $cstmr = $this->m_cust->get($id,$cust_code);
        $res = array();
        foreach ($cstmr as $key) {
            $res[] = array( 
                "id_customer"       => $key->id_customer,
                "email"             => $key->email,
                "nama"              => $key->nama,
                "gender"            => $key->gender,
                "no_hp"             => $key->no_hp,
                "saldo"             => $key->saldo,
                "foto"              => $key->foto
            );
        }        
        $this->_api(JSON_SUCCESS, "Success Get Data Customer", $res);
	}

    public function insert(){        
        $nm = $this->post('nama_makanan');
        $config = array();
        $config['max_size'] = '3072';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['overwrite']     = TRUE; 
        $config['upload_path']   = './assets/upload/Makanan/';
        $config['file_name']     = $nm.'.png';
        if (!file_exists($config["upload_path"])) {
            mkdir($config["upload_path"]);
        }
        $this->load->library('upload');
        $this->upload->initialize($config);
        $data = array(
            'id_makanan'        => $this->post('id_makanan'),
            'nama_makanan'      => $this->post('nama_makanan'),
            'jenis'             => $this->post('jenis'),
            'kkal'              => $this->post('kkal'),
            'karbo'             => $this->post('karbo'),
            'protein'           => $this->post('protein'),
            'lemak'             => $this->post('lemak'),            
            'keterangan'        => $this->post('keterangan'),
        );
        $where1 = $this->m_cust->count(array('nama_makanan' => $this->post('nama_makanan')));
        if ($where1 > 0) {
            $this->_api(JSON_ERROR, "Data Telah Tersedia");
        }else{
            $insert = $this->m_cust->insert($data);
            if ($insert) {
                //$this->_api(JSON_SUCCESS, "Success Insert Data", $data);
                if (isset($_FILES["foto"]) && $_FILES["foto"] != NULL) {
                    if (!$this->upload->do_upload("foto")) {
                        $this->_api(JSON_ERROR, "Insert Foto Gagal");
                        exit(0);
                    }
                }
                $this->_api(JSON_SUCCESS, "Success Insert Data", $data);
            } else {
                $this->_api(JSON_ERROR, "Insert Data Gagal");
            }
        }
    }

    public function update(){
        $nm = $this->post('nama_makanan');

        $lokasi   = './assets/upload/Makanan/';

        $nama = $this->m_cust->get($this->post("id_makanan"));
        $flold = "";
        if(isset($nama[0])){
            $flold = $lokasi.$nama[0]->nama_makanan.'.png';
        }
        $flnew = $lokasi.$nm.'.png';

        $data = array(                        
            'nama_makanan'      => $this->post('nama_makanan'),
            'jenis'             => $this->post('jenis'),
            'kkal'              => $this->post('kkal'),
            'karbo'             => $this->post('karbo'),
            'protein'           => $this->post('protein'),
            'lemak'             => $this->post('lemak'),            
            'keterangan'        => $this->post('keterangan'),
        );

        $update = $this->m_cust->update($data, $this->post("id_makanan"));
        if ($update) {
            if(file_exists($flold) && !empty($flold)){
                rename($flold, $flnew);
            }
            if (isset($_FILES["foto"]) && $_FILES["foto"] != NULL) {
                $config = array();
                $config['max_size'] = '3072';
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['overwrite']     = TRUE; 
                $config['upload_path']   = './assets/upload/Makanan/';
                $config['file_name']     = $nm.'.png';
                if (!file_exists($config["upload_path"])) {
                    mkdir($config["upload_path"]);
                }
                $this->load->library('upload');
                $this->upload->initialize($config);

                if (!$this->upload->do_upload("foto")) {
                    $this->_api(JSON_ERROR, "Insert Foto Gagal");
                    exit(0);
                }
            }
            $this->_api(JSON_SUCCESS, "Success Update Data");
        } else {
            $this->_api(JSON_ERROR, "Update Data Gagal");
        }
        }

    public function delete(){
        $delete = $this->m_cust->delete($this->post("id_makanan"));
        if ($delete) {
            $this->_api(JSON_SUCCESS, "Success Delete Data");
        } else {
            $this->_api(JSON_ERROR, "Delete Data Gagal");
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