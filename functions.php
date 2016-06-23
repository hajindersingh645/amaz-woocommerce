/**
 * Add the field to the checkout
 */
add_action( 'woocommerce_before_checkout_form', 'woo_amazon_custom' );

function woo_amazon_custom( $checkout ) {
	if( is_user_logged_in() ) :
		global $wpdb;

		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		// select saved address from the database in respect to this particular user
		$my_addresses = $wpdb->get_results( "Select * from wp_neuro_amazon where user_id = 1" );
		
		if(  null !== $my_addresses ){
			$_html = "<ul class='geo_di'>";
			$count = 0;
			foreach ( $my_addresses as $address ) {
				$_html .= "<li id='".$user_id."_$count'>";
				$_html .= "<h2 class='name'><span class='v_1'>". $address->first_name ."</span>&nbsp;<span class='v_2'>". $address->last_name. "</span></h2>";
				$_html .= "<div class='address'>";
				$_html .= "<span class='company'>". $address->company_name ."</span><br/>";
				$_html .= "<span class='v_1'>". $address->address_1 ."</span>";
				$_html .= "&nbsp;<span class='v_2'>". $address->address_2 ."</span>";
				$_html .= "&nbsp;<span class='city'>".$address->town_city."</span>";
				$_html .= "&nbsp;<span class='state'>".$address->state."</span>";
				$_html .= ",&nbsp;<span class='zipcode'>".$address->zip_code."</span>";
				$_html .= "<br /><span class='country'>".$address->country."</span>";
				$_html .= "</div>";
				$_html .= "<div>";
				$_html .= "<span class='email'>".$address->email."</span><br/>";
				$_html .= "<span class='phone'>".$address->phone."</span>";
				$_html .= "</div>";
				$_html .= "<div class='action'>";
				$_html .= "<button class='use_this button alt'>Use this address</button>";
				$_html .= "</div>";
				$_html .= "</li>";

				$count++;
			}

			$_html .= "</ul>";

			echo $_html;

			$script_element = '
				<script type="text/javascript">
					jQuery(document).ready(function($){
						$(".use_this").on("click", function(event){
							// get the list item id
							var parent_id = $(this).closest("li").attr("id");
							var label = "billing_";
							$( "[name="+label+"first_name]" ).val( $("#"+parent_id).find(".name .v_1").text() );
							$( "[name="+label+"last_name]" ).val( $("#"+parent_id).find(".name .v_2").text() );
							$( "[name="+label+"company]" ).val( $("#"+parent_id).find(".company").text() );
							$( "[name="+label+"email]" ).val( $("#"+parent_id).find(".email").text() );
							$( "[name="+label+"phone]" ).val( $("#"+parent_id).find(".phone").text() );
							$( "[name="+label+"address_1]" ).val( $("#"+parent_id).find(".address .v_1").text() );
							$( "[name="+label+"address_2]" ).val( $("#"+parent_id).find(".address .v_2").text() );
							$( "[name="+label+"city]" ).val( $("#"+parent_id).find(".city").text() );
							$( "[name="+label+"postcode]" ).val( $("#"+parent_id).find(".name .v_1").text() );
							$( "#select2-chosen-1" ).text( $("#"+parent_id).find(".country").text() );
							$( "#select2-chosen-2" ).text( $("#"+parent_id).find(".state").text() );
						});
					});
				</script>
			';

			echo $script_element;
		}else{
			// echo "No Data Found";
		}

    	
	endif;
}

add_action( 'woocommerce_checkout_order_processed', 'action_woocommerce_before_checkout_process', 1, 1 );
function action_woocommerce_before_checkout_process(){
	if ( is_user_logged_in() ):
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		global $wpdb;
		$wpdb->insert(
			'wp_neuro_amazon',
			array(
				'first_name' => $_POST['billing_first_name'],
				'last_name'		=> $_POST['billing_last_name'],
				'company_name'		=> $_POST['billing_company'],
				'email'				=> $_POST['billing_email'],
				'phone'				=> $_POST['billing_phone'],
				'country'				=> $_POST['billing_country'],
				'address_1'				=> $_POST['billing_address_1'],
				'address_2'				=> $_POST['billing_address_2'],
				'town_city'				=> $_POST['billing_city'],
				'state'				=> $_POST['billing_state'],
				'zip_code'				=> $_POST['billing_postcode'],
				'user_id'				=> $user_id,
			),
			array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
			)
		);
	endif;
}
