<?php

	/**
	 * @package UploadAbsPath
	 * @author Puggan
	 * @version 1.0.0
	 */

	/*
	Plugin Name: UploadAbsPath
	Description: Makes Wordpress able to accept absolute paths as uploads dirs
	Version: 1.0.1
	Author: Puggan
	Author URI: http://blog.puggan.se
	*/

	add_filter(
		'upload_dir',
		function ($param) {
			if(defined('UPLOADS'))
			{
				if(UPLOADS[0] === '/')
				{
					$param['path'] = str_replace(ABSPATH . UPLOADS, UPLOADS, $param['path']);
					$param['basedir'] = str_replace(ABSPATH . UPLOADS, UPLOADS, $param['basedir']);
				}

				if(defined('UPLOADS_URL'))
				{
					$param['url'] = str_replace(UPLOADS, UPLOADS_URL, $param['url']);
					$param['baseurl'] = str_replace(UPLOADS, UPLOADS_URL, $param['baseurl']);

					if(UPLOADS_URL[0] === '/')
					{
						$siteurl = trailingslashit(get_option('siteurl'));
						$site_url_parts = parse_url($siteurl);
						$site_url_root = "{$site_url_parts['scheme']}://{$site_url_parts['host']}" . (empty($site_url_parts['port']) ? '' : ":{$site_url_parts['port']}");

						$param['url'] = str_replace($siteurl, $site_url_root, $param['url']);
						$param['baseurl'] = str_replace($siteurl, $site_url_root, $param['baseurl']);
					}
				}
			}

			return $param;
		}
	);

