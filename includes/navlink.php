<div align="center" class="barnav">
<p class="boxes">
<?php
for ($i=$TFM_startLink; $i <= $TFM_endLink; $i++) {
  $TFM_counter = ($i - 1) * $maxRows_rs1 + 1;
  $TFM_endCounter = min($totalRows_rs1,$TFM_counter + $maxRows_rs1 - 1);
  if($i-1 != $pageNum_rs1) {
    printf('<a href="'."%s?pageNum_rs1=%d%s", $currentPage, $i-1, $queryString_rs1.'">');
      echo "$TFM_counter-$TFM_endCounter</a>";
  }else{
    echo "<strong>$TFM_counter-$TFM_endCounter</strong>";
  }
  if($i != $TFM_endLink) echo " ";
}
?>
</p>
</div>