<?php
try{
	switch ($_GET["mcmd"]) {
		// list ankiet *********************************************************************************
		case "1":{
			$ankety_all = new CMS_InquiryList();
			$ankety_all->execute();
			$GLOBALS["smarty"]->assign("language_list_local",$GLOBALS['LanguageListLocal']);
			$GLOBALS["smarty"]->assign("ankety_list",$ankety_all);
			$GLOBALS["smarty"]->display("list.tpl");
		}
		break;
		//*************************************************************************************************
		
		// nova anketa *********************************************************************************
		case "2":{
			$GLOBALS["smarty"]->display("new.tpl");
		}
		break;
		//*************************************************************************************************
		
		// update ankety *********************************************************************************
		case "3":{
			$anketa = new CMS_Inquiry($_REQUEST['row_id'][0]);
			$anketa->execute();
			
			$questions = $anketa->getQuestions();
			
			$GLOBALS["smarty"]->assign("anketa",$anketa);
			$GLOBALS["smarty"]->assign("questions",$questions);
			$GLOBALS["smarty"]->display("edit.tpl");
		}
		break;
		//*************************************************************************************************
		
	}	
}
catch(CN_Exception $e){
	echo $e->displayDetails();
}
?>
