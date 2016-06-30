<div class="">
	<form method="post" id="verify_userinfo_form">
	<table class="form-table">
		<?php if(!$display_info){ ?>
		<tr class="confirm_field confirm_field_company">
			<th>
			</th>
			<td>
				<div class="confirm_title"><?php _e('公司认证'); ?></div>
			</td>
			<td></td>
		</tr>
		<?php } ?>

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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_company_name_notice"></textarea></span>
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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_license_number_notice"></textarea></span>
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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_license_image_notice"></textarea></span>
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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_organization_number_notice"></textarea></span>
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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_organization_image_notice"></textarea></span>
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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_tax_number_notice"></textarea></span>
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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_tax_image_notice"></textarea></span>
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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_owner_name_notice"></textarea></span>
			</td>
		</tr>
		<?php } ?>

		<?php if($display_info){ ?>
		<tr class="confirm_field confirm_field_personal">
			<th>
			</th>
			<td>
				<div class="confirm_title"><?php _e('个人认证'); ?></div>
			</td>
			<td></td>
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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_user_name_notice"></textarea></span>
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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_user_card_id_notice"></textarea></span>
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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_user_card_image_notice"></textarea></span>
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

		<?php if($display_info && 2 == $user_action){ ?>

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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_personal_bank_account_notice"></textarea></span>
			</td>
		</tr>
		<?php } ?>

		<?php if(!$display_info && 2 == $user_action){ ?>

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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_company_bank_account_notice"></textarea></span>
			</td>
		</tr>
		<?php } ?>

		<?php if(!$display_info && 2 == $user_action && 2 == $user_options['verify_company_bank_type'] ){ ?>

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
				<button class="confirm_fail_button"><?php _e('审核失败提示'); ?></button>
				<span class="confirm_fail_notice"><textarea class="confirm_notice_area" name="confirm_company_bank_name_notice"></textarea></span>
			</td>
		</tr>
		<?php } ?>

		<tr class="confirm_field">
			<th>
				<label class="confirm_left_field"><?php _e('申请类型'); ?></label>
			</th>
			<td>
				<div class="confirm_right_field" id="confirm_user_action">
				<?php echo $user_action_content; ?>
				</div>
			</td>
		</tr>
	</table>
	<div class="verify_userinfo_step">
		<button class="verify_userinfo_button verify_userinfo_fail_button" status="fail"><?php _e('审核失败'); ?></button>
		<button class="verify_userinfo_button verify_userinfo_success_button" status="success"><?php _e('审核通过'); ?></button>
	</div>
	<?php wp_nonce_field('admin_verify_userinfo'); ?>
	<input type="hidden" name="verify_userinfo_status" id="verify_userinfo_status" value="" />
	<input type="hidden" name="verify_style" value="<?php echo $verify_style; ?>" />
	</form>
</div>