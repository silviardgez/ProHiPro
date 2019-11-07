<head><link rel="stylesheet" href="../CSS/login.css" /></head>
<div class="sidenav">
         <div class="login-main-text">
            <h2>TEC<br> Teaching Execution Control</h2>
         </div>
      </div>
      <div class="main">
         <div class="col-md-7 col-sm-12">
            <div class="login-form">
               <form action='../Controllers/LoginController.php' method="post">
                  <div class="form-group">
                     <label>Login</label>
                     <input type="text" class="form-control" name="login" placeholder="Login">
                  </div>
                  <div class="form-group">
                     <label>Contraseña</label>
                     <input type="password" class="form-control" name="password" placeholder="Contraseña">
                  </div>
                  <button type="submit" name="action" value="login-user" class="btn btn-black">Login</button>
               </form>
            </div>
         </div>
      </div>
