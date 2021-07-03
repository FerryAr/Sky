<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thread extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('thread_model');
        $this->load->model('pelajaran_model');
        $this->load->model('reply_model');
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper('url');
    }
    public function index() {
        $page = 1;
        $keyword = '';

        $perPage = 20;

        $limit = $perPage;
        $offset = ($page-1)*$perPage;
        if ($this->input->get('page')) {
            $page = $this->input->post('page');
        }
        if ($this->input->post('keyword')) {
            $keyword = $this->input->post('keyword');
        }
        $thread = $this->thread_model->getThread($page, $keyword, $limit, $offset);

        $data = array (
            'threads' => $thread,
            'page' => $page,
            'perPage' => $perPage,
            'offset' => $offset,
            'keyword' => $keyword,
            'layout' => $this->load->view('layout', NULL, TRUE),
        );
        $this->load->view('thread/thread_index', $data);
    }
    public function view() {
        $id = $this->uri->segment(3);

        $thread = $this->thread_model->findThreadById($id);
        $pelajaran = $this->pelajaran_model->findPelById($thread->id_pelajaran);
        $user = $this->ion_auth->users($thread->created_by)->result();
        $reply = $this->reply_model->getReply($id);

        $data = array (
            'thread' => $thread,
            'pelajaran' => $pelajaran,
            'user' => $user,
            'reply' => $reply,
            'layout' => $this->load->view('layout', NULL, TRUE),
        );
        $this->load->view('thread/thread_view', $data);
    }
    public function create() {
        if ($this->input->post()) {
            $judul = $this->input->post('judul', TRUE);
            $id_pelajaran = $this->input->post('id_pelajaran', TRUE);
            $isi = $this->input->post('isi', TRUE);
            $created_by = $this->ion_auth->get_user_id();
            $created_at = date('Y-m-d H:i:s');
            $this->thread_model->createThread($judul, $isi, $id_pelajaran, $created_by, $created_at);
            $id = $this->db->insert_id();

            return redirect(base_url('index.php/thread/view/'.$id));
        }
        $pelajaran = $this->pelajaran_model->showPel();
        foreach($pelajaran as $p) {
            $arrayPel[$p->id] = $p->pelajaran;
        }
        $data = array (
            'layout' => $this->load->view('layout', NULL, TRUE),
            'arrayPel' => $arrayPel,
        );
        $this->load->view('thread/thread_create', $data);
    }
}