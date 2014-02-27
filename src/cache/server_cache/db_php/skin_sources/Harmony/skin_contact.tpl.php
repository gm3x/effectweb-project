<?php
/***********************************************************/
/* Cetemaster Services, Limited                            */
/* Copyright (c) 2010-2013. All Rights Reserved,           */
/* www.cetemaster.com.br / www.cetemaster.com              */
/***********************************************************/
/* File generated by Cetemaster PHP Template Engine        */
/* Template: Harmony                                       */
/* DB file: skin_contact                                   */
/* DB generated in 20/10/2013 - 04:34h                     */
/***********************************************************/
/* This is a cache file generated by                       */
/* DO NOT EDIT DIRECTLY                                    */
/* The changes are not saved to the cache automatically    */
/***********************************************************/

/********** Begin: contact **********/
$CTM_TEMPLATE_DATABASE['contact'] = <<<HTML
	<script type="text/javascript">
	::x####$####x::(function()
	{
		var currentSection = "Contact1";
		
		::x####$####x::("td[rel*=SelectContact]").click(function()
		{
			contact = ::x####$####x::(this).attr("id");
			
			if(::x####$####x::("#View_"+currentSection).is(":visible"))
				::x####$####x::("#View_"+currentSection).slideUp(341);
					
			::x####$####x::("#View_"+contact).slideDown(341);
			::x####$####x::("#"+currentSection).attr("class", "");
			::x####$####x::("#"+contact).attr("class", "current");
			
			currentSection = contact;
		});
	});
	</script>
	<style type="text/css">
    #TopContactSelect {
        text-align:center;
    }
    #TopContactSelect td
    {
        padding:5px;
        margin:10px;
        cursor: pointer;
    }
    </style>

	<div class="box-content">
		<div class="header"><span>{::x####$####x::this->lang->words['Contact']['Title']}</span></div>
        <blockquote>
            {::x####$####x::this->lang->words['Contact']['HeaderText']}<br /><br />
            <table width="50%" border="0" id="TopContactSelect" class="optionSelect" align="center" style="margin-bottom:15px;">
                <tr>
                    <td align="center" rel="SelectContact" class="current"  id="Contact1"><strong>{::x####$####x::this->lang->words['Contact']['Menu']['Mail']}</strong></td>
                    <if syntax="::x####$####x::this->settings['CONTACT']['ENABLE_PHONE'] == true">
                    <td  rel="SelectContact"  id="Contact2"><strong>{::x####$####x::this->lang->words['Contact']['Menu']['Phone']}</strong></td>
                    </if>
                    <td rel="SelectContact" id="Contact3"><strong>{::x####$####x::this->lang->words['Contact']['Menu']['Ticket']}</strong></td>
                </tr>
            </table>
		</blockquote>
    </div>

	<div id="View_Contact1" class="CurrentContact">
		<div class="box-content">
			<div class="header"><span>{::x####$####x::this->lang->words['Contact']['MailContact']['Title']}</span></div>
			<p>
				<strong>{::x####$####x::this->lang->words['Contact']['MailContact']['Text']}</strong><br />
				<if syntax="count(::x####$####x::this->settings['CONTACT']['MAIL']) > 0">
                <ul class="info">
				<foreach loop="::x####$####x::this->settings['CONTACT']['MAIL'] as ::x####$####x::mail">
					<li>&raquo; {::x####$####x::mail[1]} - <span class="colr">{::x####$####x::mail[0]}</span></li>
				</foreach>
                </ul>
				<else />
				<div class="info-box">{::x####$####x::this->lang->words['Contact']['MailContact']['Disabled']}</div>
				</if>
			</p>
		</div>
	</div>

	<if syntax="::x####$####x::this->settings['CONTACT']['ENABLE_PHONE'] == true">
	<div id="View_Contact2"  style="display:none;" class="CurrentContact">
		<div class="box-content">
			<div class="header"><span>{::x####$####x::this->lang->words['Contact']['PhoneContact']['Title']}</span></div>
			<p>
				<strong>{::x####$####x::this->lang->words['Contact']['PhoneContact']['Text']}</strong><br />
    			<if syntax="count(::x####$####x::this->settings['CONTACT']['PHONE']) > 0">
                <ul class="info">
   				<foreach loop="::x####$####x::this->settings['CONTACT']['PHONE'] as ::x####$####x::phone">
        			<li>&raquo; {::x####$####x::phone[1]} - <span class="colr">{::x####$####x::phone[0]}</span> - <strong>{::x####$####x::this->lang->words['Contact']['PhoneContact']['Speak']}</strong> {::x####$####x::phone[2]}</li>
   				</foreach>
                </ul>
    			<else />
    			<div class="info-box">{::x####$####x::this->lang->words['Contact']['PhoneContact']['Disabled']}</div>
    			</if>
			</p>
		</div>
	</div>
	</if>
    
	<div id="View_Contact3"  style="display:none;" class="CurrentContact">
		<div class="box-content">
			<div class="header"><span>{::x####$####x::this->lang->words['Contact']['TicketContact']['Title']}</span></div>
			<p>
				{::x####$####x::this->lang->words['Contact']['TicketContact']['Text']}
			</p>
		</div>
	</div>
HTML;
/********** End: contact **********/