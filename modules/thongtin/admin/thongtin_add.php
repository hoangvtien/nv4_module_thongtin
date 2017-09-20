<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (01692777913@yahoo.com)
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2012 2mit.org. All rights reserved
 * @Createdate 19-07-2012 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['thongtin_add'];
global $global_config, $file_name;

if( defined( 'NV_EDITOR' ) )
{
	require_once ( NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php' );
}

$xtpl = new XTemplate( "thongtin_add.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );

$my_head = "<script type=\"text/javascript\" src=\"" . NV_BASE_SITEURL . "js/popcalendar/popcalendar.js\"></script>\n";

$url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "";
$xtpl->assign( 'ACTION', $url );

$op = $nv_Request->get_string ('op', 'get','');

$donvi = getDonvi();
$chucvu = getChucvu();

if(empty($donvi))
{
    Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=donvi_add");
}

if(empty($chucvu))
{
    Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=chucvu_add");
}

$thongtin = array();

$thongtin['ten'] = "";
$thongtin['ngsinh'] = "";
$thongtin['gt'] = 1;    
$thongtin['avt'] = "";    
$thongtin['que'] = "";
$thongtin['diachi'] = "";
$thongtin['madvi'] = "";
$thongtin['macvu1'] = "";
$thongtin['macvu2'] = "";
$thongtin['macvu3'] = "";
$thongtin['email'] = "";
$thongtin['yahoo'] = "";
$thongtin['skype'] = "";
$thongtin['phone'] = "";
$thongtin['web'] = "";
$thongtin['tt'] = "";
$thongtin['noilamviec'] = "";

$error = array();

if ( $nv_Request->get_int( 'save', 'post' ) == 1 )
{
    //dua thong tin tu form vao mang
    $thongtin['ten'] = $nv_Request->get_string ('ten', 'post','');
    $thongtin['ngsinh'] = $nv_Request->get_string ('ngsinh', 'post',0);
    $thongtin['gt'] = $nv_Request->get_int ('gt', 'post', 1); 
    $thongtin['avt'] = $nv_Request->get_string ('avt', 'post','');    
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
    $bodytext = $nv_Request->get_string( 'tt', 'post','' );
    $thongtin['web'] = $nv_Request->get_string( 'noilamviec', 'post','' );
	$thongtin['tt'] = defined( 'NV_EDITOR' ) ? nv_editor_br2nl( $bodytext, '' ) : nv_editor_br2nl( nv_htmlspecialchars( strip_tags( $bodytext ) ), '<br />' );
   
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
    
    //Xu ly cac ky tu xuong dong trong textarea
    $thongtin['tt'] = nv_nl2br( $thongtin['tt'], "<br />" );

    //Kiem tra loi
    //Check loi ten can bo
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
    if(!empty($thongtin['phone']) && strlen($thongtin['phone']) <10  or $thongtin['phone'] && !is_numeric($thongtin['phone']))
    {
        $error['format_phone'] = $lang_module['format_phone'];
    }
   
	///////////////////////////////////////
    if(empty($error))
    {
		$sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '
				( hoten, ngsinh, gtinh, avt, quequan, diachi, madvi, macvu1, macvu2, macvu3, email, yahoo, skype, phone, website, tomtat, noilamviec) VALUES (
				 :hoten,
				 :ngsinh,
				 :gtinh,
				 :avt,
				 :quequan,
				 :diachi,
				 :madvi,
				 :macvu1,
				 :macvu2,
				 :macvu3,
				 :email,
				 :yahoo,
				 :skype,
				 :phone,
				 :website,
				 :tomtat,
				 :noilamviec)';

			$data_insert = array();
			$data_insert['hoten'] = $thongtin['ten'];
			
			$data_insert['ngsinh'] = $thongtin['ngsinh'];
			$data_insert['gtinh'] = $thongtin['gt'];
			$data_insert['avt'] = $thongtin['avt'];
			$data_insert['quequan'] = $thongtin['que'];
			$data_insert['diachi'] = $thongtin['diachi'];
			$data_insert['madvi'] = $thongtin['madvi'];
			$data_insert['macvu1'] = $thongtin['macvu1'];
			$data_insert['macvu2'] = $thongtin['macvu2'];
			$data_insert['macvu3'] = $thongtin['macvu3'];
			$data_insert['email'] = $thongtin['email'];
			$data_insert['yahoo'] = $thongtin['yahoo'];
			$data_insert['skype'] = $thongtin['skype'];
			$data_insert['phone'] = $thongtin['phone'] ;
			$data_insert['website'] = $thongtin['web'];
			$data_insert['tomtat'] = $thongtin['tt'];
			$data_insert['noilamviec'] = $thongtin['noilamviec'];
			$kq = $db->insert_id( $sql, 'id', $data_insert );
            if($kq)
            {
                Header("Location:" . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name );
            }
            else
            {
                $error['csdl'] = $lang_module['csdl'];
            }
    }
}
else
{
    $thongtin['gt'] = 1;
}

$thongtin['gt1'] = $thongtin['gt'] ? " checked=\"checked\"" : "";

//Lay danh sach cac don vi
foreach($donvi as $list_dv)
{
	$xtpl->assign('SELECTED', $list_dv['madvi'] == $thongtin['madvi'] ? 'selected=\"selected\"' : '' );
    $xtpl->assign('LIST_DV', $list_dv);
    $xtpl->parse( 'main.dv' );
}

//Lay danh sach chuc vu
foreach($chucvu as $list_cv)
{
    $xtpl->assign('LIST_CV', $list_cv);
	$xtpl->assign('SELECTED', $list_cv['macvu'] == $thongtin['macvu1'] ? 'selected=\"selected\"' : '' );
    $xtpl->parse( 'main.cv1' );
	$xtpl->assign('SELECTED', $list_cv['macvu'] == $thongtin['macvu2'] ? 'selected=\"selected\"' : '' );
    $xtpl->parse( 'main.cv2' );
	$xtpl->assign('SELECTED', $list_cv['macvu'] == $thongtin['macvu3'] ? 'selected=\"selected\"' : '' );
    $xtpl->parse( 'main.cv3' );
}


if( defined( 'NV_EDITOR' ) and nv_function_exists( 'nv_aleditor' ) )
	{
		$data  = nv_aleditor( "tt", '99%', '300px', $thongtin['tt'] );
	}
	else
	{
		$data = "<textarea style=\"width: 99%\" name=\"tt\" id=\"tt\" cols=\"20\" rows=\"8\">" . $thongtin['tt'] . "</textarea>";
	}

$xtpl->assign( 'THONGTIN', $thongtin );
$xtpl->assign( 'bodytext', $data );

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

