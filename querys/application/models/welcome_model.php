<?php

	class Welcome_model extends CI_model{

		public function __construct(){
			parent::__construct();
		}

		public function get($rows = null, $order = "ASC"){
			//Query realizado con joins para juntar las tres tablas a través de las llaves foráneas
			//Se ordena de manera ascendente y por el user_id de la tabla picks
			$this->db->order_by('picks.user_id', 'ASC');
			$this->db->select('*');
			$this->db->from('entries');
			$this->db->join('picks','picks.user_id = entries.user_id');
			$this->db->join('fixtures','picks.fixture_id = fixtures.id');
			$query = $this->db->get()->result();

			//Se mandan los resultados al controlador cuando este los solicite mediante la variable $query
			return $query;
		}

	}
?>