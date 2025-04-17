<?php
$conn = new mysqli('localhost', 'root', '', 'plantpal');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$plantName = 'Carex saxatilis';
$sql = "SELECT * FROM plantinfo WHERE AccSpeciesName = '$plantName' LIMIT 1";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data for $plantName</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
            padding-top: 100px;
            color: #333;
        }

        .header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 50px;
            z-index: 1000;
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
            color: #4caf50;
            text-decoration: none;
        }

        .header .logo i {
            margin-right: 8px;
            color: #0b3d0b;
        }

        .navbar a {
            margin: 0 15px;
            color: #4caf50;
            font-size: 18px;
            text-decoration: none;
        }

        .signin-btn {
            background: #0b3d0b;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            text-decoration: none;
            margin-right: 15px;
        }

        .icons {
            display: flex;
            align-items: center;
        }

        .icons .fas {
            background: #0b3d0b;
            color: #a0d6a0;
            padding: 12px;
            margin-left: 10px;
            border-radius: 10px;
            cursor: pointer;
        }

        h2 {
            color: #2e7d32;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f0f0f0;
        }

        .no-data {
            color: red;
            font-weight: bold;
        }

        .footer {
            background-color: #fff;
            padding: 50px 5%;
            width: 100%;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
            margin-top: 50px;
        }

        .footer .box-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
        }

        .footer .box {
            flex: 1 1 200px;
            min-width: 220px;
        }

        .footer .box h3 {
            font-size: 22px;
            color: #4caf50;
            margin-bottom: 15px;
        }

        .footer .box a {
            display: block;
            color: #0b3d0b;
            margin: 6px 0;
            text-decoration: none;
        }

        .footer .box a i {
            margin-right: 8px;
        }

        .footer .box p {
            color: #0b3d0b;
            line-height: 1.6;
        }

        body.dark-mode {
            background-color: #1e1e1e;
            color: #ddd;
        }

        body.dark-mode .footer {
            background-color: #121212;
        }

        body.dark-mode .footer .box h3,
        body.dark-mode .footer .box a,
        body.dark-mode .footer .box p {
            color: #ccc;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer .box.slide-up {
            animation: slideUp 1s ease-out forwards;
            opacity: 0;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px 20px;
            }

            .navbar {
                margin: 10px 0;
            }

            .icons {
                margin-top: 10px;
            }

            .footer .box-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="header">
  <a href="#" class="logo"> <i class="fas fa-user"></i> PlantPal </a>
  <nav class="navbar">
    <a href="welcome.html">Home</a>
    <a href="plan.html">Plan</a>
    <a href="contact.html">Contact</a>
  </nav>
  <a href="index.html" class="signin-btn">SIGN OUT</a>
  <div class="icons">
    <div class="fas fa-moon" id="theme-btn"></div>
  </div>
</header>

<div style="padding: 30px;">
<h2>Data for '$plantName'</h2>
<?php
if ($result && $result->num_rows > 0) {
    echo "<table><tr>";
    while ($field = $result->fetch_field()) {
        echo "<th>{$field->name}</th>";
    }
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='no-data'>No data found for this plant.</p>";
}
$conn->close();
?>
</div>

<!-- Footer -->
<section class="footer">
  <div class="box-container">
    <div class="box slide-up">
      <h3> <i class="fas fa-user"></i> PlantPal </h3>
      <p>PlantPal is a web-based platform designed to help plant enthusiasts and gardeners manage their plants effectively. It provides personalized care schedules, reminders for watering, fertilizing, repotting, and other plant care activities.</p>
    </div>
    <div class="box slide-up">
      <h3>Our Services</h3>
      <a href="#"><i class="fas fa-chevron-right"></i> Watering reminders</a>
      <a href="#"><i class="fas fa-chevron-right"></i> Fertilizing reminders</a>
      <a href="#"><i class="fas fa-chevron-right"></i> Repotting reminders</a>
      <a href="#"><i class="fas fa-chevron-right"></i> Disease identification</a>
    </div>
    <div class="box slide-up">
      <h3>Contact Us</h3>
      <a href="#"><i class="fas fa-phone"></i> +91 87794 74881</a>
      <a href="#"><i class="fas fa-phone"></i> +91 96191 88892</a>
      <a href="#"><i class="fas fa-envelope"></i> info@plantpal.com</a>
      <a href="#"><i class="fas fa-map"></i> 123 Main St, Mumbai India</a>
    </div>
    <div class="box slide-up">
      <h3>Follow Us</h3>
      <a href="#"> <i class="fab fa-facebook-f"></i> Facebook </a>
      <a href="#"> <i class="fab fa-twitter"></i> Twitter </a>
      <a href="#"> <i class="fab fa-instagram"></i> Instagram </a>
      <a href="#"> <i class="fab fa-pinterest"></i> Pinterest </a>
    </div>
  </div>
</section>

<script>
  const themeBtn = document.getElementById('theme-btn');
  themeBtn.onclick = () => {
    document.body.classList.toggle('dark-mode');
  };

  window.addEventListener('load', () => {
    document.querySelectorAll('.footer .box').forEach((box, i) => {
      setTimeout(() => {
        box.classList.add('slide-up');
      }, i * 150);
    });
  });
</script>

</body>
</html>