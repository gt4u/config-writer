<?php


namespace BONE\ConfigWriter;


use BONE\Config\Config;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Symfony\Component\VarExporter\VarExporter;
use League\Flysystem\FileExistsException;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;

class ConfigWriter
{

    private $configPath;

    private $configInstance;

    private $fileSystemInstance;

    /**
     * ConfigWriter constructor.
     * @param string $configPath
     * @param null $configInstance
     */
    public function __construct($configPath = '/', &$configInstance = null)
    {
        $this->configPath = $configPath;
        $this->configInstance = $configInstance ?: Config::getInstance($configPath);
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     * @throws ExceptionInterface
     */
    public function write($key, $value)
    {
        $this->configInstance->set($key, $value);
        $configFileName = self::getConfigFileName($key);
        $configFileContent = $this->getConfigFileContent($this->configInstance->get($configFileName));
        $configFilePath = $configFileName . ".php";
        $this->getFilesystemInstance()->put($configFilePath, $configFileContent);
        return $this->configInstance->get($key);
    }

    /**
     * @param $array
     * @return string
     * @throws ExceptionInterface
     */
    private function getConfigFileContent($array)
    {
        $arrayAsString = VarExporter::export($array);
        return "<?php" . PHP_EOL . PHP_EOL . "return " . $arrayAsString . ";";
    }

    /**
     * @param $key
     * @return string
     */
    private static function getConfigFileName($key)
    {
        return explode('.', $key)[0] ?? "undefined";
    }

    /**
     * @return Filesystem
     */
    private function getFilesystemInstance()
    {
        if (empty($this->fileSystemInstance)) {
            $this->fileSystemInstance = new Filesystem(new Local($this->configPath));
        }
        return $this->fileSystemInstance;
    }

}