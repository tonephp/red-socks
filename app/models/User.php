<?php

namespace app\models;

use core\base\Model;

class User extends Model {

  public $table = 'user';

  public $attributes = [
    'login' => '',
    'password' => '',
    'email' => '',
    'name' => '',
    'role' => 'user'
  ];
  
  public $rules = [
    'required' => [
      ['login'],
      ['password'],
      ['email'],
      ['name'],
    ],
    'email' => [
      ['email'],
    ],
    'lengthMin' => [
      ['password', 6],
    ]
  ];

  public function checkUnique() {
    $sql = "SELECT login, email FROM $this->table WHERE login = ? OR email = ?";
    $candidateLogin = $this->attributes['login'];
    $candidateEmail = $this->attributes['email'];
    $user = $this->db->query($sql, [$candidateLogin, $candidateEmail]);

    if ($user) {
      $user = $user[0];
      if ($user['login'] === $candidateLogin) {
        $this->errors['unique'][] = "Логин $candidateLogin уже занят";
      }
      if ($user['email'] === $candidateEmail) {
        $this->errors['unique'][] = "Email $candidateEmail уже занят";
      }
      return false;
    }
    return true;
  }

  public function login() {
    $login = trim($_POST['login']) ?? null;
    $password = trim($_POST['password']) ?? null;

    if ($login && $password) {
      
      $sql = "SELECT * FROM $this->table WHERE login = ?";
      
      $users = $this->db->query($sql, [$login]);

      if ($users) {
        $user = $users[0];
        if (password_verify($password, $user['password'])) {

          foreach ($user as $key => $value) {
            if ($key !== 'password' && $key !== 'id') {
              $_SESSION['user'][$key] = $value;
            }
          }

          return true;
        }
      }
    }

    return false;
  }

  public static function isAdmin() {
    return (
      isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'
    );
  }
}