

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    	<link rel="stylesheet" href="admin.css">

</head>
<body>
    
<section class="bg-light p-3 p-md-4 p-xl-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-xxl-11">
          <div class="card border-light-subtle shadow-sm">
            <div class="row g-0 recuperarcontraseñacontenedor">
              <div class="col-12 col-md-6">
                <img class="img-fluid rounded-start w-100 h-100 object-fit-cover" loading="lazy" src="img/moren-hsu-VLaKsTkmVhk-unsplash4.jpg" alt="Welcome back you've been missed!">
              </div>
              <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                <div class="col-12 col-lg-11 col-xl-10">
                  <div class="card-body p-3 p-md-4 p-xl-5">
                    <div class="row">
                      <div class="col-12">
                        <div class="mb-5">

                            <div class="text-center mb-4 logorecuperarcontraseña">
                                <a href="login.html">
                                    <img class="logo" src="img/logo pio baroja circular.png" alt="Logo Ies Pio Baroja" width="65" height="65">
                                </a>
                            </div>
                            
                          <h2 class="h4 text-center">Recuperar Contraseña</h2>
                          <h3 class="fs-6 fw-normal text-secondary text-center m-0">Proporciona el email asociado a tu cuenta para recuperar tu contraseña.</h3>
                        </div>
                      </div>
                    </div>
                    <form action="userAccount.php" method="post">
                      <div class="row gy-3 overflow-hidden">
                        <div class="col-12">
                          <div class="form-floating mb-3">
                          <input type="password" name="password" placeholder="PASSWORD" required="">
                          <input type="password" name="confirm_password" placeholder="CONFIRM PASSWORD" required="">
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="d-grid">
                          <input type="hidden" name="fp_code" value=""/>
                          <input type="submit" name="resetSubmit" value="RESET PASSWORD">
                          </div>
                        </div>
                      </div>
                    </form>
                    <div class="row">
                      <div class="col-12">
                        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-center mt-5">
                          <a href="login.html" class="link-secondary text-center text-decoration-none">Login</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>



