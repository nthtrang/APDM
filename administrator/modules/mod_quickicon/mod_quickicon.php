<?php
/**
* @version		$Id: mod_quickicon.php 10381 2008-06-01 03:35:53Z pasamio $
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
defined( '_JEXEC' ) or die( 'Restricted access' );

if (!defined( '_JOS_QUICKICON_MODULE' ))
{
	/** ensure that functions are declared only once */
	define( '_JOS_QUICKICON_MODULE', 1 );

	function quickiconButton( $link, $image, $text )
	{
		global $mainframe;
		$lang		=& JFactory::getLanguage();
		$template	= $mainframe->getTemplate();
		
		
		
		?>
		<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
				<a href="<?php echo $link; ?>">
					<?php echo JHTML::_('image.site',  $image, '/templates/'. $template .'/images/header/', NULL, NULL, $text ); ?>
					<span><?php echo $text; ?></span></a>
			</div>
		</div>
		<?php
	}

	?>
	<div id="cpanel">
		<?php
		// Get the current JUser object
		$user = &JFactory::getUser();
		$db			= & JFactory::getDBO();		
		
		$db->setQuery("SELECT user_id, user_enable FROM apdm_users WHERE user_id=".$user->get('id'));
		$result= $db->loadObjectList();
		if ($result) {
			$user_apdm = $result[0]->user_enable;
		}else{
			$user_apdm = 1;
		}
		
		
		$usertype	= $user->get('usertype');
		if (trim($usertype) =='Super Administrator'){
			$user_apdm = 0;
		}
		 $arr_component = array();
		if (trim($usertype)=="Manager") {		
			//get role of user
			$db->setQuery("SELECT role_id FROM  apdm_role_user WHERE user_id=".$user->get("id"));
			$role_result = $db->loadObjectList();
			$arr_role = array();
			if (count($role_result) > 0){
				foreach ($role_result as $obj){
					$arr_role[] = $obj->role_id;
				}
			}
			
			//get component id of role			
			 $db->setQuery("SELECT  DISTINCT component_id from apdm_role_component where role_id IN (".implode(",", $arr_role).") ");
			 $result_com = $db->loadObjectList();
			
			
			 if (count($result_com) > 0){
			 	foreach ($result_com as $com){
					$arr_component[] = $com->component_id;
				}
			 }
			 
			///end get role
		}		
		if (trim($usertype) == 'Super Administrator' || ($user_apdm && $user->get('id'))) {
			$link = 'index.php?option=com_content&amp;task=add';
			quickiconButton( $link, 'icon-48-article-add.png', JText::_( 'ADD NEW ARTICLE' ) );
	
			$link = 'index.php?option=com_content';
			quickiconButton( $link, 'icon-48-article.png', JText::_( 'ARTICLE MANAGER' ) );
	
			$link = 'index.php?option=com_frontpage';
			quickiconButton( $link, 'icon-48-frontpage.png', JText::_( 'FRONTPAGE MANAGER' ) );
	
			$link = 'index.php?option=com_sections&amp;scope=content';
			quickiconButton( $link, 'icon-48-section.png', JText::_( 'SECTION MANAGER' ) );
	
			$link = 'index.php?option=com_categories&amp;section=com_content';
			quickiconButton( $link, 'icon-48-category.png', JText::_( 'CATEGORY MANAGER' ) );
	
			$link = 'index.php?option=com_media';
			quickiconButton( $link, 'icon-48-media.png', JText::_( 'MEDIA MANAGER' ) );
			
			if ( $user->get('gid') > 23 ) {
				$link = 'index.php?option=com_menus';
				quickiconButton( $link, 'icon-48-menumgr.png', JText::_( 'MENU MANAGER' ) );
				
				$link = 'index.php?option=com_users';
				quickiconButton( $link, 'icon-48-user.png', JText::_( 'USER MANAGER' ) );
		    }

		} //end 
			///Commodity code
			if($user_apdm==0 && (in_array(1, $arr_component) || $usertype =='Administrator' || $usertype=="Super Administrator" )) {
				$link = 'index.php?option=com_apdmccs';
				quickiconButton( $link, 'icon-48-category.png', JText::_( 'CC MANAGER' ) );
			}
			
			//PNs
			if($user_apdm==0 &&  (in_array(6, $arr_component) || $usertype =='Administrator' || $usertype=="Super Administrator" )){
				$link = 'index.php?option=com_apdmpns';
				quickiconButton( $link, 'icon-48-cpanel.png', JText::_( 'PN MANAGER' ) );
			}
			//suplier
			if($user_apdm==0 &&  (in_array(2, $arr_component) || $usertype =='Administrator' || $usertype=="Super Administrator")){
				$link = 'index.php?option=com_apdmsuppliers';
				quickiconButton( $link, 'icon-48-category.png', JText::_( 'ORGANIZATION MANAGER' ) );
			}
			
			//ECO
			if($user_apdm==0 &&  (in_array(5, $arr_component) || $usertype =='Administrator' || $usertype=="Super Administrator" )){
				$link = 'index.php?option=com_apdmeco';
				quickiconButton( $link, 'icon-48-category.png', JText::_( 'ECO MANAGER' ) );
			}
			//Profile
			if ($user_apdm==0) {
				$link = 'index.php?option=com_apdmusers&view=apdmuser&task=profile&cid[]='.$user->get('id');
				quickiconButton( $link, 'icon-48-user.png', JText::_( 'Profile' ) );
			
			if ($usertype =='Administrator' || $usertype=="Super Administrator") {
			
				$link = 'index.php?option=com_apdmusers';
				quickiconButton( $link, 'icon-48-user.png', JText::_( 'APDM USER MANAGER' ) );
			
				$link = 'index.php?option=com_roles';
				quickiconButton( $link, 'icon-48-config.png', JText::_( 'ROLES MANAGER' ) );
				
				$link = 'index.php?option=com_history';
				quickiconButton( $link, 'icon-48-content.png', JText::_( 'HISTORY MANAGER' ) );
				
			}
			}
			
			if ($user_apdm==0 && $usertype =='Manager') {
				$role1 = JAdministrator::RoleOnComponent(1); //CCS	
				$role2 = JAdministrator::RoleOnComponent(2); //SP. VD, MF
				$role5 = JAdministrator::RoleOnComponent(5); // ECO
				$role6 = JAdministrator::RoleOnComponent(6); //PNs
				$arr_role = array_merge($role1, $role2, $role5, $role6);
				if (in_array('R', $arr_role)){
					$link = 'index.php?option=com_apdmrecylebin';
					quickiconButton( $link, 'icon-48-trash.png', JText::_( 'RECYCLE BIN MANAGER' ) );
				}
			}else{
				if ($user_apdm==0) {
					$link = 'index.php?option=com_apdmrecylebin';
					quickiconButton( $link, 'icon-48-trash.png', JText::_( 'RECYCLE BIN MANAGER' ) );
					
					$link = 'index.php?option=com_config';
					quickiconButton( $link, 'icon-48-config.png', JText::_( 'GLOBAL CONFIGURATION' ) );
				}
			}
	

		if ( $user->get('gid') > 24 ) {
			$link = 'index.php?option=com_languages&amp;client=0';
			quickiconButton( $link, 'icon-48-language.png', JText::_( 'Language Manager' ) );
		}
		$link = 'index.php?option=com_apdmpns&task=searchall';
			quickiconButton( $link, 'icon-48-search.png', JText::_( 'Search' ) );
	/*	if ( $user->get('gid') > 24 ) {
			$link = 'index.php?option=com_config';
			quickiconButton( $link, 'icon-48-config.png', JText::_( 'Global Configuration' ) );
		} */
		?>
	</div>
	<?php 
}
?>