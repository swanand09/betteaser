<?php
/*
Plugin Name: Simple Session Support
Plugin URI: http://devondev.com/simple-session-support/
Description: Adds PHP session support for developers, destroys session at log off
Version: 1.01
Author: Peter Wooster
Author URI: http://www.devondev.com/
*/

/*  Copyright (C) 2011 Devondev Inc.  (http://devondev.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * add actions at initialization to start the session
 * and at logout and login to end the session
 */
add_action('init', 'simpleSessionStart', 1);
add_action('wp_logout', 'simpleSessionDestroy');
add_action('wp_login', 'simpleSessionDestroy');

/**
 * start the session, after this call the PHP $_SESSION super global is available
 */
function simpleSessionStart() {
    if(!session_id())session_start();
}

/**
 * destroy the session, this removes any data saved in the session over logout-login
 */              
function simpleSessionDestroy() {
    session_destroy ();
}

/**
 * get a value from the session array
 * @param type $key the key in the array
 * @param type $default the value to use if the key is not present. empty string if not present
 * @return type the value found or the default if not found
 */
function simpleSessionGet($key, $default='') {
    if(isset($_SESSION[$key])) {
        return $_SESSION[$key];
    } else {
        return $default;
    }
}

/**
 * set a value in the session array
 * @param type $key the key in the array
 * @param type $value the value to set
 */
function simpleSessionSet($key, $value) {
    $_SESSION[$key] = $value;
}


/* =========================================================================
 * end of program, php close tag intentionally omitted
 * ========================================================================= */
