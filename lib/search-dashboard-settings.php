<?php

    class RAWBSearchDashoardSettings {

        private $options;
        private $search_dashboard;

        public function __construct($search_dashboard) {
            $this->search_dashboard = $search_dashboard;

            add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
            add_action( 'admin_init', array( $this, 'page_init' ) );
        }

		public function get_indexes() {
			$value = get_option( 'rawb_search_dashboard_indexes' );
            $list = explode("\n", $value);
			return $list;
		}

        public function add_plugin_page() {
            add_submenu_page('rawb-search-dashboard', 'Settings', 'Settings', 'manage_options', 'rawb-search-dashboard-settings', array( &$this, 'create_admin_page'));
        }

        public function create_admin_page() {

            $this->options = get_option( 'my_option_name' );
?>
        <div class="wrap">
            <h1>RAWB Search Dashboard Settings</h1>

            <form method="post" action="options.php">
<?php
            // This prints out all hidden setting fields
            settings_fields( 'rawb_search_dashboard_group' );
            do_settings_sections( 'search-dashboard-admin-settings' );
            submit_button();
?>
            </form>
        </div>
<?php
        }

        /**
         * Register and add settings
         */
        public function page_init() {

			if (!get_option('rawb_search_dashboard_indexes')) {
				add_option('rawb_search_dashboard_indexes');
            }

            register_setting( 'rawb_search_dashboard_group', 'rawb_search_dashboard_indexes', array( $this, 'sanitize' ) );

            add_settings_section( 'settings_indexes', 'Hosts to replace', array( $this, 'print_indexes_info' ), 'search-dashboard-admin-settings' );  
			add_settings_field( 'rawb_search_dashboard-settings', 'List of hosts', array( $this, 'indexes_callback'), 'search-dashboard-admin-settings', 'settings_indexes' );      

		}

		public function sanitize( $input ) {
			$new_input = array();
			if( isset( $input['id_number'] ) )
				$new_input['id_number'] = absint( $input['id_number'] );

			if( isset( $input['title'] ) )
				$new_input['title'] = sanitize_text_field( $input['title'] );

			return $input;
        }

		public function print_indexes_info() {
            print 'List all indexes available';
        }

		public function indexes_callback() {
			$value = get_option( 'rawb_search_dashboard_indexes' );
			echo "<div><textarea style=\"width: 50%; height: 200px;\" name=\"rawb_search_dashboard_indexes\" />$value</textarea></div>";
		}

	}

