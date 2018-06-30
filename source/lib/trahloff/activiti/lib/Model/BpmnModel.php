<?php
/**
 * BpmnModel
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * sWIm Activiti REST API
 *
 * here be dragons
 *
 * OpenAPI spec version: v0.2.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Model;

use \ArrayAccess;
use \Swagger\Client\ObjectSerializer;

/**
 * BpmnModel Class Doc Comment
 *
 * @category Class
 * @package     Swagger\Client
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class BpmnModel implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'BpmnModel';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'definitions_attributes' => 'map[string,\Swagger\Client\Model\ExtensionAttribute[]]',
        'processes' => '\Swagger\Client\Model\Process[]',
        'location_map' => 'map[string,\Swagger\Client\Model\GraphicInfo]',
        'label_location_map' => 'map[string,\Swagger\Client\Model\GraphicInfo]',
        'flow_location_map' => 'map[string,\Swagger\Client\Model\GraphicInfo[]]',
        'signals' => '\Swagger\Client\Model\Signal[]',
        'pools' => '\Swagger\Client\Model\Pool[]',
        'imports' => '\Swagger\Client\Model\Import[]',
        'interfaces' => '\Swagger\Client\Model\ModelInterface[]',
        'global_artifacts' => '\Swagger\Client\Model\Artifact[]',
        'resources' => '\Swagger\Client\Model\Resource[]',
        'target_namespace' => 'string',
        'source_system_id' => 'string',
        'user_task_form_types' => 'string[]',
        'start_event_form_types' => 'string[]',
        'errors' => 'map[string,string]',
        'messages' => '\Swagger\Client\Model\Message[]',
        'item_definitions' => 'map[string,\Swagger\Client\Model\ItemDefinition]',
        'main_process' => '\Swagger\Client\Model\Process',
        'message_flows' => 'map[string,\Swagger\Client\Model\MessageFlow]',
        'data_stores' => 'map[string,\Swagger\Client\Model\DataStore]',
        'namespaces' => 'map[string,string]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'definitions_attributes' => null,
        'processes' => null,
        'location_map' => null,
        'label_location_map' => null,
        'flow_location_map' => null,
        'signals' => null,
        'pools' => null,
        'imports' => null,
        'interfaces' => null,
        'global_artifacts' => null,
        'resources' => null,
        'target_namespace' => null,
        'source_system_id' => null,
        'user_task_form_types' => null,
        'start_event_form_types' => null,
        'errors' => null,
        'messages' => null,
        'item_definitions' => null,
        'main_process' => null,
        'message_flows' => null,
        'data_stores' => null,
        'namespaces' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'definitions_attributes' => 'definitionsAttributes',
        'processes' => 'processes',
        'location_map' => 'locationMap',
        'label_location_map' => 'labelLocationMap',
        'flow_location_map' => 'flowLocationMap',
        'signals' => 'signals',
        'pools' => 'pools',
        'imports' => 'imports',
        'interfaces' => 'interfaces',
        'global_artifacts' => 'globalArtifacts',
        'resources' => 'resources',
        'target_namespace' => 'targetNamespace',
        'source_system_id' => 'sourceSystemId',
        'user_task_form_types' => 'userTaskFormTypes',
        'start_event_form_types' => 'startEventFormTypes',
        'errors' => 'errors',
        'messages' => 'messages',
        'item_definitions' => 'itemDefinitions',
        'main_process' => 'mainProcess',
        'message_flows' => 'messageFlows',
        'data_stores' => 'dataStores',
        'namespaces' => 'namespaces'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'definitions_attributes' => 'setDefinitionsAttributes',
        'processes' => 'setProcesses',
        'location_map' => 'setLocationMap',
        'label_location_map' => 'setLabelLocationMap',
        'flow_location_map' => 'setFlowLocationMap',
        'signals' => 'setSignals',
        'pools' => 'setPools',
        'imports' => 'setImports',
        'interfaces' => 'setInterfaces',
        'global_artifacts' => 'setGlobalArtifacts',
        'resources' => 'setResources',
        'target_namespace' => 'setTargetNamespace',
        'source_system_id' => 'setSourceSystemId',
        'user_task_form_types' => 'setUserTaskFormTypes',
        'start_event_form_types' => 'setStartEventFormTypes',
        'errors' => 'setErrors',
        'messages' => 'setMessages',
        'item_definitions' => 'setItemDefinitions',
        'main_process' => 'setMainProcess',
        'message_flows' => 'setMessageFlows',
        'data_stores' => 'setDataStores',
        'namespaces' => 'setNamespaces'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'definitions_attributes' => 'getDefinitionsAttributes',
        'processes' => 'getProcesses',
        'location_map' => 'getLocationMap',
        'label_location_map' => 'getLabelLocationMap',
        'flow_location_map' => 'getFlowLocationMap',
        'signals' => 'getSignals',
        'pools' => 'getPools',
        'imports' => 'getImports',
        'interfaces' => 'getInterfaces',
        'global_artifacts' => 'getGlobalArtifacts',
        'resources' => 'getResources',
        'target_namespace' => 'getTargetNamespace',
        'source_system_id' => 'getSourceSystemId',
        'user_task_form_types' => 'getUserTaskFormTypes',
        'start_event_form_types' => 'getStartEventFormTypes',
        'errors' => 'getErrors',
        'messages' => 'getMessages',
        'item_definitions' => 'getItemDefinitions',
        'main_process' => 'getMainProcess',
        'message_flows' => 'getMessageFlows',
        'data_stores' => 'getDataStores',
        'namespaces' => 'getNamespaces'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['definitions_attributes'] = isset($data['definitions_attributes']) ? $data['definitions_attributes'] : null;
        $this->container['processes'] = isset($data['processes']) ? $data['processes'] : null;
        $this->container['location_map'] = isset($data['location_map']) ? $data['location_map'] : null;
        $this->container['label_location_map'] = isset($data['label_location_map']) ? $data['label_location_map'] : null;
        $this->container['flow_location_map'] = isset($data['flow_location_map']) ? $data['flow_location_map'] : null;
        $this->container['signals'] = isset($data['signals']) ? $data['signals'] : null;
        $this->container['pools'] = isset($data['pools']) ? $data['pools'] : null;
        $this->container['imports'] = isset($data['imports']) ? $data['imports'] : null;
        $this->container['interfaces'] = isset($data['interfaces']) ? $data['interfaces'] : null;
        $this->container['global_artifacts'] = isset($data['global_artifacts']) ? $data['global_artifacts'] : null;
        $this->container['resources'] = isset($data['resources']) ? $data['resources'] : null;
        $this->container['target_namespace'] = isset($data['target_namespace']) ? $data['target_namespace'] : null;
        $this->container['source_system_id'] = isset($data['source_system_id']) ? $data['source_system_id'] : null;
        $this->container['user_task_form_types'] = isset($data['user_task_form_types']) ? $data['user_task_form_types'] : null;
        $this->container['start_event_form_types'] = isset($data['start_event_form_types']) ? $data['start_event_form_types'] : null;
        $this->container['errors'] = isset($data['errors']) ? $data['errors'] : null;
        $this->container['messages'] = isset($data['messages']) ? $data['messages'] : null;
        $this->container['item_definitions'] = isset($data['item_definitions']) ? $data['item_definitions'] : null;
        $this->container['main_process'] = isset($data['main_process']) ? $data['main_process'] : null;
        $this->container['message_flows'] = isset($data['message_flows']) ? $data['message_flows'] : null;
        $this->container['data_stores'] = isset($data['data_stores']) ? $data['data_stores'] : null;
        $this->container['namespaces'] = isset($data['namespaces']) ? $data['namespaces'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        return true;
    }


    /**
     * Gets definitions_attributes
     *
     * @return map[string,\Swagger\Client\Model\ExtensionAttribute[]]
     */
    public function getDefinitionsAttributes()
    {
        return $this->container['definitions_attributes'];
    }

    /**
     * Sets definitions_attributes
     *
     * @param map[string,\Swagger\Client\Model\ExtensionAttribute[]] $definitions_attributes definitions_attributes
     *
     * @return $this
     */
    public function setDefinitionsAttributes($definitions_attributes)
    {
        $this->container['definitions_attributes'] = $definitions_attributes;

        return $this;
    }

    /**
     * Gets processes
     *
     * @return \Swagger\Client\Model\Process[]
     */
    public function getProcesses()
    {
        return $this->container['processes'];
    }

    /**
     * Sets processes
     *
     * @param \Swagger\Client\Model\Process[] $processes processes
     *
     * @return $this
     */
    public function setProcesses($processes)
    {
        $this->container['processes'] = $processes;

        return $this;
    }

    /**
     * Gets location_map
     *
     * @return map[string,\Swagger\Client\Model\GraphicInfo]
     */
    public function getLocationMap()
    {
        return $this->container['location_map'];
    }

    /**
     * Sets location_map
     *
     * @param map[string,\Swagger\Client\Model\GraphicInfo] $location_map location_map
     *
     * @return $this
     */
    public function setLocationMap($location_map)
    {
        $this->container['location_map'] = $location_map;

        return $this;
    }

    /**
     * Gets label_location_map
     *
     * @return map[string,\Swagger\Client\Model\GraphicInfo]
     */
    public function getLabelLocationMap()
    {
        return $this->container['label_location_map'];
    }

    /**
     * Sets label_location_map
     *
     * @param map[string,\Swagger\Client\Model\GraphicInfo] $label_location_map label_location_map
     *
     * @return $this
     */
    public function setLabelLocationMap($label_location_map)
    {
        $this->container['label_location_map'] = $label_location_map;

        return $this;
    }

    /**
     * Gets flow_location_map
     *
     * @return map[string,\Swagger\Client\Model\GraphicInfo[]]
     */
    public function getFlowLocationMap()
    {
        return $this->container['flow_location_map'];
    }

    /**
     * Sets flow_location_map
     *
     * @param map[string,\Swagger\Client\Model\GraphicInfo[]] $flow_location_map flow_location_map
     *
     * @return $this
     */
    public function setFlowLocationMap($flow_location_map)
    {
        $this->container['flow_location_map'] = $flow_location_map;

        return $this;
    }

    /**
     * Gets signals
     *
     * @return \Swagger\Client\Model\Signal[]
     */
    public function getSignals()
    {
        return $this->container['signals'];
    }

    /**
     * Sets signals
     *
     * @param \Swagger\Client\Model\Signal[] $signals signals
     *
     * @return $this
     */
    public function setSignals($signals)
    {
        $this->container['signals'] = $signals;

        return $this;
    }

    /**
     * Gets pools
     *
     * @return \Swagger\Client\Model\Pool[]
     */
    public function getPools()
    {
        return $this->container['pools'];
    }

    /**
     * Sets pools
     *
     * @param \Swagger\Client\Model\Pool[] $pools pools
     *
     * @return $this
     */
    public function setPools($pools)
    {
        $this->container['pools'] = $pools;

        return $this;
    }

    /**
     * Gets imports
     *
     * @return \Swagger\Client\Model\Import[]
     */
    public function getImports()
    {
        return $this->container['imports'];
    }

    /**
     * Sets imports
     *
     * @param \Swagger\Client\Model\Import[] $imports imports
     *
     * @return $this
     */
    public function setImports($imports)
    {
        $this->container['imports'] = $imports;

        return $this;
    }

    /**
     * Gets interfaces
     *
     * @return \Swagger\Client\Model\ModelInterface[]
     */
    public function getInterfaces()
    {
        return $this->container['interfaces'];
    }

    /**
     * Sets interfaces
     *
     * @param \Swagger\Client\Model\ModelInterface[] $interfaces interfaces
     *
     * @return $this
     */
    public function setInterfaces($interfaces)
    {
        $this->container['interfaces'] = $interfaces;

        return $this;
    }

    /**
     * Gets global_artifacts
     *
     * @return \Swagger\Client\Model\Artifact[]
     */
    public function getGlobalArtifacts()
    {
        return $this->container['global_artifacts'];
    }

    /**
     * Sets global_artifacts
     *
     * @param \Swagger\Client\Model\Artifact[] $global_artifacts global_artifacts
     *
     * @return $this
     */
    public function setGlobalArtifacts($global_artifacts)
    {
        $this->container['global_artifacts'] = $global_artifacts;

        return $this;
    }

    /**
     * Gets resources
     *
     * @return \Swagger\Client\Model\Resource[]
     */
    public function getResources()
    {
        return $this->container['resources'];
    }

    /**
     * Sets resources
     *
     * @param \Swagger\Client\Model\Resource[] $resources resources
     *
     * @return $this
     */
    public function setResources($resources)
    {
        $this->container['resources'] = $resources;

        return $this;
    }

    /**
     * Gets target_namespace
     *
     * @return string
     */
    public function getTargetNamespace()
    {
        return $this->container['target_namespace'];
    }

    /**
     * Sets target_namespace
     *
     * @param string $target_namespace target_namespace
     *
     * @return $this
     */
    public function setTargetNamespace($target_namespace)
    {
        $this->container['target_namespace'] = $target_namespace;

        return $this;
    }

    /**
     * Gets source_system_id
     *
     * @return string
     */
    public function getSourceSystemId()
    {
        return $this->container['source_system_id'];
    }

    /**
     * Sets source_system_id
     *
     * @param string $source_system_id source_system_id
     *
     * @return $this
     */
    public function setSourceSystemId($source_system_id)
    {
        $this->container['source_system_id'] = $source_system_id;

        return $this;
    }

    /**
     * Gets user_task_form_types
     *
     * @return string[]
     */
    public function getUserTaskFormTypes()
    {
        return $this->container['user_task_form_types'];
    }

    /**
     * Sets user_task_form_types
     *
     * @param string[] $user_task_form_types user_task_form_types
     *
     * @return $this
     */
    public function setUserTaskFormTypes($user_task_form_types)
    {
        $this->container['user_task_form_types'] = $user_task_form_types;

        return $this;
    }

    /**
     * Gets start_event_form_types
     *
     * @return string[]
     */
    public function getStartEventFormTypes()
    {
        return $this->container['start_event_form_types'];
    }

    /**
     * Sets start_event_form_types
     *
     * @param string[] $start_event_form_types start_event_form_types
     *
     * @return $this
     */
    public function setStartEventFormTypes($start_event_form_types)
    {
        $this->container['start_event_form_types'] = $start_event_form_types;

        return $this;
    }

    /**
     * Gets errors
     *
     * @return map[string,string]
     */
    public function getErrors()
    {
        return $this->container['errors'];
    }

    /**
     * Sets errors
     *
     * @param map[string,string] $errors errors
     *
     * @return $this
     */
    public function setErrors($errors)
    {
        $this->container['errors'] = $errors;

        return $this;
    }

    /**
     * Gets messages
     *
     * @return \Swagger\Client\Model\Message[]
     */
    public function getMessages()
    {
        return $this->container['messages'];
    }

    /**
     * Sets messages
     *
     * @param \Swagger\Client\Model\Message[] $messages messages
     *
     * @return $this
     */
    public function setMessages($messages)
    {
        $this->container['messages'] = $messages;

        return $this;
    }

    /**
     * Gets item_definitions
     *
     * @return map[string,\Swagger\Client\Model\ItemDefinition]
     */
    public function getItemDefinitions()
    {
        return $this->container['item_definitions'];
    }

    /**
     * Sets item_definitions
     *
     * @param map[string,\Swagger\Client\Model\ItemDefinition] $item_definitions item_definitions
     *
     * @return $this
     */
    public function setItemDefinitions($item_definitions)
    {
        $this->container['item_definitions'] = $item_definitions;

        return $this;
    }

    /**
     * Gets main_process
     *
     * @return \Swagger\Client\Model\Process
     */
    public function getMainProcess()
    {
        return $this->container['main_process'];
    }

    /**
     * Sets main_process
     *
     * @param \Swagger\Client\Model\Process $main_process main_process
     *
     * @return $this
     */
    public function setMainProcess($main_process)
    {
        $this->container['main_process'] = $main_process;

        return $this;
    }

    /**
     * Gets message_flows
     *
     * @return map[string,\Swagger\Client\Model\MessageFlow]
     */
    public function getMessageFlows()
    {
        return $this->container['message_flows'];
    }

    /**
     * Sets message_flows
     *
     * @param map[string,\Swagger\Client\Model\MessageFlow] $message_flows message_flows
     *
     * @return $this
     */
    public function setMessageFlows($message_flows)
    {
        $this->container['message_flows'] = $message_flows;

        return $this;
    }

    /**
     * Gets data_stores
     *
     * @return map[string,\Swagger\Client\Model\DataStore]
     */
    public function getDataStores()
    {
        return $this->container['data_stores'];
    }

    /**
     * Sets data_stores
     *
     * @param map[string,\Swagger\Client\Model\DataStore] $data_stores data_stores
     *
     * @return $this
     */
    public function setDataStores($data_stores)
    {
        $this->container['data_stores'] = $data_stores;

        return $this;
    }

    /**
     * Gets namespaces
     *
     * @return map[string,string]
     */
    public function getNamespaces()
    {
        return $this->container['namespaces'];
    }

    /**
     * Sets namespaces
     *
     * @param map[string,string] $namespaces namespaces
     *
     * @return $this
     */
    public function setNamespaces($namespaces)
    {
        $this->container['namespaces'] = $namespaces;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param  integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param  integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param  integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
