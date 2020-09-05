<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/gaming/v1/game_server_configs.proto

namespace Google\Cloud\Gaming\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for GameServerConfigsService.DeleteGameServerConfig.
 *
 * Generated from protobuf message <code>google.cloud.gaming.v1.DeleteGameServerConfigRequest</code>
 */
class DeleteGameServerConfigRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The name of the game server config to delete. Uses the form:
     * `projects/{project}/locations/{location}/gameServerDeployments/{deployment}/configs/{config}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The name of the game server config to delete. Uses the form:
     *           `projects/{project}/locations/{location}/gameServerDeployments/{deployment}/configs/{config}`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Gaming\V1\GameServerConfigs::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The name of the game server config to delete. Uses the form:
     * `projects/{project}/locations/{location}/gameServerDeployments/{deployment}/configs/{config}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The name of the game server config to delete. Uses the form:
     * `projects/{project}/locations/{location}/gameServerDeployments/{deployment}/configs/{config}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

}

