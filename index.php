<?php
if(file_exists('install.php')){
?>
<head>
<title>Installation</title>
<style>
body{
width:100%;
padding-top:50px;
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

</style>
</head>

<body>
  <div class='content'>
    <h2>Wellcome to the Installation Guide</h2>
    <h3>In order to get started with the setup you must enter the requested data</h3>
    <form action="/install.php" method='POST'>

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
  </div>
</body>
<?php
}
else{
  echo "Il file che stai cercando e' stato gia' cancellato.";
}
?>
