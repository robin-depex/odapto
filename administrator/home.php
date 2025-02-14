
	<tr>
		<td class="content-main hidenavlayer">
			<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
				<tr>
					<td class="bigtitel">
						<table border="0" cellpadding="0" cellspacing="0" style="line-height: 12px; padding: 3px; padding-left: 0px;" width="100%">
							<tr>
								<td class="bigtitel">WELCOME TO ADMINISTRATOR PANEL</td>

								<td style="font-weight: bold; text-align: right;" width="140">
									<?php echo $_SESSION['sess_user']; ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>


			<form action="hpm_login.php" id="formular" method="post" name="formular" style="margin:0px;">
				<table border="0" cellpadding="3" cellspacing="0" class="tabelle1" width="100%">
					<tr>
						<td style="width:15%; float: left;background: #68aea0; border: 1px solid #000; border-radius:12px; padding:15px;text-align:center;margin: 5px; font-size: 16px;color: #fff">							
							

							<span class="fa fa-user fa-2x"></span>
							<br style="clear: both">
							<a href="<?php echo ADMIN_URL;?>index.php?page=user-action" style="color:#fff">Add User</a>							
						</td>
						
						<td style="width:15%; float: left;background: #68aea0; border: 1px solid #000; border-radius:12px; padding:15px;text-align:center;margin: 5px; font-size: 16px;color: #fff">
							<span class="fa fa-globe fa-2x"></span>
							<br style="clear: both">
							<a href="<?php echo ADMIN_URL;?>index.php?page=user" style="color:#fff">View All User</a>
						</td>
						
						
					</tr>
					
				</table>
			</form>
		</td>
	</tr>
