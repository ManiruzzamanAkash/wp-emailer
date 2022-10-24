<?php

namespace Akash\WpEmailer\Tests;

/**
 * Assets class test.
 *
 * @since WP_EMAILER_SINCE
 */
class AssetTest extends \WP_UnitTestCase {

    /**
     * Asset class instance.
     *
     * @var \Akash\WpEmailer\Asset()
     */
    public $asset;

    /**
     * Setup test environment.
     */
    protected function setUp() : void {
        $this->asset = new \Akash\WpEmailer\Asset();
    }

    public function test_get_router_base_url() {
        $admin_page_url1 = 'http://host.com/folder/wp-admin/admin.php?page=wp-emailer';
        $admin_page_url2 = 'http://host.com/wp-admin/admin.php?page=wp-emailer';

        $this->assertEquals(
            $this->asset->get_router_base_url( $admin_page_url1 ),
            'folder/wp-admin/admin.php?page=wp-emailer#',
        );

        $this->assertEquals(
            $this->asset->get_router_base_url( $admin_page_url2 ),
            'wp-admin/admin.php?page=wp-emailer#'
        );
    }
}
