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
        $tglbeli   = $this->post('tgl_beli');
        $chck = $this->m_ticket->checkTikeKursi($jadwalID, $tglbeli);
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
        $this->load->model("Table_Layanan", "m_lay");
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
                
                $sub = $this->post('sub_total');
        $dataBL = array(
                'id_trans'      => '',
                'id_jadwal'     => $this->post('id_jadwal'),
                'id_customer'   => $this->post('id_customer'),
                'id_bioskop'    => $this->post('id_bioskop'),
                'tgl_beli'      => $this->post('tgl_beli'),
                'biaya_layanan' => $this->post('biaya_layanan')
                );
                
                $this->m_lay->insert($dataBL);
                $insert = $this->m_ticket->insert($data);
                if ($insert) {
                    $getSaldoCs = $this->db->query('SELECT saldo FROM customer WHERE id_customer="'.$data['id_customer'].'"')->row();
                    $getSaldoBs = $this->db->query('SELECT manager_register.saldo FROM manager_register INNER JOIN bioskop ON manager_register.id = bioskop.id_manager WHERE bioskop.id_bioskop ="'.$data['id_bioskop'].'"')->row();

                    if (is_object($getSaldoCs)) {
                        $upsaldo = ($getSaldoCs->saldo) - ($data['jml_uang']);
                        $this->db->query('Update customer set saldo="'.$upsaldo.'" Where id_customer="'.$data['id_customer'].'"'); 
                    }
                    if (is_object($getSaldoBs)) {
                        $upsaldoB = ($getSaldoBs->saldo) + ($sub);
                        $this->db->query('UPDATE manager_register JOIN bioskop ON bioskop.id_manager = manager_register.id SET saldo="'.$upsaldoB.'" WHERE bioskop.id_bioskop="'.$data['id_bioskop'].'"'); 
                    }

                    $this->_api(JSON_SUCCESS, "Success Add", $data);
                } else {
                    $this->_api(JSON_ERROR, "Failed Add");
                }
    }

}

/* End of file olahraga.php */
/* Location: ./application/controllers/olahraga.php */