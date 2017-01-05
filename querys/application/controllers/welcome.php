<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){

		parent::__construct();

		//Se conecta el controlador la base de datos
		$this->load->database();
		//Se carga el helper de las url's para evitar problemas de con las url's
		$this->load->helper('url');
		$this->load->model('welcome_model','my_model');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//Se realiza la llamada al método get() declarado en el modelo para guardar los campos de las tablas
		//La variable $data que contiene un arreglo con todos los campos.
		$data['results'] = $this->my_model->get();
		//Se carga la vista enviando la variable $data para en la vista mostrar los resultados de la consulta
		echo $this->load->view('welcome_message', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */