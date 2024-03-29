<?php

class EvidenceController extends AppController{

  var $uses = array('Evidence','MemberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $components = array('Pager');

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->MemberQuest->find('all',array('conditions'=>array("member_id"=>$member_id)));
    $this->set('data',$data);
  }

  function detail($quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->StructureSql->select_own_evidence_list($quest_id);
    $this->set('quest_id',quest_id);
    $this->set('data',$data);
  }

  function evidence_detail(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $evidence_id = $this->params['named']['evi_i'];
    $member_quest_id = $this->params['named']['mq_i'];
    $data = $this->StructureSql->select_own_evidence_detail($evidence_id);
    $this->set('evidence_id',$evidence_id);
    $this->set('member_quest_id',$member_quest_id);
    $this->set('evidence_name',$data[0]['evidences']['name']);
    $this->set('m_e_img_id',$data[0][0]['m_e_img_id']);
    $this->set('data',$data);
  }

  function evidence_have_list($evidence_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->StructureSql->evidence_own_members($member_id,$evidence_id);
    $this->set('data',$data);
    $ev_data = $this->Evidence->findById($evidence_id);
    $evidence_name = $ev_data['Evidence']['name'];
    $ev_img_id = $ev_data['Evidence']['img_id'];
    $this->set('evidence_name',$evidence_name);
    $this->set('img_id',$ev_img_id);
  }

  function return_useragent_code(){
    $isiPhone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
    $isiPod = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPod');
    $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
    $isAndroid = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Android');
    if($isiPad){return 1;}
    else if($isiPod){return 1;}
    else if($isiPhone){return 1;}
    else if($isAndroid){return 2;}
    else{return 2;}
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}