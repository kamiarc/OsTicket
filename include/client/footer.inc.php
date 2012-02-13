<? require_once('translate/languages.php'); ?>
 <div style="clear:both"></div> 
 </div>
 <div id="footer">Copyright &copy; osTicket-reloaded.com. All rights reserved</div>
 <div align="center">
    <!-- As a show of support, we ask that you leave powered by osTicket link to help spread the word. Thank you! -->
     <a id="powered_by" href="http://osticket-reloaded.com"><img src="./images/poweredby.jpg" width="126" height="23" alt="Powered by osTicket"></a></div>
</div>
<div align="center">
<ul style="list-style: none; margin: 0;"><?
        $dir = "translate";
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if(strpos($file,'.') === false) $langs[$file] = $LANG[strtoupper($file).'_NAME'];
                }
                closedir($dh);
            }
        }
        foreach($langs as $k => $v){
            echo "   <li style='display: inline;'><a href='?setLang=".$k."'>".$v."</a></li> &nbsp;  ";
        }
?></ul></div>
</body>
</html>