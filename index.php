<?php
if(file_exists('install/install.php')){
?>
<head>
<title>Installation</title>
<style>
body{
width:100%;
display:grid;
justify-content: center;
justify:center;
}
.content{
  position:relative;
  width:500px;
  max-width:100%;
  text-align: center;
}
form{
  border:2px solid grey;
  border-radius:5px;
  padding:30px;
}
input{
  margin-bottom:10px;
}
h2{
  width:100%;
  padding:12px;
}
h3{
  width:100%;
  padding:12px;
}
h3{
  width:100%;
  padding:12px;
}

</style>
</head>

<body>
  <div class='content'>
    <h2>Welcome to the Installation Guide</h2>
    <h3>In order to get started with the setup you must enter the requested data</h3>
    <form action="install/install.php" method='POST'>

      DB Host:<br>
      <input type="text" name="DBhost"><br>
      DB Name:<br>
      <input type="text" name="DBname"><br>
      DB Username:<br>
      <input type="text" name="DBusername"><br>
      DB Password:<br>
      <input type="text" name="DBpassword"><br><br>
      <input type="submit" value="SETUP">
    </form>
    <h4>The setup might take several minutes, just be patient</h4>
    <p>Before starting remember the following things:</p>
    <ul>
     <li>index.php must be writable and executable</li>
     <li>install folder and all its content must be writable and executable</li>
     <li>includes/config.inc.php must be writable</li>
     <li>libs/smarty/templates_c must be writable</li>
    </ul>
  </div>
</body>
<?php
}
else{
  echo "Il file che stai cercando e' stato gia' cancellato.";
}
?>
