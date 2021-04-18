<header class="header">
    <div class="header__cell">
        <a href="/">Main Page</a>
    </div>
    <div class="header__cell">
        <?php if ($this->isAuth()): ?>
            <span>Hello, <?=$this->getUser()['name']?></span>
            <a href="/user/logout">Logout</a>
        <?php else: ?>
            <a href="/user/login">Login</a>
            <a href="/user/signup">Signup</a>
        <?php endif; ?>
    </div>
</header>