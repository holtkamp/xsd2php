<?php
namespace GoetasWebservices\Xsd\XsdToPhp\Php\PathGenerator;

use GoetasWebservices\Xsd\XsdToPhp\PathGenerator\PathGeneratorException;
use GoetasWebservices\Xsd\XsdToPhp\PathGenerator\Psr4PathGenerator as Psr4PathGeneratorBase;
use Zend\Code\Generator\ClassGenerator;

class Psr4PathGenerator extends Psr4PathGeneratorBase implements PathGenerator
{
    public function getPath(ClassGenerator $php)
    {
        foreach ($this->namespaces as $namespace => $dir) {
            ;
            if (strpos(trim($php->getNamespaceName()) . "\\", $namespace) === 0) {
                $d = strtr(substr($php->getNamespaceName(), strlen($namespace)), "\\", "/");
                $dir = rtrim($dir, "/") . "/" . $d;
                if (!is_dir($dir) && !mkdir($dir, 0777, true)) {
                    throw new PathGeneratorException("Can't create the '$dir' directory");
                }

                return rtrim($dir, "/") . "/" . $php->getName() . ".php";
            }
        }

        throw new PathGeneratorException("Can't find a defined location where save '{$php->getNamespaceName()}\\{$php->getName()}' object");
    }
}

