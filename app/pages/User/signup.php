<?=$this->component('form', [
  'title' => 'Signup page',
  'children' => [
    'file' => 'pages/User/parts/signup-form',
    'data' => [
      'login' => $login,
      'email' => $email,
      'name' => $name
    ]
  ]
])?>