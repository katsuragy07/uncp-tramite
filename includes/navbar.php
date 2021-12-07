<br />
<div align="center">
<p class="boxes">
<?php //$TFM_navLinks
if ($pageNum_rs1 > 0) {
printf('<a href="'."%s?pageNum_rs1=%d%s", $currentPage, 0, $queryString_rs1.'">Primero</a>');
}else{
echo "Primero";
}
echo " ";
if ($pageNum_rs1 > 0) {
printf('<a href="'."%s?pageNum_rs1=%d%s", $currentPage, max(0, $pageNum_rs1 - 1), $queryString_rs1.'">Anterior</a>');
}else{
echo "Anterior";
}
echo " ";
for ($i = $TFM_startLink; $i <= $TFM_endLink; $i++) {
$TFM_LimitPageEndCount = $i -1;
if($TFM_LimitPageEndCount != $pageNum_rs1) {
printf('<a href="'."%s?pageNum_rs1=%d%s", $currentPage, $TFM_LimitPageEndCount, $queryString_rs1.'">');
echo "$i</a>";
}else{
echo "<span class=\"current_nav\">$i</span>";
}
if($i != $TFM_endLink) echo(" ");}
if ($pageNum_rs1 < $totalPages_rs1) { 
printf(' <a href="'."%s?pageNum_rs1=%d%s", $currentPage, $pageNum_rs1 + 1, $queryString_rs1.'">Siguiente</a>');
}else{
echo " Siguiente";
}
echo " ";
if ($pageNum_rs1 < $totalPages_rs1) { 
printf('<a href="'."%s?pageNum_rs1=%d%s", $currentPage, $totalPages_rs1, $queryString_rs1.'">&Uacute;ltimo</a>');
}else{
echo "&Uacute;ltimo";
}
?></p>
</div>