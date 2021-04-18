<form method="post" action="/user/login">
  <div>
    <label for="login">Login</label>
    <input 
      id="login"
      type="text" 
      name="login" 
      placeholder="login"
    >
  </div>
  <div>
    <label for="password">Password</label>
    <input 
      id="password"
      type="password" 
      name="password" 
      placeholder="password"
    >
  </div>
  <div>
    <?=$this->component('button', ['title' => 'Login'])?>
  </div>
</form>

<p>
  Don't have an account? <a href="/user/signup">Signup</a>
</p>