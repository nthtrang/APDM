<?php
/**
* @version		$Id:mod_menu.php 2463 2006-02-18 06:05:38Z webImagery $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(dirname(__FILE__).DS.'menu.php');

class modMenuHelper
{
	/**
	 * Show the menu
	 * @param string The current user type
	 */
	function buildMenu()
	{
		global $mainframe;

		$lang		= & JFactory::getLanguage();
		$user		= & JFactory::getUser();
		$db			= & JFactory::getDBO();
		$usertype	= $user->get('usertype');
		//echo $usertype; exit;
		//get user have exist or enable on table apdm_user

		$db->setQuery("SELECT user_id, user_enable FROM apdm_users WHERE user_id=".$user->get('id'));
	//	echo "SELECT user_id, user_enable FROM apdm_users WHERE user_id=".$user->get('id');
		$result= $db->loadObjectList();
		if ($result) {
			$user_apdm = $result[0]->user_enable; //enable
		}else{
			$user_apdm = 1;
		}
		if (trim($usertype) =='Super Administrator'){
			$user_apdm = 0;
		}
		//echo $user_apdm; 
		if ($usertype =='Manager') {
				$role1 = JAdministrator::RoleOnComponent(1); //CCS	
				$role2 = JAdministrator::RoleOnComponent(2); //SP. VD, MF
				$role5 = JAdministrator::RoleOnComponent(5); // ECO
				$role6 = JAdministrator::RoleOnComponent(6); //PNs
                                $role7 = JAdministrator::RoleOnComponent(7); //PO
                                $role8 = JAdministrator::RoleOnComponent(8); //STO
                                $role9 = JAdministrator::RoleOnComponent(9); //Location
				$arr_role = array_merge($role1, $role2, $role5, $role6, $role7, $role8, $role9);
		}
	

		// cache some acl checks
		$canCheckin			= $user->authorize('com_checkin', 'manage');
		$canConfig			= $user->authorize('com_config', 'manage');
		$manageTemplates	= $user->authorize('com_templates', 'manage');
		$manageTrash		= $user->authorize('com_trash', 'manage');
		$manageMenuMan		= $user->authorize('com_menus', 'manage');
		$manageLanguages	= $user->authorize('com_languages', 'manage');
		$installModules		= $user->authorize('com_installer', 'module');
		$editAllModules		= $user->authorize('com_modules', 'manage');
		$installPlugins		= $user->authorize('com_installer', 'plugin');
		$editAllPlugins		= $user->authorize('com_plugins', 'manage');
		$installComponents	= $user->authorize('com_installer', 'component');
		$editAllComponents	= $user->authorize('com_components', 'manage');
		$canMassMail		= $user->authorize('com_massmail', 'manage');
		$canManageUsers		= $user->authorize('com_users', 'manage');

		// Menu Types
		require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_menus'.DS.'helpers'.DS.'helper.php' );
		$menuTypes 	= MenusHelper::getMenuTypelist();

		/*
		 * Get the menu object
		 */
		$menu = new JAdminCSSMenu();
	if ($user_apdm) {
		/*
		 * Site SubMenu
		 */
                
		$menu->addChild(new JMenuNode(JText::_('Site')), true);
		$menu->addChild(new JMenuNode(JText::_('Control Panel'), 'index.php', 'class:cpanel'));
		$menu->addSeparator();
		if ($canManageUsers && $canConfig) {
			$menu->addChild(new JMenuNode(JText::_('User Manager'), 'index.php?option=com_users&task=view', 'class:user'));
		//}
		$menu->addChild(new JMenuNode(JText::_('Media Manager'), 'index.php?option=com_media', 'class:media'));
		$menu->addSeparator();
		//if ($canConfig) {
			$menu->addChild(new JMenuNode(JText::_('Configuration'), 'index.php?option=com_config', 'class:config'));
			$menu->addSeparator();
		}
		$menu->addChild(new JMenuNode(JText::_('Logout'), 'index.php?option=com_login&task=logout', 'class:logout'));

		$menu->getParent();
	}
//	if ($user_apdm ){
		/*
		 * Control SubMenu
		 */
		if (!$user_apdm) {
//			$menu->addChild(new JMenuNode(JText::_('Sitea')), true);
                        $menu->addChild(new JMenuNode(JText::_('Dashboard'), 'index.php?option=com_apdmeco&task=dashboard'));
                        //Hide 09/12/2018        
                          //$menu->addChild(new JMenuNode(JText::_('Control Panel'), 'index.php'), 'class:dashboard');
		 	//$menu->getParent();
		 }
	//}
		/*
		 * Menus SubMenu
		 */
	 if ($canManageUsers && $canConfig) { //for supper admin
		$menu->addChild(new JMenuNode(JText::_('Menus')), true);
		if ($manageMenuMan) {
			$menu->addChild(new JMenuNode(JText::_('Menu Manager'), 'index.php?option=com_menus', 'class:menu'));
		}
		if ($manageTrash) {
			$menu->addChild(new JMenuNode(JText::_('Menu Trash'), 'index.php?option=com_trash&task=viewMenu', 'class:trash'));
		}

		if($manageTrash || $manageMenuMan) {
			$menu->addSeparator();
		}
		/*
		 * SPLIT HR
		 */
		if (count($menuTypes)) {
			foreach ($menuTypes as $menuType) {
				$menu->addChild(new JMenuNode($menuType->title.($menuType->home ? ' *' : ''), 'index.php?option=com_menus&task=view&menutype='.$menuType->menutype, 'class:menu'));
			}
		}
		
		$menu->getParent();
	} //enf fo submenu of suppler admin
	if (($user_apdm && $user->get('id')) || ($canManageUsers && $canConfig))	{
		/*
		 * Content SubMenu
		 */
		$menu->addChild(new JMenuNode(JText::_('Content')), true);
		$menu->addChild(new JMenuNode(JText::_('Article Manager'), 'index.php?option=com_content', 'class:article'));
		if ($manageTrash) {
			$menu->addChild(new JMenuNode(JText::_('Article Trash'), 'index.php?option=com_trash&task=viewContent', 'class:trash'));
		}
		$menu->addSeparator();
		$menu->addChild(new JMenuNode(JText::_('Section Manager'), 'index.php?option=com_sections&scope=content', 'class:section'));
		$menu->addChild(new JMenuNode(JText::_('Category Manager'), 'index.php?option=com_categories&section=com_content', 'class:category'));
		$menu->addSeparator();
		$menu->addChild(new JMenuNode(JText::_('Frontpage Manager'), 'index.php?option=com_frontpage', 'class:frontpage'));
		
		$menu->getParent();
	} // end for content Menu
		/*
		 * Components SubMenu
		 */
		if ($editAllComponents)
		{
			$menu->addChild(new JMenuNode(JText::_('Components')), true);
		if ($canManageUsers && $canConfig || ($usertype=='Administrator' && $user_apdm) ){
			$query = 'SELECT *' .
				' FROM #__components' .
				' WHERE '.$db->NameQuote( 'option' ).' <> "com_frontpage"' .
				' AND '.$db->NameQuote( 'option' ).' <> "com_media"' .
				' AND enabled = 1' .
				' AND id NOT IN (34, 37, 40, 41, 42, 43, 44, 45, 46, 47, 48,50,52,53,54,55,56,57) '.
				' ORDER BY ordering, name';
		}else{ 
			if ($usertype=='Administrator' && $user_apdm==0){
				$query = 'SELECT *' .
				' FROM #__components' .
				' WHERE id IN (34, 37, 40, 41, 42, 43, 44, 45, 46, 47, 48,50,52,53,54,55,56,57)'.
				' AND '.$db->NameQuote( 'option' ).' <> "com_media"' .
				' AND enabled = 1' .
				' ORDER BY ordering, name';
			}elseif ($usertype=='Manager' && $user_apdm==0){
				$list_recyle_bin = '';
				if(in_array("R", $arr_role)){
					$list_recyle_bin = ', 43, 44, 45, 46, 47';
				}
				$query = 'SELECT *' .
				' FROM #__components' .
				' WHERE id IN (57,56,55,53,54,52,40, 41, 42, 48,50 '.$list_recyle_bin.' )'.
				' AND '.$db->NameQuote( 'option' ).' <> "com_media"' .
				' AND enabled = 1' .
				' ORDER BY ordering, name';
			}

		}
		
		if($usertype=='Super Administrator'){
			$query = 'SELECT *' .
				' FROM #__components' .
				' WHERE '.$db->NameQuote( 'option' ).' <> "com_frontpage"' .
				' AND '.$db->NameQuote( 'option' ).' <> "com_media"' .
				' AND enabled = 1' .				
				' ORDER BY ordering, name';
		}
			$db->setQuery($query);
			$comps = $db->loadObjectList(); // component list
			$subs = array(); // sub menus
			$langs = array(); // additional language files to load

			// first pass to collect sub-menu items
			foreach ($comps as $row)
			{
				if ($row->parent)
				{
					if (!array_key_exists($row->parent, $subs)) {
						$subs[$row->parent] = array ();
					}
					$subs[$row->parent][] = $row;
					$langs[$row->option.'.menu'] = true;
				} elseif (trim($row->admin_menu_link)) {
					$langs[$row->option.'.menu'] = true;
				}
			}

			// Load additional language files
			if (array_key_exists('.menu', $langs)) {
				unset($langs['.menu']);
			}
			foreach ($langs as $lang_name => $nothing) {
				$lang->load($lang_name);
			}

			foreach ($comps as $row)
			{
				if ($editAllComponents | $user->authorize('administration', 'edit', 'components', $row->option))
				{
					if ($row->parent == 0 && (trim($row->admin_menu_link) || array_key_exists($row->id, $subs)))
					{
						$text = $lang->hasKey($row->option) ? JText::_($row->option) : $row->name;
						$link = $row->admin_menu_link ? "index.php?$row->admin_menu_link" : "index.php?option=$row->option";
						if (array_key_exists($row->id, $subs)) {
							$menu->addChild(new JMenuNode($text, $link, $row->admin_menu_img), true);
							foreach ($subs[$row->id] as $sub) {
								$key  = $row->option.'.'.$sub->name;
								$text = $lang->hasKey($key) ? JText::_($key) : $sub->name;
								$link = $sub->admin_menu_link ? "index.php?$sub->admin_menu_link" : null;
								$menu->addChild(new JMenuNode($text, $link, $sub->admin_menu_img));
							}
							$menu->getParent();
						} else {
							$menu->addChild(new JMenuNode($text, $link, $row->admin_menu_img));
						}
					}
				}
			}
			$menu->getParent();
                      
                        //get component id of role			
                        $usertype	= $user->get('usertype');
                        if (trim($usertype) =='Super Administrator'){
                                $user_apdm = 0;
                        }
                        $db->setQuery("SELECT role_id FROM  apdm_role_user WHERE user_id=".$user->get("id"));
                       
			$role_result = $db->loadObjectList();
			$arr_role1 = array(0);
			if (count($role_result) > 0){
				foreach ($role_result as $obj){
					$arr_role1[] = $obj->role_id;
				}
			}                        
			 $db->setQuery("SELECT  DISTINCT component_id from apdm_role_component where role_id IN (".implode(",", $arr_role1).") ");
                         $result_com = $db->loadObjectList();		
                         $arr_component= array();
			 if (count($result_com) > 0){
			 	foreach ($result_com as $com){
					$arr_component[] = $com->component_id;
				}
			 }
                         	$menu->addSeparator();		 
                        //PO
			if($user_apdm==0 &&  (in_array(7, $arr_component) || $usertype =='Administrator' || $usertype=="Super Administrator" )){                               
				$menu->addChild(new JMenuNode(JText::_('Internal PO'), 'index.php?option=com_apdmpns&task=pomanagement', 'class:dashboard'));                               
			}                        
			//STO
			/*if($user_apdm==0 &&  (in_array(8, $arr_component) || $usertype =='Administrator' || $usertype=="Super Administrator" )){
				$menu->addChild(new JMenuNode(JText::_('STO'), 'index.php?option=com_apdmpns&task=stomanagement', 'class:dashboard'));                        
			} */
                        //SO
			if($user_apdm==0 &&  (in_array(8, $arr_component) || $usertype =='Administrator' || $usertype=="Super Administrator" )){                                
				$menu->addChild(new JMenuNode(JText::_('SO'), 'index.php?option=com_apdmpns&task=somanagement', 'class:dashboard'));                        
			}     
                        //NEW STO
			if($user_apdm==0 &&  (in_array(8, $arr_component) || $usertype =='Administrator' || $usertype=="Super Administrator" )){                                
				$menu->addChild(new JMenuNode(JText::_('Inventory'), 'index.php?option=com_apdmsto', 'class:dashboard'));
			}  
                        //NEW STO
			if($user_apdm==0 &&  (in_array(8, $arr_component) || $usertype =='Administrator' || $usertype=="Super Administrator" )){                                
				$menu->addChild(new JMenuNode(JText::_('Tool Tracker'), 'index.php?option=com_apdmtto', 'class:dashboard'));
			} 
		}

		/*
		 * Extensions SubMenu
		 */
		//if ($installModules )
		if ($canManageUsers && $canConfig)
		{
			$menu->addChild(new JMenuNode(JText::_('Extensions')), true);

			$menu->addChild(new JMenuNode(JText::_('Install/Uninstall'), 'index.php?option=com_installer', 'class:install'));
			$menu->addSeparator();
			if ($editAllModules) {
				$menu->addChild(new JMenuNode(JText::_('Module Manager'), 'index.php?option=com_modules', 'class:module'));
			}
			if ($editAllPlugins) {
				$menu->addChild(new JMenuNode(JText::_('Plugin Manager'), 'index.php?option=com_plugins', 'class:plugin'));
			}
			if ($manageTemplates) {
				$menu->addChild(new JMenuNode(JText::_('Template Manager'), 'index.php?option=com_templates', 'class:themes'));
			}
			if ($manageLanguages) {
				$menu->addChild(new JMenuNode(JText::_('Language Manager'), 'index.php?option=com_languages', 'class:language'));
			}
			$menu->getParent();
		}

		/*
		 * System SubMenu
		 */
		//if ($canConfig || $canCheckin)
		if ($canManageUsers && $canConfig)
		{
			$menu->addChild(new JMenuNode(JText::_('Tools')), true);

			if ($canConfig) {
				$menu->addChild(new JMenuNode(JText::_('Read Messages'), 'index.php?option=com_messages', 'class:messages'));
				$menu->addChild(new JMenuNode(JText::_('Write Message'), 'index.php?option=com_messages&task=add', 'class:messages'));
				$menu->addSeparator();
			}
			if ($canMassMail) {
				$menu->addChild(new JMenuNode(JText::_('Mass Mail'), 'index.php?option=com_massmail', 'class:massmail'));
				$menu->addSeparator();
			}
			if ($canCheckin) {
				$menu->addChild(new JMenuNode(JText::_('Global Checkin'), 'index.php?option=com_checkin', 'class:checkin'));
				$menu->addSeparator();
			}
			$menu->addChild(new JMenuNode(JText::_('Clean Cache'), 'index.php?option=com_cache', 'class:config'));

			$menu->getParent();
		}

		/*
		 * Help SubMenu
		 */
	  if ($canManageUsers && $canConfig){
		$menu->addChild(new JMenuNode(JText::_('Help')), true);
		$menu->addChild(new JMenuNode(JText::_('Joomla! Help'), 'index.php?option=com_admin&task=help', 'class:help'));
		$menu->addChild(new JMenuNode(JText::_('System Info'), 'index.php?option=com_admin&task=sysinfo', 'class:info'));

		$menu->getParent();
	  }

		$menu->renderMenu('menu', '');
	}

	/**
	 * Show an disbaled version of the menu, used in edit pages
	 *
	 * @param string The current user type
	 */
	function buildDisabledMenu()
	{
		$lang	 =& JFactory::getLanguage();
		$user	 =& JFactory::getUser();
		$usertype = $user->get('usertype');

		$canConfig			= $user->authorize('com_config', 'manage');
		$installModules		= $user->authorize('com_installer', 'module');
		$editAllModules		= $user->authorize('com_modules', 'manage');
		$installPlugins		= $user->authorize('com_installer', 'plugin');
		$editAllPlugins		= $user->authorize('com_plugins', 'manage');
		$installComponents	= $user->authorize('com_installer', 'component');
		$editAllComponents	= $user->authorize('com_components', 'manage');
		$canMassMail			= $user->authorize('com_massmail', 'manage');
		$canManageUsers		= $user->authorize('com_users', 'manage');

		$text = JText::_('Menu inactive for this Page', true);

		// Get the menu object
		$menu = new JAdminCSSMenu();

		// Site SubMenu
		$menu->addChild(new JMenuNode(JText::_('Site'), null, 'disabled'));

		// Menus SubMenu
		$menu->addChild(new JMenuNode(JText::_('Menus'), null, 'disabled'));

		// Content SubMenu
		$menu->addChild(new JMenuNode(JText::_('Content'), null, 'disabled'));

		// Components SubMenu
		if ($installComponents) {
			$menu->addChild(new JMenuNode(JText::_('Components'), null, 'disabled'));
		}

		// Extensions SubMenu
		if ($installModules) {
			$menu->addChild(new JMenuNode(JText::_('Extensions'), null, 'disabled'));
		}

		// System SubMenu
		if ($canConfig) {
			$menu->addChild(new JMenuNode(JText::_('Tools'),  null, 'disabled'));
		}

		// Help SubMenu
		$menu->addChild(new JMenuNode(JText::_('Help'),  null, 'disabled'));

		$menu->renderMenu('menu', 'disabled');
	}
}
?>
