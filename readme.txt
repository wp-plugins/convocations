=== Convocations ===
Contributors: breizh_seo
Donate link: http://www.breizh-seo.com/
Tags: convocation, sport
Requires at least: 3.0
Tested up to: 4.1.1
Stable tag: 0.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Manage the notifications of your teams and of your players to matches.

== Description ==

Convocations plugin is for sports associations such as football clubs, handball clubs, basket-ball clubs, ... which allows you to manage the notifications of your teams and of your players to matches.

= Features =
* Create and manage teams
* Create and manage players
* Manage games by configuring several parameters (Team opponent, Meeting Date, Type of meeting: Home or Away, Place of appointment, Time of appointment, Match Schedule, List of players convoked for the match)

== Installation ==

1. Extract `convocations.zip` and upload `convocations` to the `/wp-content/plugins/` folder
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place this shortcode `[convocations]` into a page.

== Frequently Asked Questions ==

= How to create a new notification =

The notifications are related teams. It is therefore necessary to create a team first. Once the team is created, go back to the admin panel `Convocations`. A new notification has been created.

== Screenshots ==

1. All convocations
2. Manage convocation

== Changelog ==

= 0.1 =
* First version of the plugin

= 0.2 =
* Fix some warnings and notices

= 0.3 =
* Add shortcode `[convocations]` to display in front-end more easily
* Add a custom icon for the plugin menu
* Insert the notion of class in the plugin (OOP) and the design patterns Singleton and MVC

= 0.4 =
* Fix a lot of bug in admin and in front-end

= 0.4 =
* Fix the front-end display in IE9

== Upgrade Notice ==

= 0.3 =
Using shortocode to display in front-end !

= 0.4 =
A lot of bug are fixed !

= 0.5 =
* Fix function prepare warning

= 0.6 =
* Major update :  Overhaul of the plugin structure with POO
* Add languages support
* Fix warning for wpdb::prepare
* Add timepicker on the edition of a convocation
