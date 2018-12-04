<?php echo $header;?>
  <div class="signin-form">
    <form action="/Login/validaUser" name="login" method="POST" class="form">
        <h2>Sign In</h2>
        
        <?php echo $showmessage; ?>
        
        <div class="form-row">
            <label class="fontawesome-user" for="username"></label>
            <input id="username" type="text" placeholder="Enter Username" name="username" required>
        </div>

        <div class="form-row">
            <label class="fontawesome-key" for="password"></label>
            <input id="password" type="password" placeholder="Enter Password" name="password" required>
        </div>

        <div class="form-row">
            <span class="virtual-signin">
                <label style="background:#377dd2;" class="fontawesome-lock" for="signin">
                <span class="signin-label">Sign In</span>
            </span>
            <input type="submit" id="signin">
        </div>
    </form>
  </div>
<?php echo $footer;?>