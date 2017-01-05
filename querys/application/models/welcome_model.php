<?php

	class Welcome_model extends CI_model{

		public function __construct(){
			parent::__construct();
		}

		public function get($rows = null, $order = "ASC"){
			$this->db->order_by('picks.user_id', 'ASC');
			$this->db->select('*');
			$this->db->from('entries');
			$this->db->join('picks','picks.user_id = entries.user_id');
			$this->db->join('fixtures','picks.fixture_id = fixtures.id');
			$query = $this->db->get()->result();

			return $query;
		}

	}
?>