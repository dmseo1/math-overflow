<?php

	@session_start();
	if(!isset($_POST['profile']) || !isset($_POST['member_no']))
	{
		echo "잘못된 접근입니다(1)";
		return;
	}
	echo $_POST['member_no'];
	echo $_SESSION['user_member_no'];
	if($_POST['member_no'] != $_SESSION['user_member_no'])
	{
		echo "잘못된 접근입니다(2)";
		return;
	}
	
	$member_no = $_POST['member_no'];
	$profile = -1;
	$activity = -1;
	$question = -1;
	$answer = -1;
	$community = -1;
	$comment = -1;
	$onetoone = -1;

	if($_POST['profile'] == "yes") {
		$profile = 1;
	} else { $profile = 0; }

	if($_POST['activity'] == "yes") {
		$activity = 1;
	} else { $activity = 0; }

	if($_POST['footprint_question'] == "yes") {
		$question = 1;
	} else { $question = 0; }

	if($_POST['footprint_answer'] == "yes") {
		$answer = 1;
	} else { $answer = 0; }

	if($_POST['footprint_community'] == "yes") {
		$community = 1;
	} else { $community = 0; }

	if($_POST['footprint_comment'] == "yes") {
		$comment = 1;
	} else { $comment = 0; }
	if($_POST['onetoone'] == "yes") {
		$onetoone = 1;
	} else { $onetoone = 0; }


	$info_range = $profile . $activity . $question . $answer . $community . $comment;
	$conn = new mysqli("localhost", "root", "sdm9469", "math_overflow");
	$sql_apply = "update member set info_range='" . $info_range . "', allow_onetoone=" . $onetoone . " where no=" . $member_no;
	$result_apply = $conn->query($sql_apply);

	if(!$result_apply) { echo "잘못된 접근입니다(3)"; return;}

	echo "<script>alert('정보 공개 범위 설정이 완료되었습니다.'); window.close();</script>";



?>
