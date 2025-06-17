<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/');
        }

        if ($this->request->getMethod() === 'POST') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $this->userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                if (!$user['is_active']) {
                    return redirect()->back()->with('error', 'Akun Anda tidak aktif');
                }

                $this->session->set([
                    'user_id' => $user['id'],
                    'user_name' => $user['name'],
                    'user_email' => $user['email'],
                    'user_role' => $user['role'],
                    'is_logged_in' => true,
                ]);

                return redirect()->to('/')->with('success', 'Login berhasil');
            }

            return redirect()->back()->with('error', 'Email atau password salah');
        }

        return view('auth/login');
    }

    public function register()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('/');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ];

            $passwordConfirm = $this->request->getPost('password_confirm');
            
            if ($data['password'] !== $passwordConfirm) {
                return redirect()->back()->with('error', 'Konfirmasi password tidak cocok')->withInput();
            }

            if ($this->userModel->insert($data)) {
                return redirect()->to('/login')->with('success', 'Registrasi berhasil, silakan login');
            }

            return redirect()->back()->with('errors', $this->userModel->errors())->withInput();
        }

        return view('auth/register');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/')->with('success', 'Logout berhasil');
    }

    public function profile()
    {
        $authCheck = $this->requireAuth();
        if ($authCheck) return $authCheck;

        $user = $this->getCurrentUser();
        $stats = $this->userModel->getUserStats($user['id']);

        return view('auth/profile', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }

    public function updateProfile()
    {
        $authCheck = $this->requireAuth();
        if ($authCheck) return $authCheck;

        $userId = $this->session->get('user_id');
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        if ($this->userModel->update($userId, $data)) {
            $this->session->set('user_name', $data['name']);
            $this->session->set('user_email', $data['email']);
            return redirect()->back()->with('success', 'Profil berhasil diperbarui');
        }

        return redirect()->back()->with('errors', $this->userModel->errors());
    }

    public function changePassword()
    {
        $authCheck = $this->requireAuth();
        if ($authCheck) return $authCheck;

        $userId = $this->session->get('user_id');
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        $user = $this->userModel->find($userId);

        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password lama tidak benar');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password baru tidak cocok');
        }

        if (strlen($newPassword) < 6) {
            return redirect()->back()->with('error', 'Password baru minimal 6 karakter');
        }

        if ($this->userModel->update($userId, ['password' => $newPassword])) {
            return redirect()->back()->with('success', 'Password berhasil diubah');
        }

        return redirect()->back()->with('error', 'Gagal mengubah password');
    }
}