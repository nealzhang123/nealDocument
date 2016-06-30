<div id="verify_bar_area" class="verify_bar_area ">
	<div id="verify_bar_1" class="verify_bar_item <?php echo ( $this->fill_start_status == $verify_status ) ? 'f_bar_active' : 'f_bar_unactive'; ?>">
		<?php _e('认证方式'); ?>
	</div>
	<div id="verify_bar_2" class="verify_bar_item m_bar_unactive">
		<?php _e('同意协议'); ?>
	</div>
	<div id="verify_bar_3" class="verify_bar_item <?php echo ( $this->fill_fail_status == $verify_status ) ? 'm_bar_active' : 'm_bar_unactive'; ?>">
		<?php _e('填写信息'); ?>
	</div>
	<div id="verify_bar_4" class="verify_bar_item m_bar_unactive">
		<?php _e('信息确认'); ?>
	</div>
	<div id="verify_bar_5" class="verify_bar_item <?php echo ( $this->verifying_info_status == $verify_status || $this->fill_bank_status == $verify_status ) ? 'm_bar_active' : 'm_bar_unactive'; ?>">
		<?php _e('等待审核'); ?>
	</div>
	<div id="verify_bar_6" class="verify_bar_item <?php echo $verify_bar_complete_class; ?>">
		<?php _e('完成验证'); ?>
	</div>
</div>

<div id="verify_choose_area" class="verify_choose_area verify_form_div" style="display:<?php echo ( $this->fill_start_status == $verify_status ) ? 'block' : 'none'; ?>;">
	<div id="verify_style_title" class="verify_style_title">
		<?php _e('请选择认证方式:'); ?>
	</div>
	<div id="verify_style_choose" class="verify_style_choose">
	<label class="verify_style_pson">
		<input type="radio" name="verify_choose_style" id="verify_style_personal" value="personal" <?php echo ( ( isset($display_info) && $display_info || $this->fill_start_status == $verify_status ) ) ? 'checked' : ''; ?> /><?php _e('个人认证'); ?></label>
	<label class="verify_style_com">
		<input type="radio" name="verify_choose_style" id="verify_style_company" value="company" <?php echo ( isset($display_info) && !$display_info) ? 'checked' : ''; ?> /><?php _e('公司认证'); ?></label>
	</div>
</div>

