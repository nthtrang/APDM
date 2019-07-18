<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
$cid = JRequest::getVar('cid', array(0));
$route = JRequest::getVar('routes');
$role = JAdministrator::RoleOnComponent(5);
//$tabfiles = '<button onclick="javascript:hideMainMenu(); submitbutton(\'files\')" class="buttonfiles" style="vertical-align:middle"><span>Files </span></button>';
//  $tabSummary = '<button onclick="javascript:hideMainMenu(); submitbutton(\'summary\')" class="buttonfiles" style="vertical-align:middle"><span>Summary </span></button>';
//  $tabAffected  = '<button onclick="javascript:hideMainMenu(); submitbutton(\'affected\')" class="buttonaffected" style="vertical-align:middle"><span>Affected Parts </span></button>';
$demote = $promote = "";
$me = & JFactory::getUser();
$add_routes = "";
$arrayNotAllow = array("Closed","Finished");
if ($this->row->eco_create_by == $me->get('id') && $this->row->eco_status != "Released") {

        $add_routes = '<a href="javascript:;"id="lnkfichier" title="Add more approvers " >' . JText::_('Click here to add more approvers') . '</a>';
        if ($route == $this->row->eco_routes_id) {
                if(!in_array($this->arr_route[0]->status,$arrayNotAllow)){
                        $promote = '<button onclick="javascript:hideMainMenu(); submitbutton(\'promote\')" class="button_promote" style="vertical-align:middle"><span>Promote</span></button>';                        
                }
                $demote = '<button onclick="javascript:hideMainMenu(); submitbutton(\'demote\')" class="button_demote" style="vertical-align:middle"><span>Demote </span></button>';
                
        }
}

JToolBarHelper::title(JText::_($this->row->eco_name) . $demote . $promote, 'generic.png');
//JToolBarHelper::title( JText::_($this->rowrowEco->eco_name));        
$arrayAllowSetRoute = array("Create","Started");                                        
if(in_array($this->arr_route[0]->status,$arrayAllowSetRoute))
{
        JToolBarHelper::customX("set_route_eco", 'apply', '', 'Set Route', true);
}

if(!in_array($this->arr_route[0]->status,$arrayNotAllow))
{
        JToolBarHelper::customX("approvers", 'save', '', 'Save', true);
}

JToolBarHelper::cancel('cancel', 'Back');
$cparams = JComponentHelper::getParams('com_media');

// clean itemrow-> data
JFilterOutput::objectHTMLSafe($user, ENT_QUOTES, '');
?>
<script language="javascript" type="text/javascript">
        function submitbutton(pressbutton) {
                var form = document.adminForm;
                if (pressbutton == 'summary') {
                        window.location.assign("index.php?option=com_apdmeco&task=detail&cid[]=<?php echo $this->row->eco_id ?>")
                        return;
                }
                //		if (pressbutton == 'files') {
                //			  window.location.assign("index.php?option=com_apdmeco&task=files&cid[]=<?php echo $this->row->eco_id ?>");
                //			return;
                //		}   
                if (pressbutton == 'demote') {
                        window.location.assign("index.php?option=com_apdmeco&task=demote&cid[]=<?php echo $this->row->eco_id ?>&routes=<?php echo $cid = JRequest::getVar('routes'); ?>&time=<?php echo time(); ?>");
                        return;
                }  
                if (pressbutton == 'promote') {
                        window.location.assign("index.php?option=com_apdmeco&task=promote&cid[]=<?php echo $this->row->eco_id ?>&routes=<?php echo $cid = JRequest::getVar('routes'); ?>&time=<?php echo time(); ?>");
                        return;
                }   
                if (pressbutton == 'affected') {
                        window.location.assign("index.php?option=com_apdmeco&task=affected&cid[]=<?php echo $this->row->eco_id ?>&time=<?php echo time(); ?>");
                        return;
                }
                if (pressbutton == 'cancel') {
                    window.location.assign("index.php?option=com_apdmeco&task=routes&cid[]=<?php echo $this->row->eco_id ?>&time=<?php echo time(); ?>");
                    return;
                }
                 if (pressbutton == 'set_route_eco') {
                    window.location.assign("index.php?option=com_apdmeco&task=set_route_eco&cid[]=<?php echo $this->row->eco_id ?>&time=<?php echo time(); ?>&id=<?php echo $cid = JRequest::getVar('routes'); ?>");
                    return;
                }
            if (pressbutton == 'approvers') {
                        document.adminForm.submit();
                        //submitform( pressbutton );
                        //return;
                }
                var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");	
        }
        
        ///for add more file
        window.addEvent('domready', function(){
                //File Input Generate
                var mid=0;			
                var mclick=1;
                $$(".iptfichier tr").each(function(itext,id) {                               
                        //	if (mid!=0)
                        itext.style.display = "none";
                        mid++;
                });
                $('lnkfichier').addEvents ({				
                        'click':function(){	
                                if (mclick<mid) {
                                        $$(".iptfichier tr")[mclick].style.display="block";
                                        //	alert($$(".iptfichier input")[mclick].style.display);
                                        mclick++;
                                }
                        }
                });	
        });    
                
        function removeApprove(id){
                document.getElementById(id).style.visibility= 'hidden';
                document.getElementById(id).style.display= 'none';
        }
