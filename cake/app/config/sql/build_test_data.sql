delimiter //
drop procedure build_test_data//
create procedure build_test_data(in local_max_counter_1 int,in local_max_counter_2 int)
begin
  declare local_test_name varchar(250);
  declare local_thumnail_url varchar(250);
  declare local_evidence_id int;
  declare local_evidence_name varchar(250);
  declare local_evidence_img_id int;
  declare local_counter_1 int;
  declare local_counter_2 int;
  declare local_member_quests_id_counter int;
  declare local_member_quests_id_max_counter int;
  declare local_treasure_member int;
  declare local_mission_count int;
  declare local_quest_id int;
  set local_counter_1 = 2;
  set local_counter_2 = 2;
  set local_member_quests_id_counter = 10;

  truncate table members;
  truncate table member_quests;
  truncate table member_evidences;
  truncate table member_quest_details;
  truncate table messages;

  insert into members (id,mixi_account_id,name,power,max_power,money,lv,exp,least_next_exp,sum_exp,star_count
  )values(
  1,1,'TestUser',1000,1000,1000,1,0,1000,0,10);
  insert into member_quests (
  id,
  member_id,
  title,
  comment,
  quest_exp,
  quest_price,
  resolved_flag,
  evidence_appear_rate,
  challenge_count,
  quest_id,
  insert_time
  )values(
  100,
  1,
  '観覧車殺人事件',
  '遊園地の観覧車内で起きた殺人事件の犯人を追え！',
  300,
  30,
  0,
  5,
  4,
  1,
  NOW()
  );
  insert into member_quest_details (
  member_quest_id,
  detail_no,
  resoluved_flag,
  member_id,
  title,
  comment,
  exp,
  distance,
  all_distance,
  last_marker_flag,
  quest_detail_id,
  insert_time
  )values(
  100,
  1,
  0,
  1,
  '現場検証をせよ',
  '現場検証を行い手掛かりを探せ',
  100,
  0,
  100,
  0,
  1,
  NOW()
  );

  while local_counter_1 < local_max_counter_1 do
    set local_member_quests_id_counter = local_member_quests_id_counter+1;
    set local_member_quests_id_max_counter = local_member_quests_id_counter + 10;
    set local_counter_2 = 1;
       select name into local_test_name from test_names order by rand() limit 1;
    select
      concat('http://bank.blamestitch.com/jpg/test/',local_counter_1,'.jpg')
    into
      local_thumnail_url
    ;
    select FLOOR( REVERSE( RAND() ) ) %(500 - 5 + 1) + 5 into local_mission_count;
    insert into members (
      id,
      mixi_account_id,
      thumnail_url,
      name,
      power,
      max_power,
      money,
      lv,
      exp,
      least_next_exp,
      sum_exp,
      mission_count,
      star_count,
      attack_power,
      defence_power,
      fortune_power
    )values(
      local_counter_1,
      local_counter_1,
      local_thumnail_url,
      local_test_name,
      1000,
      1000,
      100,
      1,
      0,
      1000,
      0,
      local_mission_count,
      5,
      5,
      10,
      5
    );
    while local_counter_2 < local_max_counter_2 do
      select id,name,img_id
      into local_evidence_id,local_evidence_name,local_evidence_img_id
      from evidences order by rand() limit 1;
      insert into member_evidences(
        evidence_id,member_id,name,img_id,member_quest_id,member_quest_detail_id
      )values(
        local_evidence_id,local_counter_1,local_evidence_name,local_evidence_img_id,0,0
      );
      set local_counter_2 = local_counter_2 + 1;
    end while;

    set local_quest_id = 1;
    while local_member_quests_id_counter < local_member_quests_id_max_counter do
      insert into member_quests(id,member_id,quest_id)values(local_member_quests_id_counter,local_counter_1,local_quest_id);
      insert into member_quest_details(member_quest_id,detail_no,resoluved_flag,member_id)values(local_member_quests_id_counter,1,1,local_counter_1);
      set local_quest_id =local_quest_id+1;
      set local_member_quests_id_counter=local_member_quests_id_counter+1;
    end while;

    set local_counter_1 = local_counter_1 + 1;
  end while;

end
//
delimiter ;
call build_test_data(5,5);