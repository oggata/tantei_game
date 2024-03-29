<?php

require_once(BASE_DIR.'/cake/app/controllers/components/opensocial_get_user.php');
require_once(BASE_DIR.'/cake/app/controllers/components/JSON.php');

class LoginController extends AppController{

  var $uses = array('StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;

  function mixi_login(){
    $mixi_account_id = $this->params['form']['id'];
    if(strlen($mixi_account_id)==0){
      self::s_t_out();
    }
    $this->Session->write("RefleshImgFlag",1);
    //OAuthでユーザー情報を取得する
    $user_data = $this->oauth_get_user_account($mixi_account_id);
    $mixi_name = $user_data['nickname'];
    $mixi_name = mysql_escape_string($mixi_name);
    $mixi_thumbnail = $user_data['thumbnailUrl'];
    $this->Session->write("after_login_flag",1);
    $this->Session->write("mixi_name",$mixi_name);
    $this->Session->write("mixi_account_id",$mixi_account_id);
    $this->Session->write("mixi_thumbnail",$user_data['thumbnailUrl']);
    $count = $this->Member->findCount(array('mixi_account_id'=>$mixi_account_id));
    if($count == 0){
      //transaction開始
      $this->Member->begin();
      $this->MemberQuest->begin();
      $this->MemberQuestDetail->begin();
      $data = array(
        'Member' => array(
          'mixi_account_id' => $mixi_account_id,
          'thumnail_url' => $mixi_thumbnail,
          'name' => $mixi_name,
          'mail' => '',
          'pass' => '',
          'money' => '100',
          'power' => 300,
          'max_power' => 300,
          'lv' => 1,
          'lv_up_flag' => 0,
          'exp' => 0,
          'least_next_exp' => 1000,
          'sum_exp' => 0,
          'mission_count' => 0,
          'evidence_count' => 0,
          'compleate_evidence_count' => 0,
          'avater_id' => 0,
          'insert_date' => date("Y-m-d H:i:s")
        )
      );
      $m_result = $this->Member->save($data);
      $member_id = $this->Member->getLastInsertID();
      //最初の依頼を生成その１
      $first_quests_result = $this->insert_first_quests($member_id);
      //transaction終了
      if($m_result!==false&&$first_quests_result!==false){
        $this->Member->commit();
        $this->MemberQuest->commit();
        $this->MemberQuestDetail->commit();
      }else{
        $this->Member->rollback();
        $this->MemberQuest->rollback();
        $this->MemberQuestDetail->rollback();
        $this->redirect('/login/session_timeout/');
      }
      //メッセージの追加（これはトランザクション外でOK..）
      $title = '「観覧車殺人事件」が追加されました。';
      $this->send_message($member_id,$title,'');
      self::login_f_mixi();
    }else{
      if(strlen($mixi_name)>0){
        $mdata = $this->Member->findByMixiAccountId($mixi_account_id);
        $id = $mdata['Member']['id'];
        $data = array(
          'id' => $id,
          'mixi_account_id' => $mixi_account_id,
          'thumnail_url' => $mixi_thumbnail,
          'name' => $mixi_name,
          'update_date' => date("Y-m-d H:i:s")
        );
        $this->Member->save($data);
      }
      $data = $this->Member->find("first",array("mixi_account_id" => $mixi_account_id));
      if(strlen($data['Member']['id'])==0){
        self::login_failed();
      }else{
        $this->Session->write("member_info",$data['Member']);
        self::login_success();
      }
    }
  }

  function oauth_get_user_account($mixi_account_code){
    $api = new OpensocialGetUserRestfulAPI($mixi_account_code);
    $data = $api->get();
    $json = new Services_JSON;
    $decode_data = $json->decode($data,true);
    $user_data['nickname'] = $decode_data->entry->nickname;
    $user_data['thumbnailUrl']= $decode_data->entry->thumbnailUrl;
    $user_data['platformUserId']= $decode_data->entry->platformUserId;
    return $user_data;
  }

  function oauth_get_user_account_id($mixi_account_id){
    $api = new OpensocialGetUserRestfulAPI($mixi_account_id);
    $data = $api->get();
    $json = new Services_JSON;
    $decode_data = $json->decode($data,true);
    $user_data['nickname'] = $decode_data->entry->nickname;
    $user_data['thumbnailUrl']= $decode_data->entry->thumbnailUrl;
    return $user_data;
  }

  function login_failed(){
    $this->redirect('/login/login/');
  }

  function login_success(){
    $this->Session->write('img_refresh_flag',1);
    $this->redirect('/top/top/');
  }

  function s_t_out(){
    $this->redirect('/login/session_timeout/');
  }

  function session_timeout(){
  }

  function login_f_mixi(){
    $this->redirect("/login/login_first_mixi");
  }

  function login_first_mixi(){
    $error_txt = $this->Session->read("error_txt");
    //$this->set('error_txt',$error_txt);
    //$this->Session->write("RefleshImgFlag",1);
    $mixi_account_id = $this->Session->read("mixi_account_id");
    $this->set('mixi_account_id',$mixi_account_id);
    $mixi_name = $this->Session->read("mixi_name");
    $this->set('mixi_name',$mixi_name);
  }

  function log_out(){
    $this->Session->write("user_genre_code","");
    $this->Session->write("member_info","");
    $this->member_id = 1;
  }

  private function send_message($member_id,$title,$comment){
    //メッセージを入れる
    $msdata = array(
      'Message' => array(
        'member_id' => $member_id,
        'title' => $title,
        'comment' => $comment,
        'genre_id' => 1,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->Message->create();
    $this->Message->save($msdata);
  }

  private function insert_first_quests($member_id){
    $data = array(
      'MemberQuest' => array(
        'member_id' => $member_id,
        'title' => '観覧車殺人事件',
        'comment' => '遊園地の観覧車内で起きた殺人事件の犯人を追え！',
        'quest_exp' => 300,
        'quest_price' => 30,
        'resolved_flag' => 0,
        'evidence_appear_rate' => 5,
        'challenge_count' => 4,
        'quest_id' => 1,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuest->create();
    $mq_result = $this->MemberQuest->save($data);
    $member_quest_id = $this->MemberQuest->getLastInsertID();
    $data = array(
      'MemberQuestDetail' => array(
        'member_quest_id' =>$member_quest_id,
        'detail_no' => 1,
        'resoluved_flag' =>0,
        'member_id' =>$member_id,
        'title' =>'現場検証をせよ',
        'comment' =>'現場検証を行い手掛かりを探せ',
        'exp' =>100,
        'distance' =>0,
        'all_distance' =>100,
        'last_marker_flag' =>0,
        'quest_detail_id' =>1,
        'insert_time' =>date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuestDetail->create();
    $mqd_result = $this->MemberQuestDetail->save($data);
    if($mq_result!==false&&$mqd_result!==false){
      return true;
    }else{
      return false;
    }
  }
}
