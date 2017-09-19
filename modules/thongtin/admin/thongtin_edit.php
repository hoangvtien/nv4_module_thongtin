<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (01692777913@yahoo.com)
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2012 2mit.org. All rights reserved
 * @Createdate 19-07-2012 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['edit_tv'];


if( defined( 'NV_EDITOR' ) )
{
	require_once ( NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php' );
}

$xtpl = new XTemplate( "thongtin_edit.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );

//$my_head = "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/popcalendar/popcalendar.js\"></script>\n";

$op = $nv_Request->get_string ('op', 'get','');
$id = $nv_Request->get_string ('id', 'get','');
$ac = $nv_Request->get_string ('ac', 'get','');

$url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&amp;id=" . $id;
$xtpl->assign( 'ACTION', $url );


if($ac == 'del')
{
    $result = $db->query("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . " WHERE id = '".$id."' ");
    Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "");
}

$error = array();
$thongtin = array();

if(isset($id))
{
   $thong_tin = array();
   $result = $db->query( "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . " WHERE id= '" . $id . "'");
   while ( $row = $result->fetch() )
   {
      $thongtin[] = array (
         "id" => $row['id'],
         "ten" => $row['hoten'],
         "ngsinh" => $row['ngsinh'],
         "gt" => $row['gtinh'],
         "avt" => $row['avt'],
         "que" => $row['quequan'],
         "diachi" => $row['diachi'],
         "madvi" => $row['madvi'],
         "macvu1" => $row['macvu1'],
         "macvu2" => $row['macvu2'],
         "macvu3" => $row['macvu3'],
         "email" => $row['email'],
         "yahoo" => $row['yahoo'],
         "skype" => $row['skype'],
         "phone" => $row['phone'],
         "web" => $row['website'],
         "tt" => $row['tomtat'],
         "noilamviec" => $row['noilamviec'],
      );
      
      if($row['gtinh'] != 0)
      {
        $xtpl->assign( 'CHECK_GT', 'checked="checked"' );
      }
    }
}


//Cap nhat du lieu tu form
if ( $nv_Request->get_int( 'save', 'post' ) == 1 )
{
	
    //dua thong tin tu form vao mang
    $thongtin['id'] = $nv_Request->get_string ('id', 'post','');
    $thongtin['ten'] = $nv_Request->get_string ('ten', 'post','');
    $thongtin['ngsinh'] = $nv_Request->get_string ('ngsinh', 'post','');
    $thongtin['gt'] = $nv_Request->get_int ('gt', 'post', 1); 
    $thongtin['avt'] = $nv_Request->get_string ('avt', 'post','');
    $thongtin['nvdoan'] = $nv_Request->get_string ('nvdoan', 'post','');    
    $thongtin['dang'] = $nv_Request->get_int ('dang', 'post',0);
    $thongtin['nvdang'] = $nv_Request->get_string ('nvdang', 'post','');    
    $thongtin['que'] = $nv_Request->get_string ('que', 'post','');
    $thongtin['diachi'] = $nv_Request->get_string ('diachi', 'post','');
    $thongtin['madvi'] = $nv_Request->get_int ('madvi', 'post',0);
    $thongtin['macvu1'] = $nv_Request->get_int ('macvu1', 'post',0);
    $thongtin['macvu2'] = $nv_Request->get_int ('macvu2', 'post',0);
    $thongtin['macvu3'] = $nv_Request->get_int ('macvu3', 'post',0);
    $thongtin['email'] = $nv_Request->get_string ('email', 'post','');
    $thongtin['yahoo'] = $nv_Request->get_string ('yahoo', 'post','');
    $thongtin['skype'] = $nv_Request->get_string ('skype', 'post','');
    $thongtin['phone'] = $nv_Request->get_string ('phone', 'post','');
    $thongtin['web'] = $nv_Request->get_string ('web', 'post','');
    $thongtin['noilamviec'] = $nv_Request->get_string ('noilamviec', 'post','');
    $bodytext = $nv_Request->get_string( 'tt', 'post','' );
	$thongtin['tt'] = defined( 'NV_EDITOR' ) ? nv_nl2br( $bodytext, '' ) : nv_nl2br( nv_htmlspecialchars( strip_tags( $bodytext ) ), '<br />' );
	
	
    //Dinh dang dia chi web
    if ( ! empty( $thongtin['web'] ) )
    {
        if ( ! preg_match( "#^(http|https|ftp|gopher)\:\/\/#", $thongtin['web'] ) )
        {
            $thongtin['web'] = "http://" . $thongtin['web'];
        }
        if ( ! nv_is_url( $thongtin['web'] ) )
        {
            $thongtin['web'] = "";
        }
    }
    
    
    //Kiem tra loi
    //Check loi ten thanh vien
    if(empty($thongtin['ten']))
    {
        $error['no_name'] = $lang_module['no_name'];
    }
    
    //Check loi ngay sinh
    if(empty($thongtin['ngsinh']))
    {
        $error['no_ngsinh'] = $lang_module['no_ngsinh'];
    }
    elseif(strlen($thongtin['ngsinh']) != 10 )
    {
        $error['format_ngsinh'] = $lang_module['format_ngsinh'];
    }
	
    
    
    
    //Check loi don vi
    if($thongtin['madvi'] == "")
    {
        $error['no_dvi'] = $lang_module['no_dvi'];
    }
    
    //Check loi chuc vu
    if($thongtin['macvu1'] == "")
    {
        $error['no_cvu'] = $lang_module['no_cvu'];
    }
    elseif($thongtin['macvu1'] == $thongtin['macvu2'] OR $thongtin['macvu1'] == $thongtin['macvu3'] OR !empty($thongtin['macvu2']) && !empty($thongtin['macvu3']) 
    && $thongtin['macvu2'] == $thongtin['macvu3'])
    {
        $error['tr_cvu'] = $lang_module['tr_cvu'];
    }
    
    //Kiem tra dinh dang email
    $pattern = '/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/';
    $mailStr = $thongtin['email'];
    if(( !empty($thongtin['email']) && preg_match($pattern, $mailStr)==0) ) 
    {
        $error['format_email'] = $lang_module['format_email'];
    }
    
    //Kiem tra so dien thoai
    if(!empty($thongtin['phone']) && strlen($thongtin['phone']) <10  or !empty($thongtin['phone']) && !is_numeric($thongtin['phone']))
    {
        $error['format_phone'] = $lang_module['format_phone'];
    }
    
    if(empty($error))
    {
		
		$sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . " SET
				hoten = '" . $thongtin['ten'] . "',
				ngsinh = '" . $thongtin['ngsinh'] . "',
				gtinh = '" . $thongtin['gt'] . "',
				avt = '" . $thongtin['avt'] . "',            
				quequan = '" . $thongtin['que'] . "',
				diachi = '" . $thongtin['diachi'] . "',
				madvi = '" . $thongtin['madvi'] . "',
				macvu1 = '" . $thongtin['macvu1'] . "',
				macvu2 = '" . $thongtin['macvu2'] . "',
				macvu3 = '" . $thongtin['macvu3'] . "',
				email = '" . $thongtin['email'] . "',
				yahoo = '" . $thongtin['yahoo'] . "',
				skype = '" . $thongtin['skype'] . "',
				phone = '" . $thongtin['phone'] . "',
				website = '" . $thongtin['web'] . "',
				tomtat = '" . $bodytext . "',
				noilamviec = '" . $thongtin['noilamviec'] . "' WHERE id = '".$thongtin['id']."'";    
		$result = $db->query($sql);
		
		if($result)
		{
			Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "");
		}
	
    }
	
	
}


//Lay danh sach cac don vi
$donvi = getDonvi();

foreach($donvi as $list_dv)
{
    foreach ($thongtin as $tv)
    {
        $xtpl->assign('LIST_DV', $list_dv);
        $xtpl->assign('SELECTED', $list_dv['madvi'] == $tv['madvi'] ? 'selected=\"selected\"' : '');
        $xtpl->parse( 'main.dv' );
    }
}


//Lay danh sach chuc vu
$chucvu = getChucvu();
foreach($chucvu as $list_cv)
{
    foreach($thongtin as $tv)
    {
        $xtpl->assign('LIST_CV', $list_cv);
        $xtpl->assign('SELECTED', $list_cv['macvu'] == $tv['macvu1'] ? 'selected=\"selected\"' : '');
        $xtpl->parse( 'main.cv1' );
		$xtpl->assign('SELECTED', $list_cv['macvu'] == $tv['macvu2'] ? 'selected=\"selected\"' : '');
        $xtpl->parse( 'main.cv2' );
		$xtpl->assign('SELECTED', $list_cv['macvu'] == $tv['macvu3'] ? 'selected=\"selected\"' : '');
        $xtpl->parse( 'main.cv3' );
    }
}

foreach ($thongtin AS $tv)
{

	if( defined( 'NV_EDITOR' ) and nv_function_exists( 'nv_aleditor' ) )
	{
		$data  = nv_aleditor( "tt", '99%', '300px', $tv['tt'] );
	}
	else
	{
		$data = "<textarea style=\"width: 99%\" name=\"tt\" id=\"tt\" cols=\"20\" rows=\"8\">" . $tv['tt'] . "</textarea>";
	}
    $xtpl->assign( 'THONGTIN', $tv);
	$xtpl->assign( 'bodytext', $data );
}

foreach($error as $errors)
{
    $xtpl->assign( 'ERROR', $errors );
    $xtpl->parse ( 'main.loop' );
}

$xtpl->assign( 'BROWSER', NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=upload&popup=1&area=" + area+"&path="+path+"&type="+type, "NVImg", "850", "400","resizable=no,scrollbars=no,toolbar=no,location=no,status=no' );
$xtpl->assign( 'PATH', NV_UPLOADS_DIR . '/' . $module_name . "" );

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

