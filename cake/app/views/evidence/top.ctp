
<table width="310" height="127" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="310"><table width="310" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <th height="19">&nbsp;</th>
        <th width="56">&nbsp;</th>
      </tr>
      <?php foreach($data as $datas): ?>
      <tr>
        <td><a href="/cake/evidence/detail/<?php echo $datas['MemberQuest']['quest_id'] ?>"><?php echo $datas['MemberQuest']['title'] ?></a></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="2"><hr></td>
        </tr>
      <?php endforeach; ?>
    </table></td>
  </tr>
</table>



