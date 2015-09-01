<?php
/*
Plugin Name: New Post Notification
Plugin URI:  https://codex.wordpress.org/Writing_a_Plugin
Description: Envía un email a la lista de correos deseada cuando se publica un post nuevo.
Version:     1.0
Author:      Jose Lazo
Author URI:  http://joselazo.es
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: npn

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/


function send_mails_on_publish( $new_status, $old_status, $post ) {
    if ( 'publish' !== $new_status or 'publish' === $old_status
        or 'my_custom_type' !== get_post_type( $post ) )
        return;

    $subscribers = get_users( array ( 'role' => 'subscriber' ) );
    $emails      = array ();

    foreach ( $subscribers as $subscriber )
        $emails[] = $subscriber->user_email;

    $body = sprintf( 'Tenemos una nueva publicación para ti.

        Mira <%s>',
        get_permalink( $post )
    );

    wp_mail( $emails, '¡Nueva publicación en ' . bloginfo( 'name' ) . '!', $body );
}
add_action( 'transition_post_status', 'send_mails_on_publish', 10, 3 );