<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      background-color: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      position: relative;
      width: 90%;
      max-width: 850px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 85vh;
      margin-top: -70px;
    }
    .form-container {
      padding: 40px;
      width: 100%;
      max-width: 400px;
      text-align: center;
    }
    img {
      max-width: 100%;
      height: auto;
    }
    .social-container {
      margin: 20px 0;
    }
    .social-container a {
      font-size: 20px;
      margin: 0 10px;
    }
    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgba(0, 0, 0, 0.7);
      color: #fff;
      transform: translateY(-100%);
      transition: transform 0.6s ease-in-out;
    }
    footer {
      width: 100%;
      text-align: center;
      padding: 10px 0;
      background-color: #333;
      color: #fff;
      position: fixed;
      bottom: 0;
      left: 0;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-container sign-in-container">
      <img src="img/lars_limpio.png" alt="LARS Logo" class="mb-4">
      <form method="POST" action="login.php">
        <h1 class="mb-4">Inicia sesión</h1>
        <div class="social-container mb-4">
          <a href="https://www.facebook.com/CorpSenk" class="social"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
          <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
        </div>
        <input type="email" class="form-control mb-3" name="email" placeholder="Email" required>
        <input type="password" class="form-control mb-3" name="password" placeholder="Contraseña" required>
        <input type="hidden" name="redirect" value="dashboard.php">
        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
      </form>
    </div>
  </div>

  <footer>
    <p>@Senk - Todos los derechos reservados &copy; 2024</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
