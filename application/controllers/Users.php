<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php'; 
use chriskacerguis\RestServer\REST_Controller;
use chriskacerguis\RestServer\Format;

class Users extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->library('form_validation');
    }

    // LISTAR TODOS OS USUÁRIOS (GET)
    public function index_get($id = null) {
        if ($id === null) {
            $users = $this->UserModel->get_all();
            if ($users) {
                $this->response($users, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Nenhum usuário encontrado.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $user = $this->UserModel->get_by_id($id);
            if ($user) {
                $this->response($user, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Usuário não encontrado.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    // CRIAR NOVO USUÁRIO (POST)
    public function index_post() {
        // Validação de entrada
        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules('name', 'Nome', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]|max_length[255]');
        $this->form_validation->set_rules('password', 'Senha', 'required|min_length[6]');

        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => false,
                'message' => validation_errors()
            ], REST_Controller::HTTP_BAD_REQUEST); // Tratamento de erro
        } else {
            $data = $this->post();
            $user_id = $this->UserModel->create($data);
            if ($user_id) {
                $this->response([
                    'status' => true,
                    'message' => 'Usuário criado com sucesso.',
                    'id' => $user_id
                ], REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Erro ao criar o usuário.'
                ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    // ATUALIZAR USUÁRIO (PUT)
    public function index_put($id) {
        if (!$id) {
            $this->response([
                'status' => false,
                'message' => 'ID do usuário não fornecido.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }

        // Validação de entrada
        $this->form_validation->set_data($this->put());
        $this->form_validation->set_rules('name', 'Nome', 'trim|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[users.email]|max_length[255]');
        $this->form_validation->set_rules('password', 'Senha', 'min_length[6]');

        if ($this->form_validation->run() === FALSE) {
            $this->response([
                'status' => false,
                'message' => validation_errors()
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $data = $this->put();
            $affected_rows = $this->UserModel->update($id, $data);
            if ($affected_rows > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Usuário atualizado com sucesso.'
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Nenhum usuário foi atualizado ou usuário não encontrado.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    // DELETAR USUÁRIO (DELETE)
    public function index_delete($id) {
        if (!$id) {
            $this->response([
                'status' => false,
                'message' => 'ID do usuário não fornecido.'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        
        $affected_rows = $this->UserModel->delete($id);
        if ($affected_rows > 0) {
            $this->response([
                'status' => true,
                'message' => 'Usuário deletado com sucesso.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Nenhum usuário foi deletado ou usuário não encontrado.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}