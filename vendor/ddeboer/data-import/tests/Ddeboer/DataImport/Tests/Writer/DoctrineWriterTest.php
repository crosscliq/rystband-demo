<?php

namespace Ddeboer\DataImport\Tests\Writer;

use Ddeboer\DataImport\Writer\DoctrineWriter;
use Ddeboer\DataImport\Tests\Fixtures\TestEntity;

class DoctrineWriterTest extends \PHPUnit_Framework_TestCase
{
    public function testWriteItem()
    {
        $em = $this->getEntityManager();

        $em->expects($this->once())
                ->method('persist');

        $writer = new DoctrineWriter($em, 'DdeboerDataImport:TestEntity');

        $item = array(
            'firstProperty' => 'some value',
            'secondProperty'=> 'some other value'
        );
        $writer->writeItem($item);
    }

    public function testBatches()
    {
        $em = $this->getEntityManager();
        $em->expects($this->exactly(11))
            ->method('persist');

        $em->expects($this->exactly(4))
            ->method('flush');

        $writer = new DoctrineWriter($em, 'DdeboerDataImport:TestEntity');
        $writer->prepare();

        $writer->setBatchSize(3);
        $this->assertEquals(3, $writer->getBatchSize());

        $item = array(
            'firstProperty' => 'some value',
            'secondProperty'=> 'some other value'
        );

        for ($i = 0; $i < 11; $i++) {
            $writer->writeItem($item);
        }

        $writer->finish();
    }

    protected function getEntityManager()
    {
        $em = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->setMethods(array('getRepository', 'getClassMetadata', 'persist', 'flush', 'clear', 'getConnection'))
            ->disableOriginalConstructor()
            ->getMock();

        $repo = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $metadata = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
            ->setMethods(array('getName', 'getFieldNames', 'setFieldValue'))
            ->disableOriginalConstructor()
            ->getMock();

        $metadata->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('Ddeboer\DataImport\Tests\Fixtures\TestEntity'));

        $metadata->expects($this->any())
            ->method('getFieldNames')
            ->will($this->returnValue(array('firstProperty', 'secondProperty')));

        $configuration = $this->getMockBuilder('Doctrine\DBAL\Configuration')
            ->setMethods(array('getConnection'))
            ->disableOriginalConstructor()
            ->getMock();

        $connection = $this->getMockBuilder('Doctrine\DBAL\Connection')
            ->setMethods(array('getConfiguration', 'getDatabasePlatform', 'getTruncateTableSQL', 'executeQuery'))
            ->disableOriginalConstructor()
            ->getMock();

        $connection->expects($this->any())
            ->method('getConfiguration')
            ->will($this->returnValue($configuration));

        $connection->expects($this->any())
            ->method('getDatabasePlatform')
            ->will($this->returnSelf());

        $connection->expects($this->any())
            ->method('getTruncateTableSQL')
            ->will($this->returnValue('TRUNCATE SQL'));

        $connection->expects($this->any())
            ->method('executeQuery')
            ->with('TRUNCATE SQL');

        $em->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($repo));

        $em->expects($this->once())
            ->method('getClassMetadata')
            ->will($this->returnValue($metadata));

        $em->expects($this->any())
            ->method('getConnection')
            ->will($this->returnValue($connection));

        return $em;
    }
}
