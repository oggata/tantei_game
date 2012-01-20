<link href="/js/progress/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/js/progress/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="/js/progress/jquery-ui-1.8.11.custom.min.js"></script>
<style type="text/css">
#progressbar {width: 120px; height: 10px;}
#progressbar .ui-progressbar-value { background-color: #0033CC;}
</style>
<script type="text/javascript">
$(function(){
    // プログレスバーを生成
    $("#progressbar").progressbar();
    $(window).load(function() {
            var start = $(this);
            var value =100;
            var timer = setInterval(function(){
                if(value <= <?php echo $power; ?>) {
                    clearInterval(timer);
                    value = <?php echo $power; ?>;
                } else {
                    value = value - 5;
                }
                // プログレスバーの値を変更
                $("#progressbar").progressbar("option", "value", value);
            }, 100);
        })
});
</script>
<table width="310"  border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td><p><img src="/img/ajito_<?php echo $avater_id; ?>.png" width="320" height="180"></p></td>
  </tr>
  <tr>
    <td height="10"><table class="message" width="315" border="0">
        <tr>
          <td>最近の動き<br>
            <?php echo $message_txt;?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="11"><a href="/cake/quest/top/"><img src="/img/sousa_start.png" width="320" height="50" border="0"></a></td>
  </tr>
  <tr>
    <td height="135"> <?php foreach($mdata as $mdatas): ?>
      <table width="304" border="0">
        <tr>
          <td width="71"><img src="<?php echo $mdatas['thumnail_url'];?>" width="44"></td>
          <td width="215"><?php echo $mdatas['name'];?><span class="mini_message">[Lv<?php echo $mdatas['lv'];?>]</span></td>
        </tr>
        <tr>
          <td colspan="2"><hr></td>
        </tr>
        <tr>
          <td width="71">Exp</td>
          <td width="215">Exp<?php echo $mdatas['exp'];?><span class="mini_message">[次のレベルまで<?php echo $mdatas['least_next_exp'];?>]</span> </td>
        </tr>
        <tr>
          <td colspan="2"><hr></td>
        </tr>
        <tr>
          <td>体力</td>
          <td><div id="progressbar"> </div><?php echo $mdatas['power'];?>/<?php echo $mdatas['max_power'];?><span class="mini_message">満タンまで残り<?php echo $least_time;?></span></td>
        </tr>
        <tr>
          <td colspan="2"><hr></td>
        </tr>
        <tr>
          <td>所持金</td>
          <td>$<?php echo $mdatas['money'];?> </td>
        </tr>
        <tr>
          <td colspan="2"><hr></td>
        </tr>
        <tr>
          <td>順位</td>
          <td><?php echo $mdatas['rank_no'];?>/<?php echo $mdatas['total_members'];?> <a href="/cake/ranking/top/">ランキングを見る </a></td>
        </tr>
        <tr>
          <td colspan="2"><hr>
            <br>
            <a href="/cake/top/profile/" class="style4">もっと詳しく見る</a></td>
        </tr>
      </table>
      <?php endforeach; ?>
      <p><a href="/cake/gacha/top/"><img src="/img/gacha_start.png" width="320" height="50" border="0"><br>
        <br>
      <img src="/img/aaaa.png" width="320" height="50" border="0">      </a></p>
      <a href="/cake/help/top/">HELP </a> </td>
  </tr>
</table>
