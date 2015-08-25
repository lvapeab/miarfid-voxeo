
<vxml version="2.1" xmlns="http://www.w3.org/2001/vxml" xml:lang="es-es">
  <meta name="maintainer" content="lvapeab@fiv.upv.es" />
  <form id="MainForm">
    <block>
      <prompt> Bienvenido!
       <!-- <?php
          if (is_null($prev)) { echo "Bienvenido\n"; }
          echo $message;
        ?> -->
      </prompt>
    </block>
    <field name="action">
<grammar xmlns="http://www.w3.org/2001/06/grammar"
         xml:lang="es-es" root="ROOT" mode="voice">
  <rule id="ROOT" scope="public">
    <one-of>
      <item><ruleref uri="./grammar/control.xml#ROOT"/></item>
      <item><ruleref uri="./grammar/main.xml#ROOT"/></item>
<?php
     echo "<item><ruleref uri=\"$SHOW_POST_URI\"/></item>";
  }
?>
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
           
        
        <if cond="lastresult$.interpretation.ACTION == 'READ'">
            <goto next="./read.php?prev=index&amp;search=new" />
          </if>
          <if cond="lastresult$.interpretation.SEARCH == 'all'">
            <goto next="./index.php?prev=index&amp;search=all" />
          </if>
          <if cond="lastresult$.interpretation.SEARCH == 'day'">
            <goto expr="'./index.php?prev=index&amp;search=day&amp;date=' + lastresult$.interpretation.DATE" />
          </if>
        </if>
        <if cond="lastresult$.interpretation.ACTION == 'read'">
          <goto expr="'./read.php?prev=index&amp;uid=' + lastresult$.interpretation.UID" />
        </if>
      </filled>
    </field>
  </form>
</vxml>
