<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie extends MY_Controller {
	
	function __construct() {
        parent::__construct();
        $this->load->model("Table_Movie", "m_movie");
    }

	public function index()
	{
		if($this->_check_func($this)){
			$m = $this->method;
			$this->$m();
		}else{
			$this->_api(JSON_ERROR, "No Method ".$this->method." in Class Movie");
		}
	}
    public function getJadwalMovie()
    {
        $bioskop_code = $this->post('id_bioskop');
        $movie_code = $this->post('id_movie');

        $jadwal = $this->m_movie->getJadwal($bioskop_code, $movie_code);
        $res = array();
        foreach ($jadwal->result() as $key) {
                $res[] = array(
                    "id_jadwal"     => $key->id_jadwal,
                    "jam"           => $key->jam,
                    "type_theater"  => $key->type_theater,
                    "kuota"         => $key->kuota,
                    "tgl_mulai"     => $key->tgl_mulai,
                    "tgl_selesai"   => $key->tgl_selesai
                    );
        }
        $this->_api(JSON_SUCCESS, "Success Get Data Jadwal",$res);
    }

    public function getMovieTic()
    {
        $movie_code =   $this->post('id_bioskop');
        /*$movie_code = "BS001";*/
        $movie = $this->m_movie->get_movie_tic($movie_code);
        $res = array();
        foreach ($movie->result() as $key) {
            $res[] = array( 
                "id_movie"     => $key->id_movie,
                "id_jadwal"    => $key->id_jadwal,
                "id_bioskop"   => $key->id_bioskop,
                "Poster"       => $key->Poster,
                "Title"        => $key->Title,
                "type_theater" => $key->type_theater,
                "jam"          => $key->jam,
                "kuota"        => $key->kuota,
                "harga"        => $key->harga,
                "tgl_mulai"    => $key->tgl_mulai,
                "tgl_selesai"  => $key->tgl_selesai
                );
        }
        $this->_api(JSON_SUCCESS, "Success Get Data Tiket", $res);    }

	public function get_movie()
	{
		$movie_code =   $this->post('imdbID');
		if ($movie_code != "") {
            $movie = $this->m_movie->get($movie_code);
        }else{
            $movie = $this->m_movie->get();
        }
        $res = array();
        foreach ($movie as $key) {
            $res[] = array( 
                "imdbID"      	=> $key->imdbID,
                'Title'			=> $key->Title,
                'Production'	=> $key->Production,
                'Year'			=> $key->Year,
                'Released'		=> $key->Released,
                'Genre'			=> $key->Genre,
                'Director'		=> $key->Director,
                'Writer'		=> $key->Writer,
                'Actors'		=> $key->Actors,
                'Plot'			=> $key->Plot,
                'Language'		=> $key->Language,
                'Country'		=> $key->Country,
                'Poster'		=> $key->Poster
            );
        }
        $this->_api(JSON_SUCCESS, "Success Get Data Movie", $res);
	}
}
/* End of file Movie.php */
/* Location: ./application/controllers/Movie.php */