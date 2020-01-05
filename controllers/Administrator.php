<?php
defined('BASEPATH') or exit('No direct script access allowed');

class  Administrator extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {

        $data['tittle'] = "Dasboard";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('template/user_header', $data);
        $this->load->view('template/user_sidebar', $data);
        $this->load->view('template/user_topbar', $data);
        $this->load->view('user/admin', $data);
        $this->load->view('template/user_footer');
    }

    public function role()
    {

        $data['tittle'] = "Role";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('template/user_header', $data);
        $this->load->view('template/user_sidebar', $data);
        $this->load->view('template/user_topbar', $data);
        $this->load->view('user/role', $data);
        $this->load->view('template/user_footer');
    }

    public function roleAccess($role_id)
    {

        $data['tittle'] = "Role Access";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        // $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get_where('user_menu', ['id !=' => 1])->result_array();

        $this->load->view('template/user_header', $data);
        $this->load->view('template/user_sidebar', $data);
        $this->load->view('template/user_topbar', $data);
        $this->load->view('user/roleaccess', $data);
        $this->load->view('template/user_footer');
    }

    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access granted</div>');
        } else {
            $this->db->delete('user_access_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access dissmissed</div>');
        }
    }

    public function banner()
    {

        $data['tittle'] = "Banner";
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['banner'] = $this->db->get('banner')->result_array();

        $this->form_validation->set_rules('date', 'Date', 'required|trim');





        if ($this->form_validation->run() == false) {

            $this->load->view('template/user_header', $data);
            $this->load->view('template/user_sidebar', $data);
            $this->load->view('template/user_topbar', $data);
            $this->load->view('user/banner-management', $data);
            $this->load->view('template/user_footer');
        } else {
            $valid_date = $this->input->post('date');
            $unix = strtotime($valid_date);
            var_dump($valid_date);
            echo $unix;
            echo '<br>';
            echo time();
            die;
            $uploaded_image = $_FILES['image']['name'];

            if ($uploaded_image != null) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/img/slideshow';
                $this->load->library('upload', $config);


                if ($this->upload->do_upload('image')) {
                    $this->db->insert('banner', ['image' => $uploaded_image], ['valid_date' => $valid_date]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Menu has beed Added</div>');
                    redirect('administrator/banner');
                } else {
                    $message = $this->upload->display_errors();
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $message . '</div>');
                    redirect('administrator/banner');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please pick a banner</div>');
                redirect('administrator/banner');
            }
        }
    }

    public function deleteBanner()
    {
        $deleted_id = $this->input->get('id');
        $banner = $this->db->get_where('banner', ['id' => $deleted_id])->row_array();

        if ($banner) {

            unlink(FCPATH . 'assets/img/slideshow/' . $banner['image']);
            $this->db->delete('banner', ['id' => $deleted_id]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Banner has beed deleted</div>');
            redirect('administrator/banner');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Error, Cant delete Banner</div>');
            redirect('administrator/banner');
        }
    }

    public function category()
    {
        $email = $this->session->userdata('email');
        $id_user = $this->session->userdata('id');
        $data['tittle'] = "Category";
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['kategori'] = $this->db->get_where('list_kategori', ['id !=' => 9])->result_array();

        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        if (!$this->form_validation->run()) {

            $this->load->view('template/user_header', $data);
            $this->load->view('template/user_sidebar', $data);
            $this->load->view('template/user_topbar', $data);
            $this->load->view('kategori', $data);
            $this->load->view('template/user_footer');
        } else {
            $new_kategori = ucwords($this->input->post('kategori'));
            $edited_id = $this->input->post('id');
            $check_kategori = $this->db->get_where('list_kategori', ['kategori' => $new_kategori])->num_rows();
            if ($check_kategori) {
                $this->db->update('list_kategori', ['kategori' => $new_kategori], ['id' => $edited_id]);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Category has beed edited</div>');
                redirect('administrator/category');
            } else {

                $this->db->insert('list_kategori', ['kategori' => $new_kategori]);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New category has beed added</div>');
                redirect('administrator/category');
            }
        }
    }

    public function deleteCheckedCat()
    {

        $deleted_id = $this->input->post('deleted_id');

        if ($deleted_id) {
            foreach ($deleted_id as $d) {
                $this->db->delete('list_kategori', ['id' => $d]);
                $this->db->update('inventory', ['id_kategori' => 9], ['id_kategori' => $d]);
            }
        } else {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">No rows selected</div>');
            redirect('administrator/category');
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Category has been deleted, and become General item</div>');
        redirect('administrator/category');
    }

    public function deleteCat()
    {
        $deleted_id = $this->input->get('id');

        $this->db->update('inventory', ['id_kategori' => 9], ['id_kategori' => $deleted_id]);
        $this->db->delete('list_kategori', ['id' => $deleted_id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Category has been deleted, and become General item</div>');
        redirect('administrator/category');
    }
}