</script>
<style>
        .buttonfiles {
                display: inline-block;
                border-radius: 4px;
                background-color: #f49542;
                border: none;
                color: white;
                text-align: center;
                font-size: 16px;
                padding: 10px 32px;
                width: 120px;
                transition: all 0.5s;
                cursor: pointer;
                margin-left: 30px;
        }

        .buttonaffected {
                display: inline-block;
                border-radius: 4px;
                background-color: #f49542;
                border: none;
                color: white;
                text-align: center;
                font-size: 16px;
                padding: 10px 32px;
                width: 180px;
                transition: all 0.5s;
                cursor: pointer;
                margin-left: 30px;
        }

        .button_demote {
                display: inline-block;
                border-radius: 4px;
                background-color: #A4A1AE;
                border: none;
                color: white;
                text-align: center;
                font-size: 12px;
                padding: 6px 20px;
                width: 100px;
                transition: all 0.5s;
                cursor: pointer;
                margin-left: 30px;
        }

        .button_promote {
                display: inline-block;
                border-radius: 4px;
                background-color: #759BBD;
                border: none;
                color: white;
                text-align: center;
                font-size: 12px;
                padding: 6px 20px;
                width: 160px;
                transition: all 0.5s;
                cursor: pointer;
                margin-left: 30px;
        }
</style>
<?php
$me = & JFactory::getUser();
$me->get('email');
$owner = $this->row->eco_create_by;
$link = "index.php?option=com_apdmeco&amp;task=saveapprove&amp;cid[]=" . $this->row->eco_id . "&amp;time=" . time();
if ($owner == $me->get('id')) {
        //       echo $add_routes;
        $link = "index.php?option=com_apdmeco&amp;task=addapprove&amp;cid[]=" . $this->row->eco_id . "&amp;time=" . time();
}
?>

<div class="submenu-box">
        <div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
                <ul id="submenu" class="configuration">
                        <li><a id="detail" href="index.php?option=com_apdmeco&task=detail&cid[]=<?php echo $this->row->eco_id; ?>"><?php echo JText::_('Detail'); ?></a></li>
                        <li><a id="affected" href="index.php?option=com_apdmeco&task=affected&cid[]=<?php echo $this->row->eco_id; ?>"><?php echo JText::_('Affected Parts'); ?></a></li>
                        <li><a id="initial" href="index.php?option=com_apdmeco&task=initial&cid[]=<?php echo $this->row->eco_id; ?>"><?php echo JText::_('Initial Data'); ?></a></li>
                        <li><a id="supporting" href="index.php?option=com_apdmeco&task=files&cid[]=<?php echo $this->row->eco_id; ?>"><?php echo JText::_('Supporting Document'); ?></a></li>
                        <li><a id="routes" href="index.php?option=com_apdmeco&task=routes&cid[]=<?php echo $this->row->eco_id; ?>&time=<?php echo time();?>" class="active"><?php echo JText::_('Routes'); ?></a></li>
                </ul>
                <div class="clr"></div>
        </div>
        <div class="b">
                <div class="b">
                        <div class="b"></div>
                </div>
        </div>
</div>
<div class="clr"></div>
<p>&nbsp;</p>
<form action="<?php echo $link; ?>" method="post" name="adminForm" >               
                    <table class="adminlist" cellpadding="1">
<thead>
        <tr>
