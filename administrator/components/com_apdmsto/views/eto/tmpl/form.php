<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php JHTML::_('behavior.modal'); ?>
<?php
$cid = JRequest::getVar( 'cid', array(0) );
$edit		= JRequest::getVar('edit',true);
$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

JToolBarHelper::title( JText::_( 'ETO' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'generic.png' );
if (!intval($edit)) {
    //	JToolBarHelper::save('save', 'Save & Add new');
}
JToolBarHelper::apply('save_eto', 'Save');

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
    function get_default_ito_prefix(){
        var url = 'index.php?option=com_apdmsto&task=get_sto_code_default&sto_type=2';
        var MyAjax = new Ajax(url, {
            method:'get',
            onComplete:function(result){
                $('sto_code').value = result.trim();
            }
        }).request();
    }
    get_default_ito_prefix();


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
    <div class="col width-60">
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
                        <input type="text" readonly="readonly" name="sto_code" id="sto_code"  size="10" value=""/>
                    </td>
                </tr>
                <tr>
                    <td class="key">
                        <label for="name">
                            <?php echo JText::_( 'WO#' ); ?>
                        </label>
                    </td>
                    <td>
                        <?php //echo $this->lists['wolist'];?>
                        <input type="text" value="" name="wo_code" id="wo_code" readonly="readonly" />
                        <input type="hidden" name="sto_wo_id" id="sto_wo_id" value="" />
                        <a class="modal-button" rel="{handler: 'iframe', size: {x: 650, y: 400}}" href="index.php?option=com_apdmsto&task=get_wo_ajax&tmpl=component" title="Image">
                            <input type="button" name="addSO" value="<?php echo JText::_('Select WO')?>"/>
                        </a>
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
                        <span id="po_customer"></span>
                    </td>
                </tr>
                <tr>
                    <td class="key">
                        <label for="name">
                            <?php echo JText::_( 'Customer#' ); ?>
                        </label>
                    </td>
                    <td>
                        <input type="hidden" readonly="readonly" name="customer_id" id="customer_id"  size="10" value=""/>
                      <span id="ccs_name"></span>
                    </td>
                </tr>
                <tr>
                    <td class="key">
                        <label for="name">
                            <?php echo JText::_( 'Delivery Good' ); ?>
                        </label>
                    </td>
                    <td>
                        <?php echo $this->lists['stoDeliveryGood'];?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                            <div id="delivery_info" style="display: none">
                            <fieldset>               
                                    <legend><?php echo JText::_( 'Delivery Note' ); ?></legend>
                                   <table class="admintable" cellspacing="1" width="100%">
                                           <tr><td  class="key">Delivery Method</td>
                                           <td colspan="3"><input type="text" name="sto_delivery_method" id="sto_delivery_method"  size="30" value=""/></td>
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
                                                <input type="text" name="sto_delivery_shipping_name" id="sto_delivery_shipping_name"  size="30" value=""/>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Name' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="sto_delivery_billing_name" id="sto_delivery_billing_name"  size="30" value=""/>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Company name' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="sto_delivery_shipping_company" id="sto_delivery_shipping_company"  size="30" value=""/>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Company name' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="sto_delivery_billing_company" id="sto_delivery_billing_company"  size="30" value=""/>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Street address' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="sto_delivery_shipping_street" id="sto_delivery_shipping_street"  size="30" value=""/>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Street address' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="sto_delivery_billing_street" id="sto_delivery_billing_street"  size="30" value=""/>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'City,Zip code' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="sto_delivery_shipping_zipcode" id="sto_delivery_shipping_zipcode"  size="30" value=""/>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'City,Zip code' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="sto_delivery_billing_zipcode" id="sto_delivery_billing_zipcode"  size="30" value=""/>
                                            </td>
                                             </tr>
                                             <tr>
                                            <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Phone number' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="sto_delivery_shipping_phone" id="sto_delivery_shipping_phone"  size="30" value=""/>
                                            </td>
                                             <td class="key">
                                                <label for="name">
                                                    <?php echo JText::_( 'Phone number' ); ?>
                                                </label>
                                            </td>
                                            <td>
                                                <input type="text" name="sto_delivery_billing_phone" id="sto_delivery_billing_phone"  size="30" value=""/>
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
                        <input type="checkbox" id ="stocker_confirm" name="stocker_confirm" checked="checked" value="1" />
                    </td>
                </tr>
                <tr>
                    <td class="key">
                        <label for="name">
                            <?php echo JText::_( 'Description' ); ?>
                        </label>
                    </td>
                    <td>
                        <textarea name="sto_description" rows="10" cols="60"><?php echo $this->sto_row->sto_code?></textarea>
                    </td>
                </tr>


                <!--<tr>
                    <td class="key">
                        <label for="name">
                            <?php /*echo JText::_( 'Owner' ); */?>
                        </label>
                    </td>
                    <td  width="16%">
                        <select name="sto_owner" id="sto_owner" >
                            <option value="">Select Owner</option>
                            <?php /*foreach ($this->list_user as $list) { */?>
                                <option value="<?php /*echo $list->id; */?>"><?php /*echo $list->name; */?></option>
                            <?php /*} */?>
                        </select>
                    </td>
                </tr>-->
            </table>
        </fieldset>
    </div>
    <div class="col width-40">
        <fieldset class="adminform">
            <legend><?php echo JText::_( 'Documents' ); ?> <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font></legend>
            <table class="adminlist">
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
    <input type="hidden" name="pns_id" value="<?php echo  $cid[0];?>" />
    <input type="hidden" name="option" value="com_apdmsto" />
    <input type="hidden" name="return" value="sto"  />
    <input type="hidden" name="task" value="save_eto" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>
