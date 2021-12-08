<?php

namespace App\Controllers;

use App\Models\MnjPetugasModel;

class Auth extends BaseController
{
    protected $db;
    protected $petugas;
    protected $validation;
    public function __construct()
    {

        $this->db      = \Config\Database::connect();
        $this->petugas = new MnjPetugasModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        if (session()->get('logged_in') and session()->get('role') == 'admin') {
            return redirect()->to('admin/dashboard');
        } else if (session()->get('logged_in') and session()->get('role') == 'petugas') {
            return redirect()->to('petugas/dashboard');
        }

        $mnj_desa = $this->db->table('mnj_desa')->get()->getFirstRow('array');

        $data = [
            'desa' => $mnj_desa,
            'action' => base_url('login'),
        ];
        return view('auth/index', $data);
    }

    public function auth()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $this->petugas->where('email', $email)->first();

        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $session_data = [
                    'id_user'       => $data['id_user'],
                    'nama'     => $data['nama'],
                    'role'    => $data['role'],
                    'logged_in'     => TRUE
                ];
                session()->set($session_data);
                session()->setFlashdata('pesan', 'Berhasil login');

                if (session()->get('role') == 'admin') {
                    # code...
                    return redirect()->to('admin/dashboard');
                } else {
                    # code...
                    return redirect()->to('petugas/dashboard');
                }
            } else {
                session()->setFlashdata('error', 'Password salah !');
                return redirect()->to('auth')->withInput();
            }
        } else {
            session()->setFlashdata('error', 'Email tidak ditemukan !');
            return redirect()->to('auth')->withInput();
        }
    }


    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('pesan', 'Berhasil Logout !');
        return redirect()->to('/');
    }
}
