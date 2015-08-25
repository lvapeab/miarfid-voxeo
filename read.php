<?php
  echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
  if (!isset($_GET['uid'])) {
    trigger_error("Expected message \"uid\".", E_USER_ERROR);
  }
  
$page_id = $_GET['uid'];
$access_token = '727478640669562|y2OmHAKuU7NqW1zmLb5I9eU3Bk4';
//Get the JSON
$json_object = @file_get_contents('https://graph.facebook.com/' . $page_id . 
'/posts?access_token=' . $access_token);
//Interpret data
$fbdata = json_decode($json_object);


foreach ($fbdata->data as $post )
{
$posts .= '<p><a href="' . $post->link . '">' . $post->story . '</a></p>';
$posts .= '<p><a href="' . $post->link . '">' . $post->message . '</a></p>';
$posts .= '<p>' . $post->description . '</p>';
$posts .= '<br />';
}
  
  
echo $posts;
?>
<vxml version="2.1" xmlns="http://www.w3.org/2001/vxml" xml:lang="ca-es">
  <meta name="maintainer" content="lvapeab@fiv.upv.es" />
  <form id="MainForm">
   <block>
      <prompt>
	<?php echo $posts; ?>
      </prompt>
    </block>
    <field name="action">
      <grammar xmlns="http://www.w3.org/2001/06/grammar"
               xml:lang="es-es" root="ROOT" mode="voice">
        <rule id="ROOT" scope="public">
          <one-of>
            <item><ruleref uri="./grammar/control.xml#ROOT"/></item>
            <item><ruleref uri="./grammar/main.xml#ROOT"/></item>
            <item><ruleref uri="./grammar/readPosts.xml#ROOT"/></item>
          </one-of>
        </rule>
      </grammar>
      <filled>
        <if cond="lastresult$.interpretation.ACTION == 'stop'">
          <clear namelist="action"/>
        </if>
        <if cond="lastresult$.interpretation.ACTION == 'exit'">
          <prompt>Adiós</prompt>
        </if>
      </filled>
    </field>
  </form>
</vxml>