<td class="title1" style="background-color:#fff" colspan="2"><strong><?php echo $this->arr_route[0]->name; ?></strong></td>
<td class="title1" style="background-color:#fff" colspan="8"><strong><?php echo $this->arr_route[0]->description; ?></strong></td>
        </tr>
                                <tr>
                                        <th class="title" width="2%"><strong><?php echo JText::_('NUM') ?></strong></th>
                                        <th class="title" width="10%"><strong><?php echo JText::_('Sequence') ?> </strong></th>
                                        <th class="title" width="10%"><strong><?php echo JText::_('Title') ?> </strong></th>
                                        <th class="title" width="10%"><strong><?php echo JText::_('Approver') ?> </strong></th>
                                        <th class="title" width="5%"><strong><?php echo JText::_('Approve/Reject') ?> </strong></th>
                                        <th class="title" width="5%"><strong><?php echo JText::_('State') ?> </strong></th>
                                        <th class="title" width="20%"><strong><?php echo JText::_('Comment') ?> </strong></th>
                                        <th class="title" width="15%"><strong><?php echo JText::_('Approved/Rejected Date') ?> </strong></th>
                                        <th class="title" width="14%"><strong><?php echo JText::_('Due Date') ?> </strong></th>
                                        <th class="title" width="20%"><strong><?php echo JText::_('Action') ?> </strong></th>
                                </tr>
