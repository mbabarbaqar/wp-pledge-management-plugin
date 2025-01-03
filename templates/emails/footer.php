<?php
/**
 * Email Footer
 *
 * Override this template by copying it to yourtheme/hspg/emails/footer.php
 *
 * @author  Studio 164a
 * @package Hspg/Templates/Emails
 * @version 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// For gmail compatibility, including CSS styles in head/body are stripped out therefore styles need to be inline. These variables contain rules which are added to the template inline.
$template_footer = "
	border-top:0;
	-webkit-border-radius:3px;
";

$credit = "
	border:0;
	color: #000000;
	font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
	font-size:12px;
	line-height:125%;
	text-align:center;
";
?>
															</div>
														</td>
													</tr>
												</table>
												<!-- End Content -->
											</td>
										</tr>
									</table>
									<!-- End Body -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer" style="<?php echo $template_footer; ?>">
										<tr>
											<td valign="top">
												<table border="0" cellpadding="10" cellspacing="0" width="100%">
													<tr>
														<td colspan="2" valign="middle" id="credit" style="<?php echo $credit; ?>">
															<?php
																echo wpautop(
																	wp_kses_post(
																		wptexturize(
																			/**
																			 * Filter the email footer text & link.
																			 *
																			 * @since 1.0.0
																			 *
																			 * @param string $text The default text.
																			 */
																			apply_filters( 'hs_email_footer_text', '<a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>' )
																		)
																	)
																);
															?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<!-- End Footer -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
