<?php
function getData($filename)
{
    if(isset($filename))
    {
        
    
$myfile = fopen($filename, "r") or die("Unable to open file!");
$data = fread($myfile,filesize($filename));
fclose($myfile);
return $data;
}
}

$directory = 'games';
$scan = array_diff(scandir($directory), array('..', '.'));
//number of games
$nbGames = count($scan);

?>

<html>
<head>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
    <style type="text/css">
    .ui{
        margin-top:-60px;
    }
    iframe{
        border:0;
    }
    </style>
</head>
<body>
    <div class="container">
          <div class="jumbotron">
    <h1>Media Experiment</h1>      
    
    
    
  </div>
  <nav class="navbar navbar-inverse ui">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://pacee.net">Pacee.net</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php">Home</a></li>
     <!-- <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li> 
      <li><a href="#">Page 3</a></li> -->
    </ul>
  </div>
</nav>
  <div class="row">
      <?php
      if (isset($_GET['game'])&&is_dir("games/".$game=htmlspecialchars($_GET['game']))) // On a le nom et le prénom
{
   $json = getData("games/".$game."/infos.json");
      $data = json_decode($json, true);
	?>
	  <div class="col-sm-push-2 col-sm-8">
          <div class="panel panel-default">
          <div class="panel-heading"><?php  echo $data["name"]; ?></div>
          <div class="panel-body"> 
<div><script src="embed.js?game=<?php  echo $game; ?>&amp;width=<?php  echo $data["w"]; ?>&amp;height=<?php  echo $data["h"]; ?>"></script></div>
          </div>
          <div class="panel-footer">
              <div class="form-group">
      <label for="focusedInput">link</label>
      <input class="form-control" id="focusedInput" type="text" value="<?php  echo  "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
    </div><?php 
      
       
          echo 'Bonjour ' .$data["infos"] ; ?></div>
        </div>  </div>
        <?php
}
else{
?>
      <!-- game 1 --->
 
      <?php
      foreach($scan as $file)
{
    if (is_dir("games/$file"))
    { $json = getData("games/".$file."/infos.json");
      $data = json_decode($json, true);
      
    ?>
    
     <div class="col-sm-4">
          <div class="panel panel-default">
          <div class="panel-heading"><?php  echo '<a href="?game='.$file.'">'.$data["name"]; ?></div>
          <div class="panel-body">  <?php
        echo $data["infos"]; 
        ?>
        
          <img src="<?php echo 'games/'.$file.'/img.jpg'; ?>" class="img-thumbnail" style="display:inline" alt="dolphin" width="100%" height="100%"></div>
        </a></div>  </div>
    <?php
    }
}

}
?>
        
    
        
   <!--         
  <div class="col-sm-4">
          <div class="panel panel-default">
          <div class="panel-heading">game2</div>
          <div class="panel-body">My game2</div>
        </div>  </div>
        
           
  <div class="col-sm-4">
          <div class="panel panel-default">
          <div class="panel-heading">game3</div>
          <div class="panel-body">My game3</div>
        </div>
    </div>
    </div>   --->  
 
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41036023-1', 'auto');
  ga('send', 'pageview');

</script>
</body> 
</html>