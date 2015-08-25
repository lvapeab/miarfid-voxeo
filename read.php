<?php 
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
  
  if(!isset($_GET['mode'])){
    trigger_error("Se esperaba un modo",E_USER_ERROR);
  }

  if(!isset($_GET['page'])){
  trigger_error("Se esperaba una página",E_USER_ERROR);
  }
  
  $mode = $_GET['mode'];
  $mode= str_replace("'","",$mode );

  $page_id = $_GET['page'];
  $page_id= str_replace("'","",$page_id );


  
  $access_token = '727478640669562|y2OmHAKuU7NqW1zmLb5I9eU3Bk4';

//Get the JSON
  $json_object = @file_get_contents('https://graph.facebook.com/' . $page_id . 
  '/posts?access_token=' . $access_token);

//Interpret data
  $fbdata = json_decode($json_object);


  if($mode === "readLast"){
    $posts .=  $fbdata->data[0]->message ;
}
  if($mode === "readTwo"){
    $posts .=  $fbdata->data[0]->message . '  <break/>  ' ;
    $posts .=  $fbdata->data[1]->message  ;
  }

  if($mode === "readAll"){
    foreach ($fbdata->data as $post )
    {
      $posts .=  $post->message . '  <break/>  ' ;
    }
  } 
// Filtramos las webs
$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
// Comprobamos si existe una url en la noticia.
if(preg_match($reg_exUrl,$posts)) {
      //Si existe, la eliminamos
       $posts = preg_replace($reg_exUrl, " ", $posts);
} 

if(empty($posts)){
  $posts = "Lo siento, no hay noticias en esa página. <break\>";
  }
?>  



<vxml version="2.1" xmlns="http://www.w3.org/2001/vxml" xml:lang="es-es">
  <form id="MainForm">
    <block>
      <prompt>
        <?php
        echo $posts; 
        echo "<break/>";
        echo "¿Deseas hacer algo más?";
        ?>
      </prompt>
    </block>

    <field name="action">
      <grammar xmlns="http://www.w3.org/2001/06/grammar"
      xml:lang="es-es" root="ROOT" mode="voice">
      <rule id="ROOT" scope="public">
        <one-of>
        <item><ruleref uri="./control.grxml#ROOT"/></item>
        <item><ruleref uri="./main.grxml#ROOT"/></item>
      </one-of>
    </rule>
  </grammar>


  <filled>
   <if cond="lastresult$.interpretation.ACTION == 'stop'">
      <clear namelist="action"/>
        <prompt> . ¿Deseas hacer algo más?</prompt>
    </if>
   <if cond="lastresult$.interpretation.ACTION == 'exit'">
      <prompt>Adiós.</prompt>
    </if>
    <if cond="lastresult$.interpretation.ACTION == 'read'">
     <assign name="page" expr="action$.interpretation.PAGE" />
     <assign name="mode" expr="action$.interpretation.MODE" />
     <submit next="read.php" method="get" namelist="mode page" />
   </if>

    <if cond="lastresult$.interpretation.ACTION == 'repeat'">
      <submit next="read.php" method="get" namelist="mode page" />


    </if>
  </filled>
</field>

</form>
</vxml>
