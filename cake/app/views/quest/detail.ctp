<script src="http://www.google.com/jsapi"></script>
<script>
  google.load("jquery", "1.6.1");
  google.load("jqueryui", "1.7.1");
</script>
<script type="text/javascript" src="/js/jquery.easing.js"></script>

<style type="text/css">
div .distance_gage_1{
  background: red;
  width: 0px;
  height: 20px;
  border-width:1px;
  border-style:solid;
  border-color:#000000;
}
</style>

 <table width="310" height="127" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="310"><table width="310" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <th height="8">&nbsp;</th>
        </tr>
        <tr>
          <th height="9"><H1 align="left"><img src="/img/shitai_icon.png" width="18" height="18"><?php echo $quest_title;?></H1>
            <div align="right">
                <a href="/cake/quest/datalist/<?php echo $member_quest_id;?>"><img src="/img/evidence2_icon.png" width="18" height="18">事件簿に戻る</a>
            </div>
            <hr></th>
        </tr>
        <tr>
          <th height="17">&nbsp;</th>
        </tr>
        <?php foreach($data as $datas): ?>
        <tr>
          <td><H1><img src="/img/evidence3_icon.png" width="18" height="18"><?php echo $datas['MemberQuestDetail']['title'] ?></H1></td>
        </tr>
        <tr>
          <td><table width="320" border="0" class="quest_detail_comment">
              <tr>
                <td><H2><?php echo $datas['MemberQuestDetail']['comment'] ?></H2><span class="mini_message_red">経験値<?php echo $datas['MemberQuestDetail']['exp'] ?>↑</span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
<script type="text/javascript">
$(document).ready(function(){
  $(".distance_gage_1").animate({width: "<?php echo ceil(320*$datas['MemberQuestDetail']['distance']/$datas['MemberQuestDetail']['all_distance']); ?>px"}, "fast");
});
</script>
          <td><img src="/img/spacer.gif" width="5" height="5"><div class="distance_gage_1"></div><img src="/img/spacer.gif" width="5" height="5"><?php echo $datas['MemberQuestDetail']['distance'] ?>/<?php echo $datas['MemberQuestDetail']['all_distance'] ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><a href="/cake/quest/exe_quest/<?php echo $datas['MemberQuestDetail']['id'];?>"><img src="/img/sousa_bottan.png" width="200" height="50"></a></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><hr></td>
        </tr>
        <tr>
          <td> <?php foreach($mdata as $mdatas): ?>
            <table width="320" border="0" class="profile">
              <tr>
                <td width="66" rowspan="3"><img src="<?php echo $mdatas['Member']['thumnail_url'];?>" width="44" height="44"></td>
                <td width="59">体力</td>
                <td width="115"><?php echo $mdatas['Member']['power'];?>/<?php echo $mdatas['Member']['max_power'];?></td>
              </tr>
              <tr>
                <td>LV</td>
                <td><?php echo $mdatas['Member']['lv'];?>(あと<?php echo $mdatas['Member']['least_next_exp'];?>exp)</td>
              </tr>
              <tr>
                <td>EXP</td>
                <td><?php echo $mdatas['Member']['exp'];?>exp</td>
              </tr>
            </table>
            <?php endforeach; ?> </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <?php endforeach; ?>
      </table></td>
  </tr>
</table>
