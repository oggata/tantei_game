<?php
function return_wordwrap($line){
  $n=45; #改行させる（半角での）文字数
  $rtntxt = '';
  for($i=0;$i<mb_strlen($line);$i+=$len){
    for($j=1;$j<=$n;$j++){
      $wk=mb_substr($line,$i,$j);
      if(strlen($wk)>=$n) break;
    }
    $len=mb_strlen($wk);
    $rtntxt .= "$wk<br>";
  }
  return $rtntxt;
}
?>
<table width="310" height="127" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="310"><table width="310" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th width="179" height="19">名前 </th>
        <th width="75">解決</th>
        <th width="26">真相</th>
        <th width="28">勝率</th>
      </tr>
      <?php foreach($data as $datas): ?>
      <tr bgcolor="#000000">
        <td><img src="<?php echo $datas['Member']['thumnail_url'] ?>" width="27" height="34"><?php echo $datas['Member']['name'] ?>(Lv.<?php echo $datas['Member']['lv'] ?>)</td>
        <td><?php echo $datas['Member']['mission_count'] ?>件</td>
        <td><?php echo $datas['Member']['win_count'] ?>勝/<?php echo $datas['Member']['lose_count'] ?>敗</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><hr></td>
        </tr>
      <?php endforeach; ?>
    </table></td>
  </tr>
</table>
