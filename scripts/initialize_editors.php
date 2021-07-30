<?php
	$included_tiny_api = false;
	$included_fck_api = false;

	$rHas = fn(string $key, $value) => isset($_REQUEST[$key]) and $_REQUEST[$key] === $value;

		//ak je "edit" alebo "new" clanku alebo modul "JOB" pre pole TEXT
		if (($_REQUEST["cmd"]==9)||($_REQUEST["cmd"]==8)||(($rHas('module', 'CMS_Job'))&&($rHas('mcmd', 2)))||(($rHas('module', 'CMS_Job'))&&($rHas('mcmd', 4)))){

				if (getConfig('proxia','prefered_editor') == 'xinha')										// XINHA
					include ("scripts/init_xinha.php");

				elseif (getConfig('proxia','prefered_editor') == 'tinymce_simple'){			// TINY_MCE SIMPLE
					$included_tiny_api = true;
					echo '
					<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
					<script language="javascript" type="text/javascript">
						tinyMCE.init({
								mode : "textareas",
								editor_selector : "mceArticleText",
								elements : "f_text",
								theme : "advanced",
								theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,code,image",
								theme_advanced_buttons2 : "",
								theme_advanced_buttons3 : "",
								theme_advanced_toolbar_location : "top",
								theme_advanced_toolbar_align : "left",
								theme_advanced_path_location : "bottom",
								plugins : "advlink,advimage",
								extended_valid_elements : "a[name|href|target|title|onclick|class|rel]",

								convert_urls : false
						});
					</script>
					';
				}
				elseif (getConfig('proxia','prefered_editor') == 'tinymce_full'){				// TINY_MCE FULL

					$user_detail = CMS_UserLogin::getSingleton()->getUser();
					// Nastavenie jazyka editora
					$editor_language = $user_detail->getConfigValue('prefered_language');
					if(empty($editor_language))
						$editor_language = getConfig('proxia','prefered_language');

					$project_name = $_SESSION["user"]["name"];

					//cesta ku projektom
					$path_prefix =  "../www/";

					//ziskanie zoznamu tem pre projekt
/*					$directory = dir($path_prefix.$project_name."/themes");
					$combo_theme_value = "";
					while (false !== ($entry = $directory->read())) {
						 if( $entry=="." or $entry==".." or $entry==".svn")
							continue;
					   if(is_dir($path_prefix.$project_name."/themes/".$entry))
					   		$combo_theme_value .= '<option value='.$entry.'>'.$entry.'</option>';
					}*/
					
					//$directory->close();

					// nastavenie css pre editor
					$path_to_project_css = $path_prefix.$project_name."/css/editor_styles_4_article_text.css";
					if(!file_exists($path_to_project_css))
						$path_to_project_css = "/tiny_mce/themes/advanced/css/editor_content.css";


					$included_tiny_api = true;
					echo '
					<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
					<script language="javascript" type="text/javascript">
						tinyMCE.init({
								mode : "textareas",
								editor_selector : "mceArticleText",
								elements : "f_text",
								theme : "advanced",
								plugins : "table,save,advhr,advimage,advlink,iespell,insertdatetime,preview,zoom,searchreplace,print,contextmenu,paste,fullscreen,proxiaflash,template,proxiatheme",
								theme_advanced_buttons1_add_before : "save,separator",
								theme_advanced_buttons1_add : "fontselect,fontsizeselect",
								theme_advanced_buttons2_add : "separator,zoom,separator,forecolor,backcolor,proxiatheme",
								theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",
								theme_advanced_buttons3_add_before : "tablecontrols,separator",
								theme_advanced_buttons3_add : "iespell,proxiaflash,separator,print,separator,pastetext,pasteword,selectall,preview,fullscreen,template",
								theme_advanced_toolbar_location : "top",
								theme_advanced_toolbar_align : "left",
								theme_advanced_path_location : "bottom",
										template_cdate_classes : "cdate creationdate",
										template_mdate_classes : "mdate modifieddate",
										template_selected_content_classes : "selcontent",
										template_cdate_format : "%m/%d/%Y : %H:%M:%S",
										template_mdate_format : "%m/%d/%Y : %H:%M:%S",
										template_templates : [
											{
												title : "Image and Title",
												src : "tiny_mce/plugins/template/image_title.htm",
												description : "One main image with a title and text that surround the image."
											},
											{
												title : "Strange Temlate",
												src : "tiny_mce/plugins/template/strange_template.htm",
												description : "A template that defines two columns, each one with a title, and some text.."
											},
											{
												title : "Text and Table",
												src : "tiny_mce/plugins/template/text_table.htm",
												description : "A title with some text and a table."
											}
										],
								plugin_insertdate_dateFormat : "%Y-%m-%d",
								plugin_insertdate_timeFormat : "%H:%M:%S",
								verify_css_classes : true,
								convert_fonts_to_spans : false,
								paste_create_paragraphs : false,
								paste_create_linebreaks : false,
								paste_use_dialog : false,
								paste_auto_cleanup_on_paste : true,
								paste_convert_middot_lists : true,
								paste_unindented_list_class : "unindentedList",
								paste_convert_headers_to_strong : true,
								fullscreen_new_window : false,
								fullscreen_settings : {
									theme_advanced_path_location : "top"
								},
								language : "'.$editor_language.'",
								content_css : "'.$path_to_project_css.'",
								proxia_project_name : "'.$project_name.'",
								proxia_element_name : "article_text",
								proxia_path : "'.$path_prefix.'",
								debug : false,
								entity_encoding : "raw",
								extended_valid_elements : "a[name|href|target|title|onclick|class|style|rel],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|obj|param|embed|xflashvars|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],iframe[width|height|frameborder|scrolling|marginheight|marginwidth|src|align],script[language]",
								external_link_list_url : "example_data/example_link_list.js",
								external_image_list_url : "example_data/example_image_list.js",
								convert_urls : false
						});


					</script>
					';
				}

				elseif (getConfig('proxia','prefered_editor') == 'fck'){								// FCK
					$included_fck_api = true;
					$fckEditorForDescription = getConfig('proxia','prefered_editor_for_desc') == 'fck';
					$fckEditorForDescription = $fckEditorForDescription ? "1" : "0";
					echo '
					<script language="javascript" type="text/javascript" src="scripts/fck/fckeditor.js"></script>
					<script language="javascript" type="text/javascript">
						var fckEditorForDescription = 0;
						window.onload = function()
					      {
					      	fckEditorForDescription = '.$fckEditorForDescription.';
					        var oFCKeditor = new FCKeditor( "f_text" ) ;
					        oFCKeditor.BasePath = "scripts/fck/" ;
					        oFCKeditor.Height = 500 ;
					        oFCKeditor.ReplaceTextarea() ;

									if (fckEditorForDescription==1)
										callNextEditor();
					      }
					</script>
					';
				}

				}
