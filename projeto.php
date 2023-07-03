<?php
/*
 * OBTENDO AS PÁGINAS A SEREM INCLUIDAS
 */

date_default_timezone_set("America/Sao_Paulo");

$css      = $js = Array();
$FOLDER   = dirname(__FILE__) . "/paginas";
$dirs     = scandir( $FOLDER );
$indice   = "$FOLDER/indice.txt";

if ((count($dirs) > 2) && (file_exists($indice)))
  $indice = file($indice, FILE_TEXT | FILE_SKIP_EMPTY_LINES);

  $unsetado = false;
  
  foreach ($indice as $key => $value){
    $value = trim($value, chr(10) . chr(13));
    
    if (strpos($value, ":") !== false){
      $value = explode(":", $value);
      
      $nomePath = $value[0];
      $nomePath = strtoupper($nomePath{0}) . substr($nomePath, 1);
      
      $nome = $value[1];
      $nome = strtoupper($nome{0}) . substr($nome, 1) ;             
    }else
      $nome = $nomePath = strtoupper($value{0}) . substr($value, 1);          
      
    $indice[$key] = Array(
        $nomePath, 
        "$FOLDER/" . strtoupper($nomePath{0}) . substr($nomePath, 1) . "/" . strtolower($nomePath),
        $nome
    );
        
    if (file_exists($indice[$key][1] . ".php")){
      $RELATIVE = str_replace( dirname(__FILE__), "", $indice[$key][1]);

      if ((file_exists($indice[$key][1].".css")))
        $css[] = "$RELATIVE.css";


      if (file_exists($indice[$key][1].".js"))
        $js[] = "$RELATIVE.js";      
    }else{     
      if (strtolower(substr($indice[$key][2], 0, 2)) !== '//'){
        unset($indice[$key]);
        $unsetado = true;      
      }
    }
  }
  
  if ($unsetado)
    $indice = array_values($indice);      
  
?><!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  
  <title>Wikiscrito, o comentário bíblico livre.</title>
  <meta property="description" content="EM BREVE, um wiki teológico sério, racional, dinâmico e imparcial. Com recursos avançados para estudo aprofundado da Bíblia Sagrada. Onde o superficial é deixado para tráz e partimos para o incrível mundo de descobertas bíblicas a um simples clique de você. Aguarde e junte-se a nós nesta exploração!" />
  
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
  <!-- META PARA FACEBOOK  -->
  <meta property="fb:admins" content="JeanCarloEM,JenifferEM" />
  <meta property="fb:page_id" content="Wikiscrito" />
  <meta property="fb:app_id" content="307935729347542" />  
  <meta property="og:url" content="http://wikiscrito.org" />    
  <meta property="og:type" content="website" />    
  <meta property="og:site_name" content="Wikiscrito, o comentário bíblico livre." />  
  <meta property="og:title" content="Wikiscrito, o comentário bíblico livre." />  
  <meta property="og:description" content="EM BREVE, um wiki teológico sério, racional, dinâmico e imparcial. Com recursos avançados para estudo aprofundado da Bíblia Sagrada. Onde o superficial é deixado para tráz e partimos para o incrível mundo de descobertas bíblicas a um simples clique de você. Aguarde e junte-se a nós nesta exploração!" />  
  <meta property="og:image" content="http://wikiscrito.org/img/thumbnail.png" />
  <meta property="og:image" content="http://wikiscrito.org/LOGOs/png512.png" />  
  
  <!-- THUMBNAILS -->
  <link rel="image_src" href="http://wikiscrito.org/img/thumbnail.png" />
  <link rel="image_src" href="http://wikiscrito.org/LOGOs/png512.png" />   
  
  <!-- FAVICON and TOUCH ICONS -->
  <link rel="shortcut icon" type="image/x-icon" href="LOGOs/logo.ico" />  
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="LOGOs/png144.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="LOGOs/png114.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="LOGOs/png72.png">
  <link rel="apple-touch-icon-precomposed" href="images/ico/LOGOs/png57.png">
  
  <!-- O STILO PADRÃO -->
  <link rel='stylesheet' type='text/css' href="/css/master.css" media="screen" />    

  <!-- A ÚLTIMA VRSÃO JQUERY -->
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
  
  <!-- MENU SUPERFISH -->
  <link rel="stylesheet" href="/css/superfish/superfish.css" media="screen">    
  <script type="text/javascript" src="/js/superfish/hoverIntent.js"></script>    
  <script type="text/javascript" src="/js/superfish/superfish.js"></script>  
  
  <!-- SCRIPT PADRAO -->
  <script type="text/javascript" src="/js/master.js"></script>  
  <script type="text/javascript" src="/js/rolasuave.js"></script>    
   
    
