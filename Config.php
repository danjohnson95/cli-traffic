<?php namespace Danj\Traffic;

use Danj\Traffic\Exceptions\NoConfigSpecifiedException;
use Danj\Traffic\Exceptions\InvalidConfigException;

class Config
{
    /**
     * The path to the config file
     * @var string
     */
    protected $path = __DIR__."/../config.php";

    /**
     * Stores the decoded contents of the config file
     * @var object
     */
    protected $file;

    /**
     * The fields required in the config file
     * @var array
     */
    protected $required = [
        'data',
        'origin',
        'key'
    ];

    /**
     * Makes a new instance of the Config class
     * 'destination',
     * @throws \Danj\Traffic\Exceptions\NoConfigSpecifiedException
     * @return void
     */
    public function __construct()
    {
        if (!file_exists($this->path)) {
            throw new NoConfigSpecifiedException;
        }

        $file = require $this->path;

        $this->validateConfigFile($file);

        $this->file = $file;//json_decode($file);
    }

    /**
     * Ensures the config file is valid JSON and it contains all the required
     * fields.
     * @param string $contents
     * @return bool
     */
    protected function validateConfigFile($contents)
    {
        $config = $contents;//json_decode($contents);

        if ($config === null) {
            $this->throwInvalidConfig();
        }

        foreach ($this->required as $required) {
            if (!isset($config, $required)) {
                $this->throwInvalidConfig();
            }
        }
        return true;
    }

    /**
     * Throws an InvalidConfigException
     * @throws \Danj\Traffic\Exceptions\InvalidConfigException
     */
    protected function throwInvalidConfig()
    {
        throw new InvalidConfigException;
    }

    /**
     * Gets the data source we should use to grab traffic info
     * @return string
     */
    public function getDataSource()
    {
        return $this->file['data'];
    }

    /**
     * Gets the postcode of the origin of the journey
     * @return string
     */
    public function getOriginPostcode()
    {
        return $this->file['origin'];
    }

    /**
     * Gets the postcode of the destination of the journey
     * @return string
     */
    public function getDestinationPostcode()
    {
        return $this->file['destination'];
    }

    /**
     * Gets the API key to use for the specified data source
     * @return mixed
     */
    public function getAPIKey()
    {
        return $this->file['key'];
    }
}