</thead>
<?php
$sequence = array();
//$sequence[] =    JHTML::_('select.option', 0, JText::_('Please Select') , 'value', 'text');
for($s=1;$s<=20;$s++)
{
    $sequence[] =    JHTML::_('select.option', JText::_('sequence'.$s), JText::_('Sequence '. $s) , 'value', 'text');
}
$i = 1;
if (count($this->arr_status) > 0) {
        ?>
                                        <?php
                                        foreach ($this->arr_status as $status) {
                                            $background="";
                                            $remain_day = $status->route_remain_date;
                                            if($status->route_status == 'Create'){
                                                if($remain_day<=0)
                                                {
                                                    $background= "style='background-color:#f00;color:#fff'";

                                                }
                                                elseif($remain_day<=3)
                                                {

                                                    $background= "style='background-color:#ff0;color:#000'";

                                                }
                                            }
                                                if ($me->get('email') == $status->email || $owner == $me->get('id')) {                                                                                                                                                                       

                                                       ?>
                                                        <tr>
                                                                <td align="center"><?php echo $i ?></td>
                                                                 <td align="center" width="5%">
                                                                          <?php                                         
                                                                         echo  $status->sequence;//JHTML::_('select.genericlist',   $sequence, 'sequence'.$status->id, 'class="inputbox" size="1" ', 'value', 'text', $status->sequence );
                                                                        ?>
                                                                 </td>
                                                                <td align="center" width="15%">
                                                                <?php echo $status->title ?>
                                                                        <input type="hidden" name="title[]" id="title" value="<?php echo $status->title ?>" /></td>
                                                                <td align="center" width="15%"><?php echo EcoController::GetNameApprover($status->email); ?>
                                                                        <input type="hidden" name="mail_user[]" id="title" value="<?php echo $status->email; ?>" />
                                                                </td>
                                                                        <?php
                                                                        if ($status->eco_status == 'Inreview') {
                                                                                ?>
                                                                        <td align="center">
                                                                        <?php                                                                        
                                                                                $status_arr = array();
                                                                                $status_arr[] = JHTML::_('select.option', 'Inreview', JText::_('Inreview'), 'value', 'text');
                                                                                $status_arr[] = JHTML::_('select.option', 'Released', JText::_('Approve'), 'value', 'text');
                                                                                $status_arr[] = JHTML::_('select.option', 'Reject', JText::_('Reject'), 'value', 'text');
                                                                                echo JHTML::_('select.genericlist', $status_arr, 'approve_status[]', 'class="inputbox" size="1" ', 'value', 'text', $status->eco_status);
                                                                                                                                                ?>                                                                                                    
                                                                        </td>     
                                                                        <td align="center"><?php echo $status->status; ?></td>
                                                                        <td align="center">

                                                                                <textarea cols="20" rows="4" id ="approve_note" name ='approve_note[]' <?php //echo $disabled; ?>><?php echo $status->note; ?></textarea>                                                       
                                                                        </td>
                                                                                <?php
                                                                        } else {
                                                                                ?>
                                                                         <td align="center"> <?php   echo ($status->eco_status=="Released")?"Approve":$status->eco_status;?></td>
                                                                         <td align="center"><?php echo $status->status; ?></td>
                                                                        <td  align="center">
                                                                                <?php echo $status->note; ?>                                                   
                                                                        </td>
                                                                        <?php
                                                                        }
                                                                                ?>
                                                                        <td align="center"> <?php
                                                                            if($status->approved_at) {
                                                                                echo JHTML::_('date', $status->approved_at, JText::_('DATE_FORMAT_LC5'));
                                                                            }

                                                                            ?></td>
                                                                <td width="20%" align="center" <?php echo $background?>>
                                                                <?php echo JHTML::_('date', $status->route_due_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                                </td>   
                                                                <td align="center">
                                                                        <?php if ($status->route_status == "Create" && $owner == $me->get('id') && $status->eco_status=="Inreview") { ?>
                                                                                <a href='index.php?option=com_apdmeco&task=removeapprove&cid[]=<?php echo $this->row->eco_id; ?>&id=<?php echo $status->id; ?>&time=<?php echo time(); ?>&routes=<?php echo JRequest::getVar('routes') ?>'>Remove</a>                                             
                                                                <?php } ?>                                                                    
                                                                </td>   
                                                        </tr>
                                                                <?php
                                                                $i++;
                                                        } else {//for member
                                                                ?>
                                                        <tr>
                                                                <td align="center"><?php echo $i ?></td>
                                                                <td align="center"><?php echo $status->sequence;?></td>
                                                                <td align="center"><?php echo $status->title ?></td>
                                                                <td align="center"><?php echo EcoController::GetNameApprover($status->email); ?>
                                                                        <input type="hidden" name="mail_user[]" id="title" value="<?php echo $status->email; ?>" />
                                                                </td>
                                                        <?php
                                                        if ($status->eco_status == 'Inreview') {
                                                                ?>
                                                                        <td align="center" width="20%"><?php echo $status->eco_status; ?></td>
                                                                        <td align="center"><?php echo $status->status; ?></td>
                                                                        <td  align="center" width="25%">
                                                                                <textarea disabled="disabled" cols="25" rows="6" id ="approve_note" name ='approve_note[]'><?php echo $status->note; ?></textarea>
                                                                        </td>
                                                                                <?php
                                                                        } else {
                                                                                ?>
                                                                        <td align="center" width="20%">
                                                                                <?php echo ($status->eco_status=="Released")?"Approve":$status->eco_status; ?>                                                         
                                                                        </td>
                                                                        <td align="center"><?php echo $status->status; ?></td>
                                                                        <td align="center" width="25%">
                                                                                <?php echo $status->note; ?>                                                  
                                                                        </td>       
                                                                                <?php
                                                                        }
                                                                        ?>
                                                            <td align="center"> <?php
                                                                if($status->approved_at) {
                                                                    echo JHTML::_('date', $status->approved_at, JText::_('DATE_FORMAT_LC5'));
                                                                }
                                                                ?></td>
                                                            <td align="center" width="20%" <?php echo $background?>>
                                                                <?php echo JHTML::_('date', $status->route_due_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                                </td> 
                                                                <td align="center" width="25%">
                                                                <?php if ($status->route_status == "Create" && $owner == $me->get('id')) { ?>
                                                                                <a href='index.php?option=com_apdmeco&task=removeapprove&cid[]=<?php echo $this->row->eco_id; ?>&id=<?php echo $status->id; ?>&time=<?php echo time(); ?>&routes=<?php echo JRequest::getVar('routes') ?>'>Remove</a>                                             
                                                                        <?php } ?>
                                                                </td>   
                                                        </tr>
                                                                        <?php
                                                                        $i++;
                                                                }
                                                        }
                                                        ?>
                                                        <?php } ?>
                        </table>
                                                <?php if ($owner == $me->get('id')) { //for save approvers?>
                                <table  class="adminlist iptfichier" width="100%"  >
                                                        <?php
                                                        $status_arr = array();
                                                        $status_arr[] = JHTML::_('select.option', 'Inreview', JText::_('Inreview'), 'value', 'text');
                                                        $status_arr[] = JHTML::_('select.option', 'Released', JText::_('Approve'), 'value', 'text');
                                                        $status_arr[] = JHTML::_('select.option', 'Reject', JText::_('Reject'), 'value', 'text');
                                                        for ($j = $i; $j < 20; $j++) {
                                                                ?>

                                                <tr id="<?php echo $j; ?>" style="display:block">
                                                        <td  align="center"width="2%"><?php echo $j; ?></td>
                                                    <td align="center" width="13%">
                                                        <?php
                                                        echo JHTML::_('select.genericlist',   $sequence, 'sequence'.$j, 'class="inputbox" size="1" ', 'value', 'text', $status->sequence );
                                                        ?>
                                                    </td>
                                                        <td align="center" width="10%"><input type="text" name="title<?php echo $j; ?>" id="title" value="" /></td>
                                                        <td  align="center" width="10%">
                                                                <select name="mail_user<?php echo $j; ?>" >
                                                                        <option value="">Select Approver</option>
                                                                            <?php foreach ($this->list_user as $list) { ?>
                                                                                <option value="<?php echo $list->email; ?>"><?php echo $list->name; ?></option>
                                                                             <?php } ?>
                                                                </select>
                                                        </td>
                                                <?php
                                                if ($status->eco_status == 'Inreview') {
                                                        ?>
                                                                <td  align="center" width="7%">
                                                                <?php
                                                                echo JHTML::_('select.genericlist', $status_arr, 'approve_status[]', 'class="inputbox" size="1" ', 'value', 'text', "Inreview");
                                                                ?>
                                                                        <a href='index.php?option=com_apdmeco&task=approve&cid[]=<?php echo $this->row->eco_id; ?>&time=<?php echo time(); ?>'></a>                                                                
                                                                </td>
                                                                <td align="center" width="5%"><?php echo $this->arr_route[0]->status; ?></td>
                                                                <td align="center" width="19%">
                                                                        <textarea cols="15" rows="4" id ="approve_note" name ='approve_note[]'><?php echo $status->note; ?></textarea>
                                                                </td>
                                                                                <?php
                                                                        } else {
                                                                                ?>
                                                                <td align="center" width="7%">
                                                                         <?php echo ($status->eco_status=="Released")?"Approve":$status->eco_status; ?>
                                                                </td>
                                                                <td align="center" width="5%"><?php echo $this->arr_route[0]->status; ?></td>
                                                                <td align="center" width="19%">
                                                                <?php echo $status->note; ?>
                                                                </td>                                                                
                                                                        <?php
                                                                }
                                                                ?>
                                                                <td align="center" width="19%"> <?php
                                                                    if($status->approved_at) {
                                                                        echo JHTML::_('date', $status->approved_at, JText::_('DATE_FORMAT_LC5'));
                                                                    }
                                                                    ?></td>
                                                                <td width="20%" <?php echo $background?>>
                                                                    <?php echo JHTML::_('date', $this->arr_route[0]->route_due_date, JText::_('DATE_FORMAT_LC5')); ?>
                                                                </td>
                                                        <td width="20%">          
                                                            <?php if ($status->route_status == "Create" && $status->eco_status=="Inreview") { ?>
                                                                        <a  style="cursor:pointer" onclick="removeApprove(<?php echo $j; ?>)">Remove</a>
                                                        <?php } ?>
                                                        </td>   
                                                </tr>
                                                <?php } ?>
                                                    </table>
                                                <?php } ?>
                
                                                <?php
                                                
                                                if ($owner == $me->get('id')) {                                                        
                                                        if ($this->arr_route[0]->status == "Create") {
                                                                echo $add_routes;
                                                        }
                                                        $link = "index.php?option=com_apdmeco&amp;task=addapprove&amp;cid[]=" . $this->row->eco_id . "&amp;time=" . time();
                                                }
                                                ?>
        <div class="clr"></div>

        <input type="hidden" name="eco_id" value="<?php echo $this->row->eco_id ?>" />
        <input type="hidden" name="cid[]" value="<?php echo $this->row->eco_id ?>" />
        <input type="hidden" name="route" value="<?php echo $cid = JRequest::getVar('routes'); ?>" />
        <input type="hidden" name="option" value="com_apdmeco" />

                        <?php
                        $task = "saveapprove";
                        if ($owner == $me->get('id')) {
                                $task = "addapprove";
                        }
                        ?>
        <input type="hidden" name="task" value="<?php echo $task ?>" />
        <input type="hidden" name="boxchecked" value="1" />
                <?php echo JHTML::_('form.token'); ?>
</form>
