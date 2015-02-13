<?php
/**
 * This file is part of Vegas package
 *
 * @author Adrian Malik <adrian.malik@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VegasTest;

use Vegas\Db\Decorator\CollectionAbstract;
use Vegas\Media\Db\FileInterface;
use Vegas\Media\Uploader;

class File extends CollectionAbstract implements FileInterface
{
    public function getSource()
    {
        return 'vegas_files';
    }
}

class UploaderTest extends \PHPUnit_Framework_TestCase
{
    public function testSetFiles()
    {
        try {
            $files = array();

            $uploader = new Uploader(new File());

            $uploader->setFiles($files);
            $uploader->handle();
        } catch(\Exception $exception) {

            $this->assertInstanceOf('\Vegas\Media\Uploader\Exception\NoFilesException', $exception);
        }
    }

    public function testSetMimeTypes()
    {
        try {
            $files = array();

            $uploader = new Uploader(new File());

            $uploader->setMimeTypes(['image/jpeg', 'image/png']);
            $uploader->handle();
        } catch(\Exception $exception) {

            $this->assertInstanceOf('\Vegas\Media\Uploader\Exception\NoFilesException', $exception);
        }
    }

    public function testSetOriginalDestination()
    {
        try {
            $files = array();

            $uploader = new Uploader(new File());

            $uploader->setOriginalDestination('/origin');
            $uploader->handle();
        } catch(\Exception $exception) {

            $this->assertInstanceOf('\Vegas\Media\Uploader\Exception\NoFilesException', $exception);
        }
    }

    public function testSetMaxFileSize()
    {
        try {
            $files = array();

            $uploader = new Uploader(new File());

            $uploader->setMaxFileSize('10MB');
            $uploader->handle();
        } catch(\Exception $exception) {

            $this->assertInstanceOf('\Vegas\Media\Uploader\Exception\NoFilesException', $exception);
        }
    }

    public function testSetTempDestination()
    {
        try {
            $files = array();

            $uploader = new Uploader(new File());

            $uploader->setTempDestination('/tmp');
            $uploader->handle();
        } catch(\Exception $exception) {

            $this->assertInstanceOf('\Vegas\Media\Uploader\Exception\NoFilesException', $exception);
        }
    }

    public function testFilterMaxSize()
    {
        $method = new \ReflectionMethod('\Vegas\Media\Uploader', 'filterMaxSize');

        $method->setAccessible(true);

        $this->assertEquals($method->invoke(new Uploader(new File()), '100'), 100);
        $this->assertEquals($method->invoke(new Uploader(new File()), '1KB'), 1024 * 1);
        $this->assertEquals($method->invoke(new Uploader(new File()), '1MB'), 1024 * 1024 * 1);
        $this->assertEquals($method->invoke(new Uploader(new File()), '1GB'), 1024 * 1024 * 1024 * 1);
        $this->assertEquals($method->invoke(new Uploader(new File()), '1TB'), 1024 * 1024 * 1024 * 1024 * 1);
        $this->assertEquals($method->invoke(new Uploader(new File()), '1B'), 1);

        try {
            $method->invoke(new Uploader(new File()), '2FB');
        } catch (\Exception $exception) {
            $this->assertInstanceOf('\Vegas\Media\Uploader\Exception\InvalidMaxSizeException', $exception);
        }
    }

    public function testSetExtensions()
    {
        $inputExtensions = array('jpg', 'png');
        $uploader = new Uploader(new File());
        $uploader->setExtensions($inputExtensions);

        $reflectionProperty = new \ReflectionProperty('\Vegas\Media\Uploader', 'extensions');
        $reflectionProperty->setAccessible(true);
        $outputExtensions = $reflectionProperty->getValue($uploader);

        $this->assertTrue($inputExtensions == $outputExtensions);
    }
}