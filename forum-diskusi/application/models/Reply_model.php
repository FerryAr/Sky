<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reply_model extends CI_Model {
    public function getReply($id) {
        $query = $this->db->select('reply.id, reply.isi, reply.created_at, users.first_name, users.avatar ')
                ->from('reply')
                ->join('users', 'users.id = reply.id_user', 'left')
                ->where('id_thread', $id)
                ->get()
                ->result();
        return $query;
    }
}