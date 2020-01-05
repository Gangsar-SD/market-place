<?php
defined('BASEPATH') or exit('No direct script access allowed');

class  Market extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Menu_model');
        $this->form_validation->set_rules('submenu', 'SubMenu', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
    }
    public function index()
    {

        $config['base_url'] = 'http://geesde.xyz/market/index';
        $config['total_rows'] = $this->Menu_model->getCountItem();
        $config['per_page'] = 6;

        $data['start'] = $this->uri->segment(3, 0);
        $this->pagination->initialize($config);

        $data['cbanner'] = $this->db->get('banner')->num_rows() - 1;
        $data['banner'] = $this->db->get('banner')->result_array();

        if ($this->session->userdata('email') != null) {
            $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        } else {
            $user = null;
        }
        // var_dump($data['banner']);
        // die;
        $data['user'] = $user;
        $data['tittle'] = "Market";
        $data['item'] = $this->Menu_model->getMarketItem($data['start'], $config['per_page']);
        $data['kategori'] = $this->db->get('list_kategori')->result_array();



        $this->load->view('template/menu_header', $data);
        $this->load->view('template/menu_topbar', $data);
        $this->load->view('market', $data);
        $this->load->view('template/menu_footer', $data);
    }

    public function kategori()
    {
        $id = $this->uri->segment(3);
        $data['start'] =  $this->uri->segment(4, 0);

        $config['base_url'] = 'http://geesde.xyz/market/kategori/' . $id;
        $config['total_rows'] = $this->Menu_model->getCountItemByCategory($id);
        $config['per_page'] = 8;

        if ($this->session->userdata('email') != null) {
            $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        } else {
            $user = null;
        }

        $data['user'] = $user;



        $this->pagination->initialize($config);
        $data['kategori'] = $this->db->get_where('list_kategori', ['id' => $id])->row_array();
        $data['tittle'] = $data['kategori']['kategori'];
        $data['sidebar'] = $this->db->get('list_kategori')->result_array();
        $data['item'] = $this->Menu_model->getMarketItemByCategory($id, $data['start'], $config['per_page']);

        if ($data['item'] == null) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sorry, no item found</div>');
        }

        $this->load->view('template/menu_header', $data);
        $this->load->view('template/menu_topbar', $data);
        $this->load->view('market-kategori', $data);
        $this->load->view('template/menu_footer', $data);
    }

    public function detailItem()
    {
        $id = $this->input->get('id');
        $data['item'] = $this->Menu_model->getInventoryByID($id);

        if ($this->session->userdata('email') != null) {
            $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        } else {
            $user = null;
        }

        $data['user'] = $user;
        $this->load->view('template/menu_header', $data);
        $this->load->view('template/menu_topbar', $data);
        $this->load->view('detail-item', $data);
        $this->load->view('template/menu_footer', $data);
    }
}
