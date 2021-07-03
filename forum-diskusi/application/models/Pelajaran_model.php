<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelajaran_model extends CI_Model {
    public function findPelById($id_pelajaran) {
        $query = $this->db->select('*')
                ->from('pelajaran')
                ->where('id', $id_pelajaran)
                ->get()->row();
        return $query;
    }
    public function showPel() {
        $query = $this->db->select('*')
                ->from('pelajaran')
                ->get()->result();
        return $query;
    }
}