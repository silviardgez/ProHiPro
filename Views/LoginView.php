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
                     <label data-translate="Nombre de usuario"></label>
                     <input type="text" class="form-control" name="login" placeholder="Nombre de usuario">
                  </div>
                  <div class="form-group">
                     <label data-translate="Contraseña"></label>
                     <input type="password" class="form-control" name="password" placeholder="Contraseña">
                  </div>
                  <button type="submit" name="action" value="login-user" class="btn btn-black">
                      <p data-translate="Iniciar sesión"></p></button>
               </form>
            </div>
         </div>
      </div>
<script>
    translatePage(getCookie("language-selected"));
</script>
