<?php

/**
 * @Project NUKEVIET 3.x
 * @Author hongoctrien (01692777913@yahoo.com)
 * @Update to 4.x webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2012 2mit.org. All rights reserved
 * @Createdate 19-07-2012 14:43
 */

if( ! defined( 'NV_IS_MOD_CBDOAN' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];

$xtpl = new XTemplate( "detail.tpl", NV_ROOTDIR . "/themes/" . $module_info['template'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );


    $id  = $array_op[1];
    $id=explode('-', $id);
    $id=$id[0];

   $result = $db->query( "SELECT config_name, config_value FROM " . NV_CONFIG_GLOBALTABLE . " WHERE lang='".NV_LANG_DATA."' AND module='".$module_data."'" );
	$module_config = array();
	while( list( $c_config_name, $c_config_value ) = $result->fetch( 3 ) )
	{
		$module_config[$c_config_name] = $c_config_value;
	}

if(!$id)
{
    Header("Location: " . NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name);
}
    
$sql = "SELECT TV.*, CV.tenchucvu AS chucvu1, CV2.tenchucvu AS chucvu2, CV3.tenchucvu AS chucvu3, DV.tendonvi  FROM " . NV_PREFIXLANG . "_" . $module_data . " 
    TV LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_chucvu CV ON TV.macvu1=CV.macvu LEFT JOIN " 
    . NV_PREFIXLANG . "_" . $module_data . "_chucvu CV2 ON TV.macvu2=CV2.macvu
    LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_chucvu CV3 ON TV.macvu3=CV3.macvu
    LEFT JOIN " . NV_PREFIXLANG . "_" . $module_data . "_donvi DV ON TV.madvi=DV.madvi WHERE id = " . $id;
$result = $db->query( $sql );

while( $row = $result->fetch() )
{
    $row['gtinh'] == 1 ? $row['gtinh'] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/thongtin/male.png" : 
                         $row['gtinh'] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/thongtin/female.png";
    
                        
	if( empty( $row['avt'] ) )
	{
		$row['avt'] = NV_BASE_SITEURL . "themes/" . $module_info['template'] . "/images/thongtin/no-image.jpg";
	}
    
    $madvi = $row['madvi'];
    $cv2 = $row['macvu2'];
    $cv3 = $row['macvu3'];
    $quequan = $row['quequan'];
    $diachi = $row['diachi'];
    $noilamviec = $row['noilamviec'];
    $email = $row['email'];
    $yahoo = $row['yahoo'];
    $web = $row['website'];
    $skype = $row['skype'];
    $phone = $row['phone'];
    $tt = $row['tomtat'];
	
    $xtpl->assign( 'TITLE', sprintf($lang_module['tieudecb'], $row['hoten'] ));
    $xtpl->assign( 'ROW', $row );
}

$cv2 != 0 ? $xtpl->parse( 'main.cv2' ) : "";
$cv3 != 0 ? $xtpl->parse( 'main.cv3' ) : "";
$quequan != "" ? $xtpl->parse( 'main.quequan' ) : "";
$diachi != "" ? $xtpl->parse( 'main.diachi' ) : "";
$noilamviec != "" ? $xtpl->parse( 'main.noilamviec' ) : "";
$email != "" ? $xtpl->parse( 'main.k_onl.email' ) : "";
$yahoo != "" ? $xtpl->parse( 'main.k_onl.yahoo' ) : "";
$web != "" ? $xtpl->parse( 'main.k_onl.web' ) : "";
$skype != "" ? $xtpl->parse( 'main.k_onl.skype' ) : "";
$phone != "" ? $xtpl->parse( 'main.k_onl.phone' ) : "";
$tt != "" ? $xtpl->parse( 'main.tomtat' ) : "";
$yahoo != "" || $web != "" || $email != "" || $skype != "" || $phone != "" ? $xtpl->parse( 'main.k_onl' ) : "";

//dem so can bo cung don vi
$sql1 = "SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . " WHERE madvi=" . $madvi . " and id != " . $id;
$result1 = $db->query($sql1);
$num  = $result1->rowCount();

//Dinh dang link xem cac can bo cung don vi
$xtpl->assign( 'DV_LINK', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . 
                "=" . $module_name . "&amp;madvi=" . $madvi );
                
//Hien thi thong tin
$xtpl->assign( 'DV_K', sprintf($lang_module['view_dv'], $num ) );

//Bat tat tim kiem
if( $module_config['search'] == 1 )
{
    $xtpl->assign( 'ACTION', NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name );
    $xtpl->parse( 'main.search' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_site_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );

