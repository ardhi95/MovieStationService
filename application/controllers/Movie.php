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