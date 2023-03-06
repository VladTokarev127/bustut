<?php

	add_action('wp_enqueue_scripts', 'autobus_media');

	add_action('after_setup_theme', 'autobus_after_setup');

	/**
	 * Enqueues script with WordPress and adds version number that is a timestamp of the file modified date.
	 * 
	 * @param string      $handle    Name of the script. Should be unique.
	 * @param string|bool $src       Path to the script from the theme directory of WordPress. Example: '/js/myscript.js'.
	 * @param array       $deps      Optional. An array of registered script handles this script depends on. Default empty array.
	 * @param bool        $in_footer Optional. Whether to enqueue the script before </body> instead of in the <head>.
	 *                               Default 'false'.
	 */
	function enqueue_versioned_script( $handle, $src = false, $deps = array(), $in_footer = false ) {
		wp_enqueue_script( $handle, get_stylesheet_directory_uri() . $src, $deps, filemtime( get_stylesheet_directory() . $src ), $in_footer );
	}
	
	/**
	 * Enqueues stylesheet with WordPress and adds version number that is a timestamp of the file modified date.
	 *
	 * @param string      $handle Name of the stylesheet. Should be unique.
	 * @param string|bool $src    Path to the stylesheet from the theme directory of WordPress. Example: '/css/mystyle.css'.
	 * @param array       $deps   Optional. An array of registered stylesheet handles this stylesheet depends on. Default empty array.
	 * @param string      $media  Optional. The media for which this stylesheet has been defined.
	 *                            Default 'all'. Accepts media types like 'all', 'print' and 'screen', or media queries like
	 *                            '(orientation: portrait)' and '(max-width: 640px)'.
	 */
	function enqueue_versioned_style( $handle, $src = false, $deps = array(), $media = 'all' ) {
		wp_enqueue_style( $handle, get_stylesheet_directory_uri() . $src, $deps = array(), filemtime( get_stylesheet_directory() . $src ), $media );
	}

	function autobus_media() {
		enqueue_versioned_style('test-main', '/style.css');
		enqueue_versioned_script('test-main', '/js/main.min.js', array( 'jquery'), false);
	}

	function autobus_after_setup() {
		register_nav_menu('menu', 'Menu');

		add_theme_support('post-thumbnails');
	}

	add_action( 'admin_head', 'cron_activation' );
	function cron_activation() {
		if( ! wp_next_scheduled( 'set_stations_list_action' ) ) {
			// установить часовой пояс PHP в UTC
			default_timezone_set( 'UTC' );
			// определить временную метку для запуска в первый раз.
			$timestamp = strtotime( '2023-03-06 19:00:00' ); 
			wp_schedule_event( $timestamp, 'daily', 'set_stations_list_action');
		}
	}

	function get_stations() {
		global $wpdb;
		$wpdb->query("TRUNCATE TABLE `wp_stations_list`");
		$curl = curl_init();
		$config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl,CURLOPT_URL, 'https://bus.tutu.ru/bus/v1/schedule/bus_terminal/?bus_stop_id=1177120&offset=0&limit=100');
		curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
		curl_setopt($curl,CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_REFERER, 'https://ivanovo-avtovokzal.ru/');
		curl_setopt($curl, CURLOPT_USERAGENT, $config['useragent']);
		curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'GET');
		$out = curl_exec($curl);
		$json = json_decode($out)->{'data'};
		$dataStations = [];
		$stationsIds = [];
		$daysToHtml = [
			0   => '<span>неизвестно</span>',
			127 => '<span>ежедневно</span>',
			64  => '<span class="is-holiday">вс</span>',
			16  => '<span>пт</span>',
			1   => '<span>пн</span>',
			80  => '<span>пт</span>, <span class="is-holiday">вс</span>',
			68  => '<span>ср</span>, <span class="is-holiday">вс</span>',
			33  => '<span>пн</span>, <span class="is-holiday">сб</span>',
			112 => '<span>пт</span>, <span class="is-holiday">сб</span>, <span class="is-holiday">вс</span>',
			63  => '<span>пн</span>, <span>вт</span>, <span>ср</span>, <span>чт</span>, <span>пт</span>, <span class="is-holiday">сб</span>, <span class="is-holiday">вс</span>',
			18  => '<span>вт</span>, <span>пт</span>',
			48  => '<span>пт</span>, <span class="is-holiday">сб</span>',
			31  => '<span>По будням</span>',
			32  => '<span class="is-holiday">сб</span>',
			65  => '<span>пн</span>, <span class="is-holiday">вс</span>'
		];
		foreach ($json as $itemKey => $item) {
			array_push($stationsIds, $item->geoPointId);
			array_push($dataStations, array('geoPointId' => $item->geoPointId, 'schedules' => [], 'stationName' => ''));
			foreach($item->schedules as $key => $schedule) {
				$activeDays = $schedule->activeDaysData->params->activeDays ? $schedule->activeDaysData->params->activeDays : $schedule->activeDays;
				$daysHtml = $daysToHtml[$activeDays];
				array_push($dataStations[$itemKey]['schedules'], array('time' => $schedule->time, 'days' => $schedule->activeDaysData->mode, 'transit' => $schedule->isTransit, 'activeDays' => $activeDays, 'daysHtml' => $daysHtml));
			}
			$geoPointId = $dataStations[$itemKey]['geoPointId'];
			$schedules = json_encode($dataStations[$itemKey]['schedules']);
			$wpdb->insert(
				$wpdb->prefix . 'stations_list',
				array(
					'ID' => $itemKey,
					'geoPointId' => $geoPointId,
					'schedules' => $schedules,
					'stationName' => '',
				),
				array(
					'%d',
					'%d',
					'%s',
					'%s'
				)
			);
		}
		$stationsIds = array_unique($stationsIds);
		foreach($stationsIds as $key => $id) {
			$curl = curl_init();
			$config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
			curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl,CURLOPT_URL, 'https://api-bus.tutu.ru/v1/search/?departureId=1444796&arrivalId='. $id .'&departureDate=09.02.2023&seatCount=1');
			curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
			curl_setopt($curl,CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_REFERER, 'https://ivanovo-avtovokzal.ru/');
			curl_setopt($curl, CURLOPT_USERAGENT, $config['useragent']);
			curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'GET');
			$stationOut = curl_exec($curl);
			$stationJson = json_decode($stationOut);
			$name = $stationJson->data->references->geoPoints[1]->name;
			foreach($dataStations as $statKey => $item) {
				if ($item['geoPointId'] === $id) {
					$dataStations[$statKey]['stationName'] = $name;
					$wpdb->update(
						$wpdb->prefix . 'stations_list',
						array(
							'stationName' => $name,
						),
						array(
							'ID' => $statKey
						)
					);
				}
			}
		}
	}

	// get_stations();

	add_action( 'set_stations_list_action', 'set_stations_list' );
	function set_stations_list(){
		get_stations();
	}