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
div .distance_gage_2{
  background: red;
  width: 0px;
  height: 20px;
  border-width:1px;
  border-style:solid;
  border-color:#000000;
}
div .distance_gage_3{
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
    <td width="310"> <H1><img src="/img/shitai_icon.png" width="18" height="18"><?php echo $member_quest_title; ?></H1>[報酬]Exp<?php echo $member_quest_exp; ?>/$<?php echo $member_quest_price; ?>
      <a href="/cake/quest/top/">一覧ページに戻る</a>
      <hr>
      <br>
      <?php if($real_fact_enter_flag==1){?>
      <table width="320" border="0">
        <tr>
          <td height="51"><a href="/cake/realfact/top/"><img alt="真相への入り口" src="/img/shinsou_finish_img.png" width="320" height="99" border="0"></a></td>
        </tr>
      </table>
      <?php } ?>
      <?php if($real_fact_resolved_flag==1){?>
      <table width="320" border="0">
        <tr>
          <td height="51"><img alt="真相解明完了" src="/img/shinsou_finish_img.png" width="320" height="99" border="0"></td>
        </tr>
      </table>
      <?php } ?>
      <?php if($quest_resolved_flag==1){?>
      <table width="320" border="0">
        <tr>
          <td height="51"><img alt="事件解決" src="/img/shinsou_finish_img.png" width="320" height="99" border="0"></td>
        </tr>
      </table>
      <?php } ?>
      <?php if($last_stage_link_flag==1){ ?>
      <table width="310" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <th height="8">&nbsp;</th>
        </tr>
        <tr>
          <th height="9"><table width="320" border="0">
              <tr>
                <td height="56"><img src="/img/sousa_finish_img.png" width="320" height="99"></td>
              </tr>
              <tr>
                <td><a href="/cake/attack/top/<?php echo $member_quest_id;?>">解決編へ....[回数:<?php echo $max_challenge_count; ?>件(証拠<?php echo $ev_count; ?>:件+目撃:<?php echo $challenge_count; ?>人)]</a> <a href="/cake/item/item_challenge_top/<?php echo $member_quest_id;?>">アイテムを使って目撃者を探す[<?php echo $item_challenge;?>個]</a></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            <?php } ?> </th>
        </tr>
        <tr>
          <th height="17">証拠一覧 ---<a href="/cake/help/page3/">Q.証拠とは?</a>---
            <table width="320" border="0" class="treasure">
              <tr>
                <?php $i=1;?>
                <?php foreach($ev_data as $ev_datas): ?>
                <td width="30"><a href="/cake/evidence/evidence_detail/evi_i:<?php echo $ev_datas['evidences']['id'];?>/mq_i:<?php echo $member_quest_id;?>"><img src="/img/evidence/<?php echo $ev_datas[0]['evidence_img_id'];?>.png" width="40" height="40" border="0">(<?php echo $ev_datas[0]['count'];?>)</a></td>
                <?php if($i%7==0){ ?>
              </tr>
              <tr>
                <?php } ?>
                <?php $i+=1;?>
                <?php endforeach; ?>
            </table>
            <?php if($evidence_compleate_flag==1){ ?>
            <img alt="全部の証拠を収集完了" src="/img_0113.png" width="320" height="50" border="0">
            <?php } ?></th>
        </tr>
        <?php $i=0;?>
        <?php foreach($data as $datas): ?>
        <tr>
          <td><H1><img src="/img/evidence3_icon.png" width="18" height="18"><?php echo $datas['MemberQuestDetail']['title'] ?></H1></td>
        </tr>
        <tr>
          <td><table width="320" border="0" class="quest_detail_comment">
              <tr>
                <td><?php echo $datas['MemberQuestDetail']['comment'] ?> <span class="mini_message_red">経験値<?php echo $datas['MemberQuestDetail']['exp'] ?>↑</span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <?php $i+=1;?>
          <script type="text/javascript">
$(document).ready(function(){
  $(".distance_gage_<?php echo $i;?>").animate({width: "<?php echo ceil(320*$datas['MemberQuestDetail']['distance']/$datas['MemberQuestDetail']['all_distance']); ?>px"}, "fast");
});
</script>
          <td><img src="/img/spacer.gif" width="5" height="5">
            <div class="distance_gage_<?php echo $i;?>"></div>
            <img src="/img/spacer.gif" width="5" height="5">(<?php echo $datas['MemberQuestDetail']['distance'].'/'.$datas['MemberQuestDetail']['all_distance'];?>)</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><a href="/cake/quest/detail/<?php echo $datas['MemberQuestDetail']['id'];?>#header-menu"><img src="/img/sousa.png" width="200" height="50"></a></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><hr></td>
        </tr>
        <?php endforeach; ?>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
