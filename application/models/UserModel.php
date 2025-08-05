<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    // Retorna todos os usuários
    public function get_all() {
        $query = $this->db->get('users');
        return $query->result();
    }

    // Retorna um único usuário por ID
    public function get_by_id($id) {
        $query = $this->db->get_where('users', array('id' => $id));
        return $query->row();
    }

    // Cria um novo usuário
    public function create($data) {
        // Criptografa a senha antes de salvar
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    // Atualiza um usuário existente
    public function update($id, $data) {
        // Criptografa a senha se ela for fornecida
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();
    }

    // Deleta um usuário
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');
        return $this->db->affected_rows();
    }
}