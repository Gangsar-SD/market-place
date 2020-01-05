<?php
defined('BASEPATH') or exit('No direct script access allowed');

class  Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Menu_model');
    }
    public function index()
    {

        $data['tittle'] = "Menu Management";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        // echo $this->input->post('menu');
        // echo $this->session->userdata('role_id');
        // echo $this->session->userdata('email');
        // echo $this->session->userdata('id');
        // die;

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('template/user_header', $data);
            $this->load->view('template/user_sidebar', $data);
            $this->load->view('template/user_topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('template/user_footer');
        } else {
            $input = ['menu' => $this->input->post('menu')];

            $this->db->insert('user_menu', $input);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Menu has beed Added</div>');
            redirect('menu');
        }
    }

    public function subMenu()
    {
        $this->form_validation->set_rules('submenu', 'SubMenu', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
        $data['tittle'] = "Sub Menu Management";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->model('Menu_model');
        $data['subMenu'] = $this->Menu_model->getSubMenu();



        if ($this->form_validation->run() == false) {
            $this->load->view('template/user_header', $data);
            $this->load->view('template/user_sidebar', $data);
            $this->load->view('template/user_topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('template/user_footer');
        } else {
            $active = $this->input->post('is_active');
            $tittle = $this->input->post('submenu');
            if ($active == null) {
                $active = 0;
            }
            $data = [
                'tittle' => $tittle,
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $active
            ];
            // checking data existence
            $editedId = $this->input->post('id');
            if ($this->db->get_where('user_sub_menu', ['id' => $editedId])->num_rows() > 0) {
                $this->db->update('user_sub_menu', $data, ['id' => $editedId]);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sub Menu has beed Edited</div>');
                redirect('menu/submenu');
            } else {

                $this->db->insert('user_sub_menu', $data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Sub Menu has beed Added</div>');
                redirect('menu/submenu');
            }
        }
    }
    public function deleteMenu($id)
    {

        $this->Menu_model->deleteDataById('user_menu', $id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has beed deleted</div>');
        redirect('menu');
    }

    public function deleteSubMenu($id)
    {
        $this->Menu_model->deleteDataById('user_sub_menu', $id);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sub Menu has beed deleted</div>');
        redirect('menu/submenu');
    }
}
