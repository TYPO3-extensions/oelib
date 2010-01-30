<?php

########################################################################
# Extension Manager/Repository config file for ext "oelib".
#
# Auto generated 30-01-2010 13:19
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'One is Enough Library',
	'description' => 'This extension provides useful stuff for extension development: helper functions for unit testing, templating, automatic configuration checks and performance benchmarking.',
	'category' => 'services',
	'author' => 'Oliver Klee',
	'author_email' => 'typo3-coding@oliverklee.de',
	'shy' => 0,
	'dependencies' => 'static_info_tables',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => 'be_users,cache_pages,fe_groups,fe_users,pages,sys_template,tt_content,user_oelibtest_test,user_oelibtest_test_article_mm',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'author_company' => '',
	'version' => '0.6.5',
	'_md5_values_when_last_written' => 'a:141:{s:13:"changelog.txt";s:4:"ca43";s:29:"class.tx_oelib_Attachment.php";s:4:"f260";s:29:"class.tx_oelib_Autoloader.php";s:4:"bd81";s:38:"class.tx_oelib_BackEndLoginManager.php";s:4:"3de6";s:32:"class.tx_oelib_Configuration.php";s:4:"1f29";s:40:"class.tx_oelib_ConfigurationRegistry.php";s:4:"b236";s:29:"class.tx_oelib_DataMapper.php";s:4:"de2a";s:30:"class.tx_oelib_FakeSession.php";s:4:"1030";s:32:"class.tx_oelib_FileFunctions.php";s:4:"ac36";s:39:"class.tx_oelib_FrontEndLoginManager.php";s:4:"5c19";s:30:"class.tx_oelib_IdentityMap.php";s:4:"e809";s:23:"class.tx_oelib_List.php";s:4:"0218";s:23:"class.tx_oelib_Mail.php";s:4:"55ca";s:33:"class.tx_oelib_MapperRegistry.php";s:4:"a3c0";s:24:"class.tx_oelib_Model.php";s:4:"700d";s:25:"class.tx_oelib_Object.php";s:4:"6fe6";s:32:"class.tx_oelib_ObjectFactory.php";s:4:"ab5d";s:29:"class.tx_oelib_PageFinder.php";s:4:"b17b";s:31:"class.tx_oelib_PublicObject.php";s:4:"29a2";s:26:"class.tx_oelib_Session.php";s:4:"9f6f";s:27:"class.tx_oelib_Template.php";s:4:"8be8";s:35:"class.tx_oelib_TemplateRegistry.php";s:4:"e256";s:24:"class.tx_oelib_Timer.php";s:4:"4dbf";s:29:"class.tx_oelib_Translator.php";s:4:"2e15";s:37:"class.tx_oelib_TranslatorRegistry.php";s:4:"04f5";s:38:"class.tx_oelib_abstractHeaderProxy.php";s:4:"70a3";s:33:"class.tx_oelib_abstractMailer.php";s:4:"1efe";s:30:"class.tx_oelib_configcheck.php";s:4:"8955";s:37:"class.tx_oelib_configurationProxy.php";s:4:"c3a4";s:21:"class.tx_oelib_db.php";s:4:"3a79";s:33:"class.tx_oelib_emailCollector.php";s:4:"771f";s:34:"class.tx_oelib_headerCollector.php";s:4:"51c9";s:37:"class.tx_oelib_headerProxyFactory.php";s:4:"b90f";s:32:"class.tx_oelib_mailerFactory.php";s:4:"6930";s:34:"class.tx_oelib_realHeaderProxy.php";s:4:"633a";s:29:"class.tx_oelib_realMailer.php";s:4:"6e2f";s:37:"class.tx_oelib_salutationswitcher.php";s:4:"2f89";s:33:"class.tx_oelib_templatehelper.php";s:4:"dc21";s:35:"class.tx_oelib_testingFramework.php";s:4:"e280";s:12:"ext_icon.gif";s:4:"b4bf";s:17:"ext_localconf.php";s:4:"6f82";s:14:"ext_tables.php";s:4:"2297";s:14:"ext_tables.sql";s:4:"0a06";s:22:"icon_tx_oelib_test.gif";s:4:"bd58";s:16:"locallang_db.xml";s:4:"a70b";s:7:"tca.php";s:4:"628c";s:8:"todo.txt";s:4:"d400";s:28:"tx_oelib_commonConstants.php";s:4:"0182";s:51:"Exception/class.tx_oelib_Exception_AccessDenied.php";s:4:"369f";s:47:"Exception/class.tx_oelib_Exception_Database.php";s:4:"cf4d";s:55:"Exception/class.tx_oelib_Exception_EmptyQueryResult.php";s:4:"3ecd";s:47:"Exception/class.tx_oelib_Exception_NotFound.php";s:4:"693e";s:46:"Interface/class.tx_oelib_Interface_Address.php";s:4:"6250";s:51:"Interface/class.tx_oelib_Interface_LoginManager.php";s:4:"f3d7";s:47:"Interface/class.tx_oelib_Interface_MailRole.php";s:4:"dd45";s:44:"Mapper/class.tx_oelib_Mapper_BackEndUser.php";s:4:"f5ff";s:40:"Mapper/class.tx_oelib_Mapper_Country.php";s:4:"61e8";s:45:"Mapper/class.tx_oelib_Mapper_FrontEndUser.php";s:4:"0ba2";s:50:"Mapper/class.tx_oelib_Mapper_FrontEndUserGroup.php";s:4:"c900";s:41:"Mapper/class.tx_oelib_Mapper_Language.php";s:4:"c9af";s:42:"Model/class.tx_oelib_Model_BackEndUser.php";s:4:"9628";s:38:"Model/class.tx_oelib_Model_Country.php";s:4:"1d71";s:43:"Model/class.tx_oelib_Model_FrontEndUser.php";s:4:"b00a";s:48:"Model/class.tx_oelib_Model_FrontEndUserGroup.php";s:4:"eacc";s:39:"Model/class.tx_oelib_Model_Language.php";s:4:"11c4";s:40:"Resources/Private/Language/locallang.xml";s:4:"0494";s:21:"contrib/PEAR/PEAR.php";s:4:"9e9a";s:22:"contrib/PEAR/PEAR5.php";s:4:"2107";s:26:"contrib/PEAR/Mail/mime.php";s:4:"6faf";s:30:"contrib/PEAR/Mail/mimePart.php";s:4:"2cf9";s:30:"contrib/emogrifier/LICENSE.TXT";s:4:"8403";s:33:"contrib/emogrifier/emogrifier.php";s:4:"f03e";s:14:"doc/manual.sxw";s:4:"2ef7";s:38:"tests/tx_oelib_Attachment_testcase.php";s:4:"3e9b";s:38:"tests/tx_oelib_Autoloader_testcase.php";s:4:"9c5d";s:47:"tests/tx_oelib_BackEndLoginManager_testcase.php";s:4:"6640";s:49:"tests/tx_oelib_ConfigurationRegistry_testcase.php";s:4:"1e2a";s:41:"tests/tx_oelib_Configuration_testcase.php";s:4:"334b";s:38:"tests/tx_oelib_DataMapper_testcase.php";s:4:"9dc7";s:46:"tests/tx_oelib_Exception_Database_testcase.php";s:4:"77b5";s:54:"tests/tx_oelib_Exception_EmptyQueryResult_testcase.php";s:4:"1958";s:39:"tests/tx_oelib_FakeSession_testcase.php";s:4:"4582";s:48:"tests/tx_oelib_FrontEndLoginManager_testcase.php";s:4:"dd6b";s:39:"tests/tx_oelib_IdentityMap_testcase.php";s:4:"38e1";s:32:"tests/tx_oelib_List_testcase.php";s:4:"bbbc";s:32:"tests/tx_oelib_Mail_testcase.php";s:4:"68a0";s:42:"tests/tx_oelib_MapperRegistry_testcase.php";s:4:"2fa2";s:46:"tests/tx_oelib_Mapper_BackEndUser_testcase.php";s:4:"ba64";s:42:"tests/tx_oelib_Mapper_Country_testcase.php";s:4:"a9d3";s:52:"tests/tx_oelib_Mapper_FrontEndUserGroup_testcase.php";s:4:"b7c0";s:47:"tests/tx_oelib_Mapper_FrontEndUser_testcase.php";s:4:"5093";s:43:"tests/tx_oelib_Mapper_Language_testcase.php";s:4:"23d4";s:45:"tests/tx_oelib_Model_BackEndUser_testcase.php";s:4:"4f28";s:41:"tests/tx_oelib_Model_Country_testcase.php";s:4:"151d";s:51:"tests/tx_oelib_Model_FrontEndUserGroup_testcase.php";s:4:"dd1e";s:46:"tests/tx_oelib_Model_FrontEndUser_testcase.php";s:4:"aeff";s:42:"tests/tx_oelib_Model_Language_testcase.php";s:4:"b5da";s:33:"tests/tx_oelib_Model_testcase.php";s:4:"da2a";s:41:"tests/tx_oelib_ObjectFactory_testcase.php";s:4:"650b";s:34:"tests/tx_oelib_Object_testcase.php";s:4:"6a6e";s:38:"tests/tx_oelib_PageFinder_testcase.php";s:4:"2b39";s:35:"tests/tx_oelib_Session_testcase.php";s:4:"3730";s:44:"tests/tx_oelib_TemplateRegistry_testcase.php";s:4:"28ad";s:36:"tests/tx_oelib_Template_testcase.php";s:4:"f368";s:33:"tests/tx_oelib_Timer_testcase.php";s:4:"fc27";s:46:"tests/tx_oelib_TranslatorRegistry_testcase.php";s:4:"9f38";s:38:"tests/tx_oelib_Translator_testcase.php";s:4:"142f";s:46:"tests/tx_oelib_configurationCheck_testcase.php";s:4:"7681";s:46:"tests/tx_oelib_configurationProxy_testcase.php";s:4:"7776";s:30:"tests/tx_oelib_db_testcase.php";s:4:"543b";s:46:"tests/tx_oelib_headerProxyFactory_testcase.php";s:4:"749b";s:41:"tests/tx_oelib_mailerFactory_testcase.php";s:4:"52a3";s:38:"tests/tx_oelib_phpmyadmin_testcase.php";s:4:"947c";s:51:"tests/tx_oelib_salutationswitcherchild_testcase.php";s:4:"77e1";s:47:"tests/tx_oelib_templatehelperchild_testcase.php";s:4:"95ae";s:44:"tests/tx_oelib_testingFramework_testcase.php";s:4:"c91a";s:52:"tests/fixtures/class.tx_oelib_dummyObjectToCheck.php";s:4:"5f39";s:57:"tests/fixtures/class.tx_oelib_salutationswitcherchild.php";s:4:"991c";s:53:"tests/fixtures/class.tx_oelib_templatehelperchild.php";s:4:"2abe";s:47:"tests/fixtures/class.tx_oelib_testingObject.php";s:4:"623b";s:72:"tests/fixtures/class.tx_oelib_tests_fixtures_ColumnLessTestingMapper.php";s:4:"9ef3";s:54:"tests/fixtures/class.tx_oelib_tests_fixtures_Empty.php";s:4:"c6b4";s:71:"tests/fixtures/class.tx_oelib_tests_fixtures_ModelLessTestingMapper.php";s:4:"7b42";s:60:"tests/fixtures/class.tx_oelib_tests_fixtures_NotIncluded.php";s:4:"b8c6";s:66:"tests/fixtures/class.tx_oelib_tests_fixtures_NotIncludedEither.php";s:4:"48d7";s:62:"tests/fixtures/class.tx_oelib_tests_fixtures_ReadOnlyModel.php";s:4:"2198";s:71:"tests/fixtures/class.tx_oelib_tests_fixtures_TableLessTestingMapper.php";s:4:"7763";s:67:"tests/fixtures/class.tx_oelib_tests_fixtures_TestingChildMapper.php";s:4:"52ac";s:66:"tests/fixtures/class.tx_oelib_tests_fixtures_TestingChildModel.php";s:4:"bdd7";s:64:"tests/fixtures/class.tx_oelib_tests_fixtures_TestingMailRole.php";s:4:"2a96";s:62:"tests/fixtures/class.tx_oelib_tests_fixtures_TestingMapper.php";s:4:"3fbf";s:61:"tests/fixtures/class.tx_oelib_tests_fixtures_TestingModel.php";s:4:"d92e";s:28:"tests/fixtures/locallang.xml";s:4:"c52b";s:25:"tests/fixtures/oelib.html";s:4:"59ca";s:23:"tests/fixtures/test.css";s:4:"0acf";s:23:"tests/fixtures/test.png";s:4:"c7b6";s:25:"tests/fixtures/test_2.css";s:4:"4a4a";s:33:"tests/fixtures/user_oelibtest.t3x";s:4:"322c";s:34:"tests/fixtures/user_oelibtest2.t3x";s:4:"56c7";s:69:"tests/fixtures/pi1/class.tx_oelib_tests_fixtures_pi1_NotIncluded1.php";s:4:"34d7";s:64:"tests/fixtures/xclass/class.ux_tx_oelib_tests_fixtures_Empty.php";s:4:"530f";}',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.2.0-0.0.0',
			'static_info_tables' => '2.0.8-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
);

?>