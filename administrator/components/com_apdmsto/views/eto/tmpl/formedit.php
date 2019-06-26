<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php
$cid = JRequest::getVar( 'cid', array(0) );
$edit		= JRequest::getVar('edit',true);
$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
$folder_sto = $this->sto_row->sto_code;
$allow_edit = 1;
$styleReadonly ="";
if ($this->sto_row->sto_owner_confirm==1 && $this->sto_row->sto_owner)
{
    $styleReadonly ='readonly="readonly"';
    $allow_edit = 0;
}
JToolBarHelper::title( $this->sto_row->sto_code. ': <small><small>[ '. $text .' ]</small></small>' , 'generic.png' );
if (!intval($edit)) {
    //	JToolBarHelper::save('save', 'Save & Add new');
}
JToolBarHelper::apply('save_editeto', 'Save');

if ( $edit ) {
    // for existing items the button is renamed `close`
    JToolBarHelper::cancel( 'cancel', 'Close' );
} else {
    JToolBarHelper::cancel();
}

$cparams = JComponentHelper::getParams ('com_media');
?>
<?php
//poup add rev roll
$edit		= JRequest::getVar('edit',true);
$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
// clean item data
JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );


?>
<script language="javascript" type="text/javascript">
    window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });
    window.addEvent('domready', function() {

        SqueezeBox.initialize({});

        $$('a.modal-button').each(function(el) {
            el.addEvent('click', function(e) {
                new Event(e).stop();
                SqueezeBox.fromElement(el);
            });
        });
    });

    window.addEvent('domready', function() {

        SqueezeBox.initialize({});

        $$('a.modal').each(function(el) {
            el.addEvent('click', function(e) {
                new Event(e).stop();
                SqueezeBox.fromElement(el);
            });
        });
    });
    function getccsPoCoordinator(wo_id)
    {
        var url = 'index.php?option=com_apdmsto&task=getPoCoordinator&wo_id='+wo_id;
        var MyAjax = new Ajax(url, {
            method:'get',
            onComplete:function(result){
                //$result = $row->customer_id.'^'.$row->ccs_name.'^'.$row->pns_so_id.'^'.$soNumber;
                var so_result = result;
                eco = so_result.split('^');
                window.document.getElementById('po_customer').innerHTML =  eco[3];
                window.document.getElementById('ccs_name').innerHTML = eco[1];
                window.document.getElementById('so_cuscode').value = eco[2];
                window.document.getElementById('customer_id').value = eco[0];
                // $('so_coordinator').value = result.trim();
            }
        }).request();
    }
   
    ///for add more file
window.addEvent('domready', function(){
        //for image
        //File Input Generate
        var mid=0;			
        var mclick=1;
        $$(".iptfichier_image span").each(function(itext,id) {
                if (mid!=0)
                        itext.style.display = "none";
                        mid++;
        });
        $('lnkfichier_image').addEvents ({				
                'click':function(){	
                        if (mclick<mid) {
                                $$(".iptfichier_image span")[mclick].style.display="block";
                        //	alert($$(".iptfichier input")[mclick].style.display);
                                mclick++;
                        }
                }
        });	   
});
    function getDeliveryAddress(is_delivery)
    {
        if(is_delivery==1)
        {
            document.getElementById('delivery_info').style.visibility= 'visible';
            document.getElementById('delivery_info').style.display= 'block';
        }
        else
        {
            document.getElementById('delivery_info').style.visibility= 'hidden';
            document.getElementById('delivery_info').style.display= 'none';
        }

    }
