<?php  
ob_start();
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();



if(isset($_REQUEST['bid'])){
	$list_data = $db->getBoardList($_REQUEST['bid']);
	echo '<option value="">Select List</option>';
	 foreach ($list_data as  $value) { ?>
				<option <?php if($value['list_id']==$_SESSION['list_id']){ echo 'selected';} ?> value="<?php echo $value['list_id']; ?>"><?php echo $value['list_title']; ?></option>
				<?php }
}

if(isset($_REQUEST['listid'])){
	$card_data = $db->getListCard($_REQUEST['listid']); 
$cardlst_count = count($card_data['cardList'])+1;
	echo '<option value="">Select Position</option>';
	 for($cs=1;$cs<=$cardlst_count;$cs++){ ?>
				<option value="<?php echo $cs; ?>"><?php echo $cs; ?></option>
<?php }
}

if(isset($_REQUEST['bordidmove']) && isset($_REQUEST['listmove']) && isset($_REQUEST['positionmove'])){
	$bord_detail = $db->getBoardDetails($_REQUEST['bordidmove']);
$updatedata1 = array(
'list_id' => $_REQUEST['listmove'],
'position' => $_REQUEST['positionmove'],
	);
$whearcon1 = array(
'card_id' => $_SESSION['cardid'],
	);
$update1 = $db->update('tbl_board_list_card',$updatedata1,$whearcon1);


$whearcon2 = array(
'card_id' => $_SESSION['cardid'],
	);
$delete1 = $db->delete('tbl_board_card_members',$whearcon2);

$insertdata = array(
'card_id' => $_SESSION['cardid'],
'list_id' => $_REQUEST['listmove'],
'user_id' => $_SESSION['sess_login_id'],
'board_id' => $_REQUEST['bordidmove'],
'Menber' => $_SESSION['sess_login_id'],
	);
$delete1 = $db->insert('tbl_board_card_members',$insertdata);

 $_SESSION['opencard']="";
	$url = $db->site_url."dashboard.php?page=board&b=".$_REQUEST['bordidmove']."&t=&k=".$bord_detail['board_key'];
echo $url;
}


if(isset($_REQUEST['bordidmove1']) && isset($_REQUEST['listmove1']) && isset($_REQUEST['positionmove1']) && isset($_REQUEST['copycomment'])){

	$carddata = $db->getfieldvisedata('tbl_board_list_card','card_id',$_SESSION['cardid']);
	/* Card Create start*/
	$insertarray1 = array(
'card_description' => $carddata[0]['card_description'],
'list_id' => $_REQUEST['listmove1'],
'card_title' => $_REQUEST['copycomment'],
'def' => '0',
'position' => '1',
'del_status' => '0',
'date_time' => date('Y-m-d h:i:s'),
	);

	$insert1 = $db->insert('tbl_board_list_card',$insertarray1);
	$cardlastid = $insert1;
	/* Card Create End*/

		/* Member Create start*/
	$insertarray2 = array(
'card_id' => $cardlastid,
'list_id' => $_REQUEST['listmove1'],
'user_id' => $_SESSION['sess_login_id'],
'board_id' => $_REQUEST['bordidmove1'],
'Menber' => $_SESSION['sess_login_id'],
	);

	$insert2 = $db->insert('tbl_board_card_members',$insertarray2);
	/* Member Create End*/

		/* Attachment Create start*/
	$attachmentdata = $db->getfieldvisedata('tbl_board_list_card_attachements','cardid',$_SESSION['cardid']);
	if(count($attachmentdata)>0){
		foreach($attachmentdata as $attachval){
$insertaarray3 = array(
'cardid' => $cardlastid,
'userid' => $_SESSION['sess_login_id'],
'attachments' => $attachval['attachments'],
'title_name' => $attachval['title_name'],
'ckey' => $attachval['ckey'],
'datetime' => date('Y-m-d h:i:s'),
'status' => $attachval['status'],
'cover_image' => $attachval['cover_image'],
'background' => $attachval['background'],
'location' => $attachval['location'],
'file_type' => $attachval['file_type'],
'file_extenstion' => $attachval['file_extenstion'],
	);
$insert3 = $db->insert('tbl_board_list_card_attachements',$insertaarray3);
		}
	}
	/* Attachment Create end*/

		/* Checklist Create start*/
	$checklistdata = $db->getfieldvisedata('tbl_board_list_card_checklist','cardid',$_SESSION['cardid']);
	if(count($checklistdata)>0){
		foreach($checklistdata as $checkval){
$insertaarray4 = array(
'cardid' => $cardlastid,
'userid' => $_SESSION['sess_login_id'],
'checklist' => $checkval['checklist'],
'date_time' => date('Y-m-d h:i:s'),
'ckey' => $checkval['ckey'],
'status' => $checkval['status'],
'item_name' => $checkval['item_name'],
'refrenceid' => $checkval['refrenceid'],
	);
$insert4 = $db->insert('tbl_board_list_card_checklist',$insertaarray4);
$lastchecklistid = $insert4;
$checklistitemdata = $db->getfieldvisedata('tbl_board_list_card_checklist_item','checklist_id',$checkval['id']);
	if(count($checklistitemdata)>0){
		foreach($checklistitemdata as $checkitmval){
$insertaarray5 = array(
'item_name' => $checkitmval['item_name'],
'status' => $checkitmval['status'],
'checklist_id' => $lastchecklistid,
	);
$insert5 = $db->insert('tbl_board_list_card_checklist_item',$insertaarray5);

		}
	}




		}
	}

/* Checklist Create End*/

		$bord_detail1 = $db->getBoardDetails($_REQUEST['bordidmove1']);
		 $_SESSION['opencard']="";
$url = $db->site_url."dashboard.php?page=board&b=".$_REQUEST['bordidmove1']."&t=&k=".$bord_detail1['board_key'];
echo $url;
	}
?>