<div id="verify_agreement_area" class="verify_agreement_area verify_form_div">
	
	<textarea id="verify_agreement_content" class="verify_agreement_content" readonly="readonly">
		<?php _e('服务条款
1、协议

Etongapp向其会员提供及多种产品和服务，在使用etongapp所有产品和服务前，请用户务必仔细阅读并透彻理解本条款。除非您已阅读并接受本条款，否则您可能无法访问或使用etongapp的服务。etongapp欢迎所有用户注册，但如果您未满18周岁，请在法定监护人的陪同下阅读本条款，并特别注意未成年人使用条款。
2、适用范围
以下条款和条件适用etongapp网站上所有的内容、服务和产品，及通过本平台注册的开发者和建站用户。此外，如若您同意，etongapp可以自动升级服务，这些条款将适用于任何升级。
3、服务内容
3.1 注册

为了能够使用etongapp的服务，用户须填妥账号注册表。而且作为使用etongapp的条件，用户同意提供注册表上所要求的，正确的用户名、注册邮箱、密码，并确保今后更新的登陆邮箱、用户名等资料的有效性和合法性。

但如用户提供任何违法、不道德或etongapp认为不适合在平台展示的资料；或者etongapp有理由怀疑用户的资料属于病毒程序或恶意操作，etongapp有权暂停或终止用户的帐号，并拒绝用户于现在和未来使用本服务之全部或任何部分。

Etongapp无须对任何用户的任何登记资料承担任何责任，包括但不限于鉴别、核实任何登记资料的真实性、正确性、完整性、适用性及是否为最新资料的责任。

3.2账户

一个注册账户可以不创建站点，或创建多个站点。通常，账户内每个站点用户将有搭建12个页面，每天编辑、发布5篇文章的权利。etongapp不能保证基本站点是否匹配用户的需求，如需要增加文章及页面数量，须选择升级账户。升级规则由etongapp约定。

如果用户创建一个博客或网站，用户有责任维护用户博客和网站的安全，并对用户的网站完全负责，包括发生在博客和网站内所有的活动与行为，不限于使用的文字，照片，视频，音频，或代码是否合乎法律。用户必须妥善保管用户的账户，如账户被恶意盗用，及任何未经授权使用用户的博客，用户的帐户，或任何其他违反安全，必须立即通知etongapp，因此及延误举报造成的任何损失，etongapp将不会承担责任！

3.3设置

为了能够成功发送站内站外邮件，用户必须提供一个有效邮箱用来设置smtp邮差。

3.4产品使用

Etongapp平台提供不同级别的服务、不同功能的应用app。用户可以选择免费产品及服务，或定制付费模板及服务。需要注意的是，产品提供商对产品及服务负全部责任。包括售前、售后的任何问题！

如果用户使用一款免费插件、应用软件，或者主题，除非用户激活启用，产品提供商不会恶意推销或强行安装。使用期限内，除非用户自愿终止，产品提供商将不会无故停用服务。但提供商有权更改免费使用期限及定制收费标准。

如果用户购买一款插件、应用软件，或者主题，通常情况下，产品提供商会提供一次试用机会，包括中途暂停试用。试用期后用户有权决定是否购买，除非用户自愿，提供商不会强制付款。但如果继续使用，提供商有权暂停用户的app使用，直至用户购买付款。

此外，用户将有权获取每款主题及软件的操作方法。产品提供商有权决定产品及服务的免费服务期限，正常情况下，最低6个月的免费使用指导服务。免费服务期后，如果用户仍然需要技术指导，产品提供商有权决定是否收费。

3.5广告

Etongapp保留权利，在用户的博客上或者网站上显示广告，除非用户购买了一个广告免费升级或VIP服务帐户。

3.6支付

用户可以购买用户需要的服务及产品，产品提供商停将会保证软件在使用期内的正常运行，对于异常情况，产品提供商会尽快使软件恢复正常运作。正常情况下，除非用户授意，提供商不会暂停用户的服务及产品应用。

所有产品和服务付款成功以后，正式生效。因付款失败导致的产品或者服务不能及时启用，损失将由用户自己承担。

对于永久出售的产品及服务，用户付款后可以获得产品及服务的使用权，原则上时限是除不可抗力因素之外的永久。

除永久出售的产品及服务外，对于分期出售的产品及服务，提供商有权更改产品或服务的分期周期及价格。变更之前，提供商会通知用户，用户有权决定是否续用。

分期出售的产品及服务，在约定使用期结束后，提供商将会通知用户续交费用，用户有权决定是否需用，但因忽视提醒通知而导致的产品或服务停用造成的一切损失由用户自己承担。

3.7售后

产品或者服务出现问题时，用户应及时和产品提供商联系。Etongapp提供在线客服系统，供用户和第三方开发者在线交流售前、售后。

用户遇到任何关于etongapp的问题，请通过工单及在线客服联系etongapp，etongapp确保在最快的时间内回复。同等情况下，付费用户有优先获得客服解答的权利。需要说明的是，每一次问题的完整解决，以创建工单为开始，关闭工单为结束。中途，若用户关闭了工单，etongapp有权认为问题已经解决，因此而导致的纠纷及损失，etongapp将不承担责任。

3.8知识产权

用户通过平台提供的技术（包括但不限于网页、文字、图片、音频、视频、图表等）的知识产权归用户自己所有。用户有权决定是否允许他人转载，及用于包括商业运营、出售、转让等在内的合法用途。

4、开发者权利和义务

4.1 产品上架

Etongapp支持、欢迎第三方开发者使用平台，开发者开发的产品或提供的服务能否上架，必须先由etongapp技术部门测试审核，以确保产品及服务能够正常运行及使用。

开发者有权决定产品或服务的用途，是否在线销售及分享交流。前提是开发者必须对产品或服务负全责。开发者必须保证上传正确规范的操作说明及服务说明，并保证提供一定期限内的售后服务。若无相关的使用说明或演示，或不合规范的说明，etongapp会采取一定的措施，情节严重的产品直接下架。

4.2服务

上架产品必须接受etongapp统一管理，开发者保证服务期内，产品或服务出错后第一时间解决，因为产品没有完成指定任务或经常出错导致无法正常运行，用户在已付款经购买的情况下，开发者必须协商解决问题，情况无法挽回的，须无条件提供退款。

开发者必须保证产品续用的通知事宜，否则因此造成的用户损失将由开发者自己承担。操作复杂的应用软件，开发者应提供操作技术支持，时限最少6个月，最高不设上限。

Etongapp支持开发者和终端用户交流解决售前、售后问题，会尽一切努力保证开发者和终端客户的交流，后期会提供强大的在线客服系统给开发者和终端用户使用，作为在线服务。

4.3收费

除因为无法提供使用操作说明而被下架的情况，开发者有权决定产品及服务何时下架，及产品和服务的收费方式及价格。这其中包括，产品是否永久销售、分期销售，分期付款、全额付款等等，etongapp原则上不会干涉。

5、建站用户

5.1 用户义务

Etongapp提供技术支持，尽一切可能为用户创造安全、可信的交易平台，并保证所有产品和服务能够正常运行，这其中包括软件测试，审查网站或博客内容是否雅观，是否带有政治性，是否带有病毒等，etongapp尽力，但无法保证万无一失。

用户有责任采取必要的预防措施来保护自己和您的计算机系统免受病毒、蠕虫、木马等有害或破坏性内容的损害。

5.2  用户权益

Etongapp维护平台交易秩序，认可用户权益，平台所有产品及服务都由产品产品提供商负全责。用户在使用及购买产品及服务过程中遇到的任何问题，请和产品提供商联系。

因为产品没有完成指定任务或经常出错导致无法正常运行时，用户可和产品提供协商解决，情况无法挽回的，可申请退款。协商无果的情况下，etongapp将尽力调解，但因第三方开发者产生的任何责任的任何损害，etongapp不承担任何责任。

6、禁止

用户在使用本服务时须遵守法律法规，不得利用本服务从事违法违规行为，包括但不限于：（1）发布、传送、传播、储存危害国家安全统一、破坏社会稳定、违反公序良俗、侮辱、诽谤、淫秽、暴力以及任何违反国家法律法规的内容或者移动应用；（2）发布、传送、传播、储存侵害他人知识产权、商业秘密等合法权利的内容或者移动应用；（3）恶意虚构事实、隐瞒真相以误导、欺骗他人；（4）发布、传送、传播广告信息及垃圾信息；（5）其他法律法规禁止的行为；

如果用户违反了本条约定，相关国家机关或机构可能会对用户提起诉讼、罚款或采取其他制裁措施，对于造成损害的，用户应依法予以赔偿，etongapp不承担任何责任。

如果etongapp发现或收到他人举报用户发布的信息违反本条约定，etongapp有权进行独立判断并采取技术手段予以删除、屏蔽或断开链接。同时，etongapp有权视用户的行为性质，采取包括但不限于暂停或终止服务，限制、冻结或终止etongapp网站账号的使用，追究法律责任等措施。

用户在使用本服务过程中应当遵守当地相关的法律法规，并尊重当地的道德和风俗习惯。如果用户的行为违反了当地法律法规或道德风俗，用户应当为此独立承担责任。

用户应避免因使用本服务而使etongapp卷入政治和公共事件，否则etongapp有权暂停或终止对用户的服务。

7、 免责声明

用户理解并同意，在使用本服务的过程中，可能会遇到不可抗力等风险因素，使本服务发生中断。不可抗力是指不能预见、不能克服并不能避免且对一方或双方造成重大影响的客观事件，包括但不限于自然灾害如洪水、地震、瘟疫流行和风暴等以及社会事件如战争、动乱、政府行为等。出现上述情况时，etongapp将努力在第一时间与相关单位配合，及时进行修复，但是由此给用户造成的损失etongapp在法律允许的范围内免责。

在法律允许的范围内，etongapp对以下情形导致的服务中断或受阻不承担责任：

（1）受到计算机病毒、木马或其他恶意程序、黑客攻击的破坏；

（2）用户或etongapp的电脑软件、系统、硬件和通信线路出现故障；

（3）用户操作不当；

（4）用户通过非etongapp授权的方式使用本服务；

（5）其他etongapp无法控制或合理预见的情形；

用户理解并同意，在使用本服务的过程中，可能会遇到网络信息或其他用户行为带来的风险，etongapp不对任何信息的真实性、适用性、合法性承担责任，也不对因侵权行为给用户造成的损害负责。
8 、终止
用户使用etongapp的服务即视为用户已阅读本条款并接受本条款的约束。etongapp有权在必要时修改本条款条款。

如发生下列任何一种情形，etongapp有权不经通知而中断或终止向用户提供的服务：（1）根据法律规定用户应提交真实信息，而用户提供的个人资料不真实、或与注册时信息不一致又未能提供合理证明；（2）用户违反相关法律法规或本条款的约定；（3）按照法律规定或主管部门的要求；（4）出于安全的原因或其他必要的情形；（5）开发对“etongapp”及互联网环境造成危害或者不利影响的移动应用。
9、修订
Etongapp正在不断地更新务，这意味着有时etongapp必须改变服务所提供的法律条款。如果etongapp做出改变，etongapp会通过博客、电子邮件及其他沟通方式让用户知道。

该通知存在一段时间后，新条款将生效。本条款条款变更后，如果用户继续使用etongapp提供的软件或服务，即视为用户已接受修改后的条款。如果用户不接受修改后的条款，应当停止使用etongapp提供的软件或服务。需要注意的是，在发生变化之前，任何争端都应遵循此协议。');?>
	</textarea>
	<br/>
	<div id="agreement_error" class="error_notice"><i class="fa fa-exclamation-circle"></i> <?php _e('尚未同意有关协议'); ?></div>
	<label class="verify_agr">
	<input type="checkbox" name="verify_agreement" id="verify_agreement" /><?php _e('我同意'); ?></label>
</div>

<div id="information_area" class="information_area verify_form_div" style="display:<?php echo ( $this->fill_fail_status == $verify_status ) ? 'block' : 'none'; ?>;">
	<form id="verify_form" method="post" enctype="multipart/form-data">
	<table class="form-table">
		<tr class="information_form_field verify_style_company" <?php echo ( isset($display_info) && !$display_info) ? '' : 'style="display:none;"'; ?>>
			<th></th>
			<td>
				<div class="verify_information_title"><?php _e('公司认证'); ?></div>
				(<div class="error_logo">*</div><?php _e('为必填选项'); ?>)
			</td>
		</tr>

		<tr class="information_form_field verify_style_company" <?php echo ( isset($display_info) && !$display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label for="verify_company_name" id="label_company_name"><?php _e('公司名称'); ?></label>
			</th>
			<td>
				<input class="form-control" id="verify_company_name" name="verify_company_name" type="text" placeholder="<?php _e('请输入公司名称'); ?>" value="<?php echo isset($user_options['verify_company_name']) ? $user_options['verify_company_name'] : ''; ?>"/>
				<div class="error_notice" id="error_company_name"></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_company" <?php echo ( isset($display_info) && !$display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label for="verify_license_number" id="label_license_number"><?php _e('公司营业执照号码'); ?></label>
			</th>
			<td>
				<input class="form-control" id="verify_license_number" name="verify_license_number" type="text" placeholder="<?php _e('请输入公司营业执照号码'); ?>" value="<?php echo isset($user_options['verify_license_number']) ? $user_options['verify_license_number'] : ''; ?>" />
				<div class="error_notice" id="error_license_number"></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_company" <?php echo ( isset($display_info) && !$display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label for="verify_license_image"><?php _e('公司营业执照上传'); ?></label>
			</th>
			<td>
				<input type="file" name="verify_license_image" id="verify_license_image" class="upload_file_image" /><img id="verify_license_image_preview" class="verify_card_img" src="<?php echo ( isset($user_options['verify_license_image']) && !empty($user_options['verify_license_image']) ) ? esc_url( STACKTECH_VERIFY_IMG_URL . $user_options['verify_license_image'] ) : esc_url( plugins_url('image/001.jpg',dirname(__FILE__) ) ); ?>" />
				<div class="error_notice" id="error_license_image"></div>
				<p class="mark">
				<?php _e('(请提交贵公司有效营业执照  格式如下：支持　.jpg .jpeg .bmp .gif .png格式照片，大小不超过5M)'); ?></p>
			</td>
			<td>
				<div><?php _e('示例图'); ?></div>
				<div><img src="<?php echo esc_url( plugins_url('image/fr.jpeg',dirname(__FILE__) ) ); ?>" class="fr" /></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_company" <?php echo ( isset($display_info) && !$display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label for="verify_organization_number" id="label_organization_number"><?php _e('公司组织机构代码'); ?></label>
			</th>
			<td>
				<input class="form-control" id="verify_organization_number" name="verify_organization_number" type="text" placeholder="<?php _e('请输入公司组织机构代码'); ?>" value="<?php echo isset($user_options['verify_organization_number']) ? $user_options['verify_organization_number'] : ''; ?>" />
				<div class="error_notice" id="error_organization_number"></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_company" <?php echo ( isset($display_info) && !$display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label><?php _e('公司组织机构代码上传'); ?></label>
			</th>
				<td>
				<input type="file" name="verify_organization_image" id="verify_organization_image" class="upload_file_image" /><img id="verify_organization_image_preview" class="verify_card_img" src="<?php echo ( isset($user_options['verify_organization_image']) && !empty($user_options['verify_organization_image']) ) ? esc_url( STACKTECH_VERIFY_IMG_URL . $user_options['verify_organization_image'] ) : esc_url( plugins_url('image/003.jpg',dirname(__FILE__) ) ); ?>" />
				<div class="error_notice" id="error_organization_image"></div>
				<p class="mark">
					<?php _e('(请提交贵公司有效组织机构代码证  格式如下：支持　.jpg .jpeg .bmp .gif .png格式照片，大小不超过5M)'); ?>
				</p>
			</td>

				<!-- <table class="update">
					<tr>
						<td><input type="file" name="verify_organization_image" id="verify_organization_image" />
						<div class="error_notice" id="error_organization_image"></div>
						</td>
						<td><input type="file" name="verify_organization_back_image" id="verify_organization_back_image" />
						<div class="error_notice" id="error_organization_back_image"></div>
						</td>
					</tr>
					<tr>
						<td><img id="verify_organization_image_preview" class="verify_card_img" /></td>
						<td><img id="verify_organization_back_image_preview" class="verify_card_img" /></td>
					</tr>
				</table>
				 -->
			<td>
			
						<div><?php _e('示例图'); ?></div>
					
						<div><img src="<?php echo esc_url( plugins_url('image/zz.jpg',dirname(__FILE__) ) ); ?>" class="zz" /></div>
					
			</td>
		</tr>

		<tr class="information_form_field verify_style_company" <?php echo ( isset($display_info) && !$display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label for="verify_tax_number" id="label_tax_number"><?php _e('公司税务登记证号码'); ?></label>
			</th>
			<td>
				<input class="form-control" id="verify_tax_number" name="verify_tax_number" type="text" placeholder="<?php _e('请输入公司税务登记证号码'); ?>" value="<?php echo isset($user_options['verify_tax_number']) ? $user_options['verify_tax_number'] : ''; ?>" />
				<div class="error_notice" id="error_tax_number"></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_company" <?php echo ( isset($display_info) && !$display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label for="verify_tax_image"><?php _e('公司税务登记证号码上传'); ?></label>
			</th>
			<td>
				<input type="file" name="verify_tax_image" id="verify_tax_image" class="upload_file_image" /><img id="verify_tax_image_preview" class="verify_card_img" src="<?php echo ( isset($user_options['verify_tax_image']) && !empty($user_options['verify_tax_image']) ) ? esc_url( STACKTECH_VERIFY_IMG_URL . $user_options['verify_tax_image'] ) : esc_url( plugins_url('image/001.jpg',dirname(__FILE__) ) ); ?>" />
				<div class="error_notice" id="error_tax_image"></div>
				<p class="mark">
					<?php _e('(请提交贵公司有效税务登记证  格式如下：支持　.jpg .jpeg .bmp .gif .png格式照片，大小不超过5M)'); ?>
				</p>
			</td>
			<td>
				<div><?php _e('示例图'); ?></div>
				<div><img src="<?php echo esc_url( plugins_url('image/sw.jpg',dirname(__FILE__) ) ); ?>" class="sw"/></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_company" <?php echo ( isset($display_info) && !$display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label for="verify_owner_name" id="label_owner_name"><?php _e('运营者姓名'); ?></label>
			</th>
			<td>
				<input class="form-control" id="verify_owner_name" name="verify_owner_name" type="text" placeholder="<?php _e('请输入运营者姓名'); ?>" value="<?php echo isset($user_options['verify_owner_name']) ? $user_options['verify_owner_name'] : ''; ?>" />
				<div class="error_notice" id="error_owner_name"></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_personal" <?php echo ( isset($display_info) && $display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
			</th>
			<td>
				<div class="verify_agreement_title"><?php _e('个人认证'); ?></div>
				(<div class="error_logo">*</div><?php _e('为必填选项'); ?>)
			</td>
		</tr>

		<tr class="information_form_field verify_style_personal" <?php echo ( isset($display_info) && $display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<label for="verify_user_name" id="label_user_name"><div class="error_logo">*</div><?php _e('姓名'); ?></label>
			</th>
			<td>
				<input class="form-control" id="verify_user_name" name="verify_user_name" type="text" placeholder="<?php _e('请输入姓名'); ?>" value="<?php echo isset($user_options['verify_user_name']) ? $user_options['verify_user_name'] : ''; ?>" />
				<div class="error_notice" id="error_user_name"></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_inform">
			<th>
				<label for="verify_user_card_id" id="label_user_card_id"><div class="error_logo">*</div><?php _e('身份证号'); ?></label>
			</th>
			<td>
				<input class="form-control" id="verify_user_card_id" name="verify_user_card_id" type="text" placeholder="<?php _e('请输入身份证号'); ?>" value="<?php echo isset($user_options['verify_user_card_id']) ? $user_options['verify_user_card_id'] : ''; ?>" />
				<div class="error_notice" id="error_user_card_id"></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_inform">
			<th>
				
				<label for="verify_user_card_front_image" id="one">
				<div class="error_logo">*</div><?php _e('身份证上传(正反面)'); ?></label>
			</th>
			<td>
				<table class="update">
					<tr>
						<td><input type="file" name="verify_user_card_front_image" id="verify_user_card_front_image" class="upload_file_image" /><img id="verify_user_card_front_image_preview" class="verify_card_img" src="<?php echo ( isset($user_options['verify_user_card_front_image']) && !empty($user_options['verify_user_card_front_image']) ) ? esc_url( STACKTECH_VERIFY_IMG_URL . $user_options['verify_user_card_front_image'] ) : esc_url( plugins_url('image/001.jpg',dirname(__FILE__) ) ); ?>" />
						<div class="error_notice" id="error_user_card_front_image"></div>
						</td>
						<td><input type="file" name="verify_user_card_back_image" id="verify_user_card_back_image" class="upload_file_image" /><img id="verify_user_card_back_image_preview" class="verify_card_img" src="<?php echo ( isset($user_options['verify_user_card_back_image']) && !empty($user_options['verify_user_card_back_image']) ) ? esc_url( STACKTECH_VERIFY_IMG_URL . $user_options['verify_user_card_back_image'] ) : esc_url( plugins_url('image/001.jpg',dirname(__FILE__) ) ); ?>" />
						<div class="error_notice" id="error_user_card_back_image"></div>
						</td>
					</tr>
				</table>
				<p class="mark-id">
				<?php _e('(请提交中华人民共和国居民身份证，无居民身份证可提交＜临时居民身份证＞格式要求：支持　.jpg .jpeg .bmp .gif .png格式照片，大小不超过5M)'); ?></p>
			</td>
			<td>
				<table class="id-img">
					<tr>
						<th><?php _e('示例(正面)'); ?></th>
						<th><?php _e('示例(反面)'); ?></th>
					</tr>
					<tr>
						<td><img src="<?php echo esc_url( plugins_url('image/card_id_front.jpg',dirname(__FILE__) ) ); ?>" class="verify_card_img-id" /></td>
						<td><img src="<?php echo esc_url( plugins_url('image/card_id_back.jpg',dirname(__FILE__) ) ); ?>" class="verify_card_img-id" /></td>
					</tr>
				</table>
			</td>
		</tr>		

		<tr class="information_form_field verify_style_inform">
			<th>
				<label for="verify_phone" id="label_verify_phone"><div class="error_logo">*</div><?php _e('手机号码'); ?></label>
			</th>
			<td id="send">
				<div id="verify_phone_span">
					<input class="form-control" id="verify_phone" name="verify_phone" type="text" placeholder="<?php _e('请输入手机号码'); ?>" value="<?php echo $verify_phone; ?>" <?php echo $phone_disabled; ?>/>
				</div>
				<button type="button" id="verify_phone_button" onClick="get_mobile_code('verify_phone');" <?php echo $phone_disabled; ?>><?php echo $verify_phone_button; ?></button>
				<div class="error_notice" id="error_verify_phone"><?php (1 == $reason['verify_phone'] && $this->fill_fail_status == $verify_status ) ? _e('手机未验证') : ''; ?></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_inform" id="verify_sms_msg_span" style="display: none;">
			<th>
				<label for="verify_sms_msg"><div class="error_logo">*</div><?php _e('验证码'); ?></label>
			</th>
			<td >
				<input class="form-control" id="verify_sms_msg" name="verify_sms_msg" type="text" placeholder="<?php _e('请输入验证码'); ?>" />
				<button type="button" id="verify_sms_msg_button" onClick="verify_input_sms_msg();"><?php _e('确定'); ?></button>
				<div class="error_notice" id="sms_error_message"></div>
			</td>
		</tr>

		<?php if($this->user_action == 2 ){ ?>
		<tr class="information_form_field verify_style_personal" <?php echo ( isset($display_info) && $display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<label for="verify_personal_bank_account" id="label_personal_bank_account"><div class="error_logo">*</div><?php _e('支付宝账号'); ?></label>
			</th>
			<td>
				<input class="form-control" id="verify_personal_bank_account" name="verify_personal_bank_account" type="text" placeholder="<?php _e('请输入支付宝账号'); ?>" value="<?php echo isset($user_options['verify_personal_bank_account']) ? $user_options['verify_personal_bank_account'] : ''; ?>" />
				<div class="error_notice" id="error_personal_bank_account"></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_company" <?php echo ( isset($display_info) && !$display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label id="label_company_bank_type"><?php _e('账号类型'); ?></label>
			</th>
			<td>
				<div class="verify_company_bank_pos">
				<input type="radio" class="form-control verify_company_bank_type" name="verify_company_bank_type" value="2" <?php if ( 1 != $user_options['verify_company_bank_type'] ) echo 'checked="checked"';?>><?php _e('公司银行账号'); ?>
				<input type="radio" class="form-control verify_company_bank_type" name="verify_company_bank_type" value="1" <?php checked( $user_options['verify_company_bank_type'], 1 ); ?>/><?php _e('支付宝账号'); ?>
				</div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_company" <?php echo ( isset($display_info) && !$display_info) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label for="verify_company_bank_account" id="label_company_bank_account"><?php echo ( 1 != $user_options['verify_company_bank_type'] ) ? '公司银行账号' : '支付宝账号'; ?></label>
			</th>
			<td>
				<input class="form-control" id="verify_company_bank_account" name="verify_company_bank_account" type="text" placeholder="<?php _e('请输入账号'); ?>" value="<?php echo isset($user_options['verify_company_bank_account']) ? $user_options['verify_company_bank_account'] : ''; ?>" />
				<div class="error_notice" id="error_company_bank_account"></div>
			</td>
		</tr>

		<tr class="information_form_field verify_style_company verify_style_company_extend" <?php echo ( isset($display_info) && !$display_info && $user_options['verify_company_bank_type'] != 1 ) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label for="verify_company_bank_name" id="label_company_bank_name"><?php _e('企业开户行'); ?></label>
			</th>
			<td>
				<input class="form-control" id="verify_company_bank_name" name="verify_company_bank_name" type="text" placeholder="<?php _e('请输入企业开户行'); ?>" value="<?php echo isset($user_options['verify_company_bank_name']) ? $user_options['verify_company_bank_name'] : ''; ?>" />
				<div class="error_notice" id="error_company_bank_name"></div>
			</td>
		</tr>
		<tr class="information_form_field verify_style_company verify_style_company_extend" <?php echo ( isset($display_info) && !$display_info && $user_options['verify_company_bank_type'] != 1 ) ? '' : 'style="display:none;"'; ?>>
			<th>
				<div class="error_logo">*</div><label for="verify_company_bank_position" id="label_company_bank_position"><?php _e('企业开户名称'); ?></label>
			</th>
			<td>
				<input class="form-control" id="verify_company_bank_position" name="verify_company_bank_position" type="text" placeholder="<?php _e('请输入企业开户名称'); ?>" value="<?php echo isset($user_options['verify_company_bank_position']) ? $user_options['verify_company_bank_position'] : ''; ?>" />
				<div class="error_notice" id="error_company_bank_position"></div>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php wp_nonce_field('verify_userinfo'); ?>
	<input type="hidden" name="verify_style" id="verify_style" value="personal">
	<input type="hidden" name="action" id="action" value="personal">
	</form>
</div>

<div id="verify_confirm_area" class="verify_confirm_area verify_form_div">
	<table class="form-table">
		<tr class="confirm_field confirm_field_company">
			<th>
			</th>
			<td>
				<div class="confirm_title"><?php _e('公司认证'); ?></div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司名称'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_company_name">
				</div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司营业执照号码'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_license_number">
				</div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司营业执照上传'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field">
					<img id="confirm_license_image" class="verify_card_img" src="" />
				</div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司组织机构代码'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_organization_number">
				</div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司组织机构代码上传'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field">
					<div class="confirm_organization_image">
						<img id="confirm_organization_image" class="verify_card_img" src="" />
					</div>
					<!-- <div class="confirm_organization_back_image">
						<img id="confirm_organization_back_image" class="verify_card_img" src="" />
					</div> -->
				</div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司税务登记证号码'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_tax_number">
				</div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司税务登记证号码上传'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field">
					<img id="confirm_tax_image" class="verify_card_img" src="" />
				</div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('运营者姓名'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_owner_name">
				</div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_personal">
			<th>
			</th>
			<td>
				<div class="confirm_title"><?php _e('个人认证'); ?></div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_personal">
			<th>
				<label class="confirm_left_field"><?php _e('姓名'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_user_name">
				</div>
			</td>
		</tr>

		<tr class="confirm_field">
			<th>
				<label class="confirm_left_field"><?php _e('身份证号'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_user_card_id">
				</div>
			</td>
		</tr>

		<tr class="confirm_field">
			<th>
				<label class="confirm_left_field"><?php _e('身份证上传(正反面)'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field">
					<div class="confirm_user_card_front_image">
						<img id="confirm_user_card_front_image" class="verify_card_img" src="" />
					</div>
					<div class="confirm_user_card_back_image">
						<img id="confirm_user_card_back_image" class="verify_card_img" src="" />
					</div>
				</div>
			</td>
		</tr>

		<tr class="confirm_field">
			<th>
				<label class="confirm_left_field"><?php _e('手机号码'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_verify_phone">
				</div>
			</td>
		</tr>

		<?php if( 2 == $this->user_action){ ?>
		<tr class="confirm_field confirm_field_personal">
			<th>
				<label class="confirm_left_field"><?php _e('支付宝账号'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_personal_bank_account">
				</div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司银行账号或支付宝账号'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_company_bank_account">
				</div>
			</td>
		</tr>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"></label>
			</th>
			<td>
				<div class="confirm_right_field">
				<div id="confirm_company_bank_position" class="confirm_company_bank_position"></div>
				<div id="confirm_company_bank_name" class="confirm_company_bank_name"></div>
				</div>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>

<div id="verify_waiting_area" class="verify_waiting_area verify_form_div" style="display:<?php echo ( $this->verifying_info_status == $verify_status || ($this->verify_info_success_status == $verify_status && $this->user_action != 1 ) ) ? 'block' : 'none'; ?>;">
	<h3 class="ok"><?php _e('您的申请提交成功!'); ?></h3>
	<p class="ok-1"><?php ( $this->user_action == 1 ) ? _e('信息在审核中,请等待管理员进行信息确认
') : _e('信息在审核中,一个星期内我们会向您的支付宝账号或者银行账号转账一定的金额,请输入收到的金额值,完成验证
'); ?></p>
</div>

<?php if( $this->verify_info_fail_status == $verify_status || $this->fill_bank_status == $verify_status || $this->verify_bank_fail_status == $verify_status || $this->verify_success_status == $verify_status || ($this->verify_info_success_status == $verify_status && $this->user_action == 1 ) ){ ?>
<div id="verify_final_area" class="verify_final_area">
	<div class="verify_money">
	<?php if( $this->verify_info_fail_status == $verify_status ){ ?>
		<h1 class="error-1"><?php _e('抱歉您的申请未通过'); ?></h1>
		<p class="error-2"><?php _e('您填写的信息存在错误，请查看下面错误填写，需要您再申请一次，给您带来不变，敬请谅解！'); ?></p>
	<?php }elseif( $this->fill_bank_status == $verify_status ){ ?>
		<form id="verify_money_form" method="post">
			<span class="verify_money_title"><?php _e('输入转账金额:'); ?></span>
			<input type="text" name="verify_money" id="verify_money" />
			<button id="verify_money_button"><?php _e('提交'); ?></button>
			<p class="verify_money_error" id="verify_money_error"></p>
			<p><?php _e('请确认在收到银行转账金额后才开始填写,二次输入错误后将无法填写! '); ?></p>
			<?php wp_nonce_field('verify_money'); ?>
		</form>
	<?php }elseif( $this->verify_bank_fail_status == $verify_status ){ ?>
		<h1 class="error-1"><?php _e('抱歉您的申请未通过'); ?></h1>
		<p class="error-2"><?php echo __('您填写的银行金额存在错误，请与管理员联系，给您带来不变，敬请谅解！'); ?></p>
	<?php }elseif( $this->verify_success_status == $verify_status && $this->user_action == 2 ){ ?>
		<h3 class="ok"><?php _e('您的申请提交成功!'); ?></h3>
		<p class="ok-1">您已经成功完成开发者认证!</p>
		<a class="ok-2" href="<?php echo get_admin_url(BLOG_ID_CURRENT_SITE); ?>" target="_blank">点击进入开发者中心</a>
	<?php }elseif( ( $this->verify_info_success_status == $verify_status || $this->verify_success_status == $verify_status ) && $this->user_action == 1){ ?>
		<h3 class="ok"><?php _e('您的申请提交成功!'); ?></h3>
		<p class="ok-1">您已经成功完成代理认证!</p>
		<a class="ok-2" href="<?php echo get_site_url(SITE_ID_CURRENT_SITE) . '/wp-signup.php'; ?>" target="_blank">点击开始创建新的站点</a>
	<?php } ?>
	</div>

	<?php if( $this->verify_info_fail_status == $verify_status || $this->fill_bank_status == $verify_status ){ ?>
		
	<table class="form-table">
		<?php if(!$display_info){ ?>
		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司名称'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_company_name">
				<?php echo $user_options['verify_company_name']; ?>
				</div>
			</td>
			<td>
				<span class="error_notice"><?php echo isset($reason['verify_company_name']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_company_name'] : ''; ?></span>
				<?php if( $this->verify_info_fail_status == $verify_status ){ ?>
	<button class="verify_final_modify" id="verify_final_modify"><?php _e('修改'); ?></button>
		<?php } ?>
			</td>
		</tr>
		<?php } ?>

		<?php if(!$display_info){ ?>
		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司营业执照号码'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_license_number">
				<?php echo $user_options['verify_license_number']; ?>
				</div>
			</td>
			<td>
				<span class="error_notice"><?php echo isset($reason['verify_license_number']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_license_number'] : ''; ?></span>
			</td>
		</tr>
		<?php } ?>

		<?php if(!$display_info){ ?>
		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司营业执照上传'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field">
					<img id="confirm_license_image" class="verify_card_img" src="<?php echo esc_url( STACKTECH_VERIFY_IMG_URL . $user_options['verify_license_image'] ); ?>" />
				</div>
			</td>
			<td>
				<span class="error_notice"><?php echo isset($reason['verify_license_image']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_license_image'] : ''; ?></span>
			</td>
		</tr>
		<?php } ?>

		<?php if(!$display_info){ ?>
		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司组织机构代码'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_organization_number">
				<?php echo $user_options['verify_organization_number']; ?>
				</div>
			</td>
			<td>
				<span class="error_notice"><?php echo isset($reason['verify_organization_number']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_organization_number'] : ''; ?></span>
			</td>
		</tr>
		<?php } ?>

		<?php if(!$display_info){ ?>
		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司组织机构代码上传'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field">
					<div class="confirm_organization_image">
						<img id="confirm_organization_image" class="verify_card_img" src="<?php echo esc_url( STACKTECH_VERIFY_IMG_URL . $user_options['verify_organization_image'] ); ?>" />
					</div>
					<!-- <div class="confirm_organization_back_image">
						<img id="confirm_organization_back_image" class="verify_card_img" src="<?php echo esc_url( STACKTECH_VERIFY_IMG_URL . $user_options['verify_organization_back_image'] ); ?>" />
					</div> -->
				</div>
			</td>
			<td>
				<span class="error_notice"><?php echo isset($reason['verify_organization_image']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_organization_image'] : ''; ?></span>
			</td>
		</tr>
		<?php } ?>

		<?php if(!$display_info){ ?>
		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司税务登记证号码'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_tax_number">
				<?php echo $user_options['verify_tax_number']; ?>
				</div>
			</td>
			<td>
				<span class="error_notice"><?php echo isset($reason['verify_tax_number']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_tax_number'] : ''; ?></span>
			</td>
		</tr>
		<?php } ?>

		<?php if(!$display_info){ ?>
		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司税务登记证号码上传'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field">
					<img id="confirm_tax_image" class="verify_card_img" src="<?php echo esc_url( STACKTECH_VERIFY_IMG_URL . $user_options['verify_tax_image'] ); ?>" />
				</div>
			</td>
			<td>
				<span class="error_notice"><?php echo isset($reason['verify_tax_image']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_tax_image'] : ''; ?></span>
			</td>
		</tr>
		<?php } ?>

		<?php if(!$display_info){ ?>
		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('运营者姓名'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_owner_name">
				<?php echo $user_options['verify_owner_name']; ?>
				</div>
			</td>
			<td>
				<span class="error_notice"><?php echo isset($reason['verify_owner_name']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_owner_name'] : ''; ?></span>
			</td>
		</tr>
		<?php } ?>

		<?php if($display_info){ ?>
		<tr class="confirm_field confirm_field_personal">
			<th>
				<label class="confirm_left_field"><?php _e('姓名'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_user_name">
				<?php echo $user_options['verify_user_name']; ?>
				</div>
			</td>
			<td>
				<span class="error_notice notice-1"><?php echo isset($reason['verify_user_name']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_user_name'] : ''; ?></span>
				<?php if( $this->verify_info_fail_status == $verify_status ){ ?>
	<button class="verify_final_modify" id="verify_final_modify"><?php _e('修改'); ?></button>
		<?php } ?>
			</td>
		</tr>
		<?php } ?>

		<tr class="confirm_field">
			<th>
				<label class="confirm_left_field"><?php _e('身份证号'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_user_card_id">
				<?php echo $user_options['verify_user_card_id']; ?>
				</div>
			</td>
			<td>
				<span class="error_notice notice-1"><?php echo isset($reason['verify_user_card_id']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_user_card_id'] : ''; ?></span>
			</td>
		</tr>

		<tr class="confirm_field">
			<th>
				<label class="confirm_left_field"><?php _e('身份证上传(正反面)'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field">
					<div class="confirm_user_card_front_image">
						<img id="confirm_user_card_front_image" class="verify_card_img" src="<?php echo esc_url( STACKTECH_VERIFY_IMG_URL . $user_options['verify_user_card_front_image'] ); ?>" />
					</div>
					<div class="confirm_user_card_back_image">
						<img id="confirm_user_card_back_image" class="verify_card_img" src="<?php echo esc_url( STACKTECH_VERIFY_IMG_URL . $user_options['verify_user_card_back_image'] ); ?>" />
					</div>
				</div>
			</td>
			<td>
				<span class="error_notice notice-1"><?php echo isset($reason['verify_user_card_image']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_user_card_image'] : ''; ?></span>
			</td>
		</tr>

		<tr class="confirm_field">
			<th>
				<label class="confirm_left_field"><?php _e('手机号码'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_verify_phone">
				<?php echo $verify_phone; ?>
				</div>
			</td>
		</tr>

		<?php if($display_info && $this->user_action != 1){ ?>

		<tr class="confirm_field confirm_field_personal">
			<th>
				<label class="confirm_left_field"><?php _e('支付宝账号'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_personal_bank_account">
				<?php echo $user_options['verify_personal_bank_account']; ?>
				</div>
			</td>
			<td>
				<span class="error_notice notice-1"><?php echo isset($reason['verify_personal_bank_account']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_personal_bank_account'] : ''; ?></span>
			</td>
		</tr>
		<?php } ?>

		<?php if(!$display_info && $this->user_action != 1){ ?>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"><?php _e('公司银行账号或支付宝账号'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_company_bank_account">
				<?php echo $user_options['verify_company_bank_account']; ?>
				</div>
			</td>
			<td>
				<span class="error_notice"><?php echo isset($reason['verify_company_bank_account']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_company_bank_account'] : ''; ?></span>
			</td>
		</tr>
		<?php } ?>

		<?php if(!$display_info && $this->user_action != 1 && $user_options['verify_company_bank_type'] == 2 ){ ?>

		<tr class="confirm_field confirm_field_company">
			<th>
				<label class="confirm_left_field"></label>
			</th>
			<td>
				<div class="confirm_right_field">
				<div id="confirm_company_bank_position" class="confirm_company_bank_position">
				<?php echo $user_options['verify_company_bank_position']; ?>
				</div>
				<div id="confirm_company_bank_name" class="confirm_company_bank_name">
				<?php echo $user_options['verify_company_bank_name']; ?>
				</div>
				</div>
			</td>
			<td>
				<span class="error_notice"><?php echo isset($reason['verify_company_bank_name']) ? '<i class="fa fa-exclamation-circle"></i> '.$reason['verify_company_bank_name'] : ''; ?></span>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>
</div>
<?php } ?>

<?php
if( in_array( $verify_status, $bottom_allow_arr ) ){ ?>
<div class="verify_userinfo_step">
	<button id="verify_prev_step_button" class="verify_prev_step_button" <?php echo ( $this->verify_info_fail_status == $verify_status ) ? '' : 'style="display:none;"'; ?> ><?php _e('上一步'); ?></button>

	<button id="verify_next_step_button" class="verify_next_step_button"><?php _e('下一步'); ?></button>
</div>
<?php } ?>