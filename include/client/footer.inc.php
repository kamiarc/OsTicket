<? require_once('translate/languages.php'); ?>
 <div style="clear:both"></div> 
 </div>

</div>
<div align="center" style="width:800px; margin:auto;">
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
            echo "   <li style='display: inline; float:right; margin-left:1px; margin-top:5px;'><a href='?setLang=".$k."'>".$v."</a></li> &nbsp;  ";
        }
?></ul></div>
</body>
</html>