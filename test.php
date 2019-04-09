<?php

function notifyDealClients() {
	/**
	 *
     * NOTIFY DEAL CLIENTS -------------------------------
     *
	 */

	$args = array(
		'post_type' => 'deal',
		'posts_per_page' => -1
	);
	// Get all the deals
	$loop = new WP_Query($args);

	//wp_mail("tasospapt@yahoo.gr", "update triggered", "x", [
	//	'Content-Type: text/html; charset=UTF-8'
	//]);

	while ($loop->have_posts()) {
		// loop all deals
		$loop->the_post();
		//echo "current deal: " . get_the_title() . "\n";
		// Get deal expiration date in unix timestamp
		$expires_at = get_field("offer_expiration_date", get_the_ID());
		if (!$expires_at) {
			continue;
		}
		$expires_at = DateTime::createFromFormat('!d/m/Y', $expires_at);
		if (!$expires_at) {
			continue;
		}
		$expires_at = $expires_at->format('U');



		// initial check, do not load clients if not expiring soon
		// TODO SHT
		if (1556755200 - 1554824815 < (60 * 60 * 24) * 7 && $expires_at > 0) {

		//wp_mail("tasospapt@yahoo.gr", "sending mails for deal ", get_the_title() . " at " . date("U"), [
		//	'Content-Type: text/html; charset=UTF-8'
		//]);


		//if (true) {
			// load clients
			$clients = get_field("users_who_downloaded", get_the_ID());
			// initialize should update variable (do not update if nothing changed)
			$should_update = false;
			// loop clients
			//echo json_encode($clients, JSON_PRETTY_PRINT);
			$current = 0;
			foreach ($clients as $row) {
				//var_dump($row);
				$client = $row['user_download'];
				$client_name = $client['user_firstname'] . " " . $client['user_lastname'];
				//var_dump($client_name);
				$client_email = $client['user_email'];
				$notified_2 = $row['notified_2'];
				$notified_7 = $row['notified_7'];
				$should_notify_for_2 = false;
				$should_notify_for_7 = false;
				$owner = get_field("deal_owner", get_the_ID());
				$business = get_field("business_of_owner", "user_" . $owner['ID']);
				// if the deal expires in less than 2 days
				//echo "    checking user $client_email -- expires at $expires_at\n";
				if ($expires_at - date("U") < (60 * 60 * 24) * 2) {
					// ... and the user is not notified, send alert
					if (!$notified_2) {
						//echo "update for 2";
						// should notify the user
						$should_notify_for_2 = true;
						// update both 2 and 7 because since we alerted him for 2 the alert for 7 is invalid
						//$row['notified_2'] = true;
						//$row['notified_7'] = true;
						$clients[$current]['notified_2'] = true;
						$clients[$current]['notified_7'] = true;
						// should update
						$should_update = true;
					}
				}
				// else if the deal expires in less than 7 days
				else if ($expires_at - date("U") < (60 * 60 * 24) * 7) {
					// ... and the user is not notified for 7 days, send alert. he should be notified for 2 as well
					if (!$notified_7) {
						//echo "update for 7";
						// should notify the user
						$should_notify_for_7 = true;
						// update notified for 7 boolean
						//$row['notified_7'] = true;
						$clients[$current]['notified_7'] = true;
						// should update
						$should_update = true;
					}
				}
				// format the email for each type
				// TODO SHT
				if ($should_notify_for_2) {
				// if (true) {
					// $client_email
					$title = "Η δωροεπιταγή σου 🔖 σε περιμένει αλλά όχι για πολύ ⏳";
					$message = "Γεια σου $client_name,<br><br>";
					$message .= "Αν δεν έχεις εξαργυρώσει ακόμα τη δωροεπιταγή σου \"" . get_the_title() . "\", δεν έχεις παρά 2 μέρες ακόμα.<br><br>";
					// TODO SHT
					if ($business) {
						$message .= "Η επιχείρηση $business σε περιμένει<br><br>";
					}
					else {
						$message .= "Σε περιμένουμε<br><br>";
					}
					$message .= "Φιλικά,<br><br>";
					$message .= "<img src='cid:logo' /><br>";
					$message .= "sindetiras.gr<br>";
				}
				else if ($should_notify_for_7) {
				//else if (true) {
					$title = "Καλύτερα να βιαστείς. Η δωροεπιταγή σου 🔖 λήγει σε 7 ημέρες 😱";
					$message = "Γεια σου $client_name,<br><br>";
					$message .= "Θέλω να σου θυμίσω ότι έχεις ακόμα 7 ημέρες για να εξαργυρώσεις τη δωροεπιταγή σου \"" . get_the_title() . "\".<br><br>";
					// TODO SHT
					if ($business) {
						$message .= "Η επιχείρηση $business σε περιμένει αλλά όχι για πολύ ακόμα 🙂<br><br>";
					}
					else {
						$message .= "Σε περιμένουμε αλλά όχι για πολύ ακόμα 🙂<br><br>";
					}
					$message .= "Φιλικά,<br><br>";

					$message .= "<img src='cid:logo' /><br>";
					$message .= "sindetiras.gr<br>";
				}

				if ($should_notify_for_2 || $should_notify_for_7) {
					//echo "sending to $client_email";
					$phpmailerInitAction = function(&$phpmailer) {
						$phpmailer->AddEmbeddedImage(get_theme_file_path("/images/logo-wide-red.png"), 'logo');
					};
					add_action('phpmailer_init', $phpmailerInitAction);
					// TODO SHT
					//wp_mail($client_email, $title, $message, [
					//    'Content-Type: text/html; charset=UTF-8'
					//]);

					wp_mail("tasospapt@yahoo.gr", $title . " for $client_email", $message, [
					    'Content-Type: text/html; charset=UTF-8'
					]);
					remove_action('phpmailer_init', $phpmailerInitAction);
				}
				$current++;
			}
			//echo json_encode($clients, JSON_PRETTY_PRINT);
			if ($should_update) {
				//echo "updated";
				// update the field for current deal
				update_field("users_who_downloaded", $clients, get_the_ID());
			}
		}
	}
	wp_reset_query();
}
