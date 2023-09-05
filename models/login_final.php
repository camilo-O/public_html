<div id="back">
  <div class="backRight"></div>
  <div class="backLeft"></div>
</div>
<div id="slideBox">
  <div class="topLayer">
    <div class="left">
      <div class="content">
        <h2>SER EMPRESAS</h2>
        <form action="controlers/submit.php" method="POST" name="empresas"  id="login_form">
          <?php
            if(isset($_COOKIE['error']) && isset($_COOKIE['Email']) && $_COOKIE['tipo']=='empresa'){
              $constructor->loginForm($_COOKIE['tipo'], $_COOKIE['Email'], $_COOKIE['error']);
            }else{
              $constructor->loginForm('empresa', '', '');
            }
          ?>
        </form>
        <button id="goLeft" class="off">Ir a candidatos</button>
      </div>
    </div>
    <div class="right">
      <div class="content">
        <h2>SER CANDIDATOS</h2>
        <form action="controlers/submit.php" method="POST" name="aplicantes" id="login_form">
          <?php
            if(isset($_COOKIE['error']) && isset($_COOKIE['tipo'])  &&$_COOKIE['tipo']=='aplicante'){
              $constructor->loginForm($_COOKIE['tipo'], $_COOKIE['Email']?$_COOKIE['Email']:'', $_COOKIE['error']);
            }else{
              $constructor->loginForm('aplicante', '', '');
            }
          ?>
        </form>
        <button id="goRight" class="off">Ir a empresas</button>
      </div>
    </div>
  </div>
</div>
<div class="volver">
  <button onclick="location.href='https://serenaccion.com.co';">VOLVER A INICIO</button>
</div>
<style>
  h6{
    color:#1453a0;
  }
  .volver{
    z-index: 1000;
    position: fixed;
    right: 45%;
    bottom: 50px;
    cursor: pointer;
}
</style>