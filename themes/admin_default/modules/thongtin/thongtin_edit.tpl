﻿<!-- BEGIN: main -->
<link type="text/css" href="/{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<script type="text/javascript" src="/{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

	<!-- BEGIN: loop -->
		<span class="quytac">{ERROR}</span>
	<!-- END: loop -->
	<form name="add_thongtin" id="add_thongtin" action="{ACTION}" method="POST" enctype="multipart/form-data">
	<input name="save" type="hidden" value="1" />
		<input type="hidden" name="id" value="{THONGTIN.id}">
		<table class="table table-striped table-bordered table-hover">
		<tbody>
			<tr>
				<td style="width: 200px">{LANG.ten}</td>
				<td><input type="text" name="ten" value="{THONGTIN.ten}" style="width:300px" maxlength="255"></td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.ngsinh}</td>
				<td>
					<input type="text" name="ngsinh" id="birthday" value="{THONGTIN.ngsinh}" readonly="readonly">
					
				</td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.gtinh}</td>
				<td><input type="checkbox" name="gt" value="1" {CHECK_GT}/>{LANG.female}</td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.avt}</td>
			<td><input type="text" name="avt" id="pic_path" value="{THONGTIN.avt}">
			<input value="{LANG.select_pic}" name="selectimg" type="button"/></td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.que}</td>
			<td><input type="text" name="que" value="{THONGTIN.que}" style="width:300px" maxlength="255"></td>
			</tr>
		</tbody>

		<tbody>
			<tr>
				<td>{LANG.diachi}</td>
			<td><input type="text" name="diachi" value="{THONGTIN.diachi}" style="width:300px" maxlength="255"></td>
			</tr>
		</tbody>

		<tbody class="second">
			<tr>
				<td>{LANG.donvi}</td>
			<td>
                    <select name="madvi">
						<option value="">{LANG.chon_dv}</option>
                        <!-- BEGIN: dv -->
							<option value="{LIST_DV.madvi}" {SELECTED}>{LIST_DV.tendvi}</option>
                        <!-- END: dv -->
                    </select>
			</td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.chucvu}</td>
				<td>
                    <select name="macvu1">
						<option value="">{LANG.chon_cv1}</option>
                        <!-- BEGIN: cv1 -->
							<option value="{LIST_CV.macvu}" {SELECTED}>{LIST_CV.tenchucvu}</option>
                        <!-- END: cv1 -->
                    </select>
					
                    <select name="macvu2">
						<option value="">{LANG.chon_cv2}</option>
                        <!-- BEGIN: cv2 -->
							<option value="{LIST_CV.macvu}" {SELECTED}>{LIST_CV.tenchucvu}</option>
                        <!-- END: cv2 -->
                    </select>
					
                    <select name="macvu3">
						<option value="">{LANG.chon_cv3}</option>
                        <!-- BEGIN: cv3 -->
							<option value="{LIST_CV.macvu}" {SELECTED}>{LIST_CV.tenchucvu}</option>
                        <!-- END: cv3 -->
                    </select>
				</td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.email}</td>
			<td><input type="text" name="email" value="{THONGTIN.email}"></td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.yahoo}</td>
			<td><input type="text" name="yahoo" value="{THONGTIN.yahoo}"></td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.skype}</td>
			<td><input type="text" name="skype" value="{THONGTIN.skype}"></td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.phone}</td>
			<td><input type="text" name="phone" value="{THONGTIN.phone}"></td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td>{LANG.web}</td>
			<td><input type="text" name="web" value="{THONGTIN.web}"></td>
			</tr>
		</tbody>
		
		<tbody>
			<tr>
				<td>{LANG.tt}</td>
			    <td>
                    {bodytext}
                </td>
			</tr>
		</tbody>
		
		<tbody class="second">
			<tr>
				<td><input type="submit" name="confirm" value="{LANG.rec}" onclick="return formtest()" />
				<td></td>
			</tr>
		</tbody>
		</table>
	</form>
	
<script type="text/javascript">
	//<![CDATA[
	document.getElementById('add_thongtin').setAttribute("autocomplete", "off");
	$(function() {
		$("#birthday").datepicker({
			showOn : "both",
			dateFormat : "dd/mm/yy",
			changeMonth : true,
			changeYear : true,
			showOtherMonths : true,
			buttonImage : nv_base_siteurl + "assets/images/calendar.gif",
			buttonImageOnly : true,
			yearRange: "-99:+0"
		});
		
	});
	$("input[name=selectimg]").click(function()
	{
		var area = "pic_path"; // return value area
		var type = "image";
		var path = "{PATH}";
		nv_open_browse("{BROWSER}");
		return false;
	});
	//]]>
</script>
<!-- END: main -->
