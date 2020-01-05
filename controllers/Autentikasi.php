<?php
defined('BASEPATH') or exit('No direct script access allowed');

class  Autentikasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('cookie');
    }
    public function index()
    {

        $user_agent = $this->agent->agent_string();
        $cookie = $this->input->cookie('cookie');
        if ($cookie != null) {
            check_cookie($cookie, $user_agent);
        }

        if ($this->session->userdata('email')) {
            redirect('user');
        }
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'valid_email' => 'Email tidak Valid'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {

            $this->load->view('template/a_header');
            $this->load->view('autentikasi/login');
            $this->load->view('template/a_footer');
        } else {

            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        // user ada
        if ($user) {
            //user active
            if ($user['is_active'] == 1) {
                //password benar dan bisa login
                if (password_verify($password, $user['password'])) {
                    if ($this->input->post('remember_me')) {
                        if (get_cookie('cookie') == null) {
                            $token_cookie = base64_encode(random_bytes(32));
                            $cookie = array(
                                'name'   => 'cookie',
                                'value'  => $token_cookie,
                                'expire' => '2592000',
                                'path' => '/'
                            );
                            set_cookie($cookie);
                        }
                        $user_agent = $this->agent->agent_string();
                        $input = [
                            'email' => $email,
                            'token' => $token_cookie,
                            'user_agent' => $user_agent,
                            'date_created' => time()
                        ];
                        $this->db->insert('remember_me', $input);
                    }


                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],
                        'id_user' => $user['id']
                    ];
                    $this->session->set_userdata($data);


                    if ($user['role_id'] == 1) {

                        redirect('administrator');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!!</div>');
                    redirect('autentikasi');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please activate your email</div>');
                redirect('autentikasi');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email is not registered!</div>');
            redirect('autentikasi');
        }
    }
    public function regist()
    {


        if ($this->session->userdata('email')) {
            redirect('user');
        }
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has beed registered!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => "Password didn't match!",
            'min_length' => 'Password too short! Minimum length is 3 character.'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/a_header');
            $this->load->view('autentikasi/registrasi');
            $this->load->view('template/a_footer');
        } else {
            $data = [
                'name' => $this->input->post('name', true),
                'email' => $this->input->post('email', true),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1', true), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()

            ];

            $token = base64_encode(random_bytes(32));

            $user_token = [
                'email' => $this->input->post('email', true),
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Your account has been created, please chock your email (spam also) to active yout account.</div>');
            redirect('autentikasi');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'sendmail',
            'smtp_host' => 'mail.geesde.xyz',
            'smtp_user' => 'verification@geesde.xyz',
            'smtp_pass' => 'gangsar123',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from('verification@geesde.xyz', 'Gangsar Salatsa Dewantara');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {

            $this->email->subject('Account Verification');
            $this->email->message('Click thi lick to verify your account : <a href="' . base_url('autentikasi/verify') . '?email=' . $this->input->post('email') . '&token=' . urlencode($token)  . '">Activate</a>');
        } else if ($type == 'forgotpass') {
            $this->email->subject('Reset Password');
            $this->email->message('Click thi lick to reset your password : <a href="' . base_url('autentikasi/resetpassword') . '?email=' . $this->input->post('email') . '&token=' . urlencode($token)  . '">Reset</a>');
        }


        if ($this->email->send()) {
            return true;
            die;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {

                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    // tidak lebih dari 1 hari

                    $this->db->update('user', ['is_active' => 1], ['email' => $email]);

                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    ' . $email . 'Has been Activated! Please Login to proceed. </div>');
                    redirect('autentikasi');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    redirect('autentikasi');
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Account Activation Failed. Token expired, Please register account!</div>');
                    redirect('autentikasi');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Account Activation Failed. Invalid token!</div>');
                redirect('autentikasi');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Account Activation Failed. Email didnot exist</div>');
            redirect('autentikasi');
        }
    }

    public function logout()
    {

        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('id_user');
        $this->db->delete('remember_me', ['token' => $this->input->cookie('cookie')]);
        delete_cookie('cookie');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Your account has been logged out.</div>');
        redirect('autentikasi');
    }

    public function blocked()
    {
        $this->load->view('template/blocked');
    }

    public function forgotpassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {

            $data['tittle'] = 'Forgot Password';
            $this->load->view('template/a_header');
            $this->load->view('autentikasi/forgotpassword');
            $this->load->view('template/a_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', [
                'email' => $email,
                'is_active' => 1
            ])->row_array();
            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgotpass');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset password</div>');
                redirect('autentikasi/forgotpassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Email is not registered or activated</div>');
                redirect('autentikasi/forgotpassword');
            }
        }
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user_token', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                //check kadaluarsa token
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->session->set_userdata('reset_email', $email);
                    $this->changePassword();
                } else {
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                        token Expired! Please input your email to reset</div>');
                    redirect('autentikasi/forgotpassword');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Unable to reset Password, Wrong token!</div>');
                redirect('autentikasi');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Unable to reset Password, Wrong Email!</div>');
            redirect('autentikasi');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('autentikasi');
        }
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => "Password didn't match!",
            'min_length' => 'Password too short! Minimum length is 3 character.'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');


        if ($this->form_validation->run() == false) {

            $data['tittle'] = 'Forgot Password';
            $this->load->view('template/a_header');
            $this->load->view('autentikasi/changepassword');
            $this->load->view('template/a_footer');
        } else {

            $password_hashed = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');
            $this->db->delete('user_token', ['email' => $email]);

            $this->db->update('user', ['password' => $password_hashed], ['email' => $email]);
            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Password has been changed, Please login!</div>');
            redirect('autentikasi');
        }
    }
}
