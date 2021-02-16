	<?php
	//xinha
			require_once('../cms_classes/xinha.php');

			$xinha = new Xinha('scripts/xinha/');

			$xinha->addEditor('f_text');
			$xinha->addGlobalPlugin('ListType');
		//	$xinha->setGlobalParam('width', '630px');
		//	$xinha->setGlobalParam('height', '630px');

			$xinha->setEditorParam('f_text', 'height', '450px');
		//	$xinha->setEditorParam('f_text', 'width', '600px');
			$xinha->addEditorPlugin('f_text', 'ContextMenu');
			$xinha->addEditorPlugin('f_text', 'ImageManager');
			$xinha->addEditorPlugin('f_text', 'CharacterMap');


			//$xinha->addEditorPlugin('f_text', 'BackgroundImage');
			$xinha->addEditorPlugin('f_text', 'DynamicCSS');
			$xinha->addEditorPlugin('f_text', 'EditTag');
			$xinha->addEditorPlugin('f_text', 'FindReplace');
			$xinha->addEditorPlugin('f_text', 'InsertMarquee');
			$xinha->addEditorPlugin('f_text', 'InsertSmiley');
      //$xinha->addEditorPlugin('f_text', 'HtmlTidy');


			echo $xinha->getMainScript();
			echo $xinha->getConfig();
			?>
