<?php

if ( ! class_exists( 'RAWBSearchDashoard' ) ) {

    require_once 'search-dashboard-settings.php';

    class RAWBSearchDashoard {

        static $version;
        protected $dir;
        protected $plugin_dir;
        protected $api_token;
        protected $init = false;
        protected $short_init = false;
        static $singleton;

        private $pre_term_url;
        private $appstate;
        private $settings_page;
        private $indexes;
        private $graphql_url = 'http://search/graphql';

        static function getInstance() {
            if (is_null(RAWBSearchDashoard::$singleton)) {
                throw new Exception('RAWBSearchDashoard not instanciated');
            }
            return RAWBSearchDashoard::$singleton;
        }

        function __construct($dir, $version, $api_token, $short_init = false) {

            RAWBSearchDashoard::$version = $version;

            $this->dir = $dir;
            $this->appstate = new stdClass();
            $this->api_token = $api_token;
            $this->short_init = $short_init;
            $this->plugin_dir = basename( $this->dir );
            $this->js_script = plugins_url( '../js-dist/dls-entry-' . DraftLiveSync::$version . '.js', __FILE__ );

            $this->init();

            RAWBSearchDashoard::$singleton = $this;

            $this->settings_page = new RAWBSearchDashoardSettings($this);

            $this->indexes = $this->settings_page->get_indexes();

            if (!isset($this->indexes) || sizeof($this->indexes) == 0 ) {
                add_action( 'admin_notices', array(&$this, 'show_missing_indexes'));
            }

            $this->prepare_appstate();

        }

        public function init() {

            // Disable double initialization.
            if ( $this->init ) {
                return $this;
            }

            $this->init = true;

            if (!$this->short_init) {
                add_filter( 'admin_menu', array( &$this, 'add_admin_pages'), 10, 2 );
                add_action( 'admin_enqueue_scripts', array(&$this, 'enqueue_admin_scripts' ));
                add_action( 'wp_ajax_rawb-search-dashboard-reindex', array( &$this, 'reindex') );
            }

            $indexes = $this->get_indexes();

            // print_r($indexes);

            return $this;

        }

        function prepare_appstate() {
            $indexes = $this->get_indexes();
            $this->appstate->indexes = $indexes['data']['indexes'];
        }


        function enqueue_admin_scripts($hook) {
            // wp_enqueue_style( 'dls-css', plugins_url( '../css/style.css', __FILE__ ) );
            if ( 'toplevel_page_rawb-search-dashboard' == $hook ) {
                wp_enqueue_script( 'rawb-search-dashbpard-script', plugins_url( '../js/build/rawb-search-dashboard-boot.js', __FILE__ ) );
                // wp_enqueue_style( 'dls-css', plugins_url( '../css/style.css', __FILE__ ) );
                return;
            }
        }

        function render_admin_page() {
            print '<script type="application/json" id="rawb-search-dashboard-appstate">' . json_encode($this->appstate) . '</script>';
            print '<div id="rawb-search-dashboard-page-root"></div>';
        }

        function reindex() {
            $reponse = array();
            if (!empty($_POST['name'])) {
                $name = $_POST['name'];
                $query = <<<'GRAPHQL'
                    mutation Reindex($name: String) {
                        reindex (index: $name)  {
                            success
                        }
                    }
GRAPHQL;
                $result = $this->graphql_query($query, [ 'name' => $name ] );
                $response = $result['data']['reindex'];
            }
            header( "Content-Type: application/json" );
            echo json_encode($response);
            exit();
        }


        function get_indexes() {

            $query = <<<'GRAPHQL'
                query {
                    indexes  {
                        name
                    }
                }
GRAPHQL;

            return $this->graphql_query($query);

        }


        function graphql_query(string $query, array $variables = [], ?string $token = null): array {
            $headers = ['Content-Type: application/json', 'User-Agent: Dunglass minimal GraphQL client'];
            if (null !== $token) {
                $headers[] = "Authorization: bearer $token";
            }

            if (false === $data = @file_get_contents($this->graphql_url, false, stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => $headers,
                    'content' => json_encode(['query' => $query, 'variables' => $variables]),
                ]
            ]))) {
                $error = error_get_last();
                error_log('ERROR: ' . $error['message'] . ', ' . $error['type'] );
                return json_decode( '{}', true);
                //throw new \ErrorException($error['message'], $error['type']);
            }

            return json_decode($data, true);
        }


        function add_admin_pages() {
            add_menu_page( 'RAWB Search', 'RAWB Search', 'manage_options', 'rawb-search-dashboard', array( &$this, 'render_admin_page'));
            // add_submenu_page('rawb-search-dashboard', 'Sync check', 'Sync check', 'manage_options', 'rawb-search-dashboard-check-sync', array( &$this, 'render_admin_page_check_sync'));
        }


    }

}
