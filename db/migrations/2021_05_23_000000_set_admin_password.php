<?php

namespace Engelsystem\Migrations;

use Engelsystem\Config\Config;
use Engelsystem\Database\Migration\Migration;
use Engelsystem\Helpers\Authenticator;
use Illuminate\Database\Schema\Builder as SchemaBuilder;

class SetAdminPassword extends Migration
{
    use Reference;

    /** @var Authenticator */
    protected Authenticator $auth;

    /** @var Config */
    protected Config $config;

    /**
     * @param SchemaBuilder $schemaBuilder
     * @param Authenticator $auth
     * @param Config        $config
     */
    public function __construct(SchemaBuilder $schemaBuilder, Authenticator $auth, Config $config)
    {
        parent::__construct($schemaBuilder);

        $this->auth = $auth;
        $this->config = $config;
    }

    /**
     * Run the migration
     */
    public function up()
    {
        $admin = $this->auth->authenticate('admin', 'asdfasdf');
        $setupPassword = $this->config->get('setup_admin_password');
        if (!$admin || !$setupPassword) {
            return;
        }

        $this->auth->setPassword($admin, $setupPassword);
    }
}
