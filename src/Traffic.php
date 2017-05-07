<?php namespace Danj\Traffic;

use Danj\Traffic\Data\GoogleMapsAPI;
use Danj\Traffic\Exceptions\InvalidDataSourceException;
use Danj\Traffic\Helpers\TimeHelper;

class Traffic
{
    /**
     * An instance of the Config class
     * @var \Danj\Traffic\Config
     */
    protected $config;

    /**
     * An instance of the data source
     * @var \Danj\Traffic\Data\DataSourceContract
     */
    protected $data;

    /**
     * An instance of the Output class
     * @var \Danj\Traffic\Output
     */
    protected $output;

    /**
     * An instance of the time helper class
     * @var \Danj\Traffic\Helpers\TimeHelper
     */
    protected $time;

    /**
     * Start point for the application. Gets the configuration, makes the API
     * call using this information, and then sends the traffic information
     * to the output handler.
     * @return void
     */
    public function run()
    {
        $this->config = $this->bindConfigClass();
        $this->data = $this->bindDataSource();
        $this->time = $this->bindTimeHelper();
        $this->output = $this->bindOutput();

        return $this->output->getOutputMessage();
    }

    /**
     * Binds the DataSourceContract to the implementation specified in the
     * configuration, and returns the instance.
     * @throws \Danj\Traffic\Exceptions\InvalidDataSourceException
     * @return \Danj\Traffic\Data\DataSourceContract
     */
    private function bindDataSource()
    {
        $class = $this->config->getDataSource();

        switch ($this->config->getDataSource()) {
            case "google":
                $class = GoogleMapsAPI::class;
                break;
            default:
                throw new InvalidDataSourceException($class);
        }

        if (class_exists($class)) {
            return new $class($this->config);
        }
    }

    /**
     * Binds the Time Helper class to the application
     * @return \Danj\Traffic\Helpers\TimeHelper
     */
    private function bindTimeHelper()
    {
        return new TimeHelper;
    }

    /**
     * Binds the Config class to the application
     * @return \Danj\Traffic\Config
     */
    private function bindConfigClass()
    {
        return new Config;
    }

    /**
     * Binds the Output class to the application and injects the required
     * dependencies
     * @return \Danj\Traffic\Output
     */
    private function bindOutput()
    {
        return new Output(
            $this->data,
            $this->time
        );
    }
}