</script>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
    <div class="col width-40">
        <fieldset class="adminform">
            <legend><?php echo JText::_( 'ETO Detail' ); ?></legend>
            <table class="admintable" cellspacing="1">
                <tr>
                    <td class="key">
                        <label for="name">
                            <?php echo JText::_( 'ETO Number' ); ?>
                        </label>
                    </td>
                    <td>
                        <input type="text" readonly="readonly" name="sto_code" id="sto_code"  size="10" value="<?php echo $this->sto_row->sto_code?>"/>
                        <input type="hidden" readonly="readonly" name="sto_so_id" id="sto_so_id"  size="10" value="<?php echo $this->sto_row->sto_so_id?>"/>
                        <span id="po_customer" style="display:none"></span>
                    </td>
                </tr>
                <?php // echo $this->lists['stoDeliveryGood'];
                if($this->sto_row->sto_isdelivery_good) {
                    ?>
                    <tr>
                <td class="key">
                    <label for="name">
                        <?php echo JText::_( 'SO' ); ?>
                    </label>
                </td>
                <td>

                    <?php
                    $so_code =  SToController::getSoCodeFromId($this->sto_row->sto_so_id);
                    //echo $this->lists['wolist'];?>
                    <input type="text" value="<?php echo $so_code?>" name="so_code" id="so_code" readonly="readonly" />
                    <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsto&task=get_so_ajax&tmpl=component" title="Image">
                        <input type="button" name="addSO" value="<?php echo JText::_('Select SO')?>"/>
                    </a>
                </td>
                    </tr>
                    <?php
                }else{
                    ?>
                    <tr>
                        <td class="key">
                            <label for="name">
                                <?php echo JText::_( 'WO' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php //echo $this->lists['wolist'];?>
                            <input type="text" value="<?php echo $this->sto_row->wo_code?>" name="wo_code" id="wo_code" readonly="readonly" />
                            <input type="hidden" name="sto_wo_id" id="sto_wo_id" value="<?php echo $this->sto_row->sto_wo_id?>" />
                            <?php if($allow_edit){?>
                                <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsto&task=get_wo_ajax&tmpl=component" title="Image">
                                    <input type="button" name="addSO" value="<?php echo JText::_('Select WO')?>"/>
                                </a>
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="name">
                                <?php echo JText::_( 'PO#' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="hidden" readonly="readonly" name="so_cuscode" id="so_cuscode"  size="10" value=""/>
                            <span id="po_customer"><?php
                                $soNumber = $this->sto_row->so_cuscode;
                                if($this->sto_row->ccs_code)
                                {
                                    $soNumber = $this->sto_row->ccs_code."-".$soNumber;
                                }
                                echo $soNumber;
                                ?></span>
                        </td>
                    </tr>
                <?php }?>
                <tr>
                    <td class="key">
                        <label for="name">
                            <?php echo JText::_( 'Customer#' ); ?>
                        </label>
                    </td>
                    <td>
                        <input type="hidden" readonly="readonly" name="customer_id" id="customer_id"  size="10" value=""/>
                        <span id="ccs_name">
                        <?php
                        if($this->sto_row->sto_isdelivery_good && $this->sto_row->sto_so_id){
                            echo SToController::getCustomerCodeFromSoId($this->sto_row->sto_so_id);
                        }
                        else
                        {
                            echo ($this->sto_row->ccs_name)?$this->sto_row->ccs_name:"NA";
                        }
                        ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="key">
                        <label for="name">
                            <?php echo JText::_( 'Delivery Goods' ); ?>
                        </label>
                    </td>
                    <td>
                        <?php // echo $this->lists['stoDeliveryGood'];
                        if($this->sto_row->sto_isdelivery_good)
                                echo "Yes";
                        else {
                                echo "No";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                            <?php
                            $style='style="display: none"';
                            if($this->sto_row->sto_isdelivery_good)
                            {
                                    $style='style="display: block"';
                            }
                            ?>
                            <div id="delivery_info" <?php echo $style?> >
                            <fieldset>               
                                    <legend><?php echo JText::_( 'Delivery Note' ); ?></legend>
                                   <table class="admintable" cellspacing="1" width="100%">
                                           <tr><td  class="key">Delivery Method</td>
                                           <td colspan="3"><input <?php echo $styleReadonly;?> type="text" name="sto_delivery_method" id="sto_delivery_method"  size="20" value="<?php  echo $this->sto_row->delivery_method; ?>"/></td>
                                           </tr>
                                        <tr>
                                            <td colspan="2">
                                                <label for="name" style="color:#0B55C4;font-size: 12px;font-weight: bold">
                                                    <?php echo JText::_( 'Shipping Address' ); ?>
                                                </label>
                                            </td>
                                          <td colspan="2">
                                                <label for="name" style="color:#0B55C4;font-size: 12px;font-weight: bold">
                                                    <?php echo JText::_( 'Invoice Address' ); ?>
                                                </label>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Name' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input <?php echo $styleReadonly;?> type="text" name="sto_delivery_shipping_name" id="sto_delivery_shipping_name"  size="20" value="<?php  echo $this->sto_row->delivery_shipping_name; ?>"/>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Name' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input <?php echo $styleReadonly;?> type="text" name="sto_delivery_billing_name" id="sto_delivery_billing_name"  size="20" value="<?php  echo $this->sto_row->delivery_billing_name; ?>"/>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Company name' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input <?php echo $styleReadonly;?> type="text" name="sto_delivery_shipping_company" id="sto_delivery_shipping_company"  size="20" value="<?php  echo $this->sto_row->delivery_shipping_company; ?>"/>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Company name' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input <?php echo $styleReadonly;?> type="text" name="sto_delivery_billing_company" id="sto_delivery_billing_company"  size="20" value="<?php  echo $this->sto_row->delivery_billing_company; ?>"/>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Street address' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input <?php echo $styleReadonly;?> type="text" name="sto_delivery_shipping_street" id="sto_delivery_shipping_street"  size="20" value="<?php  echo $this->sto_row->delivery_shipping_street; ?>"/>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Street address' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input <?php echo $styleReadonly;?> type="text" name="sto_delivery_billing_street" id="sto_delivery_billing_street"  size="20" value="<?php  echo $this->sto_row->delivery_billing_street; ?>"/>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'City,Zip code' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input <?php echo $styleReadonly;?> type="text" name="sto_delivery_shipping_zipcode" id="sto_delivery_shipping_zipcode"  size="20" value="<?php  echo $this->sto_row->delivery_shipping_zipcode; ?>"/>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'City,Zip code' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input <?php echo $styleReadonly;?> type="text" name="sto_delivery_billing_zipcode" id="sto_delivery_billing_zipcode"  size="20" value="<?php  echo $this->sto_row->delivery_billing_zipcode; ?>"/>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Phone number' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input <?php echo $styleReadonly;?> type="text" name="sto_delivery_shipping_phone" id="sto_delivery_shipping_phone"  size="20" value="<?php  echo $this->sto_row->delivery_shipping_phone; ?>"/>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Phone number' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input <?php echo $styleReadonly;?> type="text" name="sto_delivery_billing_phone" id="sto_delivery_billing_phone"  size="20" value="<?php  echo $this->sto_row->delivery_billing_phone; ?>"/>
                                            </td>
                                             </tr>
                                           </table>
                                    </fieldset>
                            </div>
                            
                    </td>
                    
                </tr>               
                <tr>
                    <td class="key" valign="top">
                        <label for="stocker">
                            <?php echo JText::_( 'Stoker confirm' ); ?>
                        </label>
                    </td>
                    <td>
                        <input type="checkbox" id ="stocker_confirm" name="stocker_confirm" checked="checked" value="1" onclick="return false;" onkeydown="return false;" />
                    </td>
                </tr>
                <tr>
                    <td class="key">
                        <label for="name">
                            <?php echo JText::_( 'Description' ); ?>
                        </label>
                    </td>
                    <td>
                        <textarea <?php echo $styleReadonly;?> name="sto_description" rows="10" cols="60"><?php echo $this->sto_row->sto_description?></textarea>
                    </td>
                </tr>


<!--                <tr>
                    <td  class="key" width="28%"><?php /*echo JText::_('Confirm'); */?></td>
                    <td width="30%" class="title">
                        <?php
/*                        if(!$this->sto_row->sto_owner_confirm){

                            */?>


                            <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsto&task=get_owner_confirm_sto&sto_id=<?php /*echo $this->sto_row->pns_sto_id*/?>&tmpl=component" title="Image">
                                <input onclick="return false;" onkeydown="return false;" type="checkbox" name="sto_owner_confirm" value="1" /></a>
                        <?php /*}
                        else
                        {
                            */?>
                            <input checked="checked" onclick="return false;" onkeydown="return false;" type="checkbox" name="sto_owner_confirm" value="1" />
                            <?php
/*                        }
                        */?>
                    </td>
                </tr>

                <tr>
                    <td class="key">
                        <label for="name">
                            <?php /*echo JText::_( 'Owner' ); */?>
                        </label>
                    </td>
                    <td  width="16%">
                        <?php /*echo ($this->sto_row->sto_owner)?GetValueUser($this->sto_row->sto_owner, "name"):""; */?>
                    </td>
                </tr>-->
            </table>
		</fieldset>
	</div>
 <div class="col width-60">
                <fieldset class="adminform">
		<legend><?php echo JText::_( 'Documents' ); ?> <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>
                <table class="adminlist">                        
              <?php if (isset($this->lists['image_files'])&& count($this->lists['image_files'])>0) {?>
				<tr>
                                        <td colspan="2" >
					<table width="100%"  class="adminlist" cellpadding="1">
						
						<thead>
							<th colspan="4"><?php echo JText::_('List documents')?></th>
						</thead>
						<tr>
							<td width="5%"><strong><?php echo JText::_('No.')?></strong></td>
							<td width="45%"><strong><?php echo JText::_('Name')?> </strong></td>
							<td width="30%"><strong><?php echo JText::_('Size (KB)')?> </strong></td>
							<td width="20%"><strong><?php echo JText::_('Download')?>  <?php echo JText::_('Remove')?></strong></td>
						</tr>
				<?php
				
				$i = 1;
				foreach ($this->lists['image_files'] as $image) {
					$filesize = SToController::readfilesizeSto($folder_sto, $image['image_file'],'images');
				?>
				<tr>
					<td><?php echo $i?></td>
					<td><?php echo $image['image_file']?></td>
					<td><?php echo number_format($filesize, 0, '.', ' '); ?></td>
					<td><a href="index.php?option=com_apdmsto&task=download_doc_sto&type=images&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $image['id']?>" title="Click here to download file"><img src="images/download_f2.png" width="20" height="20" /></a>&nbsp;&nbsp;
                                                <?php
                                               if ($this->sto_row->sto_state  != "Done") {                       
                                                ?>
					<a href="index.php?option=com_apdmsto&task=remove_doc_sto&back=ito_detail&type=images&sto_id=<?php echo $this->sto_row->pns_sto_id?>&id=<?php echo $image['id']?>&remove=<?php echo $i.time();?>" title="Click to remove" onclick="if ( confirm('Are you sure to delete it ? ') ) { return true;} else {return false;} "><img src="images/cancel_f2.png" width="15" height="15" /></a>
                                         <?php
                                               }
                                                ?>
                                        </td>
				</tr>
				<?php $i++; } ?>
				
				<tr>
					
					<td colspan="4" align="center">
					<a href="index.php?option=com_apdmsto&task=download_all_doc_sto&type=images&tmpl=component&sto_id=<?php echo $this->sto_row->pns_sto_id;?>" title="Download All Files">
<!--                                        <input type="button" name="addVendor" value="<?php //echo JText::_('Download All Files')?>"/>-->
                                        </a>&nbsp;&nbsp;

<!--					<input type="button" value="<?php echo JText::_('Remove All Files')?>" onclick="if ( confirm ('Are you sure to delete it ?')) { window.location.href='index.php?option=com_apdmpns&task=remove_all_images&pns_id=<?php echo $this->row->pns_id?>' }else{ return false;}" /></td>					-->
				</tr>
								
					</table>
					</td>                                        
                                        
				</tr>
				<?php } ?>
                <tr>
					<td>

						<input type="hidden" name="old_pns_image" value="<?php echo $this->row->pns_image;?>" />
                                                <div class="iptfichier_image">
                                                 <span id="1">
							<input type="file" name="pns_image1" /> 
						</span>
						<span id="2">
							<input type="file" name="pns_image2" /> 
						</span>
						<span id="3">
							<input type="file" name="pns_image3" /> 
						</span>
						<span id="4">
							<input type="file" name="pns_image4" /> 
						</span>
						<span id="5">
							<input type="file" name="pns_image5" /> 
						</span>
						<span id="6">
							<input type="file" name="pns_image6" /> 
						</span>
						<span id="7">
							<input type="file" name="pns_image7" /> 
						</span>
						<span id="8">
							<input type="file" name="pns_image8" /> 
						</span>
						<span id="9">
							<input type="file" name="pns_image9" /> 
						</span>   
						<span id="10">
							<input type="file" name="pns_image10" /> 
						</span>                                                           
                                                </div>
                                                <br />
                                                <a href="javascript:;"id="lnkfichier_image" title="<?php echo JText::_('Click here to add more files');?>" ><?php /*echo JText::_('Click here to add more files');*/?></a>
					</td>
                                        </tr> 
                                          </table>
                </fieldset>
        </div>
    <input type="hidden" name="pns_sto_id" value="<?php echo $this->sto_row->pns_sto_id?>" />
    <input type="hidden" name="option" value="com_apdmsto" />
    <input type="hidden" name="return" value="sto"  />
    <input type="hidden" name="task" value="save_editeto" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>