//***************************************
// pre kratky popis clanku /new, edit/
//***************************************
			if ( ($_REQUEST["cmd"]==9) || ($_REQUEST["cmd"]==8) || ($_REQUEST["cmd"]==3) )
				{
					$prefered_editor_for_desc = getConfig('proxia','prefered_editor_for_desc');
					if (!$included_tiny_api){
						echo '<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>';
						}

					if($prefered_editor_for_desc == "tinymce_simple"){
							$user_detail = CMS_UserLogin::getSingleton()->getUser();
							$editor_language = $user_detail->getConfigValue('prefered_language');
							if(empty($editor_language))
								$editor_language = getConfig('proxia','prefered_language');

							$project_name = $_SESSION["user"]["name"];
							//cesta ku projektom
							$path_prefix =  "../www/";

							$path_to_project_css = $path_prefix.$project_name."/css/editor_styles_4_article_desc.css";
							if(!file_exists($path_to_project_css))
								$path_to_project_css = "/tiny_mce/themes/advanced/css/editor_content.css";

								if (!$included_tiny_api){
									echo '<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>';
								}
								echo '
								<script language="javascript" type="text/javascript">
									tinyMCE.init({
											mode : "textareas",
											elements : "f_description",
											editor_selector : "mceArticleDesc",
											theme : "advanced",
											theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,undo,redo,link,unlink,code,image",
											theme_advanced_buttons2 : "",
											theme_advanced_buttons3 : "",
											theme_advanced_toolbar_location : "top",
											theme_advanced_toolbar_align : "left",
											theme_advanced_path_location : "bottom",
											plugins : "advlink,advimage",
											language : "'.$editor_language.'",
											content_css : "'.$path_to_project_css.'",
											extended_valid_elements : "a[name|href|target|title|onclick|class|rel],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|obj|param|embed|xflashvars]",
											height : "150",
											convert_urls : false
									});
								</script>
								';
					}
			}


	//ak je  modul "Catalog"
if ((($rHas('mcmd', 12)) || ($rHas('mcmd', 11)) || ($rHas('mcmd', 6)))&&($_REQUEST["module"]=='CMS_Catalog')){
					$user_detail = CMS_UserLogin::getSingleton()->getUser();
					// Nastavenie jazyka editora
					$editor_language = $user_detail->getConfigValue('prefered_language');
					if(empty($editor_language))
						$editor_language = getConfig('proxia','prefered_language');

					echo '
					<script language="javascript" type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
					<script language="javascript" type="text/javascript">
						tinyMCE.init({
								mode : "textareas",
								elements : "f_description",
								theme : "advanced",
								theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,code,image,proxiaflash,separator,pastetext,pasteword,selectall,forecolor,backcolor",
								theme_advanced_buttons2 : "fontselect,fontsizeselect",
								theme_advanced_buttons2_add_before : "tablecontrols,separator",
								theme_advanced_buttons3 : "",
								theme_advanced_toolbar_location : "top",
								theme_advanced_toolbar_align : "left",
								theme_advanced_path_location : "bottom",
								plugins : "advlink,advimage,table,paste,proxiaflash",
								convert_fonts_to_spans : false,
								paste_create_paragraphs : false,
								paste_create_linebreaks : false,
								paste_use_dialog : false,
								paste_auto_cleanup_on_paste : true,
								paste_convert_middot_lists : true,
								paste_unindented_list_class : "unindentedList",
								paste_convert_headers_to_strong : true,
								fullscreen_new_window : false,
								extended_valid_elements : "a[name|href|target|title|onclick|rel]",
								height : "250",
								language : "'.$editor_language.'",
								convert_urls : false
						});
					</script>
					';

	/*	echo '
				<script language="javascript" type="text/javascript" src="scripts/fck/fckeditor.js"></script>
				<script language="javascript" type="text/javascript">
					window.onload = function()
				      {
				        var oFCKeditor = new FCKeditor( "f_description" ) ;
				        oFCKeditor.BasePath = "scripts/fck/" ;
				        oFCKeditor.Height = 300 ;
				        oFCKeditor.ReplaceTextarea() ;

				        var oFCKeditor2 = new FCKeditor( "f_descriptionExtended" ) ;
				        oFCKeditor2.BasePath = "scripts/fck/" ;
				        oFCKeditor2.Height = 500 ;
				        oFCKeditor2.ReplaceTextarea() ;
				      }
				</script>
				';
		*/
		}

?>
