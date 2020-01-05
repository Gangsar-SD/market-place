<?php
defined('BASEPATH') or exit('No direct script access allowed');

class  User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Menu_model');
    }

    public function index()
    {


        $data['tittle'] = "My Profile";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('template/user_header', $data);
        $this->load->view('template/user_sidebar', $data);
        $this->load->view('template/user_topbar', $data);
        $this->load->view('user/member', $data);
        $this->load->view('template/user_footer');
    }

    public function editProfil()
    {
        $data['tittle'] = "Edit Profile";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Name', 'required|trim');

        if ($this->form_validation->run() == false) {

            $this->load->view('template/user_header', $data);
            $this->load->view('template/user_sidebar', $data);
            $this->load->view('template/user_topbar', $data);
            $this->load->view('user/editprofil', $data);
            $this->load->view('template/user_footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            $uploaded_image = $_FILES['image']['name'];

            if ($uploaded_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/img/user_img';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/user_img/' . $old_image);
                    }
                    $newImage = $this->upload->data('file_name');
                    $this->db->set('image', $newImage);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->update('user', ['name' => $name], ['email' => $email]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Menu has beed Added</div>');
            redirect('user');
        }
    }

    public function changePassword()
    {
        $this->form_validation->set_rules('current_password', 'Password', 'required|trim');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => "Password didn't match!",
            'min_length' => 'Password too short! Minimum length is 3 character.'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        $data['tittle'] = "Change Password";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        if ($this->form_validation->run() == false) {

            $this->load->view('template/user_header', $data);
            $this->load->view('template/user_sidebar', $data);
            $this->load->view('template/user_topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('template/user_footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('password1');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Wrong Current Password</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    New Password cannot be the same as Old Password</div>');
                    redirect('user/changepassword');
                } else {
                    //password siap diganti
                    $password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                    $this->db->update('user', ['password' => $password_hashed], ['email' => $data['user']['email']]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Password has been changed</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }

    public function deleteItem()
    {
        $deleted_id = $this->input->get('id');
        $id_user = $this->session->userdata('id_user');

        $user = $this->db->get_where('inventory', [
            'id' => $deleted_id,
            'id_user' => $id_user
        ])->num_rows();
        if ($user) {
            $deleted_inv = $this->db->get_where('inventory', ['id' => $deleted_id])->row_array();

            if ($deleted_inv['image'] != 'default.jpg') {
                unlink(FCPATH . 'assets/img/user_img/' . $deleted_inv['image']);
            }
            $this->db->delete('inventory', ['id' => $deleted_id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item has beed deleted</div>');
            redirect('user/inventory');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Item belongs to other user</div>');
            redirect('user/inventory');
        }
    }

    public function Inventory()
    {

        $email = $this->session->userdata('email');
        $id_user = $this->session->userdata('id_user');
        $role = $this->session->userdata('role_id');


        $data['tittle'] = "Inventory";
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();




        $this->form_validation->set_rules('item', 'Item', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

        $data['inventory'] = $this->Menu_model->getInventory($id_user);

        $data['kategori'] = $this->db->get('list_kategori')->result_array();


        if (!$this->form_validation->run()) {

            $this->load->view('template/user_header', $data);
            $this->load->view('template/user_sidebar', $data);
            $this->load->view('template/user_topbar', $data);
            $this->load->view('inventory', $data);
            $this->load->view('template/user_footer');
        } else {
            $edited_id = $this->input->post('id');
            $item = $this->input->post('item');
            $harga = $this->input->post('harga');
            $deskripsi = $this->input->post('deskripsi');
            $id_kategori = $this->input->post('id_kategori');
            $uploaded_image = $_FILES['image']['name'];


            if ($uploaded_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/img/user_img';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    if ($edited_id) {

                        $old = $this->menu_model->getInventoryByID($edited_id);
                        $old_image = $old['image'];
                        if ($old_image != 'default.jpg') {
                            unlink(FCPATH . 'assets/img/user_img/' . $old_image);
                        }
                    }

                    $newImage = $this->upload->data('file_name');
                    $finalimage = $newImage;
                } else {
                    echo $this->upload->display_errors();
                }
            } else {
                $finalimage = 'default.jpg';
            }

            $input = [
                'item' => $item,
                'id_kategori' => $id_kategori,
                'deskripsi' => $deskripsi,
                'harga' => $harga,
                'id_user' => $id_user,
                'image' => $finalimage
            ];

            if ($this->db->get_where('inventory', ['id' => $edited_id])->num_rows() > 0) {
                $this->db->update('inventory', $input, ['id' => $edited_id]);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item has beed Edited</div>');
                redirect('user/inventory');
            } else {
                $this->db->insert('inventory', $input);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item has beed added</div>');
                redirect('user/inventory');
            }
        }
    }



    public function deleteCheckedItem()
    {

        $deleted_id = $this->input->post('deleted_id');

        if ($deleted_id) {
            foreach ($deleted_id as $d) {
                $this->db->delete('inventory', ['id' => $d]);
            }
        } else {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">No rows selected</div>');
            redirect('user');
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item has been daleted</div>');
        redirect('user');
    }
}