<?php
  echo "\n\t<!-- INI :: ESTILOS POR PÁGINA -->\r";
  
  foreach ($css as $value)
    echo "\n\t<link rel='stylesheet' type='text/css' href='$value' rel='stylesheet' />\r";
  
  echo "\n\t<!-- FIM :: ESTILOS POR PÁGINA -->\r";  
  
  echo "\n\n\t<!-- INI :: JAVASCRIPTs POR PÁGINA -->\r";
  
  foreach ($js as $value)
    echo "\n\t<link rel='stylesheet' type='text/css' href='$value' rel='stylesheet' />\r";
  
  echo "\n\t<!-- FIM :: JAVASCRIPTs POR PÁGINA -->\r";    
?>  
  
</head>

<body> 
  <header id="master">
    <ul class="sf-menu popap" id="principal">
      <li>
        <a><img class="menuPopap" src="/img/menu.png" /></a>

        <?php
          $lista = "<ul>";
          foreach ($indice as $key => $value) {
            if (strtolower(substr($value[2], 0, 2)) === '//')
              $nome =  strtolower((strtolower($value[0]) === "splash")?"Home":$value[0]);
            else
              $nome =  strtolower((strtolower($value[2]) === "splash")?"Home":$value[2]);              
            
            if (strtolower(substr($value[2], 0, 2)) === '//')
              $lista .= "<li><a href='" . strtolower($value[2]) . "'>" . strtoupper($nome{0}) . substr($nome, 1) . "</a></li>";
            else
              $lista .= "<li><a href='#pg_id_" . strtolower($value[0]) . "'>" . strtoupper($nome{0}) . substr($nome, 1) . "</a></li>";              
          }
          $lista .= "</ul>";          

          echo $lista;
        ?>        
      </li>
    </ul>    
        
    <div class="logo">Wikiscrito</div>  
    
    <div class="menu">
      <?php        
        echo $lista;
      ?>
    </div>      
  </header>
  
  <div id="conteiner">
<?php
    foreach ($indice as $key => $value) {
      if (strtolower(substr($value[2], 0, 2)) !== '//'){
?>
    <!-- INI PÁGINA :: <?php echo strtoupper($value[0]);?> -->
    <div id="pagina_<?php echo $key;?>" class="pagina">
      <div id="pg_id_<?php echo str_replace(" ", "_", str_replace("  ", " ", strtolower($value[0])));?>">
        <a href="#pg_id_<?php echo str_replace(" ", "_", str_replace("  ", " ", strtolower($value[0])));?>" name="pg_id_<?php echo str_replace(" ", "_", str_replace("  ", " ", strtolower($value[0])));?>" class="bola"><?php
        if (file_exists(dirname(__FILE__) .  "/paginas/" . $value[0] . "/img/bola.png")){
    ?><img src="/paginas/<?php echo $value[0];?>/img/bola.png" /><?php } ?></a>
        <?php require_once "$value[1].php"; ?>
      </div>
    </div>
    <!-- FIM PÁGINA :: <?php echo strtoupper($value[0]);?> -->
<?php
      }
    }
?>
  </div>    
  
</body>

</html>