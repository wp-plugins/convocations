=== Convocations ===
Contributors: breizh_seo
Donate link: http://www.breizh-seo.com/
Tags: convocation, sport
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Gérez les convocations de vos joueurs à une rencontre sportive

== Description ==

Convocations est un plugin pour les clubs sportifs souhaitant gérer et afficher sur leur site la liste des joueurs convoqués à un match.
Fonctionnalités de Convocations :
 - Créer et gérer des équipes
 - Créer et gérer des joueurs
 - Gérer les matchs en configurant plusieurs paramètres :
	- Equipe adverse
	- Date de la rencontre
	- Type de la rencontre : Domicile ou Extérieur
	- Lieu du RDV
	- Heure du RDV
	- Heure du match
	- Liste des joueurs convoqués pour le match

== Installation ==

1. Extract `convocations.zip` and upload the folder `convocations` to the `/wp-content/plugins/` directory;
2. Activate the plugin through the `Plugins` menu in WordPress
3. Place this `<?php if (function_exists('displayConvocations')) { displayConvocations(); } ?>` in your templates

== Frequently Asked Questions ==

= Comment créer une nouvelle convocation =

Les convocations sont liées aux équipes. Il est donc nécessaire de créer une équipe en premier lieu. Une fois l'équipe créée, retournez sur le panneau d'administration `Convocations`. Une nouvelle convocation a été créée.

== Screenshots ==

1. Gestion des convocations

== Changelog ==

= 0.1 =
* Première version du plugin