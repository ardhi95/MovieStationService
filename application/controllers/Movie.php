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

    public function getMovieTic()
    {
        $movie_code =   $this->post('id_bioskop');
        /*$movie_code = "BS001";*/
        $movie = $this->m_movie->get_movie_tic($movie_code);
        $res = array();
        foreach ($movie->result() as $key) {
            $res[] = array( 
                "nama_film"     => $key->nama_film,
                "harga"         => $key->harga,
                "id_bioskop"    => $key->id_bioskop,
                "id_movie"      => $key->id_movie,
                "id_jadwal"    => $key->id_jadwal
                );
        }
        $this->_api(JSON_SUCCESS, "Success Get Data saldo", $res);    }

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