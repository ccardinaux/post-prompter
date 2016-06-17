<!doctype html>
<html>
	<head>
		<meta name="viewport" content="width=device-width">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>It's time to write a blog post!</title>
		<style>
		/* -------------------------------------
		GLOBAL
		------------------------------------- */
		* {
			font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
			font-size: 100%;
			line-height: 1.6em;
			margin: 0;
			padding: 0;
		}

		img {
			max-width: 600px;
			width: auto;
		}

		body {
			-webkit-font-smoothing: antialiased;
			height: 100%;
			-webkit-text-size-adjust: none;
			width: 100% !important;
		}


		/* -------------------------------------
		ELEMENTS
		------------------------------------- */
		a {
			color: #348eda;
		}

		.btn-primary {
			margin: 40px auto;
			width: auto !important;
		}

		.btn-primary td {
			background-color: #348eda; 
			border-radius: 25px;
			font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; 
			font-size: 14px; 
			text-align: center;
			vertical-align: top; 
		}

		.btn-primary td a {
			background-color: #348eda;
			border: solid 1px #348eda;
			border-radius: 25px;
			border-width: 10px 20px;
			display: inline-block;
			color: #ffffff;
			cursor: pointer;
			font-weight: bold;
			line-height: 2;
			text-decoration: none;
		}

		.btn-primary td a:hover {
			background-color: #377BB5;
			border-color: #377BB5;
		}

		.last {
			margin-bottom: 0;
		}

		.first {
			margin-top: 0;
		}

		.padding {
			padding: 10px 0;
		}


		/* -------------------------------------
		BODY
		------------------------------------- */
		table.body-wrap {
			padding: 20px;
			width: 100%;
		}

		table.body-wrap .container {
			border: 1px solid #f0f0f0;
		}


		/* -------------------------------------
		FOOTER
		------------------------------------- */
		table.footer-wrap {
			clear: both !important;
			width: 100%;  
		}

		.footer-wrap .container p {
			color: #666666;
			font-size: 12px;
		}

		table.footer-wrap a {
			color: #999999;
		}


		/* -------------------------------------
		TYPOGRAPHY
		------------------------------------- */
		h1, 
		h2, 
		h3 {
			color: #111111;
			font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
			font-weight: 200;
			line-height: 1.2em;
			margin: 40px 0 10px;
		}

		h1 {
			font-size: 36px;
		}
		h2 {
			font-size: 28px;
		}
		h3 {
			font-size: 22px;
		}

		p, 
		ul, 
		ol {
			font-size: 14px;
			font-weight: normal;
			margin-bottom: 10px;
		}

		ul li, 
		ol li {
			margin-left: 5px;
			list-style-position: inside;
		}

		small {
			font-size: 12px;
			color: #666666;
		}

		strong {
			font-weight: bold;
		}

		/* ---------------------------------------------------
		RESPONSIVENESS
		------------------------------------------------------ */

		/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
		.container {
			clear: both !important;
			display: block !important;
			margin: 0 auto !important;
			max-width: 600px !important;
		}

		/* Set the padding on the td rather than the div for Outlook compatibility */
		.body-wrap .container {
			padding: 20px;
		}

		/* This should also be a block element, so that it will fill 100% of the .container */
		.content {
			display: block;
			margin: 0 auto;
			max-width: 600px;
		}

		/* Let's make sure tables in the content area are 100% wide */
		.content table {
			width: 100%;
		}

		</style>
	</head>

	<body bgcolor="#f6f6f6">

		<!-- body -->
		<table class="body-wrap" bgcolor="#f6f6f6">
			<tr>
				<td></td>
				<td class="container" bgcolor="#FFFFFF">

					<!-- content -->
					<div class="content">
						<table>
							<tr>
								<td>
									<p>Howdy <?php echo $first_name; ?>,</p>

									<p><?php echo $last_published; ?></p>
									<p><?php echo $most_recent; ?></p>

									<h3>This is a friendly reminder to get to writing!</h3>
									<p>Perhaps you might find these recent articles inspiring:</p>

									<ul>
										<?php if ( $maxitems == 0 ) : ?>
											<li>No articles found. Try a <a href="https://news.google.com/">Google News search</a> instead.</li>
										<?php else : ?>
											<?php foreach ( $rss_items as $item ) : ?>
												<li>
													<a href="<?php echo esc_url( $item->get_permalink() ); ?>"
													title="<?php printf( __( 'Posted %s', 'wpdocs_textdomain' ), $item->get_date('j F Y | g:i a') ); ?>">
														<?php echo esc_html( $item->get_title() ); ?>
													</a>
												</li>
											<?php endforeach; ?>
										<?php endif; ?>
									</ul>

									<p><small>
										Articles are from Google News based on your keyword <a href="<?php echo $news_url; ?>"><strong><?php echo $keywords; ?></strong></a>.<br>
										<a href="<?php echo $unsubscribe_url; ?>">Visit your profile</a> to update your keyword selections.
									</small></p>

									<!-- button -->
									<table class="btn-primary" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td>
												<a href="<?php echo $new_post_url; ?>">Write a new blog post</a>
											</td>
										</tr>
									</table>
									<!-- /button -->

									<p>Have a great day!</p>
									<p>Post Prompter Robot</p>
								</td>
							</tr>
						</table>
					</div>
					<!-- /content -->

				</td>
				<td></td>
			</tr>
		</table>
		<!-- /body -->

		<!-- footer -->
		<table class="footer-wrap">
			<tr>
				<td></td>
				<td class="container">

					<!-- content -->
					<div class="content">
						<table>
							<tr>
								<td align="center">
									<p>Tired of being prompted? <a href="<?php echo $unsubscribe_url; ?>">Visit your profile</a> to unsubscribe.</p>
								</td>
							</tr>
						</table>
					</div>
					<!-- /content -->

				</td>
				<td></td>
			</tr>
		</table>
		<!-- /footer -->

	</body>
</html>
