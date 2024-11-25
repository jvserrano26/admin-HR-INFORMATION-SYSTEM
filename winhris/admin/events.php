<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Under Maintenance</title>
  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Arial', sans-serif;
      background: linear-gradient(135deg, #1a73e8, #34a853); /* Iconnect Colors */
      color: #ffffff;
      text-align: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .container {
      max-width: 500px;
      background: rgba(0, 0, 0, 0.5);
      padding: 30px 20px;
      border-radius: 15px;
      box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.6);
    }
    .icon {
      font-size: 100px;
      color: #ffd700; /* Yellow for construction */
      margin-bottom: 20px;
      animation: bounce 2s infinite ease-in-out;
    }
    @keyframes bounce {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-15px);
      }
    }
    h1 {
      font-size: 32px;
      margin-bottom: 10px;
    }
    p {
      font-size: 18px;
      line-height: 1.6;
    }
    .contact-link {
      color: #ffd700;
      text-decoration: none;
      font-weight: bold;
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      border: 2px solid #ffd700;
      border-radius: 25px;
      transition: background 0.3s, color 0.3s;
    }
    .contact-link:hover {
      background: #ffd700;
      color: #000000;
    }
  </style>
  <!-- Font Awesome for Icons -->
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <div class="icon">
      <i class="fas fa-hard-hat"></i> <!-- Construction-themed icon -->
    </div>
    <h1>Under Maintenance</h1>
    <p>
      Our website is currently under maintenance. We're making some improvements to serve you better.<br>
      Please check back soon. For urgent inquiries, contact us at 
      <a href="https://gitlab.com/rainzkiem" class="contact-link">https://gitlab.com/rainzkiem</a>.
    </p>
    <a href="http://localhost/winhris/admin/home.php" class="contact-link">Return to Home</a><a
  </div>
</body>
</html>
