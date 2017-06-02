<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends MY_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model("Table_Ticket", "m_ticket");
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

    public function getTicketCust()
    {
        $cust_id = $this->post('id_customer');
        $ticket = $this->m_ticket->getTicket($cust_id);
        $res = array();
        foreach ($ticket->result() as $key) {
            $res[] = array(
                'id_pembelian'    => $key->id_pembelian,
                'id_jadwal'       => $key->id_jadwal,
                'id_customer'     => $key->id_customer,
                'id_bioskop'      => $key->id_bioskop,
                'id_kursi'        => $key->id_kursi,
                'kursi'           => $key->kursi,
                'tgl_beli'        => $key->tgl_beli,
                'jml_uang'        => $key->jml_uang,
                'status'          => $key->status
                );
        }
        $this->_api(JSON_SUCCESS, "Success Get Data", $res);
    }

    public function checkTiket()
    {
        $jadwalID = $this->post('id_jadwal');
        $chck = $this->m_ticket->checkTikeKursi($jadwalID);
        $res = array();
        foreach ($chck->result() as $key) {
            $res[] = array(
                'id_kursi'    => $key->id_kursi
                );
        }
        $this->_api(JSON_SUCCESS, "Success Get Data", $res);
    }

    public function addTicket()
    {

        $data = array(
                'id_pembelian'    => "",
                'id_jadwal'       => $this->post('id_jadwal'),
                'id_customer'     => $this->post('id_customer'),
                'id_bioskop'      => $this->post('id_bioskop'),
                'id_kursi'        => $this->post('id_kursi'),
                'kursi'           => $this->post('kursi'),
                'tgl_beli'        => $this->post('tgl_beli'),
                'jml_uang'        => $this->post('jml_uang'),
                'status'          => "0"
                );
            
                $insert = $this->m_ticket->insert($data);
                if ($insert) {
                    $getSaldoCs = $this->db->query('SELECT saldo FROM customer WHERE id_customer="'.$data['id_customer'].'"')->row();
                    /*$getSaldoBs = $this->db->query('SELECT manager_register.saldo FROM manager_register INNER JOIN bioskop ON manager_register.id = bioskop.id_manager WHERE bioskop.id_bioskop ="'.$data['id_bioskop'].'"')->row();
                    $getIdM = $this->db->query('SELECT manager_register.id FROM manager_register INNER JOIN bioskop ON manager_register.id = bioskop.id_manager WHERE bioskop.id_bioskop = "'.$data['id_bioskop'].'"')->row();*/

                    if (is_object($getSaldoCs)) {
                        $upsaldo = ($getSaldoCs->saldo) - ($data['jml_uang']);
                        $this->db->query('Update customer set saldo="'.$upsaldo.'" Where id_customer="'.$data['id_customer'].'"'); 
                    }
                    /*if (is_object($getSaldoBs)) {
                        $upsaldoB = ($getSaldoBs->saldo) + ($data['jml_uang']);
                        $this->db->query('UPDATE manager_register SET saldo="'.$upsaldoB.'" WHERE id="'.$getIdM.'"'); 
                    }*/
                    $this->_api(JSON_SUCCESS, "Success Add", $data);
                } else {
                    $this->_api(JSON_ERROR, "Failed Add");
                }
    }

}

/* End of file olahraga.php */
/* Location: ./application/controllers/olahraga.php */