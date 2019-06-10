<?php
if(file_exists('install/install.php')){
    $index = is_writable(__FILE__);
    $install = removableDirectory("install");
    $includes = is_writable("includes/config.inc.php");
    $smarty = is_writable("libs/smarty/templates_c");
    $ok = $index && $install && $includes && $smarty;
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
.error{
    color: red;
}
.ok{
    color: green;
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
    <p>Before starting remember the following things:</p>
    <ul>
     <li>
     <?php
        if(!$index){
            echo "<span class='error'>index.php is not writable</span>";
        }else{
            echo "<span class='ok'>index.php is writable</span>";
        }
     ?>
     </li>
     <li>
     <?php
        if(!$install){
            echo "<span class='error'>install folder and all its content are not writable</span>";
        }else{
            echo "<span class='ok'>install folder and all its content are writable</span>";
        }
     ?>
     </li>
     <li>
     <?php
        if(!$includes){
            echo "<span class='error'>includes/config.inc.php is not writable</span>";
        }else{
            echo "<span class='ok'>includes/config.inc.php is writable</span>";
        }
     ?></li>
     <li>
     <?php
        if(!$smarty){
            echo "<span class='error'>libs/smarty/templates_c is not writable</span>";
        }else{
            echo "<span class='ok'>libs/smarty/templates_c is writable</span>";
        }
     ?></li>
    </ul>
    <h3>In order to get started with the setup you must enter the requested data</h3>
    <form action="/install/install.php" method='POST'>

      DB Host:<br>
      <input type="text" name="DBhost"><br>
      DB Name:<br>
      <input type="text" name="DBname"><br>
      DB Username:<br>
      <input type="text" name="DBusername"><br>
      DB Password:<br>
      <input type="text" name="DBpassword"><br><br>
      <input type="submit" value="SETUP"
      <?php if(!$ok) echo " disabled";?>
      >
    </form>
    <h4>The setup might take several minutes, just be patient</h4>

  </div>
</body>
<?php
}
else{
  echo "Il file che stai cercando e' stato gia' cancellato.";
}

function removableDirectory($dir){
    if (!file_exists($dir))
        return is_writable($dir) && is_executable($dir);

    if (!is_dir($dir))
        return is_writable($dir);

    foreach (scandir($dir) as $item){
        if ($item == '.' || $item == '..')
            continue;
        return removableDirectory($dir . DIRECTORY_SEPARATOR . $item);
    }
    return rmdir($dir);
}
?>
